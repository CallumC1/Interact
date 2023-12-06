<!-- Import Header -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/header.php") ?>

<?php
if (!isset($_SESSION["user_data"]["user_id"])) {
    header("Location: /interact/src/pages/signup.php?error=notLoggedIn");
    exit();
}

echo("test");

?>

<!-- Import Footer -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/footer.php") ?>