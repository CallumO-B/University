import processing.serial.*;

Serial port;

String[] ports = Serial.list();


void setup() {

  println(ports);
  println("Beginning finding ports...");

  int port_number = 0;
  boolean port_found = false;

  //While Arduino port not found...
  while (!port_found) {
    
    //If no ports have been found, call exit and break to finish setup before exiting.
    if(ports.length == 0){
      
      print("Port List is empty, no devices found!");
      exit();
      break;
      
    }
    
    //For each available port...
    for (int i = 0; (i < ports.length) && (!port_found); i++) {

      String handshake = "";
      boolean port_open = false;

      //Try each port.
      try {

        //Open the serial port for testing.
        port = new Serial(this, ports[i], 115200);
        port_open = true;
        
        port_number = i;
        
        //Clear old stuff from the port to stop mid-string readings.
        port.clear();

        //Read port for a second...
        int start_time = millis();

        print("Port: ");
        println(ports[i]);
        
        
        while ((millis() - start_time) < 1000) {
          
          while(port.available() > 0){
            
            //Read a string from buffer until the next newline.
            handshake = port.readStringUntil('\n');
          
          }
          
        }
        
        port.stop();

        print("Current String: ");
        println(handshake);
        print("Length: ");
        println(handshake.length());
        println("\n\n");
        
        //If string contains the substring "ARDUINO", port has been found.
        if (handshake.contains("ARDUINO")) {

          port_found = true;
        }
        
        
      }
      catch(Exception e)
      {

        //If exception was thrown after the port was successfully opened, close the port.
        if (port_open) {

          port.stop();
        }
      }//End Catch
    }//End For
  }//End While
  
  if(port_found){
    
    port = new Serial(this, ports[port_number], 115200);
    
  }
  
}//End Setup


void draw() {
  
  
  
  
  if(port.available() > 0){
    
    println(port.readStringUntil('\n'));
  
  }
  
}