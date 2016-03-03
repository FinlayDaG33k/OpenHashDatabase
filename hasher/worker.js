importScripts('../js/httpGet.js');
var username = '';
onmessage = function (e) {
username = e.data;
}



var count = 0;

function genStr(length)
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < length; i++ ){
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return text;
}

function genInt()
{
    var int = "";
    var possible = "123456789";

    for( var i=0; i < 1; i++ ){
        int += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return int;
}

function Submit(text,username){
    httpGet("https://ohd.finlaydag33k.nl/?method=plaintext&username=" + username + "&text=" + text);
}

function Dowork(){
    Submit(genStr(genInt()),username);
    count++;
    postMessage(count);
    setTimeout("Dowork()");
}

Dowork();
