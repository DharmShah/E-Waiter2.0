<?php include 'adminheader.php'; ?>

    <main class="p-6 bg-gray-100 min-h-screen flex justify-center items-start">
        <div class="bg-white shadow-md rounded-lg p-6 w-screen max-w-3xl">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Order #<?= esc($order['id']) ?></h2>

            <form method="post" action="<?= base_url('admin/updateorder/' . $order['id']) ?>" class="space-y-6" id="editOrderForm">
                <div>
                    <label class="block font-medium text-sm text-gray-700">Table Number</label>
                    <input type="text" name="tablenumber" value="<?= esc($order['tablenumber']) ?>" class="w-full border rounded p-2" />
                </div>

                <div>
                    <label class="block font-medium text-sm text-gray-700">Items & Quantities</label>
                    <div id="itemsContainer" class="space-y-3">
                        <?php foreach ($order['itemname'] as $index => $item): ?>
                            <div class="grid grid-cols-10 gap-2 items-center item-row">
                                <input type="text" name="itemname[]" value="<?= esc($item) ?>" class="col-span-4 border rounded p-2 item-input" />
                                <input type="number" name="itemquantitie[]" value="<?= esc($order['itemquantitie'][$index]) ?>" min="1" class="col-span-4 quantity-input border rounded p-2" />
                                <button type="button" class="delete-row col-span-2 text-red-600 hover:text-red-800 text-xl">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-4">
                        <button type="button" id="addRow" class="text-sm text-blue-600 hover:underline flex items-center">
                            <i class="fas fa-plus mr-1"></i> Add Item
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-sm text-gray-700">Total</label>
                    <input type="text" id="totalField" name="total" value="<?= esc($order['total']) ?>" class="w-full border rounded p-2 bg-gray-100" readonly />
                </div>

                <div>
                    <label class="block font-medium text-sm text-gray-700">Payment Mode</label>
                    <select name="paymentmode" class="w-full border rounded p-2">
                        <option value="Cash" <?= $order['paymentmode'] == 'Cash' ? 'selected' : '' ?>>Cash</option>
                        <option value="UPI" <?= $order['paymentmode'] == 'UPI' ? 'selected' : '' ?>>UPI</option>
                        <option value="Card" <?= $order['paymentmode'] == 'Card' ? 'selected' : '' ?>>Card</option>
                    </select>
                </div>

                <div>
                    <label class="block font-medium text-sm text-gray-700">Date & Time</label>
                    <input type="datetime-local" name="datetime" value="<?= date('Y-m-d\TH:i', strtotime($order['datetime'])) ?>" class="w-full border rounded p-2" />
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const prices = <?= json_encode($prices) ?>;

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const itemInput = row.querySelector('.item-input');
                const quantityInput = row.querySelector('.quantity-input');

                const itemName = (itemInput?.value || "").toLowerCase().trim();
                const quantity = parseInt(quantityInput?.value) || 0;
                const price = prices[itemName] || 0;

                total += quantity * price;
            });
            document.getElementById('totalField').value = total.toFixed(2);
        }

        function addDeleteListener(button) {
            button.addEventListener('click', function () {
                this.closest('.item-row').remove();
                updateTotal();
            });
        }

        function addInputListeners() {
            document.querySelectorAll('.quantity-input, .item-input').forEach(input => {
                input.addEventListener('input', updateTotal);
            });
        }

        document.querySelectorAll('.delete-row').forEach(btn => {
            addDeleteListener(btn);
        });

        document.getElementById('addRow').addEventListener('click', () => {
            const container = document.getElementById('itemsContainer');

            const row = document.createElement('div');
            row.className = 'grid grid-cols-10 gap-2 items-center item-row';
            row.innerHTML = `
                <input type="text" name="itemname[]" placeholder="Item Name" class="col-span-4 border rounded p-2 item-input" />
                <input type="number" name="itemquantitie[]" value="1" min="1" class="col-span-4 quantity-input border rounded p-2" />
                <button type="button" class="delete-row col-span-2 text-red-600 hover:text-red-800 text-xl">
                    <i class="fas fa-trash-alt"></i>
                </button>
            `;

            container.appendChild(row);
            addDeleteListener(row.querySelector('.delete-row'));
            addInputListeners();
            updateTotal();
        });

        updateTotal();
    </script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />