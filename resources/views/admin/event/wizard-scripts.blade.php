<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 5;

    // Step navigation
    document.querySelectorAll('.next-step').forEach(button => {
        button.addEventListener('click', function() {
            if (currentStep < totalSteps) {
                showStep(currentStep + 1);
            }
        });
    });

    document.querySelectorAll('.prev-step').forEach(button => {
        button.addEventListener('click', function() {
            if (currentStep > 1) {
                showStep(currentStep - 1);
            }
        });
    });

    // Show specific step
    function showStep(stepNumber) {
        // Hide all step contents
        document.querySelectorAll('.step-content').forEach(content => {
            content.classList.remove('active');
        });

        // Hide all step indicators
        document.querySelectorAll('.step').forEach(step => {
            step.classList.remove('active', 'completed');
        });

        // Show current step content
        document.getElementById(`step-${stepNumber}`).classList.add('active');

        // Update step indicators
        for (let i = 1; i <= totalSteps; i++) {
            const stepElement = document.querySelector(`[data-step="${i}"]`);
            if (i < stepNumber) {
                stepElement.classList.add('completed');
            } else if (i === stepNumber) {
                stepElement.classList.add('active');
            }
        }

        currentStep = stepNumber;
    }

    // Payment type selection
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.payment-card').forEach(card => {
                card.classList.remove('active');
            });
            this.nextElementSibling.querySelector('.payment-card').classList.add('active');
        });
    });

    // Ticket options selection
    document.querySelectorAll('.ticket-option-card').forEach(card => {
        card.addEventListener('click', function() {
            const checkbox = this.parentElement.previousElementSibling;
            checkbox.checked = !checkbox.checked;
            
            if (checkbox.checked) {
                this.classList.add('active');
            } else {
                this.classList.remove('active');
            }
        });
    });

    // File upload handlers
    document.getElementById('main-image').addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const fileName = e.target.files[0].name;
            const uploadArea = document.querySelector('.upload-placeholder');
            uploadArea.innerHTML = `
                <i class="fas fa-check-circle text-success"></i>
                <p class="text-success">${fileName}</p>
                <button type="button" class="btn btn-outline-primary">Change Image</button>
            `;
        }
    });

    // Additional image uploads
    document.querySelectorAll('.additional-upload-box input').forEach(input => {
        input.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const box = this.parentElement;
                box.innerHTML = `
                    <i class="fas fa-check-circle text-success"></i>
                    <input type="file" name="additional_images[]" accept="image/*" style="display: none;">
                `;
                box.onclick = function() { this.querySelector('input').click(); };
            }
        });
    });

    // Video uploads
    document.querySelectorAll('.video-upload-box input').forEach(input => {
        input.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const box = this.parentElement;
                box.innerHTML = `
                    <i class="fas fa-check-circle text-success"></i>
                    <input type="file" name="videos[]" accept="video/*" style="display: none;">
                `;
                box.onclick = function() { this.querySelector('input').click(); };
            }
        });
    });

    // Preview event functionality
    document.querySelector('.preview-event').addEventListener('click', function() {
        showPreview();
    });

    // Form submission
    let isSubmitting = false; // Add flag to prevent duplicate submissions
    
    $('.event-wizard-form').on('submit', function(e) {
        e.preventDefault();
        
        // Prevent duplicate submissions
        if (isSubmitting) {
            return false;
        }
        
        isSubmitting = true; // Set flag to prevent further submissions
        const formData = new FormData(this);
        
        // Show loading state
        const submitBtn = $('.btn-upload-event');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Creating Event...').prop('disabled', true);
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Show brief success message and redirect to event preview page
                    const successMessage = response.message || 'Event created successfully!';
                    
                    // Show success notification
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: successMessage,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            // Redirect to organization dashboard event details page
                            window.location.href = `{{ url('events_details') }}/${response.event_id}`;
                        });
                    } else {
                        // Fallback alert and redirect
                        alert(successMessage);
                        window.location.href = `{{ url('events_details') }}/${response.event_id}`;
                    }
                }
            },
            error: function(xhr) {
                console.error('Error creating event:', xhr.responseText);
                let errorMessage = 'Error creating event. Please try again.';
                
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join('\n');
                }
                
                alert(errorMessage);
                
                // Reset submission flag and button on error
                isSubmitting = false;
                submitBtn.html(originalText).prop('disabled', false);
            },
            complete: function() {
                // Only reset if there was an error (success redirects away)
                // Don't reset isSubmitting flag here to prevent accidental double submissions
            }
        });
    });

    // Initialize first step
    showStep(1);
});
</script>
