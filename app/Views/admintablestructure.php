<?php include 'adminheader.php'; ?>

<main class="flex-1 p-8">
    <div class="bg-white shadow p-4 mt-4 mx-auto max-w-4xl rounded">
        <h2 class="text-xl font-semibold mb-3">Manage Tables</h2>

        <!-- Form to Update Number of Tables -->
        <form action="<?= base_url('/updateTables') ?>" method="post">
            <label class="block mb-2">Enter number of tables:</label>
            <input type="number" name="numTables" class="border p-2 rounded w-full" required>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-3 rounded">
                Update Tables
            </button>
        </form>
    </div>

    <!-- Display Existing Tables in Grid Layout -->
    <div class="mt-6 mx-auto max-w-4xl bg-white shadow p-4 rounded">
        <h2 class="text-xl font-semibold mb-3">Existing Tables</h2>
        <div class="grid grid-cols-4 gap-4">
            <?php foreach ($tables as $table) : ?>
                <div class="p-4 border border-gray-300 rounded shadow-lg text-center">
                    <img src="<?= base_url('public/table.png') ?>" alt="Table Image" class="w-20 h-20 mx-auto">
                    <p class="mt-2 font-semibold">Table <?= esc($table['table_number']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php include 'adminfooter.php'; ?>
