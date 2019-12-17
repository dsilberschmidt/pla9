boolean reconnect() {

  if (mqttClient.connect(mqtthost, mqttuser, mqttpass)) {
    mqttClient.publish("outTopic","hello world");
    mqttClient.subscribe("homie/arduino/relays/+/set");
  }

  return mqttClient.connected();
}
