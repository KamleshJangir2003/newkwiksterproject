var clearTime;
var seconds = 0,
    minutes = 0,
    hours = 0;
var secs, mins, gethours;

function startWatch() {
    if (seconds === 60) {
        seconds = 0;
        minutes = minutes + 1;
    }

    mins = minutes < 10 ? "0" + minutes : minutes;
    gethours = hours < 10 ? "0" + hours : hours;
    secs = seconds < 10 ? "0" + seconds : seconds;

    var continueButton = document.getElementById("continue");
    continueButton.removeAttribute("hidden");

    var x = document.getElementById("timer");
    x.innerHTML = '<div>' + gethours + ' h</div>' +
        '<div>' + mins + ' m</div>' +
        '<div>' + secs + ' s</div>';  // Removed colons here

    seconds++;

    clearTime = setTimeout(startWatch, 1000);
}

function startTime() {

    if (seconds === 0 && minutes === 0 && hours === 0) {
        var fulltime = document.getElementById("fulltime");
        fulltime.style.display = "none";
        var showStart = document.getElementById("start");
        showStart.style.display = "none";

        startWatch();
    }
}
var start = document.getElementById("start");
start.addEventListener("click", startTime);
window.addEventListener('load', function() {
    var stop = document.getElementById('stop');
    stop.addEventListener('click', stopTime);

    var pause = document.getElementById('pause');
    pause.addEventListener('click', pauseTime);

    var cTime = document.getElementById('continue');
    cTime.addEventListener('click', continueTime);

    // Start the timer on page load
    startWatch();
});

/*create a function to stop the time */
function stopTime() {
    if (seconds !== 0 || minutes !== 0 || hours !== 0) {
        var continueButton = document.getElementById("continue");
        continueButton.setAttribute("hidden", "true");
        var fulltime = document.getElementById("fulltime");
        fulltime.style.display = "block";
        fulltime.style.color = "#ff4500";

        // Format the recorded time in "hour:min:sec"
        var recordedHours = hours < 10 ? "0" + hours : hours;
        var recordedMinutes = minutes < 10 ? "0" + minutes : minutes;
        var recordedSeconds = seconds < 10 ? "0" + seconds : seconds;

        var time = recordedHours + ":h" + recordedMinutes + ":m" + recordedSeconds+"s";
        fulltime.innerHTML = "Time Recorded is " + time;

        // reset the Count-Up
        seconds = 0;
        minutes = 0;
        hours = 0;

        // Format the displayed time in "hour:min:sec" after stopping
        var x = document.getElementById("timer");
        var stopTime = '<div>' + recordedHours + 'h</div>' +
            '<div>' + recordedMinutes + 'm</div>' +
            '<div>' + recordedSeconds + 's</div>';
        x.innerHTML = stopTime;

        // Display all Count-Up control buttons
        var showStart = document.getElementById("start");
        showStart.style.display = "inline-block";
        var showStop = document.getElementById("stop");
        showStop.style.display = "inline-block";
        var showPause = document.getElementById("pause");
        showPause.style.display = "inline-block";

        clearTimeout(clearTime);
    }

    localStorage.removeItem('seconds');
    localStorage.removeItem('minutes');
    localStorage.removeItem('hours');
}

window.addEventListener("load", function() {
    var stop = document.getElementById("stop");
    stop.addEventListener("click", stopTime);
});

function pauseTime() {
    if (seconds !== 0 || minutes !== 0 || hours !== 0) {
        /* display the Count-Up Timer after clicking on pause button */
        var x = document.getElementById("timer");
        var stopTime = '<div>' + gethours + 'h</div>' +
            '<div>' + mins + 'm</div>' +
            '<div>' + secs + ' s</div>';;
        x.innerHTML = stopTime;

        /* display all Count-Up control buttons */
        var showStop = document.getElementById("stop");
        showStop.style.display = "inline-block";

        /* clear the Count-Up using the setTimeout( ) 
            return value 'clearTime' as ID */
        clearTimeout(clearTime);
    }
    localStorage.removeItem('seconds');
    localStorage.removeItem('minutes');
    localStorage.removeItem('hours');
}

var pause = document.getElementById("pause");
pause.addEventListener("click", pauseTime);
/*********** End of Pause Button Operations *********/

/*********** Continue Button Operations *********/
function continueTime() {
    if (seconds !== 0 || minutes !== 0 || hours !== 0) {
        /* display the Count-Up Timer after it's been paused */
        var x = document.getElementById("timer");
        var continueTime = '<div>' + gethours + 'h</div>' +
            '<div>' + mins + 'm</div>' +
            '<div>' + secs + ' s</div>';
        x.innerHTML = continueTime;

        /* display all Count-Up control buttons */
        var showStop = document.getElementById("stop");
        showStop.style.display = "inline-block";
        /* clear the Count-Up using the setTimeout( ) 
            return value 'clearTime' as ID.
            call the setTimeout( ) to keep the Count-Up alive ! */
        clearTimeout(clearTime);
        localStorage.removeItem('seconds');
        localStorage.removeItem('minutes');
        localStorage.removeItem('hours');
        clearTime = setTimeout("startWatch( )", 1000);
    }
}

window.addEventListener("load", function() {
    var cTime = document.getElementById("continue");
    cTime.addEventListener("click", continueTime);
});
/*********** End of Continue Button Operations *********/

// Disable right-click context menu
document.addEventListener('contextmenu', function (event) {
    event.preventDefault();
});

// Prevent page reload
window.addEventListener('beforeunload', function (event) {
    event.preventDefault();
});

// Optionally, you can also prevent the 'F5' key press for page reload
document.addEventListener('keydown', function (event) {
    if (event.key === 'F5' || (event.key === 'r' && event.ctrlKey)) {
        event.preventDefault();
    }
  
});
