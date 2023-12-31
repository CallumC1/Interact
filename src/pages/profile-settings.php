<!-- Import Header -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/header.php") ?>

<?php
if (!isset($_SESSION["user_data"]["user_id"])) {
    header("Location: /interact/src/pages/signup.php?error=notLoggedIn");
    exit();
}
$user_data = $_SESSION["user_data"];

$full_name = $user_data["user_first_name"] . " " . $user_data["user_last_name"];
?>   

<div class="flex w-screen h-screen">
    <!-- Include Sidebar -->
    <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/sidebar.php") ?>
    
    <div class="pl-4 w-full h-full bg-slate-300">
        <h1 class="text-2xl font-semibold pt-4">Profile Settings</h1>

        
        <!-- User details -->
        <div class="flex flex-col gap-5">
            <div>
                <p class="font-semibold">Full Name:</p>
                <p><?= $full_name ?></p>
            </div>

            <div>
                <p class="font-semibold">Email:</p>
                <p><?= $user_data["user_email"] ?></p>
            </div>
        </div>


        <!-- Bio -->
        <div class="pt-4 drop-shadow-md ">
            <p class="font-semibold">Personal Bio:</p>
            <textarea name="" id="bio_message" placeholder="Write your bio here." class="w-full md:w-1/2 pl-1 overflow-hidden resize-none outline-none"></textarea>
        </div>

    </div>

</div>

<script src="/interact/src/assets/js/ajaxMessages.js"></script>
<script src="/interact/src/assets/js/profileSettingsScripts.js"></script>
<!-- Import Footer -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/footer.php") ?>
