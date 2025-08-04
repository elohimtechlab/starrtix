<!-- Event Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle mr-2"></i>
                    Event Created Successfully!
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <!-- Preview Mode Header -->
                <div id="preview-mode-header" class="text-center mb-4">
                    <h3 class="text-primary">
                        <i class="fas fa-eye mr-2"></i>
                        Preview Your Event
                    </h3>
                    <p class="text-muted">Review your event details before publishing</p>
                </div>
                
                <!-- Success Animation (hidden initially) -->
                <div id="success-mode-header" class="text-center mb-4" style="display: none;">
                    <div class="success-celebration">
                        <i class="fas fa-trophy text-warning" style="font-size: 3rem;"></i>
                        <h3 class="mt-2 text-success">🎉 Event Created Successfully! 🎉</h3>
                        <p class="text-muted">Your event is now live and ready to share with the world!</p>
                    </div>
                </div>

                <div class="event-preview-content">
                    <div class="row">
                        <!-- Event Details Column -->
                        <div class="col-md-8">
                            <div class="event-card border rounded p-4 bg-light">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="preview-image">
                                            <img id="preview-event-image" src="" alt="Event Image" class="img-fluid rounded shadow" style="display: none;">
                                            <div id="preview-image-placeholder" class="text-center p-3 bg-white rounded border">
                                                <i class="fas fa-image fa-2x text-muted"></i>
                                                <p class="text-muted mt-2 mb-0">Event Image</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="preview-details">
                                            <h4 id="preview-title" class="mb-3 text-primary">Event Title</h4>
                                            <div class="preview-info">
                                                <div class="info-item mb-2 d-flex align-items-center">
                                                    <i class="fas fa-tag text-success mr-2"></i>
                                                    <strong class="mr-2">Category:</strong> 
                                                    <span id="preview-category" class="badge badge-primary">-</span>
                                                </div>
                                                <div class="info-item mb-2 d-flex align-items-center">
                                                    <i class="fas fa-credit-card text-success mr-2"></i>
                                                    <strong class="mr-2">Type:</strong> 
                                                    <span id="preview-type" class="badge badge-info">-</span>
                                                </div>
                                                <div class="info-item mb-2 d-flex align-items-center">
                                                    <i class="fas fa-map-marker-alt text-success mr-2"></i>
                                                    <strong class="mr-2">Location:</strong> 
                                                    <span id="preview-address">-</span>
                                                </div>
                                                <div class="info-item mb-2 d-flex align-items-center">
                                                    <i class="fas fa-calendar text-success mr-2"></i>
                                                    <strong class="mr-2">Date:</strong> 
                                                    <span id="preview-date">-</span>
                                                </div>
                                                <div class="info-item mb-2 d-flex align-items-center">
                                                    <i class="fas fa-clock text-success mr-2"></i>
                                                    <strong class="mr-2">Time:</strong> 
                                                    <span id="preview-time">-</span>
                                                </div>
                                                <div class="info-item mb-2 d-flex align-items-center">
                                                    <i class="fas fa-dollar-sign text-success mr-2"></i>
                                                    <strong class="mr-2">Price:</strong> 
                                                    <span id="preview-price" class="badge badge-success">-</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- QR Code Column -->
                        <div class="col-md-4">
                            <div class="qr-section text-center">
                                <div class="qr-card border rounded p-4 bg-white shadow-sm">
                                    <h5 class="mb-3 text-primary">
                                        <i class="fas fa-qrcode mr-2"></i>
                                        Event QR Code
                                    </h5>
                                    <div id="qr-code-container" class="mb-3">
                                        <div id="qr-placeholder" class="p-4 bg-light rounded">
                                            <i class="fas fa-qrcode fa-3x text-muted"></i>
                                            <p class="text-muted mt-2 mb-0">QR Code will appear here</p>
                                        </div>
                                        <canvas id="qr-canvas" style="display: none;"></canvas>
                                    </div>
                                    <p class="small text-muted mb-0">Scan to view event details</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <!-- Preview Mode Footer (before event creation) -->
                <div id="preview-mode-footer" class="w-100 text-center">
                    <button type="button" class="btn btn-outline-secondary mr-3" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> Close
                    </button>
                    <button type="button" class="btn btn-primary btn-lg" onclick="submitEventForm()">
                        <i class="fas fa-upload mr-2"></i> Upload Event
                    </button>
                </div>
                
                <!-- Success Mode Footer (after event creation) -->
                <div id="success-mode-footer" class="w-100" style="display: none;">
                    <!-- Sharing Section -->
                    <div class="mb-3">
                        <h6 class="text-center mb-3">
                            <i class="fas fa-share-alt mr-2"></i>
                            Share Your Event
                        </h6>
                        <div class="d-flex justify-content-center flex-wrap">
                            <button type="button" class="btn btn-facebook btn-sm mr-2 mb-2" onclick="shareOnFacebook()">
                                <i class="fab fa-facebook-f mr-1"></i> Facebook
                            </button>
                            <button type="button" class="btn btn-info btn-sm mr-2 mb-2" onclick="shareOnTwitter()">
                                <i class="fab fa-twitter mr-1"></i> Twitter
                            </button>
                            <button type="button" class="btn btn-success btn-sm mr-2 mb-2" onclick="shareOnWhatsApp()">
                                <i class="fab fa-whatsapp mr-1"></i> WhatsApp
                            </button>
                            <button type="button" class="btn btn-warning btn-sm mr-2 mb-2" onclick="copyEventLink()">
                                <i class="fas fa-link mr-1"></i> Copy Link
                            </button>
                            <button type="button" class="btn btn-dark btn-sm mb-2" onclick="downloadQRCode()">
                                <i class="fas fa-download mr-1"></i> Download QR
                            </button>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="text-center">
                        <button type="button" class="btn btn-outline-secondary mr-3" data-dismiss="modal">
                            <i class="fas fa-times mr-2"></i> Close
                        </button>
                        <a href="{{ url('events') }}" class="btn btn-primary">
                            <i class="fas fa-list mr-2"></i> View All Events
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load QR Code library -->
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>

