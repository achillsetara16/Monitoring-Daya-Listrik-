<!-- Nama File: dashboard.php -->
<!-- Deskripsi: File ini menampilkan data pemakaian daya dalam 1 hari -->
<!-- Dibuat oleh: Elvan - NIM: 3312311004 -->
<!-- Tanggal: 12 November 2024 -->

<!-- Nama File: dashboard.html -->
<!-- Deskripsi: File ini menampilkan data menggunakan grafik -->
<!-- Dibuat oleh: Donni - NIM: 3312311051 -->
<!-- Tanggal: 16 November 2024 -->

<!-- Nama File: dashboard.html -->
<!-- Deskripsi: File ini menampilkan hasil report penggunaan daya -->
<!-- Dibuat oleh: Masruri - NIM: 3312311110 -->
<!-- Tanggal: 17 November 2024 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="dashboard">
    <?php require 'navbar.php'; ?>
    <div class="container1">
    <div class="chart-container1">
        <h1>LIVE MONITORING</h1>
        <canvas id="powerChart"></canvas>
    </div>
    <div class="form-container1">
        <label for="building1">Building 1</label>
        <input type="text" id="building1" readonly />
    
        <label for="building2">Building 2</label>
        <input type="text" id="building2" readonly />
    
        <label for="total">Total</label>
        <input type="text" id="total" readonly />
    </div>
    </div>
    <div class="container3">
        <h3 class="report">REPORT</h3>
    <form action="report.php" method="POST">
        <div class="form-container">
            <div class="form-input">
                <label for="building">Building</label><br>
                <select name="building" id="building" required>
                    <option value="0">Choose...</option>
                    <option value="all">All Building</option>
                    <option value="1">Building 1</option>
                    <option value="2">Building 2</option>
                </select>
            </div>
            <div class="form-input">
                <label for="date_start">From</label><br>
                <input type="date" name="date_start" id="date_start" required>
            </div>
            <div class="form-input">
                <label for="date_end">Until</label><br>
                <input type="date" name="date_end" id="date_end" required>
            </div>
            <div class="form-input">
                <input type="submit" id="submit" value="View Report">
            </div>
        </div>
    </form>
</div>
</div>
    <script>
        const ctx = document.getElementById('powerChart').getContext('2d');
        const powerChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Building 1 (Watt)',
                        borderColor: '#0B5CF2',
                        backgroundColor: '#0B5CF2',
                        data: []
                    },
                    {
                        label: 'Building 2 (Watt)',
                        borderColor: '#FF0408',
                        backgroundColor: '#FF0408',
                        data: []
                    }
                ]
            },
            options: {
    responsive: true,
    scales: {
        x: {
            title: {
                display: true,
                text: 'Time',
                font: { 
                    size: 16, // Ukuran font
                    weight: 'bold' // Membuat teks tebal
                },
                color: '#000000' // Warna hitam
            }
        },
        y: {
            title: {
                display: true,
                text: 'POWER (Watt)',
                font: { 
                    size: 16, // Ukuran font
                    weight: 'bold' // Membuat teks tebal
                },
                color: '#000000' // Warna hitam
            }
        }
    }
}

        });

        function updateData() {
    fetch('/api/data-usage')
        .then(response => response.json())
        .then(data => {
            const labels = data.history.map(entry => entry.time);
            const building1Data = data.history.map(entry => entry.building1);
            const building2Data = data.history.map(entry => entry.building2);

            // Update chart dengan data terbaru
            powerChart.data.labels = labels;
            powerChart.data.datasets[0].data = building1Data;
            powerChart.data.datasets[1].data = building2Data;
            powerChart.update();

            // Panggil updateInputs dengan data terbaru dari grafik
            const latestBuilding1 = building1Data[building1Data.length - 1];
            const latestBuilding2 = building2Data[building2Data.length - 1];

            // Perbarui input berdasarkan data terbaru
            updateInputs(latestBuilding1, latestBuilding2);
        })
        .catch(error => console.error('Error fetching data:', error));
}

window.onload = updateData;

// Fungsi untuk memperbarui kolom input berdasarkan data terbaru
function updateInputs(building1Data, building2Data) {
    const building1Input = document.getElementById('building1');
    const building2Input = document.getElementById('building2');
    const totalInput = document.getElementById('total');

    // Set nilai untuk input field
    building1Input.value = building1Data + " W";
    building2Input.value = building2Data + " W";

    // Hitung total dan masukkan ke input total
    const total = building1Data + building2Data;
    totalInput.value = total + " W";
}
    </script>
</body>
</html>
