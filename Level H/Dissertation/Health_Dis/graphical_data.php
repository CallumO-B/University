<?php

session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username']))
{
    header("location: login_form.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "Root#123", "health_database");

if (!$conn)
{
    die("Connection Failed: " . mysqli_connect_error());
}

if(isset($_POST) && 0 === count($_POST))
{
    echo ("<h1>check box was not selected</h1><p><h2>please go back and try again</h2></p>");
}

$logid = $_POST["logID"];


$get_monitorData = "SELECT * FROM monitor_data WHERE logID = $logid";// use log selected by user
$monitor_data = mysqli_query($conn, $get_monitorData) or die(mysqli_error());
$rows = mysqli_num_rows($monitor_data);

$temp = array();
$time = array();
$emg = array();
$ecg = array();
$airFlow = array();
$skinConductance = array();
$skinResistance = array();
$skinConductanceVoltage = array();
$beatsPerMinute = array();
$bloodOxygen = array();

while($array = mysqli_fetch_array($monitor_data))
{   
    $temp[] = $array['temperature'];
    $time[] = $array['timeValue'];
    $emg[] = $array['ecg'];
    $ecg[] = $array['emg'];
    $airFlow[] = $array['airFlow'];
    $skinConductance[] = $array['skinConductance'];
    $skinResistance[] = $array['skinResistance'];
    $skinConductanceVoltage[] = $array['skinConductanceVoltage'];
    $beatsPerMinute[] = $array['beatsPerMinute'];
    $bloodOxygen[] = $array['bloodOxygen'];
}

mysqli_free_result($monitor_data);
mysqli_close($conn);

?>



<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <title>Graphical Data</title>

    <link rel="stylesheet" href="button_form_CSS.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css"> 
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>

    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }

        #myChart {
        height:100%;
        width:100%;
        min-height:300px;
        }

    </style>

