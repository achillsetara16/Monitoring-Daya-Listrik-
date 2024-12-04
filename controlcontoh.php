<!-- Nama File: control.php -->
<!-- Deskripsi: File ini digunakan untuk menyala-matikan lampu -->
<!-- Dibuat oleh: Viodama - NIM: 3312311131 -->
<!-- Tanggal: 12 November 2024 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="contohcontrol.css" rel="stylesheet">
    <title>Control</title>
    <script>
        function toggleLamp(area, isOn) {
            const lamp = document.getElementById(`lamp-${area}`);
            if (isOn) {
                lamp.classList.add('on');
                lamp.classList.remove('off');
            } else {
                lamp.classList.add('off');
                lamp.classList.remove('on');
            }
        }
    </script>
</head>
<body class="control">
    <nav>
        <div class="logo">
            <img src="image/logo.png" alt="Logo" />
            <p>POWER MONITORING</p>
        </div>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a class="active" href="control.php">Control</a></li>
            <li><a href="history.php">History</a></li>
        </ul>
    </nav>

    <div class="container">
        <!-- Area 1 -->
        <div class="area">
            <h2>AREA 1</h2>
            <div class="content">
                <div class="left">
                    <button class="btn turn-on" onclick="toggleLamp(1, true)">TURN ON</button>
                    <button class="btn turn-off" onclick="toggleLamp(1, false)">TURN OFF</button>
                    <div class="lamp off" id="lamp-1"></div>
                </div>
                <div class="divider"></div>
                <div class="right">
                    <img src="image/tower.png" alt="Tower" class="icon">
                    <div class="electricity-line"></div>
                    <img src="image/warehouse.png" alt="Warehouse" class="icon">
                </div>
            </div>
        </div>

        <!-- Area 2 -->
        <div class="area">
            <h2>AREA 2</h2>
            <div class="content">
                <div class="left">
                    <button class="btn turn-on" onclick="toggleLamp(2, true)">TURN ON</button>
                    <button class="btn turn-off" onclick="toggleLamp(2, false)">TURN OFF</button>
                    <div class="lamp off" id="lamp-2"></div>
                </div>
                <div class="divider"></div>
                <div class="right">
                    <img src="image/tower.png" alt="Tower" class="icon">
                    <div class="electricity-line"></div>
                    <img src="image/warehouse.png" alt="Warehouse" class="icon">
                </div>
            </div>
        </div>
    </div>
</body>
</html>