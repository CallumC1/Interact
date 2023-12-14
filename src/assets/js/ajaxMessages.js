
var lastMessageId = null;
function fetchMessages() {
    $url = "/interact/src/includes/ajaxHandler.inc.php";
    $data = {
        action: "getMsgs",
        lastMessageId: lastMessageId
    };
    fetch($url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify($data),
    })
    .then (response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        // console.log("Response text:", response.text());
        return response.json();
    })
    .then (data => {
        var msgContainer = document.getElementById("msgContainer");

        if (data.result == "noNewMsgs") {
            console.log("No new messages.")
            return;
        } 

        if (data.result == "noMsgs") {
            console.log("No messages in db.")
            return;
        } 

        if (lastMessageId == null) {
            console.log("Fetching all messages.");
            msgContainer.innerHTML = "";
        } else {
            console.log("Fetching new messages.");
        }


        // Fetch the message template to display each message
        fetch('/interact/src/components/message.html')
            .then(componentResponse => componentResponse.text())
            .then(component => {
                data.messages.forEach(msg => {
                    // Create a new div using the component
                    var msgDiv = document.createElement("div");
                    msgDiv.innerHTML = component;

                    // Set content based on data
                    // msgDiv.querySelector('.message-id').innerText = msg.message_id;
                    msgDiv.dataset.messageid = msg.message_id;

                    msgDiv.querySelector('.message-user').innerText = msg.fullname;
                    msgDiv.querySelector('.message-content').innerText = msg.message;

                    // if (msg.liked == 1) {
                    //     button.style.fill = 'red';
                    // }

                    // Append the new message div to the container
                    msgContainer.appendChild(msgDiv);

                    lastMessageId = msg.message_id;
                    // console.log(lastMessageId);

                });

                // Scroll to bottom of messages by default
                var msgScroll = document.getElementById("msgContainer");
                msgScroll.scrollTop = msgScroll.scrollHeight;

                // Once generated add like functionality.
                addFunctionality();


                console.log("Messages fetched successfully.");
                console.log("Last message id:", lastMessageId);
                console.log("Fetching new messages.");

            })
            .catch(error => console.error('Error loading template:', error));
            console.log("Error fetching message template. Retrying...");
        })
        .catch (error => {
            if (error.name === "AbortError") {
                console.log("Fetch timeout, Looking for new messages..");
                fetchMessages();
            } else {
                // Log any other errors
                console.error('Fetch error:', error);
                console.error('Stack trace:', error.stack);
            }
    })
    .catch (error => {
        if (error.name === "AbortError") {
            console.log("Fetch timeout, Looking for new messages..");
            fetchMessages();
        } else {
            // Log any other errors
            console.error('Fetch error:', error);
            console.error('Stack trace:', error.stack);
        }
    })
    .finally(() => {
        console.log("Finally");
        fetchMessages(); // Recursively fetch new messages after long-polling.
    });
}



// 
// Send messages 
// 

var submitBtn = document.getElementById("submitBtn");

submitBtn.addEventListener("click", function(event) {
submitMessage();
event.preventDefault();
});

function submitMessage() {
    $url = "/interact/src/includes/ajaxHandler.inc.php";
    $data = {
        action: "sendMsg",
        message: message = encodeURIComponent(document.getElementById("textInput").value)
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
        if (data.result == "success") {
            console.log("Message sent successfully.");
            document.getElementById("textInput").value = "";
            // fetchMessages();
        } else {
            console.log("Message failed to send.");
        }
    })
    .catch (error => {
        console.log(error);
    });

}

// Like Message Ajax

function likeMessage($msgId) {
    console.log("Like message function called.");
    // Ensure that special characters are properly encoded
    fetch("/interact/src/includes/ajaxHandler.inc.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "action=likeMsg&msgId=" + $msgId,
    })
    .then (response => response.json())
    .then (data => {
        console.log(data);
        if (data.result == "success") {
            console.log("Message liked successfully.");
        } else {
            console.log("Message liked failed.");
        }
    })
    .catch (error => {
        console.log(error);
    });

}

// Fetch messages on page load
fetchMessages();