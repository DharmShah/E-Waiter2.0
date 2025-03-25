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
                    <?= session()->get('waiter_name') ?>
                </span>

                <!-- Profile Image -->
                <div class="w-10 h-10 overflow-hidden border-2 border-gray-400 rounded-full">
                    <img src="/images/bg.jpg" class="object-cover w-full h-full" alt="avatar">                    
                </div>
            </div>
        </div>
    </nav>

    <!-- Table Grid -->
    <div class="container mx-auto p-4">
        <div id="tableGrid" class="grid gap-4 grid-cols-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
            <!-- Tables will be inserted here by JavaScript -->
        </div>
    </div>

    <script>
        const numImages = 10; 
        const grid = document.getElementById('tableGrid');

        for (let i = 1; i <= numImages; i++) {
            // Create wrapper div (Clickable)
            const div = document.createElement("div");
            div.className = "relative border border-gray-300 p-2 bg-white rounded-lg shadow-lg flex items-center justify-center cursor-pointer";
            div.dataset.tableNumber = i; // Store table number in dataset
            
            // Create image element
            const img = document.createElement("img");
            img.src = "/images/tableimg.png"; // Corrected path
            img.alt = `Table ${i}`;
            img.className = "w-full h-auto rounded-md";

            // Create number overlay
            const numOverlay = document.createElement("span");
            numOverlay.className = "absolute inset-0 flex items-center justify-center text-2xl font-bold text-black bg-opacity-50";
            numOverlay.textContent = i;

            // Add click event to store table number in session and redirect
            div.addEventListener("click", function() {
                const tableNumber = this.dataset.tableNumber;

                fetch(`/home/selectTable/${tableNumber}`)
                    .then(response => {
                        if (response.ok) {
                            window.location.href = "/menu"; // Redirect to menu page
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });

            // Append elements
            div.appendChild(img);
            div.appendChild(numOverlay);
            grid.appendChild(div);
        }
    </script>

</body>
</html>
