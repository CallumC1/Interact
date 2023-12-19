var lastMessageId = null;
async function fetchMessages() {
    $url = "/interact/src/includes/ajaxHandler.inc.php";
    $data = {
        action: "fetchMsgs",
        lastMessageId: lastMessageId,
    };

    $response = await fetch($url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify($data),
    })
    .then (response => response.json())
    .then (data => {
        console.log(data);
        $user_id = data.user_id;
        // If there are no messages to display (in the db), return.
        if (data.result == "noMsgs") {
            console.log("No messages to display.");
            return;
        }

        displayMessages(data, $user_id);
    })
    .catch(error => {
        console.log("Fetch Error, possible timeout, Retrying..");
        setTimeout(fetchMessages, 2000);
    });

};


function displayMessages(data, $user_id) {
    $messageTemplate = fetch('/interact/src/components/message.html')
    .then(componentResponse => componentResponse.text())
    .then(component => {
        data.messages.forEach(msg => {
            // Create a new div using the component
            var msgDiv = document.createElement("div");
            // set the innerHTML of the new div to the component html
            msgDiv.innerHTML = component;

            if (msg.sender_id == $user_id) {
                msgDiv.querySelector('.message-card').style.backgroundColor = "#32a852";
            } 

            msgDiv.dataset.senderid = msg.sender_id;
            msgDiv.dataset.messageid = msg.message_id;
            msgDiv.querySelector('.message-user').innerText = decodeURIComponent(msg.fullname);
            msgDiv.querySelector('.message-content').innerText = decodeURIComponent(msg.message);


            if (msg.liked == true) {
                msgDiv.querySelector('.like-btn').style.fill = 'red';
            }


            // Append the new message to the message container.
            var msgContainer = document.getElementById('msgContainer');
            msgContainer.appendChild(msgDiv);

        });

        // Set the last message id to the last message in the data.
        lastMessageId = data.messages[data.messages.length - 1].message_id;
        console.log("Last message id: " + lastMessageId)


        // Scroll to bottom of message container.
        var msgScroll = document.getElementById("msgContainer");
        msgScroll.scrollTop = msgScroll.scrollHeight;

        addFunctionality();

        // Start the long poll messages function again.
        fetchMessages();

    });
}


// SEND MESSAGE

// On click of submit, send ajax request to send message.
// ADD EVENT LISTENER
var submitBtn = document.getElementById("submitBtn");

submitBtn.addEventListener("click", function(event) {
    event.preventDefault();
    sendMessage();
});

function sendMessage() {
    $url = "/interact/src/includes/ajaxHandler.inc.php";
    $data = {
        action: "sendMsg",
        message: encodeURIComponent(document.getElementById("textInput").value),
    };

    fetch($url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify($data),
    })
    .then (response => response.json())
    .then (data => {
        console.log(data);
        if (data.result == "messageSendSuccess") {

            // Reset the input field.
            document.getElementById("textInput").value = "";
            document.getElementById("textInput").style.height = "auto";
        }
    })
}

// On page load functions.
fetchMessages();

function updateBio() {
    $url = "/interact/src/includes/ajaxHandler.inc.php";
    $data = {
        action: "updateBio",
        bio_message: encodeURIComponent(document.getElementById("bio_message").value),
    };

    fetch($url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify($data),
    })
    .then (response => response.json())
    .then (data => {
        console.log(data);

        if (data.result == "bioUpdateSuccess") {
            // Reset the input field.
            // document.getElementById("bioInput").value = "";
            document.getElementById("bioInput").style.height = "auto";
        }
    })
}


async function fetchProfile($user_id) {
    $url = "/interact/src/includes/ajaxHandler.inc.php";
    $data = {
        action: "fetchProfile",
        user_id: $user_id,
    };

    fetch($url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify($data),
    })
    .then (response => response.json())
    .then (data => {
        if (data.result == "profileFetchSuccess") {
            console.log(data.user_data);
            fetchProfileTemplate(data.user_data);
        } else {
            console.log("Profile fetch failed.");
            return;
        }
        
    })
}

function fetchProfileTemplate($data) {
    $profileTemplate = fetch('/interact/src/components/profileTemplate.html')
    .then(componentResponse => componentResponse.text())
    .then(component => {

        $first_name = $data.user_first_name;
        $last_name = $data.user_last_name;
        $about = $data.user_about;

        var profileDiv = document.createElement("div");
        profileDiv.innerHTML = component;
        console.log("fn " + $first_name);  

        if ($about == null || $about == "") {
            $about = "No bio yet.";
        }
        console.log($about);
        
        profileDiv.querySelector('.profile-name').innerText = $first_name + " " + $last_name;
        profileDiv.querySelector('.profile-about').innerText = $about;

        // var locationContainer = document.getElementById('profileContainer');
        document.body.appendChild(profileDiv);
        
    })
};

// Like Messages
function likeMessage(messageId) {
    console.log("Like message function called.");
    var url = "/interact/src/includes/ajaxHandler.inc.php";
    var data = {
        action: "likeMsg",
        messageId: messageId,
    };

    return new Promise(function (resolve, reject) {
        fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                console.log("aaa: " + data.result);
                resolve(data.result);
            })
            .catch(function (error) {
                console.log(error);
                reject(error);
            });
    });
}

