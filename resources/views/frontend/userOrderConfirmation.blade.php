@extends('user-master')

@section('content')
    <!-- Success Animation Overlay -->
    <div id="success-overlay" class="success-overlay">
        <div class="success-animation">
            <div class="checkmark-container">
                <div class="checkmark">
                    <div class="checkmark-circle"></div>
                    <div class="checkmark-stem"></div>
                    <div class="checkmark-kick"></div>
                </div>
            </div>
            <h2 class="success-title">Booking Successful!</h2>
            <p class="success-subtitle">Your tickets have been confirmed</p>
            <div class="confetti"></div>
        </div>
    </div>

    <section class="section">
        <div class="section-header animated-header">
            <h1><i class="fas fa-check-circle text-success pulse-icon"></i> {{ __('Booking Confirmation') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('userDashboard') }}">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ __('Booking Confirmation') }}</div>
            </div>
        </div>

        <div class="section-body">
            @if(isset($order) && $order->event)
                <!-- Main Content -->
                <div class="row animated-content">
                    <!-- Event Details Column -->
                    <div class="col-lg-8">
                        <!-- Event Details Card -->
                        <div class="card border rounded p-4 bg-white mb-4 slide-in-left">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ url('images/upload/'.$order->event->image) }}" 
                                         class="img-fluid rounded shadow-sm" 
                                         alt="{{ $order->event->name }}"
                                         style="height: 200px; width: 100%; object-fit: cover;">
                                </div>
                                <div class="col-md-8">
                                    <div class="event-info">
                                        <h3 class="text-primary mb-3">{{ $order->event->name }}</h3>
                                        
                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <div class="info-item">
                                                    <i class="fas fa-tag text-muted mr-2"></i>
                                                    <span class="text-muted">{{ __('Category:') }}</span>
                                                    <span class="badge badge-info ml-2">{{ $order->event->category->name ?? __('General') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item">
                                                    <i class="fas fa-globe text-muted mr-2"></i>
                                                    <span class="text-muted">{{ __('Type:') }}</span>
                                                    <span class="badge badge-secondary ml-2">{{ ucfirst($order->event->type) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <div class="info-item">
                                                    <i class="fas fa-map-marker-alt text-muted mr-2"></i>
                                                    <span class="text-muted">{{ __('Location:') }}</span>
                                                    <span class="ml-2">{{ $order->event->address }}</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item">
                                                    <i class="fas fa-users text-muted mr-2"></i>
                                                    <span class="text-muted">{{ __('Capacity:') }}</span>
                                                    <span class="badge badge-warning ml-2">{{ $order->event->people }} {{ __('people') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <div class="info-item">
                                                    <i class="fas fa-calendar text-muted mr-2"></i>
                                                    <span class="text-muted">{{ __('Date:') }}</span>
                                                    <span class="ml-2">{{ \Carbon\Carbon::parse($order->event->start_time)->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item">
                                                    <i class="fas fa-clock text-muted mr-2"></i>
                                                    <span class="text-muted">{{ __('Time:') }}</span>
                                                    <span class="ml-2">{{ \Carbon\Carbon::parse($order->event->start_time)->format('h:i A') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="info-item">
                                                    <i class="fas fa-building text-muted mr-2"></i>
                                                    <span class="text-muted">{{ __('Organizer:') }}</span>
                                                    <a href="{{ url('/organization/' . $order->organization->id . '/' . $order->organization->name) }}" class="text-primary ml-2">
                                                        {{ $order->organization->name }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Event Description -->
                            @if($order->event->description)
                            <div class="mt-4 pt-3 border-top">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    {{ __('Event Description') }}
                                </h6>
                                <p class="text-muted mb-0">{{ strip_tags($order->event->description) }}</p>
                            </div>
                            @endif
                        </div>
                        
                        <!-- QR Code & Sharing Card -->
                        <div class="card border rounded p-4 bg-white mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Order QR Code -->
                                    <div class="qr-section">
                                        <h6 class="text-muted mb-3">
                                            <i class="fas fa-qrcode mr-2"></i>{{ __('Order QR Code') }}
                                        </h6>
                                        <div class="text-center">
                                            <div id="qr-code-container" class="mb-3">
                                                <canvas id="qr-canvas" style="display: none;"></canvas>
                                                <div id="qr-placeholder" class="bg-light border rounded p-3">
                                                    <i class="fas fa-qrcode text-muted" style="font-size: 3rem;"></i>
                                                    <p class="text-muted mt-2 mb-0 small">{{ __('Generating QR Code...') }}</p>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="downloadOrderQR()">
                                                <i class="fas fa-download mr-1"></i>{{ __('Download QR') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Share Event -->
                                    <div class="sharing-section">
                                        <h6 class="text-muted mb-3">
                                            <i class="fas fa-share-alt mr-2"></i>{{ __('Share Event') }}
                                        </h6>
                                        <div class="sharing-buttons">
                                            <button type="button" class="btn btn-facebook btn-sm btn-block mb-2" onclick="shareOnFacebook()">
                                                <i class="fab fa-facebook-f mr-2"></i>{{ __('Facebook') }}
                                            </button>
                                            <button type="button" class="btn btn-info btn-sm btn-block mb-2" onclick="shareOnTwitter()">
                                                <i class="fab fa-twitter mr-2"></i>{{ __('Twitter') }}
                                            </button>
                                            <button type="button" class="btn btn-success btn-sm btn-block mb-2" onclick="shareOnWhatsApp()">
                                                <i class="fab fa-whatsapp mr-2"></i>{{ __('WhatsApp') }}
                                            </button>
                                            <button type="button" class="btn btn-secondary btn-sm btn-block" onclick="copyEventLink()">
                                                <i class="fas fa-copy mr-2"></i>{{ __('Copy Link') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Your Tickets Section -->
                    <div class="col-lg-4">
                        <div class="card border rounded">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-ticket-alt mr-2"></i>{{ __('Your Tickets') }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Order Information -->
                                <div class="ticket-details mb-4">
                                    <div class="row mb-3">
                                        <div class="col-sm-5"><strong>{{ __('Order ID:') }}</strong></div>
                                        <div class="col-sm-7">
                                            <span class="badge badge-primary">{{ $order->order_id }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-5"><strong>{{ __('Ticket Type:') }}</strong></div>
                                        <div class="col-sm-7">{{ $order->ticket->name ?? __('General Admission') }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-5"><strong>{{ __('Quantity:') }}</strong></div>
                                        <div class="col-sm-7">
                                            <span class="badge badge-success">{{ $order->quantity }} {{ __('tickets') }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-5"><strong>{{ __('Total Amount:') }}</strong></div>
                                        <div class="col-sm-7">
                                            <span class="h6 text-success mb-0">
                                                {{ App\Models\Setting::find(1)->currency_symbol }}{{ number_format($order->payment, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-5"><strong>{{ __('Status:') }}</strong></div>
                                        <div class="col-sm-7">
                                            <span class="badge badge-success">{{ __('Confirmed') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ticket Validity -->
                                <div class="ticket-validity mb-4">
                                    <div class="row">
                                        <div class="col-sm-5"><strong>{{ __('Valid:') }}</strong></div>
                                        <div class="col-sm-7">
                                            @if ($order->ticket_date != '')
                                                {{ Carbon\Carbon::parse($order->ticket_date)->format('M d, Y') }}
                                            @else
                                                {{ Carbon\Carbon::parse($order->event->start_time)->format('M d, Y') }} - {{ Carbon\Carbon::parse($order->event->end_time)->format('M d, Y') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Success Confirmation -->
                                <div class="text-center mb-4">
                                    <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-2">{{ __('Booking Confirmed') }}</p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="action-buttons">
                                    <a href="{{ url('order-invoice-print/' . $order->id) }}" target="_blank" class="btn btn-outline-success btn-block mb-2">
                                        <i class="fas fa-print mr-2"></i>{{ __('Print Tickets') }}
                                    </a>
                                    <a href="{{ route('downloadTicket', $order->id) }}" class="btn btn-success btn-block mb-2">
                                        <i class="fas fa-download mr-2"></i>{{ __('Download Tickets') }}
                                    </a>
                                    <a href="{{ url('/starrtix/events/' . $order->event->id) }}" class="btn btn-outline-primary btn-block mb-2">
                                        <i class="fas fa-eye mr-2"></i>{{ __('View Event') }}
                                    </a>
                                    <a href="{{ url('/starrtix/events/' . $order->event->id) }}" class="btn btn-primary btn-block">
                                        <i class="fas fa-redo mr-2"></i>{{ __('Book Again') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- What's Next Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <!-- What's Next -->
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
                @else
                    <!-- Error State -->
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center p-5">
                                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                                    <h3 class="mt-3 mb-3">{{ __('Order Not Found') }}</h3>
                                    <p class="text-muted mb-4">{{ __('We couldn\'t retrieve your order details. Please try again or contact support.') }}</p>
                                    <a href="{{ route('userOrders') }}" class="btn btn-primary">
                                        <i class="fas fa-list mr-2"></i>{{ __('View My Orders') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('script')
<!-- Load QR Code library -->
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(isset($order) && $order->event)
    // Event data for JavaScript
    const eventData = {
        id: {{ $order->event->id }},
        name: {!! json_encode($order->event->name) !!},
        url: '{{ url("/events/" . $order->event->id) }}',
        description: {!! json_encode(strip_tags($order->event->description ?? '')) !!}
    };
    
    const orderData = {
        id: {{ $order->id }},
        order_id: '{{ $order->order_id }}',
        url: '{{ route("userOrderConfirmation", $order->id) }}'
    };
    
    // Show success animation on page load
    showSuccessAnimation();
    
    // Generate QR Code for order
    generateOrderQR();
    @endif
});

function showSuccessAnimation() {
    const overlay = document.getElementById('success-overlay');
    const checkmark = document.querySelector('.checkmark');
    
    if (overlay && checkmark) {
        // Show the overlay
        overlay.style.display = 'flex';
        
        // Animate the checkmark
        setTimeout(() => {
            checkmark.classList.add('animate-checkmark');
        }, 500);
        
        // Create confetti effect
        createConfetti();
        
        // Hide overlay after animation
        setTimeout(() => {
            overlay.style.opacity = '0';
            setTimeout(() => {
                overlay.style.display = 'none';
            }, 500);
        }, 3000);
    }
}

function createConfetti() {
    const colors = ['#f39c12', '#e74c3c', '#9b59b6', '#3498db', '#2ecc71', '#1abc9c'];
    const confettiContainer = document.querySelector('.success-animation');
    
    for (let i = 0; i < 50; i++) {
        const confetti = document.createElement('div');
        confetti.className = 'confetti-piece';
        confetti.style.cssText = `
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: ${colors[Math.floor(Math.random() * colors.length)]};
            left: ${Math.random() * 100}%;
            animation: confettiFall ${2 + Math.random() * 3}s linear forwards;
            animation-delay: ${Math.random() * 2}s;
        `;
        confettiContainer.appendChild(confetti);
        
        // Remove confetti after animation
        setTimeout(() => {
            if (confetti.parentNode) {
                confetti.parentNode.removeChild(confetti);
            }
        }, 5000);
    }
}

function generateOrderQR() {
    const canvas = document.getElementById('qr-canvas');
    const placeholder = document.getElementById('qr-placeholder');
    
    if (!canvas || !placeholder) return;
    
    try {
        // Try using QRCode library first
        if (typeof QRCode !== 'undefined') {
            QRCode.toCanvas(canvas, orderData.url, {
                width: 200,
                height: 200,
                colorDark: '#000000',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.M
            }, function (error) {
                if (error) {
                    console.error('QR Code generation error:', error);
                    fallbackQRGeneration();
                } else {
                    // Show canvas and hide placeholder
                    canvas.style.display = 'block';
                    placeholder.style.display = 'none';
                }
            });
        } else {
            fallbackQRGeneration();
        }
    } catch (error) {
        console.error('QR Code library error:', error);
        fallbackQRGeneration();
    }
}

function fallbackQRGeneration() {
    const placeholder = document.getElementById('qr-placeholder');
    if (placeholder) {
        // Use external QR code API as fallback
        const qrApiUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(orderData.url)}`;
        placeholder.innerHTML = `
            <img src="${qrApiUrl}" alt="Order QR Code" class="img-fluid" style="max-width: 200px;">
            <p class="text-muted mt-2 mb-0">{{ __('Order QR Code') }}</p>
        `;
    }
}

function downloadOrderQR() {
    const canvas = document.getElementById('qr-canvas');
    const placeholder = document.getElementById('qr-placeholder');
    
    // Try to download from canvas first
    if (canvas && canvas.style.display !== 'none') {
        try {
            const link = document.createElement('a');
            link.download = `order-${orderData.order_id}-qr.png`;
            link.href = canvas.toDataURL();
            link.click();
            return;
        } catch (error) {
            console.error('Canvas download error:', error);
        }
    }
    
    // Fallback: download from API
    const qrApiUrl = `https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=${encodeURIComponent(orderData.url)}`;
    const link = document.createElement('a');
    link.download = `order-${orderData.order_id}-qr.png`;
    link.href = qrApiUrl;
    link.target = '_blank';
    link.click();
}

// Sharing functions
function shareOnFacebook() {
    const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(eventData.url)}`;
    window.open(url, '_blank', 'width=600,height=400');
}

function shareOnTwitter() {
    const text = `Check out this amazing event: ${eventData.name}`;
    const url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(eventData.url)}`;
    window.open(url, '_blank', 'width=600,height=400');
}

function shareOnWhatsApp() {
    const text = `Check out this amazing event: ${eventData.name} ${eventData.url}`;
    const url = `https://wa.me/?text=${encodeURIComponent(text)}`;
    window.open(url, '_blank');
}

function copyEventLink() {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(eventData.url).then(function() {
            // Show success message
            showToast('{{ __("Event link copied to clipboard!") }}', 'success');
        }).catch(function(error) {
            console.error('Copy failed:', error);
            fallbackCopyToClipboard(eventData.url);
        });
    } else {
        fallbackCopyToClipboard(eventData.url);
    }
}

function fallbackCopyToClipboard(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
        showToast('{{ __("Event link copied to clipboard!") }}', 'success');
    } catch (error) {
        console.error('Fallback copy failed:', error);
        showToast('{{ __("Failed to copy link. Please copy manually.") }}', 'error');
    }
    document.body.removeChild(textArea);
}

function showToast(message, type = 'info') {
    // Create toast notification
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 3000);
}
</script>

<style>
/* Success Animation Overlay */
.success-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(52, 152, 219, 0.95), rgba(41, 128, 185, 0.95));
    z-index: 9999;
    display: none;
    justify-content: center;
    align-items: center;
    transition: opacity 0.5s ease;
}

.success-animation {
    text-align: center;
    position: relative;
    animation: bounceIn 1s ease-out;
}

.checkmark-container {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 20px;
}

.checkmark {
    position: relative;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: #fff;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
}

.checkmark.animate-checkmark::before {
    content: '✓';
    font-size: 60px;
    color: #3498db;
    font-weight: bold;
    animation: checkmarkPop 0.6s ease-out 0.5s both;
}

.success-title {
    font-size: 32px;
    font-weight: bold;
    color: #fff;
    margin: 20px 0 10px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    animation: fadeInUp 0.8s ease-out 0.8s both;
}

.success-subtitle {
    font-size: 18px;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0;
    animation: fadeInUp 0.8s ease-out 1s both;
}

/* Pulse animation for header icon */
.pulse-icon {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

@keyframes bounceIn {
    0% {
        opacity: 0;
        transform: scale(0.3);
    }
    50% {
        opacity: 1;
        transform: scale(1.05);
    }
    70% {
        transform: scale(0.9);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes checkmarkPop {
    0% {
        opacity: 0;
        transform: scale(0);
    }
    50% {
        opacity: 1;
        transform: scale(1.2);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes confettiFall {
    0% {
        opacity: 1;
        transform: translateY(-100px) rotate(0deg);
    }
    100% {
        opacity: 0;
        transform: translateY(100vh) rotate(720deg);
    }
}

.animated-header {
    animation: fadeInDown 1s ease-out 3.5s both;
}

.animated-content {
    animation: fadeInUp 1s ease-out 3.8s both;
}

@keyframes fadeInDown {
    0% {
        opacity: 0;
        transform: translateY(-50px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(50px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.slide-in-left {
    animation: slideInLeft 1.2s ease-out 4s both;
}

@keyframes slideInLeft {
    0% {
        opacity: 0;
        transform: translateX(-100px);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Additional card animations */
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

/* Button hover animations */
.btn {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn:hover::before {
    left: 100%;
}

/* Step icons animation */
.step-icon {
    transition: all 0.3s ease;
}

.step-icon:hover {
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}
</style>
@endsection
