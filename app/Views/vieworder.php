<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        light: {
                            bg: "#f9f9f9",
                            card: "#ffffff",
                            accent: "#2563eb",
                            border: "#e5e7eb",
                            text: "#1f2937"
                        },
                        dark: {
                            bg: "#121212",
                            card: "#1e1e1e",
                            accent: "#38bdf8",
                            border: "#2a2a2a",
                            text: "#e5e5e5"
                        }
                    }
                }
            }
        };
    </script>
</head>
<body class="bg-light-bg dark:bg-dark-bg min-h-screen p-6 transition-colors duration-300">

<div class="max-w-4xl mx-auto">
    <!-- Top Navigation -->
    <div class="flex items-center justify-between mb-6 bg-light-card dark:bg-dark-card p-3 rounded-lg shadow-md transition">
        <span id="selectedTable" class="text-light-text dark:text-dark-text text-lg font-semibold"></span>
        <div class="flex gap-2 items-center">
            <!-- Theme Toggle Button -->
            <button id="themeToggle"
                class="w-10 h-10 flex items-center justify-center rounded-full bg-light-accent dark:bg-dark-accent shadow transition duration-300 relative">
                <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" class="absolute w-5 h-5 text-white transition-opacity duration-300 opacity-100 dark:opacity-0" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 18a6 6 0 100-12 6 6 0 000 12zm0-16a1 1 0 011 1v2a1 1 0 11-2 0V3a1 1 0 011-1zm0 18a1 1 0 011 1v2a1 1 0 11-2 0v-2a1 1 0 011-1zm10-8a1 1 0 01-1 1h-2a1 1 0 110-2h2a1 1 0 011 1zM5 12a1 1 0 01-1 1H2a1 1 0 110-2h2a1 1 0 011 1zm14.07-7.07a1 1 0 00-1.41 0l-1.42 1.42a1 1 0 001.41 1.41l1.42-1.42a1 1 0 000-1.41zM6.34 17.66a1 1 0 00-1.41 0l-1.42 1.42a1 1 0 001.41 1.41l1.42-1.42a1 1 0 000-1.41zM17.66 17.66a1 1 0 000 1.41l1.42 1.42a1 1 0 001.41-1.41l-1.42-1.42a1 1 0 00-1.41 0zM6.34 6.34a1 1 0 000 1.41L7.76 9.17a1 1 0 001.41-1.41L7.76 6.34a1 1 0 00-1.41 0z"/>
                </svg>
                <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" class="absolute w-5 h-5 text-white transition-opacity duration-300 opacity-0 dark:opacity-100" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z"/>
                </svg>
            </button>

            <button id="viewOrderBtn" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm shadow-md transition">
                🧾 Billing
            </button>
            <button id="menuBtn" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm shadow-md transition">
                🍽 Menu
            </button>
        </div>
    </div>

    <!-- Order List -->
    <div class="bg-light-card dark:bg-dark-card p-5 rounded-lg shadow-lg transition">
        <h2 class="text-xl font-semibold text-light-text dark:text-dark-text mb-4">📋 Ordered Items</h2>

        <!-- Desktop Table -->
        <div class="hidden sm:block">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-200 text-sm sm:text-base">
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">Item Name</th>
                        <th class="px-4 py-2 text-left">Quantity</th>
                        <th class="px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody" class="divide-y divide-gray-300 dark:divide-gray-700"></tbody>
                <tfoot>
                    <tr class="bg-gray-300 dark:bg-gray-700 text-gray-900 dark:text-gray-200 font-semibold">
                        <td colspan="2" class="px-4 py-3 text-right">Total Quantity:</td>
                        <td class="px-4 py-3" id="totalQuantity">0</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Mobile View (Cards) -->
        <div id="mobileOrderList" class="sm:hidden space-y-3 mt-3"></div>
    </div>
</div>

