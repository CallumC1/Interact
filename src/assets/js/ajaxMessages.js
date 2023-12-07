
var lastMessageId = null;
function fetchMessages() {
    fetch("/interact/src/includes/ajaxHandler.inc.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "action=getMsgs" + (lastMessageId ? "&lastMessageId=" + lastMessageId : ""),
    })
    .then (response => response.json())
    .then (data => {
        var msgContainer = document.getElementById("msgContainer");

        if (data.result == "noNewMsgs") {
            console.log("No new messages.")
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
                data.result.forEach(msg => {
                    // Create a new div using the component
                    var msgDiv = document.createElement("div");
                    msgDiv.innerHTML = component;

                    // Set content based on data
                    msgDiv.querySelector('.message-user').innerText = msg.fullname;
                    msgDiv.querySelector('.message-content').innerText = msg.message;

                    // Append the new message div to the container
                    msgContainer.appendChild(msgDiv);

                    lastMessageId = msg.message_id;
                    // console.log(lastMessageId);
                });

                // Scroll to bottom of messages by default
                var msgScroll = document.getElementById("msgContainer");
                msgScroll.scrollTop = msgScroll.scrollHeight;

            })
            .catch(error => console.error('Error loading template:', error));
        })
        .catch (error => {
            console.log(error);
    });
}
// Fetch messages every x seconds
setInterval(fetchMessages, 3000);
// Fetch messages on page load
fetchMessages();


// 
// Send messages
// 

var submitBtn = document.getElementById("submitBtn");

submitBtn.addEventListener("click", function(event) {
submitMessage();
event.preventDefault();
});

function submitMessage() {
    // Ensure that special characters are properly encoded
    var message = encodeURIComponent(document.getElementById("textInput").value);
    fetch("/interact/src/includes/ajaxHandler.inc.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "action=sendMsg&message=" + message,
    })
    .then (response => response.json())
    .then (data => {
        console.log(data);
        if (data.result == "success") {
            console.log("Message sent successfully.");
            document.getElementById("textInput").value = "";
            fetchMessages();
        } else {
            console.log("Message failed to send.");
        }
    })
    .catch (error => {
        console.log(error);
    });

}
