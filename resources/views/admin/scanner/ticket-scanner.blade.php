@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => __('Ticket Scanner'),
    ])

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-qrcode mr-2"></i>{{ __('Scan Event Tickets') }}</h4>
                    </div>
                    <div class="card-body">
                        <!-- Event Selection -->
                        <div class="row justify-content-center mb-4">
                            <div class="col-12 col-md-8 col-lg-6 mb-3">
                                <label for="event_select" class="form-label"><strong>{{ __('Select Event') }}</strong></label>
                                <select id="event_select" class="form-control">
                                    <option value="">{{ __('Choose an event to scan tickets for...') }}</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}">
                                            {{ $event->name }} - {{ date('M j, Y', strtotime($event->start_time)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-8 col-lg-6">
                                <div id="scanner_status" class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle mr-2"></i>{{ __('Please select an event to start scanning') }}
                                </div>
                            </div>
                        </div>

                        <!-- Scanning Interface -->
                        <div id="scanning_interface" style="display: none;">
                            <div class="row justify-content-center">
                                <!-- Manual Input -->
                                <div class="col-12 col-md-6 col-lg-5 mb-3">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="mb-0"><i class="fas fa-keyboard mr-2"></i>{{ __('Manual Entry') }}</h6>
                                        </div>
                                        <div class="card-body">
                                            <form id="scan_form">
                                                @csrf
                                                <input type="hidden" id="selected_event_id" name="event_id">
                                                <div class="form-group mb-3">
                                                    <label for="ticket_code" class="form-label">{{ __('Ticket Code') }}</label>
                                                    <input type="text" 
                                                           id="ticket_code" 
                                                           name="ticket_code" 
                                                           class="form-control" 
                                                           placeholder="{{ __('Enter ticket code...') }}"
                                                           autocomplete="off">
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100" id="scan_btn">
                                                    <i class="fas fa-search mr-2"></i>{{ __('Scan Ticket') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- QR Code Scanner -->
                                <div class="col-12 col-md-6 col-lg-5">
                                    <div class="card border-success">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="mb-0"><i class="fas fa-camera mr-2"></i>{{ __('QR Code Scanner') }}</h6>
                                        </div>
                                        <div class="card-body text-center">
                                            <div id="qr_reader" class="d-flex align-items-center justify-content-center" style="width: 100%; height: 200px; border: 2px dashed #28a745; border-radius: 8px; background: #f8f9fa;">
                                                <div class="p-2">
                                                    <i class="fas fa-qrcode fa-2x text-muted mb-2 d-block"></i>
                                                    <p class="text-muted mb-2 small">{{ __('Click "Start Camera" to scan QR codes') }}</p>
                                                    <button type="button" class="btn btn-success" id="start_camera_btn">
                                                        <i class="fas fa-camera mr-2"></i>{{ __('Start Camera') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Scan Results -->
                        <div id="scan_results" class="mt-4" style="display: none;">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-clipboard-check mr-2"></i>{{ __('Scan Results') }}</h6>
                                </div>
                                <div class="card-body" id="result_content">
                                    <!-- Results will be populated here -->
                                </div>
                            </div>
                        </div>

                        <!-- Scan History -->
                        <div id="scan_history" class="mt-4" style="display: none;">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-history mr-2"></i>{{ __('Recent Scans') }}</h6>
                                    <button type="button" class="btn btn-sm btn-outline-secondary float-right" id="clear_history_btn">
                                        {{ __('Clear History') }}
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div id="history_list">
                                        <!-- History items will be populated here -->
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

<!-- Include QR Code Scanner Library -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<style>
.scan-result-valid {
    border-left: 5px solid #28a745;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.scan-result-used {
    border-left: 5px solid #ffc107;
    background-color: #fff3cd;
    border-color: #ffeaa7;
}

.scan-result-limit-reached {
    border-left: 5px solid #fd7e14;
    background-color: #ffeaa7;
    border-color: #ffc107;
}

.scan-result-invalid {
    border-left: 5px solid #dc3545;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.history-item {
    border-bottom: 1px solid #eee;
    padding: 10px 0;
}

.history-item:last-child {
    border-bottom: none;
}
.ticket-code {
    font-family: 'Courier New', monospace;
    font-weight: bold;
    background: #f8f9fa;
    padding: 2px 6px;
    border-radius: 4px;
}
</style>

<script>
$(document).ready(function() {
    let html5QrCode = null;
    let scanHistory = JSON.parse(localStorage.getItem('scanHistory') || '[]');
    
    // Event selection handler
    $('#event_select').on('change', function() {
        const eventId = $(this).val();
        if (eventId) {
            $('#selected_event_id').val(eventId);
            $('#scanning_interface').show();
            $('#scanner_status').removeClass('alert-info').addClass('alert-success')
                .html('<i class="fas fa-check-circle mr-2"></i>Ready to scan tickets for: ' + $(this).find('option:selected').text());
            $('#ticket_code').focus();
            updateScanHistory();
        } else {
            $('#scanning_interface').hide();
            $('#scan_results').hide();
            $('#scanner_status').removeClass('alert-success').addClass('alert-info')
                .html('<i class="fas fa-info-circle mr-2"></i>Please select an event to start scanning');
        }
    });

    // Manual scan form handler
    $('#scan_form').on('submit', function(e) {
        e.preventDefault();
        const ticketCode = $('#ticket_code').val().trim();
        const eventId = $('#selected_event_id').val();
        
        if (!ticketCode) {
            alert('Please enter a ticket code');
            return;
        }
        
        if (!eventId) {
            alert('Please select an event first');
            return;
        }
        
        scanTicket(ticketCode, eventId);
    });

    // Start camera for QR scanning
    $('#start_camera_btn').on('click', function() {
        startQRScanner();
    });

    // Clear history
    $('#clear_history_btn').on('click', function() {
        scanHistory = [];
        localStorage.setItem('scanHistory', JSON.stringify(scanHistory));
        updateScanHistory();
    });

    // Scan ticket function
    function scanTicket(ticketCode, eventId) {
        $('#scan_btn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Scanning...');
        
        $.ajax({
            url: '{{ url("/scan-ticket") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                ticket_code: ticketCode,
                event_id: eventId
            },
            success: function(response) {
                displayScanResult(response, ticketCode);
                addToHistory(response, ticketCode);
                $('#ticket_code').val('').focus();
            },
            error: function(xhr) {
                const response = xhr.responseJSON || {success: false, message: 'Network error occurred'};
                displayScanResult(response, ticketCode);
            },
            complete: function() {
                $('#scan_btn').prop('disabled', false).html('<i class="fas fa-search mr-2"></i>Scan Ticket');
            }
        });
    }

    // Display scan result
    function displayScanResult(response, ticketCode) {
        let resultClass = '';
        let icon = '';
        let title = '';
        
        if (response.success) {
            resultClass = 'scan-result-valid';
            icon = 'fas fa-check-circle text-success';
            title = 'Valid Ticket';
        } else {
            switch(response.status) {
                case 'scan_limit_reached':
                    resultClass = 'scan-result-limit-reached';
                    icon = 'fas fa-ban text-warning';
                    title = 'Scan Limit Reached';
                    break;
                case 'already_used':
                    resultClass = 'scan-result-used';
                    icon = 'fas fa-exclamation-triangle text-warning';
                    title = 'Already Used';
                    break;
                case 'unconfirmed':
                    resultClass = 'scan-result-pending';
                    icon = 'fas fa-clock text-info';
                    title = 'Order Pending';
                    break;
                case 'unauthorized':
                    resultClass = 'scan-result-unauthorized';
                    icon = 'fas fa-ban text-danger';
                    title = 'Unauthorized';
                    break;
                case 'wrong_event':
                    resultClass = 'scan-result-wrong-event';
                    icon = 'fas fa-exchange-alt text-warning';
                    title = 'Wrong Event';
                    break;
                case 'wrong_date':
                    resultClass = 'scan-result-wrong-date';
                    icon = 'fas fa-calendar-times text-warning';
                    title = 'Wrong Date';
                    break;
                case 'invalid':
                    resultClass = 'scan-result-not-found';
                    icon = 'fas fa-search text-danger';
                    title = 'Ticket Not Found';
                    break;
                default:
                    resultClass = 'scan-result-invalid';
                    icon = 'fas fa-times-circle text-danger';
                    title = 'Invalid Ticket';
            }
        }
        
        let resultHtml = `
            <div class="alert ${resultClass} mb-3">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <i class="${icon} fa-3x"></i>
                    </div>
                    <div class="col-md-10">
                        <h5 class="mb-2">${title}</h5>
                        <p class="mb-1"><strong>Ticket Code:</strong> <span class="ticket-code">${ticketCode}</span></p>
                        <p class="mb-0">${response.message}</p>
                        ${response.data ? `
                            <hr class="my-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <small><strong>Event:</strong> ${response.data.event_name || 'N/A'}</small><br>
                                    <small><strong>Ticket:</strong> ${response.data.ticket_name || 'N/A'}</small><br>
                                    <small><strong>Customer:</strong> ${response.data.customer_name || 'N/A'}</small>
                                </div>
                                <div class="col-md-6">
                                    <small><strong>Scanned:</strong> ${response.data.scanned_at || 'N/A'}</small><br>
                                    ${response.data.max_scans ? `
                                        <small><strong>Scan Count:</strong> ${response.data.current_scans || 0} / ${response.data.max_scans}</small><br>
                                        ${response.data.scans_remaining !== undefined ? `<small><strong>Remaining:</strong> ${response.data.scans_remaining} scans</small>` : ''}
                                    ` : ''}
                                </div>
                            </div>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;
        
        $('#result_content').html(resultHtml);
        $('#scan_results').show();
        
        // Auto-hide after 5 seconds for successful scans
        if (response.success) {
            setTimeout(() => {
                $('#scan_results').fadeOut();
            }, 5000);
        }
    }

    // Add to scan history
    function addToHistory(response, ticketCode) {
        const historyItem = {
            ticket_code: ticketCode,
            status: response.status || (response.success ? 'valid' : 'invalid'),
            message: response.message,
            timestamp: new Date().toLocaleString(),
            data: response.data || null
        };
        
        scanHistory.unshift(historyItem);
        if (scanHistory.length > 20) {
            scanHistory = scanHistory.slice(0, 20);
        }
        
        localStorage.setItem('scanHistory', JSON.stringify(scanHistory));
        updateScanHistory();
    }

    // Update scan history display
    function updateScanHistory() {
        if (scanHistory.length === 0) {
            $('#scan_history').hide();
            return;
        }
        
        let historyHtml = '';
        scanHistory.forEach(item => {
            let statusClass = '';
            let statusIcon = '';
            
            switch(item.status) {
                case 'valid':
                    statusClass = 'text-success';
                    statusIcon = 'fas fa-check-circle';
                    break;
                case 'already_used':
                    statusClass = 'text-warning';
                    statusIcon = 'fas fa-exclamation-triangle';
                    break;
                default:
                    statusClass = 'text-danger';
                    statusIcon = 'fas fa-times-circle';
            }
            
            historyHtml += `
                <div class="history-item">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <i class="${statusIcon} ${statusClass}"></i>
                            <span class="ticket-code ml-2">${item.ticket_code}</span>
                        </div>
                        <div class="col-md-6">
                            <small>${item.message}</small>
                        </div>
                        <div class="col-md-4 text-right">
                            <small class="text-muted">${item.timestamp}</small>
                        </div>
                    </div>
                </div>
            `;
        });
        
        $('#history_list').html(historyHtml);
        $('#scan_history').show();
    }

    // Start QR Code Scanner
    function startQRScanner() {
        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                html5QrCode = null;
                $('#start_camera_btn').html('<i class="fas fa-camera mr-2"></i>Start Camera');
            });
            return;
        }

        html5QrCode = new Html5Qrcode("qr_reader");
        
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                // Look for back camera (environment facing) first
                let cameraId = devices[0].id; // fallback to first camera
                
                // Try to find the back camera
                for (let device of devices) {
                    if (device.label && (device.label.toLowerCase().includes('back') || 
                        device.label.toLowerCase().includes('rear') ||
                        device.label.toLowerCase().includes('environment'))) {
                        cameraId = device.id;
                        break;
                    }
                }
                
                // If no back camera found by label, try using environment facing mode
                const config = {
                    fps: 10,
                    qrbox: { width: 250, height: 250 },
                    // Prefer back camera
                    facingMode: { ideal: "environment" }
                };
                
                html5QrCode.start(
                    cameraId,
                    config,
                    (decodedText, decodedResult) => {
                        // Prevent multiple scans of the same ticket
                        if (html5QrCode && html5QrCode.getState() === Html5QrcodeScannerState.SCANNING) {
                            html5QrCode.pause(true);
                            
                            $('#ticket_code').val(decodedText);
                            const eventId = $('#selected_event_id').val();
                            if (eventId) {
                                scanTicket(decodedText, eventId);
                            }
                            
                            // Resume scanning after 3 seconds to allow for next ticket
                            setTimeout(() => {
                                if (html5QrCode && html5QrCode.getState() === Html5QrcodeScannerState.PAUSED) {
                                    html5QrCode.resume();
                                }
                            }, 3000);
                        }
                    },
                    (errorMessage) => {
                        // Handle scan errors silently
                    }
                ).then(() => {
                    $('#start_camera_btn').html('<i class="fas fa-stop mr-2"></i>Stop Camera');
                }).catch(err => {
                    console.error('Unable to start camera:', err);
                    alert('Unable to access camera. Please check permissions.');
                });
            } else {
                alert('No cameras found on this device.');
            }
        }).catch(err => {
            console.error('Error getting cameras:', err);
            alert('Error accessing camera devices.');
        });
    }

    // Initialize scan history on page load
    updateScanHistory();
    
    // Focus on ticket code input when page loads
    $('#ticket_code').focus();
});
</script>

