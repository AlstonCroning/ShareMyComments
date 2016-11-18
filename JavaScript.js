//sample Ajax Demonstration
var button = document.getElementById("btn");
var userName = document.getElementById("username");
var userComment = document.getElementById("inputComment");
var msgTextArea = document.getElementById("displayComment");
var msg = document.getElementById("message");

//event
button.addEventListener("click", loadDoc);

function loadDoc() {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
             var stringify = JSON.stringify(xhttp.responseText);
             var validResponse = JSON.parse(stringify);
             outputCommentsAsHTML(validResponse);
        }
    };
	
	// Send JSON
    xhttp.open("POST", "BackendPHP.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("json_name="+
       JSON.stringify(
           {
               username1: userName.value,
               inputComment1: userComment.value
           }
       )
    );
	
	/*	
	//form encoded method (POST method)
		xhttp.open("POST", "BackendPHP.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("username1=" + userName.value + "&inputComment1=" + userComment.value);
	*/
}

function outputCommentsAsHTML(arr) {
    var out = "";
    for (var i = 0; i < arr.length; i++) {
        out = arr[i];
        msgTextArea.innerHTML += out;
    }
}
