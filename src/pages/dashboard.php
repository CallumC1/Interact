<!-- Import Header -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/header.php") ?>

<?php
if (!isset($_SESSION["user_data"]["user_id"])) {
    header("Location: /interact/src/pages/signup.php?error=notLoggedIn");
    exit();
}
$user_data = $_SESSION["user_data"];

$full_name = $user_data["user_first_name"] . " " . $user_data["user_last_name"];
$email = $user_data["user_email"];
?>


<div class="grid grid-cols-3 max-w-7xl w-full mx-auto">
    <div id="menu" class="hidden md:block col-span-3 md:col-span-1 w-full px-3">
        <p class="text-green-600 font-semibold text-xl">Interact</p>
        <p class="font-semibold">Account Details</p>
        <p>User Name:</p>
        <p><?= htmlspecialchars($full_name); ?></p>
        <p>Email:</p>
        <p><?= htmlspecialchars($email); ?></p>

        <a href="/interact/src/includes/destroy.inc.php" class="mt-10 font-semibold">Sign Out?</a>

    </div>
    <div class="w-full h-screen bg-slate-50 border-t-2 md:border-t-0 md:border-l-2 border-gray-300 px-3 col-span-3 md:col-span-2">
        <span class="flex justify-between">
            <p class="text-3xl font-semibold">Messages</p>
            <p id="menuBtn" class="text-xl md:hidden">Menu</p>
        </span>

        <!-- Display Previous Messages -->
        <div class="h-5/6 overflow-y-scroll" id="msgContainer">
            <!-- Msgs Here -->
        </div>

        <!-- Create Message -->
        <form action="/interact/src/includes/sendmsg.inc.php" method="POST" class="flex my-5 h-fit">
            <textarea id="textInput" name="textInput" placeholder="Type here" class=" px-2 w-full border-2 border-gray-300 overflow-hidden"></textarea>
            <input type="submit" class="flex-shrink-0 ml-2 w-12 h-12 rounded-lg bg-green-600 text-2xl font-semibold cursor-pointer" value=">">
        </form>

    </div>
</div>

<script>
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
                        console.log(lastMessageId);
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
    setInterval(fetchMessages, 2000);
    // Fetch messages on page load
    fetchMessages();
</script>


<script>
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
</script>


<!-- Import Footer -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/footer.php") ?>