<script>
    // Setup theme on page load
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme === "dark") {
        document.documentElement.classList.add("dark");
    }

    // Update icon based on theme
    function updateThemeIcons() {
        const isDark = document.documentElement.classList.contains("dark");
        document.getElementById("sunIcon").style.opacity = isDark ? "0" : "1";
        document.getElementById("moonIcon").style.opacity = isDark ? "1" : "0";
    }

    updateThemeIcons();

    // Theme toggle handler
    document.getElementById("themeToggle").addEventListener("click", () => {
        const isDark = document.documentElement.classList.toggle("dark");
        localStorage.setItem("theme", isDark ? "dark" : "light");
        updateThemeIcons();
    });

    // Orders logic
    let orders = [];

    function fetchOrders() {
        const selectedTable = sessionStorage.getItem("selectedTable");
        if (!selectedTable) return;

        fetch(`/getOrders?tableno=${selectedTable}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    orders = data.orders;
                    populateTable();
                }
            }).catch(console.error);
    }

    function populateTable() {
        const tableBody = document.getElementById("orderTableBody");
        const mobileOrderList = document.getElementById("mobileOrderList");
        const totalQuantityElement = document.getElementById("totalQuantity");

        let total = 0, tableHTML = "", mobileHTML = "";

        orders.forEach((item, i) => {
            const qty = parseInt(item.quantity) || 0;
            total += qty;

            tableHTML += `
                <tr id="row-${i}" class="${item.served ? 'bg-green-200 dark:bg-green-600' : ''}">
                    <td class="px-4 py-3 text-light-text dark:text-dark-text">${i + 1}</td>
                    <td class="px-4 py-3 text-light-text dark:text-dark-text">${item.itemname}</td>
                    <td class="px-4 py-3 text-light-text dark:text-dark-text">${qty}</td>
                    <td class="px-4 py-3 flex justify-center gap-2">
                        <button onclick="editRow(${i})" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg shadow-md"><i data-feather="edit"></i></button>
                        <button onclick="deleteRow(${i})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg shadow-md"><i data-feather="trash-2"></i></button>
                        <button onclick="highlightRow(${i})" class="bg-green-500 text-white px-3 py-2 rounded-lg shadow-md"><i data-feather="check-circle"></i></button>
                    </td>
                </tr>`;

            mobileHTML += `<div class="p-3 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md flex justify-between items-center">
                <h3 class="font-semibold text-gray-700 dark:text-gray-200">${item.itemname}</h3>
                <span class="text-gray-600 dark:text-gray-300">Qty: <strong>${qty}</strong></span>
            </div>`;
        });

        tableBody.innerHTML = tableHTML;
        mobileOrderList.innerHTML = mobileHTML;
        totalQuantityElement.textContent = total;

        feather.replace();
    }

    function highlightRow(index) {
        const row = document.getElementById(`row-${index}`);
        if (!row) return;
        const served = !orders[index].served;
        orders[index].served = served;

        row.classList.toggle("bg-green-200", served);
        row.classList.toggle("dark:bg-green-600", served);

        fetch(`/order/served/${orders[index].id}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ served: served ? 1 : 0 })
        }).catch(console.error);
    }

    function editRow(index) {
        const newQty = prompt("Enter new quantity:", orders[index].quantity);
        if (newQty !== null) {
            fetch('/order/update', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: orders[index].id, quantity: parseInt(newQty) })
            }).then(res => res.json()).then(data => {
                if (data.status === 'success') {
                    orders[index].quantity = parseInt(newQty);
                    populateTable();
                }
            }).catch(console.error);
        }
    }

    function deleteRow(index) {
        if (confirm("Are you sure you want to delete this item?")) {
            fetch(`/order/delete/${orders[index].id}`, {
                method: 'DELETE'
            }).then(res => res.json()).then(data => {
                if (data.status === 'success') {
                    orders.splice(index, 1);
                    populateTable();
                }
            }).catch(console.error);
        }
    }

    document.getElementById("selectedTable").textContent = `Table ${sessionStorage.getItem("selectedTable") || "Not Selected"}`;
    document.getElementById("viewOrderBtn").addEventListener("click", () => window.location.href = "/billing");
    document.getElementById("menuBtn").addEventListener("click", () => window.location.href = "/menu");

    fetchOrders();
</script>
</body>
</html>
