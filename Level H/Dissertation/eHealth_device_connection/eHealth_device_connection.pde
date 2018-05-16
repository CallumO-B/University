import processing.serial.*; //import the Serial library
import javax.swing.JOptionPane;
PrintWriter output; // creating variable to write data to a file
Serial ehealthPort; // assisgning the name my port to serial port 
String val, file_name, serial_input;
PImage img;
boolean firstContact = false;

int rectX, rectY, rectX_2, rectY_2, rectX_3, rectY_3;
int rectSize = 90;     // Diameter of rect
color rectColor, rectColor_2, rectColor_3, rectHighlight;
boolean rectOver = false, rectOver_2= false, rectOver_3= false;

void setup() {
  size(850, 500); 
  img = loadImage("hope_logo.jpg"); 
  img.resize(850, 500); 
  background(img);

  file_name= JOptionPane.showInputDialog("Please type name for the file to be stored in");
  file_name = file_name + ".csv"; // adds file type to name entered
  output = createWriter( file_name ); // writes to text file

  ehealthPort = new Serial(this, Serial.list()[0], 115200);
  ehealthPort.bufferUntil('\n'); 

  rectColor = color(0, 200, 50);
  rectColor_2 = color(50, 0, 200);
  rectColor_3 = color(200, 0, 50);
  rectHighlight = color(150, 0, 150);
  rectX = 50;
  rectY = 70;
  rectX_2 = 50;
  rectY_2 = 200;
  rectX_3 = 50;
  rectY_3 = 330;

  textSize(20);
  text("1)    Click this button to receive data", 190, 120); 
  text("2)    Click this button to close the file", 190, 250); 
  text("3)    Click this button to restart device and delete file on SD card", 190, 380); 
  fill(0, 102, 153);
}


void draw() 
{

  ///BUTTONS
  update(mouseX, mouseY);

  if (rectOver) 
  {
    fill(rectHighlight);
  } else
  {
    fill(rectColor);
  }
  stroke(255);
  rect(rectX, rectY, rectSize, rectSize);

  if (rectOver_2) 
  {
    fill(rectHighlight);
  } else
  {
    fill(rectColor_2);
  }
  stroke(255);
  rect(rectX_2, rectY_2, rectSize, rectSize);
  
  if (rectOver_3) 
  {
    fill(rectHighlight);
  } else
  {
    fill(rectColor_3);
  }
  stroke(255);
  rect(rectX_3, rectY_3, rectSize, rectSize);
}


void serialEvent( Serial ehealthPort) 
{
  val = ehealthPort.readStringUntil('\n');
  if (val != null) 
  {
    val = trim(val);
    println(val);
    output.println(val);
  }
}

void update(int x, int y) 
{
  if ( overRect(rectX, rectY, rectSize) )
  {
    rectOver = true;
    rectOver_2 = false;
    rectOver_3 = false;
  } 
  else if ( overRect_2(rectX_2, rectY_2, rectSize) )
  {
    rectOver = false;
    rectOver_3 = false;
    rectOver_2 = true;
  } 
  else if ( overRect_3(rectX_3, rectY_3, rectSize) )
  {
    rectOver = false;
    rectOver_2 = false;
    rectOver_3 = true;
  } 
  else
  {
    rectOver_3 = rectOver_2 = rectOver = false;
  }
}


// code which saves stored data in text file when a keyboard key is pressed 
void keyPressed() {
}

void mousePressed() 
{
  if (rectOver)
  {
    ehealthPort.write('1');
    println("Sending data, Restart device to keep file");
  }

  if (rectOver_2)
  {
    output.flush();  // Writes the remaining data to the file
    output.close();  // Finishes the file  
    println("Closing File: " + file_name);
  }

  if (rectOver_3)
  {
    ehealthPort.write("22");
    println("Removing file and restarting");
  }
}

boolean overRect(int x, int y, int height) 
{
  if (mouseX >= x && mouseX <= x+width && mouseY >= y && mouseY <= y+height) 
  {
    return true;
  } else
  {
    return false;
  }
}

boolean overRect_2(int x, int y, int height) 
{
  if (mouseX >= x && mouseX <= x+width && mouseY >= y && mouseY <= y+height) 
  {
    return true;
  } else 
  {
    return false;
  }
}

boolean overRect_3(int x, int y, int height) 
{
  if (mouseX >= x && mouseX <= x+width && mouseY >= y && mouseY <= y+height) 
  {
    return true;
  } else 
  {
    return false;
  }
}