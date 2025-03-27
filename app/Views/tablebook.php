<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Table Grid</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-blue-500 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-white text-xl font-bold">Table Page</h1>
            
            <div class="flex items-center space-x-3">
                
                <!-- Waiter Name -->
                <span class="text-white font-semibold">
                    <?= esc($waiter_name) ?>
                </span>

                <!-- Profile Image -->
                <div class="w-10 h-10 overflow-hidden border-2 border-gray-400 rounded-full">
                    <img src="/images/bg.jpg" class="object-cover w-full h-full" alt="avatar">                    
                </div>
                <div class="flex items-center">
                    <a href="/" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Table Grid -->
    <div class="container mx-auto p-4">
        <div id="tableGrid" class="grid gap-4 grid-cols-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
            <?php for ($i = 1; $i <= $tableCount; $i++): ?>
                <?php $isOccupied = in_array($i, $occupiedTables); ?>

                <div class="relative border border-gray-300 p-2 bg-white rounded-lg shadow-lg flex items-center justify-center cursor-pointer 
                            <?= $isOccupied ? 'bg-yellow-300 border-yellow-500' : '' ?>" 
                     data-table-number="<?= $i ?>" 
                     onclick="selectTable(<?= $i ?>)">
                    
                    <img src="/images/tableimg.png" class="w-full h-auto rounded-md" alt="Table <?= $i ?>">
                    
                    <span class="absolute inset-0 flex items-center justify-center text-2xl font-bold text-black bg-opacity-50">
                        <?= $i ?>
                    </span>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <script>
        function selectTable(tableNumber) {
            fetch(`/home/selectTable/${tableNumber}`)
                .then(response => {
                    if (response.ok) {
                        window.location.href = "/menu"; // Redirect to menu page
                    }
                })
                .catch(error => console.error("Error:", error));
        }
    </script>

</body>
</html>
