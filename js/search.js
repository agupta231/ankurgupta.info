function loadResults() {
	let keystring = "*";
	let keytag = "*";

	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			displayResults(this);			
		}
	};

	xhttp.open("POST", "/php/search_site.php", true);
	xhttp.setRequestHeader("Content-Type", "application/json");

	let sample_data = {
		"keystring" : keystring,
		"keytag" : keytag
	};
    xhttp.send(JSON.stringify(sample_data));
}

function displayResults(xhttp) {
	console.log(xhttp.responseText);
}

loadResults();
