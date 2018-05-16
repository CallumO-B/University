#include <PinChangeInt.h>
#include <eHealth.h>
#include <Wire.h>
#include <SPI.h>
#include <SD.h>
#include "RTClib.h"

#define ECHO_TO_SERIAL   1 // echo data to serial port
#define WAIT_TO_START    0 // Wait for serial input in setup()

RTC_DS1307 RTC; // define the Real Time Clock object
const int chipSelect = 10;// for the data logging shield, we use digital pin 10 for the SD cs line
File logfile;// the logging file
String output, patient;
int i = 0, logData = 1;
char filename[] = "DATA01.csv";

void setup() 
{
    eHealth.initPulsioximeter();
    PCintPort::attachInterrupt(6, readPulsioximeter, RISING);
  
    Serial.begin(115200);
    pinMode(10, OUTPUT);
    
    // see if the card is present and can be initialized:
    if (!SD.begin(chipSelect)) 
    {
      error("Card failed, or not present");
      return;
    }
  
    if (SD.exists(filename))
    {
      char patient[] = "1001|1957/04/11";
      logfile = SD.open(filename); 
      String line = logfile.readStringUntil('\n');  
      char match[16];
      line.toCharArray(match,16);
      for(int i=0; i<line.length(); i++)
      {
        if (!match[i] == patient[i])
        {
          error("Patient Data Match Failed");
        }
      }
      Serial.println("Patient Data Matched");
    }
    else 
    {
      error("couldnt open file");
    }


  Wire.begin();  
  if (!RTC.begin()) 
  {
   error("RTC failed");
  }

  if (! RTC.begin()) {
    Serial.println("Couldn't find RTC");
    while (1);
  }

  if (! RTC.isrunning()) {
    Serial.println("RTC is NOT running!");
     RTC.adjust(DateTime(F(__DATE__), F(__TIME__)));
  }
  
  logfile.close();
}

void loop()
{ 
   DateTime now = RTC.now();
   if (logData == 1 && now.second()==00) 
   { 
    logfile=SD.open(filename,FILE_WRITE);  
    logfile.print(now.year(), DEC);
    logfile.print("-");
    if(now.month() < 10)
    {
      logfile.print("0" + String(now.month()));
    }
    else
    {
      logfile.print(now.month(), DEC);
    }
    logfile.print("-");
    if(now.day() < 10)
    {
      logfile.print("0" + String(now.day()));
    }
    else
    {
      logfile.print(now.day(), DEC);
    }
    logfile.print(",");
    if(now.hour() < 10)
    {
      logfile.print("0" + String(now.hour()));
    }
    else
    {
      logfile.print(now.hour(), DEC);
    }
    if(now.minute() < 10)
    {
      logfile.print("0" + String(now.minute()));
    }
    else
    {
      logfile.print(now.minute(), DEC);
    }
  #if ECHO_TO_SERIAL
    Serial.print(now.year(), DEC);
    Serial.print("-");
    Serial.print(now.month(), DEC);
    Serial.print("-");
    Serial.print("0" + String(now.day()));
    Serial.print(",");
    if(now.hour() < 10)
    {
      Serial.print("0" + String(now.hour()));
    }
    else
    {
      Serial.print(now.hour(), DEC);
    }
    Serial.print(":");
    if(now.minute() < 10)
    {
      Serial.print("0" + String(now.minute()));
    }
    else
    {
      Serial.print(now.minute(), DEC);
    }
  #endif //ECHO_TO_SERIAL
    delay(1000); //One data per second  
    output += ',';
    output += String(eHealth.getTemperature());
    delay(5);  
    output += ',';
    output += String(eHealth.getEMG());
    delay(5);  
    output += ',';
    output += String(eHealth.getECG());  
    delay(5);  
    output += ',';
    output += String(eHealth.getAirFlow());
    delay(5);  
    output += ',';
    output += String(eHealth.getSkinConductance());
    delay(5);
    output += ',';
    output += String(eHealth.getSkinResistance());
    delay(5);  
    output += ',';
    output += String(eHealth.getSkinConductanceVoltage());
    delay(5);  
    output += ',';
    output += String(eHealth.getBPM());
    delay(5);
    output += ',';
    output += String(eHealth.getOxygenSaturation() + 90);
    delay(5);
      
    logfile.println(output);
    Serial.println(output);
    logfile.close();
    Serial.flush();
    output ="";
  }
}

void readPulsioximeter() 
{
  i ++;
  if (i == 50) 
  {
    eHealth.readPulsioximeter();
    i = 0;
  }
}

void error(char *str)
{
  Serial.print('error: ' + str);
  while(1);
}

void serialEvent() 
{
  while (Serial.available())
  {
    if(Serial.read() == '1')
    {
      delay(2000);
      logData = 0;
      logfile.close();
      logfile= SD.open(filename);
      patient = logfile.readStringUntil('\n');    
      while (logfile.available()) 
      {
        String line = logfile.readStringUntil('\n');
        Serial.println(line);
      }
      logfile.close();
      break;
    }
    
    if(Serial.read() == '2') // 22 is required for this if to become true
    {
      delay(2000);
      SD.remove("DATA01.csv");
      logfile = SD.open("DATA01.csv", FILE_WRITE);
      logfile.println(patient);
      Serial.println(patient);
      logfile.close();
      patient = "";
      logData = 1;
      break;
    }
  }
}
