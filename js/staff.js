document.addEventListener('DOMContentLoaded', function() {
    const categoryRadios = document.querySelectorAll('.category-tabs input[type="radio"]');
    categoryRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            
            document.querySelectorAll('.category').forEach(category => {
                category.classList.remove('active');
            });
            
            
            document.getElementById(this.value).classList.add('active');
        });
    });

    document.addEventListener('change', function(event) {
        if (event.target.matches('input[type="radio"][name$="-sub"]')) {
            const radio = event.target;
            const categoryId = radio.name.replace('-sub', '');
            
            document.querySelectorAll(`#${categoryId} .subcategory`).forEach(sub => {
                sub.classList.remove('active');
            });
            
            document.getElementById(radio.value).classList.add('active');
        }
    });
});