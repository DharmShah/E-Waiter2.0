<?php include 'adminheader.php'; ?>

<main class="flex-1 p-8">
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

    <!-- Add Dish Form -->
    <div class="bg-white shadow p-6 mt-4 mx-auto max-w-4xl rounded">
        <h2 class="text-xl font-semibold mb-4">Add New Dish</h2>
        <form action="<?= base_url('/admin/addDish') ?>" method="post" enctype="multipart/form-data" class="space-y-4">
            <input type="text" name="dishName" placeholder="Dish Name" class="w-full border p-2 rounded" required>
            <input type="number" name="dishPrice" placeholder="Price" class="w-full border p-2 rounded" required>

            <!-- Category Dropdown -->
            <select name="dishCategory" id="dishCategory" class="w-full border p-2 rounded" required onchange="toggleOtherCategory()">
                <option value="" selected disabled>Select Category</option>
                <option value="Soups">Soups</option>
                <option value="Starter">Starter</option>
                <option value="Salads">Salads</option>
                <option value="Sabji">Sabji</option>
                <option value="Roti">Roti</option>
                <option value="Drinks">Drinks</option>
                <option value="Rice">Rice</option>
                <option value="Desserts">Desserts</option>
                <option value="other">Other</option>
            </select>

            <input type="text" name="otherCategory" id="otherCategory" placeholder="Enter Other Category" class="w-full border p-2 rounded hidden">

            <!-- Trending Checkbox -->
            <div class="flex items-center space-x-2">
                <input type="checkbox" name="isTrending" id="isTrending" value="1" class="h-4 w-4">
                <label for="isTrending" class="text-sm font-medium">Mark as Trending</label>
            </div>

            <input type="file" name="dishImage" class="w-full border p-2 rounded" required>

            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white py-2 px-4 rounded">
                Add Dish
            </button>
        </form>
    </div>

    <!-- Dish List -->
    <div class="mt-10 mx-auto max-w-6xl">
        <div class="bg-white shadow rounded p-6">
            <h2 class="text-xl font-semibold mb-4">All Dishes</h2>
            <table class="w-full border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2 text-left">Image</th>
                        <th class="border px-3 py-2 text-left">Name</th>
                        <th class="border px-3 py-2 text-left">Price</th>
                        <th class="border px-3 py-2 text-left">Category</th>
                        <th class="border px-3 py-2 text-center">Trending</th>
                        <th class="border px-3 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($menuItems)): ?>
                        <?php foreach ($menuItems as $dish): ?>
                            <tr class="border-b">
                                <form action="<?= base_url('/admin/updateDish') ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= esc($dish['id']) ?>">
                                    <input type="hidden" name="oldImage" value="<?= esc($dish['imgurl']) ?>">

                                    <td class="px-3 py-2">
                                        <img src="<?= base_url('images/' . esc($dish['imgurl'])) ?>" class="h-16 w-16 object-cover rounded">
                                    </td>
                                    <td class="px-3 py-2">
                                        <input type="text" name="dishName" value="<?= esc($dish['itemname']) ?>" class="w-full border p-1 rounded">
                                    </td>
                                    <td class="px-3 py-2">
                                        <input type="number" name="dishPrice" value="<?= esc($dish['itemprice']) ?>" class="w-full border p-1 rounded">
                                    </td>
                                    <td class="px-3 py-2">
                                        <input type="text" name="dishCategory" value="<?= esc($dish['itemcategory']) ?>" class="w-full border p-1 rounded">
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <input type="checkbox" name="isTrending" value="1" <?= $dish['trending'] ? 'checked' : '' ?> class="h-4 w-4">
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <div class="flex justify-center gap-2">
                                            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Save</button>
                                            <a href="<?= base_url('admin/deleteDish/' . $dish['id']) ?>"
                                               onclick="return confirm('Are you sure you want to delete this dish?');"
                                               class="bg-red-500 text-white px-3 py-1 rounded">
                                                Delete
                                            </a>
                                        </div>
                                    </td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">No dishes available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    function toggleOtherCategory() {
        const select = document.getElementById("dishCategory");
        const otherInput = document.getElementById("otherCategory");
        if (select.value === "other") {
            otherInput.classList.remove("hidden");
            otherInput.setAttribute("required", "required");
        } else {
            otherInput.classList.add("hidden");
            otherInput.removeAttribute("required");
        }
    }
</script>