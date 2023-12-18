// Text box expand JS

const messageTextarea = document.getElementById('textInput');

messageTextarea.addEventListener('input', function (event) {
    // Auto-expand the messageTextarea as the user types unless there are two empty lines above the current line.

    $lines = this.value.split("\n");

    // Get the current line number
    $currentLine = 0;
    for (var i = 0; i < this.selectionStart; i++) {
        if (this.value[i] === "\n") {
            $currentLine++;
        }
    }
    //  Check if there are two empty lines above the current line, if so stop expanding.
    if ($currentLine > 1) {
        $lineTwoAbove = $lines[$currentLine - 2];
        $lineOneAbove = $lines[$currentLine - 1];
        if ($lineOneAbove === "" && $lineTwoAbove === "") {
            // Two empty lines above current line, stop expanding.
            this.value = this.value.substring(0, this.value.length - 1);
        } else {
            // Expand the messageTextarea
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        }
    }

});

// Submit Message With Enter Key
messageTextarea.addEventListener('keydown', function (e) {
    // Prevent the enter key from creating a new line
    if (e.code === "Enter" && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
    } 
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