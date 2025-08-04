<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Event Ticket') }} - {{ $order->event->name ?? 'Event' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            background: #fff;
        }
        .ticket-container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .ticket-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .ticket-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .ticket-header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        .ticket-body {
            padding: 30px;
            background: #fff;
        }
        .event-info {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .event-details, .ticket-details {
            display: table-cell;
            vertical-align: top;
            width: 50%;
            padding-right: 20px;
        }
        .ticket-details {
            text-align: right;
            padding-right: 0;
            padding-left: 20px;
        }
        .info-item {
            margin-bottom: 12px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            min-width: 100px;
        }
        .info-value {
            color: #333;
        }
        .qr-section {
            text-align: center;
            padding: 20px;
            border-top: 2px dashed #ddd;
            margin-top: 20px;
        }
        .qr-code {
            margin: 10px 0;
        }
        .ticket-footer {
            background: #f8f9fa;
            padding: 15px 30px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
        .order-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .order-summary h3 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 18px;
        }
        .ticket-item {
            display: table;
            width: 100%;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .ticket-item:last-child {
            border-bottom: none;
        }
        .ticket-name, .ticket-qty, .ticket-price {
            display: table-cell;
            vertical-align: middle;
        }
        .ticket-name {
            width: 60%;
        }
        .ticket-qty {
            width: 20%;
            text-align: center;
        }
        .ticket-price {
            width: 20%;
            text-align: right;
            font-weight: bold;
        }
        .total-row {
            font-weight: bold;
            font-size: 16px;
            color: #333;
            border-top: 2px solid #ddd;
            padding-top: 10px;
        }
        @media print {
            body { margin: 0; padding: 10px; }
            .ticket-container { box-shadow: none; border: 1px solid #000; }
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <!-- Ticket Header -->
        <div class="ticket-header">
            <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                @if($setting->logo && file_exists(public_path('images/upload/' . $setting->logo)))
                    <?php
                    $logoPath = public_path('images/upload/' . $setting->logo);
                    $logoData = base64_encode(file_get_contents($logoPath));
                    $logoExtension = pathinfo($logoPath, PATHINFO_EXTENSION);
                    $logoMimeType = $logoExtension === 'png' ? 'image/png' : ($logoExtension === 'jpg' || $logoExtension === 'jpeg' ? 'image/jpeg' : 'image/png');
                    ?>
                    <img src="data:{{ $logoMimeType }};base64,{{ $logoData }}" alt="Logo" style="height: 50px; margin-right: 15px; object-fit: contain;">
                @endif
                <div style="text-align: center;">
                    <h1 style="margin: 0; font-size: 28px; font-weight: bold;">{{ $setting->app_name ?? 'Event Ticket' }}</h1>
                    <p style="margin: 5px 0 0 0; opacity: 0.9; font-size: 14px;">{{ __('Official Event Ticket') }}</p>
                </div>
            </div>
        </div>

        <!-- Ticket Body -->
        <div class="ticket-body">
            <!-- Event Information -->
            <div class="event-info">
                <div class="event-details">
                    <h2 style="margin: 0 0 20px 0; color: #333;">{{ $order->event->name ?? 'Event Name' }}</h2>
                    
                    @if($order->event)
                        <div class="info-item">
                            <span class="info-label">{{ __('Start Date:') }}</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($order->event->start_time)->format('d F Y, h:i A') }}</span>
                        </div>
                        
                        <div class="info-item">
                            <span class="info-label">{{ __('End Date:') }}</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($order->event->end_time)->format('d F Y, h:i A') }}</span>
                        </div>
                        
                        <div class="info-item">
                            <span class="info-label">{{ __('Location:') }}</span>
                            <span class="info-value">
                                @if($order->event->type == 'online')
                                    {{ __('Online Event') }}
                                @else
                                    {{ $order->event->address ?? 'TBA' }}
                                @endif
                            </span>
                        </div>
                    @endif
                    
                    @if($order->organization)
                        <div class="info-item">
                            <span class="info-label">{{ __('Organizer:') }}</span>
                            <span class="info-value">{{ ($order->organization->first_name ?? '') . ' ' . ($order->organization->last_name ?? '') }}</span>
                        </div>
                    @endif
                </div>

                <div class="ticket-details">
                    <div class="info-item">
                        <span class="info-label">{{ __('Order ID:') }}</span>
                        <span class="info-value">#{{ $order->order_id ?? 'N/A' }}</span>
                    </div>
                    
                    @if($order->customer)
                        <div class="info-item">
                            <span class="info-label">{{ __('Customer:') }}</span>
                            <span class="info-value">{{ ($order->customer->name ?? '') . ' ' . ($order->customer->last_name ?? '') }}</span>
                        </div>
                        
                        <div class="info-item">
                            <span class="info-label">{{ __('Email:') }}</span>
                            <span class="info-value">{{ $order->customer->email ?? 'N/A' }}</span>
                        </div>
                    @endif
                    
                    <div class="info-item">
                        <span class="info-label">{{ __('Payment:') }}</span>
                        <span class="info-value">{{ ucfirst($order->payment_type ?? 'N/A') }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">{{ __('Status:') }}</span>
                        <span class="info-value" style="color: #28a745; font-weight: bold;">{{ __('Confirmed') }}</span>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <h3>{{ __('Ticket Details') }}</h3>
                
                @if($orderchild && $orderchild->count() > 0)
                    @foreach($orderchild as $child)
                        <div class="ticket-item">
                            <div class="ticket-name">{{ $child->ticket->name ?? __('Event Ticket') }}</div>
                            <div class="ticket-qty">{{ $child->quantity ?? 1 }}</div>
                            <div class="ticket-price">{{ ($setting->currency ?? '$') }}{{ number_format($child->price ?? 0, 2) }}</div>
                        </div>
                    @endforeach
                @else
                    <div class="ticket-item">
                        <div class="ticket-name">{{ $order->ticket->name ?? __('Event Ticket') }}</div>
                        <div class="ticket-qty">{{ $order->quantity ?? 1 }}</div>
                        <div class="ticket-price">{{ ($setting->currency ?? '$') }}{{ number_format($order->payment ?? 0, 2) }}</div>
                    </div>
                @endif
                
                <div class="ticket-item total-row">
                    <div class="ticket-name">{{ __('Total Amount') }}</div>
                    <div class="ticket-qty"></div>
                    <div class="ticket-price">{{ ($setting->currency ?? '$') }}{{ number_format($order->payment ?? 0, 2) }}</div>
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="qr-section">
                <h3 style="margin: 0 0 15px 0;">{{ __('Scan to Verify') }}</h3>
                
                @if($orderchild && $orderchild->count() > 0)
                    <!-- Multiple Tickets - Generate QR for each ticket -->
                    <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
                        @foreach($orderchild as $index => $child)
                            <div class="individual-qr" style="text-align: center; margin-bottom: 20px;">
                                <div class="qr-code">
                                    @if(isset($child->ticket_number))
                                        <?php
                                        $qr = QrCode::format('png')
                                            ->size(120)
                                            ->generate($child->ticket_number);
                                        ?>
                                        <img src="data:image/png;base64,{{ base64_encode($qr) }}" alt="QR Code {{ $index + 1 }}" style="width: 120px; height: 120px;">
                                    @endif
                                </div>
                                <p style="margin: 10px 0 0 0; font-size: 11px; color: #666; font-weight: bold;">
                                    {{ __('Ticket') }} {{ $index + 1 }}: {{ $child->ticket_number }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Single Ticket - Generate one QR code -->
                    <div class="qr-code" style="text-align: center;">
                        @if(isset($order->order_id) && $order->event)
                            <?php
                            // For single ticket, use order_id as fallback if no ticket_number
                            $ticketNumber = $order->ticket_number ?? $order->order_id;
                            $qr = QrCode::format('png')
                                ->size(120)
                                ->generate($ticketNumber);
                            ?>
                            <img src="data:image/png;base64,{{ base64_encode($qr) }}" alt="QR Code" style="width: 120px; height: 120px;">
                        @endif
                        <p style="margin: 10px 0 0 0; font-size: 11px; color: #666; font-weight: bold;">
                            {{ $order->ticket_number ?? $order->order_id }}
                        </p>
                    </div>
                @endif
                
                <p style="margin: 15px 0 0 0; font-size: 12px; color: #666; text-align: center;">
                    {{ __('Present these QR codes at the event entrance for verification') }}
                </p>
            </div>
        </div>

        <!-- Ticket Footer -->
        <div class="ticket-footer">
            <p>{{ __('This is an official ticket for') }} {{ $order->event->name ?? 'this event' }}. {{ __('Please keep this ticket safe and present it at the event.') }}</p>
            <p>{{ __('For support, contact the event organizer or visit our website.') }}</p>
        </div>
    </div>
</body>
</html>
