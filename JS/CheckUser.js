function CheckUser() {
    let username = document.getElementById("full_name").value;
    let response = document.getElementById("userresponse");
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            response.innerHTML = this.responseText;
        } else if (this.readyState === 4) {
            response.innerHTML = this.status;
        }
    };

    xhttp.open("POST", "../Controller/CheckUser.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("username=" + encodeURIComponent(username));
}
