<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex items-center justify-center bg-black">
    <div class="flex flex-col md:flex-row bg-white dark:bg-gray-800 dark:text-white rounded-lg shadow-lg max-w-3xl w-full">
        
        <!-- First Div (Logo) -->
        <div name="firstdiv" class="flex items-center justify-center p-6 md:w-1/2 bg-gray-200 dark:bg-gray-900 rounded-l-lg">
            <img  class="h-64 w-64 md:h-80 md:w-80 lg:h-96 lg:w-96 object-contain" src="https://images.unsplash.com/photo-1567446537708-ac4aa75c9c28?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Logo">
        </div>

        <!-- Second Div (Login Form) -->
        <div name="seconddiv" class="flex flex-col p-6 md:w-1/2">
            <div class="mb-8 text-center">
                <h1 class="my-3 text-4xl font-bold">Waiter Login</h1>
                <p class="text-sm dark:text-gray-300">Login to access your account</p>
            </div>            

            <!-- Display Error Message -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-500 text-white text-sm p-2 rounded-md mb-4">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form action="/login" method="post" class="space-y-6">
                <div class="space-y-4">
                    <div>
                        <label for="username" class="block mb-2 text-sm">User Name</label>
                        <input type="text" name="username" id="username" placeholder="Lala" class="w-full px-3 py-2 border rounded-md dark:border-gray-500 dark:bg-gray-700 dark:text-white" required>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-2">
                            <label for="password" class="text-sm">Password</label>
                        </div>
                        <input type="password" name="password" id="password" placeholder="*****" class="w-full px-3 py-2 border rounded-md dark:border-gray-500 dark:bg-gray-700 dark:text-white" required>
                    </div>
                </div>
                <div class="space-y-2">
                    <div>
                        <button type="submit" class="w-full px-8 py-3 font-semibold rounded-md bg-violet-600 text-white hover:bg-violet-700">Login</button>
                    </div>
                </div>
            </form>
        </div>
        
    </div>
</body>
</html>
