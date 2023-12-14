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

        // If there are no messages to display (in the db), return.
        if (data.result == "noMsgs") {
            console.log("No messages to display.");
            return;
        }

        displayMessages(data);
    })
    .catch(error => {
        console.log("Fetch Error, possible timeout, Retrying..");
        setTimeout(fetchMessages, 2000);
    });

};


function displayMessages(data) {
    $messageTemplate = fetch('/interact/src/components/message.html')
    .then(componentResponse => componentResponse.text())
    .then(component => {
        data.messages.forEach(msg => {
            // Create a new div using the component
            var msgDiv = document.createElement("div");
            // set the innerHTML of the new div to the component html
            msgDiv.innerHTML = component;

            msgDiv.dataset.messageid = msg.message_id;
            msgDiv.querySelector('.message-user').innerText = decodeURIComponent(msg.fullname);
            msgDiv.querySelector('.message-content').innerText = decodeURIComponent(msg.message);


            // Append the new message to the message container.
            msgContainer.appendChild(msgDiv);

        });

        // Set the last message id to the last message in the data.
        lastMessageId = data.messages[data.messages.length - 1].message_id;
        console.log("Last message id: " + lastMessageId)


        // Scroll to bottom of message container.
        var msgScroll = document.getElementById("msgContainer");
        msgScroll.scrollTop = msgScroll.scrollHeight;

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
        }
    })
}

// On page load functions.
fetchMessages();

// Set interval to fetch messages every 5 seconds.
// setInterval(fetchMessages, 5000);
