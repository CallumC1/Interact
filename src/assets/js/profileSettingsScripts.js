// Submit Bio With Enter Key
const bioTextarea = document.getElementById('bio_message');

bioTextarea.addEventListener('keydown', function (e) {
    if (e.code === "Enter") {
        e.preventDefault();
        updateBio();
    } 
});