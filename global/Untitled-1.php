<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    
    <p>Server time: <span id="servertime">Loading...</span></p>
<p>Device time: <span id="devicetime">Loading...</span></p>
<p>Time offset: <span id="offsettime">Loading...</span> ms</p>
<hr/>
<p>Sweden time :: <span id="swedentime">Loading...</span></p>
<p>Finland time : <span id="finlandtime">Loading...</span></p>
<p>Japan time ::: <span id="japantime">Loading...</span></p>
<p>Dubai time ::: <span id="dubaitime">Loading...</span></p>
<p>New York time: <span id="newyorktime">Loading...</span></p>
<p>Eucla time ::: <span id="euclatime">Loading...</span></p>

<script>
    /*
	External dependencies:
		* http://momentjs.com/
		* http://momentjs.com/timezone/
*/

(function() {
    // Set the locale to use for time formatting. Try other
    // options like 'sv' or 'fi' or 'fr'. 'en' == english
    moment.locale('en');

    var deviceTime,
        serverTime,
        actualTime,
        timeOffset;

	// Run each second lap to show times in real time
    var updateDisplay = function() {
        // Show static time data
        document.getElementById('servertime').innerHTML = 
            serverTime.format();
        document.getElementById('devicetime').innerHTML = 
            deviceTime.format();
        document.getElementById('offsettime').innerHTML = 
            timeOffset;
        
        // Show dynamic time data
        var displayFormat = 'LL LTS';
        document.getElementById('swedentime').innerHTML = 
            actualTime.tz('Europe/Stockholm').format(displayFormat);
        document.getElementById('finlandtime').innerHTML = 
            actualTime.tz('Europe/Helsinki').format(displayFormat);
        document.getElementById('japantime').innerHTML = 
            actualTime.tz('Asia/Tokyo').format(displayFormat);
        document.getElementById('dubaitime').innerHTML = 
            actualTime.tz('Asia/Dubai').format(displayFormat);
        document.getElementById('newyorktime').innerHTML = 
            actualTime.tz('America/New_York').format(displayFormat);
        document.getElementById('euclatime').innerHTML = 
            actualTime.tz('Australia/Eucla').format(displayFormat);
    };

    var timerHandler = function() {
        // Get current time on the device
        actualTime = moment();
        
        // Add the calculated offset
        actualTime.add(timeOffset);
        
        // Show our new results
        updateDisplay();
        	
        // Re-run this next second wrap
    	setTimeout(timerHandler, (1000 - (new Date().getTime() % 1000)));
    };

	// Fetch the servern time through a HEAD request to current URL
    // using asynchronous request.
    var fetchServerTime = function() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onload = function() {
            var dateHeader = xmlhttp.getResponseHeader('Date');
	         
            // Just store the current time on device for display purpose
            deviceTime = moment();
            
            // Turn the "Date:" header field into a "moment" object,
            // use JavaScript Date() object as parser
            serverTime = moment(new Date(dateHeader)); // Read
            
            // Store the differences between device time and server time
            timeOffset = serverTime.diff(moment());
            
            // Now when we've got all data, trigger the timer for the first time
            timerHandler();
        }
        xmlhttp.open("HEAD", window.location.href);
        xmlhttp.send();
    }

    // Trigger the whole procedure
    fetchServerTime();
})();

</script>
</body>
</html>