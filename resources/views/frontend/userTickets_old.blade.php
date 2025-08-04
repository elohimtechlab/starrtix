@extends('frontend.master', ['activePage' => 'ticket'])
@section('title', __('My Dashboard'))
@section('content')
    @php
        $user = Auth::guard('appuser')->user();
        $totalTickets = $ticket['upcoming']->total() + $ticket['past']->total();
        $upcomingTickets = $ticket['upcoming']->total();
        $pastTickets = $ticket['past']->total();
        $likedEventsCount = $likedEvents->count();
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
            <!-- Statistics Cards Row -->
            <div class="row">
                <!-- Total Tickets Card -->
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
                                    <div class="card-stats-item-count">{{ $likedEventsCount }}</div>
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

                <!-- Profile Card -->
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-stats">
                            <div class="card-stats-title">{{ __('Account Info') }}</div>
                            <div class="card-stats-items">
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ $user->name }}</div>
                                    <div class="card-stats-item-label">{{ __('Full Name') }}</div>
                                </div>
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ \Carbon\Carbon::parse($user->created_at)->format('M Y') }}</div>
                                    <div class="card-stats-item-label">{{ __('Member Since') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-icon shadow-success bg-success">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Profile') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $user->email }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wallet Balance Card -->
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-stats">
                            <div class="card-stats-title">{{ __('Wallet') }}</div>
                            <div class="card-stats-items">
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">${{ number_format($user->balance ?? 0, 2) }}</div>
                                    <div class="card-stats-item-label">{{ __('Available Balance') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-icon shadow-warning bg-warning">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Wallet Balance') }}</h4>
                            </div>
                            <div class="card-body">
                                <a href="#" class="btn btn-sm btn-primary">{{ __('Add Funds') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Row -->
            <div class="row">
                <!-- Left Column - Tickets and Events -->
                <div class="col-lg-8">
                    <!-- Upcoming Tickets Section -->
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Upcoming Tickets') }}</h4>
                            <div class="card-header-action">
                                <a href="#" class="btn btn-primary">{{ __('View All') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($ticket['upcoming']->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Event') }}</th>
                                                <th>{{ __('Date') }}</th>
                                                <th>{{ __('Time') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ticket['upcoming']->take(5) as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ url('images/upload/' . $item->event->image) }}" 
                                                                 alt="{{ $item->event->name }}" 
                                                                 class="rounded" 
                                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                                            <div class="ml-3">
                                                                <div class="font-weight-bold">{{ $item->event->name }}</div>
                                                                <div class="text-muted small">{{ $item->event->address }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($item->event->start_time)->format('M d, Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->event->start_time)->format('h:i A') }}</td>
                                                    <td>
                                                        <span class="badge badge-success">{{ __('Confirmed') }}</span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('/ticket-booking/' . $item->id . '/' . $item->customer_id) }}" 
                                                           class="btn btn-sm btn-primary">{{ __('View Ticket') }}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="empty-state" data-height="400">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-ticket-alt"></i>
                                    </div>
                                    <h2>{{ __('No Upcoming Tickets') }}</h2>
                                    <p class="lead">{{ __('You don\'t have any upcoming event tickets yet.') }}</p>
                                    <a href="{{ url('/') }}" class="btn btn-primary mt-4">{{ __('Browse Events') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Liked Events Section -->
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Liked Events') }}</h4>
                            <div class="card-header-action">
                                <a href="#" class="btn btn-primary">{{ __('View All') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($likedEvents->count() > 0)
                                <div class="row">
                                    @foreach($likedEvents->take(4) as $event)
                                        <div class="col-md-6 mb-3">
                                            <div class="card card-secondary">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <img src="{{ url('images/upload/' . $event->image) }}" 
                                                             alt="{{ $event->name }}" 
                                                             class="rounded mr-3" 
                                                             style="width: 60px; height: 60px; object-fit: cover;">
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1">{{ $event->name }}</h6>
                                                            <p class="text-muted small mb-1">{{ $event->address }}</p>
                                                            <p class="text-muted small mb-0">{{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state" data-height="200">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <h4>{{ __('No Liked Events') }}</h4>
                                    <p class="lead">{{ __('Start liking events to see them here.') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column - Profile and Actions -->
                <div class="col-lg-4">
                    <!-- Profile Details Card -->
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Profile Details') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="profile-widget">
                                <div class="profile-widget-header">
                                    <img alt="image" src="{{ $user->image ? url('images/upload/' . $user->image) : asset('images/default-user.png') }}" 
                                         class="rounded-circle profile-widget-picture">
                                    <div class="profile-widget-items">
                                        <div class="profile-widget-item">
                                            <div class="profile-widget-item-label">{{ __('Tickets') }}</div>
                                            <div class="profile-widget-item-value">{{ $totalTickets }}</div>
                                        </div>
                                        <div class="profile-widget-item">
                                            <div class="profile-widget-item-label">{{ __('Liked') }}</div>
                                            <div class="profile-widget-item-value">{{ $likedEventsCount }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-widget-description">
                                    <div class="profile-widget-name">{{ $user->name }}</div>
                                    <p>{{ $user->email }}</p>
                                    <p class="text-muted">{{ __('Member since') }} {{ \Carbon\Carbon::parse($user->created_at)->format('M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Quick Actions') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#editProfileModal">
                                    <i class="fas fa-user-edit mr-2"></i>
                                    {{ __('Edit Profile') }}
                                </a>
                                <a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#changePasswordModal">
                                    <i class="fas fa-key mr-2"></i>
                                    {{ __('Change Password') }}
                                </a>
                                <a href="{{ url('/') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    {{ __('Browse Events') }}
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fas fa-wallet mr-2"></i>
                                    {{ __('Add Funds') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity Card -->
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Recent Activity') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="activities">
                                @if($ticket['past']->count() > 0)
                                    @foreach($ticket['past']->take(3) as $item)
                                        <div class="activity">
                                            <div class="activity-icon bg-primary text-white shadow-primary">
                                                <i class="fas fa-ticket-alt"></i>
                                            </div>
                                            <div class="activity-detail">
                                                <div class="mb-2">
                                                    <span class="text-job">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                                </div>
                                                <p>{{ __('Attended') }} <strong>{{ $item->event->name }}</strong></p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-muted">{{ __('No recent activity') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">{{ __('Edit Profile') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/user-profile-update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">{{ __('Full Name') }}</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Email Address') }}</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">{{ __('Phone Number') }}</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                        </div>
                        <div class="form-group">
                            <label for="image">{{ __('Profile Image') }}</label>
                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Update Profile') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">{{ __('Change Password') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/user-change-password') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="current_password">{{ __('Current Password') }}</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">{{ __('New Password') }}</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirmation">{{ __('Confirm New Password') }}</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Change Password') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Handle profile form submission
        $('#editProfileModal form').on('submit', function(e) {
            e.preventDefault();
            // Add your AJAX submission logic here
            console.log('Profile update form submitted');
        });

        // Handle password change form submission
        $('#changePasswordModal form').on('submit', function(e) {
            e.preventDefault();
            // Add your AJAX submission logic here
            console.log('Password change form submitted');
        });
    });
</script>
@endsection
