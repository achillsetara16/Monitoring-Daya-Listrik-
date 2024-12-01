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
</head>
<body id="history">
    <?php require 'navbar.php'; ?>
    
    <div class="garis"></div>
    <div class="history">
        <p>HISTORY</p>
    </div>
    <div class="table-container">
    <div class="table-controls">
    <div class="entries-per-page">
    <label for="entries">
        <select id="entries">
            <option value="10">10</option>
            <option value="20" selected>20</option>
            <option value="30">30</option>
        </select>
        entries per page
        </label>
    </div>
    <div class="search-box">
        <label for="search">Search:</label>
        <input type="text" id="search">
    </div>
    </div>
    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>Building</th>
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
                                echo "<td>" . htmlspecialchars($row['building']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['area']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['control_on']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['control_off']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['start_time']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['finish_time']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['power_consumed']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No data found.</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Failed to connect to database.</td></tr>";
                    }
                    ?>
                </tbody>
    </table>
    <div class="pagination-control">
    <p>Showing 1 to 20 of 32 entries</p>
    <div class="pagination">
                <a href="#">&lt;&lt;</a>
                <a href="#">&lt;</a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">&gt;</a>
                <a href="#">&gt;&gt;</a>
            </div>
            </div>
</div>
</body>
</html>