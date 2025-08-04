<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Invitation - {{ $event->name }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 300;
        }
        .content {
            padding: 40px 30px;
        }
        .invite-badge {
            display: inline-block;
            background: #f8f9fa;
            color: #495057;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 20px;
            border: 2px solid #e9ecef;
        }
        .event-details {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 25px;
            margin: 25px 0;
            border-left: 4px solid #667eea;
        }
        .event-title {
            font-size: 22px;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 15px 0;
        }
        .event-info {
            display: flex;
            align-items: center;
            margin: 10px 0;
            color: #6c757d;
        }
        .event-info i {
            width: 20px;
            margin-right: 10px;
            color: #667eea;
        }
        .message-box {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        .message-box h4 {
            margin: 0 0 10px 0;
            color: #856404;
        }
        .cta-section {
            text-align: center;
            margin: 40px 0;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            margin: 0 10px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .btn-confirm {
            background: #28a745;
            color: white;
        }
        .btn-confirm:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        .btn-decline {
            background: #dc3545;
            color: white;
        }
        .btn-decline:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 5px;
            }
            .content {
                padding: 20px;
            }
            .btn {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🎉 You're Invited!</h1>
            <p>{{ $setting->app_name }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Hello <strong>{{ $invite->guest_name }}</strong>,</p>
            
            <p>You have been invited as a <span class="invite-badge">{{ ucfirst($invite->invite_type) }}</span> to an exciting event!</p>

            <!-- Event Details -->
            <div class="event-details">
                <h2 class="event-title">{{ $event->name }}</h2>
                
                <div class="event-info">
                    <i>📅</i>
                    <span><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->start_time)->format('l, F j, Y') }}</span>
                </div>
                
                <div class="event-info">
                    <i>🕒</i>
                    <span><strong>Time:</strong> {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}</span>
                </div>
                
                <div class="event-info">
                    <i>📍</i>
                    <span><strong>Location:</strong> {{ $event->address }}</span>
                </div>
                
                @if($event->description)
                <div style="margin-top: 15px;">
                    <strong>About the Event:</strong>
                    <p style="margin: 10px 0; color: #555;">{{ Str::limit(strip_tags($event->description), 200) }}</p>
                </div>
                @endif
            </div>

            <!-- Personal Message -->
            @if($invite->invite_message)
            <div class="message-box">
                <h4>Personal Message:</h4>
                <p style="margin: 0; color: #856404;">{{ $invite->invite_message }}</p>
            </div>
            @endif

            <!-- Call to Action -->
            <div class="cta-section">
                <h3 style="color: #2c3e50; margin-bottom: 20px;">Will you be attending?</h3>
                <p style="margin-bottom: 30px; color: #6c757d;">Please let us know your response by clicking one of the buttons below:</p>
                
                <a href="{{ $inviteUrl }}" class="btn btn-confirm">
                    ✅ View Invitation & Respond
                </a>
            </div>

            <p style="color: #6c757d; font-size: 14px; text-align: center;">
                This invitation is specifically for <strong>{{ $invite->guest_name }}</strong><br>
                Please do not forward this email as it contains a unique invitation link.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This invitation was sent by <strong>{{ $setting->app_name }}</strong></p>
            <p>
                <a href="{{ url('/') }}">Visit our website</a> | 
                <a href="{{ url('/contact') }}">Contact us</a>
            </p>
            <p style="margin-top: 20px; font-size: 12px; color: #999;">
                If you're having trouble with the button above, copy and paste this URL into your browser:<br>
                <a href="{{ $inviteUrl }}" style="word-break: break-all;">{{ $inviteUrl }}</a>
            </p>
        </div>
    </div>
</body>
</html>
