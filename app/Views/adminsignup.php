<?php include 'adminheader.php'; ?>

<!-- Main Content -->
<main class="flex-1 p-8">
    <!-- Show Flash Messages -->
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

    <!-- Add Admin Form (Initially Hidden if Admins Exist) -->
    <div id="addAdminFormContainer" class="<?= !empty($admins) ? 'hidden' : '' ?> bg-white shadow p-4 mx-auto max-w-4xl rounded">
        <h2 class="text-xl font-semibold mb-3">Add New Admin</h2>
        <form action="<?= base_url('admin/addAdmin') ?>" method="post" class="space-y-4">
            <div class="flex space-x-4 mb-4">
                <input type="text" name="username" placeholder="Admin Name" class="border p-2 flex-1 rounded" required>
                <input type="text" name="phonenumber" pattern="\d{10}" placeholder="Admin Mobile No." class="border p-2 flex-1 rounded" required>
            </div>
            <div class="flex space-x-4 mb-4">
                <input type="password" name="password" maxlength="10" minlength="5" placeholder="Password" class="border p-2 flex-1 rounded" required>
                <input type="password" name="confirm_password" maxlength="10" minlength="5" placeholder="Confirm Password" class="border p-2 flex-1 rounded" required>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full md:w-auto">
                Add Admin
            </button>
        </form>
    </div>

    <!-- Admin List -->
    <div id="adminList" class="mt-6 mx-auto max-w-4xl">
        <div class="bg-white shadow rounded p-4">
            <h2 class="text-xl font-semibold mb-3">Admin List</h2>
            <table class="w-full border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">Admin Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Admin Mobile No</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Password</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin): ?>
                        <tr>
                            <form action="<?= base_url('admin/updateAdmin') ?>" method="post">
                                <input type="hidden" name="id" value="<?= $admin['id'] ?>">
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="text" name="adminname" value="<?= esc($admin['username']) ?>" class="border p-1 rounded w-full">
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="text" name="phonenumber" value="<?= esc($admin['phonenumber']) ?>" class="border p-1 rounded w-full">
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="text" name="password" value="<?= esc($admin['password']) ?>" class="border p-1 rounded w-full">
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <div class="flex space-x-2 justify-center">
                                        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Save</button>
                                        <a href="<?= base_url('admin/deleteAdmin/'.$admin['id']) ?>" class="bg-red-500 text-white p-2 rounded" onclick="return confirm('Are you sure?')">Delete</a>
                                    </div>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Button to Show Form (Placed Below the List) -->
    <?php if (!empty($admins)): ?>
        <div class="text-center mt-4">
            <button id="showAddAdminForm" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Admin
            </button>
        </div>
    <?php endif; ?>

</main>

<!-- JavaScript for Show/Hide Form -->
<script>
    document.getElementById('showAddAdminForm')?.addEventListener('click', function () {
        document.getElementById('addAdminFormContainer').classList.toggle('hidden');
    });
</script>