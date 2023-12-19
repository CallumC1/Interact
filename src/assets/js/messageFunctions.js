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
    // Disply a modal with the user's profile.
    messageUsers.forEach(function (messageUser) {
        messageUser.addEventListener('click', function () {
            $sender_id = messageUser.parentNode.parentNode.dataset.senderid;
            $message_id = messageUser.parentNode.parentNode.dataset.messageid;
            fetchProfile($sender_id);
        });
    });


    // Get all elements with the class 'like-btn'
    // Promises: https://chat.openai.com/share/b5789099-c224-4a56-a3f6-169fce2052c2
    var likeButtons = document.querySelectorAll('.like-btn');

    // Add a click listener to each 'like-btn'
    likeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var msgid = button.parentNode.parentNode.parentNode.dataset.messageid;
            console.log('Like Message ID:', msgid);
    
            likeMessage(msgid)
                .then(function (result) {
                    console.log("likemsg: " + result);
                    if (result === "unlikeSuccess") {
                        button.style.fill = 'none';
                    } else {
                        button.style.fill = 'red';
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        });
    });
}

function closeModal() {
    var modals = document.getElementsByClassName("profile-modal");

    for (var i = 0; i < modals.length; i++) {
        modals[i].style.display = "none";
    }
}