<script>


    var temp = [];
    var ecg = [];
    var emg = [];
    var airFlow = [];
    var skinConductance = [];
    var skinResistance = [];
    var skinConductanceVoltage = [];
    var beatsPerMinute = [];
    var bloodOxygen = [];
    var time = [];


    <?php 
    for ($i=0 ; $i<$rows ; $i++) 
    { 
        echo "temp[$i] = $temp[$i];";
        echo "emg[$i] = $emg[$i];";
        echo "ecg[$i] = $ecg[$i];";
        echo "airFlow[$i] = $airFlow[$i];";
        echo "skinConductance[$i] = $skinConductance[$i];";
        echo "skinResistance[$i] = $skinResistance[$i];";
        echo "skinConductanceVoltage[$i] = $skinConductanceVoltage[$i];";
        echo "bloodOxygen[$i] = $bloodOxygen[$i];";
        echo "beatsPerMinute[$i] = $beatsPerMinute[$i];"; 
        echo "time[$i] = $time[$i];"; 
    } 
    ?>

    var myChart1 = 
    {
        "graphset":[
            {
            "background-color":"#ffffff",
            "type":"line",
            "title": {
              "text": ""
            },
            "legend":{
                "toggle-action":"remove",
                "align":"center",
                "adjust-layout":false,
                "borderWidth":0,
                "verticalAlign":"bottom",
                "fontColor":"#7d7d7d",
                "font-size":10,
                "marginRight":20,
                "marginBottom":0,
                "marginTop":0,
                "marker":{
                    "type":"square"
                },
            },
            "preview":{
                "background-color":"#F5F7F3",
                "border-width":0,
                "height":30,
                "preserve-zoom":false,
                "mask":{
                    "backgroundColor":"grey",
                    "alpha":0.8
                },
                "handle":{
                    "border-width":2
                },
                "y":"85%"
            },
            "scale-x":{
                "zooming":true,
                "zoom-to":[0,30],
                "item":{
                    "font-size":10,
                    "font-color":"#7d7d7d"
                },
                "tick":{
                    "visible":true
                },
                "labels": time,
                    "label":{
                    "text":"Time (HH:MM)",
                    "font-size":"10px",
                    "color":"grey"
                },
            },
            "scale-y":{
                "zooming":false,
                "values":"0:50:5",
                "guide":{
                    "line-style":"dotted"
                },
                "item":{
                    "font-size":10,
                    "font-color":"#7d7d7d"
                },
                "tick":{
                    "visible":true
                },
                "format":"",
                "decimals":1
            },
            "zoom":{
                "active":true,
                "preserve-zoom":true
            },
            "plotarea":{
                "margin-top":"20",
                "margin-left":"20",
                "margin":"dynamic 50 105 dynamic"
            },
            "plot":{
                "data-append-selection":true,
                "mode":"normal",
                "line-width":1,
                "line-color":"#FF5733",
                "background-color":"#1e88e5",
                "marker":{
                    "size":3,
                    "background-color":"#FF5733",
                    "border-width":2,
                    "border-color":"#FF5733"
                },
                "tooltip":{
                    "visible":true,
                    "text":"%kv<br>%vv"
                },
                "selection-mode":"multiple",
                "selected-state":{
                    "background-color":"#ffa726",
                    "border-width":0
                }
            },
            "series":[
                {
                    "values":temp,
                    "text":"Temperature (°C)"
                }
            ]
        }
       ]
    };

    var myChart2 = {
        "graphset":[
            {
            "background-color":"#ffffff",
            "type":"line",
            "title": {
              "text": ""
            },
            "legend":{
                "toggle-action":"remove",
                "align":"center",
                "adjust-layout":false,
                "borderWidth":0,
                "verticalAlign":"bottom",
                "fontColor":"#7d7d7d",
                "font-size":10,
                "marginRight":20,
                "marginBottom":0,
                "marginTop":0,
                "marker":{
                    "type":"square"
                },
            },
            "preview":{
                "background-color":"#F5F7F3",
                "border-width":0,
                "height":30,
                "preserve-zoom":false,
                "mask":{
                    "backgroundColor":"grey",
                    "alpha":0.8
                },
                "handle":{
                    "border-width":2
                },
                "y":"85%"
            },
            "scale-x":{
                "zooming":true,
                "zoom-to":[0,30],
                "item":{
                    "font-size":10,
                    "font-color":"#7d7d7d"
                },
                "tick":{
                    "visible":true
                },
                "labels": time,
                    "label":{
                    "text":"Time (HH:MM)",
                    "font-size":"10px",
                    "color":"grey"
                },
            },
            "scale-y":{
                "zooming":false,
                "values":"0:1000:10",
                "guide":{
                    "line-style":"dotted"
                },
                "item":{
                    "font-size":10,
                    "font-color":"#7d7d7d"
                },
                "tick":{
                    "visible":true
                },
                "format":"",
                "decimals":1
            },
            "zoom":{
                "active":true,
                "preserve-zoom":true
            },
            "plotarea":{
                "margin-top":"20",
                "margin-left":"20",
                "margin":"dynamic 50 105 dynamic"
            },
            "plot":{
                "data-append-selection":true,
                "mode":"normal",
                "line-width":1,
                "line-color":"#FFAF33",
                "background-color":"#1e88e5",
                "marker":{
                    "size":3,
                    "background-color":"#FFAF33",
                    "border-width":2,
                    "border-color":"#FFAF33"
                },
                "tooltip":{
                    "visible":true,
                    "text":"%kv<br>%vv"
                },
                "selection-mode":"multiple",
                "selected-state":{
                    "background-color":"#ffa726",
                    "border-width":0
                }
            },
            "series":[
                {
                    "values":ecg,
                    "text":"ECG"
                }
            ]
        }
        ]
    };

    var myChart3 = {
        "graphset":[
            {
            "background-color":"#ffffff",
            "type":"line",
            "title": {
              "text": ""
            },
            "legend":{
                "toggle-action":"remove",
                "align":"center",
                "adjust-layout":false,
                "borderWidth":0,
                "verticalAlign":"bottom",
                "fontColor":"#7d7d7d",
                "font-size":10,
                "marginRight":20,
                "marginBottom":0,
                "marginTop":0,
                "marker":{
                    "type":"square"
                },
            },
            "preview":{
                "background-color":"#F5F7F3",
                "border-width":0,
                "height":30,
                "preserve-zoom":false,
                "mask":{
                    "backgroundColor":"grey",
                    "alpha":0.8
                },
                "handle":{
                    "border-width":2
                },
                "y":"85%"
            },
            "scale-x":{
                "zooming":true,
                "zoom-to":[0,30],
                "item":{
                    "font-size":10,
                    "font-color":"#7d7d7d"
                },
                "tick":{
                    "visible":true
                },
                "labels": time,
                    "label":{
                    "text":"Time (HH:MM)",
                    "font-size":"10px",
                    "color":"grey"
                },
            },
            "scale-y":{
                "zooming":false,
                "values":"0:1000:10",
                "guide":{
                    "line-style":"dotted"
                },
                "item":{
                    "font-size":10,
                    "font-color":"#7d7d7d"
                },
                "tick":{
                    "visible":true
                },
                "format":"",
                "decimals":1
            },
            "zoom":{
                "active":true,
                "preserve-zoom":true
            },
            "plotarea":{
                "margin-top":"20",
                "margin-left":"20",
                "margin":"dynamic 50 105 dynamic"
            },
            "plot":{
                "data-append-selection":true,
                "mode":"normal",
                "line-width":1,
                "line-color":"#33B0FF",
                "background-color":"#1e88e5",
                "marker":{
                    "size":3,
                    "background-color":"#33B0FF",
                    "border-width":2,
                    "border-color":"#33B0FF"
                },
                "tooltip":{
                    "visible":true,
                    "text":"%kv<br>%vv"
                },
                "selection-mode":"multiple",
                "selected-state":{
                    "background-color":"#ffa726",
                    "border-width":0
                }
            },
            "series":[
                {
                    "values":emg,
                    "text":"EMG"
                }
            ]
        }
        ]
    };

    var myChart4 = {
    "graphset":[
            {
            "background-color":"#ffffff",
            "type":"line",
            "title": {
              "text": ""
            },
            "legend":{
                "toggle-action":"remove",
                "align":"center",
                "adjust-layout":false,
                "borderWidth":0,
                "verticalAlign":"bottom",
                "fontColor":"#7d7d7d",
                "font-size":10,
                "marginRight":20,
                "marginBottom":0,
                "marginTop":0,
                "marker":{
                    "type":"square"
                },
            },
            "preview":{
                "background-color":"#F5F7F3",
                "border-width":0,
                "height":30,
                "preserve-zoom":false,
                "mask":{
                    "backgroundColor":"grey",
                    "alpha":0.8
                },
                "handle":{
                    "border-width":2
                },
                "y":"85%"
            },
            "scale-x":{
                "zooming":true,
                "zoom-to":[0,30],
                "item":{
                    "font-size":10,
                    "font-color":"#7d7d7d"
                },
                "tick":{
                    "visible":true
                },
                "labels": time,
                    "label":{
                    "text":"Time (HH:MM)",
                    "font-size":"10px",
                    "color":"grey"
                },
            },
            "scale-y":{
                "zooming":false,
                "values":"-0:1000:10",
                "guide":{
                    "line-style":"dotted"
                },
                "item":{
                    "font-size":10,
                    "font-color":"#7d7d7d"
                },
                "tick":{
                    "visible":true
                },
                "format":"",
                "decimals":1
            },
            "zoom":{
                "active":true,
                "preserve-zoom":true
            },
            "plotarea":{
                "margin-top":"20",
                "margin-left":"20",
                "margin":"dynamic 50 105 dynamic"
            },
            "plot":{
                "data-append-selection":true,
                "mode":"normal",
                "line-width":1,
                "line-color":"#5433FF",
                "background-color":"#1e88e5",
                "marker":{
                    "size":3,
                    "background-color":"#5433FF",
                    "border-width":2,
                    "border-color":"#5433FF"
                },
                "tooltip":{
                    "visible":true,
                    "text":"%kv<br>%vv"
                },
                "selection-mode":"multiple",
                "selected-state":{
                    "background-color":"#ffa726",
                    "border-width":0
                }
            },
            "series":[
                {
                    "values":airFlow,
                    "text":"Air Flow"
                }
            ]
        }
        ]
    };

    var myChart5 = {
        "graphset":[
            {
            "background-color":"#ffffff",
            "type":"line",
            "title": {
              "text": ""
            },
            "legend":{
                "toggle-action":"remove",
                "align":"center",
                "adjust-layout":false,
                "borderWidth":0,
                "verticalAlign":"bottom",
                "fontColor":"#7d7d7d",
                "font-size":10,
                "marginRight":20,
                "marginBottom":0,
                "marginTop":0,
                "marker":{
                    "type":"square"
                },
            },
            "preview":{
                "background-color":"#F5F7F3",
                "border-width":0,
                "height":30,
                "preserve-zoom":false,
                "mask":{
                    "backgroundColor":"grey",
                    "alpha":0.8
                },
                "handle":{
                    "border-width":2
                },
                "y":"85%"
            },
            "scale-x":{
                "zooming":true,
                "zoom-to":[0,30],
                "item":{
                    "font-size":10,
                    "font-color":"#7d7d7d"
                },
                "tick":{
                    "visible":true
                },
                "labels": time,
                    "label":{
                    "text":"Time (HH:MM)",
                    "font-size":"10px",
                    "color":"grey"
                },
            },
            "scale-y":{
                "zooming":false,
                "values":"0:5000000:10",
                "guide":{
                    "line-style":"dotted"
                },
                "item":{
                    "font-size":10,
                    "font-color":"#7d7d7d"
                },
                "tick":{
                    "visible":true
                },
                "format":"",
                "decimals":1
            },
            "zoom":{
                "active":true,
                "preserve-zoom":true
            },
            "plotarea":{
                "margin-top":"20",
                "margin-left":"20",
                "margin":"dynamic 50 105 dynamic"
            },
            "plot":{
                "data-append-selection":true,
                "mode":"normal",
                "line-width":1,
                "line-color":"#EB2E2E",
                "background-color":"#1e88e5",
                "marker":{
                    "size":3,
                    "background-color":"#EB2E2E",
                    "border-width":2,
                    "border-color":"#EB2E2E"
                },
                "tooltip":{
                    "visible":true,
                    "text":"%kv<br>%vv"
                },
                "selection-mode":"multiple",
                "selected-state":{
                    "background-color":"#ffa726",
                    "border-width":0
                }
            },
            "series":[
                {
                    "values":skinConductance,
                    "text":"Skin Conductance"
                }
            ]
        }
        ]
    };

    var myChart6 = {
        "graphset":[
            {
            "background-color":"#ffffff",
            "type":"line",
            "title": {
              "text": ""
            },
            "legend":{
                "toggle-action":"remove",
                "align":"center",
                "adjust-layout":false,
                "borderWidth":0,
                "verticalAlign":"bottom",
                "fontColor":"#7d7d7d",
                "font-size":10,
                "marginRight":20,
                "marginBottom":0,
                "marginTop":0,
                "marker":{
                    "type":"square"
                },
            },
            "preview":{
                "background-color":"#F5F7F3",
                "border-width":0,
                "height":30,
                "preserve-zoom":false,
                "mask":{
                    "backgroundColor":"grey",
                    "alpha":0.8
                },
                "handle":{
                    "border-width":2
                },
                "y":"85%"
            },
            "scale-x":{
                "zooming":true,
                "zoom-to":[0,30],
                "item":{
                    "font-size":10,
                    "font-color":"#7d7d7d"
                },
                "tick":{
                    "visible":true
                },
                "labels": time,
                    "label":{
                    "text":"Time (HH:MM)",
                    "font-size":"10px",
                    "color":"grey"
                },
            },
            "scale-y":{
                "zooming":false,
                "values":"0:5000000:10",
                "guide":{
                    "line-style":"dotted"
                },
                "item":{
                    "font-size":10,
                    "font-color":"#7d7d7d"
                },
                "tick":{
                    "visible":true
                },
                "format":"",
                "decimals":1
            },
            "zoom":{
                "active":true,
                "preserve-zoom":true
            },
            "plotarea":{
                "margin-top":"20",
                "margin-left":"20",
                "margin":"dynamic 50 105 dynamic"
            },
            "plot":{
                "data-append-selection":true,
                "mode":"normal",
                "line-width":1,
                "line-color":"#4d9900",
                "background-color":"#1e88e5",
                "marker":{
                    "size":3,
                    "background-color":"#4d9900",
                    "border-width":1,
                    "border-color":"#4d9900"
                },
                "tooltip":{
                    "visible":true,
                    "text":"%kv<br>%vv"
                },
                "selection-mode":"multiple",
                "selected-state":{
                    "background-color":"#ffa726",
                    "border-width":0
                }
            },
            "series":[
                {
                    "values":skinResistance,
                    "text":"Skin Resistance (ohm)"
                }
            ]
        }
        ]
    };

    var myChart7 = {
        "graphset":[
            {
            "background-color":"#ffffff",
            "type":"line",
            "title": {
              "text": ""
            },
            "legend":{
                "toggle-action":"remove",
                "align":"center",
                "adjust-layout":false,
                "borderWidth":0,
                "verticalAlign":"bottom",
                "fontColor":"#7d7d7d",
                "font-size":10,
                "marginRight":20,
                "marginBottom":0,
                "marginTop":0,
                "marker":{
                    "type":"square"
                },
            },
            "preview":{
                "background-color":"#F5F7F3",
                "border-width":0,
                "height":30,
                "preserve-zoom":false,
                "mask":{
                    "backgroundColor":"grey",
                    "alpha":0.8
                },
                "handle":{
                    "border-width":2
                },
                "y":"85%"
            },
            "scale-x":{
                "zooming":true,
                "zoom-to":[0,30],
                "item":{
                    "font-size":10,
                    "font-color":"#7d7d7d"
                },
                "tick":{
                    "visible":true
                },
                "labels": time,
                    "label":{
                    "text":"Time (HH:MM)",
                    "font-size":"10px",
                    "color":"grey"
                },
            },
            "scale-y":{
                "zooming":false,
                "values":"0:5000000:10",
                "guide":{
                    "line-style":"dotted"
                },
                "item":{
                    "font-size":10,
                    "font-color":"#7d7d7d"
                },
                "tick":{
                    "visible":true
                },
                "format":"",
                "decimals":1
            },
            "zoom":{
                "active":true,
                "preserve-zoom":true
            },
            "plotarea":{
                "margin-top":"20",
                "margin-left":"20",
                "margin":"dynamic 50 105 dynamic"
            },
            "plot":{
                "data-append-selection":true,
                "mode":"normal",
                "line-width":1,
                "line-color":"#3DDA33",
                "background-color":"#1e88e5",
                "marker":{
                    "size":3,
                    "background-color":"#3DDA33",
                    "border-width":2,
                    "border-color":"#3DDA33"
                },
                "tooltip":{
                    "visible":true,
                    "text":"%kv<br>%vv"
                },
                "selection-mode":"multiple",
                "selected-state":{
                    "background-color":"#ffa726",
                    "border-width":0
                }
            },
            "series":[
                {
                    "values":skinConductanceVoltage,
                    "text":"SKin Conductance Voltage (V)"
                }
            ]
        }
        ]
    };

    var myChart8 = {
    "graphset":[
            {
            "background-color":"#ffffff",
            "type":"line",
            "title": {
              "text": ""
            },
            "legend":{
                "toggle-action":"remove",
                "align":"center",
                "adjust-layout":false,
                "borderWidth":0,
                "verticalAlign":"bottom",
                "fontColor":"#7d7d7d",
                "font-size":10,
                "marginRight":20,
                "marginBottom":0,
                "marginTop":0,
                "marker":{
                    "type":"square"
                },
            },
            "preview":{
                "background-color":"#F5F7F3",
                "border-width":0,
                "height":30,
                "preserve-zoom":false,
                "mask":{
                    "backgroundColor":"grey",
                    "alpha":0.8
                },
                "handle":{
                    "border-width":2
                },
                "y":"85%"
            },
            "scale-x":{
                "zooming":true,
                "zoom-to":[0,30],
                "item":{
                    "font-size":10,
                    "font-color":"#7d7d7d"
                },
                "tick":{
                    "visible":true
                },
                "labels": time,
                    "label":{
                    "text":"Time (HH:MM)",
                    "font-size":"10px",
                    "color":"grey"
                },
            },
            "scale-y":{
                "zooming":false,
                "values":"0:230:10",
                "guide":{
                    "line-style":"dotted"
                },
                "item":{
                    "font-size":10,
                    "font-color":"#7d7d7d"
                },
                "tick":{
                    "visible":true
                },
                "format":"",
                "decimals":1
            },
            "zoom":{
                "active":true,
                "preserve-zoom":true
            },
            "plotarea":{
                "margin-top":"20",
                "margin-left":"20",
                "margin":"dynamic 50 105 dynamic"
            },
            "plot":{
                "data-append-selection":true,
                "mode":"normal",
                "line-width":1,
                "line-color":"#E1DE2B",
                "background-color":"#1e88e5",
                "marker":{
                    "size":3,
                    "background-color":"#E1DE2B",
                    "border-width":2,
                    "border-color":"#E1DE2B"
                },
                "tooltip":{
                    "visible":true,
                    "text":"%kv<br>%vv"
                },
                "selection-mode":"multiple",
                "selected-state":{
                    "background-color":"#ffa726",
                    "border-width":0
                }
            },
            "series":[
                {
                    "values":beatsPerMinute,
                    "text":"Beats Per Minute"
                }
            ]
        }
        ]
    };

    var myChart9 = {
        "graphset":[
            {
            "background-color":"#ffffff",
            "type":"line",
            "title": {
              "text": ""
            },
            "legend":{
                "toggle-action":"remove",
                "align":"center",
                "adjust-layout":false,
                "borderWidth":0,
                "verticalAlign":"bottom",
                "fontColor":"#7d7d7d",
                "font-size":10,
                "marginRight":20,
                "marginBottom":0,
                "marginTop":0,
                "marker":{
                    "type":"square"
                },
            },
            "preview":{
                "background-color":"#F5F7F3",
                "border-width":0,
                "height":30,
                "preserve-zoom":false,
                "mask":{
                    "backgroundColor":"grey",
                    "alpha":0.8
                },
                "handle":{
                    "border-width":2
                },
                "y":"85%"
            },
            "scale-x":{
                "zooming":true,
                "zoom-to":[0,30],
                "item":{
                    "font-size":10,
                    "font-color":"#7d7d7d"
                },
                "tick":{
                    "visible":true
                },
                "labels": time,
                    "label":{
                    "text":"Time (HH:MM)",
                    "font-size":"10px",
                    "color":"grey"
                },
            },
            "scale-y":{
                "zooming":false,
                "values":"0:100:10",
                "guide":{
                    "line-style":"dotted"
                },
                "item":{
                    "font-size":10,
                    "font-color":"#7d7d7d"
                },
                "tick":{
                    "visible":true
                },
                "format":"",
                "decimals":1
            },
            "zoom":{
                "active":true,
                "preserve-zoom":true
            },
            "plotarea":{
                "margin-top":"20",
                "margin-left":"20",
                "margin":"dynamic 50 105 dynamic"
            },
            "plot":{
                "data-append-selection":true,
                "mode":"normal",
                "line-width":1,
                "line-color":"#E12B2B",
                "background-color":"#1e88e5",
                "marker":{
                    "size":3,
                    "background-color":"#E12B2B",
                    "border-width":2,
                    "border-color":"#E12B2B"
                },
                "tooltip":{
                    "visible":true,
                    "text":"%kv<br>%vv"
                },
                "selection-mode":"multiple",
                "selected-state":{
                    "background-color":"#ffa726",
                    "border-width":0
                }
            },
            "series":[
                {
                    "values":bloodOxygen,
                    "text":"Blood Oxygen (%)"
                }
            ]
        }
        ]
    };
  

  
