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

    <!-- Messages -->
    <div class="w-full h-screen bg-slate-50 border-t-2 md:border-t-0 md:border-l-2 border-gray-300 px-3 col-span-3 md:col-span-2">
        <span class="flex justify-between">
            <p class="text-3xl font-semibold">Messages</p>
            <p id="menuBtn" class="text-xl md:hidden">Menu</p>
        </span>

        <!-- Display Previous Messages -->
        <div class="h-5/6 overflow-y-scroll overflow-x-hidden" id="msgContainer">
            <!-- Msgs Here -->
        </div>

        <!-- Create Message -->
        <form action="/interact/src/includes/sendmsg.inc.php" method="POST" class="flex my-5 h-fit">
            <textarea id="textInput" name="textInput" placeholder="Type here" class="bg-slate-100 drop-shadow-md font-semibold placeholder:italic placeholder:font-semibold pt-6 px-2 w-full border-2 border-gray-300 overflow-hidden min-h-[55px] resize-none"></textarea>
            <img id="submitBtn" src="/interact/src/assets/icons/arrow-right.svg" alt="Send Message" class="bg-slate-100 drop-shadow-md ml-2 p-4 cursor-pointer focus:scale-95">
        </form>

    </div>

    <!-- Menu -->
    <div id="menu" class="bg-slate-100 absolute mt-9 md:relative md:mt-0 pt-5 z-20 hidden md:block col-span-3 md:col-span-1 w-screen h-screen px-3">
        <p class="text-green-600 font-semibold text-xl">Interact</p>
        <p class="font-semibold">Account Details</p>
        <p>User Name:</p>
        <p><?= htmlspecialchars($full_name); ?></p>
        <p>Email:</p>
        <p><?= htmlspecialchars($email); ?></p>

        <a href="/interact/src/includes/destroy.inc.php" class="mt-10 font-semibold">Sign Out?</a>

        <div>
            <textarea name="" id="bio_message" placeholder="Write your bio here." class="w-full pl-2"></textarea>
        </div>

        <!-- Profile Container -->
        <div id="profileContainer" >

        </div>

    </div>

</div>


<!-- import page JS scripts -->
<script src="/interact/src/assets/js/likeMessage.js"></script>
<script src="/interact/src/assets/js/ajaxMessages.js"></script>
<script src="/interact/src/assets/js/dashboardScripts.js"></script>

<!-- Import Footer -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/footer.php") ?>
