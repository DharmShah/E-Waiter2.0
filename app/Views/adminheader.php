<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-gray-800 p-4 text-white">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center">
            <img src="your_logo.png" alt="Company Logo" class="h-8 mr-2">
        </div>
        <div class="flex items-center">
            <a href="/adminlogout" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Logout
            </a>
        </div>
    </div>
</nav>


    <!-- Sidebar + Main Content -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-200 p-4">
            <h2 class="text-lg font-semibold mb-4">Dashboard</h2>
            <ul>
                <li class="mb-2">
                    <h1 class="block px-4 py-2 rounded hover:bg-gray-300">Navigation</h1>
                </li>
            </ul>

            <div class="mt-3"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 w-full" onclick="window.location.href='<?= base_url('./admindashboard') ?>'" >Analysis</button>
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4 w-full" onclick="window.location.href='<?= base_url('./adminmenu') ?>'">Menu</button>
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4 w-full" onclick="window.location.href='<?= base_url('./adminwaiter') ?>'" >Waiter</button>
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4 w-full" onclick="window.location.href='<?= base_url('./admin/manageAdmins') ?>'" >Admins</button>
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4 w-full" onclick="window.location.href='<?= base_url('./adminchef') ?>'" >Chef</button>
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4 w-full" onclick="window.location.href='<?= base_url('./admincontrol') ?>'" >Admin Control</button>
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4 w-full" onclick="window.location.href='<?= base_url('./admintablestructure') ?>'" >Table Structure</button>
            </div>
        </aside>
        