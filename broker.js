// Mosca MQTT broker
var mosca = require("mosca");
var settings = {
  port: 1883,
  http: {
    port: 8080,
    bundle: true,
    static: "./",
  },
};
var broker = new mosca.Server(settings);

// MySQL
var mysql = require("mysql");
var db = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "power_monitoring",
});

db.connect(() => {
  console.log("Database connected!");
});

broker.on("ready", () => {
  console.log("Broker is ready!");
});

energyArea1 = 0;
energyArea2 = 0;

control1 = "";
control2 = "";

broker.on("published", (packet) => {
  topic = packet.topic;
  message = packet.payload.toString();

  index = message.indexOf(",");
  lamp = message.substring(0, index);

  lampIndex = lamp.indexOf("-");
  lampStatus = lamp.substring(0, lampIndex - 1);
  control = lamp.substring(lampIndex + 1);
  power = 0;
  if (lampStatus == "ON") {
    power = message.substring(index + 1);
  }

  if (topic == "area/1/iot") {
    energyArea1 += parseFloat(power) / 3600;
    control1 = control;
  }

  if (topic == "area/2/iot") {
    energyArea2 += parseFloat(power) / 3600;
    control2 = control;
  }

  if (lampStatus == "OFF") {
    sql = "UPDATE history SET control_off = ?, finish_time = ?, power_consumed = ? WHERE control_off IS NULL AND area = ?";

    if (topic == "area/1/iot") {
      db.query(sql, [control1, getCurrentDateTime(), energyArea1, "Area 1"]);
      energyArea1 = 0;
    }

    if (topic == "area/2/iot") {
      db.query(sql, [control2, getCurrentDateTime(), energyArea2, "Area 2"]);
      energyArea2 = 0;
    }
  }
});

function getCurrentDateTime() {
  now = new Date();

  year = now.getFullYear();
  month = String(now.getMonth() + 1).padStart(2, "0");
  day = String(now.getDate()).padStart(2, "0");
  hours = String(now.getHours()).padStart(2, "0");
  minutes = String(now.getMinutes()).padStart(2, "0");
  seconds = String(now.getSeconds()).padStart(2, "0");

  return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

setInterval(() => {
  sql_select = "SELECT COUNT(*) AS count FROM history WHERE area = ? AND control_off IS NULL";
  sql_insert = "INSERT INTO history (area, control_on, start_time, power_consumed) VALUES (?, ?, ?, ?)";
  sql_update = "UPDATE history SET power_consumed = ? WHERE area = ? ORDER BY id DESC LIMIT 1";
  startTime = getCurrentDateTime();

  if (energyArea1 > 0) {
    db.query(sql_select, ["Area 1"], (err, results) => {
      stillOn = results[0].count;
      if (stillOn > 0) {
        db.query(sql_update, [energyArea1, "Area 1"], (err) => {});
      } else {
        db.query(sql_insert, ["Area 1", control1, startTime, energyArea1], (err) => {});
      }
    });
  }

  if (energyArea2 > 0) {
    db.query(sql_select, ["Area 2"], (err, results) => {
      stillOn = results[0].count;
      if (stillOn > 0) {
        db.query(sql_update, [energyArea2, "Area 2"], (err) => {});
      } else {
        db.query(sql_insert, ["Area 2", control2, startTime, energyArea2], (err) => {});
      }
    });
  }
}, 5000);
