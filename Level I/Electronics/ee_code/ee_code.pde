import processing.serial.*;    //importing serial port library
import javax.swing.JOptionPane;
PrintWriter output; // creating variable to write data to a file
Serial ehealthPort; // assisgning the name my port to serial port 

String file_name, serial_input;
String[] portNames = Serial.list();
PImage img;
PFont font;
float [] values= new float [10];
int count=0, xPos = 20, max_resistance = 1000000;

//arrays to control graph colour
int [] r  = new int [10];
int [] g  = new int [10];
int [] b  = new int [10];

//arrays to control graph plot size
int [] max = new int [9];
int [] min = new int [9];

//array of graphs
Graph[] sensorGraphs= new Graph[10];


void setup() {
  stroke(250);
   colorMode(RGB);
   size(1100, 700);
   img = loadImage("hope_logo.jpg"); img.resize(1100, 700); background(img);
   
   //creates line graph, setting position and colour
   sensorGraphs[1]= new Graph(120, 50);
   r[1]=40; g[1]=200; b[1]=150; 
   
   sensorGraphs[2]= new Graph(120, 200);
   r[2]=40; g[2]=240; b[2]=120;
   
   sensorGraphs[3]= new Graph(120, 340);
   r[3]=240; g[3]=0; b[3]=150;
   
   sensorGraphs[4]= new Graph(120, 470);
   r[4]=0; g[4]=255; b[4]=0;
   
   sensorGraphs[5]= new Graph(120, 590);
   r[5]=250; g[5]=50; b[5]=0;
   
   sensorGraphs[6]= new Graph(520, 50);
   r[6]=170; g[6]=150; b[6]=170;
   
   sensorGraphs[7]= new Graph(520, 200);
   r[7]=0; g[7]=0; b[7]=255;
   
   sensorGraphs[8]= new Graph(520, 340);
   r[8]=0; g[8]=255; b[8]=0;
   
   sensorGraphs[9]= new Graph(520, 470);
   r[9]=255; g[9]=0; b[9]=0;

// creates maximum and minimum range for plotted values
  sensorGraphs[1].map_graph(30, 50);  
  sensorGraphs[2].map_graph(50, 700); 
  sensorGraphs[3].map_graph(0, 4);
  sensorGraphs[4].map_graph(0, 1000);
  sensorGraphs[5].map_graph(0, 30);
  sensorGraphs[6].map_graph(0, max_resistance);  
  sensorGraphs[7].map_graph(0, 4);  
  sensorGraphs[8].map_graph(0, 200);
  sensorGraphs[9].map_graph(90, 100);

  file_name= JOptionPane.showInputDialog("A name for the file");
  file_name = file_name + ".txt"; // adds file type to name entered
  output = createWriter( file_name ); // writes to text file

// to find arduino in the computer's serial ports
/*  println(Serial.list());  println(portNames);*/
  
  println("Beginning finding portNames...");
  int port_number = 0;
  boolean port_found = false;

  //While Arduino port not found...
  while (!port_found) {
    
    //If no portNames have been found, call exit and break to finish setup before exiting.
    if(portNames.length == 0){
      
      print("Port List is empty, no devices found!");
      exit();
      break;  
 
}

    //For each available port...
    for (int i = 0; (i < portNames.length) && (!port_found); i++) {

      String handshake = "";
      boolean port_open = false;

      //Try each port.
      try {

        //Open the serial port for testing.
        ehealthPort = new Serial(this, portNames[i], 115200);
        port_open = true;
        
        port_number = i;
        
        //Clear old stuff from the port to stop mid-string readings.
        ehealthPort.clear();

        //Read port for a second...
        int start_time = millis();

        print("Port: ");
        println(portNames[i]);
        
        
        while ((millis() - start_time) < 1000) {
          
          while(ehealthPort.available() > 0){
            
            //Read a string from buffer until the next newline.
            handshake = ehealthPort.readStringUntil('\n');
          
          }
          
        }
        
        ehealthPort.stop();

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

          ehealthPort.stop();
        }
      }//End Catch
    }//End For
  }//End While
  
  if(port_found){
    // second try catch acounts for port busy
    try
    {
    ehealthPort = new Serial(this, portNames[port_number], 115200);
    }
    catch(Exception e)
    {
      ehealthPort.clear();
      ehealthPort.stop();
      delay(500);
      ehealthPort = new Serial(this, portNames[port_number], 115200);
    }
  }
  
}//End Setup

