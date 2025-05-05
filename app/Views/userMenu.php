<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Delicious Bites - Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .category-btn {
            background-size: cover;
            background-position: center;
            color: white;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.8);
        }
        .category-btn.active {
            border: 3px solid #FF7F50; /* coral color for active state */
        }
        .dish-card { display: none; }
        .dish-card.active { display: block; }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-teal-600 text-white p-5 shadow-xl">
        <div class="container mx-auto flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <h1 class="text-3xl font-semibold">Delicious Bites</h1>
        </div>
    </nav>

    <!-- Categories -->
    <div class="bg-teal-50 shadow-md sticky top-0 z-10">
        <div class="container mx-auto px-4 py-3 overflow-x-auto">
            <div class="flex space-x-3" id="category-container">
                <?php foreach ($menuData as $category => $items): ?>
                    <button 
                        class="category-btn px-6 py-3 rounded-full font-semibold capitalize transition-all transform hover:scale-105 <?= ($category === array_key_first($menuData)) ? 'active' : '' ?>" 
                        data-category="<?= esc($category) ?>"
                        style="background-image: url('/public/images/<?= esc($category) ?>.jpg');"
                    >
                        <?= esc(ucfirst($category)) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Dish View -->
    <main class="container mx-auto px-4 py-10">
        <h2 class="text-4xl font-bold text-gray-800 mb-6" id="category-title"><?= esc(ucfirst(array_key_first($menuData))) ?></h2>
        <div class="dishes-container relative overflow-hidden">
            <div id="dishes-wrapper"></div>
        </div>
        <div class="flex justify-center mt-4 space-x-3" id="dish-indicators"></div>
    </main>

    <script>
        const menuData = <?= json_encode($menuData) ?>;
        let currentCategory = '<?= array_key_first($menuData) ?>';
        let currentDishIndex = 0;
        let dishes = [];
        let startX = 0, isSwiping = false;

        document.addEventListener('DOMContentLoaded', () => {
            const categoryButtons = document.querySelectorAll('.category-btn');
            categoryButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    currentCategory = btn.dataset.category;
                    currentDishIndex = 0;
                    loadCategory(currentCategory);
                });
            });

            const container = document.querySelector('.dishes-container');
            container.addEventListener('touchstart', e => { startX = e.touches[0].clientX; isSwiping = true; });
            container.addEventListener('touchend', e => { if (isSwiping) handleSwipe(e.changedTouches[0].clientX); isSwiping = false; });

            container.addEventListener('mousedown', e => { startX = e.clientX; isSwiping = true; });
            container.addEventListener('mouseup', e => { if (isSwiping) handleSwipe(e.clientX); isSwiping = false; });

            loadCategory(currentCategory);
        });

        function handleSwipe(endX) {
            const deltaX = endX - startX;
            if (deltaX > 50) showPreviousDish();
            else if (deltaX < -50) showNextDish();
        }

        function loadCategory(category) {
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.toggle('active', btn.dataset.category === category);
            });

            document.getElementById('category-title').textContent = category.charAt(0).toUpperCase() + category.slice(1);
            dishes = menuData[category];
            const wrapper = document.getElementById('dishes-wrapper');
            wrapper.innerHTML = '';

            dishes.forEach((dish, index) => {
                const card = document.createElement('div');
                card.className = `dish-card ${index === 0 ? 'active' : ''}`;
                const trendingText = (dish.trending === 1) ? 'Trending' : 'Not Trending';
                const trendingColor = (dish.trending === 1) ? 'text-green-600' : 'text-red-600';
                
                // Image path adjustment (prepend '/public/images' to stored relative path)
                const imgPath = `/public/images${dish.itemimage}`; // Prepend /public/images to the relative path stored in DB

                card.innerHTML = `
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="h-64 overflow-hidden">
                            <img src="${imgPath}" alt="${dish.itemname}" class="w-full h-full object-cover rounded-t-xl">
                        </div>
                        <div class="p-5">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-2xl font-semibold text-gray-900">${dish.itemname}</h3>
                                <span class="text-lg font-semibold text-orange-600">₹${dish.itemprice}</span>
                            </div>
                            <p class="text-gray-700 mb-4">${dish.itemingredient || ''}</p>
                            <div class="text-sm ${trendingColor}">
                                ${trendingText}
                            </div>
                        </div>
                    </div>`;
                wrapper.appendChild(card);
            });

            updateIndicators();
        }

        function updateIndicators() {
            const indicators = document.getElementById('dish-indicators');
            indicators.innerHTML = '';
            dishes.forEach((_, i) => {
                const dot = document.createElement('span');
                dot.className = `w-4 h-4 rounded-full ${i === currentDishIndex ? 'bg-teal-600' : 'bg-gray-400'}`;
                indicators.appendChild(dot);
            });
        }

        function updateActiveDish() {
            const cards = document.querySelectorAll('.dish-card');
            cards.forEach((card, i) => card.classList.toggle('active', i === currentDishIndex));
            updateIndicators();
        }

        function showNextDish() {
            if (currentDishIndex < dishes.length - 1) {
                currentDishIndex++;
                updateActiveDish();
            }
        }

        function showPreviousDish() {
            if (currentDishIndex > 0) {
                currentDishIndex--;
                updateActiveDish();
            }
        }
    </script>
</body>
</html>
