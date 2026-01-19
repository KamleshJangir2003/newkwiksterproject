function openTimerPopup() {
    // Check if the popup is already open
    if (window.timerPopup && !window.timerPopup.closed) {
        // If open, bring it to focus
        window.timerPopup.focus();
        return;
    }

    const timestamp = new Date().getTime();
    const windowName = 'TimerPopup' + timestamp;
    const popupWindow = window.open('', windowName, 'width=300,height=250,resizable=no');

    // Assign the popup window to a global variable
    window.timerPopup = popupWindow;

    // Add event listener to prevent refresh on close
    popupWindow.onbeforeunload = function () {
        popupWindow.opener.focus();
        return "Are you sure you want to leave?";
    };

    // Add event listener to handle resize attempts
    popupWindow.addEventListener('resize', function () {
        popupWindow.resizeTo(300, 250);
    });

    popupWindow.document.write(`
        <html>
            <head>
                <title>Timer Popup</title>
                <link rel="stylesheet" href="${window.location.origin}/assets/css/timer.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
            </head>
            <body>
                <div class="container-fluid d-flex text-aligns-center justify-content-center b">
                    <div class="row a">
                        <div class="col-sm-12 ">
                            <section id="stopWatch">
                                <div class="d-flex text-aligns-center justify-content-center">
                                    <img src="${window.location.origin}/images/giphy.webp" alt="" class="img">
                                </div>
                             
                                <p id="timer" class="text-center"> 00:00:00 </p>
                                <button id="start"> Start </button>
                                <button id="stop"> Stop </button>
                                <button id="pause"> Pause </button>
                                <button id="continue" hidden> Continue </button>
                                <p id="fulltime" class="fulltime"> </p>
                            </section>
                        </div>
                    </div>
                </div>
                <script src="${window.location.origin}/assets/js/script.js"></script>
            </body>
        </html>
    `);
    popupWindow.document.close();

    // Disable the button after opening the popup
    document.getElementById('openTimerButton').disabled = true;
}
