<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-[#FDEBD0] p-4 shadow-lg flex items-center justify-between rounded-b-lg">
        <p class="text-gray-800 text-lg font-bold">🍽️ Menu Page</p>
        
        <div class="flex-1 flex justify-center">
            <span id="selectedTable" class="text-gray-800 text-lg font-semibold">
                <?php echo isset($tableno) ? "Table $tableno" : "No table selected"; ?>
            </span>
        </div>
        
        <div class="flex items-center space-x-3">
            <button onclick="redirectTotable()" class="bg-[#F5CBA7] hover:bg-[#E59866] text-gray-800 px-4 py-2 rounded-lg text-sm font-semibold shadow-md">
                📜 Table
            </button>
            <button id="addOrderBtn" class="bg-[#A9DFBF] hover:bg-[#73C6B6] text-gray-800 px-5 py-2 rounded-lg text-sm">
                ➕ Add Order
            </button>
            <button id="viewOrderBtn" class="bg-[#F9E79F] hover:bg-[#F4D03F] text-gray-800 px-5 py-2 rounded-lg text-sm">
                👀 View Order 
            </button>
        </div>
    </nav>

    <!-- Category Section -->
    <div class="container mx-auto p-4">
        <div class="overflow-x-auto hide-scrollbar p-2 md:flex md:justify-center w-full">
            <div id="categoryContainer" class="flex space-x-4 md:space-x-6 gap-4 w-max">
                <?php 
                $uniqueCategories = [];
                foreach ($categories as $category): 
                    if (!in_array($category['itemcategory'], $uniqueCategories)): 
                        $uniqueCategories[] = $category['itemcategory'];
                ?>
                    <div class="flex flex-col items-center cursor-pointer category-item" data-category="<?= $category['itemcategory'] ?>">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 md:w-14 md:h-14 lg:w-12 lg:h-12 rounded-full border-2 border-gray-300 shadow-lg overflow-hidden">
                            <img src="<?= base_url('images/' . $category['imgurl']) ?>" alt="<?= $category['itemcategory'] ?>" class="w-full h-full object-cover">
                        </div>
                        <span class="mt-2 text-xs sm:text-sm font-medium text-gray-700"><?= $category['itemcategory'] ?></span>
                    </div>
                <?php 
                    endif;
                endforeach; 
                ?>
            </div>
        </div>
    </div>

    <!-- Item Cards Section -->
    <div class="bg-[#FDEBD0] container mx-auto p-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6" id="itemsContainer">
        <?php foreach ($dishes as $index => $dish): ?>
            <div class="relative bg-[#F3F4F6] p-4 rounded-lg shadow-md flex flex-col items-center item-card" data-category="<?= $dish['itemcategory'] ?>">
                
                <?php if ($dish['trending']): ?>
                    <div class="absolute top-2 right-2 text-[20px] animate-pulse">🔥</div>
                <?php endif; ?>

                <div class="w-24 h-24 rounded-full border-2 border-gray-300 shadow-lg overflow-hidden">
                    <img src="<?= base_url('images/' . $dish['imgurl']) ?>" alt="<?= $dish['itemname'] ?>" class="w-full h-full object-cover">
                </div>
                <span class="mt-2 text-sm font-semibold text-gray-800 text-center"><?= $dish['itemname'] ?></span>
                <span class="text-gray-600 text-sm">₹<?= $dish['itemprice'] ?></span>
                <div class="flex items-center mt-2 space-x-4">
                    <button class="bg-red-500 text-white px-3 py-1 rounded-full text-lg font-bold" onclick="changeQuantity(<?= $index ?>, -1)">−</button>
                    <span id="quantity-<?= $index ?>" class="text-lg font-semibold">0</span>
                    <button class="bg-green-500 text-white px-3 py-1 rounded-full text-lg font-bold" onclick="changeQuantity(<?= $index ?>, 1)">+</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        function changeQuantity(index, change) {
            let quantityElement = document.getElementById(`quantity-${index}`);
            let currentQuantity = parseInt(quantityElement.textContent);
            let newQuantity = Math.max(0, currentQuantity + change);
            quantityElement.textContent = newQuantity;
        }

        const selectedTable = "<?= $tableno ?>";
        if (selectedTable) {
            sessionStorage.setItem("selectedTable", selectedTable);
        }
        document.getElementById("selectedTable").textContent = selectedTable ? `Table ${selectedTable}` : "No table selected";

        document.querySelectorAll(".category-item").forEach(category => {
            category.addEventListener("click", function () {
                const selectedCategory = this.getAttribute("data-category");
                document.querySelectorAll(".item-card").forEach(item => {
                    if (item.getAttribute("data-category") === selectedCategory || selectedCategory === "All") {
                        item.style.display = "flex";
                    } else {
                        item.style.display = "none";
                    }
                });
            });
        });

        document.getElementById("addOrderBtn").addEventListener("click", function () {
            let selectedTable = sessionStorage.getItem("selectedTable") || "Unknown";
            let orders = [];

            document.querySelectorAll(".item-card").forEach((item, index) => {
                let quantity = parseInt(document.getElementById(`quantity-${index}`).textContent);
                if (quantity > 0) {
                    orders.push({
                        tableno: selectedTable,
                        itemname: item.querySelector("span").textContent,
                        quantity: quantity
                    });
                }
            });

            if (orders.length > 0) {
                fetch("/order/add", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ orders: orders })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.status === "success") {
                        document.querySelectorAll(".item-card span[id^='quantity-']").forEach(q => q.textContent = "0");
                    }
                })
                .catch(error => console.error("Error:", error));
            } else {
                alert("Please select at least one item before adding an order.");
            }
        });

        function redirectToViewOrder() {
            window.location.href = "/vieworder";
        }

        document.getElementById("viewOrderBtn").addEventListener("click", redirectToViewOrder);

        function redirectTotable() {
            window.location.href = "/tablebook";
        }
    </script>

    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

</body>
</html>