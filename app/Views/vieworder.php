<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gray-100 p-4 sm:p-6">

<div class="flex items-center justify-between mb-4">
    <div class="flex-1 flex justify-center">
        <span id="selectedTable" class="text-black text-base sm:text-lg font-semibold"></span>
    </div>
    <button id="viewOrderBtn" class="bg-blue-500 hover:bg-blue-600 text-white px-2 sm:px-5 py-1 sm:py-2 rounded-lg text-[15px] w-[70px] sm:w-auto ml-2">🧾 Billing</button>
    <button id="menuBtn" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 sm:px-5 py-1 sm:py-2 rounded-lg text-[15px] w-[70px] sm:w-auto ml-2">Menu</button>
</div>

<div class="bg-white p-4 rounded-lg shadow-lg">
    <h2 class="text-lg sm:text-xl font-semibold text-gray-700 mb-3">Ordered Items</h2>

    <!-- Desktop Table -->
    <div class="hidden sm:block">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200 text-gray-700 text-sm sm:text-base">
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Item Name</th>
                    <th class="px-4 py-2 text-left">Quantity</th>
                    <th class="px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="orderTableBody" class="divide-y divide-gray-300"></tbody>
            <tfoot>
                <tr class="bg-gray-300 text-gray-900 font-semibold">
                    <td colspan="2" class="px-4 py-3 text-right">Total Quantity:</td>
                    <td class="px-4 py-3" id="totalQuantity">0</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Mobile View (Cards) -->
    <div id="mobileOrderList" class="sm:hidden space-y-3"></div>
</div>

<script>
    let orders = [];

    function fetchOrders() {
        const selectedTable = sessionStorage.getItem("selectedTable");

        if (!selectedTable) {
            console.error("No table selected");
            return;
        }

        fetch(`/getOrders?tableno=${selectedTable}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    orders = data.orders;
                    populateTable();
                } else {
                    console.error("Failed to fetch orders for table " + selectedTable);
                }
            })
            .catch(error => console.error("Error fetching orders:", error));
    }

    function populateTable() {
        const tableBody = document.getElementById("orderTableBody");
        const mobileOrderList = document.getElementById("mobileOrderList");
        const totalQuantityElement = document.getElementById("totalQuantity");

        let totalQuantity = 0;
        let tableRows = "";
        let mobileCards = "";

        orders.forEach((item, index) => {
            const itemQuantity = parseInt(item.quantity) || 0; // Ensure it's a number
            totalQuantity += itemQuantity;

            tableRows += `
            <tr id="row-${index}" class="${item.served ? 'bg-white-200' : ''} hover:bg-gray-100 transition">
                <td class="px-4 py-3">${index + 1}</td>
                <td class="px-4 py-3">${item.itemname}</td>
                <td class="px-4 py-3">${itemQuantity}</td>
                <td class="px-4 py-3 flex justify-center gap-2">
                    <button onclick="editRow(${index})" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg">
                        <i data-feather="edit"></i>
                    </button>
                    <button onclick="deleteRow(${index})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg">
                        <i data-feather="trash-2"></i>
                    </button>
                    <button onclick="highlightRow(${index})" class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg">
                        <i data-feather="check-circle"></i>
                    </button>
                </td>
            </tr>
            `;


            mobileCards += `
                <div class="p-3 bg-gray-100 rounded-lg shadow-md">
                    <div class="flex justify-between">
                        <h3 class="font-semibold text-gray-700">${item.itemname}</h3>
                        <span class="text-gray-600">Qty: <strong>${itemQuantity}</strong></span>
                    </div>
                </div>
            `;
        });

        tableBody.innerHTML = tableRows;
        mobileOrderList.innerHTML = mobileCards;
        totalQuantityElement.textContent = totalQuantity; // Display correct total quantity

        feather.replace();
    }

    function highlightRow(index) {
    const row = document.getElementById(`row-${index}`);
    if (!row) return;

    // Toggle served status based on current state
    const newServedStatus = orders[index].served ? 0 : 1;
    orders[index].served = newServedStatus;

    // Update row color based on served status
    if (newServedStatus === 1) {
        row.classList.add("bg-green-200"); // Highlight row when served
    } else {
        row.classList.remove("bg-green-200"); // Remove highlight if unserved
    }

    // Send update request to the backend
    fetch(`/order/served/${orders[index].id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ served: newServedStatus })
    }).then(response => response.json())
      .then(data => {
          if (data.status !== 'success') {
              alert("Failed to update served status.");
          }
      }).catch(error => console.error("Error updating served status:", error));
}


    document.getElementById("selectedTable").textContent = `Table ${sessionStorage.getItem("selectedTable") || "Not Selected"}`;
    document.getElementById("viewOrderBtn").addEventListener("click", () => window.location.href = "/billing");
    document.getElementById("menuBtn").addEventListener("click", () => window.location.href = "/menu");

    fetchOrders();

    function editRow(index) {
    const newQuantity = prompt("Enter new quantity:", orders[index].quantity);
    if (newQuantity !== null) {
        const orderId = orders[index].id; // Get order ID
        fetch('/order/update', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: orderId, quantity: parseInt(newQuantity) || orders[index].quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                orders[index].quantity = parseInt(newQuantity);
                populateTable(); // Refresh table
                alert("Order updated successfully!");
            } else {
                alert("Failed to update order.");
            }
        })
        .catch(error => console.error("Error updating order:", error));
    }
}

function deleteRow(index) {
    if (confirm("Are you sure you want to delete this item?")) {
        const orderId = orders[index].id; // Get order ID
        fetch(`/order/delete/${orderId}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                orders.splice(index, 1);
                populateTable(); // Refresh table
                alert("Order deleted successfully!");
            } else {
                alert("Failed to delete order.");
            }
        })
        .catch(error => console.error("Error deleting order:", error));
    }
}
</script>
</body>
</html>