<?php include 'adminheader.php'; ?>

<!-- Font Awesome CDN for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<main class="p-8 bg-gray-100 min-h-screen flex justify-center">
    <div class="bg-white shadow-2xl rounded-2xl p-6 w-full max-w-6xl overflow-x-auto">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Recent Orders</h2>

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