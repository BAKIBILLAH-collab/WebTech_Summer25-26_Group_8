function CheckUser() {
	const nameField = document.getElementById("full_name") || document.getElementById("fullname");
	const response = document.getElementById("userresponse");

	if (!nameField || !response) {
		return;
	}

	const request = new XMLHttpRequest();

	request.onreadystatechange = function () {
		if (this.readyState === 4) {
			response.innerHTML = this.status === 200
				? this.responseText
				: "AJAX Error: " + this.status;
		}
	};

	request.open("POST", "../Controller/CheckUser.php", true);
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send("username=" + encodeURIComponent(nameField.value));
}
