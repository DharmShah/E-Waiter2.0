<?php include 'adminheader.php'; ?>

<main class="p-8 bg-gray-100 min-h-screen flex justify-center">
    <div class="bg-white shadow-2xl rounded-2xl p-6 w-full max-w-6xl overflow-x-auto">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Recent Orders</h2>

        <!-- Filter Form -->
        <form method="GET" action="<?= base_url('/admintablestructure') ?>" class="mb-6 flex justify-between items-center flex-wrap gap-4">
            <div class="flex items-center gap-4 flex-wrap">
                <label for="start_datetime" class="text-gray-700">Start Date & Time:</label>
                <input type="datetime-local" id="start_datetime" name="start_datetime" 
                    class="px-4 py-2 border border-gray-300 rounded-lg"
                    value="<?= esc($start_datetime ?? '') ?>">

                <label for="end_datetime" class="text-gray-700">End Date & Time:</label>
                <input type="datetime-local" id="end_datetime" name="end_datetime" 
                    class="px-4 py-2 border border-gray-300 rounded-lg"
                    value="<?= esc($end_datetime ?? '') ?>">
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>

                <!-- Reset Button -->
                <a href="<?= base_url('/admintablestructure') ?>" class="px-6 py-2 bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-700 transition duration-200">
                    <i class="fas fa-undo mr-2"></i>Show All
                </a>
            </div>
        </form>

        <!-- Orders Table -->
        <table class="min-w-full table-auto text-sm text-left border-collapse border border-gray-200 rounded-lg">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 border-b border-gray-200">Order ID</th>
                    <th class="px-6 py-3 border-b border-gray-200">Table No.</th>
                    <th class="px-6 py-3 border-b border-gray-200">Item Name</th>
                    <th class="px-6 py-3 border-b border-gray-200">Item Quantity</th>
                    <th class="px-6 py-3 border-b border-gray-200">Time</th>
                    <th class="px-6 py-3 border-b border-gray-200">Date</th>
                    <th class="px-6 py-3 border-b border-gray-200">Payment Mode</th>
                    <th class="px-6 py-3 border-b border-gray-200">Amount</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-800">
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): 
                        $datetime = new \DateTime($order['datetime']);
                        $itemNames = json_decode($order['itemname'], true);
                        $itemQuantities = json_decode($order['itemquantitie'], true);
                    ?>
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4"><?= esc($order['id']) ?></td>
                            <td class="px-6 py-4"><?= esc($order['tablenumber']) ?></td>
                            <td class="px-6 py-4"><?= esc(implode(', ', $itemNames)) ?></td>
                            <td class="px-6 py-4"><?= esc(implode(', ', $itemQuantities)) ?></td>
                            <td class="px-6 py-4"><?= $datetime->format('h:i A') ?></td>
                            <td class="px-6 py-4"><?= $datetime->format('Y-m-d') ?></td>
                            <td class="px-6 py-4"><?= esc($order['paymentmode']) ?></td>
                            <td class="px-6 py-4 font-medium text-green-600">₹<?= esc($order['total']) ?></td>
                            <td class="px-6 py-4 text-center">
                                <a href="<?= base_url('admin/editorder/' . $order['id']) ?>" 
                                   class="text-blue-600 hover:text-blue-800 transition duration-200" 
                                   title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="px-6 py-6 text-center text-red-500">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
