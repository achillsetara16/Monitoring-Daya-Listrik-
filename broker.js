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

broker.on("ready", () => {
  console.log("Broker is ready!");
});

broker.on("published", (packet) => {
  message = packet.payload.toString();
  console.log(`Topic: ${packet.topic}, Message: ${message}`);
});
