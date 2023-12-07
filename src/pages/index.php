<!-- Import Header -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/header.php") ?>


<a href="/interact/src/pages/login.php">Login</a>
<a href="/interact/src/pages/signup.php">Sign up</a>
<a href="/interact/src/pages/dashboard.php">Dashboard</a>
<a href="/interact/src/includes/destroy.inc.php">Sign Out</a>

<?php 
var_dump($_SESSION); ?>

<!-- Import Footer -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/footer.php") ?>