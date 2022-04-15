const form = document.getElementById("form-inscription"),
    bouton = document.getElementById("bouton-inscription");

let	interalErrorId = null,
	timeoutErrorId = null;
form.addEventListener ("submit", function(e) {
	e.preventDefault();
	var httpr = new XMLHttpRequest(),
	pseudo = document.getElementById("pseudo").value,
	email = document.getElementById("email").value;
	httpr.open("POST", "FonctionPHP/IdentificationVerification.php");
	httpr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	httpr.send("email="+email+"&pseudo="+pseudo);
	httpr.onload = function(){
		document.getElementById("error").innerHTML = httpr.responseText;
		if(httpr.responseText=="" && validatePassword()){
			form.submit();
		}else if(httpr.responseText!=""){
			bouton.disabled=true;
			document.getElementById("error").style.opacity = 1;
			document.getElementById("error").style.transform = "scale(1.2)";
			now_time = 5;
			document.getElementById("error").innerHTML = httpr.responseText+'<p class="time_error">Réssayer dans '+now_time+" seconde(s)</p>";
			interalErrorId = setInterval(function(){
				now_time--;
				document.getElementById("error").innerHTML = httpr.responseText+'<p class="time_error">Réssayer dans '+now_time+" seconde(s)</p>";
			},1000);
			timeoutErrorId = setTimeout(() => {
				bouton.disabled=false;
				clearInterval(interalErrorId);
				interalErrorId = null;
				clearTimeout(timeoutErrorId);
				timeoutErrorId = null;
				document.getElementById("error").style.opacity = 0;
				document.getElementById("error").style.transform = "scale(0.1) translateY(-50%)";
				document.getElementById("error").removeChild(document.querySelector("#error .error"));
			},5000);
		}
	}
})

function validatePassword(){
	var password = document.getElementById("mdp"),
  		confirm_password = document.getElementById("mdpv");
  	if(password.value != confirm_password.value) {
    	confirm_password.setCustomValidity("Mot de passe non identique");
		return false;
  	} else {
    	confirm_password.setCustomValidity('');
		return true;
  	}
}
document.getElementById("mdp").onchange = validatePassword;
document.getElementById("mdpv").onkeyup = validatePassword;