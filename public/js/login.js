// Password Toggle
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeOpen = document.getElementById('eye-open');
    const eyeClosed = document.getElementById('eye-closed');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
    } else {
        passwordInput.type = 'password';
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
    }
}

// Turnstile Callbacks
function onTurnstileSuccess(token) {
    console.log('Turnstile verified successfully');
    document.getElementById('submit-btn').disabled = false;
}

function onTurnstileError(error) {
    console.error('Turnstile error:', error);
    document.getElementById('submit-btn').disabled = true;
}

// Form Submit with Loading Animation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submit-btn');
    const btnText = document.getElementById('btn-text');
    const btnLoading = document.getElementById('btn-loading');
    
    if (form && submitBtn && btnText && btnLoading) {
        form.addEventListener('submit', function(e) {
            // Show loading state
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');
            btnLoading.classList.add('flex');
            submitBtn.disabled = true;
            
            // Optional: If form validation fails, re-enable button
            setTimeout(() => {
                if (!form.checkValidity()) {
                    btnText.classList.remove('hidden');
                    btnLoading.classList.add('hidden');
                    btnLoading.classList.remove('flex');
                    submitBtn.disabled = false;
                }
            }, 100);
        });
    }
});

// Handle dark mode changes for Turnstile
if (typeof turnstile !== 'undefined') {
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                const isDark = document.documentElement.classList.contains('dark');
                // Turnstile will automatically adapt based on data-theme attribute
            }
        });
    });
    
    observer.observe(document.documentElement, {
        attributes: true
    });
}
