document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    const previewImage = imagePreview.querySelector('#image-preview img');
    const imageLabel = document.getElementById('image-label');
    const removeButton = document.getElementById('remove-image');
    
    if (previewImage.src && previewImage.src !== window.location.href) {
        imagePreview.classList.add('active');
    }
    
    imageInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            if (file.type.match('image.*')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imagePreview.classList.add('active');
                    
                    const fileName = file.name.length > 20 
                        ? file.name.substring(0, 20) + '...' 
                        : file.name;
                    imageLabel.textContent = fileName;
                };
                
                reader.readAsDataURL(file);
            }
        } else {
            previewImage.src = '';
            imagePreview.classList.remove('active');
            imageLabel.textContent = 'Foto de perfil';
        }
    });
    
    if (removeButton) {
        removeButton.addEventListener('click', function(){
            imageInput.value = '';
            
            previewImage.src = '';
            imagePreview.classList.remove('active');
            
            imageLabel.textContent = 'Foto de perfil';
        });
    }
});