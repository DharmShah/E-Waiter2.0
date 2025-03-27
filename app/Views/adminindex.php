<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body class="h-screen flex items-center justify-center bg-black">
    <div class="flex flex-col md:flex-row bg-white dark:bg-gray-800 dark:text-white rounded-lg shadow-lg max-w-3xl w-full">
        
    <div name="firstdiv" class="flex items-center justify-center p-6 md:w-1/2 bg-gray-200 dark:bg-gray-900 rounded-l-lg">
            <img name="logo" class="h-64 w-64 md:h-80 md:w-80 lg:h-96 lg:w-96 object-contain" 
                src="<?= esc($adminData['logo_url']) ?>" 
                alt="Logo">
        </div>

        <!-- Second Div (Login Form) -->
        <div name="seconddiv" class="flex flex-col p-6 md:w-1/2">
            <div class="mb-8 text-center">
                <h1 class="my-3 text-4xl font-bold">Admin Login</h1>
                <p class="text-sm dark:text-gray-300">Login to access Admin account</p>
            </div>

            <!-- Show Flash Error Message -->
            <?php if (session()->getFlashdata('error')): ?>
                <p class="text-red-500 text-center"><?php echo session()->getFlashdata('error'); ?></p>
            <?php endif; ?>

            <form action="/adminlogin" method="POST" class="space-y-6">
                <div class="space-y-4">
                    <div>
                        <label for="username" class="block mb-2 text-sm">User Name</label>
                        <input type="text" name="username" id="username" placeholder="Lala" class="w-full px-3 py-2 border rounded-md dark:border-gray-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <div class="flex justify-between mb-2">
                            <label for="password" class="text-sm">Password</label>
                            <a href="/adminforgotpassword" class="text-xs hover:underline dark:text-gray-300">Forgot password?</a>
                        </div>
                        <input type="password" name="password" id="password" placeholder="*****" class="w-full px-3 py-2 border rounded-md dark:border-gray-500 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
                <div class="space-y-2">
                    <div>
                        <button type="submit" class="w-full px-8 py-3 font-semibold rounded-md bg-violet-600 text-white hover:bg-violet-700">Login</button>
                    </div>
                    <p class="px-6 text-sm text-center dark:text-gray-300">
                        Don't have an account yet?
                        <a href="/adminsignup" class="hover:underline text-violet-400">Sign up</a>.
                    </p>