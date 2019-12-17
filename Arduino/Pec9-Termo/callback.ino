void callback(char* topic, byte* payload, unsigned int length) {
  String topicStr = topic;
  Serial.println(topicStr);
  Serial.println(payload[0]);
  if (modoManual == false){
    if (topicStr == "homie/arduino/relays/relays/rele1/set"){
      if (payload[0] == '0') {
        rele1State = LOW;
      }
      if (payload[0] == '1') {
        rele1State = HIGH;
      }
    }
    
    if (topicStr == "homie/arduino/relays/relays/rele2/set"){
      if (payload[0] == '0') {
        rele2State = LOW;
      }
      if (payload[0] == '1') {
        rele2State = HIGH;
      }
    }
  }
}
