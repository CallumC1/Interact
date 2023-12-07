// Text box expand JS

const textarea = document.getElementById('textInput');

textarea.addEventListener('input', function () {
    // Auto-expand the textarea as the user types
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
});

// Scroll to bottom of messages
var msgScroll = document.getElementById("msgContainer");
msgScroll.scrollTop = msgScroll.scrollHeight;

// Menu button JS
var menu = document.getElementById("menu");
var menuBtn = document.getElementById("menuBtn");
menuBtn.addEventListener("click", function () {
    menu.classList.toggle("hidden");
});