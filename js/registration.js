function register() {
    let user = document.getElementById("user");
    let pwd = document.getElementById("pwd");
    let pwd_r = document.getElementById("pwd-r");

    if (user == "" || pwd == "" || pwd_r == "") {
        screenWrite("Fill in every field to continue");
        return;
    }

    if (pwd.value != pwd_r.value) {
        screenWrite("Passwords do not match");
        return;
    }

    let obj = {
        user: user.value,
        pwd: md5(pwd.value)
    };

    let req = new XMLHttpRequest();

    req.onload = function() {
        if (this.status == 200) {
            let json = JSON.parse(this.response);
            if (json.status == "ok") {
                window.location.href = "index.html";
            } else {
                alert("Errore registrazione: " + json.status);
            }
        }
    }

    req.open("POST", "registration.php");
    req.send(JSON.stringify(obj));
}

function screenWrite(msg) {
    document.getElementById("msg_label").innerText = msg;
}