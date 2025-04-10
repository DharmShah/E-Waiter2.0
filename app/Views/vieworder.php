<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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

<div class="max-w-6xl mx-auto">
  <!-- Header -->
  <div class="flex flex-col sm:flex-row items-center justify-between mb-6 bg-light-card dark:bg-dark-card p-4 rounded-2xl shadow-lg gap-4">
    <span id="selectedTable" class="text-light-text dark:text-dark-text text-xl font-bold"></span>
    <div class="flex gap-2">
      <!-- Dark Mode Toggle -->
      <button id="themeToggle" class="w-10 h-10 flex items-center justify-center rounded-full bg-light-accent dark:bg-dark-accent shadow-md transition relative">
        <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" class="absolute w-5 h-5 text-white opacity-100 dark:opacity-0 transition-opacity" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 18a6 6 0 100-12 6 6 0 000 12zm0-16a1 1 0 011 1v2a1 1 0 11-2 0V3a1 1 0 011-1zm0 18a1 1 0 011 1v2a1 1 0 11-2 0v-2a1 1 0 011-1zm10-8a1 1 0 01-1 1h-2a1 1 0 110-2h2a1 1 0 011 1zM5 12a1 1 0 01-1 1H2a1 1 0 110-2h2a1 1 0 011 1zm14.07-7.07a1 1 0 00-1.41 0l-1.42 1.42a1 1 0 001.41 1.41l1.42-1.42a1 1 0 000-1.41zM6.34 17.66a1 1 0 00-1.41 0l-1.42 1.42a1 1 0 001.41 1.41l1.42-1.42a1 1 0 000-1.41zM17.66 17.66a1 1 0 000 1.41l1.42 1.42a1 1 0 001.41-1.41l-1.42-1.42a1 1 0 00-1.41 0zM6.34 6.34a1 1 0 000 1.41L7.76 9.17a1 1 0 001.41-1.41L7.76 6.34a1 1 0 00-1.41 0z"/>
        </svg>
        <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" class="absolute w-5 h-5 text-white opacity-0 dark:opacity-100 transition-opacity" viewBox="0 0 24 24" fill="currentColor">
          <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z"/>
        </svg>
      </button>
      <button id="viewOrderBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm shadow-md">🧾 Billing</button>
      <button id="menuBtn" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-xl text-sm shadow-md">🍽 Menu</button>
    </div>
  </div>

  <!-- Order List -->
  <div class="bg-light-card dark:bg-dark-card p-6 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-semibold text-light-text dark:text-dark-text mb-6">📋 Ordered Items</h2>

    <!-- Desktop View -->
    <div class="hidden sm:block">
      <table class="w-full text-sm text-left border-collapse">
        <thead>
          <tr class="bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
            <th class="px-4 py-3">#</th>
            <th class="px-4 py-3">Item Name</th>
            <th class="px-4 py-3">Quantity</th>
            <th class="px-4 py-3">Notes</th>
            <th class="px-4 py-3 text-center">Actions</th>
          </tr>
        </thead>
        <tbody id="orderTableBody" class="divide-y divide-gray-300 dark:divide-gray-700"></tbody>
        <tfoot>
          <tr class="bg-gray-300 dark:bg-gray-700 text-gray-900 dark:text-gray-200 font-semibold">
            <td colspan="2" class="px-4 py-3 text-right">Total Quantity:</td>
            <td class="px-4 py-3" id="totalQuantity">0</td>
            <td colspan="2"></td>
          </tr>
        </tfoot>
      </table>
    </div>

    <!-- Mobile View -->
    <div id="mobileOrderList" class="sm:hidden mt-6 space-y-4"></div>
  </div>
</div>

