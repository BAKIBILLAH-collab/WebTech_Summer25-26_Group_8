function CheckUser()
{
    let name = document.getElementById("fullname").value;
    let response = document.getElementById("userresponse");
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4)
        {
            if (this.status == 200)
            {
                response.innerHTML = this.responseText;
            }
            else
            {
                response.innerHTML = "AJAX Error: " + this.status;
            }
        }
    };

    xhttp.open("POST", "../Controller/CheckUser.php", true);

    xhttp.setRequestHeader(
        "Content-Type",
        "application/x-www-form-urlencoded"
    );

    xhttp.send("name=" + encodeURIComponent(name));
}