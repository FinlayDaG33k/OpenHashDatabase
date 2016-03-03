importScripts('../js/httpGet.js');


function refresh(){
	var json = httpGet("https://ohd.finlaydag33k.nl/api/"),
    obj = JSON.parse(json);
	postMessage(obj.hashes_today);
    setTimeout("refresh()", 5000);
}

refresh();