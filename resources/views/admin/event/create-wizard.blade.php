@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => __('Create Event'),
        'headerData' => __('Event'),
        'url' => 'events',
    ])

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Step Progress Indicator -->
                        <div class="step-progress mb-4">
                            <div class="step-container">
                                <div class="step active" data-step="1">
                                    <div class="step-circle">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <span class="step-label">What</span>
                                </div>
                                <div class="step" data-step="2">
                                    <div class="step-circle">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <span class="step-label">Where</span>
                                </div>
                                <div class="step" data-step="3">
                                    <div class="step-circle">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <span class="step-label">When</span>
                                </div>
                                <div class="step" data-step="4">
                                    <div class="step-circle">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <span class="step-label">How much</span>
                                </div>
                                <div class="step" data-step="5">
                                    <div class="step-circle">
                                        <i class="fas fa-upload"></i>
                                    </div>
                                    <span class="step-label">Upload</span>
                                </div>
                            </div>
                        </div>

                        <form method="post" class="event-wizard-form" action="{{ url('events') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Step 1: What (Event Details) -->
                            <div class="step-content active" id="step-1">
                                <div class="text-center mb-4">
                                    <h3 class="step-title">Event Details</h3>
                                    <p class="step-subtitle text-muted">Upload your event in just 7 steps</p>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('Event Title') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="event-title" value="{{ old('name') }}"
                                                placeholder="{{ __('Enter your event title') }}"
                                                class="form-control form-control-lg @error('name') is-invalid @enderror">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">{{ __('Event Category') }} <span class="text-danger">*</span></label>
                                            <select name="category_id" id="event-category" class="form-control form-control-lg select2">
                                                <option value="">{{ __('Select Category') }}</option>
                                                @foreach ($category as $item)
                                                    <option value="{{ $item->id }}" {{ $item->id == old('category_id') ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">{{ __('Payment Acceptance') }} <span class="text-danger">*</span></label>
                                            <div class="payment-options">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="type" id="free-event" value="free">
                                                    <label class="form-check-label" for="free-event">
                                                        <div class="payment-card">
                                                            <i class="fas fa-gift"></i>
                                                            <span>Free</span>
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="type" id="paid-event" value="paid" checked>
                                                    <label class="form-check-label" for="paid-event">
                                                        <div class="payment-card active">
                                                            <i class="fas fa-credit-card"></i>
                                                            <span>Paid</span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-navigation text-center mt-4">
                                            <button type="button" class="btn btn-primary btn-lg next-step">
                                                {{ __('Next') }} <i class="fas fa-arrow-right ml-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional steps will be added in separate files -->
                            @include('admin.event.wizard-steps.step-2')
                            @include('admin.event.wizard-steps.step-3')
                            @include('admin.event.wizard-steps.step-4')
                            @include('admin.event.wizard-steps.step-5')

                            <!-- Hidden fields for existing functionality -->
                            <input type="hidden" name="people" value="100">
                            <input type="hidden" name="status" value="1">
                            <input type="hidden" name="description" value="">
                            @if (Auth::user()->hasRole('admin'))
                                <input type="hidden" name="user_id" value="">
                            @endif
                            <input type="hidden" name="scanner_id[]" value="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('admin.event.wizard-styles')
@include('admin.event.wizard-scripts')
@include('admin.event.preview-modal')
@endsection