void draw()
{
  img = loadImage("hope_logo.jpg"); 
  img.resize(1100, 700); 
  background(img);
  
  // true if selected port is available 
  if (ehealthPort.available() > 0 ) 
  {
    // reads input upto new line
    serial_input = ehealthPort.readStringUntil('\n');
    
    if (  serial_input != null ) 
    {
      //removes arduino from input string
      serial_input = serial_input.replace("ARDUINO", "");
      
      // rites inout string to text file
      output.println(serial_input);
      
      //println(ehealthPort.readStringUntil('\n'));
      // removes semi-colon from input string
      values = float(split(serial_input, ';'));

      if (values[5] > max_resistance) 
      {

        max_resistance = int(values[5]);
        sensorGraphs[5].map_graph(0, max_resistance);
      }
    }
  }
  
  // try catch prevents out of bounds prompt, preventing application crash
  try 
  {
    for (int i=1; i<10; i++) 
    {
      sensorGraphs[i].add_value(values[i]);
      sensorGraphs[i].plot(r[i], g[i], b[i]);
    } 
    graphs();
  }
  catch(ArrayIndexOutOfBoundsException e) {};
}

// class to create line graphs
class Graph {

  int x_start, x_max = 250, y_min;
  int min_sensor_val = 0, max_sensor_val = 100, graph_max_height = 90; 
  float[] value = new float[x_max];

  Graph(int x, int y) 
  {
    x_start = x;
    y_min = y;
  }

  //Tack on a new value after bumping up all others.
  void add_value(float new_value) 
  {
    
    if (new_value != new_value)
    {
      return;
    }

    for (int i = value.length - 1; i > 0; i--) 
    {
      value[i] = value[i - 1];
    }
    
    value[0] = map(new_value, min_sensor_val, max_sensor_val, 0, graph_max_height);
  }

  //Plot all vars along x axis.
  void plot( int r, int g, int b) 
  {
    int current_pos = x_start + x_max;

    //Plot axes
    stroke(0, 150, 150);
    //X-axis
    line(x_start, y_min + graph_max_height, x_start + x_max, y_min + graph_max_height);
    //Y-axis
    line(x_start, y_min + graph_max_height, x_start, y_min);

    for (int i = (value.length - 1); i > 0; i--) 
    {
      stroke(r, g, b);
      line(current_pos, y_min + (graph_max_height - value[i]), current_pos - 1, y_min + (graph_max_height - value[i - 1]));
      current_pos --;
    }
  }

  void map_graph(int min_val, int max_val) 
  {

    max_sensor_val = max_val;
    min_sensor_val = min_val;
  }
}

// text to be displayed
void graphs(){
    fill(200);
    font = createFont("Calibri", 20);
    textFont(font);

    text("By: Callum Owen-Bridge and Keiran Brown", 10, 20);
    
    text("Temperature"+ " : " + values[1] + "°C", 100, 40);
    text("Temp (°C)" + "  40", 10, 60);
    text("  30", 90, 140);
    
    text("EMG"+ " : " + values[2], 100, 190);
    text("Intensity" + " 500", 10, 210);
    text(" 0", 90, 290);
    
    text("ECG"+ " : " + values[3], 100, 330);
    text("Voltage   " + "  10", 10, 350);
    text(" 0", 90, 430);
    
    text("Air Flow"+ " : " + values[4], 100, 460);
    text("Vol/s " + "1000", 10, 480);
    text(" 0", 90, 560);
    
    text("Skin Conductance"+ " : " + values[5], 100, 580);
    text("Conductance(S)", 10, 600);
    text(" 0", 90, 680);
    
    text("Skin Resistance"+ " : " + values[6], 500, 40);
    text("Ω   " + "  1000000", 410, 60);
    text(" 0", 500, 140);
    
    text("Skin Conductance Voltage"+ " : " + values[7], 500, 190);
    text("Volts " + " ", 450, 210);
    text(" 0", 500, 290);
    
    text("BPM (Beats per Minute)"+ " : " + values[8], 500, 330);
    text("Beats " + " 200", 410, 350);
    text(" 0", 500, 430);
    
    text("Oxygen Saturation"+ " : " + values[9], 500, 460);
    text("  % " + "       100", 410, 480);
    text(" 0", 500, 560);
  
    text(" X-axis is time in milli seconds ", 500, 600);
    text(" Press any keyboard key to save data ", 500, 640);
}

// code which saves stored data in text file when a keyboard key is pressed 
void keyPressed() {
  
  // allows user to enter the user's details 
  /*String date_name= JOptionPane.showInputDialog("Enter date time name");
  String[] user= split(date_name, ' ');
  saveStrings(file_name, user);*/
  
  output.flush();  // Writes the remaining data to the file
  output.close();  // Finishes the file
  exit();  // Stops the program
}