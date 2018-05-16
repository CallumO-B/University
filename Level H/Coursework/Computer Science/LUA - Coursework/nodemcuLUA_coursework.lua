wifi.setmode(wifi.STATIONAP)
config = {}
config.ssid = "Node"
config.pwd = "12345678"
wifi.ap.config(config)

config_ip = {}
config_ip.ip = "192.168.2.1"
config_ip.netmask = "255.255.255.0"
config_ip.gateway = "192.168.2.1"
wifi.ap.setip(config_ip)

ssid = "insert wifi ssid(network name) here"
password = "insert password here"
wifi.sta.config(ssid, password)

-- Connect to the wifi network using wifi module

function wifi_connection_loop()
  if wifi.sta.status() == 5 then  --STA_GOTIP
    print("NodeMCU IP "..wifi.sta.getip())
    read_dht()
    tmr.stop(1) --Exit loop
  else
    print("Trying to connect to..." ..ssid)
  end
end

tmr.alarm(1,500,tmr.ALARM_AUTO,function() wifi_connection_loop() end)

print("Setting Globel Varibales")

temperature = ""
humidity = ""

red_pin = 6
green_pin = 7
blue_pin = 8
dht_pin = 2

-- Read out DHT22 sensor using dht module
function read_dht()
  status, temp, humi, temp_dec, humi_dec = dht.read(dht_pin)
  
  if( status == dht.OK ) then
    print("DHT Temperature: "..math.floor(temp).."."..temp_dec.." C")
    print("DHT Humidity: "..math.floor(humi).."."..humi_dec.." %")
    temperature = math.floor(temp).."."..temp_dec
    humidity = math.floor(humi).."."..humi_dec
  elseif( dht_status == dht.ERROR_CHECKSUM ) then          
    print( "DHT Checksum error" )
  elseif( dht_status == dht.ERROR_TIMEOUT ) then
    print( "DHT Time out" )
  end
end

print ("Setting up LED light")
pwm.setup(red_pin, 2, 1023)
pwm.setup(green_pin, 2, 1023)
pwm.setup(blue_pin, 2, 1023)

print("starting Server")


server = net.createServer(net.TCP, 10)
counter=0
srv=net.createServer(net.TCP)

srv:listen(80,function(conn)
  conn:on("receive",function(conn,payload)
  --  print(payload)

    -- to update webpage with new data values
    function update_sensor_values()
        nodeUpdate = string.sub(payload,postparse[2]+1, #payload)
        if nodeUpdate=="Update+Temperature+and+Humidity" then
            print("Updated webpage data")
        end
        if nodeUpdate=="Red+light+on" then
            pwm.start(red_pin)
            print("Red light on")
        end
        if nodeUpdate=="Red+light+off" then
            pwm.stop(red_pin)
            print("Red light off")
        end
        if nodeUpdate=="Green+light+on" then
            pwm.start(green_pin)
            print("Green light on")
        end
        if nodeUpdate=="Green+light+off" then
            pwm.stop(green_pin)
            print("Green light off")
        end
        if nodeUpdate=="Blue+light+on" then
            pwm.start(blue_pin)
            print("Blue light on")
        end
        if nodeUpdate=="Blue+light+off" then
            pwm.stop(blue_pin)
            print("Blue light off")
        end
    end
    --Retrieve sensor data every 10 seconds
    tmr.alarm(1,10000,tmr.ALARM_AUTO,function() read_dht() end)

    --
    postparse={string.find(payload, "nodeUpdate=")}
    if postparse[2]~=nil then 
        update_sensor_values()
    end

    -- create website
    conn:send('HTTP/1.1 200 OK\n\n')
    conn:send('<!DOCTYPE HTML>\n')
    conn:send('<html>\n')
    conn:send('<head><meta  content="text/html; charset=utf-8">\n')
    conn:send('<style type="text/css">\n')
    conn:send('    body \n')
    conn:send('    {\n')
    conn:send('        height: 50%;\n')
    conn:send('        font-family: "Arial";\n')
    conn:send('        margin: 1;\n')
    conn:send('        background: linear-gradient(to bottom, #fcdb88,#d32106);\n')
    conn:send('    }\n')
    conn:send('</style>\n')
    conn:send('  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">')
    conn:send('  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>\n')
    conn:send(' <script type="text/javascript">\n')
    conn:send('   google.charts.load("current", {"packages":["gauge"]});\n')
    conn:send('  google.charts.setOnLoadCallback(drawChart);\n')
    conn:send('  function drawChart() {\n')
    conn:send('  var data = google.visualization.arrayToDataTable([\n')
    conn:send('    ["Label", "Value"],\n')
    conn:send('    ["TemperatureC", 100],\n')
    conn:send('    ["Humidity %", 100],\n')
    conn:send('   ]);\n')
    conn:send('  var options = {\n')
    conn:send('   width: 500, height: 220,\n')
    conn:send('   redFrom: 90, redTo: 100,\n')
    conn:send('   yellowFrom:75, yellowTo: 90,\n')
    conn:send('    minorTicks: 5\n')
    conn:send('  };\n')
    conn:send('  var chart = new google.visualization.Gauge(document.getElementById("chart_div"));\n')
    conn:send('    chart.draw(data, options);\n')
    conn:send('   setInterval(function() {\n')
    conn:send('     data.setValue(0, 1,'..temperature..');\n')
    conn:send('      chart.draw(data, options);\n')
    conn:send('    }, 1000);\n')
    conn:send('    setInterval(function() {\n')
    conn:send('      data.setValue(1, 1,'..humidity..');\n')
    conn:send('      chart.draw(data, options);\n')
    conn:send('    }, 1000);\n')
    conn:send('  }\n') 
    conn:send('   </script>\n')
    conn:send('<title>ESP8266</title></head>\n')
    conn:send('<body bgcolor="#4f74af"><h2>DHT22 sensor and RGB Light </h2>\n')
    conn:send('<div align = "center" id="chart_div" style="width: 500px; height: 320px;"></div>\n')
    
    conn:send('<div align="center">')
    conn:send('<form action="" method="POST">\n')
    conn:send('<input class = "btn" type="submit" name="nodeUpdate" value="Update Temperature and Humidity"><br><br>\n')   
    conn:send('<input class = "btn" type="submit" name="nodeUpdate" value="Red light on">\n')
    conn:send('<input class = "btn" type="submit" name="nodeUpdate" value="Green light on">\n')
    conn:send('<input class = "btn" type="submit" name="nodeUpdate" value="Blue light on"><br><br>\n')
    conn:send('<input class = "btn" type="submit" name="nodeUpdate" value="Red light off">\n')
    conn:send('<input class = "btn" type="submit" name="nodeUpdate" value="Green light off">\n')
    conn:send('<input class = "btn" type="submit" name="nodeUpdate" value="Blue light off">\n')
    conn:send('</form>\n')
conn:send('</div>\n')
    conn:send('</body></html>\n')
    conn:on("sent",function(conn) conn:close() end)
end)
end)
