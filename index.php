<?php
$switch = exec('gpio read 0');

if(isset($_GET['trigger']) && $_GET['trigger'] == 1) {
    error_reporting(E_ALL);
    exec('gpio mode 0 out');
    exec('gpio write 0 1');
    usleep(1000000);
    exec('gpio write 0 0');
    # an accidental page refresh causes the garage door to open
    # the following two lines must be before any HTML to prevent
    # accidental door openings
    header('Location: /index.php');
    die();
}
?>
<html>
<head>
	<link rel="icon" href="garage.png">
	<link rel="apple-touch-icon" sizes="128x128" href="garage.png">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<style>
    body {
        position: absolute;


    }
    footer {
        position:absolute;
    }
    .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }
</style>
<header class="w3-top">
    <div id="serverData"><button class="w3-button w3-block w3-black">Reed switch state displayed here</button></div>
<script type="text/javascript">
    //functions here
    //check for browser support
    if(typeof(EventSource)!=="undefined") {
        //create an object, passing it the name and location of the server side script
        var eSource = new EventSource("send_door_status.php");
        //detect message receipt
        eSource.onmessage = function(event) {
            //write the received data to the page
            document.getElementById("serverData").innerHTML = event.data;
        };
    }
    else {
        document.getElementById("serverData").innerHTML="Whoops! Your browser doesn't receive server-sent events.";
    }
</script>
</header>


<body>
<br>
<br>
<!--Replace RaspiIP with your IP-->
<img class="center" style="-webkit-user-select: none; width:100%;" src="http://192.168.178.50:8081/">

</body>
<footer class="w3-bottom">
    <a href='/?trigger=1' class="w3-button w3-block w3-red w3-jumbo">Activate</a>
</footer>
</html>