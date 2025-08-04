@extends('frontend.master', ['activePage' => 'booking-success'])

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 6rem;"></i>
                    </div>
                    <h1 class="h3 mb-3 font-weight-bold">Booking Successful!</h1>
                    <p class="text-muted">Thank you for your purchase. Your order has been confirmed.</p>
                    
                    @if(isset($order))
                        <div class="card my-4">
                            <div class="card-header">
                                Order Summary
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Order ID:</span>
                                    <strong>{{ $order->order_id }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Event:</span>
                                    <strong>{{ $order->event->name }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Date:</span>
                                    <strong>{{ $order->created_at->format('F d, Y') }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Quantity:</span>
                                    <strong>{{ $order->quantity }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Total Amount:</span>
                                    <strong>{{ App\Models\Setting::find(1)->currency_symbol }}{{ number_format($order->payment, 2) }}</strong>
                                </li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            <a href="{{ route('downloadTicket', $order->id) }}" class="btn btn-primary mr-3"> <i class="fas fa-download mr-2"></i>Download Ticket</a>
                            <a href="{{ route('userOrders') }}" class="btn btn-outline-secondary">View My Orders</a>
                        </div>
                    @else
                        <p class="text-danger">Could not retrieve order details.</p>
                        <a href="{{ route('userOrders') }}" class="btn btn-primary">Go to My Orders</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
