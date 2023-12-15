// Like Messages Script


// Each card has a unique id
// We need to get the id of the card that was clicked
// and send it to the server

// Loop through all like buttons

function addFunctionality() {
    console.log("Adding functionality");

    // Get all elements with the class 'message-user'
    var messageUsers = document.querySelectorAll('.message-user');

    // Add a click listener to each 'message-user'
    messageUsers.forEach(function (messageUser) {
        messageUser.addEventListener('click', function () {
            console.log("Message user clicked");
            $sender_id = messageUser.parentNode.parentNode.dataset.senderid;
            $message_id = messageUser.parentNode.parentNode.dataset.messageid;
            // fetchProfile($sender_id);
            displayProfile($message_id);
        });
    });

    // // Get all elements with the class 'like-btn'
    // var likeButtons = document.querySelectorAll('.like-btn');

    // // Add a click listener to each 'like-btn'
    // likeButtons.forEach(function (button) {
    //     button.addEventListener('click', function () {
    //         msgid = button.parentNode.parentNode.parentNode.dataset.messageid;
    //         console.log('Like Message ID:', msgid);
    //         likeMessage(msgid);
    //         button.style.fill = 'red';
    //     });
    // });

}