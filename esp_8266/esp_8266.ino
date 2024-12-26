#include <WiFiManager.h>
#include <MQTTClient.h>
#include <SoftwareSerial.h>
SoftwareSerial espSerial(D5, D6); // D5 = RX, D6 = TX

const char SSID[] = "PBL IF-34";
const char* serverIp = "10.170.10.177";
const int port = 1883;

WiFiClient wifiClient;
MQTTClient mqttClient;

void configModeCallback (WiFiManager *myWiFiManager) {
  Serial.print("/Could not connect to Wi-Fi. Device is in configuration mode.");
  Serial.print("\nUser must connect to device \"");
  Serial.print(myWiFiManager->getConfigPortalSSID());
  Serial.print("\" as a WiFi access point,");
  Serial.print("\nand open the configuration page at ");
  Serial.print(WiFi.softAPIP());
  Serial.print(" to configure Wi-Fi.\n");
}

void setup() {
  Serial.begin(9600);
  espSerial.begin(9600);
  delay(1000);

  Serial.println();
  Serial.println("IoT Device Started");
  Serial.printf("Previously used SSID: %s\n", WiFi.SSID().c_str());

  WiFiManager wifiManager;
  wifiManager.setAPCallback(configModeCallback);
  wifiManager.setDebugOutput(false);

  wifiManager.autoConnect(SSID);

  Serial.print("\nDevice is on the network at ");
  Serial.print(WiFi.localIP());

  mqttClient.begin(serverIp, port, wifiClient);
  mqttClient.onMessage(messageReceived);

  connect();
}

void loop() {
  if (!mqttClient.connected()) connect();

  mqttClient.loop();

  if (espSerial.available()) {
    String data = espSerial.readStringUntil('\n');
    data.trim();
    publishMessages(data);
  }

  delay(1000);
}

void connect() {
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
  }
  Serial.println();
  Serial.print("Device's IP address is ");
  Serial.println(WiFi.localIP());
  Serial.print("WiFi signal strength (RSSI) is ");
  Serial.print(WiFi.RSSI());
  Serial.println(" dBm");

  while (!mqttClient.connect("pbl-if-34", "", "")) {
    Serial.print(".");
    delay(1000);
  }
  Serial.println("connected.");
  mqttClient.subscribe("area/1/web");
  mqttClient.subscribe("area/2/web");
}

void messageReceived(String &topic, String &payload) {
  Serial.println("Incoming message:");
  Serial.println("Topic: " + topic);
  Serial.println("Payload: " + payload);
  espSerial.println(payload);
}

void publishMessages(String message) {
  int semicolonPos = message.indexOf(';');
  String firstset = message.substring(0, semicolonPos);
  String secondset = message.substring(semicolonPos + 1);

  int commaPos1 = firstset.indexOf(',');
  String lamp1 = firstset.substring(0, commaPos1);
  float power1 = firstset.substring(commaPos1 + 1).toFloat();

  int stripPos1 = lamp1.indexOf('-');
  String lampStatus1 = lamp1.substring(0, stripPos1);
  String controlOn1 = lamp1.substring(stripPos1 + 1);

  int commaPos2 = secondset.indexOf(',');
  String lamp2 = secondset.substring(0, commaPos2);
  float power2 = secondset.substring(commaPos2 + 1).toFloat();

  int stripPos2 = lamp2.indexOf('-');
  String lampStatus2 = lamp2.substring(0, stripPos2);
  String controlOn2 = lamp2.substring(stripPos2 + 1);

  if (lampStatus1 == "ON1" || lampStatus1 == "OFF1") {
    mqttClient.publish("area/1/iot", firstset);
  }
  if (lampStatus2 == "ON2" || lampStatus2 == "OFF2") {
    mqttClient.publish("area/2/iot", secondset);
  }
}