<script>
  const savedTheme = localStorage.getItem("theme");
  if (savedTheme === "dark") document.documentElement.classList.add("dark");

  function updateThemeIcons() {
    const isDark = document.documentElement.classList.contains("dark");
    document.getElementById("sunIcon").style.opacity = isDark ? "0" : "1";
    document.getElementById("moonIcon").style.opacity = isDark ? "1" : "0";
  }

  updateThemeIcons();

  document.getElementById("themeToggle").addEventListener("click", () => {
    const isDark = document.documentElement.classList.toggle("dark");
    localStorage.setItem("theme", isDark ? "dark" : "light");
    updateThemeIcons();
  });

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
          <td class="px-4 py-3 text-light-text dark:text-dark-text">
            <span id="qty-display-${i}">${qty}</span>
            <div id="qty-edit-${i}" class="hidden">
              <input type="number" value="${qty}" min="1" 
                     id="qty-input-${i}"
                     class="w-20 bg-transparent border-b border-gray-400 dark:border-gray-500 focus:outline-none focus:border-blue-500">
              <div class="flex gap-2 mt-2">
                <button onclick="saveQty(${i})" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">Save</button>
                <button onclick="cancelEditQty(${i})" class="bg-gray-500 hover:bg-gray-600 text-white px-2 py-1 rounded text-xs">Cancel</button>
              </div>
            </div>
          </td>
          <td class="px-4 py-3 text-light-text dark:text-dark-text">
            <span id="notes-display-${i}">${item.notes || '-'}</span>
            <div id="notes-edit-${i}" class="hidden">
              <input type="text" value="${item.notes || ''}" 
                     id="notes-input-${i}"
                     class="w-full bg-transparent border-b border-gray-400 dark:border-gray-500 focus:outline-none focus:border-blue-500">
              <div class="flex gap-2 mt-2">
                <button onclick="saveNotes(${i})" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">Save</button>
                <button onclick="cancelEditNotes(${i})" class="bg-gray-500 hover:bg-gray-600 text-white px-2 py-1 rounded text-xs">Cancel</button>
              </div>
            </div>
          </td>
          <td class="px-4 py-3 flex justify-center gap-2">
            <button onclick="editRow(${i})" class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-lg shadow"><i data-feather="edit"></i></button>
            <button onclick="deleteRow(${i})" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg shadow"><i data-feather="trash-2"></i></button>
            <button onclick="highlightRow(${i})" class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-lg shadow"><i data-feather="check-circle"></i></button>
          </td>
        </tr>`;

      mobileHTML += `
        <div class="p-4 rounded-xl shadow-md ${item.served ? 'bg-green-100 dark:bg-green-700' : 'bg-gray-100 dark:bg-gray-800'}">
          <div class="flex justify-between items-center mb-2">
            <div class="font-semibold text-gray-800 dark:text-gray-200">${item.itemname}</div>
            <div class="text-sm text-gray-600 dark:text-gray-300">Qty: ${qty}</div>
          </div>
          ${item.notes ? `<div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Notes: ${item.notes}</div>` : ''}
          <div class="flex justify-end gap-2">
            <button onclick="editRow(${i})" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-xs shadow">Edit</button>
            <button onclick="deleteRow(${i})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs shadow">Delete</button>
            <button onclick="highlightRow(${i})" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-xs shadow">Served</button>
          </div>
        </div>`;
    });

    tableBody.innerHTML = tableHTML;
    mobileOrderList.innerHTML = mobileHTML;
    totalQuantityElement.textContent = total;
    feather.replace();
  }

  function editRow(index) {
    // Show both quantity and notes edit fields
    document.getElementById(`qty-display-${index}`).classList.add('hidden');
    document.getElementById(`qty-edit-${index}`).classList.remove('hidden');
    document.getElementById(`notes-display-${index}`).classList.add('hidden');
    document.getElementById(`notes-edit-${index}`).classList.remove('hidden');
    document.getElementById(`qty-input-${index}`).focus();
  }

  function saveQty(index) {
    const newQty = parseInt(document.getElementById(`qty-input-${index}`).value) || 1;
    
    fetch('/order/update', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        id: orders[index].id,
        field: 'quantity',
        value: newQty
      })
    }).then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          orders[index].quantity = newQty;
          document.getElementById(`qty-display-${index}`).textContent = newQty;
          document.getElementById(`qty-display-${index}`).classList.remove('hidden');
          document.getElementById(`qty-edit-${index}`).classList.add('hidden');
          updateTotalQuantity();
        }
      }).catch(console.error);
  }

  function cancelEditQty(index) {
    document.getElementById(`qty-display-${index}`).classList.remove('hidden');
    document.getElementById(`qty-edit-${index}`).classList.add('hidden');
    document.getElementById(`qty-input-${index}`).value = orders[index].quantity;
  }

  function saveNotes(index) {
    const newNotes = document.getElementById(`notes-input-${index}`).value.trim();
    
    fetch('/order/update', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        id: orders[index].id,
        field: 'notes',
        value: newNotes === '' ? null : newNotes
      })
    }).then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          orders[index].notes = newNotes === '' ? null : newNotes;
          document.getElementById(`notes-display-${index}`).textContent = orders[index].notes || '-';
          document.getElementById(`notes-display-${index}`).classList.remove('hidden');
          document.getElementById(`notes-edit-${index}`).classList.add('hidden');
        }
      }).catch(console.error);
  }

  function cancelEditNotes(index) {
    document.getElementById(`notes-display-${index}`).classList.remove('hidden');
    document.getElementById(`notes-edit-${index}`).classList.add('hidden');
    document.getElementById(`notes-input-${index}`).value = orders[index].notes || '';
  }

  function updateTotalQuantity() {
    const total = orders.reduce((sum, item) => sum + (parseInt(item.quantity) || 0), 0);
    document.getElementById("totalQuantity").textContent = total;
  }

  function highlightRow(index) {
    const row = document.getElementById(`row-${index}`);
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

  function deleteRow(index) {
    if (confirm("Are you sure you want to delete this item?")) {
      fetch(`/order/delete/${orders[index].id}`, { method: 'DELETE' })
        .then(res => res.json()).then(data => {
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