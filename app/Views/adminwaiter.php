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

    <!-- Add Waiter Form -->
    <div class="bg-white shadow p-4 mt-4 mx-auto max-w-4xl rounded">
        <h2 class="text-xl font-semibold mb-3">Add New Waiter</h2>
        <form id="addWaiterForm" action="<?= base_url('admin/addWaiter') ?>" method="post" class="space-y-4">
            <div class="flex space-x-4 mb-4">
                <input type="text" name="waiterName" placeholder="Waiter User Name" class="border p-2 flex-1 rounded" required>
                <input type="text" name="waiterMobile" pattern="\d{10}" placeholder="Waiter Mobile No." class="border p-2 flex-1 rounded" required>
            </div>
            <div class="flex space-x-4 mb-4">
                <input type="text" name="rangeFrom" placeholder="Table No. From" class="border p-2 rounded w-1/2" required>
                <input type="text" name="rangeTo" placeholder="Table No. To" class="border p-2 rounded w-1/2" required>
                <input type="password" name="password" maxlength="10" minlength="5" placeholder=" password" class="border p-2 flex-1 rounded" required>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full md:w-auto">Add Waiter</button>
        </form>
    </div>

    <!-- Waiter List -->
    <div id="waiterList" class="mt-6 mx-auto max-w-4xl">
        <div class="bg-white shadow rounded p-4">
            <h2 class="text-xl font-semibold mb-3">Waiter List</h2>
            <table class="w-full border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">Waiter Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Waiter Mobile No</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Table Allocation</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Password</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($waiters as $waiter): ?>
                        <tr>
                            <form action="<?= base_url('admin/updateWaiter') ?>" method="post">
                                <input type="hidden" name="id" value="<?= $waiter['id'] ?>">
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="text" name="waitername" value="<?= esc($waiter['waitername']) ?>" class="border p-1 rounded w-full">
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="text" name="phonenumber" value="<?= esc($waiter['phonenumber']) ?>" class="border p-1 rounded w-full">
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="text" name="tablealloted" value="<?= esc($waiter['tablealloted']) ?>" class="border p-1 rounded w-full">
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="text" name="password" value="<?= esc($waiter['password']) ?>" class="border p-1 rounded w-full">
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <div class="flex space-x-2 justify-center">
                                        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Save</button>
                                        <a href="<?= base_url('admin/deleteWaiter/'.$waiter['id']) ?>" class="bg-red-500 text-white p-2 rounded" onclick="return confirm('Are you sure?')">Delete</a>
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