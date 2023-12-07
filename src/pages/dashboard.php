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


<div class="grid grid-cols-3 max-w-7xl w-ful mx-3 lg:mx-10 gap-5">
    <div class="w-full px-3">
        <p class="text-green-600 font-semibold text-xl">Interact</p>
        <p class="font-semibold">Account Details</p>
        <p>User Name:</p>
        <p><?= htmlspecialchars($full_name); ?></p>
        <p>Email:</p>
        <p><?= htmlspecialchars($email); ?></p>

        <a href="/interact/src/includes/destroy.inc.php" class="mt-10 font-semibold">Sign Out?</a>

    </div>
    <div class="w-full h-screen bg-slate-50 border-l-2 border-gray-300 px-3 col-span-2">
        <p class="">Messages</p>

        <!-- Display Previous Messages -->
        <div class="h-5/6 overflow-scroll" id="msgScroll">
            <?php 
                include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/databaseHandler.classes.php");
                include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/MessageModel.classes.php");
                include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/MessageHandler.classes.php");
                $messageHandler = new MessageHandler();
            
                $messageHandler->displayMessages();
            ?>
        </div>

        <!-- Create Message -->
        <form action="/interact/src/includes/sendmsg.inc.php" method="POST" class="flex pb-5">
            <textarea id="textInput" name="textInput" placeholder="Type here" class="py-3 px-2 w-full border-2 border-gray-300"></textarea>
            <input type="submit" class="flex-shrink-0 ml-2 w-10 h-10 rounded-lg bg-green-600 text-2xl font-semibold cursor-pointer" value=">">
        </form>

    </div>
</div>


<script>
    const textarea = document.getElementById('textInput');

    textarea.addEventListener('input', function () {
        // Auto-expand the textarea as the user types
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    var msgScroll = document.getElementById("msgScroll");
    msgScroll.scrollTop = msgScroll.scrollHeight;
</script>


<!-- Import Footer -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/footer.php") ?>