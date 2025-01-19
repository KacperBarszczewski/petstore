import './bootstrap';

setTimeout(() => {
    const alert = document.getElementById('alert');
    if (alert) {
        alert.classList.add('opacity-0');
        setTimeout(() => alert.remove(), 500);
    }
}, 3000);