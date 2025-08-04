<style>
/* Step Progress Styles */
.step-progress {
    padding: 2rem 0;
}

.step-container {
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 0 2rem;
    position: relative;
}

.step-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
}

.step.active .step-circle {
    background: #6777ef;
    color: white;
}

.step.completed .step-circle {
    background: #28a745;
    color: white;
}

.step-label {
    font-size: 0.9rem;
    color: #6c757d;
    font-weight: 500;
}

.step.active .step-label {
    color: #6777ef;
    font-weight: 600;
}

/* Step Content Styles */
.step-content {
    display: none;
    padding: 2rem 0;
}

.step-content.active {
    display: block;
}

.step-title {
    font-size: 2rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.step-subtitle {
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

/* Form Styles */
.form-control-lg {
    padding: 0.75rem 1rem;
    font-size: 1.1rem;
    border-radius: 0.5rem;
}

.form-label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

/* Payment Options */
.payment-options {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.payment-card {
    border: 2px solid #e9ecef;
    border-radius: 0.5rem;
    padding: 1.5rem 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 120px;
}

.payment-card:hover,
.payment-card.active {
    border-color: #6777ef;
    background: #f8f9ff;
}

.payment-card i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    display: block;
    color: #6777ef;
}

/* Ticket Options */
.ticket-options {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.ticket-option-card {
    border: 2px solid #e9ecef;
    border-radius: 0.5rem;
    padding: 1rem 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 140px;
}

.ticket-option-card:hover,
.ticket-option-card.active {
    border-color: #6777ef;
    background: #f8f9ff;
}

.ticket-option-card i {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    display: block;
    color: #6777ef;
}

/* Upload Styles */
.upload-area {
    border: 2px dashed #e9ecef;
    border-radius: 0.5rem;
    padding: 3rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.upload-area:hover {
    border-color: #6777ef;
    background: #f8f9ff;
}

.upload-placeholder i {
    font-size: 3rem;
    color: #6777ef;
    margin-bottom: 1rem;
}

.upload-area.dragover {
    border-color: #007bff;
    background-color: #f8f9fa;
}

.additional-upload-box,
.video-upload-box {
    aspect-ratio: 1;
    border: 2px dashed #e9ecef;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 1rem;
}

.additional-upload-box:hover,
.video-upload-box:hover {
    border-color: #6777ef;
    background: #f8f9ff;
}

.additional-upload-box i,
.video-upload-box i {
    font-size: 2rem;
    color: #6777ef;
}

/* Navigation Buttons */
.form-navigation {
    padding: 2rem 0;
}

.btn-lg {
    padding: 0.75rem 2rem;
    font-size: 1.1rem;
    border-radius: 0.5rem;
}

/* Success Animation */
.success-animation {
    animation: bounce 1s ease-in-out;
}

@keyframes bounce {
    0%, 20%, 60%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-20px);
    }
    80% {
        transform: translateY(-10px);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .step-container {
        flex-wrap: wrap;
    }
    
    .step {
        margin: 0.5rem;
    }
    
    .payment-options,
    .ticket-options {
        flex-direction: column;
        align-items: center;
    }
}
</style>
