<?php include 'adminheader.php'; ?>

<div class="p-6 bg-gray-100 dark:bg-gray-900 min-h-screen">
    <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">📊 Admin Dashboard</h1>

    <!-- 🔹 KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow text-center">
            <div class="text-sm text-gray-500 dark:text-gray-300">🤑 Total Revenue</div>
            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">₹<?= $totalRevenue ?? 0 ?></div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow text-center">
            <div class="text-sm text-gray-500 dark:text-gray-300">📦 Orders Till Now !!</div>
            <div class="text-2xl font-bold text-green-600 dark:text-green-400"><?= $totalOrders ?? 0 ?></div>
        </div>
        <!-- 🗓️ Today's Sales
        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow text-center">
            <div class="text-sm text-gray-500 dark:text-gray-300">🗓️ Today’s Sales</div>
            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">₹<?= $todaysSales ?? 0 ?></div>
        </div> -->
    </div>

    <!-- 🔹 Charts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Chart 1 -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">📅 Total Sales by Date</h2>
            <canvas class="w-full h-[300px] md:h-[400px]" id="salesChart"></canvas>
        </div>

        <!-- Chart 2 -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">🍔 Item Quantities</h2>
            <canvas class="w-full h-[300px] md:h-[400px]" id="itemChart"></canvas>
        </div>

        <!-- Chart 3 -->
        <div class="bg-white h-[400px] dark:bg-gray-800 p-6 rounded-2xl shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">
            💳 Sales by Payment Mode
        </h2>
        <div class="relative left-[50px] w-[400px] h-[300px] mx-auto">
            <canvas id="paymentChart" width="120" height="120"></canvas>
        </div>
        </div>
      
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('salesChart'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($dates) ?>,
            datasets: [{
                label: 'Total Sales (₹)',
                data: <?= json_encode($totals) ?>,
                backgroundColor: 'rgba(59,130,246,0.6)',
                borderColor: 'rgba(59,130,246,1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        }
    });

    new Chart(document.getElementById('itemChart'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($items) ?>,
            datasets: [{
                label: 'Quantity Sold',
                data: <?= json_encode($quantities) ?>,
                backgroundColor: 'rgba(34,197,94,0.6)',
                borderColor: 'rgba(34,197,94,1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        }
    });

    new Chart(document.getElementById('paymentChart'), {
        type: 'pie',
        data: {
            labels: <?= json_encode($paymentModes) ?>,
            datasets: [{
                data: <?= json_encode($paymentTotals) ?>,
                backgroundColor: [
                    'rgba(251,191,36,0.7)',
                    'rgba(239,68,68,0.7)',
                    'rgba(34,211,238,0.7)'
                ]
            }]
        }
    });

   
    
</script>