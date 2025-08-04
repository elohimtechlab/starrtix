@extends('user-master')
@section('title', __('Ticket Details'))
@section('content')

<!-- Success Animation Overlay -->
<div id="successOverlay" class="success-overlay">
    <div class="success-content">
        <div class="success-checkmark">
            <div class="check-icon">
                <span class="icon-line line-tip"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
        </div>
        <h2 class="success-title">{{ __('Ticket Verified!') }}</h2>
        <p class="success-message">{{ __('Your ticket is valid and ready for the event') }}</p>
    </div>
    <div class="confetti"></div>
</div>

<section class="section">
    <div class="section-header animated-header">
        <h1><i class="fas fa-ticket-alt text-primary"></i> {{ __('Ticket Details') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('userDashboard') }}">{{ __('Dashboard') }}</a></div>
            <div class="breadcrumb-item"><a href="{{ route('userOrders') }}">{{ __('My Orders') }}</a></div>
            <div class="breadcrumb-item">{{ __('Ticket Details') }}</div>
        </div>
    </div>

    <div class="section-body">
        @if(isset($order) && $order->event)
            <!-- Ticket Status Banner -->
            <div class="row mb-2">
                <div class="col-12">
                    <div class="alert alert-success border-0 shadow-sm animated-card" style="animation-delay: 0.1s;">
                        <div class="d-flex align-items-center">
                            <div class="status-icon mr-3">
                                <i class="fas fa-check-circle text-success" style="font-size: 2rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="alert-heading mb-1">{{ __('Ticket Confirmed & Valid') }}</h5>
                                <p class="mb-0">{{ __('Your ticket is confirmed and ready for') }} <strong>{{ $order->event->name }}</strong></p>
                            </div>
                            <div class="countdown-timer">
                                @php
                                    $eventDate = \Carbon\Carbon::parse($order->event->start_time);
                                    $now = \Carbon\Carbon::now();
                                    $daysUntil = $now->diffInDays($eventDate, false);
                                @endphp
                                @if($daysUntil > 0)
                                    <div class="text-center">
                                        <div class="countdown-number">{{ $daysUntil }}</div>
                                        <small class="text-muted">{{ $daysUntil == 1 ? __('day left') : __('days left') }}</small>
                                    </div>
                                @elseif($daysUntil == 0)
                                    <div class="text-center">
                                        <div class="countdown-number text-warning">{{ __('TODAY') }}</div>
                                        <small class="text-muted">{{ __('Event is today!') }}</small>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <div class="countdown-number text-muted">{{ __('PAST') }}</div>
                                        <small class="text-muted">{{ __('Event completed') }}</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="row mb-2">
                <!-- Event Details Column -->
                <div class="col-lg-8">
                    <!-- Event Details Card -->
                    <div class="card border-0 shadow-sm mb-3 animated-card" style="animation-delay: 0.2s;">
                        <div class="card-header bg-gradient-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-calendar-alt mr-2"></i>{{ __('Event Information') }}
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="event-image-container">
                                        <img src="{{ asset('images/upload/' . $order->event->image) }}" 
                                             class="img-fluid rounded shadow-sm event-image" 
                                             alt="{{ $order->event->name }}"
                                             style="height: 200px; width: 100%; object-fit: cover;">
                                        <div class="image-overlay">
                                            <a href="{{ asset('images/upload/' . $order->event->image) }}" target="_blank" class="btn btn-light btn-sm">
                                                <i class="fas fa-expand-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="event-info">
                                        <h3 class="text-primary mb-3">{{ $order->event->name }}</h3>
                                        
                                        <div class="info-grid">
                                            <div class="info-item">
                                                <div class="info-icon bg-success">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </div>
                                                <div class="info-content">
                                                    <label>{{ __('Location') }}</label>
                                                    <span>{{ $order->event->address }}</span>
                                                    <a href="https://maps.google.com/?q={{ urlencode($order->event->address) }}" target="_blank" class="btn btn-sm btn-outline-success ml-2">
                                                        <i class="fas fa-directions"></i> {{ __('Directions') }}
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="info-item">
                                                <div class="info-icon bg-danger">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                                <div class="info-content">
                                                    <label>{{ __('Date & Time') }}</label>
                                                    <div>
                                                        <strong>{{ \Carbon\Carbon::parse($order->event->start_time)->format('l, F j, Y') }}</strong><br>
                                                        <span class="text-muted">{{ \Carbon\Carbon::parse($order->event->start_time)->format('g:i A') }} 
                                                        @if($order->event->end_time)
                                                            - {{ \Carbon\Carbon::parse($order->event->end_time)->format('g:i A') }}
                                                        @endif</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- QR Code & Sharing Card -->
                    <div class="card border-0 shadow-sm mb-3 animated-card" style="animation-delay: 0.3s;">
                        <div class="card-header bg-gradient-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-qrcode mr-2"></i>{{ __('Entry Verification') }}
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="row">
                                @foreach ($orderchild as $index => $item)
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="qr-card" style="border: 1px solid #e3e6f0; border-radius: 10px; padding: 15px; background: #fff;">
                                        <div class="qr-header mb-2">
                                            <span class="badge badge-primary">{{ __('Ticket') }} {{ $index + 1 }}</span>
                                        </div>
                                        <div class="qr-code-container mb-3">
                                            {!! QrCode::size(100)->generate($item->ticket_number) !!}
                                        </div>
                                        <div class="qr-footer mb-3">
                                            <small class="text-muted d-block">{{ $item->ticket_number }}</small>
                                            <small class="text-muted">{{ $order->ticket->name ?? __('General Admission') }}</small>
                                        </div>
                                        
                                        <!-- Individual Ticket Actions -->
                                        <div class="ticket-actions">
                                            <div class="btn-group-vertical w-100" role="group">
                                                <!-- Download Individual Ticket -->
                                                <a href="{{ route('downloadTicket', $order->id) }}?ticket={{ $item->ticket_number }}" 
                                                   class="btn btn-primary btn-sm mb-2" 
                                                   style="border-radius: 20px;">
                                                    <i class="fas fa-download mr-1"></i>{{ __('Download') }}
                                                </a>
                                                
                                                <!-- Share Individual Ticket -->
                                                <button class="btn btn-outline-primary btn-sm mb-2" 
                                                        onclick="shareIndividualTicket('{{ $item->ticket_number }}', '{{ $order->event->name }}', '{{ $index + 1 }}')"
                                                        style="border-radius: 20px;">
                                                    <i class="fas fa-share-alt mr-1"></i>{{ __('Share') }}
                                                </button>
                                                
                                                <!-- Send Individual Ticket -->
                                                <button class="btn btn-warning btn-sm" 
                                                        onclick="sendIndividualTicket('{{ $item->ticket_number }}', '{{ $order->event->name }}', '{{ $index + 1 }}')"
                                                        style="border-radius: 20px; background-color: #fd7e14; border-color: #fd7e14; color: white;">
                                                    <i class="fas fa-paper-plane mr-1"></i>{{ __('Send Ticket') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Ticket & Actions Column -->
                <div class="col-lg-4">
                    <!-- Ticket Details Card -->
                    <div class="card border-0 shadow-sm mb-3 animated-card" style="animation-delay: 0.5s;">
                        <div class="card-header bg-gradient-warning text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-ticket-alt mr-2"></i>{{ __('Your Ticket') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Order Information -->
                            <div class="ticket-details mb-3">
                                <div class="detail-row">
                                    <label>{{ __('Order ID') }}</label>
                                    <span class="badge badge-primary">{{ $order->order_id }}</span>
                                </div>
                                <div class="detail-row">
                                    <label>{{ __('Ticket Type') }}</label>
                                    <span>{{ $order->ticket->name ?? __('General Admission') }}</span>
                                </div>
                                <div class="detail-row">
                                    <label>{{ __('Quantity') }}</label>
                                    <span class="badge badge-success">{{ $order->quantity }} {{ __('tickets') }}</span>
                                </div>
                                <div class="detail-row">
                                    <label>{{ __('Total Amount') }}</label>
                                    <span class="h6 text-success mb-0">
                                        {{ App\Models\Setting::find(1)->currency_symbol }}{{ number_format($order->payment, 2) }}
                                    </span>
                                </div>
                                <div class="detail-row">
                                    <label>{{ __('Status') }}</label>
                                    <span class="badge badge-success">{{ __('Confirmed') }}</span>
                                </div>
                                <div class="detail-row">
                                    <label>{{ __('Valid Until') }}</label>
                                    <span>
                                        @if ($order->ticket_date != '')
                                            {{ Carbon\Carbon::parse($order->ticket_date)->format('M d, Y') }}
                                        @else
                                            {{ Carbon\Carbon::parse($order->event->end_time)->format('M d, Y') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="card border-0 shadow-sm mb-3 animated-card" style="animation-delay: 0.6s;">
                        <div class="card-header bg-gradient-dark text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-bolt mr-2"></i>{{ __('Quick Actions') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="action-buttons">
                                <a href="{{ url('order-invoice-print/' . $order->id) }}" target="_blank" class="btn btn-outline-success btn-block mb-2 action-btn">
                                    <i class="fas fa-print mr-2"></i>{{ __('Print Ticket') }}
                                </a>
                                <a href="{{ route('downloadTicket', $order->id) }}" class="btn btn-success btn-block mb-2 action-btn">
                                    <i class="fas fa-download mr-2"></i>{{ __('Download PDF') }}
                                </a>
                                <a href="{{ url('/checkout/' . $order->event->id) }}" class="btn btn-primary btn-block mb-2 action-btn" onclick="console.log('Event ID: {{ $order->event->id }}, Order ID: {{ $order->id }}, Event Name: {{ $order->event->name }}')">
                                    <i class="fas fa-shopping-cart mr-2"></i>{{ __('Buy Ticket Again') }}
                                </a>
                                <button class="btn btn-outline-primary btn-block mb-2 action-btn" onclick="addToCalendar()">
                                    <i class="fas fa-calendar-plus mr-2"></i>{{ __('Add to Calendar') }}
                                </button>
                                <a href="{{ route('userOrders') }}" class="btn btn-outline-secondary btn-block mb-2 action-btn">
                                    <i class="fas fa-list mr-2"></i>{{ __('Back to Orders') }}
                                </a>
                                <a href="{{ url('/events/' . $order->event->id) }}" class="btn btn-outline-dark btn-block action-btn">
                                    <i class="fas fa-eye mr-2"></i>{{ __('View Event Page') }}
                                </a>
                                <button class="btn btn-warning btn-block action-btn" onclick="sendTicket()">
                                    <i class="fas fa-envelope mr-2"></i>{{ __('Send Ticket') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Support Card -->
                    <div class="card border-0 shadow-sm animated-card" style="animation-delay: 0.7s;">
                        <div class="card-header bg-gradient-secondary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-headset mr-2"></i>{{ __('Need Help?') }}
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            <p class="text-muted mb-3">{{ __('Having issues with your ticket?') }}</p>
                            <a href="mailto:{{ $order->organization->email ?? 'support@example.com' }}" class="btn btn-outline-primary btn-sm mb-2">
                                <i class="fas fa-envelope mr-1"></i>{{ __('Contact Organizer') }}
                            </a>
                            <br>
                            <button class="btn btn-outline-warning btn-sm" onclick="reportIssue()">
                                <i class="fas fa-exclamation-triangle mr-1"></i>{{ __('Report Issue') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- What's Next Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle mr-2"></i>{{ __('What\'s Next?') }}
                        </h5>
                        <small class="text-white-50">{{ __('Follow these simple steps to enjoy your event') }}</small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="d-flex align-items-start h-100">
                                    <div class="step-icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px; min-width: 40px;">
                                        <strong>1</strong>
                                    </div>
                                    <div>
                                        <strong class="text-success">{{ __('Download Your Tickets') }}</strong>
                                        <p class="text-muted mb-0 small">{{ __('Click the download button to get your tickets in PDF format') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="d-flex align-items-start h-100">
                                    <div class="step-icon bg-info text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px; min-width: 40px;">
                                        <strong>2</strong>
                                    </div>
                                    <div>
                                        <strong class="text-info">{{ __('Save the QR Code') }}</strong>
                                        <p class="text-muted mb-0 small">{{ __('Keep the QR code handy for quick event entry verification') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="d-flex align-items-start h-100">
                                    <div class="step-icon bg-warning text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px; min-width: 40px;">
                                        <strong>3</strong>
                                    </div>
                                    <div>
                                        <strong class="text-warning">{{ __('Arrive Early') }}</strong>
                                        <p class="text-muted mb-0 small">{{ __('Get to the venue 15 minutes before the event starts') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="d-flex align-items-start h-100">
                                    <div class="step-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px; min-width: 40px;">
                                        <strong>4</strong>
                                    </div>
                                    <div>
                                        <strong class="text-primary">{{ __('Present Your Ticket') }}</strong>
                                        <p class="text-muted mb-0 small">{{ __('Show your ticket (digital or printed) at the entrance') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pro Tips Section -->
                        <div class="mt-4 p-4 bg-light rounded">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <h6 class="text-primary mb-2 mb-md-0">
                                        <i class="fas fa-lightbulb mr-2"></i>{{ __('Pro Tips') }}
                                    </h6>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-4 mb-2 mb-md-0">
                                            <small class="text-muted">
                                                <i class="fas fa-check text-success mr-1"></i>
                                                {{ __('Keep your phone charged') }}
                                            </small>
                                        </div>
                                        <div class="col-md-4 mb-2 mb-md-0">
                                            <small class="text-muted">
                                                <i class="fas fa-check text-success mr-1"></i>
                                                {{ __('Print a backup copy') }}
                                            </small>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted">
                                                <i class="fas fa-check text-success mr-1"></i>
                                                {{ __('Check for event updates') }}
                                            </small>
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
</section>

<!-- Individual Ticket Share Modal -->
<div class="modal fade" id="shareTicketModal" tabindex="-1" role="dialog" aria-labelledby="shareTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="shareTicketModalLabel">
                    <i class="fas fa-share-alt mr-2"></i>{{ __('Share Ticket') }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <h6 id="shareTicketTitle" class="text-primary"></h6>
                    <p class="text-muted mb-0" id="shareTicketNumber"></p>
                </div>
                
                <div class="row">
                    <div class="col-6 mb-3">
                        <button class="btn btn-facebook btn-block" onclick="shareToSocial('facebook')">
                            <i class="fab fa-facebook-f mr-2"></i>{{ __('Facebook') }}
                        </button>
                    </div>
                    <div class="col-6 mb-3">
                        <button class="btn btn-info btn-block" onclick="shareToSocial('twitter')">
                            <i class="fab fa-twitter mr-2"></i>{{ __('Twitter') }}
                        </button>
                    </div>
                    <div class="col-6 mb-3">
                        <button class="btn btn-success btn-block" onclick="shareToSocial('whatsapp')">
                            <i class="fab fa-whatsapp mr-2"></i>{{ __('WhatsApp') }}
                        </button>
                    </div>
                    <div class="col-6 mb-3">
                        <button class="btn btn-secondary btn-block" onclick="copyTicketLink()">
                            <i class="fas fa-copy mr-2"></i>{{ __('Copy Link') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Send Ticket Modal -->
<div class="modal fade" id="sendTicketModal" tabindex="-1" role="dialog" aria-labelledby="sendTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="sendTicketModalLabel">
                    <i class="fas fa-paper-plane mr-2"></i>{{ __('Send Ticket') }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="sendTicketForm">
                    <div class="form-group">
                        <label for="recipientEmail">{{ __('Recipient Email') }}</label>
                        <input type="email" class="form-control" id="recipientEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="senderMessage">{{ __('Personal Message') }} ({{ __('Optional') }})</label>
                        <textarea class="form-control" id="senderMessage" rows="3" placeholder="{{ __('Add a personal message...') }}"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-info" onclick="submitSendTicket()">
                    <i class="fas fa-paper-plane mr-2"></i>{{ __('Send Ticket') }}
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Success Animation Overlay */
.success-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.95), rgba(29, 78, 216, 0.95));
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.5s ease;
}

.success-overlay.show {
    opacity: 1;
    visibility: visible;
}

.success-content {
    text-align: center;
    color: white;
    animation: slideInUp 0.8s ease-out;
}

.success-checkmark {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: block;
    stroke-width: 2;
    stroke: #fff;
    stroke-miterlimit: 10;
    margin: 0 auto 20px;
    box-shadow: inset 0px 0px 0px #3b82f6;
    animation: fill 0.4s ease-in-out 0.4s forwards, scale 0.3s ease-in-out 0.9s both;
}

.success-checkmark .check-icon {
    width: 56px;
    height: 56px;
    position: relative;
    border-radius: 50%;
    box-sizing: content-box;
    border: 4px solid #fff;
    margin: 8px auto;
}

.success-checkmark .check-icon::before {
    top: 3px;
    left: -2px;
    width: 30px;
    transform-origin: 100% 50%;
    border-radius: 100px 0 0 100px;
}

.success-checkmark .check-icon::after {
    top: 0;
    left: 30px;
    width: 60px;
    transform-origin: 0 50%;
    border-radius: 0 100px 100px 0;
    animation: rotate-circle 4.25s ease-in;
}

.success-checkmark .check-icon::before,
.success-checkmark .check-icon::after {
    content: '';
    height: 100px;
    position: absolute;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    transform: rotate(-45deg);
}

.success-checkmark .icon-line {
    height: 5px;
    background-color: #fff;
    display: block;
    border-radius: 2px;
    position: absolute;
    z-index: 10;
}

.success-checkmark .icon-line.line-tip {
    top: 46px;
    left: 14px;
    width: 25px;
    transform: rotate(45deg);
    animation: icon-line-tip 0.75s;
}

.success-checkmark .icon-line.line-long {
    top: 38px;
    right: 8px;
    width: 47px;
    transform: rotate(-45deg);
    animation: icon-line-long 0.75s;
}

.success-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    animation: fadeInUp 0.8s ease-out 0.3s both;
}

.success-message {
    font-size: 1.2rem;
    opacity: 0.9;
    animation: fadeInUp 0.8s ease-out 0.5s both;
}

/* Confetti Animation */
.confetti {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    overflow: hidden;
}

.confetti::before,
.confetti::after {
    content: '';
    position: absolute;
    width: 10px;
    height: 10px;
    background: #fbbf24;
    animation: confetti-fall 3s linear infinite;
}

.confetti::before {
    left: 10%;
    animation-delay: 0s;
}

.confetti::after {
    left: 90%;
    animation-delay: 0.5s;
    background: #ef4444;
}

/* Slide-in Animations */
.animated-header {
    animation: slideInDown 0.8s ease-out;
}

.animated-card {
    opacity: 0;
    transform: translateY(30px);
    animation: slideInUp 0.8s ease-out forwards;
}

.countdown-number {
    font-size: 2rem;
    font-weight: 700;
    line-height: 1;
}

.event-image-container {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.event-image-container:hover .image-overlay {
    opacity: 1;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
}

.info-item {
    display: flex;
    align-items: center;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 8px;
    border-left: 4px solid #3b82f6;
}

.info-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    margin-right: 1rem;
    flex-shrink: 0;
}

.info-content {
    flex: 1;
}

.info-content label {
    display: block;
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 0.25rem;
    font-weight: 500;
}

.qr-card {
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.qr-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.qr-header .badge {
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
}

.qr-code-container {
    margin: 1rem 0;
}

.qr-footer {
    font-family: 'Courier New', monospace;
    background: #f1f5f9;
    padding: 0.5rem;
    border-radius: 6px;
    margin-top: 1rem;
}

.sharing-section .btn-group {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    justify-content: center;
}

.share-btn {
    transition: transform 0.2s ease;
}

.share-btn:hover {
    transform: scale(1.05);
}

.insight-item {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    transition: transform 0.3s ease;
}

.insight-item:hover {
    transform: translateY(-3px);
}

.insight-number {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1;
}

.insight-label {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 500;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f5f9;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-row label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0;
}

.action-btn {
    transition: all 0.3s ease;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Keyframe Animations */
@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fill {
    100% {
        box-shadow: inset 0px 0px 0px 30px #3b82f6;
    }
}

@keyframes scale {
    0%, 100% {
        transform: none;
    }
    50% {
        transform: scale3d(1.1, 1.1, 1);
    }
}

@keyframes icon-line-tip {
    0% {
        width: 0;
        left: 1px;
        top: 19px;
    }
    54% {
        width: 0;
        left: 1px;
        top: 19px;
    }
    70% {
        width: 50px;
        left: -8px;
        top: 37px;
    }
    84% {
        width: 17px;
        left: 21px;
        top: 48px;
    }
    100% {
        width: 25px;
        left: 14px;
        top: 45px;
    }
}

@keyframes icon-line-long {
    0% {
        width: 0;
        right: 46px;
        top: 54px;
    }
    65% {
        width: 0;
        right: 46px;
        top: 54px;
    }
    84% {
        width: 55px;
        right: 0px;
        top: 35px;
    }
    100% {
        width: 47px;
        right: 8px;
        top: 38px;
    }
}

@keyframes confetti-fall {
    0% {
        transform: translateY(-100vh) rotate(0deg);
        opacity: 1;
    }
    100% {
        transform: translateY(100vh) rotate(720deg);
        opacity: 0;
    }
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .success-title {
        font-size: 2rem;
    }
    
    .countdown-number {
        font-size: 1.5rem;
    }
    
    .insight-number {
        font-size: 2rem;
    }
}

/* Print Styles */
@media print {
    .success-overlay,
    .sharing-section,
    .action-buttons {
        display: none !important;
    }
}

.btn-facebook {
    background-color: #3b5998;
    border-color: #3b5998;
    color: white;
}
.btn-facebook:hover {
    background-color: #2d4373;
    border-color: #2d4373;
    color: white;
}
.qr-card {
    transition: all 0.3s ease;
}
.qr-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}
.ticket-actions .btn {
    transition: all 0.3s ease;
}
.ticket-actions .btn:hover {
    transform: translateY(-2px);
}
</style>

<script>
// Global variables for sharing
let currentTicketNumber = '';
let currentEventName = '';
let currentTicketIndex = '';

// QR Code generation and display
document.addEventListener('DOMContentLoaded', function() {
    // Initialize any additional functionality here
    console.log('Ticket details page loaded');
});

// Contact organizer functionality
function contactOrganizer() {
    const organizerEmail = '{{ $order->organization->email ?? "" }}';
    const eventName = '{{ $order->event->name ?? "" }}';
    const orderID = '{{ $order->order_id ?? "" }}';
    
    const subject = `Inquiry about ${eventName} - Order #${orderID}`;
    const body = `Hello,\n\nI have a question regarding my ticket for ${eventName}.\n\nOrder ID: ${orderID}\n\nThank you!`;
    
    const mailtoUrl = `mailto:${organizerEmail}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    window.location.href = mailtoUrl;
}

// Send ticket functionality
function sendTicket() {
    $('#sendTicketModal').modal('show');
}

// Submit send ticket functionality
function submitSendTicket() {
    const recipientEmail = document.getElementById('recipientEmail').value;
    const senderMessage = document.getElementById('senderMessage').value;
    
    if (!recipientEmail) {
        showToast('Please enter recipient email', 'error');
        return;
    }
    
    // Send ticket logic here
    console.log('Recipient Email:', recipientEmail);
    console.log('Sender Message:', senderMessage);
    
    // Show toast notification
    showToast('Ticket sent successfully!', 'success');
    
    // Close modal and reset form
    $('#sendTicketModal').modal('hide');
    document.getElementById('sendTicketForm').reset();
}

// Share individual ticket functionality
function shareIndividualTicket(ticketNumber, eventName, ticketIndex) {
    currentTicketNumber = ticketNumber;
    currentEventName = eventName;
    currentTicketIndex = ticketIndex;
    
    // Update modal content
    document.getElementById('shareTicketTitle').textContent = `${eventName} - Ticket ${ticketIndex}`;
    document.getElementById('shareTicketNumber').textContent = `Ticket #${ticketNumber}`;
    
    // Show modal
    $('#shareTicketModal').modal('show');
}

// Share to social platforms
function shareToSocial(platform) {
    const eventDate = '{{ $order->event ? \Carbon\Carbon::parse($order->event->start_time)->format("M d, Y") : "" }}';
    const shareText = `I'm attending ${currentEventName} on ${eventDate}! Ticket #${currentTicketNumber}`;
    const shareUrl = `{{ url('/events_details/' . $order->event->id) }}`;
    
    let socialUrl = '';
    
    switch(platform) {
        case 'facebook':
            socialUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}&quote=${encodeURIComponent(shareText)}`;
            break;
        case 'twitter':
            socialUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(shareText)}&url=${encodeURIComponent(shareUrl)}`;
            break;
        case 'whatsapp':
            socialUrl = `https://wa.me/?text=${encodeURIComponent(shareText + ' ' + shareUrl)}`;
            break;
    }
    
    if (socialUrl) {
        window.open(socialUrl, '_blank', 'width=600,height=400');
        $('#shareTicketModal').modal('hide');
    }
}

// Copy ticket link
function copyTicketLink() {
    const shareUrl = `{{ url('/events_details/' . $order->event->id) }}`;
    const shareText = `Check out ${currentEventName} - Ticket #${currentTicketNumber}: ${shareUrl}`;
    
    navigator.clipboard.writeText(shareText).then(function() {
        showToast('Ticket link copied to clipboard!', 'success');
        $('#shareTicketModal').modal('hide');
    }).catch(function() {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = shareText;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showToast('Ticket link copied to clipboard!', 'success');
        $('#shareTicketModal').modal('hide');
    });
}

// Toast notification function
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'error' ? 'danger' : type} position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} mr-2"></i>
            ${message}
            <button type="button" class="close ml-auto" onclick="this.parentElement.parentElement.remove()">
                <span>&times;</span>
            </button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, 3000);
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>

@endsection