<script>
let currentEventData = {};

// Wait for QR code library to load
function waitForQRCode(callback) {
    if (typeof QRCode !== 'undefined' || typeof qrcode !== 'undefined') {
        callback();
    } else {
        setTimeout(() => waitForQRCode(callback), 100);
    }
}

function resetModalToPreviewMode() {
    // Reset to preview mode
    document.getElementById('preview-mode-header').style.display = 'block';
    document.getElementById('success-mode-header').style.display = 'none';
    document.getElementById('preview-mode-footer').style.display = 'block';
    document.getElementById('success-mode-footer').style.display = 'none';
    
    // Reset QR code area
    document.getElementById('qr-canvas').style.display = 'none';
    document.getElementById('qr-placeholder').style.display = 'block';
}

function showPreview() {
    // Reset modal to preview mode
    resetModalToPreviewMode();
    
    // Get form data
    const title = document.getElementById('event-title').value || 'Untitled Event';
    const category = document.getElementById('event-category').selectedOptions[0]?.text || 'No category';
    const type = document.querySelector('input[name="type"]:checked')?.value || 'Not specified';
    const address = document.getElementById('address').value || 'No address specified';
    const startDateTime = document.getElementById('start_time').value || '';
    const endDateTime = document.getElementById('end_time').value || '';
    const price = document.getElementById('price').value || 'Free';
    const currency = document.querySelector('select[name="currency"]').value || '';
    
    // Store event data for sharing
    currentEventData = {
        title,
        category,
        type,
        address,
        startDateTime,
        endDateTime,
        price,
        currency
    };
    
    // Update preview content
    document.getElementById('preview-title').textContent = title;
    document.getElementById('preview-category').textContent = category;
    document.getElementById('preview-type').textContent = type.charAt(0).toUpperCase() + type.slice(1);
    document.getElementById('preview-address').textContent = address;
    // Format datetime for display
    const startDate = startDateTime ? new Date(startDateTime).toLocaleDateString() : 'Not specified';
    const startTime = startDateTime ? new Date(startDateTime).toLocaleTimeString() : '';
    const endTime = endDateTime ? new Date(endDateTime).toLocaleTimeString() : '';
    
    document.getElementById('preview-date').textContent = startDate;
    document.getElementById('preview-time').textContent = startTime && endTime ? `${startTime} - ${endTime}` : 'Not specified';
    document.getElementById('preview-price').textContent = price !== 'Free' ? `${currency} ${price}` : 'Free';
    
    // Handle image preview
    const imageInput = document.getElementById('main-image');
    const previewImage = document.getElementById('preview-event-image');
    const imagePlaceholder = document.getElementById('preview-image-placeholder');
    
    if (imageInput.files && imageInput.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewImage.style.display = 'block';
            imagePlaceholder.style.display = 'none';
        };
        reader.readAsDataURL(imageInput.files[0]);
    } else {
        previewImage.style.display = 'none';
        imagePlaceholder.style.display = 'block';
    }
    
    // Show modal
    $('#previewModal').modal('show');
}

