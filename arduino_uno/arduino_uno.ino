#include <SoftwareSerial.h>
#include <PZEM004Tv30.h>

// Pin PZEM
#define RX_PIN 5  // RX Arduino to TX PZEM
#define TX_PIN 6  // TX Arduino to RX PZEM
SoftwareSerial pzemSerial(RX_PIN, TX_PIN);
PZEM004Tv30 pzem(pzemSerial);

#define RX_PIN2 10
#define TX_PIN2 11
SoftwareSerial pzemSerial2(RX_PIN2, TX_PIN2);
PZEM004Tv30 pzem2(pzemSerial2);

// Pin RELAY
#define RELAY_PIN 9
#define RELAY_PIN2 8

// Pin Sound Sensor KY-037
#define SOUND_SENSOR_PIN A0
#define THRESHOLD 100

// Pin Switch
const int button1 = 13;
const int button2 = 12;

// Variable
int lastButtonState = 0;              // Previous switch status
int lastButtonState2 = 0;
unsigned long lastDebounceTime = 0;   // Last time switch change status
unsigned long lastDebounceTime2 = 0;
unsigned long debounceDelay = 50;     // Debounce time
unsigned long debounceDelay2 = 50;

float voltage, current, power, energy;
float voltage2, current2, power2, energy2;

String lamp1 = "OFF1";
String lamp2 = "OFF2";

String control1;
String control2;


void setup() {
  Serial.begin(9600);

  pzemSerial.begin(9600);
  pzemSerial2.begin(9600);

  pinMode(RELAY_PIN, OUTPUT);
  digitalWrite(RELAY_PIN, HIGH);  // Turn Off

  pinMode(RELAY_PIN2, OUTPUT);
  digitalWrite(RELAY_PIN2, HIGH);

  pinMode(button1, INPUT_PULLUP);
  pinMode(button2, INPUT_PULLUP);

  Serial.println("Ready");
}

void loop() {

  // From Sound Sensor
  int soundLevel = analogRead(SOUND_SENSOR_PIN);

  if (soundLevel > THRESHOLD) {
    if (digitalRead(RELAY_PIN) == 1 && digitalRead(RELAY_PIN2) == 1) {
      digitalWrite(RELAY_PIN, LOW); // Turn On
      digitalWrite(RELAY_PIN2, LOW);
      lamp1 = "ON1";
      lamp2 = "ON2";
      control1 = "sound";
      control2 = "sound";
    } else {
      digitalWrite(RELAY_PIN, HIGH);  // Turn Off
      digitalWrite(RELAY_PIN2, HIGH);
      lamp1 = "OFF1";
      lamp2 = "OFF2";
      control1 = "sound";
      control2 = "sound";
    }
  }

  // From Web
  if (Serial.available() > 0) {
    String message = Serial.readStringUntil('\n');
    message.trim();

    if (message == "ON1") {
      digitalWrite(RELAY_PIN, LOW);
      lamp1 = "ON1";
      control1 = "button";
    } else if (message == "OFF1") {
      digitalWrite(RELAY_PIN, HIGH);
      lamp1 = "OFF1";
      control1 = "button";
    }

    if (message == "ON2") {
      digitalWrite(RELAY_PIN2, LOW);
      lamp2 = "ON2";
      control2 = "button";
    } else if (message == "OFF2") {
      digitalWrite(RELAY_PIN2, HIGH);
      lamp2 = "OFF2";
      control2 = "button";
    }
  }

  // From Switch
  int reading = digitalRead(button1);
  int reading2 = digitalRead(button2);

  // If switch status changed (from HIGH to LOW or vice versa)
  if (reading != lastButtonState) {
    lastDebounceTime = millis();  // Reset debounce timer
  }
  if (reading2 != lastButtonState2) {
    lastDebounceTime2 = millis();
  }

  // If switch stable (after debounceDelay)
  if ((millis() - lastDebounceTime) > debounceDelay) {
    if (digitalRead(RELAY_PIN) == 1) {
      digitalWrite(RELAY_PIN, LOW);  // Turn On
      lamp1 = "ON1";
      control1 = "switch";
    } else {
      digitalWrite(RELAY_PIN, HIGH);  // Turn Off
      lamp1 = "OFF1";
      control1 = "switch";
    }
    
    lastButtonState = reading;
  }

  if ((millis() - lastDebounceTime2) > debounceDelay2) {
    if (digitalRead(RELAY_PIN2) == 1) {
      digitalWrite(RELAY_PIN2, LOW);
      lamp2 = "ON2";
      control2 = "switch";
    } else {
      digitalWrite(RELAY_PIN2, HIGH);
      lamp2 = "OFF2";
      control2 = "switch";
    }

    lastButtonState2 = reading2;
  }


  // Read data from PZEM
  voltage = pzem.voltage();
  current = pzem.current();
  power = pzem.power();
  energy = pzem.energy();

  voltage2 = pzem2.voltage();
  current2 = pzem2.current();
  power2 = pzem2.power();
  energy2 = pzem2.energy();

  String data = lamp1 + "-" + control1 + "," + String(power) + ";" + lamp2 + "-" + control2 + "," + String(power2);
  Serial.println(data);

  delay(1000);
}