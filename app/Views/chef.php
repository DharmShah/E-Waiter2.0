<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chef Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex items-center justify-center bg-black">

    <div class="flex flex-col md:flex-row bg-white dark:bg-gray-800 dark:text-white rounded-lg shadow-lg max-w-3xl w-full">
        
        <!-- Logo -->
        <div class="flex items-center justify-center p-6 md:w-1/2 bg-gray-200 dark:bg-gray-900 rounded-l-lg">
            <img src="<?= esc($logoUrl) ?>" alt="Logo"
                 class="h-64 w-64 md:h-80 md:w-80 lg:h-96 lg:w-96 object-contain" />
        </div>

        <!-- Login Form -->
        <div class="flex flex-col p-6 md:w-1/2">
            <div class="mb-8 text-center">
                <h1 class="my-3 text-4xl font-bold">Chef Login</h1>
                <p class="text-sm dark:text-gray-300">Login to manage food orders</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-500 text-white text-sm p-2 rounded-md mb-4">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('checkchef') ?>" method="post" class="space-y-6">
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block mb-2 text-sm">Chef Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter your name"
                            class="w-full px-3 py-2 border rounded-md dark:border-gray-500 dark:bg-gray-700 dark:text-white"
                            required>
                    </div>

                    <div>
                        <label for="password" class="block mb-2 text-sm">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••"
                            class="w-full px-3 py-2 border rounded-md dark:border-gray-500 dark:bg-gray-700 dark:text-white"
                            required>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full px-8 py-3 font-semibold rounded-md bg-violet-600 text-white hover:bg-violet-700 transition">
                        Login
                    </button>
                </div>
            </form>
        </div>

    </div>

</body>
</html>
