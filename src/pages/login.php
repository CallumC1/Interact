<!-- Import Header -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/header.php") ?>

<!-- Login Form -->

<div class="fullContainer">
    <div class="userAuth">
        <a href="#" id="goBack" class="ml-1">Go back</a>
        <p class="font-semibold text-3xl sm:text-xl my-4 ml-1">Login To Your Account</p>
        <form method="POST" action="./handlers/" class="flex flex-col gap-2.5">
    
            <span class="">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" placeholder="Your email address">
            </span>
    
            <span class="">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Your password">
            </span>
    
            <input type="submit" class="" value="Login">
    
        </form>
    
        <span class="text-sm font-semibold justify-center mt-5 flex gap-1">
            <p class="text-gray-500">Don't have an account?</p>
            <a href=<?= PAGE_PATH . "signup.php" ?> class="text-blue-700 hover:underline">Sign up.</a>
        </span>
    </div>
</div>

<!-- Import Footer -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/footer.php") ?>
<script src="/interact/src/assets/js/goBack.js" ></script>