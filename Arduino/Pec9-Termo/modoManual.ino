

void cambiaModo(){
  modoManual = !modoManual;
  Serial.print("Modo: ");
  
  if (modoManual == true){
    Serial.println("Manual");
    temperaturaDeseada = temperature;
    Serial.print("Temperatura Deseada: ");
    Serial.println(temperaturaDeseada);
  }else{
    Serial.println("Automatico");
  }
}

void subirTempManual(){
  if (modoManual == true){
    temperaturaDeseada = temperaturaDeseada + 1;
    Serial.print("Temperatura Deseada: ");
    Serial.println(temperaturaDeseada);
  }
}

void bajarTempManual(){
  if (modoManual == true){
    temperaturaDeseada = temperaturaDeseada - 1;
    Serial.print("Temperatura Deseada: ");
    Serial.println(temperaturaDeseada);
  }
}

void revisabotones(){
  botonManual.update(); // Update the Bounce instance
  botonSubir.update(); // Update the Bounce instance
  botonBajar.update(); // Update the Bounce instance
   
   if ( botonManual.rose() ) {
      cambiaModo();
   }
   if ( botonSubir.rose() ) {
      subirTempManual();
   }
   if ( botonBajar.rose() ) {
      bajarTempManual();
   }
}