window.onload=function(){


  zingchart.render({
    id:'chartDiv1',
    data:myChart1,
    height: 400, 
    width: '100%'
  });


  zingchart.render({
    id:'chartDiv2',
    data:myChart2,
    height: 400, 
    width: '100%'
  });

   zingchart.render({
    id:'chartDiv3',
    data:myChart3,
    height: 400, 
    width: '100%'
  });

  zingchart.render({
    id:'chartDiv4',
    data:myChart4,
    height: 400, 
    width: '100%'
  });

   zingchart.render({
    id:'chartDiv5',
    data:myChart5,
    height: 400, 
    width: '100%'
  });

  zingchart.render({
    id:'chartDiv6',
    data:myChart6,
    height: 400, 
    width: '100%'
  });

   zingchart.render({
    id:'chartDiv7',
    data:myChart7,
    height: 400, 
    width: '100%'
  });

  zingchart.render({
    id:'chartDiv8',
    data:myChart8,
    height: 400, 
    width: '100%'
  });

   zingchart.render({
    id:'chartDiv9',
    data:myChart9,
    height: 400, 
    width: '100%'
});
};
</script>

</head>
    <body>

        <div class="page-header">
            <img src="images/logo.png" alt="logo" width = "200" height = "135">
            <h1><b>Your Data For Log </b> <?php echo $logid; ?> </h1>
            <p>   
                <?php
                    $userPage ="";
                    $find_user = $_SESSION['username'];
                    $username_length = strlen($find_user);
                    
                    $char = str_split($find_user, 1);
                    if ($char[4] == "h")
                    {
                        $userPage="hcp_welcome.php";
                    }
                    elseif ($char[4] == "p")
                    {
                        $userPage="patient_welcome.php";
                    }
                ?>
                <a href="<?php echo $userPage ?>" class="button">Go Back to Welcome Page</a>
            </p>
        </div>
        
        
        <h4><p>
            The links below open a new window. 
        </p>
        
        <b><p>
            These links should NOT be used to replace advice from 
        </p>
            health care professionals, you must consult a doctor if you are concerned.
        </b></h4>                
        <br>
        <a href="https://patient.info" target="_blank" class="button">Patient advice Webpage</a>
        <a href="https://patient.info/symptom-checker" target="_blank" class="button">Patient symptom checker Webpage</a>     
        <noscript>
            <h2>Sorry, javascript is disabled. <br><br>
            Please enable javascript to improve your experince with this webpage.</h2> 
        </noscript>

        <br><br><br><br>
        <b><p>Click and drag an area of the graph to zoom, or use the handles below each graph</p></b>

        <h3>Body Temperature</h3>
        <div id='chartDiv1'><a href="https://www.zingchart.com" target="_blank">Powered by ZingChart</a></div>

        <h3>Electromyography</h3>
        <div id='chartDiv2'><a href="https://www.zingchart.com" target="_blank">Powered by ZingChart</a></div>

        <h3>Electrocardiogram</h3>
        <div id='chartDiv3'><a href="https://www.zingchart.com" target="_blank">Powered by ZingChart</a></div>

        <h3>Air Flow</h3>
        <div id='chartDiv4'><a href="https://www.zingchart.com" target="_blank">Powered by ZingChart</a></div>

        <h3>Skin Conductance</h3>
        <div id='chartDiv5'><a href="https://www.zingchart.com" target="_blank">Powered by ZingChart</a></div>

        <h3>Skin Resistance</h3>
        <div id='chartDiv6'><a href="https://www.zingchart.com" target="_blank">Powered by ZingChart</a></div>

        <h3>Skin Conductance Voltage</h3>
        <div id='chartDiv7'><a href="https://www.zingchart.com" target="_blank">Powered by ZingChart</a>></div>

        <h3>Beats Per Minute</h3>
        <div id='chartDiv8'><a href="https://www.zingchart.com" target="_blank">Powered by ZingChart</a></div>

        <h3>Blood Oxygen</h3>
       <div id='chartDiv9'><a href="https://www.zingchart.com" target="_blank">Powered by ZingChart</a></div>

    </body>
</html>