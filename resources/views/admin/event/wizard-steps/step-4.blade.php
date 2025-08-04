<!-- Step 4: Ticket Price -->
<div class="step-content" id="step-4">
    <div class="text-center mb-4">
        <h3 class="step-title">Ticket Price</h3>
        <p class="step-subtitle text-muted">Let's get your <span class="text-warning">dates</span> and <span class="text-warning">times</span> down on paper.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-group">
                <label class="form-label">{{ __('Currency') }} <span class="text-danger">*</span></label>
                <select name="currency" class="form-control form-control-lg select2">
                    <option value="SLE">Leones</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="GBP">GBP</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Quantity') }}</label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}"
                            placeholder="{{ __('Enter quantity') }}"
                            class="form-control form-control-lg @error('quantity') is-invalid @enderror">
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Price') }}</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}"
                            placeholder="{{ __('Enter price') }}"
                            class="form-control form-control-lg @error('price') is-invalid @enderror">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="ticket-options">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="add_on" id="add-on" value="1">
                        <label class="form-check-label" for="add-on">
                            <div class="ticket-option-card">
                                <i class="fas fa-plus"></i>
                                <span>Add-on</span>
                            </div>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="in_person" id="in-person" value="1" checked>
                        <label class="form-check-label" for="in-person">
                            <div class="ticket-option-card active">
                                <i class="fas fa-user"></i>
                                <span>In-Person Tickets</span>
                            </div>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="refundable" id="refundable" value="1" checked>
                        <label class="form-check-label" for="refundable">
                            <div class="ticket-option-card active">
                                <i class="fas fa-undo"></i>
                                <span>Refundable</span>
                            </div>
                        </label>
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
