/**
 * Main Application Script
 * Handles various UI interactions and functionality
 */

// Wait for DOM to be fully loaded before executing
document.addEventListener('DOMContentLoaded', () => {
    // Initialize all UI components
    initializeSmoothScrolling();
    initializeAlerts();
    initializeFormValidation();
    initializeDeleteConfirmations();
    initializeTooltips();
    initializePopovers();
    initializePasswordToggles();
    initializeFileUploadPreviews();
    initializeClipboardCopy();
    initializeActiveNavigation();
});

/**
 * Smooth scrolling for anchor links
 */
function initializeSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            // Skip if it's just "#"
            if (targetId === '#') return;

            const target = document.querySelector(targetId);
            if (target) {
                const headerOffset = 70;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

/**
 * Auto-hide alerts after 5 seconds
 */
function initializeAlerts() {
    const alerts = document.querySelectorAll('.alert:not([data-permanent])');

    alerts.forEach(alert => {
        // Set a timeout to close the alert
        const timeoutId = setTimeout(() => {
            closeAlert(alert);
        }, 5000);

        // Allow manual dismissal by clicking the close button
        const closeButton = alert.querySelector('.btn-close');
        if (closeButton) {
            closeButton.addEventListener('click', () => {
                clearTimeout(timeoutId);
                closeAlert(alert);
            });
        }
    });
}

/**
 * Close an alert element with animation
 * @param {HTMLElement} alert - The alert element to close
 */
function closeAlert(alert) {
    alert.style.opacity = '0';
    alert.style.transition = 'opacity 0.5s ease';

    setTimeout(() => {
        if (alert.parentNode) {
            alert.parentNode.removeChild(alert);
        }
    }, 500);
}

/**
 * Form validation
 */
function initializeFormValidation() {
    const forms = document.querySelectorAll('.needs-validation');

    forms.forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();

                // Focus on the first invalid field
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                }
            }

            form.classList.add('was-validated');
        }, false);

        // Real-time validation feedback
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                if (input.hasAttribute('required') && !input.value.trim()) {
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });
        });
    });
}

/**
 * Confirm delete actions
 */
function initializeDeleteConfirmations() {
    document.querySelectorAll('[data-confirm]').forEach(element => {
        element.addEventListener('click', event => {
            const message = element.getAttribute('data-confirm') || 'Are you sure you want to delete this item?';

            // Create a custom confirmation modal instead of using browser's confirm
            if (!showConfirmationDialog(message)) {
                event.preventDefault();
            }
        });
    });
}

/**
 * Show a custom confirmation dialog
 * @param {string} message - The confirmation message
 * @returns {boolean} - True if confirmed, false otherwise
 */
function showConfirmationDialog(message) {
    // For simplicity, we're using the browser's confirm, but you could replace this with a modal
    return confirm(message);
}

/**
 * Initialize Bootstrap tooltips
 */
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(tooltipTriggerEl => {
        new bootstrap.Tooltip(tooltipTriggerEl, {
            delay: { show: 500, hide: 100 }
        });
    });
}

/**
 * Initialize Bootstrap popovers
 */
function initializePopovers() {
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.forEach(popoverTriggerEl => {
        new bootstrap.Popover(popoverTriggerEl, {
            trigger: 'focus'
        });
    });
}

/**
 * Toggle password visibility
 */
function initializePasswordToggles() {
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            const input = document.querySelector(this.getAttribute('data-target'));
            const icon = this.querySelector('i');

            if (!input) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
}

/**
 * File upload preview
 */
function initializeFileUploadPreviews() {
    document.querySelectorAll('input[type="file"][data-preview]').forEach(input => {
        input.addEventListener('change', function () {
            const previewId = this.getAttribute('data-preview');
            const preview = document.querySelector(previewId);

            if (!preview) return;

            if (this.files && this.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.onerror = function () {
                    console.error('Error reading file');
                    preview.style.display = 'none';
                };

                reader.readAsDataURL(this.files[0]);
            } else {
                preview.style.display = 'none';
            }
        });
    });
}

/**
 * Copy to clipboard functionality
 */
function initializeClipboardCopy() {
    document.querySelectorAll('.copy-to-clipboard').forEach(button => {
        button.addEventListener('click', async function () {
            const text = this.getAttribute('data-text') ||
                this.getAttribute('href') ||
                this.textContent.trim();

            try {
                await navigator.clipboard.writeText(text);

                // Show success feedback
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check"></i> Copied!';
                this.disabled = true;

                setTimeout(() => {
                    this.innerHTML = originalHTML;
                    this.disabled = false;
                }, 2000);
            } catch (err) {
                console.error('Failed to copy: ', err);

                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);

                // Show feedback
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check"></i> Copied!';
                this.disabled = true;

                setTimeout(() => {
                    this.innerHTML = originalHTML;
                    this.disabled = false;
                }, 2000);
            }
        });
    });
}

/**
 * Active navigation highlighting
 */
function initializeActiveNavigation() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link, .sidebar .nav-link');

    navLinks.forEach(link => {
        const href = link.getAttribute('href');

        // Check if the link href matches the current path
        if (href === currentPath) {
            link.classList.add('active');
        }
        // Check for partial matches (useful for dynamic URLs)
        else if (href !== '/' && href !== '#' && currentPath.startsWith(href)) {
            link.classList.add('active');
        }
    });
}

/**
 * Debounce function to limit how often a function can be called
 * @param {Function} func - The function to debounce
 * @param {number} wait - The debounce time in milliseconds
 * @returns {Function} - The debounced function
 */
function debounce(func, wait) {
    let timeout;
    return function (...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), wait);
    };
}

/**
 * Throttle function to limit how often a function can be called
 * @param {Function} func - The function to throttle
 * @param {number} limit - The throttle time in milliseconds
 * @returns {Function} - The throttled function
 */
function throttle(func, limit) {
    let inThrottle;
    return function (...args) {
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Add window resize event listener with debounce for responsive adjustments
window.addEventListener('resize', debounce(() => {
    // Handle responsive adjustments here
    console.log('Window resized');
}, 250));

// Add scroll event listener with throttle for scroll-based effects
window.addEventListener('scroll', throttle(() => {
    // Handle scroll-based effects here
    const scrollPosition = window.scrollY;

    // Example: Add shadow to header when scrolling
    const header = document.querySelector('header');
    if (header) {
        if (scrollPosition > 50) {
            header.classList.add('shadow-sm');
        } else {
            header.classList.remove('shadow-sm');
        }
    }
}, 100));