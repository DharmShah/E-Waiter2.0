<?php include 'adminheader.php'; ?>

<!-- Main Content -->
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
    <div class="bg-white shadow p-4 mt-4 mx-auto max-w-4xl rounded">
        <h2 class="text-xl font-semibold mb-3">Add New Dish</h2>
        <form action="<?= base_url('/admin/addDish') ?>" method="post" enctype="multipart/form-data">
    <div class="flex flex-col space-y-4 mb-4">
        <input type="text" name="dishName" placeholder="Dish Name" class="border p-2 rounded" required>
        <input type="number" name="dishPrice" placeholder="Price" class="border p-2 rounded" required>

        <!-- Category Dropdown -->
        <select name="dishCategory" id="dishCategory" class="border p-2 rounded" required onchange="toggleOtherCategory()">
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

        <!-- Hidden Input for "Other" Category -->
        <input type="text" name="otherCategory" id="otherCategory" placeholder="Enter Other Category" class="border p-2 rounded hidden">

        <input type="file" name="dishImage" class="border p-2 rounded" required>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add Dish
        </button>
    </div>
</form>
    </div>

    <!-- Menu List -->
    <div class="mt-6 mx-auto max-w-4xl">
        <div class="bg-white shadow rounded p-4">
            <h2 class="text-xl font-semibold mb-3">Menu Items</h2>
            <table class="w-full border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">Image</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Dish Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Price</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Category</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($menuItems)) : ?>
                        <?php foreach ($menuItems as $dish) : ?>
                            <tr>
                                <!-- Form for updating the dish -->
                                <form action="<?= base_url('/admin/updateDish') ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= esc($dish['id']) ?>">
                                    <input type="hidden" name="oldImage" value="<?= esc($dish['imgurl']) ?>">

                                    <td class="border border-gray-300 px-4 py-2">
                                        <img src="<?= base_url('images/' . esc($dish['imgurl'])) ?>" 
                                             alt="<?= esc($dish['itemname']) ?>" 
                                             class="h-16 w-16 object-cover rounded">
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <input type="text" name="dishName" value="<?= esc($dish['itemname']) ?>" class="border p-1 rounded w-full">
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <input type="number" name="dishPrice" value="<?= esc($dish['itemprice']) ?>" class="border p-1 rounded w-full">
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <input type="text" name="dishCategory" value="<?= esc($dish['itemcategory']) ?>" class="border p-1 rounded w-full">
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center flex space-x-2">
                                        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Save</button>
                                        <a href="<?= base_url('admin/deleteDish/' . $dish['id']) ?>" 
                                           onclick="return confirm('Are you sure?');" 
                                           class="bg-red-500 text-white px-3 py-1 rounded">
                                           Delete
                                        </a>
                                    </td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center border border-gray-300 p-4">No dishes found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    function toggleOtherCategory() {
        var categorySelect = document.getElementById("dishCategory");
        var otherCategoryInput = document.getElementById("otherCategory");

        if (categorySelect.value === "other") {
            otherCategoryInput.classList.remove("hidden");
            otherCategoryInput.setAttribute("required", "required");
        } else {
            otherCategoryInput.classList.add("hidden");
            otherCategoryInput.removeAttribute("required");
        }
    }
</script>