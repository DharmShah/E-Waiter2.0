<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Chef Dashboard</title>

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

  <!-- Navbar -->
  <nav class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
    <!-- Logo -->
    <div class="text-xl font-bold text-gray-800">
      CompanyLogo
    </div>
    
    <!-- Logout Button -->
    <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
      Logout
    </button>
  </nav>

  <!-- Content Section Centered -->
  <div class="max-w-4xl w-full mx-auto p-6">
    <h2 class="text-2xl font-semibold text-gray-700 mb-4 text-center">Order List</h2>

    <!-- Grid Table Header -->
    <div class="grid grid-cols-5 bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-t-md">
      <div>ID</div>
      <div>Item Name</div>
      <div>Note</div>
      <div>Quantity</div>
      <div>Action</div>
    </div>

    <!-- Grid Table Rows -->
    <div class="divide-y divide-gray-300 bg-white shadow-sm rounded-b-md">
      
      <!-- Row 1 -->
      <div class="grid grid-cols-5 items-center py-3 px-4">
        <div>1</div>
        <div>Grilled Chicken</div>
        <div>No spicy</div>
        <div>2</div>
        <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">Prepared</button>
      </div>

      <!-- Row 2 -->
      <div class="grid grid-cols-5 items-center py-3 px-4">
        <div>2</div>
        <div>Veggie Pizza</div>
        <div>Extra cheese</div>
        <div>1</div>
        <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">Prepared</button>
      </div>

      <!-- Add more rows here as needed -->
    </div>
  </div>

</body>
</html>
