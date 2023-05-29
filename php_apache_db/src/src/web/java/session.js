function pawnClickCounter() {
    if(typeof(Storage) !== "undefined") {
        if(sessionStorage.Pclickcount) {
            sessionStorage.Pclickcount = Number(sessionStorage.Pclickcount)+1;
        }
        else {
            sessionStorage.Pclickcount = 1;
        }
        document.getElementById("pawnResult").innerHTML = "Kliknięto pionka " + sessionStorage.Pclickcount + " razy w czasie tej sesji.";
    }
    else {
        document.getElementById("pawnResult").innerHTML = "Sorry, your browser does not support web storage";
    }
}
function bishopClickCounter() {
    if(typeof(Storage) !== "undefined") {
        if(sessionStorage.Bclickcount) {
            sessionStorage.Bclickcount = Number(sessionStorage.Bclickcount)+1;
        }
        else {
            sessionStorage.Bclickcount = 1;
        }
        document.getElementById("bishopResult").innerHTML = "Kliknięto gońca " + sessionStorage.Bclickcount + " razy w czasie tej sesji.";
    }
    else {
        document.getElementById("bishopResult").innerHTML = "Sorry, your browser does not support web storage";
    }
}
function knightClickCounter() {
    if(typeof(Storage) !== "undefined") {
        if(sessionStorage.Nclickcount) {
            sessionStorage.Nclickcount = Number(sessionStorage.Nclickcount)+1;
        }
        else {
            sessionStorage.Nclickcount = 1;
        }
        document.getElementById("knightResult").innerHTML = "Kliknięto skoczka " + sessionStorage.Nclickcount + " razy w czasie tej sesji.";
    }
    else {
        document.getElementById("knightResult").innerHTML = "Sorry, your browser does not support web storage";
    }
}
function rookClickCounter() {
    if(typeof(Storage) !== "undefined") {
        if(sessionStorage.Rclickcount) {
            sessionStorage.Rclickcount = Number(sessionStorage.Rclickcount)+1;
        }
        else {
            sessionStorage.Rclickcount = 1;
        }
        document.getElementById("rookResult").innerHTML = "Kliknięto wieżę " + sessionStorage.Rclickcount + " razy w czasie tej sesji.";
    }
    else {
        document.getElementById("rookResult").innerHTML = "Sorry, your browser does not support web storage";
    }
}
function queenClickCounter() {
    if(typeof(Storage) !== "undefined") {
        if(sessionStorage.Qclickcount) {
            sessionStorage.Qclickcount = Number(sessionStorage.Qclickcount)+1;
        }
        else {
            sessionStorage.Qclickcount = 1;
        }
        document.getElementById("queenResult").innerHTML = "Kliknięto hetmana " + sessionStorage.Qclickcount + " razy w czasie tej sesji.";
    }
    else {
        document.getElementById("queenResult").innerHTML = "Sorry, your browser does not support web storage";
    }
}
function kingClickCounter() {
    if(typeof(Storage) !== "undefined") {
        if(sessionStorage.Kclickcount) {
            sessionStorage.Kclickcount = Number(sessionStorage.Kclickcount)+1;
        }
        else {
            sessionStorage.Kclickcount = 1;
        }
        document.getElementById("kingResult").innerHTML = "Kliknięto króla " + sessionStorage.Kclickcount + " razy w czasie tej sesji.";
    }
    else {
        document.getElementById("kingResult").innerHTML = "Sorry, your browser does not support web storage";
    }
}