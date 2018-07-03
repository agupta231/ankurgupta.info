function loadResults() {
	let keystring = "*";
	let keytag = "*";

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			displayResults(this);			
		}
	}

	xhttp.open("POST", "/php/search_site.php", true);
	xhttp.setRequestHeader("Content-Type", "application/json");

	let sample_data = {
		"keystring" : "*",
		"keytag" : "*"
	};
	xhttp.send(JSON.stringify(sample_data);
}

function displayResults(xhttp) {
	alert(xhttp.responseText);
}
