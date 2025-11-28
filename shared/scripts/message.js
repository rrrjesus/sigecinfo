document.addEventListener('DOMContentLoaded', function() {
    const messages = document.querySelectorAll('[data-fade-out]');
    messages.forEach(message => {
        const progressBar = message.querySelector('.progress-bar');
        if (progressBar) {
            progressBar.addEventListener('animationend', () => {
                message.style.transition = 'opacity 0.5s ease';
                message.style.opacity = '0';
                setTimeout(() => {
                    message.remove();
                }, 500);
            });
        }
    });
});