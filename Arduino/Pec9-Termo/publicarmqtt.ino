void mqttClientPublishInit(){
  mqttClient.publish("homie/arduino/$homie", "3.0", true);
  mqttClient.publish("homie/arduino/$name", "Arduino MKR1000", true);
  mqttClient.publish("homie/arduino/$nodes", "(mkrenv,relays)", true);
  mqttClient.publish("homie/arduino/$state", "ready", true);
  mqttClient.publish("homie/arduino/mkrenv/$name", "Grupo4-env-01", true);
  mqttClient.publish("homie/arduino/mkrenv/$properties", "(temperature, humidity, pressure, illuminance, uva, uvb, uvindex)", true);
  //Temperature
  mqttClient.publish("homie/arduino/mkrenv/temperature/$name", "Temperature", true);
  mqttClient.publish("homie/arduino/mkrenv/temperature/$unit", "ºC", true);
  mqttClient.publish("homie/arduino/mkrenv/temperature/$datatype", "float", true);
  mqttClient.publish("homie/arduino/mkrenv/temperature/$settable", "false", true);
  //Humidity
  mqttClient.publish("homie/arduino/mkrenv/humidity/$name", "Humidity", true);
  mqttClient.publish("homie/arduino/mkrenv/humidity/$unit", "%", true);
  mqttClient.publish("homie/arduino/mkrenv/humidity/$datatype", "float", true);
  mqttClient.publish("homie/arduino/mkrenv/humidity/$settable", "false", true);  
  //Pressure
  mqttClient.publish("homie/arduino/mkrenv/pressure/$name", "Pressure", true);
  mqttClient.publish("homie/arduino/mkrenv/pressure/$unit", "kPa", true);
  mqttClient.publish("homie/arduino/mkrenv/pressure/$datatype", "float", true);
  mqttClient.publish("homie/arduino/mkrenv/pressure/$settable", "false", true); 
  //Relays
  mqttClient.publish("homie/arduino/relays/$name", "Grupo4-relays-01", true);
  mqttClient.publish("homie/arduino/relays/$properties", "(rele1, rele2)", true);  
    //Relay1
  mqttClient.publish("homie/arduino/relays/rele1/$name", "rele1", true);
  mqttClient.publish("homie/arduino/relays/rele1/$datatype", "boolean", true);
  mqttClient.publish("homie/arduino/relays/rele1/$settable", "true", true);  
    //Relay2
  mqttClient.publish("homie/arduino/relays/rele2/$name", "rele 2", true);
  mqttClient.publish("homie/arduino/relays/rele2/$datatype", "boolean", true);
  mqttClient.publish("homie/arduino/relays/rele2/$settable", "true", true);  
}


void mqttPublish(){
  temperature = ENV.readTemperature();
  humidity    = ENV.readHumidity();
  pressure    = ENV.readPressure();

  mqttClient.publish("homie/arduino/mkrenv/temperature", String(temperature).c_str(), true);  
  mqttClient.publish("homie/arduino/mkrenv/humidity", String(humidity).c_str(), true);
  mqttClient.publish("homie/arduino/mkrenv/pressure", String(pressure).c_str(), true);
  mqttClient.publish("homie/arduino/$state", "ready", true);
  if(modoManual == true){
    mqttClient.publish("homie/arduino/$modoManual", "true", true);
  }else{
    mqttClient.publish("homie/arduino/$modoManual", "false", true);
  }
  if(estadoError == true){
    mqttClient.publish("homie/arduino/$estadoError", String(error).c_str(), true);
  }
}
