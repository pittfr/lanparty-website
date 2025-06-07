document.addEventListener('DOMContentLoaded', function() {
    const radioButtons = document.querySelectorAll('.option-list li:not(:last-child) input[type="radio"]');
    const menuContents = document.querySelectorAll('.user-menu .menu-content');
    
    function showSelectedContent(inputId) {
        menuContents.forEach(content => {
            content.classList.remove('active');
        });
        
        if (inputId === 'profile-option') {
            document.getElementById('change-info-content').classList.add('active');
        } else if (inputId === 'change-password-option') {
            document.getElementById('change-password-content').classList.add('active');
        }
    }

    radioButtons.forEach(function(radio) {
        radio.addEventListener('change', function() {
            if(this.checked) {
                const optionItems = document.querySelectorAll('.option-list li:not(:last-child)');
                optionItems.forEach(item => {
                    item.classList.remove('active');
                });
                this.closest('li').classList.add('active');
                
                showSelectedContent(this.id);
            }
        });
    });
    
    const checkedRadio = document.querySelector('.option-list li:not(:last-child) input[type="radio"]:checked');
    if (checkedRadio) {
        checkedRadio.closest('li').classList.add('active');
        showSelectedContent(checkedRadio.id);
    } else {
        const firstRadio = document.querySelector('.option-list li:not(:last-child) input[type="radio"]');
        if (firstRadio) {
            firstRadio.checked = true;
            firstRadio.closest('li').classList.add('active');
            showSelectedContent(firstRadio.id);
        }
    }
});