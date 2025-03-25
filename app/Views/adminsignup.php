<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        };
    </script>
</head>
<body class="h-screen flex items-center justify-center bg-black">
    <div class="flex flex-col md:flex-row bg-white dark:bg-gray-800 dark:text-white rounded-lg shadow-lg max-w-3xl w-full">
        
        <!-- First Div (Logo) -->
        <div class="flex items-center justify-center p-6 md:w-1/2 bg-gray-200 dark:bg-gray-900 rounded-l-lg">
            <img class="h-64 w-64 md:h-80 md:w-80 lg:h-96 lg:w-96 object-contain" 
                 src="https://images.unsplash.com/photo-1567446537708-ac4aa75c9c28?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D" 
                 alt="Logo">
        </div>

        <!-- Second Div (Signup Form) -->
        <div class="flex flex-col p-6 md:w-1/2">
            <div class="mb-8 text-center">
                <h1 class="my-3 text-4xl font-bold">Signup</h1>
                <p class="text-sm dark:text-gray-300">Signup to Create Account</p>
            </div>
            <form action="/logindata" method="POST" class="space-y-6">
                <div class="space-y-4">
                    <div>
                        <label for="username" class="block mb-2 text-sm">User Name</label>
                        <input type="text" name="username" id="username" placeholder="Lala" 
                               class="w-full px-3 py-2 border rounded-md dark:border-gray-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label for="phonenumber" class="block mb-2 text-sm">Phone Number</label>
                        <input type="text" name="phonenumber" id="phonenumber" placeholder="+91 9652485652" 
                               class="w-full px-3 py-2 border rounded-md dark:border-gray-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm">Create Password</label>
                        <input type="password" name="password" id="password" placeholder="*****" 
                               class="w-full px-3 py-2 border rounded-md dark:border-gray-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label for="copassword" class="block mb-2 text-sm">Confirm Password</label>
                        <input type="password" name="copassword" id="copassword" placeholder="*****" 
                               class="w-full px-3 py-2 border rounded-md dark:border-gray-500 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
                <div class="space-y-2">
                    <div>
                        <button type="submit" class="w-full px-8 py-3 font-semibold rounded-md bg-violet-600 text-white hover:bg-violet-700">Sign up</button>
                    </div>
                    <p class="px-6 text-sm text-center dark:text-gray-300">
                        Already have an account?
                        <a href="/adminindex" class="hover:underline text-violet-400">Login</a>.
                    </p>
                </div>
            </form>
        </div>
        
    </div>
</body>
</html>