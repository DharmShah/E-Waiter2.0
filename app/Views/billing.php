<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing - <?= esc($admincontrol[0]['name'] ?? 'Restaurant') ?></title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        playfair: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        primary: "#6366F1",
                        "primary-dark": "#4F46E5",
                        accent: "#10B981",
                        "accent-dark": "#059669",
                        light: {
                            bg: "#f8fafc",
                            text: "#1f2937",
                            card: "#ffffff"
                        },
                        dark: {
                            bg: "#1f1f2e",
                            text: "#f1f5f9",
                            card: "#2e2e40"
                        }
                    }
                }
            }
        };
    </script>
</head>
<body class="bg-light-bg dark:bg-dark-bg text-light-text dark:text-dark-text transition-all duration-300">

    <div class="max-w-3xl mx-auto my-10 p-6 md:p-8 bg-white dark:bg-dark-card rounded-2xl shadow-2xl relative">

        <!-- Theme toggle -->
        <div class="absolute top-4 right-4">
            <button id="themeToggle"
                class="w-10 h-10 flex items-center justify-center rounded-full bg-light-accent dark:bg-dark-accent shadow transition duration-300 relative">
                <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg"
                    class="absolute w-5 h-5 text-gray-800 dark:text-white"
                    viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 18a6 6 0 100-12 6 6 0 000 12zm0-16a1 1 0 011 1v2a1 1 0 11-2 0V3a1 1 0 011-1zm0 18a1 1 0 011 1v2a1 1 0 11-2 0v-2a1 1 0 011-1zm10-8a1 1 0 01-1 1h-2a1 1 0 110-2h2a1 1 0 011 1zM5 12a1 1 0 01-1 1H2a1 1 0 110-2h2a1 1 0 011 1zm14.07-7.07a1 1 0 00-1.41 0l-1.42 1.42a1 1 0 001.41 1.41l1.42-1.42a1 1 0 000-1.41zM6.34 17.66a1 1 0 00-1.41 0l-1.42 1.42a1 1 0 001.41 1.41l1.42-1.42a1 1 0 000-1.41zM17.66 17.66a1 1 0 000 1.41l1.42 1.42a1 1 0 001.41-1.41l-1.42-1.42a1 1 0 00-1.41 0zM6.34 6.34a1 1 0 000 1.41L7.76 9.17a1 1 0 001.41-1.41L7.76 6.34a1 1 0 00-1.41 0z" />
                </svg>
                <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg"
                    class="absolute w-5 h-5 text-gray-800 dark:text-white hidden"
                    viewBox="0 0 24 24" fill="currentColor">
                    <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" />
                </svg>
            </button>
        </div>

        <!-- Company Info -->
        <div class="mb-6 text-center">
            <img src="<?= esc($admincontrol[0]['logo_url']) ?>" alt="Company Logo" class="h-20 mx-auto mb-2">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 bg-clip-text text-transparent font-playfair">
                <?= esc($admincontrol[0]['name'] ?? 'Restaurant') ?>
            </h1>
            <p><?= esc($admincontrol[0]['address'] ?? '123 Main Street, City') ?></p>
            <p>Phone: <?= esc($admincontrol[0]['phone'] ?? '+91 XXXXX XXXXX') ?></p>
        </div>

        <!-- Billing Info -->
        <div class="mb-4">
            <p class="text-lg font-semibold">Table No: <?= esc($tableno ?? '01') ?> | Bill No: 0000001</p>
            <p class="text-sm text-gray-600 dark:text-gray-400"><?= date('d M Y, h:i A') ?></p>
        </div>

        <!-- Order Table -->
        <div class="overflow-x-auto mt-4">
            <table class="w-full text-sm">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-left px-4 py-2">#</th>
                        <th class="text-left px-4 py-2">Item</th>
                        <th class="text-center px-4 py-2">Qty</th>
                        <th class="text-right px-4 py-2">Price</th>
                        <th class="text-right px-4 py-2">Total</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 dark:text-gray-200">
                    <?php $subtotal = 0; ?>
                    <?php foreach ($orders as $index => $order): ?>
                        <?php $item_total = $order['quantity'] * $order['itemprice']; ?>
                        <?php $subtotal += $item_total; ?>
                        <tr class="border-b border-gray-300 dark:border-gray-600">
                            <td class="px-4 py-2"><?= $index + 1 ?></td>
                            <td class="px-4 py-2"><?= esc($order['itemname']) ?></td>
                            <td class="px-4 py-2 text-center"><?= esc($order['quantity']) ?></td>
                            <td class="px-4 py-2 text-right">₹<?= number_format($order['itemprice'], 2) ?></td>
                            <td class="px-4 py-2 text-right">₹<?= number_format($item_total, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="font-semibold text-gray-900 dark:text-gray-100">
                    <tr class="bg-gray-200 dark:bg-gray-800">
                        <td colspan="4" class="text-right px-4 py-2">Total:</td>
                        <td class="text-right px-4 py-2 font-bold">₹<?= number_format($subtotal, 2) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center gap-4 mt-8">
            <button onclick="goToMenu()" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-md shadow">📝 Menu</button>
            <button onclick="openPaymentModeModal()" class="bg-accent hover:bg-accent-dark text-white px-6 py-2 rounded-md shadow">💰 Confirm Payment</button>
        </div>
    </div>

    <!-- Payment Mode Modal -->
    <div id="modeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-dark-card rounded-lg p-6 w-full max-w-sm shadow-lg text-center">
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Select Payment Method</h2>
            <select id="paymentMode" class="w-full p-2 mb-4 rounded-md border dark:border-gray-600 bg-white dark:bg-dark-bg text-black dark:text-white">
                <option value="">-- Choose --</option>
                <option value="Cash">Cash</option>
                <option value="UPI">UPI</option>
                <option value="Card">Card</option>
            </select>
            <div class="flex justify-center gap-3">
                <button onclick="submitPayment()" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-md">Pay Now</button>
                <button onclick="closeModeModal()" class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-md">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Payment Success Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-dark-card rounded-lg p-6 w-full max-w-md shadow-lg text-center">
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">✅ Payment Successful</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-2" id="paymentSummary"></p>
            <button onclick="closeModal()" class="mt-4 px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-lg">Done</button>
        </div>
    </div>

    <!-- Script -->
    <script>
        function goToMenu() {
            window.location.href = "<?= base_url('menu') ?>";
        }

        function openPaymentModeModal() {
            document.getElementById("modeModal").classList.remove("hidden");
            document.getElementById("modeModal").classList.add("flex");
        }

        function closeModeModal() {
            document.getElementById("modeModal").classList.add("hidden");
        }

        function submitPayment() {
            const mode = document.getElementById("paymentMode").value;
            const total = "<?= number_format($subtotal, 2) ?>";
            const rawAmount = "<?= number_format($subtotal, 2, '.', '') ?>"; // Raw format for gateway

            if (!mode) {
                alert("Please select a payment method.");
                return;
            }

            // Redirect to Cashfree for UPI or Card
            if (mode === "UPI" || mode === "Card") {
                const phone = "9876543210";  // Replace with dynamic phone if needed
                const name = "Test User";    // Replace with actual user name if available
                const email = "test@example.com"; // Replace with user email
                const amount = rawAmount;

                const params = new URLSearchParams({
                    phone: phone,
                    name: name,
                    email: email,
                    amount: amount
                });

                window.location.href = `https://payments-test.cashfree.com/forms?code=payment_forms&${params.toString()}`;
                return;
            }

            // For Cash, do normal form post
            const formData = new FormData();
            formData.append("paymentmode", mode);

            fetch("<?= base_url('home/payNow') ?>", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    document.getElementById("paymentSummary").textContent = `You paid ${total} using ${mode}.`;
                    document.getElementById("paymentModal").classList.remove("hidden");
                    document.getElementById("paymentModal").classList.add("flex");

                    // Redirect after success
                    setTimeout(() => {
                        window.location.href = "http://localhost:8080/tablebook";
                    }, 2000); // 2-second delay before redirect
                } else {
                    alert("Payment failed: " + data.message);
                }
            });
        }

        function closeModal() {
            document.getElementById("paymentModal").classList.add("hidden");
            window.location.href = "<?= base_url('/tablebook') ?>";
        }

        // Theme toggle
        const themeToggle = document.getElementById("themeToggle");
        const sunIcon = document.getElementById("sunIcon");
        const moonIcon = document.getElementById("moonIcon");

        themeToggle.addEventListener("click", () => {
            document.body.classList.toggle("dark");
            sunIcon.classList.toggle("hidden");
            moonIcon.classList.toggle("hidden");

            // Save the theme preference
            if (document.body.classList.contains("dark")) {
                localStorage.setItem("theme", "dark");
            } else {
                localStorage.setItem("theme", "light");
            }
        });

        // Load the theme from localStorage
        window.onload = () => {
            const theme = localStorage.getItem("theme");
            if (theme === "dark") {
                document.body.classList.add("dark");
                sunIcon.classList.add("hidden");
                moonIcon.classList.remove("hidden");
            } else {
                document.body.classList.remove("dark");
                sunIcon.classList.remove("hidden");
                moonIcon.classList.add("hidden");
            }
        };
        
    </script>
</body>
</html>
