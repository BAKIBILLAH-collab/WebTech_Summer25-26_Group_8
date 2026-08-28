function validateLogin() {
    let name = document.getElementById("name").value.trim();
    let password = document.getElementById("password").value;
    let message = "";

    if (name.length < 5) {
        message += "Name must be at least 5 characters.\n";
    }
    if (password.length < 8) {
        message += "Password must be at least 8 characters.";
    }

    if (message !== "") {
        alert(message);
        return false;
    }

    return true;
}

function validateRegistration() {
    let name = document.getElementById("full_name").value.trim();
    let password = document.getElementById("password").value;
    let message = "";

    if (name.length < 5) {
        message += "Name must be at least 5 characters.\n";
    }
    if (password.length < 8) {
        message += "Password must be at least 8 characters.";
    }

    if (message !== "") {
        alert(message);
        return false;
    }

    return true;
}
