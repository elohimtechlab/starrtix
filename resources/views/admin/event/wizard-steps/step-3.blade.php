<!-- Step 3: When (Date and Time) -->
<div class="step-content" id="step-3">
    <div class="text-center mb-4">
        <h3 class="step-title">Date and Time</h3>
        <p class="step-subtitle text-muted">Let's get your <span class="text-warning">dates</span> and <span class="text-warning">times</span> down on paper.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-group">
                <label class="form-label">{{ __('Time-zone') }} <span class="text-danger">*</span></label>
                <select name="timezone" class="form-control form-control-lg select2">
                    <option value="UTC+00(Africa/Freetown)">UTC+00(Africa/Freetown)</option>
                    <option value="UTC+01(Europe/London)">UTC+01(Europe/London)</option>
                    <option value="UTC-05(America/New_York)">UTC-05(America/New_York)</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Start Date & Time') }} <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="start_time" id="start_time" value="{{ old('start_time') }}"
                            class="form-control form-control-lg @error('start_time') is-invalid @enderror">
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Select when your event starts</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('End Date & Time') }} <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="end_time" id="end_time" value="{{ old('end_time') }}"
                            class="form-control form-control-lg @error('end_time') is-invalid @enderror">
                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Select when your event ends</small>
                    </div>
                </div>
            </div>

            <div class="form-navigation text-center mt-4">
                <button type="button" class="btn btn-outline-secondary btn-lg prev-step mr-3">
                    <i class="fas fa-arrow-left mr-2"></i> {{ __('Previous') }}
                </button>
                <button type="button" class="btn btn-primary btn-lg next-step">
                    {{ __('Next') }} <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </div>
</div>
