@extends('user-master')

@section('content')
    @php
        $user = Auth::guard('appuser')->user();
    @endphp

    <!-- Enhanced Dashboard Styles -->
    <style>
        /* Modern Dashboard Enhancements */
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

        .filter-tabs {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 2rem;
        }

        .filter-tab {
            padding: 0.75rem 1.5rem;
            border: none;
            background: none;
            color: #6c757d;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .filter-tab.active {
            color: #007bff;
            border-bottom-color: #007bff;
        }

        .filter-tab:hover {
            color: #007bff;
        }
    </style>

    <section class="section">
        <div class="section-header">
            <h1>{{ __('My Tickets') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('/user-tickets') }}">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item active">{{ __('My Tickets') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card modern-card">
                        <div class="card-header">
                            <div class="row w-100">
                                <div class="col-lg-8">
                                    <p class="text-muted mb-0">{{ __('View, download, and share all your event tickets') }}</p>
                                </div>
                                <div class="col-lg-4 text-right mt-2">
                                    <a href="{{ url('/my-orders') }}" class="btn btn-sm btn-outline-primary mr-2">
                                        <i class="fas fa-list mr-1"></i>{{ __('My Orders') }}
                                    </a>
                                    <a href="{{ url('/all-events') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus mr-1"></i>{{ __('Buy Tickets') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Tabs -->
                        <div class="card-body pb-0">
                            <div class="filter-tabs">
                                <button class="filter-tab active" onclick="filterTickets('all')" id="tab-all">
                                    <i class="fas fa-ticket-alt mr-2"></i>{{ __('All Tickets') }}
                                </button>
                                <button class="filter-tab" onclick="filterTickets('upcoming')" id="tab-upcoming">
                                    <i class="fas fa-calendar-plus mr-2"></i>{{ __('Upcoming') }}
                                </button>
                                <button class="filter-tab" onclick="filterTickets('past')" id="tab-past">
                                    <i class="fas fa-history mr-2"></i>{{ __('Past Events') }}
                                </button>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            @php
                                // Get all user's tickets (using existing data structure)
                                $allTickets = App\Models\Order::with(['event', 'ticket'])
                                    ->where('customer_id', $user->id)
                                    ->where('order_status', 'Complete')
                                    ->orderBy('created_at', 'desc')
                                    ->get();

                                // Separate upcoming and past tickets
                                $upcomingTickets = $allTickets->filter(function($ticket) {
                                    return $ticket->event && \Carbon\Carbon::parse($ticket->event->start_time)->isFuture();
                                });

                                $pastTickets = $allTickets->filter(function($ticket) {
                                    return $ticket->event && \Carbon\Carbon::parse($ticket->event->start_time)->isPast();
                                });
                            @endphp

                            @if(count($allTickets) > 0)
                                <!-- All Tickets -->
                                <div id="tickets-all" class="tickets-container">
                                    <div class="row">
                                        @foreach($allTickets as $ticket)
                                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                                <div class="card ticket-card h-100" style="border: 1px solid #e3e6f0; border-radius: 10px; transition: all 0.3s ease;">
                                                    <div class="card-body p-3">
                                                        <!-- Event Image -->
                                                        <div class="text-center mb-3">
                                                            @if($ticket->event && $ticket->event->image)
                                                                <img src="{{ url('images/upload/' . $ticket->event->image) }}" 
                                                                     alt="{{ $ticket->event->name }}" 
                                                                     class="img-fluid rounded" 
                                                                     style="width: 100%; height: 120px; object-fit: cover;">
                                                            @else
                                                                <div class="bg-primary rounded d-flex align-items-center justify-content-center" 
                                                                     style="width: 100%; height: 120px;">
                                                                    <i class="fas fa-calendar-alt fa-3x text-white"></i>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <!-- Event Status Badge -->
                                                        <div class="text-center mb-2">
                                                            @if($ticket->event && \Carbon\Carbon::parse($ticket->event->start_time)->isFuture())
                                                                <span class="badge badge-success">{{ __('Upcoming') }}</span>
                                                            @else
                                                                <span class="badge badge-secondary">{{ __('Past Event') }}</span>
                                                            @endif
                                                        </div>

                                                        <!-- Event Details -->
                                                        <div class="mb-3">
                                                            <h6 class="font-weight-bold mb-2" style="font-size: 14px; line-height: 1.3;">
                                                                {{ $ticket->event ? $ticket->event->name : 'Event' }}
                                                            </h6>
                                                            
                                                            <div class="text-muted small mb-1">
                                                                <i class="fas fa-ticket-alt mr-1"></i>
                                                                {{ $ticket->ticket ? $ticket->ticket->name : 'Ticket' }}
                                                            </div>
                                                            
                                                            @if($ticket->event)
                                                                <div class="text-muted small mb-1">
                                                                    <i class="fas fa-calendar mr-1"></i>
                                                                    {{ \Carbon\Carbon::parse($ticket->event->start_time)->format('M d, Y') }}
                                                                </div>
                                                                
                                                                <div class="text-muted small mb-1">
                                                                    <i class="fas fa-clock mr-1"></i>
                                                                    {{ \Carbon\Carbon::parse($ticket->event->start_time)->format('h:i A') }}
                                                                </div>
                                                                
                                                                @if($ticket->event->address)
                                                                    <div class="text-muted small">
                                                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                                                        {{ Str::limit($ticket->event->address, 30) }}
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>

                                                        <!-- Order Info -->
                                                        <div class="mb-3 pb-2" style="border-bottom: 1px solid #eee;">
                                                            <div class="row text-center">
                                                                <div class="col-6">
                                                                    <small class="text-muted d-block">Order ID</small>
                                                                    <span class="font-weight-bold small">#{{ $ticket->order_id }}</span>
                                                                </div>
                                                                <div class="col-6">
                                                                    <small class="text-muted d-block">Status</small>
                                                                    <span class="badge badge-success small">{{ $ticket->order_status }}</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Action Buttons -->
                                                        <div class="text-center">
                                                            <div class="btn-group-vertical w-100" role="group">
                                                                <!-- Ticket Details Button -->
                                                                <a href="{{ route('ticket-details', $ticket->id) }}" 
                                                                   class="btn btn-info btn-sm mb-2" 
                                                                   style="border-radius: 20px;">
                                                                    <i class="fas fa-eye mr-1"></i>{{ __('Ticket Details') }}
                                                                </a>
                                                                
                                                                <!-- Download Button -->
                                                                <a href="{{ route('downloadTicket', $ticket->id) }}" 
                                                                   class="btn btn-primary btn-sm mb-2" 
                                                                   style="border-radius: 20px;">
                                                                    <i class="fas fa-download mr-1"></i>{{ __('Download') }}
                                                                </a>
                                                                
                                                                <!-- Share Button -->
                                                                <button class="btn btn-outline-primary btn-sm" 
                                                                        onclick="shareTicket('{{ $ticket->id }}', '{{ $ticket->event ? $ticket->event->name : 'Event' }}', '{{ $ticket->event ? url('/events_details/' . $ticket->event->id) : '#' }}')"
                                                                        style="border-radius: 20px;">
                                                                    <i class="fas fa-share-alt mr-1"></i>{{ __('Share') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Upcoming Tickets -->
                                <div id="tickets-upcoming" class="tickets-container" style="display: none;">
                                    <div class="row">
                                        @foreach($upcomingTickets as $ticket)
                                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                                <div class="card ticket-card h-100" style="border: 1px solid #e3e6f0; border-radius: 10px; transition: all 0.3s ease;">
                                                    <div class="card-body p-3">
                                                        <!-- Event Image -->
                                                        <div class="text-center mb-3">
                                                            @if($ticket->event && $ticket->event->image)
                                                                <img src="{{ url('images/upload/' . $ticket->event->image) }}" 
                                                                     alt="{{ $ticket->event->name }}" 
                                                                     class="img-fluid rounded" 
                                                                     style="width: 100%; height: 120px; object-fit: cover;">
                                                            @else
                                                                <div class="bg-primary rounded d-flex align-items-center justify-content-center" 
                                                                     style="width: 100%; height: 120px;">
                                                                    <i class="fas fa-calendar-alt fa-3x text-white"></i>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <!-- Event Status Badge -->
                                                        <div class="text-center mb-2">
                                                            <span class="badge badge-success">{{ __('Upcoming') }}</span>
                                                        </div>

                                                        <!-- Event Details -->
                                                        <div class="mb-3">
                                                            <h6 class="font-weight-bold mb-2" style="font-size: 14px; line-height: 1.3;">
                                                                {{ $ticket->event ? $ticket->event->name : 'Event' }}
                                                            </h6>
                                                            
                                                            <div class="text-muted small mb-1">
                                                                <i class="fas fa-ticket-alt mr-1"></i>
                                                                {{ $ticket->ticket ? $ticket->ticket->name : 'Ticket' }}
                                                            </div>
                                                            
                                                            @if($ticket->event)
                                                                <div class="text-muted small mb-1">
                                                                    <i class="fas fa-calendar mr-1"></i>
                                                                    {{ \Carbon\Carbon::parse($ticket->event->start_time)->format('M d, Y') }}
                                                                </div>
                                                                
                                                                <div class="text-muted small mb-1">
                                                                    <i class="fas fa-clock mr-1"></i>
                                                                    {{ \Carbon\Carbon::parse($ticket->event->start_time)->format('h:i A') }}
                                                                </div>
                                                                
                                                                @if($ticket->event->address)
                                                                    <div class="text-muted small">
                                                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                                                        {{ Str::limit($ticket->event->address, 30) }}
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>

                                                        <!-- Order Info -->
                                                        <div class="mb-3 pb-2" style="border-bottom: 1px solid #eee;">
                                                            <div class="row text-center">
                                                                <div class="col-6">
                                                                    <small class="text-muted d-block">Order ID</small>
                                                                    <span class="font-weight-bold small">#{{ $ticket->order_id }}</span>
                                                                </div>
                                                                <div class="col-6">
                                                                    <small class="text-muted d-block">Status</small>
                                                                    <span class="badge badge-success small">{{ $ticket->order_status }}</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Action Buttons -->
                                                        <div class="text-center">
                                                            <div class="btn-group-vertical w-100" role="group">
                                                                <!-- Download Button -->
                                                                <a href="{{ route('downloadTicket', $ticket->id) }}" 
                                                                   class="btn btn-primary btn-sm mb-2" 
                                                                   style="border-radius: 20px;">
                                                                    <i class="fas fa-download mr-1"></i>{{ __('Download') }}
                                                                </a>
                                                                
                                                                <!-- Share Button -->
                                                                <button class="btn btn-outline-primary btn-sm" 
                                                                        onclick="shareTicket('{{ $ticket->id }}', '{{ $ticket->event ? $ticket->event->name : 'Event' }}', '{{ $ticket->event ? url('/events_details/' . $ticket->event->id) : '#' }}')"
                                                                        style="border-radius: 20px;">
                                                                    <i class="fas fa-share-alt mr-1"></i>{{ __('Share') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if(count($upcomingTickets) == 0)
                                        <div class="text-center py-5">
                                            <div class="mb-3">
                                                <i class="fas fa-calendar-plus fa-4x text-muted"></i>
                                            </div>
                                            <h5 class="text-muted">{{ __('No Upcoming Events') }}</h5>
                                            <p class="text-muted">{{ __('You don\'t have any upcoming events.') }}</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Past Tickets -->
                                <div id="tickets-past" class="tickets-container" style="display: none;">
                                    <div class="row">
                                        @foreach($pastTickets as $ticket)
                                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                                <div class="card ticket-card h-100" style="border: 1px solid #e3e6f0; border-radius: 10px; transition: all 0.3s ease;">
                                                    <div class="card-body p-3">
                                                        <!-- Event Image -->
                                                        <div class="text-center mb-3">
                                                            @if($ticket->event && $ticket->event->image)
                                                                <img src="{{ url('images/upload/' . $ticket->event->image) }}" 
                                                                     alt="{{ $ticket->event->name }}" 
                                                                     class="img-fluid rounded" 
                                                                     style="width: 100%; height: 120px; object-fit: cover;">
                                                            @else
                                                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                                                     style="width: 100%; height: 120px;">
                                                                    <i class="fas fa-calendar-alt fa-3x text-white"></i>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <!-- Event Status Badge -->
                                                        <div class="text-center mb-2">
                                                            <span class="badge badge-secondary">{{ __('Past Event') }}</span>
                                                        </div>

                                                        <!-- Event Details -->
                                                        <div class="mb-3">
                                                            <h6 class="font-weight-bold mb-2" style="font-size: 14px; line-height: 1.3;">
                                                                {{ $ticket->event ? $ticket->event->name : 'Event' }}
                                                            </h6>
                                                            
                                                            <div class="text-muted small mb-1">
                                                                <i class="fas fa-ticket-alt mr-1"></i>
                                                                {{ $ticket->ticket ? $ticket->ticket->name : 'Ticket' }}
                                                            </div>
                                                            
                                                            @if($ticket->event)
                                                                <div class="text-muted small mb-1">
                                                                    <i class="fas fa-calendar mr-1"></i>
                                                                    {{ \Carbon\Carbon::parse($ticket->event->start_time)->format('M d, Y') }}
                                                                </div>
                                                                
                                                                <div class="text-muted small mb-1">
                                                                    <i class="fas fa-clock mr-1"></i>
                                                                    {{ \Carbon\Carbon::parse($ticket->event->start_time)->format('h:i A') }}
                                                                </div>
                                                                
                                                                @if($ticket->event->address)
                                                                    <div class="text-muted small">
                                                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                                                        {{ Str::limit($ticket->event->address, 30) }}
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>

                                                        <!-- Order Info -->
                                                        <div class="mb-3 pb-2" style="border-bottom: 1px solid #eee;">
                                                            <div class="row text-center">
                                                                <div class="col-6">
                                                                    <small class="text-muted d-block">Order ID</small>
                                                                    <span class="font-weight-bold small">#{{ $ticket->order_id }}</span>
                                                                </div>
                                                                <div class="col-6">
                                                                    <small class="text-muted d-block">Status</small>
                                                                    <span class="badge badge-success small">{{ $ticket->order_status }}</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Action Buttons -->
                                                        <div class="text-center">
                                                            <div class="btn-group-vertical w-100" role="group">
                                                                <!-- Download Button -->
                                                                <a href="{{ route('downloadTicket', $ticket->id) }}" 
                                                                   class="btn btn-primary btn-sm mb-2" 
                                                                   style="border-radius: 20px;">
                                                                    <i class="fas fa-download mr-1"></i>{{ __('Download') }}
                                                                </a>
                                                                
                                                                <!-- Share Button -->
                                                                <button class="btn btn-outline-primary btn-sm" 
                                                                        onclick="shareTicket('{{ $ticket->id }}', '{{ $ticket->event ? $ticket->event->name : 'Event' }}', '{{ $ticket->event ? url('/events_details/' . $ticket->event->id) : '#' }}')"
                                                                        style="border-radius: 20px;">
                                                                    <i class="fas fa-share-alt mr-1"></i>{{ __('Share') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if(count($pastTickets) == 0)
                                        <div class="text-center py-5">
                                            <div class="mb-3">
                                                <i class="fas fa-history fa-4x text-muted"></i>
                                            </div>
                                            <h5 class="text-muted">{{ __('No Past Events') }}</h5>
                                            <p class="text-muted">{{ __('You don\'t have any past events.') }}</p>
                                        </div>
                                    @endif
                                </div>

                            @else
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-ticket-alt fa-4x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted">{{ __('No Tickets Yet') }}</h5>
                                    <p class="text-muted">{{ __('You haven\'t purchased any tickets yet. Browse events to get started!') }}</p>
                                    <a href="{{ url('/all-events') }}" class="btn btn-primary">
                                        <i class="fas fa-search mr-2"></i>{{ __('Browse Events') }}
                                    </a>
                                </div>
                            @endif
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

    <script>
        let currentShareData = {};

        // Filter tickets function
        function filterTickets(type) {
            // Hide all containers
            document.querySelectorAll('.tickets-container').forEach(container => {
                container.style.display = 'none';
            });

            // Remove active class from all tabs
            document.querySelectorAll('.filter-tab').forEach(tab => {
                tab.classList.remove('active');
            });

            // Show selected container and activate tab
            document.getElementById('tickets-' + type).style.display = 'block';
            document.getElementById('tab-' + type).classList.add('active');
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
    </script>
@endsection
