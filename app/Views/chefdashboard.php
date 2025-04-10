<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Chef Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

  <!-- Navbar -->
  <nav class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
    <div class="text-xl font-bold text-gray-800">CompanyLogo</div>
    <a href="<?= base_url('/cheflogout') ?>" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
  Logout
</a>

  </nav>

  <!-- Content -->
  <div class="max-w-6xl w-full mx-auto p-6">
    <h2 class="text-2xl font-semibold text-gray-700 mb-4 text-center">Order List</h2>

    <!-- Table Header -->
    <div class="grid grid-cols-6 bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-t-md">
      <div>ID</div>
      <div>Item Name</div>
      <div>Note</div>
      <div>Quantity</div>
      <div>Table No</div>
      <div>Action</div>
    </div>

    <!-- Table Rows -->
    <div class="divide-y divide-gray-300 bg-white shadow-sm rounded-b-md">
      <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
          <div class="grid grid-cols-6 items-center py-3 px-4 <?= $order['served'] ? 'bg-green-100' : '' ?>">
            <div><?= esc($order['id']) ?></div>
            <div><?= esc($order['itemname']) ?></div>
            <div><?= esc($order['notes']) ?></div>
            <div><?= esc($order['quantity']) ?></div>
            <div><?= esc($order['tableno']) ?></div>

            <?php if ($order['served']): ?>
              <button disabled class="bg-gray-400 text-white px-3 py-1 rounded cursor-not-allowed">
                Prepared
              </button>
            <?php else: ?>
              <form method="post" action="<?= base_url('/mark-prepared/' . $order['id']) ?>">
                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">
                  Prepared
                </button>
              </form>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="text-center py-4 text-gray-500 col-span-6">No orders found.</div>
      <?php endif; ?>
    </div>
  </div>
  <script>
  // Reload the full page every 10 seconds
  setInterval(() => {
    location.reload();
  }, 10000); // 10000 milliseconds = 10 seconds

</script>

</body>
</html>
