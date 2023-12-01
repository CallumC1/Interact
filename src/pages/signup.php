<!-- Import Header -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/header.php") ?>

</div>

<div class="flex w-screen h-screen m-auto">
    <div class="block md:grid grid-cols-2 w-fit h-fit m-auto rounded-md overflow-hidden drop-shadow-md">
        <!-- Side Panel -->
        <div class="hidden md:block bg-slate-200 bg-[url(/interact/src/assets/svgs/rainbow-vortex.svg)] bg-cover w-full h-full px-10 py-10 text-center">
            <h1 class="font-semibold text-xl text-white">Welcome to interact.</h1>
            <img src="/interact/src/assets/svgs/message-img.svg" class="w-72 h-auto mx-auto mt-5">
        </div>
    
        <!-- Signup Form -->
        <div class="userAuth">
            <p class="font-semibold text-center text-xl mb-4">Create Your Account</p>
            <form method="POST" action="./handlers/" class="flex flex-col">
    
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
            <span class="text-xs font-semibold justify-center mt-2 flex gap-1">
                <p class="text-gray-500">Already have an account?</p>
                <a href="" class="text-blue-700 hover:underline">Login.</a>
            </span>
        </div>
    </div>
</div>

<!-- Import Footer -->
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/footer.php") ?>