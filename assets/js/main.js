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
    initializeDarkModeToggle();
    initializeStickyHeader();
    initializeBackToTop();
    initializeCounters();
    initializeCalendar();
    initializeGallery();
    initializeTestimonials();
    initializeFAQ();
    initializeAnimations();
    initializeMobileMenu();
    initializeUserMenu();
    initializeNotifications();
    initializeSearch();
    initializeFilters();
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
 * Dark mode toggle
 */
function initializeDarkModeToggle() {
    const darkModeToggle = document.querySelector('.dark-mode-toggle');

    if (!darkModeToggle) return;

    // Check for saved dark mode preference or respect OS preference
    const darkMode = localStorage.getItem('darkMode') === 'true' ||
        (localStorage.getItem('darkMode') === null &&
            window.matchMedia('(prefers-color-scheme: dark)').matches);

    if (darkMode) {
        document.body.classList.add('dark-mode');
        darkModeToggle.classList.add('active');
    }

    darkModeToggle.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        darkModeToggle.classList.toggle('active');

        // Save preference
        localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
    });
}

/**
 * Sticky header with shadow on scroll
 */
function initializeStickyHeader() {
    const header = document.querySelector('.navbar.sticky-top');

    if (!header) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('shadow-on-scroll');
        } else {
            header.classList.remove('shadow-on-scroll');
        }
    });
}

/**
 * Back to top button
 */
function initializeBackToTop() {
    const backToTopButton = document.querySelector('.back-to-top');

    if (!backToTopButton) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTopButton.classList.add('visible');
        } else {
            backToTopButton.classList.remove('visible');
        }
    });

    backToTopButton.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

/**
 * Animated counters
 */
function initializeCounters() {
    const counters = document.querySelectorAll('.counter');

    if (!counters.length) return;

    const speed = 200;

    const countUp = (counter) => {
        const target = +counter.getAttribute('data-target');
        const count = +counter.innerText;
        const increment = target / speed;

        if (count < target) {
            counter.innerText = Math.ceil(count + increment);
            setTimeout(() => countUp(counter), 10);
        } else {
            counter.innerText = target;
        }
    };

    // Use Intersection Observer to trigger animation when counter is visible
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                countUp(counter);
                observer.unobserve(counter);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => {
        observer.observe(counter);
    });
}

/**
 * Calendar functionality
 */
function initializeCalendar() {
    const calendar = document.querySelector('#calendar');

    if (!calendar) return;

    // Simple calendar implementation
    const months = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    const today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();

    // Sample events data (in a real app, this would come from an API)
    const events = [
        { date: new Date(currentYear, currentMonth, 15), title: 'Event 1' },
        { date: new Date(currentYear, currentMonth, 20), title: 'Event 2' },
        { date: new Date(currentYear, currentMonth + 1, 5), title: 'Event 3' }
    ];

    const renderCalendar = () => {
        const firstDay = new Date(currentYear, currentMonth, 1).getDay();
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

        let html = `
            <div class="calendar-header">
                <button id="prevMonth" class="btn btn-sm btn-outline-primary"><i class="bi bi-chevron-left"></i></button>
                <h4>${months[currentMonth]} ${currentYear}</h4>
                <button id="nextMonth" class="btn btn-sm btn-outline-primary"><i class="bi bi-chevron-right"></i></button>
            </div>
            <div class="calendar-grid">
        `;

        // Add day of week headers
        daysOfWeek.forEach(day => {
            html += `<div class="calendar-day-header">${day}</div>`;
        });

        // Add empty cells for days before the first day of the month
        for (let i = 0; i < firstDay; i++) {
            html += '<div class="calendar-day empty"></div>';
        }

        // Add cells for each day of the month
        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(currentYear, currentMonth, day);
            const isToday = date.toDateString() === today.toDateString();
            const hasEvent = events.some(event => event.date.toDateString() === date.toDateString());

            let classes = 'calendar-day';
            if (isToday) classes += ' today';
            if (hasEvent) classes += ' has-event';

            html += `<div class="${classes}" data-date="${date.toISOString()}">${day}</div>`;
        }

        html += '</div>';
        calendar.innerHTML = html;

        // Add event listeners for month navigation
        document.getElementById('prevMonth').addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        });

        // Add event listeners for day clicks
        document.querySelectorAll('.calendar-day:not(.empty)').forEach(day => {
            day.addEventListener('click', () => {
                const date = new Date(day.getAttribute('data-date'));
                const dayEvents = events.filter(event =>
                    event.date.toDateString() === date.toDateString()
                );

                if (dayEvents.length > 0) {
                    let eventList = '<h5>Events on ' + date.toLocaleDateString() + '</h5><ul>';
                    dayEvents.forEach(event => {
                        eventList += `<li>${event.title}</li>`;
                    });
                    eventList += '</ul>';

                    // Show events in a modal or tooltip
                    showToast(eventList, 'info');
                }
            });
        });
    };

    renderCalendar();
}

