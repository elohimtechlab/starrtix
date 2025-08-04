<!-- Step 2: Where (Location & Address) -->
<div class="step-content" id="step-2">
    <div class="text-center mb-4">
        <h3 class="step-title">Event Location & Address</h3>
        <p class="step-subtitle text-muted">We don't want anyone <span class="text-warning">getting lost</span> or missing out.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-group">
                <label class="form-label">{{ __('Search Address') }} <span class="text-danger">*</span></label>
                <input type="text" name="address" id="address" value="{{ old('address') }}"
                    placeholder="{{ __('Aberdeen') }}"
                    class="form-control form-control-lg @error('address') is-invalid @enderror">
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">{{ __('Map Coordinates') }}</label>
                <input type="text" name="lat_long" id="lat_long" value="{{ old('lat_long') }}"
                    placeholder="{{ __('-0.39837363, 1.37352234') }}"
                    class="form-control form-control-lg @error('lat_long') is-invalid @enderror">
                @error('lat_long')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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
