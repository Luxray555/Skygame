const form = document.getElementById('form-connexion'),
	bouton = document.getElementById('bouton-connexion');

let	interalErrorId = null,
	timeoutErrorId = null;

form.addEventListener ("submit", function(e) {
	e.preventDefault();
	var httpr = new XMLHttpRequest(),
		email = document.getElementById("email").value,
		mdp = document.getElementById("mdp").value;
	httpr.open("POST", "FonctionPHP/IdentificationVerification.php");
	httpr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	httpr.send("email="+email+"&mdp="+mdp);
	httpr.onload = function(){
		document.getElementById("error").innerHTML = httpr.responseText;
		if(httpr.responseText==""){
			form.submit();
		}else{
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