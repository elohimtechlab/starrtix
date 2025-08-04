<!-- Step 5: Upload Ticket Cover -->
<div class="step-content" id="step-5">
    <div class="text-center mb-4">
        <h3 class="step-title">Upload Ticket Cover</h3>
        <p class="step-subtitle text-muted">Give life to your ticket by adding an image or video</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="upload-section">
                <div class="main-upload mb-4">
                    <div class="upload-area" onclick="document.getElementById('main-image').click()">
                        <div class="upload-placeholder">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Choose a cover image for you event</p>
                            <button type="button" class="btn btn-outline-primary">Choose Image</button>
                        </div>
                        <input type="file" name="image" id="main-image" accept="image/*" style="display: none;">
                    </div>
                </div>

                <div class="additional-uploads">
                    <h6 class="mb-3">Additional images (optional)</h6>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="additional-upload-box" onclick="this.querySelector('input').click()">
                                <input type="file" name="additional_images[]" accept="image/*" style="display: none;">
                                <i class="fas fa-plus"></i>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="additional-upload-box" onclick="this.querySelector('input').click()">
                                <input type="file" name="additional_images[]" accept="image/*" style="display: none;">
                                <i class="fas fa-plus"></i>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="additional-upload-box" onclick="this.querySelector('input').click()">
                                <input type="file" name="additional_images[]" accept="image/*" style="display: none;">
                                <i class="fas fa-plus"></i>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="additional-upload-box" onclick="this.querySelector('input').click()">
                                <input type="file" name="additional_images[]" accept="image/*" style="display: none;">
                                <i class="fas fa-plus"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="video-uploads mt-4">
                    <h6 class="mb-3">Add a video (optional)</h6>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="video-upload-box" onclick="this.querySelector('input').click()">
                                <input type="file" name="videos[]" accept="video/*" style="display: none;">
                                <i class="fas fa-video"></i>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="video-upload-box" onclick="this.querySelector('input').click()">
                                <input type="file" name="videos[]" accept="video/*" style="display: none;">
                                <i class="fas fa-video"></i>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="video-upload-box" onclick="this.querySelector('input').click()">
                                <input type="file" name="videos[]" accept="video/*" style="display: none;">
                                <i class="fas fa-video"></i>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="video-upload-box" onclick="this.querySelector('input').click()">
                                <input type="file" name="videos[]" accept="video/*" style="display: none;">
                                <i class="fas fa-video"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-navigation text-center mt-4">
                <button type="button" class="btn btn-outline-secondary btn-lg prev-step mr-3">
                    <i class="fas fa-arrow-left mr-2"></i> {{ __('Previous') }}
                </button>
                <button type="button" class="btn btn-outline-primary btn-lg preview-event mr-3">
                    <i class="fas fa-eye mr-2"></i> {{ __('Preview Event') }}
                </button>
                <button type="submit" class="btn btn-primary btn-lg btn-upload-event">
                    <i class="fas fa-upload mr-2"></i> {{ __('Upload Event') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <div class="success-animation mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h3 class="mb-3">Event Created Successfully!</h3>
                <p class="text-muted mb-4">Your event has been created and is ready to share with the world.</p>
                <div class="share-buttons">
                    <button type="button" class="btn btn-primary mr-2">
                        <i class="fab fa-facebook mr-2"></i> Share on Facebook
                    </button>
                    <button type="button" class="btn btn-info mr-2">
                        <i class="fab fa-twitter mr-2"></i> Share on Twitter
                    </button>
                    <button type="button" class="btn btn-success">
                        <i class="fab fa-whatsapp mr-2"></i> Share on WhatsApp
                    </button>
                </div>
                <div class="mt-4">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <a href="{{ url('events') }}" class="btn btn-primary">View All Events</a>
                </div>
            </div>
        </div>
    </div>
</div>
