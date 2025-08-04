@extends('frontend.master', ['activePage' => 'ticket'])
@section('title', __('Dashboard'))
@section('content')
    @php
        $user = Auth::guard('appuser')->user();
        $totalTickets = count($ticket['upcoming']) + count($ticket['past']);
        $upcomingTickets = count($ticket['upcoming']);
        $pastTickets = count($ticket['past']);
    @endphp

    <section class="section">
        <div class="section-header">
            <h1>{{ __('My Dashboard') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/') }}">{{ __('Home') }}</a></div>
                <div class="breadcrumb-item">{{ __('Dashboard') }}</div>
            </div>
        </div>

        <div class="section-body">
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-stats">
                            <div class="card-stats-title">{{ __('Ticket Statistics') }}</div>
                            <div class="card-stats-items">
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ $upcomingTickets }}</div>
                                    <div class="card-stats-item-label">{{ __('Upcoming') }}</div>
                                </div>
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ $pastTickets }}</div>
                                    <div class="card-stats-item-label">{{ __('Past') }}</div>
                                </div>
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ count($likedEvents) }}</div>
                                    <div class="card-stats-item-label">{{ __('Liked') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Total Tickets') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalTickets }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card card-hero">
                        <div class="card-header">
                            <div class="card-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <h4>{{ count($likedEvents) }}</h4>
                            <div class="card-description">{{ __('Liked Events') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card card-hero">
                        <div class="card-header">
                            <div class="card-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4>{{ count($userFollowing) }}</h4>
                            <div class="card-description">{{ __('Following') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-xl-9">
                    <!-- User Profile Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>{{ __('Profile Information') }}</h4>
                            <div class="card-header-action">
                                <a href="{{ url('/update_profile') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> {{ __('Edit Profile') }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <img src="{{ asset('images/upload/' . $user->image) }}" alt="{{ $user->name }}"
                                        class="rounded-circle" width="100" height="100" style="object-fit: cover;">
                                </div>
                                <div class="col-md-9">
                                    <h5>{{ $user->name }}</h5>
                                    <p class="text-muted">{{ $user->email }}</p>
                                    @if($user->bio)
                                        <p>{{ $user->bio }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Events -->
                    <div class="card mb-4">
                        <div class="card-header pt-0 pb-0">
                            <div class="row w-100">
                                <div class="col-lg-8">
                                    <h2 class="section-title">{{ __('Upcoming Events') }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @forelse ($ticket['upcoming'] as $item)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img src="{{ url('images/upload/' . $item->event->image) }}" alt=""
                                                    class="img-fluid rounded" style="height: 80px; width: 80px; object-fit: cover;">
                                            </div>
                                            <div class="col-md-10">
                                                <h5>{{ $item->event->name }}</h5>
                                                <div class="text-muted">{{ $item->event->address }}</div>
                                                <div class="text-muted">{{ $item->event->start_time->format('d M Y, h:i A') }}</div>
                                                <div class="text-muted">{{ $item->order_status }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info">{{ __('No upcoming events found.') }}</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Tabbed Content -->
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-pills" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="upcoming-tab" data-toggle="pill" href="#upcoming" role="tab" aria-controls="upcoming" aria-selected="true">
                                        {{ __('Upcoming') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="past-tab" data-toggle="pill" href="#past" role="tab" aria-controls="past" aria-selected="false">
                                        {{ __('Past') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="liked-tab" data-toggle="pill" href="#liked" role="tab" aria-controls="liked" aria-selected="false">
                                        {{ __('Liked Events') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="blogs-tab" data-toggle="pill" href="#blogs" role="tab" aria-controls="blogs" aria-selected="false">
                                        {{ __('Liked Blogs') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="following-tab" data-toggle="pill" href="#following" role="tab" aria-controls="following" aria-selected="false">
                                        {{ __('Following') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent3">
                                <!-- Upcoming Events Tab -->
                                <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
                                    @forelse ($ticket['upcoming'] as $item)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <img src="{{ url('images/upload/' . $item->event->image) }}" alt=""
                                                            class="img-fluid rounded" style="height: 80px; width: 80px; object-fit: cover;">
                                                    </div>
                                                    <div class="col-md-10">
                                                        <h5>{{ $item->event->name }}</h5>
                                                        <div class="text-muted">{{ $item->event->address }}</div>
                                                        <div class="text-muted">{{ $item->event->start_time->format('d M Y, h:i A') }}</div>
                                                        <div class="text-muted">{{ $item->order_status }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="alert alert-info">{{ __('No upcoming events found.') }}</div>
                                    @endforelse
                                </div>
                                <div class="tab-pane fade" id="past" role="tabpanel" aria-labelledby="past-tab">
                                    @forelse ($ticket['past'] as $item)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <img src="{{ url('images/upload/' . $item->event->image) }}" alt=""
                                                            class="img-fluid rounded" style="height: 80px; width: 80px; object-fit: cover;">
                                                    </div>
                                                    <div class="col-md-10">
                                                        <h5>{{ $item->event->name }}</h5>
                                                        <div class="text-muted">{{ $item->event->address }}</div>
                                                        <div class="text-muted">{{ $item->event->start_time->format('d M Y, h:i A') }}</div>
                                                        <div class="text-muted">{{ $item->order_status }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="alert alert-info">{{ __('No past events found.') }}</div>
                                    @endforelse
                                </div>
                                <div class="tab-pane fade" id="liked" role="tabpanel" aria-labelledby="liked-tab">
                                    @forelse ($likedEvents as $item)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <img src="{{ url('images/upload/' . $item->image) }}" alt=""
                                                            class="img-fluid rounded" style="height: 80px; width: 80px; object-fit: cover;">
                                                    </div>
                                                    <div class="col-md-10">
                                                        <h5>{{ $item->name }}</h5>
                                                        <div class="text-muted">{{ $item->address }}</div>
                                                        <div class="text-muted">{{ $item->start_time->format('d M Y, h:i A') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="alert alert-info">{{ __('No liked events found.') }}</div>
                                    @endforelse
                                </div>
                                <div class="tab-pane fade" id="blogs" role="tabpanel" aria-labelledby="blogs-tab">
                                    @forelse ($likedBlogs as $item)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <img src="{{ url('images/upload/' . $item->image) }}" alt=""
                                                            class="img-fluid rounded" style="height: 80px; width: 80px; object-fit: cover;">
                                                    </div>
                                                    <div class="col-md-10">
                                                        <h5>{{ $item->title }}</h5>
                                                        <div class="text-muted">{{ $item->created_at->format('d M Y') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="alert alert-info">{{ __('No liked blogs found.') }}</div>
                                    @endforelse
                                </div>
                                <div class="tab-pane fade" id="following" role="tabpanel" aria-labelledby="following-tab">
                                    @forelse ($userFollowing as $item)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-md-2">
                                                        <img src="{{ asset('images/upload/' . $item->image) }}" alt="{{ $item->name }}" class="rounded-circle" width="60" height="60" style="object-fit: cover;">
                                                    </div>
                                                    <div class="col-md-10">
                                                        <h5>{{ $item->name }}</h5>
                                                        <p class="text-muted mb-0">{{ $item->email }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="alert alert-info">{{ __('No following users found.') }}</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendar Sidebar -->
                <div class="col-lg-4 col-xl-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Calendar') }}</h4>
                        </div>
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function showTab(tabName) {
            // Show the corresponding tab
        }
    </script>
@endsection

@section('title', __('My Dashboard'))

@push('css')
<style>
    /* Custom styles for the new dashboard */
    body {
        background-color: #f3f4f6;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }
    
    /* Top Navigation */
    .top-nav {
        background-color: #2563eb;
        color: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        height: 4rem;
        z-index: 40;
        display: flex;
        align-items: center;
        padding: 0 1.5rem;
    }
    
    /* Sidebar */
    .sidebar {
        background-color: white;
        width: 16rem;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        padding-top: 4rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        overflow-y: auto;
        transition: all 0.3s;
        z-index: 30;
    }
    
    /* Main Content */
    .main-content {
        margin-left: 16rem;
        margin-top: 4rem;
        padding: 1.5rem;
        transition: all 0.3s;
    }
    
    /* Navigation Items */
    .nav-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        color: #4b5563;
        transition: background-color 0.2s, color 0.2s;
        text-decoration: none;
    }
    
    .nav-item:hover {
        background-color: #eff6ff;
        color: #2563eb;
    }
    
    .nav-item.active {
        background-color: #dbeafe;
        color: #2563eb;
        border-right: 4px solid #2563eb;
    }
    
    .nav-item i {
        margin-right: 0.75rem;
        width: 1.25rem;
        text-align: center;
    }
    
    /* Cards */
    .card {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    /* Calendar */
    .calendar-day {
        text-align: center;
        padding: 0.25rem 0;
        cursor: pointer;
        border-radius: 9999px;
        transition: background-color 0.2s;
    }
    
    .calendar-day:hover {
        background-color: #eff6ff;
    }
    
    .calendar-day.today {
        background-color: #dbeafe;
        color: #2563eb;
        font-weight: 500;
    }
    
    /* Event Card */
    .event-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .event-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    /* Progress Bar */
    .progress-bar {
        height: 0.5rem;
        background-color: #e5e7eb;
        border-radius: 0.25rem;
        overflow: hidden;
    }
    
    .progress-bar-fill {
        height: 100%;
        background-color: #10b981;
        border-radius: 0.25rem;
    }
    .stat-card .stat-value {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1e40af;
    }
    .stat-card .stat-label {
        color: #6b7280;
        font-size: 0.875rem;
    }
</style>
@endpush

@section('content')
@php
    $user = Auth::guard('appuser')->user();
    $upcomingEvents = $ticket['upcoming']->take(3);
    $currentDate = now();
    $today = $currentDate->day;
    $daysInMonth = $currentDate->daysInMonth;
    $firstDayOfMonth = $currentDate->firstOfMonth()->dayOfWeek;
@endphp
@php
    $user = Auth::guard('appuser')->user();
    $upcomingEvents = $ticket['upcoming']->take(3); // Get only 3 upcoming events for the dashboard
    $currentDate = now();
    $today = $currentDate->day;
    $daysInMonth = $currentDate->daysInMonth;
    $firstDayOfMonth = $currentDate->firstOfMonth()->dayOfWeek;
@endphp

<!-- Top Navigation -->
<nav class="top-nav flex items-center justify-between px-6">
    <!-- Logo -->
    <div class="flex items-center">
        <img src="{{ asset('images/logo.png') }}" alt="StarrTix" class="h-8">
        <span class="ml-2 text-xl font-bold">StarrTix</span>
    </div>
    
    <!-- User and Language -->
    <div class="flex items-center space-x-6">
        <!-- Language Selector -->
        <div class="relative">
            <button class="flex items-center text-white hover:text-blue-100">
                <i class="fas fa-globe mr-2"></i>
                <span>EN</span>
                <i class="fas fa-chevron-down ml-1 text-xs"></i>
            </button>
        </div>
        
        <!-- User Profile -->
        <div class="flex items-center">
            <span class="mr-3 text-sm font-medium">Russ Sidney</span>
            <div class="relative">
                <img src="{{ asset('images/upload/' . ($user->image ?? 'default-user.png')) }}" 
                     alt="Profile" 
                     class="w-8 h-8 rounded-full border-2 border-white">
                <span class="absolute bottom-0 right-0 w-2 h-2 bg-green-500 rounded-full border border-white"></span>
            </div>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<aside class="sidebar">
    <nav class="mt-6">
        <a href="#" class="nav-item active">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-calendar-alt"></i>
            <span>Events</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-ticket-alt"></i>
            <span>Tickets</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-shopping-bag"></i>
            <span>Orders</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>
    </nav>
</aside>

<!-- Main Content -->
<main class="main-content">
    <!-- Page Title -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            <i class="fas fa-plus mr-2"></i> New Event
        </button>
    </div>
    
    <!-- Two Column Layout -->
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Content Area -->
        <div class="w-full lg:w-2/3">
            <!-- Upcoming Events Section -->
            <div class="card mb-6">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-800">Upcoming Events</h2>
                </div>
                <div class="p-6">
                    @forelse($upcomingEvents as $event)
                    <div class="flex items-start mb-6 pb-6 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                        <!-- Event Image -->
                        <div class="w-24 h-24 rounded-lg overflow-hidden flex-shrink-0">
                            <img src="{{ asset('images/upload/' . ($event->event->image ?? 'event-default.jpg')) }}" 
                                 alt="{{ $event->event->name }}" 
                                 class="w-full h-full object-cover">
                        </div>
                        
                        <!-- Event Details -->
                        <div class="ml-4 flex-1">
                            <h3 class="font-medium text-gray-900 mb-1">{{ $event->event->name }}</h3>
                            <p class="text-sm text-gray-500 mb-3">
                                <i class="fas fa-map-marker-alt mr-2"></i> {{ $event->event->location }}
                            </p>
                            
                            <!-- Event Meta -->
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-users mr-2 text-blue-500"></i>
                                    <span>{{ $event->event->capacity }} People</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-ticket-alt mr-2 text-green-500"></i>
                                    <span>{{ $event->event->available_tickets }} Tickets Left</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="far fa-calendar-alt mr-2 text-purple-500"></i>
                                    <span>{{ \Carbon\Carbon::parse($event->event->start_date)->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-calendar-times text-4xl mb-3 text-gray-300"></i>
                        <p>No upcoming events</p>
                    </div>
                    @endforelse
                    
                    <!-- See All Button -->
                    <div class="mt-6 text-center">
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            See all events <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Sidebar -->
        <div class="w-full lg:w-1/3">
            <!-- Calendar Widget -->
            <div class="card mb-6">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800">{{ now()->format('F Y') }}</h2>
                    <div class="flex space-x-2">
                        <button class="p-1 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="p-1 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <!-- Days of Week -->
                    <div class="grid grid-cols-7 gap-1 mb-2 text-xs text-center text-gray-500 font-medium">
                        <div>Su</div><div>Mo</div><div>Tu</div><div>We</div><div>Th</div><div>Fr</div><div>Sa</div>
                    </div>
                    
                    <!-- Calendar Days -->
                    <div class="grid grid-cols-7 gap-1 text-sm">
                        @php
                            // Fill in empty days from previous month
                            for($i = 0; $i < $firstDayOfMonth; $i++) {
                                echo '<div class="h-8 flex items-center justify-center text-gray-300">' . ($daysInMonth - $firstDayOfMonth + $i + 1) . '</div>';
                            }
                            
                            // Current month's days
                            for($day = 1; $day <= $daysInMonth; $day++) {
                                $isToday = ($day == $today);
                                echo '<div class="calendar-day ' . ($isToday ? 'today' : '') . '">' . $day . '</div>';
                            }
                            
                            // Fill in remaining days of the last week
                            $remainingDays = 42 - ($firstDayOfMonth + $daysInMonth); // 6 rows x 7 days
                            for($i = 1; $i <= $remainingDays; $i++) {
                                echo '<div class="h-8 flex items-center justify-center text-gray-300">' . $i . '</div>';
                            }
                        @endphp
                    </div>
                </div>
            </div>
            
            <!-- Upcoming Events List -->
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-800">Today's Events</h2>
                </div>
                <div class="p-4">
                    @forelse($upcomingEvents as $event)
                    <div class="mb-4 pb-4 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                        <h3 class="font-medium text-sm text-gray-900 mb-1">{{ $event->event->name }}</h3>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">
                                <i class="far fa-clock mr-1"></i> 
                                {{ \Carbon\Carbon::parse($event->event->start_time)->format('g:i A') }}
                            </span>
                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                @php
                                    $progress = min(100, max(0, (($event->event->capacity - $event->event->available_tickets) / $event->event->capacity) * 100));
                                @endphp
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-gray-500 text-sm">
                        No events scheduled for today
                    </div>
                    @endforelse
            <!-- Stats Cards -->
        </div>
        
        <!-- Right Sidebar -->
        <div class="w-full lg:w-1/3 space-y-6">
            <!-- Calendar Widget -->
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800">{{ now()->format('F Y') }}</h2>
                    <div class="flex space-x-2">
                        <button class="p-1 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="p-1 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <!-- Days of Week -->
                    <div class="grid grid-cols-7 gap-1 mb-2 text-xs text-center text-gray-500 font-medium">
                        <div>Su</div><div>Mo</div><div>Tu</div><div>We</div><div>Th</div><div>Fr</div><div>Sa</div>
                    </div>
                    
                    <!-- Calendar Days -->
                    <div class="grid grid-cols-7 gap-1 text-sm">
                        @php
                            // Fill in empty days from previous month
                            for($i = 0; $i < $firstDayOfMonth; $i++) {
                                echo '<div class="h-8 flex items-center justify-center text-gray-300">' . ($daysInMonth - $firstDayOfMonth + $i + 1) . '</div>';
                            }
                            
                            // Current month's days
                            for($day = 1; $day <= $daysInMonth; $day++) {
                                $isToday = ($day == $today);
                                echo '<div class="calendar-day ' . ($isToday ? 'today' : '') . '">' . $day . '</div>';
                            }
                            
                            // Fill in remaining days of the last week
                            $remainingDays = 42 - ($firstDayOfMonth + $daysInMonth);
                            for($i = 1; $i <= $remainingDays; $i++) {
                                echo '<div class="h-8 flex items-center justify-center text-gray-300">' . $i . '</div>';
                            }
                        @endphp
                    </div>
                </div>
            </div>
            
            <!-- Today's Events -->
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-800">Today's Events</h2>
                </div>
                <div class="p-4 space-y-4">
                    @forelse($upcomingEvents as $event)
                    <div class="event-card p-3 rounded-lg border border-gray-100 hover:border-blue-100">
                        <h3 class="font-medium text-gray-900 text-sm mb-1">{{ $event->event->name }}</h3>
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                            <span><i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($event->event->start_time)->format('g:i A') }}</span>
                            <span>{{ $event->event->available_tickets }} tickets left</span>
                        </div>
                        <div class="progress-bar">
                            @php
                                $progress = min(100, max(0, (($event->event->capacity - $event->event->available_tickets) / $event->event->capacity) * 100));
                            @endphp
                            <div class="progress-bar-fill" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-gray-500 text-sm">
                        <i class="far fa-calendar-plus text-2xl mb-2 text-gray-300"></i>
                        <p>No events scheduled for today</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize any JavaScript functionality here
    const calendarDays = document.querySelectorAll('.calendar-day');
    
    calendarDays.forEach(day => {
        day.addEventListener('click', function() {
            // Remove active class from all days
            calendarDays.forEach(d => d.classList.remove('bg-blue-100', 'text-blue-700'));
            // Add active class to clicked day

                        </div>
                        <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                            <i class="fas fa-shopping-cart text-xl"></i>
                        </div>
                    </div>
                    
                </div>
                
                <!-- Upcoming Events Card -->
                <div class="card stat-card p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="stat-label">Upcoming Events</p>
                            <h3 class="stat-value">{{ $upcomingEvents }}</h3>
                        </div>
                        <div class="p-3 rounded-lg bg-green-100 text-green-600">
                            <i class="fas fa-calendar-check text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <span class="text-sm text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i> 5 more than last month
                        </span>
                    </div>
                </div>
                
                <!-- Total Spent Card -->
                <div class="card stat-card p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="stat-label">Total Spent</p>
                            <h3 class="stat-value">${{ number_format(rand(500, 5000), 2) }}</h3>
                        </div>
                        <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                            <i class="fas fa-dollar-sign text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <span class="text-sm text-red-600">
                            <i class="fas fa-arrow-down mr-1"></i> 2% from last month
                        </span>
                    </div>
                </div>
                
                <!-- Favorite Category Card -->
                <div class="card stat-card p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Quick Actions</p>
                            <h3 class="text-2xl font-bold text-gray-800">Explore</h3>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100 flex space-x-2">
                        <button class="text-xs bg-blue-50 text-blue-600 px-3 py-1 rounded-full hover:bg-blue-100">
                            <i class="fas fa-plus mr-1"></i> New Event
                        </button>
                        <button class="text-xs bg-green-50 text-green-600 px-3 py-1 rounded-full hover:bg-green-100">
                            <i class="fas fa-ticket-alt mr-1"></i> Buy Tickets
                        </button>
                    </div>
                </div>
            </div>
        
        <!-- Main Content Area -->
        <div class="grid grid-cols-1">
            <!-- Main Content -->
            <div>
                <div class="card overflow-hidden">
                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200 bg-gray-50">
                        <nav class="flex -mb-px">
                            <button type="button" onclick="showTab('orders')" class="tab-btn py-4 px-6 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600 bg-white" data-tab="orders">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                {{ __('My Orders') }}

                            </button>
                            <button type="button" onclick="showTab('events')" class="tab-btn py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="events">
                                <i class="fas fa-ticket-alt mr-2"></i>
                                {{ __('My Tickets') }}
                                <span class="ml-2 px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">{{ $upcomingEvents }}</span>
                            </button>
                            <button type="button" onclick="showTab('account')" class="tab-btn py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="account">
                                <i class="fas fa-user-cog mr-2"></i>
                                {{ __('Account') }}
                            </button>
                            <div class="flex-1 flex justify-end items-center pr-4">
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                        </nav>
                    </div>
                    
                    <!-- Tab Content -->
                    <div class="p-6">
                        <!-- Orders Tab Content -->
                        <div class="tab-content-item" id="orders-content">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div class="mb-4 md:mb-0">
                            <h3 class="text-lg font-semibold text-gray-900">{{ __('Recent Orders') }}</h3>
                            <p class="text-sm text-gray-500 mt-1">View and manage your ticket purchases</p>
                        </div>
                        <div class="flex space-x-3">
                            <div class="relative">
                                <select class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option>All Orders</option>
                                    <option>Upcoming</option>
                                    <option>Past</option>
                                    <option>Cancelled</option>
                                </select>
                            </div>
                            <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-download mr-2"></i>
                                {{ __('Export') }}
                            </button>
                        </div>
                    </div>

                    <!-- Orders Table -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Event
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Order Details
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse (array_merge($ticket['upcoming']->items(), $ticket['past']->items()) as $item)
                                    <tr class="hover:bg-gray-50">
                                        <!-- Event Column -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-12 rounded-md overflow-hidden">
                                                    <img class="h-full w-full object-cover" 
                                                         src="{{ asset('images/upload/' . $item->event->image) }}" 
                                                         alt="{{ $item->event->name }}">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $item->event->name }}</div>
                                                    <div class="text-sm text-gray-500">
                                                        <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i> 
                                                        {{ $item->event->address }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Order Details Column -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">#{{ $item->order_number }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $item->ticket->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $item->quantity }} x ${{ number_format($item->amount / $item->quantity, 2) }}
                                            </div>
                                        </td>
                                        
                                        <!-- Date Column -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($item->event->start_time)->format('M d, Y') }}
                                            </div>
                                        </td>
                                        
                                        <!-- Status Column -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusClasses = [
                                                    'Complete' => 'bg-green-100 text-green-800',
                                                    'Pending' => 'bg-yellow-100 text-yellow-800',
                                                    'Cancelled' => 'bg-red-100 text-red-800',
                                                    'Refunded' => 'bg-gray-100 text-gray-800',
                                                    'Processing' => 'bg-blue-100 text-blue-800'
                                                ][$item->order_status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses }}">
                                                {{ $item->order_status }}
                                            </span>
                                        </td>
                                        
                                        <!-- Actions Column -->
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ url('/my-ticket/' . $item->id) }}" 
                                                   class="text-blue-600 hover:text-blue-900 mr-3"
                                                   data-tooltip="View Ticket"
                                                   data-tooltip-pos="top">
                                                    <i class="fas fa-ticket-alt"></i>
                                                </a>
                                                <a href="#" 
                                                   class="text-indigo-600 hover:text-indigo-900 mr-3"
                                                   data-tooltip="Download"
                                                   data-tooltip-pos="top">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <a href="#" 
                                                   class="text-green-600 hover:text-green-900"
                                                   data-tooltip="Share"
                                                   data-tooltip-pos="top">
                                                    <i class="fas fa-share-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                                    </td>
                                                </tr>
                                            @empty
                                            @endforelse
                                            
                                            @forelse ($ticket['past'] as $item)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <img src="{{ asset('images/upload/' . $item->event->image) }}" 
                                                                 alt="{{ $item->event->name }}" 
                                                                 class="w-12 h-12 rounded-lg object-cover">
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">{{ $item->event->name }}</div>
                                                                <div class="text-sm text-gray-500">{{ $item->event->address }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->ticket->name }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($item->event->start_time)->format('M d, Y') }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $item->order_status == 'Complete' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                            {{ $item->order_status }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <a href="{{ url('/my-ticket/' . $item->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                            {{ __('View') }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                @if(count($ticket['upcoming']) == 0)
                                                <tr>
                                                    <td colspan="5" class="px-6 py-12 text-center">
                                                        <div class="flex flex-col items-center">
                                                            <i class="fas fa-shopping-cart text-4xl text-gray-400 mb-4"></i>
                                                            <p class="text-gray-500 text-lg">{{ __('No orders found') }}</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    
                    <!-- My Tickets Tab -->
                    <div class="tab-content-item" id="events">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                            <div class="mb-4 md:mb-0">
                                <h3 class="text-lg font-semibold text-gray-900">{{ __('My Tickets') }}</h3>
                                <p class="text-sm text-gray-500 mt-1">View and manage your event tickets</p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="relative">
                                    <select class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option>All Events</option>
                                        <option>Upcoming</option>
                                        <option>Past</option>
                                    </select>
                                </div>
                                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-download mr-2"></i> Export
                                </button>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            @forelse (array_merge($ticket['upcoming']->items(), $ticket['past']->items()) as $item)
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition-shadow duration-200">
                                <div class="md:flex">
                                    <!-- Event Image -->
                                    <div class="md:w-1/4 h-48 md:h-auto">
                                        <img src="{{ asset('images/upload/' . $item->event->image) }}" 
                                             class="w-full h-full object-cover" 
                                             alt="{{ $item->event->name }}">
                                    </div>
                                    
                                    <!-- Ticket Details -->
                                    <div class="p-6 flex-1">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->order_status == 'Complete' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $item->order_status }}
                                                </span>
                                                <h4 class="text-lg font-semibold text-gray-900 mt-2">{{ $item->event->name }}</h4>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    <i class="far fa-calendar-alt mr-1"></i> 
                                                    {{ \Carbon\Carbon::parse($item->event->start_time)->format('D, M j, Y \a\t g:i A') }}
                                                </p>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    <i class="fas fa-map-marker-alt mr-1"></i> {{ $item->event->address }}
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm text-gray-500">Order #{{ $item->order_id }}</p>
                                                <p class="text-xs text-gray-400 mt-1">
                                                    {{ \Carbon\Carbon::parse($item->created_at)->format('M j, Y') }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4 pt-4 border-t border-gray-100">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">{{ $item->ticket->name }}</p>
                                                    <p class="text-sm text-gray-500">Qty: 1 × {{ format_currency($item->ticket->price) }}</p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-sm font-medium text-gray-900">{{ format_currency($item->ticket->price) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4 flex flex-wrap gap-3">
                                            <a href="{{ url('/my-ticket/' . $item->id) }}" 
                                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <i class="fas fa-ticket-alt mr-2"></i> View Ticket
                                            </a>
                                            <a href="#" 
                                               class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <i class="fas fa-download mr-2"></i> Download
                                            </a>
                                            <a href="#" 
                                               class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <i class="fas fa-share-alt mr-2"></i> Share
                                            </a>
                                            <a href="{{ route('event.detail', $item->event->slug) }}" 
                                               class="ml-auto inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 hover:text-blue-800">
                                                View Event Details <i class="fas fa-chevron-right ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-12 border-2 border-dashed border-gray-300 rounded-lg">
                                <i class="fas fa-ticket-alt text-4xl text-gray-400 mb-3"></i>
                                <h4 class="text-lg font-medium text-gray-900">No tickets yet</h4>
                                <p class="mt-1 text-sm text-gray-500">You haven't purchased any tickets yet.</p>
                                <div class="mt-6">
                                    <a href="{{ route('events.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-calendar-plus mr-2"></i> Find Events
                                    </a>
                                </div>
                            </div>
                            @endforelse
                            
                            <!-- Pagination -->
                            @if(($ticket['upcoming']->total() + $ticket['past']->total()) > 10)
                            <div class="mt-6 flex items-center justify-between">
                                <div class="text-sm text-gray-500">
                                    Showing <span class="font-medium">{{ ($ticket['upcoming']->currentPage() - 1) * $ticket['upcoming']->perPage() + 1 }}</span>
                                    to <span class="font-medium">{{ min($ticket['upcoming']->currentPage() * $ticket['upcoming']->perPage(), $ticket['upcoming']->total() + $ticket['past']->total()) }}</span>
                                    of <span class="font-medium">{{ $ticket['upcoming']->total() + $ticket['past']->total() }}</span> results
                                </div>
                                <div class="flex space-x-2">
                                    @if($ticket['upcoming']->currentPage() > 1)
                                        <a href="{{ $ticket['upcoming']->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                            Previous
                                        </a>
                                    @endif
                                    @if($ticket['upcoming']->hasMorePages())
                                        <a href="{{ $ticket['upcoming']->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                            Next
                                        </a>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Account Tab -->
                    <div class="tab-content-item" id="account">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Profile Information -->
                            <div>
                                <div class="bg-white rounded-lg shadow-md">
                                    <div class="px-6 py-4 border-b border-gray-200">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Profile Information') }}</h3>
                                    </div>
                                    <div class="p-6">
                                        <div class="text-center mb-6">
                                            <img src="{{ asset('images/upload/' . Auth::guard('appuser')->user()->image) }}"
                                                 alt="Profile Picture" 
                                                 class="w-24 h-24 rounded-full mx-auto object-cover border-4 border-gray-200">
                                        </div>
                                        <div class="space-y-4">
                                            <div class="flex justify-between py-2 border-b border-gray-100">
                                                <span class="font-medium text-gray-700">{{ __('Name') }}:</span>
                                                <span class="text-gray-900">{{ Auth::guard('appuser')->user()->name . ' ' . Auth::guard('appuser')->user()->last_name }}</span>
                                            </div>
                                            <div class="flex justify-between py-2 border-b border-gray-100">
                                                <span class="font-medium text-gray-700">{{ __('Email') }}:</span>
                                                <span class="text-gray-900">{{ Auth::guard('appuser')->user()->email }}</span>
                                            </div>
                                            @if(Auth::guard('appuser')->user()->bio)
                                            <div class="flex justify-between py-2 border-b border-gray-100">
                                                <span class="font-medium text-gray-700">{{ __('Bio') }}:</span>
                                                <span class="text-gray-900">{{ Auth::guard('appuser')->user()->bio }}</span>
                                            </div>
                                            @endif
                                            @if ($wallet == 1)
                                            <div class="flex justify-between py-2 border-b border-gray-100">
                                                <span class="font-medium text-gray-700">{{ __('Wallet Balance') }}:</span>
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ Auth::guard('appuser')->user()->balance }}</span>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="text-center mt-6">
                                            <a href="{{ url('/update_profile') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <i class="fas fa-edit mr-2"></i> {{ __('Edit Profile') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Account Actions -->
                            <div>
                                <div class="bg-white rounded-lg shadow-md">
                                    <div class="px-6 py-4 border-b border-gray-200">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Account Actions') }}</h3>
                                    </div>
                                    <div class="p-6">
                                        <div class="space-y-2">
                                            <a href="{{ url('/update_profile') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                                <i class="fas fa-user-edit text-blue-500 mr-3"></i>
                                                <span>{{ __('Update Profile') }}</span>
                                            </a>
                                            <a href="{{ url('/change-password') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                                <i class="fas fa-key text-blue-500 mr-3"></i>
                                                <span>{{ __('Change Password') }}</span>
                                            </a>
                                            @if ($wallet == 1)
                                            <a href="{{ url('/wallet') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                                <i class="fas fa-wallet text-blue-500 mr-3"></i>
                                                <span>{{ __('Wallet') }}</span>
                                            </a>
                                            @endif
                                            <a href="{{ url('/logout') }}" class="flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200">
                                                <i class="fas fa-sign-out-alt text-red-500 mr-3"></i>
                                                <span>{{ __('Logout') }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Main Content Styling */
.main-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

/* Card Styling */
.card {
    background: white;
    border-radius: 0.75rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    background-color: #f9fafb;
}

.card-body {
    padding: 1.5rem;
}

/* Tab Content Styling */
.tab-content-item {
    display: none;
    animation: fadeIn 0.3s ease-in-out;
}
.tab-content-item.active {
    display: block;
}

/* Tab Button Styling */
.tab-btn.active {
    color: #2563eb !important;
    border-color: #2563eb !important;
    background-color: #eff6ff;
}

/* Custom Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Calendar Styling */
.calendar-day {
    transition: all 0.2s ease;
}
.calendar-day:hover {
    transform: scale(1.1);
}

/* Card Hover Effects */
.dashboard-card {
    transition: all 0.3s ease;
}
.dashboard-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* Gradient Background Animation */
.gradient-bg {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    background-size: 200% 200%;
    animation: gradientShift 10s ease infinite;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Table Row Animations */
.table-row {
    transition: all 0.2s ease;
}
.table-row:hover {
    transform: translateX(5px);
}

/* Status Badge Pulse Animation */
.status-complete {
    animation: pulse-green 2s infinite;
}

@keyframes pulse-green {
    0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
    100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
}

/* Loading Animation for Statistics */
.stat-number {
    animation: countUp 1s ease-out;
}

@keyframes countUp {
    from { transform: scale(0.5); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

/* Responsive Design Enhancements */
@media (max-width: 768px) {
    .dashboard-header {
        flex-direction: column;
        text-align: center;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .main-grid {
        grid-template-columns: 1fr;
    }
    
    .card {
        border-radius: 0.5rem;
    }
    
    .card-header {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
}
</style>

<script>
// Enhanced Tab Functionality
function showTab(tabName) {
    // Hide all tab content with fade effect
    document.querySelectorAll('.tab-content-item').forEach(function(tab) {
        tab.style.opacity = '0';
        setTimeout(() => {
            tab.classList.remove('active');
        }, 150);
    });
    
    // Remove active class from all tab buttons
    document.querySelectorAll('.tab-btn').forEach(function(btn) {
        btn.classList.remove('active');
        btn.classList.remove('border-blue-500', 'text-blue-600', 'bg-blue-50');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content with fade effect
    setTimeout(() => {
        const selectedTab = document.getElementById(tabName);
        selectedTab.classList.add('active');
        selectedTab.style.opacity = '1';
    }, 150);
    
    // Add active class to clicked button
    const activeBtn = document.querySelector('[data-tab="' + tabName + '"]');
    activeBtn.classList.add('active');
    activeBtn.classList.remove('border-transparent', 'text-gray-500');
    activeBtn.classList.add('border-blue-500', 'text-blue-600');
}

// Initialize dashboard animations on load
document.addEventListener('DOMContentLoaded', function() {
    // Animate statistics cards
    const statCards = document.querySelectorAll('.dashboard-card');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Animate table rows
    const tableRows = document.querySelectorAll('.table-row');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        setTimeout(() => {
            row.style.transition = 'all 0.4s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, 500 + (index * 50));
    });
    
    // Add hover effects to calendar days
    const calendarDays = document.querySelectorAll('.calendar-day');
    calendarDays.forEach(day => {
        day.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
        });
        day.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});

// Add smooth scrolling for better UX
function smoothScrollTo(element) {
    element.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

// Add loading states for buttons
function addLoadingState(button) {
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
    button.disabled = true;
    
    // Simulate loading (remove this in production)
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    }, 2000);
}

// Add click handlers for action buttons
document.addEventListener('DOMContentLoaded', function() {
    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!this.href || this.href === '#') {
                e.preventDefault();
                addLoadingState(this);
            }
        });
    });
});
</script>

@push('scripts')
<script>
// Initialize any JavaScript functionality here
document.addEventListener('DOMContentLoaded', function() {
    // Add any initialization code here
});
</script>
@endpush

@endsection
