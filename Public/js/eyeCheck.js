function eyeCheck(eye,eyeoff,passwordField){
    eye.addEventListener("click", () => {
          eye.style.display = "none";
          eyeoff.style.display = "block";
          passwordField.type = "password";
    });

    eyeoff.addEventListener("click", () => {
          eyeoff.style.display = "none";
          eye.style.display = "block";
          passwordField.type = "text";
    })
}