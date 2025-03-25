<?php include 'adminheader.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-50 to-blue-100 p-6">

    <!-- Restaurant Setup Form -->
    <div id="restaurantSetup" class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg <?= !empty($restaurant) ? 'hidden' : '' ?>">
        <h2 class="text-2xl font-semibold mb-4 text-center text-blue-600">Restaurant Setup</h2>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form id="restaurantForm" action="<?= base_url('saveAdminControl') ?>" method="post" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="id" id="restaurantId">

            <div>
                <label class="block text-sm font-medium text-gray-700">Restaurant Name</label>
                <input type="text" name="name" id="name" class="w-full p-2 border rounded focus:ring focus:ring-blue-200" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Logo</label>
                <input type="file" name="logo" id="logo" class="w-full p-2 border rounded focus:ring focus:ring-blue-200">
                <div id="logoPreview" class="mt-2"></div> 
            </div>


            <div>
                <label class="block text-sm font-medium text-gray-700">Address</label>
                <textarea name="address" id="address" class="w-full p-2 border rounded focus:ring focus:ring-blue-200" required></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="w-full p-2 border rounded focus:ring focus:ring-blue-200" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" pattern="^\d{10}$" title="Enter a valid 10-digit phone number" class="w-full p-2 border rounded focus:ring focus:ring-blue-200" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Table Count</label>
                <input type="number" name="table_count" id="table_count" class="w-full p-2 border rounded focus:ring focus:ring-blue-200">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Opening Hours</label>
                    <input type="time" name="opening_hours" id="opening_hours" class="w-full p-2 border rounded focus:ring focus:ring-blue-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Closing Hours</label>
                    <input type="time" name="closing_hours" id="closing_hours" class="w-full p-2 border rounded focus:ring focus:ring-blue-200">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Cuisine Type</label>
                <input type="text" name="cuisine_type" id="cuisine_type" class="w-full p-2 border rounded focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">GST Number</label>
                <input type="text" name="gst_number" id="gst_number" class="w-full p-2 border rounded focus:ring focus:ring-blue-200">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition w-full">
                Save
            </button>
        </form>
    </div>

    <!-- Restaurant List -->
    <div class="max-w-6xl mx-auto mt-6 bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold mb-4 text-center text-blue-600">Existing Restaurants</h3>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-blue-100">
                    <tr class="text-blue-700">
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Logo</th>
                        <th class="border p-2">Address</th>
                        <th class="border p-2">Email</th>
                        <th class="border p-2">Phone</th>
                        <th class="border p-2">Table Count</th>
                        <th class="border p-2">Opening Hours</th>
                        <th class="border p-2">Closing Hours</th>
                        <th class="border p-2">Cuisine Type</th>
                        <th class="border p-2">GST Number</th>
                        <th class="border p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($restaurant)): ?>
                        <?php foreach ($restaurant as $res): ?>
                            <tr class="bg-gray-50 hover:bg-gray-100 transition">
                                <td class="border p-2"> <?= esc($res['name']) ?> </td>
                                <td class="border p-2">
                                    <img src="<?= base_url('public/'.$res['logo']) ?>" width="50" class="rounded shadow">
                                </td>
                                <td class="border p-2"> <?= esc($res['address']) ?> </td>
                                <td class="border p-2"> <?= esc($res['email']) ?> </td>
                                <td class="border p-2"> <?= esc($res['phone']) ?> </td>
                                <td class="border p-2"> <?= esc($res['table_count']) ?> </td>
                                <td class="border p-2"> <?= esc($res['opening_hours']) ?> </td>
                                <td class="border p-2"> <?= esc($res['closing_hours']) ?> </td>
                                <td class="border p-2"> <?= esc($res['cuisine_type']) ?> </td>
                                <td class="border p-2"> <?= esc($res['gst_number']) ?> </td>
                                <td class="border p-2">
                                    <button class="bg-yellow-500 text-white px-2 py-1 rounded" onclick="editRestaurant(<?= htmlspecialchars(json_encode($res), ENT_QUOTES, 'UTF-8') ?>)">Edit</button>
                                    <a href="<?= base_url('deleteAdminControl/'.$res['id']) ?>" class="bg-red-500 text-white px-2 py-1 rounded">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11" class="border p-4 text-center text-gray-500">No restaurants found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <script>
        function editRestaurant(data) {
            document.getElementById('restaurantId').value = data.id;
            document.getElementById('name').value = data.name;
            document.getElementById('address').value = data.address;
            document.getElementById('email').value = data.email;
            document.getElementById('phone').value = data.phone;
            document.getElementById('table_count').value = data.table_count;
            document.getElementById('opening_hours').value = data.opening_hours;
            document.getElementById('closing_hours').value = data.closing_hours;
            document.getElementById('cuisine_type').value = data.cuisine_type;
            document.getElementById('gst_number').value = data.gst_number;

            // Show existing logo
            if (data.logo) {
                document.getElementById('logoPreview').innerHTML = `<img src="<?= base_url('public/') ?>${data.logo}" width="100" class="rounded shadow">`;
            } else {
                document.getElementById('logoPreview').innerHTML = "No logo uploaded";
            }

            document.getElementById('restaurantSetup').classList.remove('hidden');
        }
    </script>

</body>
</html>
