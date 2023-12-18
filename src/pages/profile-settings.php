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
    
    <div class="w-full h-full bg-slate-300">
        <div>
            <textarea name="" id="bio_message" placeholder="Write your bio here." class="w-full pl-2"></textarea>
        </div>
    </div>

</div>

<script src="/interact/src/assets/js/ajaxMessages.js"></script>
<script src="/interact/src/assets/js/profileSettingsScripts.js"></script>
<!-- Import Footer -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/footer.php") ?>
