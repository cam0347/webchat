function login() {
    let user = document.getElementById("user");
    let pwd = document.getElementById("pwd");

    if (user == "" || pwd == "") {
        screenWrite("All fields must be filled");
        return;
    }

    let req = new XMLHttpRequest();

    req.onload = function() {
        if (this.status == 200) {
            console.log(this.response);
            let json = JSON.parse(this.response);
            if (json.status == "ok") {
                window.location.href = "../chat.php";
            } else if (json.status == "denied") {
                screenWrite("Wrong credentials");
            } else {
                screenWrite("There was an error");
            }
        }
    }

    req.open("GET", "login.php?user=" + user.value + "&pwd=" + md5(pwd.value));
    req.send();
}

function screenWrite(msg) {
    document.getElementById("msg_label").innerText = msg;
}