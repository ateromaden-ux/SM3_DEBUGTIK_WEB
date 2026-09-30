/**
 * DebugTIK Login/Register Logic
 */

document.addEventListener('DOMContentLoaded', () => {
    // Tab switching (Login/Register)
    const loginTab = document.querySelector('[data-tab="login"]');
    const registerTab = document.querySelector('[data-tab="register"]');
    const loginForm = document.querySelector('[data-form="login"]');
    const registerForm = document.querySelector('[data-form="register"]');

    if (loginTab && registerTab && loginForm && registerForm) {
        loginTab.addEventListener('click', () => {
            loginTab.classList.add('border-b-2', 'border-blue-500', 'text-blue-600');
            registerTab.classList.remove('border-b-2', 'border-blue-500', 'text-blue-600');
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
        });

        registerTab.addEventListener('click', () => {
            registerTab.classList.add('border-b-2', 'border-blue-500', 'text-blue-600');
            loginTab.classList.remove('border-b-2', 'border-blue-500', 'text-blue-600');
            registerForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
        });
    }

    // Password visibility toggle
    const togglePasswordButtons = document.querySelectorAll('[data-toggle-password]');
    
    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-toggle-password');
            const passwordInput = document.getElementById(targetId);
            
            if (passwordInput) {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                button.textContent = isPassword ? 'visibility_off' : 'visibility';
            }
        });
    });

    // Form validation feedback
    const forms = document.querySelectorAll('form[data-form]');
    
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            const inputs = form.querySelectorAll('input[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('border-red-500');
                    input.addEventListener('input', () => {
                        input.classList.remove('border-red-500');
                    }, { once: true });
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });
    });

    // Remember me checkbox
    const rememberCheckbox = document.getElementById('remember');
    if (rememberCheckbox) {
        const savedEmail = localStorage.getItem('debugtik-remember-email');
        if (savedEmail) {
            const emailInput = document.getElementById('email');
            if (emailInput) {
                emailInput.value = savedEmail;
                rememberCheckbox.checked = true;
            }
        }

        rememberCheckbox.addEventListener('change', () => {
            const emailInput = document.getElementById('email');
            if (rememberCheckbox.checked && emailInput) {
                localStorage.setItem('debugtik-remember-email', emailInput.value);
            } else {
                localStorage.removeItem('debugtik-remember-email');
            }
        });
    }
});

// Export for potential external use
export { };
