<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Invite - {{$event->name}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .invite-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .invite-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            position: relative;
        }
        
        .invite-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }
        
        .invite-type-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255,255,255,0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            text-transform: uppercase;
            font-weight: bold;
        }
        
        .invite-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }
        
        .invite-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .invite-subtitle {
            opacity: 0.9;
            font-size: 1rem;
        }
        
        .event-details {
            padding: 2rem;
        }
        
        .event-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }
        
        .event-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 1rem;
        }
        
        .event-info {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            color: #666;
        }
        
        .event-info i {
            width: 20px;
            margin-right: 1rem;
            color: #28a745;
        }
        
        .personal-message {
            background: #f8f9fa;
            border-left: 4px solid #28a745;
            padding: 1rem;
            margin: 1.5rem 0;
            border-radius: 0 10px 10px 0;
        }
        
        .response-section {
            padding: 2rem;
            background: #f8f9fa;
            text-align: center;
        }
        
        .response-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1.5rem;
        }
        
        .btn-confirm {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            color: white;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(40, 167, 69, 0.3);
            color: white;
        }
        
        .btn-reject {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            color: white;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-reject:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.3);
            color: white;
        }
        
        .status-responded {
            padding: 2rem;
            text-align: center;
            background: #e9ecef;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }
        
        .status-confirmed {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }
        
        .status-rejected {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
        }
        
        @media (max-width: 768px) {
            .response-buttons {
                flex-direction: column;
            }
            
            .invite-container {
                margin: 1rem auto;
            }
        }
    </style>
</head>
<body>
    <div class="invite-container">
        <div class="invite-card">
            <!-- Invite Header -->
            <div class="invite-header">
                <div class="invite-type-badge">
                    {{ ucfirst($invite->invite_type) }}
                </div>
                <div class="invite-icon">
                    <i class="fas fa-envelope-open"></i>
                </div>
                <div class="invite-title">You're Invited!</div>
                <div class="invite-subtitle">{{ $invite->guest_name }}</div>
            </div>
            
            <!-- Event Details -->
            <div class="event-details">
                <img src="{{url('images/upload/'.$event->image)}}" alt="{{$event->name}}" class="event-image">
                
                <h2 class="event-title">{{$event->name}}</h2>
                
                <div class="event-info">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{date('F j, Y', strtotime($event->start_time))}}</span>
                </div>
                
                <div class="event-info">
                    <i class="fas fa-clock"></i>
                    <span>{{date('g:i A', strtotime($event->start_time))}} - {{date('g:i A', strtotime($event->end_time))}}</span>
                </div>
                
                <div class="event-info">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{$event->address}}</span>
                </div>
                
                @if($invite->invite_message)
                <div class="personal-message">
                    <h6><i class="fas fa-comment mr-2"></i>Personal Message:</h6>
                    <p class="mb-0">{{$invite->invite_message}}</p>
                </div>
                @endif
                
                <div class="event-info">
                    <i class="fas fa-info-circle"></i>
                    <span>{{ strip_tags($event->description) }}</span>
                </div>
            </div>
            
            <!-- Response Section -->
            @if($invite->status === 'pending')
            <div class="response-section">
                <h4>Will you be attending?</h4>
                <p class="text-muted">Please let us know your response</p>
                
                <form id="responseForm">
                    @csrf
                    <div class="response-buttons">
                        <button type="button" class="btn btn-confirm" data-response="confirmed">
                            <i class="fas fa-check mr-2"></i>Yes, I'll Attend
                        </button>
                        <button type="button" class="btn btn-reject" data-response="rejected">
                            <i class="fas fa-times mr-2"></i>Sorry, Can't Make It
                        </button>
                    </div>
                </form>
            </div>
            @else
            <div class="status-responded">
                <div class="status-badge {{ $invite->status === 'confirmed' ? 'status-confirmed' : 'status-rejected' }}">
                    @if($invite->status === 'confirmed')
                        <i class="fas fa-check mr-2"></i>Attendance Confirmed
                    @else
                        <i class="fas fa-times mr-2"></i>Unable to Attend
                    @endif
                </div>
                <p class="text-muted mb-0">
                    You responded on {{ date('F j, Y \a\t g:i A', strtotime($invite->responded_at)) }}
                </p>
            </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
    $(document).ready(function() {
        $('.response-buttons button').on('click', function() {
            const response = $(this).data('response');
            const button = $(this);
            const originalText = button.html();
            
            // Show loading state
            button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Processing...');
            $('.response-buttons button').prop('disabled', true);
            
            $.ajax({
                url: '{{ route("invite.respond", $invite->invite_token) }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    response: response
                },
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Response Recorded!',
                            text: data.message,
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            // Reload page to show updated status
                            window.location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Failed to record response');
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Failed to record your response. Please try again.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                    
                    // Reset button states
                    button.prop('disabled', false).html(originalText);
                    $('.response-buttons button').prop('disabled', false);
                }
            });
        });
    });
    </script>
</body>
</html>
