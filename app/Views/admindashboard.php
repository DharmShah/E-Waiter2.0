<?php include 'adminheader.php'; ?>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                
                <!-- Sales Distribution Chart (Smaller Pie Chart) -->
                <div class="bg-white shadow rounded p-4 h-[450px] flex flex-col items-center">
                    <h2 class="text-xl font-semibold mb-2">Sales Distribution</h2>
                    <div class="w-[300px] h-[350px] mx-auto">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                

                <!-- Monthly Revenue Chart -->
                <div class="bg-white shadow rounded p-4 h-[450px] flex flex-col">
                    <h2 class="text-xl font-semibold mb-2">Monthly Revenue</h2>
                    <canvas id="revenueChart" class="h-250 w-300"></canvas>
                </div>

                <!-- Recent Orders Table -->
                <div class="bg-white shadow rounded p-4 lg:col-span-2 h-[full] overflow-auto">
                    <h2 class="text-xl font-semibold mb-2">Recent Orders</h2>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left font-semibold">Order ID</th>
                                <th class="px-4 py-2 text-left font-semibold">Table No.</th>
                                <th class="px-4 py-2 text-left font-semibold">Time</th>
                                <th class="px-4 py-2 text-left font-semibold">Date</th>
                                <th class="px-4 py-2 text-left font-semibold">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t">
                                <td class="px-4 py-2">#12345</td>
                                <td class="px-4 py-2">6</td>
                                <td class="px-4 py-2">5:30pm</td>
                                <td class="px-4 py-2">2023-10-26</td>
                                <td class="px-4 py-2">$120</td>
                            </tr>
                            <tr class="border-t">
                                <td class="px-4 py-2">#54321</td>
                                <td class="px-4 py-2">3</td>
                                <td class="px-4 py-2">5:45pm</td>
                                <td class="px-4 py-2">2023-10-27</td>
                                <td class="px-4 py-2">$80</td>
                            </tr>
                            <tr class="border-t">
                                <td class="px-4 py-2">#98765</td>
                                <td class="px-4 py-2">5</td>
                                <td class="px-4 py-2">10:15am</td>
                                <td class="px-4 py-2">2023-10-28</td>
                                <td class="px-4 py-2">$150</td>
                            </tr>
                            <tr class="border-t">
                                <td class="px-4 py-2">#24680</td>
                                <td class="px-4 py-2">2</td>
                                <td class="px-4 py-2">11:30am</td>
                                <td class="px-4 py-2">2023-10-29</td>
                                <td class="px-4 py-2">$90</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <?php include 'adminfooter.php'; ?>