<!-- Import Header -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/header.php") ?>

<!-- Signup Form -->

<div class="fullContainer">
    <div class="userAuth">
        <p class="font-semibold text-3xl sm:text-xl my-4 ml-1">Create Your Account</p>
        <form method="POST" action="./handlers/" class="flex flex-col gap-2.5">
    
            <span class="">
                <label for="firt_name">First Name</label>
                <input type="text" name="first_name" id="first_name" placeholder="Your first name">
            </span>
    
            <span class="">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" placeholder="Your last name">
            </span>
    
            <span class="">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" placeholder="Your email address">
            </span>
    
            <span class="">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Create a password">
            </span>
    
            <input type="submit" class="" value="Sign up">
    
        </form>
    
        <span class="text-sm font-semibold justify-center mt-5 flex gap-1">
            <p class="text-gray-500">Already have an account?</p>
            <a href=<?= PAGE_PATH . "login.php" ?> class="text-blue-700 hover:underline">Login.</a>
        </span>
    </div>
</div>

<!-- Import Footer -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/footer.php") ?>