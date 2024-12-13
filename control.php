<!-- Nama File: control.php -->
<!-- Deskripsi: File ini digunakan untuk menyala-matikan lampu -->
<!-- Dibuat oleh: Viodama - NIM: 3312311131 -->
<!-- Tanggal: 12 November 2024 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'metadata.php'; ?>
    <title>Control</title>
    <script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
    <script>
        var client = mqtt.connect("ws://localhost:8080");

        client.on("connect", () => {
            console.log("Connect to MQTT Broker");
            // client.subscribe('area/1A');
            // client.subscribe('area/2A');
        });

        client.on("error", (err) => {
            console.error("Connection error: ", err);
        });

        client.on('message', (topic, message)=>{
            message = message.toString();
            console.log(topic, message);

            if (topic == 'area/1A') {
                if (message == 'ON1') {
                    this.lampOn(1);
                } else if (message == 'OFF1') {
                    this.lampOff(1);
                }
            } else if (topic == 'area/2A') {
                if (message == 'ON2') {
                    this.lampOn(2);
                } else if (message == 'OFF2') {
                    this.lampOff(2);
                }
            }
        })

        function toggleLamp(area, isOn) {
            const lampOn =document.querySelector(`#lamp-${area}-on`);
            const lampOff =document.querySelector(`#lamp-${area}-off`);
            const turnOnButton = document.querySelector(`#turn-on-${area}`);
            const turnOffButton = document.querySelector(`#turn-off-${area}`);
            const electricityLine = document.querySelector(`.electricity-line-${area}`); // Select electricity line for the area

            if (isOn) {
                client.publish(`area/${area}`, 'ON');
                console.log(`Publishing message: ON to topic: area/${area}`);
                this.lampOn(area);
            } else {
                client.publish(`area/${area}`, 'OFF');
                console.log(`Publishing message: OFF to topic: area/${area}`);
                this.lampOff(area);
            }
        }

        window.onload = function() {
            // Menetapkan warna default ke tombol OFF dan ON pada saat pertama kali dimuat
            const turnOnButton1 = document.querySelector('#turn-on-1');
            const turnOffButton1 = document.querySelector('#turn-off-1');
            
            const turnOnButton2 = document.querySelector('#turn-on-2');
            const turnOffButton2 = document.querySelector('#turn-off-2');
            
            // Setel warna tombol ke abu-abu ketika halaman dimuat
            turnOnButton1.style.backgroundColor = '#cccccc';
            turnOnButton1.style.color = 'black';
            
            turnOffButton1.style.backgroundColor = '#cccccc';
            turnOffButton1.style.color = 'black';

            turnOnButton2.style.backgroundColor = '#cccccc';
            turnOnButton2.style.color = 'black';

            turnOffButton2.style.backgroundColor = '#cccccc';
            turnOffButton2.style.color = 'black';

            // Set default border color for the containers to grey
            const container1 = document.querySelector('#area-1-container');
            const container2 = document.querySelector('#area-2-container');

            container1.style.borderColor = '#b2b6bd';
            container2.style.borderColor = '#b2b6bd';

            client.subscribe('area/1A');
            client.subscribe('area/2A');
        };

        function lampOn(area) {
            const lampOn =document.querySelector(`#lamp-${area}-on`);
            const lampOff =document.querySelector(`#lamp-${area}-off`);
            const turnOnButton = document.querySelector(`#turn-on-${area}`);
            const turnOffButton = document.querySelector(`#turn-off-${area}`);
            const electricityLine = document.querySelector(`.electricity-line-${area}`); // Select electricity line for the area
            const container = document.querySelector(`#area-${area}-container`); // Access the container

            // Toggle lamp state
            lampOff.classList.add('d-none');
            lampOn.classList.remove('d-none');
            electricityLine.classList.remove('d-none'); // Show electricity line
            // Update button style
            turnOnButton.style.backgroundColor = '#32cd32'; // Green
            turnOnButton.style.color = 'white';
            turnOffButton.style.backgroundColor = '#cccccc'; // Grey
            turnOffButton.style.color = 'black';

            container.style.borderColor = '#fdc600'; // Yellow
        }

        function lampOff(area) {
            const lampOn =document.querySelector(`#lamp-${area}-on`);
            const lampOff =document.querySelector(`#lamp-${area}-off`);
            const turnOnButton = document.querySelector(`#turn-on-${area}`);
            const turnOffButton = document.querySelector(`#turn-off-${area}`);
            const electricityLine = document.querySelector(`.electricity-line-${area}`); // Select electricity line for the area
            const container = document.querySelector(`#area-${area}-container`); // Access the container

            // Toggle lamp state
            lampOff.classList.remove('d-none');
            lampOn.classList.add('d-none');
            electricityLine.classList.add('d-none'); // Hide electricity line
            // Update button styles
            turnOffButton.style.backgroundColor = '#ff6347'; // Red
            turnOffButton.style.color = 'white';
            turnOnButton.style.backgroundColor = '#cccccc'; // Grey
            turnOnButton.style.color = 'black';

            container.style.borderColor = '#b2b6bd'; // Grey
        }

    </script>
</head>
<body class="control">
    <?php require 'navbar.php'; ?>
    <!-- nanti diisi disni -->
    <div class="container" id="area-1-container">
        <!-- Area 1 -->
        <div class="area">
            <h2>AREA 1</h2>
            <div class="content">
                <div class="left">
                    <button id="turn-on-1" class="btn turn-on" onclick="toggleLamp(1, true)">TURN ON</button>
                    <button id="turn-off-1" class="btn turn-off" onclick="toggleLamp(1, false)">TURN OFF</button>
                    <img src="image/lamp_off.png" alt="lamp" id="lamp-1-off">
                    <img src="image/lamp_on.png" alt="lamp" id="lamp-1-on" class="d-none">
                </div>
                <div class="divider"></div>
                <div class="right">
                    <img src="image/tower.png" alt="Tower" class="icontower1">
                    <!-- <div class="electricity-line"></div> -->
                    <div class="electricity-line">
                    <img src="image/dnoyd6rMvw29q-ezgif.com-speed.webp" class="electricity-line electricity-line-1 d-none">
</div>
                    <img src="image/warehouse.png" alt="Warehouse" class="iconwarehouse1">
                </div>
            </div>
        </div>
</div>
        <!-- Area 2 -->
        <div class="container" id="area-2-container">
        <div class="area">
            <h2>AREA 2</h2>
            <div class="content">
                <div class="left">
                    <button id="turn-on-2" class="btn turn-on" onclick="toggleLamp(2, true)">TURN ON</button>
                    <button id="turn-off-2" class="btn turn-off" onclick="toggleLamp(2, false)">TURN OFF</button>
                    <img src="image/lamp_off.png" alt="lamp" id="lamp-2-off">
                    <img src="image/lamp_on.png" alt="lamp" id="lamp-2-on" class="d-none">
                </div>
                <div class="divider"></div>
                <div class="right">
                    <img src="image/tower.png" alt="Tower" class="icontower2">
                    <!-- <div class="electricity-line"></div> -->
                    <div class="electricity-line">
                    <img src="image/dnoyd6rMvw29q-ezgif.com-speed.webp" class="electricity-line electricity-line-2 d-none">
</div>
                    <img src="image/warehouse.png" alt="Warehouse" class="iconwarehouse2">
                </div>
            </div>
        </div>
    </div>
</body>
</html>