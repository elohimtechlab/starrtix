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
                                                                <a href="{{ route('userOrderTicket', $order->id) }}" class="dropdown-item has-icon">
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
                            <div class="card-footer text-right">
                                <nav class="d-inline-block">
                                    {{ $orders->appends(request()->query())->links() }}
                                </nav>
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
    display: flex;
    align-items: center;
    padding: 15px 20px;
    color: #666;
    text-decoration: none;
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
}

.sidebar-nav li a:hover,
.sidebar-nav li a.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-left-color: #4f46e5;
}

.sidebar-nav li a i {
    margin-right: 12px;
    width: 20px;
}

.main-content {
    flex: 1;
    margin-left: 280px;
    padding: 30px;
}

.content-header {
    margin-bottom: 30px;
}

.content-header h2 {
    color: #333;
    margin-bottom: 5px;
    font-weight: 600;
}

.content-header p {
    color: #666;
    margin: 0;
}

.orders-container {
    max-width: 1000px;
}

.order-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    overflow: hidden;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #eee;
}

.order-info h5 {
    margin: 0;
    color: #333;
    font-weight: 600;
}

.order-date {
    margin: 5px 0 0 0;
    color: #666;
    font-size: 14px;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-complete {
    background: #d4edda;
    color: #155724;
}

.status-cancel {
    background: #f8d7da;
    color: #721c24;
}

.order-body {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
}

.event-info {
    display: flex;
    gap: 15px;
    flex: 1;
}

.event-image img {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    object-fit: cover;
}

.event-details h6 {
    margin: 0 0 8px 0;
    color: #333;
    font-weight: 600;
}

.event-details p {
    margin: 4px 0;
    color: #666;
    font-size: 14px;
}

.event-details i {
    margin-right: 8px;
    color: #4f46e5;
}

.order-amount {
    text-align: right;
}

.order-amount h5 {
    margin: 0;
    color: #333;
    font-weight: 600;
}

.order-amount p {
    margin: 5px 0 0 0;
    color: #666;
    font-size: 14px;
}

.order-footer {
    padding: 15px 20px;
    background: #f8f9fa;
    border-top: 1px solid #eee;
}

.order-actions {
    display: flex;
    gap: 10px;
}

.btn {
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #4f46e5;
    color: white;
}

.btn-primary:hover {
    background: #4338ca;
}

.btn-success {
    background: #10b981;
    color: white;
}

.btn-success:hover {
    background: #059669;
}

.btn-info {
    background: #0ea5e9;
    color: white;
}

.btn-info:hover {
    background: #0284c7;
}

.event-countdown {
    margin-top: 15px;
    text-align: center;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 6px;
}

.countdown-label {
    font-size: 12px;
    color: #666;
    margin-bottom: 8px;
    text-transform: uppercase;
    font-weight: 500;
}

.countdown {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.countdown-item {
    text-align: center;
}

.countdown-number {
    display: block;
    font-size: 16px;
    font-weight: 600;
    color: #4f46e5;
}

.countdown-text {
    display: block;
    font-size: 10px;
    color: #666;
    text-transform: uppercase;
}

.event-status-past {
    margin-top: 15px;
    text-align: center;
    padding: 10px;
    background: #d4edda;
    color: #155724;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
}

.event-status-past i {
    margin-right: 8px;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.empty-icon {
    font-size: 64px;
    color: #ddd;
    margin-bottom: 20px;
}

.empty-state h4 {
    color: #333;
    margin-bottom: 10px;
}

.empty-state p {
    color: #666;
    margin-bottom: 30px;
}

.pagination-wrapper {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .main-content {
        margin-left: 0;
        padding: 20px;
    }
    
    .order-body {
        flex-direction: column;
        gap: 20px;
        align-items: flex-start;
    }
    
    .order-amount {
        text-align: left;
        width: 100%;
    }
    
    .countdown {
        gap: 10px;
    }
    
    .countdown-number {
        font-size: 14px;
    }
}
</style>

<script>
function shareEvent(eventName, eventUrl) {
    if (navigator.share) {
        navigator.share({
            title: eventName,
            text: 'Check out this amazing event!',
            url: eventUrl
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        const shareUrl = `https://twitter.com/intent/tweet?text=Check out this amazing event: ${encodeURIComponent(eventName)}&url=${encodeURIComponent(eventUrl)}`;
        window.open(shareUrl, '_blank');
    }
}

// Countdown timer functionality
document.addEventListener('DOMContentLoaded', function() {
    const countdowns = document.querySelectorAll('.countdown');
    
    countdowns.forEach(countdown => {
        const eventDate = new Date(countdown.dataset.date).getTime();
        
        const timer = setInterval(() => {
            const now = new Date().getTime();
            const distance = eventDate - now;
            
            if (distance < 0) {
                clearInterval(timer);
                countdown.parentElement.innerHTML = '<div class="event-status-past"><i class="fas fa-check-circle"></i> Event Started</div>';
                return;
            }
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            
            const daysElement = countdown.querySelector('.days');
            const hoursElement = countdown.querySelector('.hours');
            const minutesElement = countdown.querySelector('.minutes');
            
            if (daysElement) daysElement.textContent = days;
            if (hoursElement) hoursElement.textContent = hours;
            if (minutesElement) minutesElement.textContent = minutes;
        }, 1000);
    });
});
</script>

@endsection
