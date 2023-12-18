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

<div class="flex w-screen h-screen">
    <!-- Include Sidebar -->
    <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/sidebar.php") ?>

    <!-- Message -->
    <div class="bg-slate-300 w-full h-full px-2 md:px-10 lg:px-36">
        <!-- Message Container -->
        <div id="msgContainer" class="msgContainer ">

        </div>

        <!-- Create Message -->
        <div class="flex my-3 h-fit">
            <textarea id="textInput" name="textInput" placeholder="Type here" class="bg-slate-100 text-gray-400 pt-3 px-2 w-full h-12 drop-shadow-md font-semibold rounded-md overflow-hidden resize-none outline-none  placeholder:italic placeholder:font-semibold"></textarea>
            <img id="submitBtn" src="/interact/src/assets/icons/arrow-right.svg" alt="Send Message" class="bg-blue-500 drop-shadow-md ml-2 p-3 rounded-md cursor-pointer hover:scale-95">
        </div>
    </div>
</div>



<!-- import page JS scripts -->
<script src="/interact/src/assets/js/ajaxMessages.js"></script>
<script src="/interact/src/assets/js/dashboardScripts.js"></script>
<script src="/interact/src/assets/js/messageFunctions.js"></script>

<!-- Import Footer -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/footer.php") ?>
