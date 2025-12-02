// Water Refilling Station Management System - Main JavaScript

// Form validation helper
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;

    const inputs = form.querySelectorAll('input[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('error');
            isValid = false;
        } else {
            input.classList.remove('error');
        }
    });

    return isValid;
}

// Clear input error on focus
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.form-input');
    inputs.forEach(input => {
        input.addEventListener('focus', function () {
            this.classList.remove('error');
        });
    });
});

// Confirmation dialogs for delete actions
function confirmDelete(itemName) {
    return confirm(`Are you sure you want to delete ${itemName}?`);
}

// Toast notification (simple)
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background-color: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#0ea5e9'};
        color: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Handle responsive sidebar toggle for mobile
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
        sidebar.classList.toggle('active');
    }
}
