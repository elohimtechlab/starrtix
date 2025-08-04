// Fix for frontend header dropdown menu accessibility issue
document.addEventListener('DOMContentLoaded', function() {
    // Fix dropdown menu accessibility
    const dropdownButtons = document.querySelectorAll('.dropdownScreenButton');
    
    dropdownButtons.forEach(function(button) {
        // Make the dropdown button area clickable
        button.style.cursor = 'pointer';
        
        // Add click event to toggle dropdown
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = this.querySelector('.dropdownMenuClass');
            if (dropdown) {
                dropdown.classList.toggle('hidden');
                
                // Close other dropdowns
                document.querySelectorAll('.dropdownMenuClass').forEach(function(otherDropdown) {
                    if (otherDropdown !== dropdown) {
                        otherDropdown.classList.add('hidden');
                    }
                });
            }
        });
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.dropdownMenuClass');
        dropdowns.forEach(function(dropdown) {
            const dropdownContainer = dropdown.closest('.dropdownScreenButton');
            if (dropdownContainer && !dropdownContainer.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });
    
    // Improve dropdown positioning and z-index
    const dropdowns = document.querySelectorAll('.dropdownMenuClass');
    dropdowns.forEach(function(dropdown) {
        dropdown.style.zIndex = '9999';
        dropdown.classList.remove('rigin-top-right'); // Fix typo
        dropdown.classList.add('origin-top-right');
    });
});
