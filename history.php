<!-- Nama File: history.php -->
<!-- Deskripsi: File ini menampilkan riwayat pemakaian daya secara rinci -->
<!-- Dibuat oleh: Elvan - NIM: 3312311004 -->
<!-- Tanggal: 12 November 2024 -->
<?php require 'connect_mysql.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'metadata.php'; ?>
    <title>History</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
</head>
<body id="history">
    <?php require 'navbar.php'; ?>
    
    <div class="garis"></div>
    <div class="history">
        <p>HISTORY</p>
    </div>
    <div class="table-container">
    
    <table id="table-body">
        <thead>
        <tr>
            <th>No</th>
            <th>Area</th>
            <th>Control <br>ON</th>
            <th> Control <br>OFF</th>
            <th>Start</th>
            <th>Finish</th>
            <th>Power <br>Consumed</th>
        </tr>
        </thead>
        <tbody>
                    <?php
                    
                    if (isset($connect)) {
                        $sql = "SELECT * FROM history";
                        $result = mysqli_query($connect, $sql);
    
                        if (mysqli_num_rows($result) > 0) {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . htmlspecialchars($row['area']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['control_on']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['control_off']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['start_time']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['finish_time']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['power_consumed']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'No data found.</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Failed to connect to database.</td></tr>";
                    }
                    ?>
                </tbody>
    </table>
    
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="history.js"></script>
</body>
</html>