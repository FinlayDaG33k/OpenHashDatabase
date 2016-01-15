importScripts('../js/httpGet.js');


function refresh(){
	var json = httpGet("../api"),
    obj = JSON.parse(json);
	postMessage(obj.hashes);
    setTimeout("refresh()", 5000);
}

refresh();