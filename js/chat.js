let timer = null;
let refreshInterval = 600;
let req = null;
let messageContainer = null;
let lastID = 0;

function init() {
    document.addEventListener("keypress", function(e) {
        if (e.key == "Enter") {
            sendMessage();
        } else {
            document.getElementById("textbox").focus();
        }
    });

    messageContainer = document.getElementById("messages");
    req = new XMLHttpRequest();
    req.onload = function() {
        if (this.status == 200) {
            let json = JSON.parse(this.response);

            if (json.status != "ok") {
                console.error("Server returned an error: " + json.status);
                return;
            }

            if (json.messages.length > 0) {
                json.messages.forEach((msg) => {
                    addMessage(msg.msg, msg.user, msg.date);
                });
    
                lastID = json.messages.reverse()[0].ID;
            }
        }
    }

    getMessages();
    timer = setInterval(getMessages, refreshInterval);
}

function getMessages() {
    req.open("GET", "getMessages.php?minID=" + lastID);
    req.send();
}

function addMessage(msg, user, date) {
    let html = "<div class='messageLine'><div class='message ";
    let div = document.getElementById("messages");

    if (user == "yourself") {
        html += "mine";
    }

    html += "'><span class='text'>" + msg + "</span> <span class='info'>(" + user + " - " + date + ")</span></div></div>";
    messageContainer.innerHTML += html;
    div.scrollTop = div.scrollHeight;
}

function sendMessage() {
    let msg = document.getElementById("textbox");
    let req = new XMLHttpRequest();

    req.onload = function() {
        if (this.status == 200) {
            let json = JSON.parse(this.response);

            if (json.status != "sent") {
                alert("Message can't be sent: " + json.status);
                console.error("Message can't be sent: " + json.status);
            } else {
                msg.value = "";
                msg.blur();
            }
        }
    }

    req.open("POST", "sendMessage.php");
    req.send(msg.value);
}