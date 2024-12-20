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

<?php require 'connect_mysql.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'metadata.php'; ?>
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="style.css" rel="stylesheet">
</head>
<body id="dashboard">
    <?php require 'navbar.php'; ?>
    <div class="container1">
    <div class="chart-container1">
        <h1>LIVE MONITORING</h1>
        <canvas id="powerChart"></canvas>
    </div>
    <div class="form-container1">
        <label for="area1">AREA 1</label>
        <input type="text" id="area1" readonly />
    
        <label for="area2">AREA 2</label>
        <input type="text" id="area2" readonly />
    
        <label for="total">Total</label>
        <input type="text" id="total" readonly />
    </div>
    </div>
    <div class="container3">
        <h3 class="report">REPORT</h3>
    <form action="report.php" method="POST">
        <?php

        $sql = "SELECT start_time FROM history ORDER BY start_time LIMIT 1";
        $result = mysqli_query($connect, $sql);
        $data = mysqli_fetch_assoc($result);
        $start_date = date("Y-m-d", strtotime($data["start_time"]));

        ?>
        <div class="form-container">
            <div class="form-input">
                <label for="area">AREA</label><br>
                <select name="area" id="area" required>
                    <option value="0">Choose...</option>
                    <option value="all">All AREA</option>
                    <option value="1">AREA 1</option>
                    <option value="2">AREA 2</option>
                </select>
            </div>
            <div class="form-input">
                <label for="date_start">From</label><br>
                <input type="date" name="date_start" id="date_start" min="<?= $start_date ?>" max="<?= date("Y-m-d", strtotime("-1 day")) ?>" required>
            </div>
            <div class="form-input">
                <label for="date_end">Until</label><br>
                <input type="date" name="date_end" id="date_end" min="<?= $start_date ?>" max="<?= date("Y-m-d", strtotime("-1 day")) ?>" required>
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
                        label: 'AREA 1 (Watt)',
                        borderColor: '#0B5CF2',
                        backgroundColor: '#0B5CF2',
                        data: []
                    },
                    {
                        label: 'AREA 2 (Watt)',
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
            const area1Data = data.history.map(entry => entry.area1);
            const area2Data = data.history.map(entry => entry.area2);

            // Update chart dengan data terbaru
            powerChart.data.labels = labels;
            powerChart.data.datasets[0].data = area1Data;
            powerChart.data.datasets[1].data = area2Data;
            powerChart.update();

            // Panggil updateInputs dengan data terbaru dari grafik
            const latestArea1 = area1Data[area1Data.length - 1];
            const latestArea2 = area2Data[area2Data.length - 1];

            // Perbarui input berdasarkan data terbaru
            updateInputs(latestArea1, latestArea2);
        })
        .catch(error => console.error('Error fetching data:', error));
}

        window.onload = function() {
            updateInputs();

            setInterval(() => {
                updateInputs();
            }, 5000);

            updateData();
        };

        function updateInputs() {
            const area1Input = document.getElementById('area1');
            const area2Input = document.getElementById('area2');
            const totalInput = document.getElementById('total');

            function fetchAreaData(area) {
                return fetch('./area_power.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ area }),
                })
                .then(response => response.json())
                .then(data => parseFloat(data.total));
            }

            Promise.all([fetchAreaData('Area 1'), fetchAreaData('Area 2')])
                .then(([area1Data, area2Data]) => {
                    area1Input.value = area1Data.toFixed(4) + " Wh";
                    area2Input.value = area2Data.toFixed(4) + " Wh";

                    const total = area1Data + area2Data;
                    totalInput.value = total.toFixed(4) + " Wh";
                })
                .catch(error => {
                    console.error('Error fetching area data:', error);
                });
        }
    </script>
</body>
</html>
