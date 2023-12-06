<!-- Import Header -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/header.php") ?>


<a href="/interact/src/pages/login.php">Login</a>
<a href="/interact/src/pages/signup.php">Sign up</a>

<?php 
session_start();
var_dump($_SESSION); ?>

<!-- Import Footer -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/footer.php") ?>