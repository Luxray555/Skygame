var btnAmis = document.querySelectorAll(".btnAmis button");
var mesAmis = document.getElementById("mesAmis");
var demandeAmis = document.getElementById("demandeAmis");

btnAmis[0].onclick = function(){
    btnAmis[0].id = "active";
    btnAmis[1].removeAttribute("id");
    mesAmis.style.display = "inherit";
    demandeAmis.style.display = "none";
}

btnAmis[1].onclick = function(){
    btnAmis[1].id="active";
    btnAmis[0].removeAttribute("id");
    demandeAmis.style.display = "inherit";
    mesAmis.style.display = "none";
}