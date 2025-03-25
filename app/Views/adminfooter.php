<footer class="bg-gray-900 text-white py-6 mt-10">
    <div class="max-w-6xl mx-auto text-center">
        <p class="text-lg font-semibold">Delicious Dine - Table Booking</p>
        <p class="text-sm mt-1">&copy; <?php echo date("Y"); ?> All Rights Reserved.</p>
        <div class="flex justify-center space-x-4 mt-3">
            <a href="#" class="hover:text-gray-400">Privacy Policy</a>
            <a href="#" class="hover:text-gray-400">Terms & Conditions</a>
            <a href="contact.php" class="hover:text-gray-400">Contact Us</a>
        </div>
    </div>
</footer>

<!-- admindashboard script code -->

 <!-- JavaScript for Charts -->
 <script>
        // Sales Chart (Pie Chart)
         // Sales Chart (Smaller Pie Chart)
    const salesChartCanvas = document.getElementById('salesChart').getContext('2d');
    new Chart(salesChartCanvas, {
        type: 'pie',
        data: {
            labels: ['Electronics', 'Clothing', 'Books', 'Other'],
            datasets: [{
                data: [300, 150, 100, 50],
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                hoverBackgroundColor: ['#FF7A9A', '#4AB2FB', '#FFDE7A', '#5AD0E0']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false // Ensures the pie chart does not grow
        }
    });

        // Revenue Chart (Bar Graph)
        const revenueChartCanvas = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueChartCanvas, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Monthly Revenue',
                    data: [12000, 15000, 10000, 18000, 16000, 20000],
                    backgroundColor: '#36A2EB',
                    borderColor: '#36A2EB',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Ensures defined height is respected
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

<!-- menu page script code -->
  <!-- JavaScript for Adding and Managing Dishes -->
  <script>
        document.getElementById("addDishForm").addEventListener("submit", function(event) {
            event.preventDefault();

            let name = document.getElementById("dishName").value;
            let price = document.getElementById("dishPrice").value;
            let imageInput = document.getElementById("dishImage");
            let imageFile = imageInput.files[0];

            if (!name || !price || !imageFile) {
                alert("Please fill in all fields!");
                return;
            }

            let imageURL = URL.createObjectURL(imageFile);
            let tableBody = document.getElementById("menuTableBody");
            let newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td class="border border-gray-300 px-4 py-2">
                    <img src="${imageURL}" class="w-16 h-16 object-cover rounded">
                </td>
                <td class="border border-gray-300 px-4 py-2">${name}</td>
                <td class="border border-gray-300 px-4 py-2">$${price}</td>
                <td class="border border-gray-300 px-4 py-2 text-center">
                    <button onclick="updateDish(this)" class="bg-yellow-500 hover:bg-yellow-700 text-white px-2 py-1 rounded">Update</button>
                    <button onclick="deleteDish(this)" class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded">Delete</button>
                </td>
            `;
            tableBody.appendChild(newRow);
            document.getElementById("dishName").value = "";
            document.getElementById("dishPrice").value = "";
            document.getElementById("dishImage").value = "";
        });

        function deleteDish(button) {
            button.closest("tr").remove();
        }

        function updateDish(button) {
            alert("Update functionality to be implemented!");
        }
    </script>



</body>
</html>