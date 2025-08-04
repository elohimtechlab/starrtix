@extends('frontend.master', ['activePage' => 'dashboard'])
@section('title', __('Dashboard'))
@section('content')
    @php
        $user = Auth::guard('appuser')->user();
        $totalTickets = $ticket['upcoming']->total() + $ticket['past']->total();
        $upcomingTickets = $ticket['upcoming']->total();
        $pastTickets = $ticket['past']->total();
        $likedEventsCount = $likedEvents->count();
        
        // Calculate order statistics
        $pendingOrders = 0;
        $completedOrders = 0;
        $cancelOrders = 0;
        
        foreach($ticket['upcoming'] as $order) {
            if($order->order_status == 'Pending') $pendingOrders++;
            if($order->order_status == 'Complete') $completedOrders++;
        }
        
        foreach($ticket['past'] as $order) {
            if($order->order_status == 'Cancel') $cancelOrders++;
            if($order->order_status == 'Complete') $completedOrders++;
        }
        
        $totalOrders = $pendingOrders + $completedOrders + $cancelOrders;
    @endphp

<style>
.user-dashboard {
    background-color: #f8f9fa;
    min-height: 100vh;
}

.dashboard-sidebar {
    background: white;
    width: 250px;
    min-height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    padding: 20px 0;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}

.dashboard-content {
    margin-left: 250px;
    padding: 20px;
}

.sidebar-nav {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-nav li {
    margin: 0;
}

.sidebar-nav a {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: #666;
    text-decoration: none;
    transition: all 0.3s;
}

.sidebar-nav a:hover,
.sidebar-nav a.active {
    background-color: #007bff;
    color: white;
    text-decoration: none;
}

.sidebar-nav i {
    margin-right: 10px;
    width: 20px;
    text-align: center;
}

.stats-cards {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    flex: 1;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.stat-card h3 {
    margin: 0;
    font-size: 24px;
    color: #333;
}

.stat-card p {
    margin: 5px 0 0 0;
    color: #666;
    font-size: 14px;
}

.main-cards {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
}

.main-card {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    padding: 40px 30px;
    border-radius: 12px;
    flex: 1;
    position: relative;
    overflow: hidden;
}

.main-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 100px;
    height: 100px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
}

.main-card h2 {
    font-size: 48px;
    margin: 0;
    font-weight: bold;
}

.main-card p {
    margin: 10px 0 0 0;
    font-size: 18px;
    opacity: 0.9;
}

.upcoming-events {
    background: white;
    border-radius: 8px;
    padding: 25px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.upcoming-events h3 {
    margin: 0 0 20px 0;
    color: #333;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.see-all-btn {
    background: #007bff;
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 500;
}

.see-all-btn:hover {
    background: #0056b3;
    color: white;
    text-decoration: none;
}

.event-item {
    display: flex;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.event-item:last-child {
    border-bottom: none;
}

.event-image {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
    margin-right: 15px;
}

.event-details {
    flex: 1;
}

.event-title {
    font-weight: 600;
    color: #333;
    margin: 0 0 5px 0;
    font-size: 16px;
}

.event-location {
    color: #666;
    font-size: 14px;
    margin: 0;
}

.book-btn {
    background: #007bff;
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

.book-btn:hover {
    background: #0056b3;
    color: white;
    text-decoration: none;
}

@media (max-width: 768px) {
    .dashboard-sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s;
    }
    
    .dashboard-content {
        margin-left: 0;
    }
    
    .stats-cards {
        flex-direction: column;
    }
    
    .main-cards {
        flex-direction: column;
    }
}
</style>

<div class="user-dashboard">
    <!-- Sidebar Navigation -->
    <div class="dashboard-sidebar">
        <div style="padding: 0 20px 20px 20px; border-bottom: 1px solid #eee; margin-bottom: 20px;">
            <img src="{{ asset('images/logo.png') }}" alt="Starrtix" style="height: 40px;">
        </div>
        
        <ul class="sidebar-nav">
            <li><a href="{{ url('/user-tickets') }}" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="#"><i class="fas fa-shopping-cart"></i> My orders</a></li>
            <li><a href="#"><i class="fas fa-ticket-alt"></i> My tickets</a></li>
            <li><a href="#"><i class="fas fa-calendar-alt"></i> My events</a></li>
            <li><a href="#"><i class="fas fa-user"></i> My profile</a></li>
            <li><a href="#"><i class="fas fa-wallet"></i> My wallet</a></li>
            <li><a href="#"><i class="fas fa-key"></i> Change password</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="dashboard-content">
        <!-- Order Statistics -->
        <div class="stats-cards">
            <div class="stat-card">
                <h3>{{ $pendingOrders }}</h3>
                <p>Pending</p>
            </div>
            <div class="stat-card">
                <h3>{{ $completedOrders }}</h3>
                <p>Completed</p>
            </div>
            <div class="stat-card">
                <h3>{{ $cancelOrders }}</h3>
                <p>Cancel</p>
            </div>
            <div class="stat-card">
                <h3>{{ $totalOrders }}</h3>
                <p>Total Orders</p>
            </div>
        </div>

        <!-- Main Cards -->
        <div class="main-cards">
            <div class="main-card">
                <h2>{{ $totalTickets }}</h2>
                <p>My book tickets</p>
            </div>
            <div class="main-card">
                <h2>{{ $likedEventsCount }}</h2>
                <p>Events</p>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="upcoming-events">
            <h3>
                <span><i class="fas fa-calendar-alt" style="color: #007bff; margin-right: 10px;"></i>Upcoming Event</span>
                <a href="#" class="see-all-btn">See all</a>
            </h3>
            
            @if($ticket['upcoming']->count() > 0)
                @foreach($ticket['upcoming']->take(5) as $item)
                    <div class="event-item">
                        <img src="{{ url('images/upload/' . $item->event->image) }}" 
                             alt="{{ $item->event->name }}" 
                             class="event-image">
                        <div class="event-details">
                            <h4 class="event-title">{{ $item->event->name }}</h4>
                            <p class="event-location">{{ $item->event->address }}</p>
                        </div>
                        <a href="{{ url('/event/' . $item->event->id . '/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->event->name))) }}" class="book-btn">Book event</a>
                    </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 40px; color: #666;">
                    <i class="fas fa-calendar-times" style="font-size: 48px; margin-bottom: 20px; opacity: 0.3;"></i>
                    <p>No upcoming events found</p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function() {
    // Mobile sidebar toggle (if needed)
    $('.mobile-toggle').on('click', function() {
        $('.dashboard-sidebar').toggleClass('show');
    });
});
</script>
@endsection
