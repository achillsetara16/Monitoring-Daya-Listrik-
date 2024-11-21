<!-- Nama File: history.php -->
<!-- Deskripsi: File ini menampilkan riwayat pemakaian daya secara rinci -->
<!-- Dibuat oleh: Elvan - NIM: 3312311004 -->
<!-- Tanggal: 12 November 2024 -->

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
                    
                    $data = [
                        ["Building 2", "Area 2", "Button", "Switch", "2024-09-04 08:00:36", "2024-09-04 17:00:47", "1 kW"],
                        ["Building 1", "Area 1", "Button", "Switch", "2024-09-04 08:00:32", "2024-09-04 17:00:45", "1 kW"],
                        ["Building 2", "Area 2", "Button", "Sound", "2024-09-04 08:00:05", "2024-09-04 17:00:04", "1 kW"],
                        ["Building 1", "Area 1", "Button", "Switch", "2024-09-04 08:00:02", "2024-09-04 17:00:04", "1 kW"],
                        ["Building 2", "Area 2", "Switch", "Switch", "2024-09-02 08:00:15", "2024-09-03 17:00:11", "1 kW"],
                        ["Building 1", "Area 1", "Switch", "Sound", "2024-09-03 08:00:42", "2024-09-03 17:00:09", "1 kW"],
                        ["Building 2", "Area 2", "Sound", "Switch", "2024-09-03 08:00:03", "2024-09-03 17:00:06", "1 kW"],
                        ["Building 1", "Area 1", "Sound", "Switch", "2024-09-03 08:00:03", "2024-09-03 17:00:04", "1 kW"],
                        ["Building 2", "Area 2", "Button", "Sound", "2024-09-02 08:00:31", "2024-09-02 17:00:56", "1 kW"],
                        ["Building 1", "Area 1", "Button", "Switch", "2024-09-02 08:00:23", "2024-09-02 17:00:56", "1 kW"],
                        ["Building 2", "Area 2", "Switch", "Switch", "2024-09-02 08:00:15", "2024-09-02 17:00:04", "1 kW"],
                        ["Building 1", "Area 1", "Switch", "Sound", "2024-09-02 08:00:12", "2024-09-02 17:00:04", "1 kW"],
                        
                    ];
                    
                    $no = 1;
                    foreach ($data as $row) {
                        echo "<tr>";
                        echo "<td>{$no}</td>";
                        echo "<td>{$row[0]}</td>";
                        echo "<td>{$row[1]}</td>";
                        echo "<td>{$row[2]}</td>";
                        echo "<td>{$row[3]}</td>";
                        echo "<td>{$row[4]}</td>";
                        echo "<td>{$row[5]}</td>";
                        echo "<td>{$row[6]}</td>";
                        echo "</tr>";
                        $no++;
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