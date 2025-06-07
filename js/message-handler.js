document.addEventListener('DOMContentLoaded', function() {
    function setupMessageRemoval() {
        const messages = document.querySelectorAll('#user-messages .msg');
        
        messages.forEach(message => {
            if (!message.classList.contains('fading')) {
                message.classList.add('fading');
                
                setTimeout(() => {
                    message.style.opacity = '0';
                    message.style.transform = 'translateX(20px)';
                    
                    setTimeout(() => {
                        message.remove();
                    }, 300);
                }, 2000);
            }
        });
    }
    
    setupMessageRemoval();
    
    const messagesList = document.getElementById('user-messages');
    if (messagesList) {
        const observer = new MutationObserver(mutations => {
            mutations.forEach(mutation => {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    setupMessageRemoval();
                }
            });
        });
        
        observer.observe(messagesList, { childList: true });
    }
});