function showEventCreatedSuccess(eventData) {
    // Update preview with created event data
    currentEventData = eventData;
    
    // Update event details
    document.getElementById('preview-title').textContent = eventData.name || 'Event';
    document.getElementById('preview-category').textContent = eventData.category || 'General';
    document.getElementById('preview-type').textContent = (eventData.type || 'paid').charAt(0).toUpperCase() + (eventData.type || 'paid').slice(1);
    document.getElementById('preview-address').textContent = eventData.address || 'Location TBD';
    document.getElementById('preview-date').textContent = eventData.start_time ? new Date(eventData.start_time).toLocaleDateString() : 'Date TBD';
    document.getElementById('preview-time').textContent = eventData.start_time && eventData.end_time ? 
        `${new Date(eventData.start_time).toLocaleTimeString()} - ${new Date(eventData.end_time).toLocaleTimeString()}` : 'Time TBD';
    document.getElementById('preview-price').textContent = eventData.type === 'free' ? 'Free' : `${eventData.currency || 'USD'} ${eventData.price || '0'}`;
    
    // Switch to success mode
    document.getElementById('preview-mode-header').style.display = 'none';
    document.getElementById('success-mode-header').style.display = 'block';
    document.getElementById('preview-mode-footer').style.display = 'none';
    document.getElementById('success-mode-footer').style.display = 'block';
    
    // Generate QR Code
    generateQRCode(eventData);
}

function generateQRCode(eventData) {
    // Use the correct frontend route for event details
    const eventUrl = `${window.location.origin}/events/${eventData.id}`;
    console.log('Generating QR code for:', eventUrl);
    
    const canvas = document.getElementById('qr-canvas');
    const placeholder = document.getElementById('qr-placeholder');
    
    // Wait for QR code library to load
    waitForQRCode(() => {
        try {
            // Try using the QRCode library first
            if (typeof QRCode !== 'undefined' && QRCode.toCanvas) {
                QRCode.toCanvas(canvas, eventUrl, {
                    width: 200,
                    height: 200,
                    colorDark: '#000000',
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.M
                }, function (error) {
                    if (error) {
                        console.error('QR Code generation failed:', error);
                        generateFallbackQR(eventUrl, canvas, placeholder);
                        return;
                    }
                    
                    // Show QR code, hide placeholder
                    canvas.style.display = 'block';
                    placeholder.style.display = 'none';
                });
            } else {
                // Fallback to alternative QR generation
                generateFallbackQR(eventUrl, canvas, placeholder);
            }
        } catch (error) {
            console.error('QR Code generation error:', error);
            generateFallbackQR(eventUrl, canvas, placeholder);
        }
    });
}

function generateFallbackQR(eventUrl, canvas, placeholder) {
    try {
        // Use alternative QR code generation or API
        const qrApiUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(eventUrl)}`;
        
        // Create an image element instead of canvas
        const img = document.createElement('img');
        img.src = qrApiUrl;
        img.style.width = '200px';
        img.style.height = '200px';
        img.style.borderRadius = '8px';
        img.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
        
        // Replace canvas with image
        canvas.style.display = 'none';
        placeholder.innerHTML = '';
        placeholder.appendChild(img);
        placeholder.style.display = 'block';
        
        console.log('Using fallback QR code generation');
    } catch (error) {
        console.error('Fallback QR generation failed:', error);
        placeholder.innerHTML = `
            <div class="text-center p-3">
                <i class="fas fa-qrcode fa-2x text-muted mb-2"></i>
                <p class="text-muted mb-1">QR Code</p>
                <small class="text-muted">Event ID: ${eventData.id || 'N/A'}</small>
            </div>
        `;
    }
}

// Sharing Functions
function shareOnFacebook() {
    const eventUrl = `${window.location.origin}/events/${currentEventData.id || 'preview'}`;
    const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(eventUrl)}&quote=${encodeURIComponent('Check out this amazing event: ' + currentEventData.title)}`;
    window.open(shareUrl, '_blank', 'width=600,height=400');
}

