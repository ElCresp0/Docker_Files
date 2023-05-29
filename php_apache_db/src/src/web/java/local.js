function przypisz () {
    if (typeof(Storage) !== "undefined") {
       var checkboxP = document.getElementById("p");
       if(checkboxP.checked) {localStorage.setItem("pawn", "checkboxP.checked")}
       else {localStorage.setItem("pawn", "checkboxP.unchecked")}
       var checkboxN = document.getElementById("n");
       if(checkboxN.checked) {localStorage.setItem("knight", "checkboxN.checked")}
       else {localStorage.setItem("knight", "checkboxN.unchecked")}
       var checkboxB = document.getElementById("b");
       if(checkboxB.checked) {localStorage.setItem("bishop", "checkboxB.checked")}
       else {localStorage.setItem("bishop", "checkboxB.unchecked")}
       var checkboxR = document.getElementById("r");
       if(checkboxR.checked) {localStorage.setItem("rook", "checkboxR.checked")}
       else {localStorage.setItem("rook", "checkboxR.unchecked")}
       var checkboxQ = document.getElementById("q");
       if(checkboxQ.checked) {localStorage.setItem("queen", "checkboxQ.checked")}
       else {localStorage.setItem("queen", "checkboxQ.unchecked")}
       var checkboxK = document.getElementById("k");
       if(checkboxK.checked) {localStorage.setItem("king", "checkboxK.checked")}
       else {localStorage.setItem("king", "checkboxK.unchecked")}
       var opening = document.getElementById("opening").selectedIndex;
       if(opening===0) {localStorage.setItem("favOpening", "e4");}
       if(opening===1) {localStorage.setItem("favOpening", "d4");}
       if(opening===2) {localStorage.setItem("favOpening", "c4");}
       if(opening===3) {localStorage.setItem("favOpening", "nf3");}
       var story = document.getElementById("story").value;
       localStorage.setItem("story", story);
       var name = document.getElementById("name").value;
       localStorage.setItem("name", name);
       var surname = document.getElementById("surname").value;
       localStorage.setItem("surname", surname);
       var lcAccount = document.getElementById("lcAccount").value;
       localStorage.setItem("lcAccount", lcAccount);
       var date = document.getElementById("date").value;
       localStorage.setItem("date", date);
       var radiok = document.getElementById("ko");
       var radiom = document.getElementById("m");
       if(radiok.checked) {localStorage.setItem("sex", "kobieta");}
       else {
        if(radiom.checked) {localStorage.setItem("sex", "mężczyzna");}
        else {localStorage.setItem("sex", "unknown");}
        }

    }
}