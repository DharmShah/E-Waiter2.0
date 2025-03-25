<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function printBill() {
            window.print();
        }

        function showPaymentPopup() {
            document.getElementById("paymentPopup").classList.remove("hidden");
            document.getElementById("submitPayment").disabled = true;
        }

        function checkPaymentSelection() {
            const paymentMethods = document.querySelectorAll('input[name="paymentMethod"]');
            document.getElementById("submitPayment").disabled = !Array.from(paymentMethods).some(method => method.checked);
        }

        function processPayment() {
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked');
            if (!paymentMethod) {
                alert("Please select a payment method!");
                return;
            }

            alert(`✅ Payment Completed Successfully via ${paymentMethod.value}!`);
            document.getElementById("watermarkTick").classList.remove("hidden");
            document.getElementById("billingTableBody").innerHTML = `
                <tr><td colspan="5" class="text-center text-red-600 font-semibold py-4">Table In Cleaning</td></tr>`;
            document.getElementById("totalQuantity").textContent = "0";
            document.getElementById("grandTotal").textContent = "₹0.00";
            document.getElementById("paymentPopup").classList.add("hidden");
        }

        function updateDateTime() {
            document.getElementById("dateTime").textContent = new Date().toLocaleString();
        }

        window.onload = function () {
            updateDateTime();
        };
    </script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-lg relative">
        
        <div id="watermarkTick" class="hidden absolute inset-0 flex items-center justify-center opacity-20">
            <img src="https://cdn-icons-png.flaticon.com/512/845/845646.png" alt="Paid Stamp" class="w-40">
        </div>

        <div class="relative mt-4 flex justify-between items-center">
    <div class="text-center flex-1">
        <h1 class="text-2xl font-bold text-gray-800">🍽️ Premium Restro</h1>
        <p class="text-sm text-gray-600">123 Food Street, Gourmet City</p>
    </div>
    <button onclick="redirectToMenu()" class="bg-yellow-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md ml-4">
        📜 Menu
    </button>
</div>


        <div class="flex justify-between items-center mt-4 border-b pb-2">
            <span class="text-lg font-semibold text-gray-700">Table No: <?= esc($tableno) ?></span>
            <span id="dateTime" class="text-sm text-gray-600"></span>
        </div>

        <div class="mt-4 overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 text-sm">
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">Item Name</th>
                        <th class="px-4 py-2 text-left">Qty</th>
                        <th class="px-4 py-2 text-left">Price</th>
                        <th class="px-4 py-2 text-left">Subtotal</th>
                    </tr>
                </thead>
                <tbody id="billingTableBody">
                    <?php $totalQuantity = 0; $grandTotal = 0; ?>
                    <?php foreach ($orders as $index => $order): 
                        $subtotal = $order['quantity'] * $order['itemprice'];
                        $totalQuantity += $order['quantity'];
                        $grandTotal += $subtotal;
                    ?>
                    <tr class="hover:bg-gray-100 transition">
                        <td class="px-4 py-3"><?= $index + 1 ?></td>
                        <td class="px-4 py-3"><?= esc($order['itemname']) ?></td>
                        <td class="px-4 py-3"><?= esc($order['quantity']) ?></td>
                        <td class="px-4 py-3">₹<?= number_format($order['itemprice'], 2) ?></td>
                        <td class="px-4 py-3">₹<?= number_format($subtotal, 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="bg-gray-300 text-gray-900 font-semibold">
                        <td colspan="2" class="px-4 py-3 text-right">Total Quantity:</td>
                        <td class="px-4 py-3"><?= esc($totalQuantity) ?></td>
                        <td class="px-4 py-3 text-right">Grand Total:</td>
                        <td class="px-4 py-3">₹<?= number_format($grandTotal, 2) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-6 flex gap-4">
            <button onclick="printBill()" class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg text-lg font-semibold shadow-md">
                🖨️ Print Bill
            </button>
            <button onclick="showPaymentPopup()" class="w-1/2 bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg text-lg font-semibold shadow-md">
                💳 Payment Done
            </button>
        </div>
    </div>

    <div id="paymentPopup" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <h2 class="text-xl font-semibold text-gray-800">Select Payment Method</h2>

            <div class="mt-4 space-y-2">
                <label class="block">
                    <input type="radio" name="paymentMethod" value="Cash" onclick="checkPaymentSelection()" class="mr-2"> Cash
                </label>
                <label class="block">
                    <input type="radio" name="paymentMethod" value="Online" onclick="checkPaymentSelection()" class="mr-2"> Online
                </label>
            </div>

            <button id="submitPayment" onclick="processPayment()" disabled class="mt-4 bg-green-600 text-white py-2 px-6 rounded-lg">
                Submit Payment
            </button>
        </div>
    </div>
    <script>
        function redirectToMenu() {
            window.location.href = "/menu";
        }
    </script>
</body>
</html>