function shareOnTwitter() {
    const eventUrl = `${window.location.origin}/events/${currentEventData.id || 'preview'}`;
    const eventDate = currentEventData.startDateTime ? new Date(currentEventData.startDateTime).toLocaleDateString() : 'TBD';
    const tweetText = `🎉 Join me at ${currentEventData.title}! 📅 ${eventDate} 📍 ${currentEventData.address}`;
    const shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(tweetText)}&url=${encodeURIComponent(eventUrl)}`;
    window.open(shareUrl, '_blank', 'width=600,height=400');
}

function shareOnWhatsApp() {
    const eventUrl = `${window.location.origin}/events/${currentEventData.id || 'preview'}`;
    const eventDate = currentEventData.startDateTime ? new Date(currentEventData.startDateTime).toLocaleDateString() : 'TBD';
    const startTime = currentEventData.startDateTime ? new Date(currentEventData.startDateTime).toLocaleTimeString() : 'TBD';
    const endTime = currentEventData.endDateTime ? new Date(currentEventData.endDateTime).toLocaleTimeString() : 'TBD';
    const message = `🎉 *${currentEventData.title}*\n\n📅 Date: ${eventDate}\n⏰ Time: ${startTime} - ${endTime}\n📍 Location: ${currentEventData.address}\n💰 Price: ${currentEventData.price === 'Free' ? 'Free' : currentEventData.currency + ' ' + currentEventData.price}\n\nJoin me at this amazing event!\n${eventUrl}`;
    const shareUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;
    window.open(shareUrl, '_blank');
}

function copyEventLink() {
    const eventUrl = `${window.location.origin}/events/${currentEventData.id || 'preview'}`;
    navigator.clipboard.writeText(eventUrl).then(function() {
        // Show success message
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check mr-1"></i> Copied!';
        btn.classList.add('btn-success');
        btn.classList.remove('btn-warning');
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-warning');
        }, 2000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        alert('Failed to copy link. Please copy manually: ' + eventUrl);
    });
}

function downloadQRCode() {
    const canvas = document.getElementById('qr-canvas');
    const placeholder = document.getElementById('qr-placeholder');
    
    // Try to download from canvas first
    if (canvas.style.display !== 'none') {
        try {
            const link = document.createElement('a');
            link.download = `${currentEventData.title || 'event'}-qrcode.png`;
            link.href = canvas.toDataURL();
            link.click();
            return;
        } catch (error) {
            console.error('Canvas download failed:', error);
        }
    }
    
    // Try to download from image in placeholder
    const img = placeholder.querySelector('img');
    if (img) {
        try {
            const link = document.createElement('a');
            link.download = `${currentEventData.title || 'event'}-qrcode.png`;
            link.href = img.src;
            link.target = '_blank';
            link.click();
            return;
        } catch (error) {
            console.error('Image download failed:', error);
        }
    }
    
    // Fallback: generate new QR code for download
    if (currentEventData.id) {
        const eventUrl = `${window.location.origin}/events/${currentEventData.id}`;
        const qrApiUrl = `https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=${encodeURIComponent(eventUrl)}&download=1`;
        
        const link = document.createElement('a');
        link.download = `${currentEventData.title || 'event'}-qrcode.png`;
        link.href = qrApiUrl;
        link.target = '_blank';
        link.click();
    } else {
        alert('QR Code not available for download.');
    }
}

function submitEventForm() {
    // Get the form
    const form = document.querySelector('.event-wizard-form');
    const formData = new FormData(form);
    
    // Show loading state on upload button
    const uploadBtn = document.querySelector('#preview-mode-footer .btn-primary');
    const originalText = uploadBtn.innerHTML;
    uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Creating Event...';
    uploadBtn.disabled = true;
    
    // Submit form via AJAX
    $.ajax({
        url: form.action,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                // Show success mode with event data and QR code
                showEventCreatedSuccess(response.event);
            }
        },
        error: function(xhr) {
            console.error('Error creating event:', xhr.responseText);
            let errorMessage = 'Error creating event. Please try again.';
            
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = xhr.responseJSON.errors;
                errorMessage = Object.values(errors).flat().join('\n');
            }
            
            alert(errorMessage);
            
            // Reset button
            uploadBtn.innerHTML = originalText;
            uploadBtn.disabled = false;
        }
    });
}
</script>
