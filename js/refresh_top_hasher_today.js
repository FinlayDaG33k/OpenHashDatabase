importScripts('../js/httpGet.js');


function refresh(){
	var json = httpGet("../api"),
    obj = JSON.parse(json);
	postMessage(obj.top_hasher_today.user);
    setTimeout("refresh()", 5000);
}

refresh();