/**
 * Gallery functionality
 */
function initializeGallery() {
    const galleryItems = document.querySelectorAll('.gallery-item');

    if (!galleryItems.length) return;

    galleryItems.forEach(item => {
        item.addEventListener('click', () => {
            const imgSrc = item.querySelector('img').src;
            const imgAlt = item.querySelector('img').alt;

            // Create lightbox
            const lightbox = document.createElement('div');
            lightbox.className = 'lightbox';
            lightbox.innerHTML = `
                <div class="lightbox-content">
                    <img src="${imgSrc}" alt="${imgAlt}">
                    <button class="lightbox-close">&times;</button>
                </div>
            `;

            document.body.appendChild(lightbox);

            // Close lightbox on click
            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox || e.target.classList.contains('lightbox-close')) {
                    document.body.removeChild(lightbox);
                }
            });
        });
    });
}

/**
 * Testimonial carousel
 */
function initializeTestimonials() {
    const testimonials = document.querySelectorAll('.testimonial');

    if (!testimonials.length) return;

    let currentTestimonial = 0;

    const showTestimonial = (index) => {
        testimonials.forEach((testimonial, i) => {
            testimonial.style.display = i === index ? 'block' : 'none';
        });
    };

    // Show first testimonial
    showTestimonial(currentTestimonial);

    // Auto-rotate testimonials
    setInterval(() => {
        currentTestimonial = (currentTestimonial + 1) % testimonials.length;
        showTestimonial(currentTestimonial);
    }, 5000);

    // Add navigation buttons if they exist
    const prevButton = document.querySelector('.testimonial-prev');
    const nextButton = document.querySelector('.testimonial-next');

    if (prevButton) {
        prevButton.addEventListener('click', () => {
            currentTestimonial = (currentTestimonial - 1 + testimonials.length) % testimonials.length;
            showTestimonial(currentTestimonial);
        });
    }

    if (nextButton) {
        nextButton.addEventListener('click', () => {
            currentTestimonial = (currentTestimonial + 1) % testimonials.length;
            showTestimonial(currentTestimonial);
        });
    }
}

/**
 * FAQ accordion
 */
function initializeFAQ() {
    const faqItems = document.querySelectorAll('.faq-item');

    if (!faqItems.length) return;

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');

        question.addEventListener('click', () => {
            // Toggle active class
            item.classList.toggle('active');

            // Close other items
            faqItems.forEach(otherItem => {
                if (otherItem !== item && otherItem.classList.contains('active')) {
                    otherItem.classList.remove('active');
                }
            });
        });
    });
}

/**
 * Scroll animations
 */
function initializeAnimations() {
    const animatedElements = document.querySelectorAll('.animate-on-scroll');

    if (!animatedElements.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    animatedElements.forEach(element => {
        observer.observe(element);
    });
}

/**
 * Mobile menu
 */
function initializeMobileMenu() {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    const overlay = document.querySelector('.overlay');

    if (!mobileMenuToggle || !mobileMenu) return;

    const openMobileMenu = () => {
        mobileMenu.classList.add('active');
        if (overlay) overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    const closeMobileMenu = () => {
        mobileMenu.classList.remove('active');
        if (overlay) overlay.classList.remove('active');
        document.body.style.overflow = '';
    };

    mobileMenuToggle.addEventListener('click', openMobileMenu);

    if (overlay) {
        overlay.addEventListener('click', closeMobileMenu);
    }

    const mobileMenuClose = document.querySelector('.mobile-menu-close');
    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', closeMobileMenu);
    }

    // Close mobile menu when clicking on a link
    const mobileMenuLinks = document.querySelectorAll('.mobile-menu-nav a');
    mobileMenuLinks.forEach(link => {
        link.addEventListener('click', closeMobileMenu);
    });
}

/**
 * User menu dropdown
 */
function initializeUserMenu() {
    const userMenu = document.querySelector('.user-menu');

    if (!userMenu) return;

    const userMenuToggle = userMenu.querySelector('.user-menu-toggle');

    userMenuToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        userMenu.classList.toggle('active');
    });

    // Close user menu when clicking outside
    document.addEventListener('click', () => {
        userMenu.classList.remove('active');
    });

    // Prevent closing when clicking inside the menu
    userMenu.addEventListener('click', (e) => {
        e.stopPropagation();
    });
}

