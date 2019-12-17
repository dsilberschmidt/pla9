#include <SPI.h>
#include <WiFi101.h>
#include <PubSubClient.h>
#include <Arduino_MKRENV.h>
#include <ArduinoJson.h>
#include <Bounce2.h>
#include <string.h>

#include "arduino_secrets.h" 
///////please enter your sensitive data in the Secret tab/arduino_secrets.h
char ssid[] = SECRET_SSID;        // your network SSID (name)
char pass[] = SECRET_PASS;        // your network password (use for WPA, or use as key for WEP)
char mqttuser[] = MQTT_USER;      // User
char mqttpass[] = MQTT_PASS;
char mqtthost[] = MQTT_HOST;
// Password
int status = WL_IDLE_STATUS;     // the WiFi radio's status
IPAddress mqttserver(10,12 ,10 ,1 );
const int mqttport = 8883;

Bounce botonManual = Bounce();
Bounce botonSubir = Bounce();
Bounce botonBajar = Bounce();
const int pinSalidaAutomatico = 5;
const int pinSalidaSubirTemp = 4;
const int pinSalidaBajarTemp = 3;


//Variables funcionales:
const int relay1 = 2;
const int relay2 = 1;
boolean rele1State = LOW;
boolean rele2State = LOW;
boolean modoManual = false;
boolean estadoError = false;
String error ="";

float temperaturaDeseada = 0;
float temperature = 0;
float humidity    = 0;
float pressure    = 0;


// Callback function header
void callback(char* topic, byte* payload, unsigned int length);

// Initialize the client library
WiFiSSLClient wifiClient;
PubSubClient mqttClient(mqttserver, mqttport, callback, wifiClient);

long tiempoEnviaSensores = 0;
long tiempoEnvioReles = 0;
long now;

int incomingByte = 0; // for incoming serial data
String input = "";

void setup() {
  //Initialize serial and wait for port to open:
  Serial.begin(9600);
  
  pinMode(relay1, OUTPUT);
  pinMode(relay2, OUTPUT);
  digitalWrite(relay1, rele1State);
  digitalWrite(relay2, rele2State);

  botonManual.attach(pinSalidaAutomatico,INPUT_PULLUP); // Attach the botonManual to a pin with INPUT_PULLUP mode
  botonManual.interval(25); // Use a debounce interval of 25 milliseconds

  botonSubir.attach(pinSalidaSubirTemp,INPUT_PULLUP); // Attach the botonManual to a pin with INPUT_PULLUP mode
  botonSubir.interval(25); // Use a debounce interval of 25 milliseconds

  botonBajar.attach(pinSalidaBajarTemp,INPUT_PULLUP); // Attach the botonManual to a pin with INPUT_PULLUP mode
  botonBajar.interval(25); // Use a debounce interval of 25 milliseconds

  //Initialize MRKENV
  if (!ENV.begin()) {
    while (1);
  }  

  // check for the presence of the shield:
  if (WiFi.status() == WL_NO_SHIELD) {
    // don't continue:
    while (true);
  }

  // attempt to connect to WiFi network:
    Serial.println("rev wifi");
  while ( status != WL_CONNECTED) {
    // Connect to WPA/WPA2 network:
    status = WiFi.begin(ssid, pass);
    // wait 10 seconds for connection:
      Serial.println("reintentando wifi");
    delay(10000);
  }
    Serial.println("conectado wifi");
    Serial.println("Fin Status");
  if (mqttClient.connect(mqtthost, mqttuser, mqttpass)) {
    mqttClient.subscribe("homie/arduino/relays/relays/+/set");
    mqttClientPublishInit();
  }
  tiempoEnviaSensores = 0;
  tiempoEnvioReles = 0;
}


void loop(){
  //Publicacion de datos
  now = millis();
  if (!mqttClient.connected()) {
      reconnect();
  }else{
      mqttClient.loop();
      if (now - tiempoEnvioReles > 1000) {
        mqttClient.publish("homie/arduino/relays/rele1", String(rele1State).c_str(), true);
        mqttClient.publish("homie/arduino/relays/rele2", String(rele2State).c_str(), true);
        tiempoEnvioReles = now;
      }
      if (now - tiempoEnviaSensores > 5000) {
        tiempoEnviaSensores = now;
        mqttPublish();
      }
  }
  //Fin publicacion de datos
  revisabotones();
  if (modoManual == true){
    if (temperaturaDeseada > temperature){
      rele1State = HIGH;
    }else{
      rele1State = LOW;
    }
  }
  
  digitalWrite(relay1, rele1State);
  digitalWrite(relay2, rele2State);
}





  