<style>
/* Mobile-responsive styles for ticket scanner */
@media (max-width: 768px) {
    .card {
        margin-bottom: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .form-control {
        font-size: 1rem;
        padding: 0.5rem 0.75rem;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        font-size: 1rem;
    }
    
    #qr_reader {
        height: 180px !important;
    }
    
    .alert {
        padding: 0.75rem;
        font-size: 0.9rem;
    }
    
    .card-header h6 {
        font-size: 1rem;
    }
    
    /* Make scanning interface stack on mobile */
    .col-md-6 {
        margin-bottom: 1rem;
    }
}

@media (max-width: 576px) {
    .section-body {
        padding: 0.5rem;
    }
    
    .card {
        border-radius: 0.5rem;
    }
    
    .form-control-lg {
        font-size: 1rem;
        padding: 0.625rem 0.875rem;
    }
    
    .btn-lg {
        padding: 0.625rem 1.25rem;
        font-size: 1rem;
    }
    
    #qr_reader {
        min-height: 180px !important;
    }
    
    .fa-3x {
        font-size: 2rem !important;
    }
    
    .text-muted.small {
        font-size: 0.8rem;
    }
}

/* Improve touch targets for mobile */
@media (hover: none) and (pointer: coarse) {
    .btn {
        min-height: 44px;
        min-width: 44px;
    }
    
    .form-control {
        min-height: 44px;
    }
    
    select.form-control {
        min-height: 48px;
    }
}

/* Camera scanner specific mobile styles */
#qr_reader video {
    max-width: 100% !important;
    height: auto !important;
    border-radius: 8px;
}

#qr_reader canvas {
    max-width: 100% !important;
    height: auto !important;
}

/* Scan result styling */
.scan-result-valid {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

.scan-result-used {
    background-color: #fff3cd;
    border-color: #ffeaa7;
    color: #856404;
}

.scan-result-pending {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}

.scan-result-unauthorized,
.scan-result-invalid,
.scan-result-not-found {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

.scan-result-wrong-event,
.scan-result-wrong-date {
    background-color: #fff3cd;
    border-color: #ffeaa7;
    color: #856404;
}

.ticket-code {
    font-family: 'Courier New', monospace;
    background-color: rgba(0,0,0,0.1);
    padding: 2px 6px;
    border-radius: 3px;
    font-weight: bold;
}
</style>

@endsection
