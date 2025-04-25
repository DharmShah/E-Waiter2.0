<?php include 'adminheader.php'; ?>

<!-- Main Content -->
<main class="flex-1 p-8">

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Toggle Add Chef Button -->
    <div class="max-w-4xl mx-auto mb-4">
        <button onclick="toggleChefForm()" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
            + Add Chef
        </button>
    </div>

    <!-- Add Chef Form (Hidden by Default) -->
    <div id="addChefForm" class="bg-white shadow p-4 mt-2 mx-auto max-w-4xl rounded hidden">
        <h2 class="text-xl font-semibold mb-3">Add New Chef</h2>
        <form action="<?= base_url('admin/addChef') ?>" method="post" class="space-y-4">
            <div class="flex space-x-4 mb-4">
                <input type="text" name="name" placeholder="Chef Name" class="border p-2 flex-1 rounded" required>
                <input type="text" name="phonenumber" pattern="\d{10}" placeholder="Chef Mobile No." class="border p-2 flex-1 rounded" required>
                <input type="password" name="password" maxlength="10" minlength="5" placeholder="Password" class="border p-2 flex-1 rounded" required>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded w-full md:w-auto">Add Chef</button>
        </form>
    </div>

    <!-- Chef List -->
    <div class="mt-6 mx-auto max-w-4xl">
        <div class="bg-white shadow rounded p-4">
            <h2 class="text-xl font-semibold mb-3">Chef List</h2>
            <table class="w-full border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Mobile No</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Password</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($chefs as $chef): ?>
                        <tr>
                            <form action="<?= base_url('admin/updateChef') ?>" method="post">
                                <input type="hidden" name="id" value="<?= $chef['id'] ?>">
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="text" name="name" value="<?= esc($chef['name']) ?>" class="border p-1 rounded w-full">
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="text" name="phonenumber" value="<?= esc($chef['phonenumber']) ?>" class="border p-1 rounded w-full">
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="text" name="password" value="<?= esc($chef['password']) ?>" class="border p-1 rounded w-full">
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <div class="flex space-x-2 justify-center">
                                        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Save</button>
                                        <a href="<?= base_url('admin/deleteChef/'.$chef['id']) ?>" class="bg-red-500 text-white p-2 rounded" onclick="return confirm('Are you sure?')">Delete</a>
                                    </div>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Toggle Script -->
<script>
    function toggleChefForm() {
        const form = document.getElementById('addChefForm');
        form.classList.toggle('hidden');
    }
</script>