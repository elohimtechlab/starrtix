@extends('user-master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1><i class="fas fa-shopping-cart"></i> {{ __('My Orders') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('userDashboard') }}">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ __('My Orders') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Order History') }}</h4>
                            <div class="card-header-action">
                                <div class="dropdown">
                                    <a href="#" data-toggle="dropdown" class="btn btn-warning dropdown-toggle">{{ __('Filter') }}</a>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('userOrders') }}" class="dropdown-item">{{ __('All Orders') }}</a>
                                        <a href="{{ route('userOrders', ['status' => 'Pending']) }}" class="dropdown-item">{{ __('Pending') }}</a>
                                        <a href="{{ route('userOrders', ['status' => 'Complete']) }}" class="dropdown-item">{{ __('Completed') }}</a>
                                        <a href="{{ route('userOrders', ['status' => 'Cancel']) }}" class="dropdown-item">{{ __('Cancelled') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Event') }}</th>
                                            <th>{{ __('Order ID') }}</th>
                                            <th>{{ __('Ticket') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($orders->count() > 0)
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img alt="image" src="{{ $order->event->imagePath . $order->event->image }}" class="rounded-circle" width="50" data-toggle="tooltip" title="{{ $order->event->name }}">
                                                            <div class="ml-3">
                                                                <div class="font-weight-600">{{ $order->event->name }}</div>
                                                                <div class="text-muted small">
                                                                    <i class="fas fa-map-marker-alt"></i> {{ Str::limit($order->event->address, 30) }}
                                                                </div>
                                                                <div class="text-muted small">
                                                                    <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($order->event->start_time)->format('d M Y, h:i A') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="font-weight-600">#{{ $order->order_id }}</div>
                                                        <div class="text-muted small">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="font-weight-600">{{ $order->ticket->name }}</div>
                                                        <div class="text-muted small">Qty: {{ $order->quantity }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="font-weight-600">{{ $setting->currency ?? '$' }}{{ number_format($order->payment, 2) }}</div>
                                                        <div class="text-muted small">{{ $order->payment_type }}</div>
                                                    </td>
                                                    <td>
                                                        @if($order->order_status == 'Complete')
                                                            <div class="badge badge-success">{{ $order->order_status }}</div>
                                                        @elseif($order->order_status == 'Pending')
                                                            <div class="badge badge-warning">{{ $order->order_status }}</div>
                                                        @elseif($order->order_status == 'Cancel')
                                                            <div class="badge badge-danger">{{ $order->order_status }}</div>
                                                        @else
                                                            <div class="badge badge-secondary">{{ $order->order_status }}</div>
                                                        @endif
                                                        
                                                        @if(in_array($order->order_status, ['Pending', 'Complete']) && \Carbon\Carbon::parse($order->event->start_time)->isFuture())
                                                            <div class="text-muted small mt-1">
                                                                <i class="fas fa-clock"></i> 
                                                                <span class="countdown-simple" data-date="{{ $order->event->start_time }}">Loading...</span>
                                                            </div>
                                                        @elseif(\Carbon\Carbon::parse($order->event->start_time)->isPast())
                                                            <div class="text-muted small mt-1">
                                                                <i class="fas fa-check-circle"></i> Event Completed
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm">{{ __('Actions') }}</a>
                                                            <div class="dropdown-menu">
                                                                <a href="{{ route('ticket-details', $order->id) }}" class="dropdown-item has-icon">
                                                                    <i class="fas fa-eye"></i> {{ __('View Details') }}
                                                                </a>
                                                                @if(in_array($order->order_status, ['Pending', 'Complete']))
                                                                    <a href="{{ route('downloadTicket', $order->id) }}" class="dropdown-item has-icon">
                                                                        <i class="fas fa-download"></i> {{ __('Download Ticket') }}
                                                                    </a>
                                                                @endif
                                                                <a href="/starrtix/event/{{ $order->event->id }}/{{ Str::slug($order->event->name) }}" class="dropdown-item has-icon">
                                                                    <i class="fas fa-calendar-alt"></i> {{ __('Event Details') }}
                                                                </a>
                                                                <div class="dropdown-divider"></div>
                                                                <a href="#" class="dropdown-item has-icon" onclick="shareEvent('{{ $order->event->name }}', '/starrtix/event/{{ $order->event->id }}/{{ Str::slug($order->event->name) }}')">
                                                                    <i class="fas fa-share-alt"></i> {{ __('Share Event') }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center py-5">
                                                    <div class="empty-state">
                                                        <div class="empty-state-icon">
                                                            <i class="fas fa-shopping-cart"></i>
                                                        </div>
                                                        <div class="empty-state-text">
                                                            <h3>{{ __('No Orders Found') }}</h3>
                                                            <p class="lead">{{ __('You haven\'t made any orders yet. Start exploring events!') }}</p>
                                                            <a href="{{ url('/') }}" class="btn btn-primary mt-3">
                                                                <i class="fas fa-search"></i> {{ __('Browse Events') }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($orders->count() > 0)
                            <div class="card-footer">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="mb-2 mb-md-0">
                                        <small class="text-muted">
                                            Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
                                        </small>
                                    </div>
                                    <div class="pagination-wrapper">
                                        @if ($orders->hasPages())
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination pagination-sm mb-0">
                                                    {{-- Previous Page Link --}}
                                                    @if ($orders->onFirstPage())
                                                        <li class="page-item disabled">
                                                            <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ $orders->previousPageUrl() }}" rel="prev">
                                                                <i class="fas fa-chevron-left"></i>
                                                            </a>
                                                        </li>
                                                    @endif

                                                    {{-- Pagination Elements --}}
                                                    @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                                        @if ($page == $orders->currentPage())
                                                            <li class="page-item active">
                                                                <span class="page-link">{{ $page }}</span>
                                                            </li>
                                                        @else
                                                            <li class="page-item">
                                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach

                                                    {{-- Next Page Link --}}
                                                    @if ($orders->hasMorePages())
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ $orders->nextPageUrl() }}" rel="next">
                                                                <i class="fas fa-chevron-right"></i>
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li class="page-item disabled">
                                                            <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </nav>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
<script>
    // Share event function
    function shareEvent(eventName, eventUrl) {
        if (navigator.share) {
            navigator.share({
                title: eventName,
                url: window.location.origin + eventUrl
            }).then(() => {
                console.log('Thanks for sharing!');
            }).catch(console.error);
        } else {
            // Fallback for browsers that don't support Web Share API
            const url = window.location.origin + eventUrl;
            navigator.clipboard.writeText(url).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Link Copied!',
                    text: 'Event link has been copied to clipboard',
                    timer: 2000,
                    showConfirmButton: false
                });
            }).catch(() => {
                // If clipboard API fails, show the URL in a prompt
                prompt('Copy this link:', url);
            });
        }
    }

    // Simple countdown for event start times
    function updateCountdowns() {
        $('.countdown-simple').each(function() {
            const eventDate = new Date($(this).data('date')).getTime();
            const now = new Date().getTime();
            const distance = eventDate - now;

            if (distance > 0) {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

                if (days > 0) {
                    $(this).text(`${days}d ${hours}h ${minutes}m`);
                } else if (hours > 0) {
                    $(this).text(`${hours}h ${minutes}m`);
                } else {
                    $(this).text(`${minutes}m`);
                }
            } else {
                $(this).text('Event started');
            }
        });
    }

    // Initialize tooltips
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        
        // Update countdowns every minute
        updateCountdowns();
        setInterval(updateCountdowns, 60000);
    });
</script>
@endsection
