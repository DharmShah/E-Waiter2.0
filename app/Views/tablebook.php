<!DOCTYPE html>
<html lang="en" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Table Grid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Tailwind config to enable dark mode with class strategy
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<body class="bg-[#FDFEFE] text-gray-800 dark:bg-[#1A1A2E] dark:text-gray-100 transition-colors duration-500" id="theme">
    
    <!-- Navbar -->
    <nav class="bg-[#FDEBD0] dark:bg-[#0F3460] p-4 shadow-lg flex items-center justify-between rounded-b-lg transition-colors duration-500">
        <h1 class="text-gray-800 dark:text-gray-100 text-xl font-bold tracking-wide uppercase">🍽️ Table Dashboard</h1>
        
        <div class="flex items-center space-x-4">
            <!-- Waiter Name -->
            <span class="text-gray-700 dark:text-gray-200 font-semibold text-lg">
                <?= esc($waiter_name) ?>
            </span>

            <!-- Toggle Theme -->
            <button id="themeToggle" class="bg-[#E59866] dark:bg-[#F1C40F] hover:bg-[#D35400] dark:hover:bg-yellow-400 text-white font-bold py-2 px-4 rounded-lg shadow-md transition">
                🌞 / 🌙
            </button>

            <!-- Logout -->
            <a href="/logout" class="bg-red-400 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg shadow-md">
                Logout
            </a>

        </div>
    </nav>

    <!-- Table Grid -->
    <div class="container mx-auto px-4 py-6">
        <div id="tableGrid" class="grid gap-6 grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
            <?php for ($i = 1; $i <= $tableCount; $i++): ?>
                <?php $isOccupied = in_array($i, $occupiedTables); ?>

                <div class="relative p-4 rounded-xl shadow-lg cursor-pointer transform hover:scale-105 transition duration-300 
                            <?= $isOccupied 
                                ? 'bg-yellow-300 shadow-yellow-400 dark:bg-yellow-500' 
                                : 'bg-[#FCF3CF] dark:bg-[#16213E]' ?>" 
                     data-table-number="<?= $i ?>" 
                     onclick="selectTable(<?= $i ?>)">
                    
                    <img src="/images/tableimg.png" class="w-full h-auto rounded-lg opacity-90 hover:opacity-100 transition duration-300" alt="Table <?= $i ?>">
                    
                    <span class="absolute inset-0 flex items-center justify-center text-3xl font-extrabold text-gray-700 dark:text-white bg-white dark:bg-black bg-opacity-40 rounded-lg">
                        <?= $i ?>
                    </span>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Theme Toggle Script -->
    <script>
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;

        // Load theme from localStorage
        if (localStorage.getItem('theme') === 'dark') {
            html.classList.add('dark');
        }

        themeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            if (html.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
        });

        function selectTable(tableNumber) {
            fetch(`/home/selectTable/${tableNumber}`)
                .then(response => {
                    if (response.ok) {
                        window.location.href = "/menu";
                    }
                })
                .catch(error => console.error("Error:", error));
        }
    </script>

</body>
</html>
