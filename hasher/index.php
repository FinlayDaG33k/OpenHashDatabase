<?php
    header('Content-type: text/html');
    header('Access-Control-Allow-Origin: *');
?>
<!DOCTYPE html>
<html>

    
    
    <body onload="startWorker()">
   

        <p>Submitted Hashes: <output id="result">0</output></p>
        username (Leave empty for anonymous hashing):<br><INPUT TYPE="text" NAME="inputbox" id="username" onchange="stopWorker();" value="<?php echo $_GET['username'];?>"><br />
        <button onclick="startWorker()">Start Worker</button>
        <button onclick="stopWorker()">Stop Worker</button>
        <br><br>

<script>
var w;

function startWorker() {
    var username = document.getElementById("username").value;
    if (username == '') {
        username = "Anonymous";
    }
    if(typeof(Worker) !== "undefined") {
        if(typeof(w) == "undefined") {
            w = new Worker("worker.js");
            w.postMessage(username);
        }
        
        
        w.onmessage = function(event) {
            document.getElementById("result").innerHTML = event.data;
        };
    } else {
        document.getElementById("result").innerHTML = "Sorry! No Web Worker support.";
    }
}

function stopWorker() {
    w.terminate();
    w = undefined;
}
</script>

Made with &#9829; By FinlayDaG33k	| <a href="https://github.com/FinlayDaG33k/OpenHashDatabase" target="_new">Contribute to me on Github!</a>

</body>
</html>