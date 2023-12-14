// Like Messages Script


// Each card has a unique id
// We need to get the id of the card that was clicked
// and send it to the server

// Loop through all like buttons

function addFunctionality() {
    console.log("Adding functionality");

    // Get all elements with the class 'like-btn'
    var likeButtons = document.querySelectorAll('.like-btn');

    // Add a click listener to each 'like-btn'
    likeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            msgid = button.parentNode.parentNode.parentNode.dataset.messageid;
            console.log('Like Message ID:', msgid);
            likeMessage(msgid);
            button.style.fill = 'red';
        });
    });

}