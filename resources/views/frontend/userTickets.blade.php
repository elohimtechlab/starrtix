@extends('user-master')

@section('content')
    @php
        $user = Auth::guard('appuser')->user();
        
        // Calculate order statistics (using existing data structure)
        $orders = App\Models\Order::where('customer_id', $user->id)->get();
        $pendingOrders = $orders->where('order_status', 'Pending')->count();
        $completedOrders = $orders->where('order_status', 'Complete')->count();
        $cancelOrders = $orders->where('order_status', 'Cancel')->count();
        
        // Get upcoming events for calendar (events where user has completed orders)
        $upcomingEvents = App\Models\Event::where('start_time', '>', now())
                                          ->where('status', 1)
                                          ->whereIn('id', function($query) use ($user) {
                                              $query->select('event_id')
                                                    ->from('orders')
                                                    ->where('customer_id', $user->id)
                                                    ->where('order_status', 'Complete');
                                          })
                                          ->orderBy('start_time', 'asc')
                                          ->take(10)
                                          ->get();
        
        // Prepare data for dashboard structure (using existing data only)
        $master = [
            'pending_order' => $pendingOrders,
            'complete_order' => $completedOrders,
            'cancel_order' => $cancelOrders,
            'total_order' => $pendingOrders + $completedOrders + $cancelOrders,
            'eventDate' => $upcomingEvents->map(function($event) {
                return [
                    'title' => $event->name,
                    'start' => $event->start_time,
                    'color' => '#6777ef'
                ];
            })->toArray()
        ];
    @endphp

    <!-- Enhanced Dashboard Styles -->
    <style>
        /* Modern Dashboard Enhancements */
        .modern-stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 15px;
            color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .modern-stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .modern-stats-card.success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .modern-stats-card.warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .modern-stats-card.info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stats-icon {
            font-size: 3rem;
            opacity: 0.8;
            margin-bottom: 1rem;
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stats-label {
            font-size: 1rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .quick-action-btn {
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            border-radius: 25px;
            padding: 8px 20px;
            margin: 5px;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.1);
        }

        .quick-action-btn:hover {
            background: rgba(255,255,255,0.3);
            color: white;
            transform: translateY(-2px);
        }

        .modern-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: box-shadow 0.3s ease;
        }

        .modern-card:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .section-title-modern {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 0;
        }

        .event-card {
            border-left: 4px solid #6777ef;
            transition: all 0.3s ease;
        }

        .event-card:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>

    <!-- Booking Success Modal -->
    @if(Session::has('booking_success'))
        @php
            $successOrder = null;
            if(Session::has('success_order_id')) {
                $successOrder = App\Models\Order::with(['event', 'customer', 'ticket'])
                                                ->find(Session::get('success_order_id'));
            }
        @endphp
        <div class="modal fade show" id="bookingSuccessModal" tabindex="-1" role="dialog" style="display: block; background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center p-5">
                        <!-- Success Icon -->
                        <div class="mb-4">
                            <div class="mx-auto" style="width: 64px; height: 64px; background-color: #fed7aa; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 32px; height: 32px; color: #ea580c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Success Message -->
                        <h2 class="h3 font-weight-bold text-dark mb-2">Success!</h2>
                        <p class="text-muted mb-1">Your order was successful. We've also sent a copy to</p>
                        <p class="text-muted mb-4">your email address <span style="color: #ea580c;">{{ $user->email }}</span></p>
                        
                        <p class="small text-muted mb-4">
                            If you do not receive your ticket from us, please email us at 
                            <span style="color: #ea580c;">support@{{ request()->getHost() }}</span>
                        </p>

                        <!-- Order Details -->
                        @if($successOrder)
                        <div class="bg-light rounded p-3 mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small font-weight-medium text-dark">Order ID:</span>
                                <span class="small text-dark">{{ $successOrder->order_id }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small font-weight-medium text-dark">Event:</span>
                                <span class="small text-dark">{{ $successOrder->event->name ?? 'Event' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small font-weight-medium text-dark">Quantity:</span>
                                <span class="small text-dark">{{ $successOrder->quantity ?? 1 }} {{ ($successOrder->quantity ?? 1) > 1 ? 'tickets' : 'ticket' }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="small font-weight-medium text-dark">Total:</span>
                                <span class="small font-weight-bold text-dark">${{ number_format($successOrder->payment ?? 0, 2) }}</span>
                            </div>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="mb-3">
                            <button onclick="downloadLatestTicket()" class="btn btn-primary btn-block" style="background-color: #ea580c; border-color: #ea580c;">
                                <i class="fas fa-download mr-2"></i>Download
                            </button>
                        </div>
                        
                        <div class="mb-4">
                            @if($successOrder && $successOrder->event)
                            <a href="{{ url('/events/' . $successOrder->event->id) }}" class="btn btn-outline-primary btn-block" style="color: #ea580c; border-color: #ea580c;">
                                Buy again
                            </a>
                            @else
                            <a href="{{ url('/all-events') }}" class="btn btn-outline-primary btn-block" style="color: #ea580c; border-color: #ea580c;">
                                Buy again
                            </a>
                            @endif
                        </div>

                        <!-- Footer Links -->
                        <div class="text-center">
                            <a href="{{ url('/') }}" class="small text-muted mr-3">Back to Home</a>
                            <span class="text-muted">|</span>
                            <button onclick="closeSuccessModal()" class="btn btn-link small text-muted p-0 ml-3">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <section class="section">
        <div class="section-header">
            <h1>{{ __('My Dashboard') }} </h1>
            <div class="section-header-button">
                <a href="{{ url('/all-events') }}" class="btn btn-primary quick-action-btn">
                    <i class="fas fa-ticket-alt mr-2"></i>{{ __('Browse Events') }}
                </a>
                <a href="{{ url('/my-orders') }}" class="btn btn-success quick-action-btn">
                    <i class="fas fa-list mr-2"></i>{{ __('My Orders') }}
                </a>
            </div>
        </div>

        <div class="section-body">
            <!-- Enhanced Statistics Cards -->
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card modern-stats-card mb-4">
                        <div class="card-body text-center">
                            <div class="stats-icon">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div class="stats-number">{{ $master['total_order'] }}</div>
                            <div class="stats-label">{{ __('Total Orders') }}</div>
                            <div class="mt-3">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <small>{{ __('Pending') }}</small>
                                        <div class="font-weight-bold">{{ $master['pending_order'] }}</div>
                                    </div>
                                    <div class="col-4">
                                        <small>{{ __('Completed') }}</small>
                                        <div class="font-weight-bold">{{ $master['complete_order'] }}</div>
                                    </div>
                                    <div class="col-4">
                                        <small>{{ __('Cancelled') }}</small>
                                        <div class="font-weight-bold">{{ $master['cancel_order'] }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card modern-stats-card success mb-4">
                        <div class="card-body text-center">
                            <div class="stats-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stats-number">{{ count($upcomingEvents) }}</div>
                            <div class="stats-label">{{ __('Upcoming Events') }}</div>
                            <div class="mt-3">
                                <button class="quick-action-btn btn-sm" onclick="location.href='{{ url('/my-orders') }}'">
                                    <i class="fas fa-eye mr-1"></i>{{ __('View All') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card modern-stats-card info mb-4">
                        <div class="card-body text-center">
                            <div class="stats-icon">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <div class="stats-number">{{ $master['total_order'] }}</div>
                            <div class="stats-label">{{ __('Total Tickets') }}</div>
                            <div class="mt-3">
                                <button class="quick-action-btn btn-sm" onclick="location.href='{{ url('/user-profile') }}'">
                                    <i class="fas fa-user mr-1"></i>{{ __('Profile') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Upcoming Events Card -->
                            <div class="card modern-card mb-4">
                                <div class="card-header pt-0 pb-0">
                                    <div class="row w-100">
                                        <div class="col-lg-8">
                                            <h2 class="section-title-modern">{{ __('My Upcoming Events') }}</h2>
                                        </div>
                                        <div class="col-lg-4 text-right mt-2">
                                            <a href="{{ url('/my-orders') }}">
                                                <button class="btn btn-sm btn-primary">{{ __('See all') }}</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if(count($upcomingEvents) > 0)
                                        @foreach($upcomingEvents->take(5) as $event)
                                            <div class="card event-card mb-3">
                                                <div class="card-body p-3">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-2">
                                                            @if($event->image)
                                                                <img src="{{ url('images/upload/' . $event->image) }}" 
                                                                     alt="{{ $event->name }}" 
                                                                     class="img-fluid rounded" 
                                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                                            @else
                                                                <div class="bg-primary rounded d-flex align-items-center justify-content-center" 
                                                                     style="width: 60px; height: 60px;">
                                                                    <i class="fas fa-calendar-alt text-white"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6 class="mb-1 font-weight-bold">{{ $event->name }}</h6>
                                                            <p class="text-muted mb-0 small">
                                                                <i class="fas fa-map-marker-alt mr-1"></i>{{ $event->address }}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-2 text-center">
                                                            <div class="text-primary font-weight-bold">
                                                                {{ \Carbon\Carbon::parse($event->start_time)->format('M d') }}
                                                            </div>
                                                            <small class="text-muted">
                                                                {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                                                            </small>
                                                        </div>
                                                        <div class="col-md-2 text-right">
                                                            <a href="{{ url('/events/' . $event->id) }}" 
                                                               class="btn btn-sm btn-outline-primary">
                                                                {{ __('View') }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-5">
                                            <div class="mb-3">
                                                <i class="fas fa-calendar-times fa-3x text-muted"></i>
                                            </div>
                                            <h5 class="text-muted">{{ __('No Upcoming Events') }}</h5>
                                            <p class="text-muted">{{ __('You don\'t have any upcoming events. Browse events to book tickets!') }}</p>
                                            <a href="{{ url('/all-events') }}" class="btn btn-primary">
                                                <i class="fas fa-search mr-2"></i>{{ __('Browse Events') }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <!-- Quick Actions Card -->
                            <div class="card modern-card mb-4">
                                <div class="card-header">
                                    <h4 class="section-title-modern">{{ __('Quick Actions') }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-flush">
                                        <a href="{{ url('/my-orders') }}" class="list-group-item list-group-item-action border-0 px-0">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-list text-white"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ __('My Orders') }}</h6>
                                                    <small class="text-muted">{{ __('View all your orders') }}</small>
                                                </div>
                                            </div>
                                        </a>
                                        
                                        <a href="{{ url('/user-profile') }}" class="list-group-item list-group-item-action border-0 px-0">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ __('My Profile') }}</h6>
                                                    <small class="text-muted">{{ __('Update your information') }}</small>
                                                </div>
                                            </div>
                                        </a>
                                        
                                        <a href="{{ url('/user-change-password') }}" class="list-group-item list-group-item-action border-0 px-0">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-lock text-white"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ __('Change Password') }}</h6>
                                                    <small class="text-muted">{{ __('Update your password') }}</small>
                                                </div>
                                            </div>
                                        </a>
                                        
                                        <a href="{{ url('/all-events') }}" class="list-group-item list-group-item-action border-0 px-0">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <div class="bg-info rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-ticket-alt text-white"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ __('Browse Events') }}</h6>
                                                    <small class="text-muted">{{ __('Find new events to attend') }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Account Summary Card -->
                            <div class="card modern-card">
                                <div class="card-header">
                                    <h4 class="section-title-modern">{{ __('Account Summary') }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div class="border-right">
                                                <div class="h4 font-weight-bold text-primary">{{ count($upcomingEvents) }}</div>
                                                <small class="text-muted">{{ __('Upcoming Events') }}</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="h4 font-weight-bold text-success">{{ $master['complete_order'] }}</div>
                                            <small class="text-muted">{{ __('Completed Orders') }}</small>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="text-center">
                                        <small class="text-muted">{{ __('Member since') }} {{ \Carbon\Carbon::parse($user->created_at)->format('M Y') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Share Modal -->
    <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareModalLabel">{{ __('Share Ticket') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <h6 id="shareEventName" class="font-weight-bold"></h6>
                        <p class="text-muted small">{{ __('Share this event with your friends') }}</p>
                    </div>
                    
                    <div class="row text-center">
                        <div class="col-3">
                            <button class="btn btn-outline-primary btn-block" onclick="shareOnFacebook()">
                                <i class="fab fa-facebook-f"></i>
                                <small class="d-block">Facebook</small>
                            </button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-outline-info btn-block" onclick="shareOnTwitter()">
                                <i class="fab fa-twitter"></i>
                                <small class="d-block">Twitter</small>
                            </button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-outline-success btn-block" onclick="shareOnWhatsApp()">
                                <i class="fab fa-whatsapp"></i>
                                <small class="d-block">WhatsApp</small>
                            </button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-outline-secondary btn-block" onclick="copyEventLink()">
                                <i class="fas fa-link"></i>
                                <small class="d-block">Copy Link</small>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .ticket-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .ticket-card .btn {
            transition: all 0.3s ease;
        }
        
        .ticket-card .btn:hover {
            transform: translateY(-1px);
        }
    </style>

    <script>
        // Success modal functions
        function downloadLatestTicket() {
            @if(Session::has('success_order_id'))
                window.open('{{ url("/downloadTicket/" . Session::get("success_order_id")) }}', '_blank');
            @endif
        }

        function closeSuccessModal() {
            document.getElementById('bookingSuccessModal').style.display = 'none';
        }

        // Share ticket function
        function shareTicket(ticketId, eventName, eventUrl) {
            currentShareData = {
                ticketId: ticketId,
                eventName: eventName,
                eventUrl: eventUrl
            };
            
            document.getElementById('shareEventName').textContent = eventName;
            $('#shareModal').modal('show');
        }

        // Social sharing functions
        function shareOnFacebook() {
            const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentShareData.eventUrl)}`;
            window.open(url, '_blank', 'width=600,height=400');
        }

        function shareOnTwitter() {
            const text = `Check out this amazing event: ${currentShareData.eventName}`;
            const url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(currentShareData.eventUrl)}`;
            window.open(url, '_blank', 'width=600,height=400');
        }

        function shareOnWhatsApp() {
            const text = `Check out this amazing event: ${currentShareData.eventName} ${currentShareData.eventUrl}`;
            const url = `https://wa.me/?text=${encodeURIComponent(text)}`;
            window.open(url, '_blank');
        }

        function copyEventLink() {
            navigator.clipboard.writeText(currentShareData.eventUrl).then(function() {
                // Show success message
                const button = event.target.closest('button');
                const originalHTML = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check"></i><small class="d-block">Copied!</small>';
                button.classList.remove('btn-outline-secondary');
                button.classList.add('btn-success');
                
                setTimeout(() => {
                    button.innerHTML = originalHTML;
                    button.classList.remove('btn-success');
                    button.classList.add('btn-outline-secondary');
                }, 2000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = currentShareData.eventUrl;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                alert('Link copied to clipboard!');
            });
        }

        // Auto-hide success modal after 10 seconds
        @if(Session::has('booking_success'))
            setTimeout(function() {
                closeSuccessModal();
            }, 10000);
        @endif
    </script>
@endsection
