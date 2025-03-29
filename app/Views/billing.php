<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing - <?= esc($admincontrol[0]['name'] ?? 'Restaurant') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body * { visibility: hidden; }
            .print-container, .print-container * { visibility: visible; }
            .print-container { position: absolute; left: 0; top: 0; width: 100%; margin: 0; padding: 0; }
            .no-print { display: none !important; }
            .watermark-tick { opacity: 0.15 !important; }
        }
    </style>
</head>
<body class="bg-gray-100 p-4 md:p-6">
    <div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40"></div>
    <div class="max-w-3xl mx-auto bg-white p-4 md:p-6 rounded-lg shadow-lg relative print-container">
        <div id="watermarkTick" class="hidden absolute inset-0 flex items-center justify-center opacity-20 pointer-events-none watermark-tick">
            <img src="https://cdn-icons-png.flaticon.com/512/148/148767.png" alt="Paid Stamp" class="w-32 md:w-40" onerror="this.src='https://cdn-icons-png.flaticon.com/512/1828/1828640.png'">
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center mb-4">
            <div class="text-center md:text-left mb-4 md:mb-0">
                <div class="flex items-center mb-2">
                    <img src="<?= esc($admincontrol[0]['logo_url'] ?? 'https://via.placeholder.com/64?text=LOGO') ?>" 
                     alt="Restaurant Logo" 
                     style="height: 150px;" 
                     class="object-contain" 
                     onerror="this.src='https://via.placeholder.com/64?text=LOGO/'">
                </div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-800"><?= esc($admincontrol[0]['name'] ?? 'Restaurant') ?></h1>
                <p class="text-xs md:text-sm text-gray-600"><?= esc($admincontrol[0]['address'] ?? '123 Main Street, City') ?></p>
                <p class="text-xs md:text-sm text-gray-600">Phone: <?= esc($admincontrol[0]['phone'] ?? '+91 XXXXX XXXXX') ?></p>
            </div>
            <div class="text-right">
                            <button onclick="redirectToMenu()" class="bg-yellow-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md ml-4">
                📜 Menu
            </button>
                <div class="text-lg font-semibold text-gray-700">Bill No: <?= esc($billno ?? '001') ?></div>
                <div id="dateTime" class="text-sm text-gray-600 mb-2"><?= date('d M Y, h:i A') ?></div>
                <div class="text-lg font-semibold text-gray-700">Table No: <?= esc($tableno ?? '01') ?></div>
                <?php if (!empty($customername)): ?><div class="text-sm text-gray-600">Customer: <?= esc($customername) ?></div><?php endif; ?>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 text-xs md:text-sm">
                        <th class="px-2 md:px-4 py-2 text-left w-8">#</th>
                        <th class="px-2 md:px-4 py-2 text-left">Item</th>
                        <th class="px-2 md:px-4 py-2 text-center w-16">Qty</th>
                        <th class="px-2 md:px-4 py-2 text-right w-20">Price</th>
                        <th class="px-2 md:px-4 py-2 text-right w-24">Total</th>
                    </tr>
                </thead>
                <tbody id="billingTableBody">
                    <?php 
                    $totalQuantity = $grandTotal = 0;
                    $gstRate = $admincontrol[0]['gst_rate'] ?? 5;
                    foreach ($orders as $index => $order): 
                        $subtotal = $order['quantity'] * $order['itemprice'];
                        $totalQuantity += $order['quantity'];
                        $grandTotal += $subtotal;
                    ?>
                    <tr class="border-b text-xs md:text-sm">
                        <td class="px-2 md:px-4 py-2"><?= $index + 1 ?></td>
                        <td class="px-2 md:px-4 py-2"><?= esc($order['itemname']) ?></td>
                        <td class="px-2 md:px-4 py-2 text-center"><?= esc($order['quantity']) ?></td>
                        <td class="px-2 md:px-4 py-2 text-right">₹<?= number_format($order['itemprice'], 2) ?></td>
                        <td class="px-2 md:px-4 py-2 text-right">₹<?= number_format($subtotal, 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($orders)): ?><tr><td colspan="5" class="text-center py-4 text-gray-500">No items in this bill</td></tr><?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="bg-gray-100 text-gray-900 font-semibold text-sm md:text-base">
                        <td colspan="2" class="px-4 py-2 text-right">Subtotal:</td>
                        <td class="px-4 py-2 text-center" id="totalQuantity"><?= $totalQuantity ?></td>
                        <td colspan="2" class="px-4 py-2 text-right">₹<?= number_format($grandTotal, 2) ?></td>
                    </tr>
                    <?php if (!empty($admincontrol[0]['gst_number'])): ?>
                    <tr class="bg-gray-50 text-gray-700 text-xs md:text-sm">
                        <td colspan="4" class="px-4 py-1 text-right">GST (<?= $gstRate ?>%):</td>
                        <td class="px-4 py-1 text-right">₹<?= number_format($grandTotal * ($gstRate/100), 2) ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr class="bg-gray-200 text-gray-900 font-bold text-sm md:text-base">
                        <td colspan="4" class="px-4 py-3 text-right">Total Payable:</td>
                        <td class="px-4 py-3 text-right" id="grandTotal">₹<?= number_format($grandTotal * (1 + ($gstRate/100)), 2) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>



        <div class="mt-6 flex flex-col sm:flex-row gap-3 no-print">            
            <button onclick="showPaymentPopup()" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg font-semibold shadow-md transition duration-300 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Payment
            </button>
        </div>
                <div class="mt-6 text-center text-xs md:text-sm text-gray-500">
            <p>Thank you for dining with us!</p>
            <p class="mt-1"><?= esc($admincontrol[0]['footer_message'] ?? 'Please visit again') ?></p>
        </div>
    </div>


    <div id="paymentPopup" class="hidden fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md mx-4">
            <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Payment Method</h2>
            <div class="mt-4 space-y-3">
                <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="paymentMethod" value="Cash" onclick="checkPaymentSelection()" class="h-5 w-5 text-green-600">
                    <span class="ml-3 text-gray-700">Cash</span>
                </label>
                <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="paymentMethod" value="Credit Card" onclick="checkPaymentSelection()" class="h-5 w-5 text-green-600">
                    <span class="ml-3 text-gray-700">Credit Card</span>
                    <img src="https://cdn-icons-png.flaticon.com/512/179/179457.png" class="w-6 h-6 ml-auto" alt="Credit Card">
                </label>
                <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="paymentMethod" value="Debit Card" onclick="checkPaymentSelection()" class="h-5 w-5 text-green-600">
                    <span class="ml-3 text-gray-700">Debit Card</span>
                    <img src="https://cdn-icons-png.flaticon.com/512/196/196578.png" class="w-6 h-6 ml-auto" alt="Debit Card">
                </label>
                <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="paymentMethod" value="UPI" onclick="checkPaymentSelection()" class="h-5 w-5 text-green-600">
                    <span class="ml-3 text-gray-700">UPI Payment</span>
                    <img src="https://cdn-icons-png.flaticon.com/512/825/825454.png" class="w-6 h-6 ml-auto" alt="UPI">
                </label>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button onclick="hidePaymentPopup()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">Cancel</button>
                <button id="submitPayment" onclick="processPayment()" disabled class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition">Confirm Payment</button>
            </div>
        </div>
    </div>

    <script>
        function updateDateTime() {
            document.getElementById("dateTime").textContent = new Date().toLocaleString('en-IN', { 
                day: 'numeric', month: 'short', year: 'numeric',
                hour: '2-digit', minute: '2-digit', hour12: true 
            });
        }
        function showPaymentPopup() {
            document.getElementById("paymentPopup").classList.remove("hidden");
            document.getElementById("overlay").classList.remove("hidden");
            document.body.style.overflow = 'hidden';
        }
        function hidePaymentPopup() {
            document.getElementById("paymentPopup").classList.add("hidden");
            document.getElementById("overlay").classList.add("hidden");
            document.body.style.overflow = 'auto';
        }
        function checkPaymentSelection() {
            document.getElementById("submitPayment").disabled = 
                !document.querySelector('input[name="paymentMethod"]:checked');
        }
        function processPayment() {
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked');
            if (!paymentMethod) return alert("Please select a payment method!");
            
            const submitBtn = document.getElementById("submitPayment");
            submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';
            submitBtn.disabled = true;

            setTimeout(() => {
                document.getElementById("watermarkTick").classList.remove("hidden");
                document.getElementById("billingTableBody").innerHTML = `<tr><td colspan="5" class="text-center text-green-600 font-semibold py-4">Payment Successful!</td></tr>`;
                hidePaymentPopup();
                submitBtn.innerHTML = 'Confirm Payment';
                document.querySelector('button[onclick="showPaymentPopup()"]').disabled = true;
                document.querySelector('button[onclick="showPaymentPopup()"]').classList.add('opacity-50', 'cursor-not-allowed');
                alert(`Payment of ₹${document.getElementById("grandTotal").textContent} completed via ${paymentMethod.value}`);
            }, 2000);
        }
        window.onload = function() {
            updateDateTime();
            setInterval(updateDateTime, 60000);
            document.querySelectorAll('img').forEach(img => {
                img.onerror = function() {
                    if (this.id !== 'watermarkTickImg') this.src = 'https://via.placeholder.com/64?text=Image+Not+Found';
                };
            });
        };
        function redirectToMenu() {
            window.location.href = "/menu";
        }

        function processPayment() {
    const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked');
    if (!paymentMethod) return alert("Please select a payment method!");

    const submitBtn = document.getElementById("submitPayment");
    submitBtn.innerHTML = 'Processing...';
    submitBtn.disabled = true;

    const tableno = <?= json_encode($tableno) ?>; // Get the Table Number

    fetch('/clear-bill', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ tableno })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            document.getElementById("watermarkTick").classList.remove("hidden");
            document.getElementById("billingTableBody").innerHTML = `<tr><td colspan="5" class="text-center text-green-600 font-semibold py-4">Payment Successful!</td></tr>`;
            hidePaymentPopup();
            submitBtn.innerHTML = 'Confirm Payment';
            document.querySelector('button[onclick="showPaymentPopup()"]').disabled = true;
            alert(`Payment of ₹${document.getElementById("grandTotal").textContent} completed via ${paymentMethod.value}`);
        } else {
            alert(data.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Confirm Payment';
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An error occurred while processing the payment.");
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Confirm Payment';
    });
}


    </script>
</body>
</html>