/**
 * Toast notifications
 */
function initializeNotifications() {
    // Toast notification functionality is handled by the showToast function
}

/**
 * Show toast notification
 * @param {string} message - The message to show
 * @param {string} type - The type of notification (success, error, warning, info)
 */
function showToast(message, type = 'info') {
    const toastContainer = document.querySelector('.toast-container');

    if (!toastContainer) {
        const container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = 'toast';

    let headerClass = '';
    switch (type) {
        case 'success':
            headerClass = 'bg-success';
            break;
        case 'error':
            headerClass = 'bg-danger';
            break;
        case 'warning':
            headerClass = 'bg-warning';
            break;
        default:
            headerClass = 'bg-primary';
    }

    toast.innerHTML = `
        <div class="toast-header ${headerClass}">
            <strong class="me-auto">Notification</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            ${message}
        </div>
    `;

    document.querySelector('.toast-container').appendChild(toast);

    // Auto-remove toast after 5 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.5s ease';

        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 500);
    }, 5000);

    // Close button functionality
    const closeButton = toast.querySelector('.btn-close');
    closeButton.addEventListener('click', () => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.5s ease';

        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 500);
    });
}

/**
 * Search functionality
 */
function initializeSearch() {
    const searchInput = document.querySelector('.search-box input');
    const searchResults = document.querySelector('.search-results');

    if (!searchInput) return;

    let searchTimeout;

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimeout);

        const query = searchInput.value.trim();

        if (query.length < 2) {
            if (searchResults) {
                searchResults.innerHTML = '';
                searchResults.style.display = 'none';
            }
            return;
        }

        // Simulate search delay
        searchTimeout = setTimeout(() => {
            performSearch(query);
        }, 300);
    });

    const performSearch = (query) => {
        // In a real application, this would be an API call
        // For demo purposes, we'll just show a loading spinner

        if (!searchResults) return;

        searchResults.innerHTML = '<div class="spinner"></div>';
        searchResults.style.display = 'block';

        // Simulate API response delay
        setTimeout(() => {
            // Mock search results
            const results = [
                { title: 'Result 1', url: '#' },
                { title: 'Result 2', url: '#' },
                { title: 'Result 3', url: '#' }
            ];

            if (results.length > 0) {
                let resultsHtml = '<ul class="search-results-list">';
                results.forEach(result => {
                    resultsHtml += `
                        <li>
                            <a href="${result.url}">
                                <h5>${result.title}</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </a>
                        </li>
                    `;
                });
                resultsHtml += '</ul>';

                searchResults.innerHTML = resultsHtml;
            } else {
                searchResults.innerHTML = '<p class="text-center">No results found</p>';
            }
        }, 500);
    };

    // Hide search results when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.search-box') && !e.target.closest('.search-results')) {
            if (searchResults) {
                searchResults.style.display = 'none';
            }
        }
    });
}

/**
 * Filter functionality
 */
function initializeFilters() {
    const filterPills = document.querySelectorAll('.filter-pill');
    const filterableItems = document.querySelectorAll('.filterable-item');

    if (!filterPills.length || !filterableItems.length) return;

    filterPills.forEach(pill => {
        pill.addEventListener('click', () => {
            // Update active pill
            filterPills.forEach(p => p.classList.remove('active'));
            pill.classList.add('active');

            const filter = pill.getAttribute('data-filter');

            // Show/hide items based on filter
            filterableItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
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