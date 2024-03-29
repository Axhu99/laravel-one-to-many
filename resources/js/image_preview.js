const placeholder = 'https://marcolanci.it/boolean/assets/placeholder.png';
const imageField = document.getElementById('image');
const previewField = document.getElementById('preview');

let blobUrl;

imageField.addEventListener('change', () => {
    //controllo se ho un file
    if (imageField.files && imageField.files[0]) {
        //prendo il file
        const file = imageField.files[0];
        //prepato un URL temporaneo
        blobUrl = URL.createObjectURL(file);
        //lo inserisco nel SRC
        previewField.src = blobUrl;
    }
    else {
        previewField.src = placeholder;
    }
});

window.addEventListener('beforeunload', () => {
    if (blobUrl) URL.revokeObjectURL(blobUrl);
})