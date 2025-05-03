<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body class="h-screen flex items-center justify-center bg-black">
    <div class="flex flex-col md:flex-row bg-white dark:bg-gray-800 dark:text-white rounded-lg shadow-lg max-w-3xl w-full">
        
        <!-- First Div (Logo) -->
        <div name="firstdiv" class="flex items-center justify-center p-6 md:w-1/2 bg-gray-200 dark:bg-gray-900 rounded-l-lg">
            <img class="h-64 w-64 md:h-80 md:w-80 lg:h-96 lg:w-96 object-contain" src="https://images.unsplash.com/photo-1567446537708-ac4aa75c9c28?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Logo">
        </div>

        <!-- Form Div -->
        <div class="md:w-1/2 p-6 bg-white rounded-lg shadow dark:border dark:bg-gray-800 dark:border-gray-700 sm:p-8">
            <h2 class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                Change Password
            </h2>
            <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" action="forgotpassworddata">
                <div>
                    <label for="phonenumber" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Phone Number</label>
                    <input type="text" name="phonenumber" id="phonenumber" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="+91 9856325471" required>
                    <button class="w-full mt-5 px-4 py-2 text-white bg-green-600 rounded-md hover:bg-blue-700 transition">Get OTP</button>
                </div>
                <div>
                    <label for="otp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Enter OTP</label>
                    <input type="text" name="otp" id="otp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="####" required>
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New Password</label>
                    <input type="password" name="password" id="password" placeholder="******" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                </div>
                <div>
                    <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
                    <input type="password" name="confirm-password" id="confirm-password" placeholder="******" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                </div>  
                <p class="px-6 text-sm text-center dark:text-gray-300">
                    Remembered Password?
                    <a href="login" class="hover:underline text-violet-400">Login</a>.
                </p>            
                <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 transition">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    let otpDiv = document.getElementById("otp").parentElement;
    let passwordDiv = document.getElementById("password").parentElement;
    let confirmPasswordDiv = document.getElementById("confirm-password").parentElement;

    // Initially hide OTP and password fields
    otpDiv.style.display = "none";
    passwordDiv.style.display = "none";
    confirmPasswordDiv.style.display = "none";

    document.querySelector("button").addEventListener("click", function (e) {
        e.preventDefault();
        let phoneNumber = document.getElementById("phonenumber").value;

        fetch("<?= base_url('checkPhoneNumber') ?>", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "phonenumber=" + phoneNumber
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert("OTP Sent Successfully  ");
                otpDiv.style.display = "block"; // Show OTP field
            } else if (data.status === "redirect") {
                window.location.href = data.url; // Redirect to admin page
            } else {
                alert(data.message);
            }
        });
    });

    document.getElementById("otp").addEventListener("input", function () {
        let otpValue = this.value;

        if (otpValue.length === 6) {
            fetch("<?= base_url('verifyOTP') ?>", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "otp=" + otpValue
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert("OTP Verified! You can now reset your password.");
                    otpDiv.style.display = "none"; // Hide OTP field
                    passwordDiv.style.display = "block"; // Show password fields
                    confirmPasswordDiv.style.display = "block";
                } else {
                    alert(data.message);
                }
            });
        }
    });

    document.querySelector("form").addEventListener("submit", function (e) {
        e.preventDefault();
        let password = document.getElementById("password").value;
        let confirmPassword = document.getElementById("confirm-password").value;

        if (password !== confirmPassword) {
            alert("Passwords do not match!");
            return;
        }

        fetch("<?= base_url('resetPassword') ?>", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "password=" + password
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === "success") {
                window.location.href = "<?= base_url('admin') ?>";
            }
        });
    });
});
</script>

</body>
</html>
