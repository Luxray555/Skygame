const body = document.querySelector('body'),
      main = document.querySelector('main'),
      page = body.querySelector('.main'),
      sidebar = body.querySelector('nav'),
      toggle = body.querySelector(".toggle"),
      button = document.querySelector('.sidebar header button');

close = true;
toggle.addEventListener("click" , () =>{
    sidebar.classList.toggle("close");
    main.classList.toggle("close");
    if(close){ 
        setTimeout(() => {
            toggle.querySelector("img").src = "Public/Images/icon/cross.png";
            close=false;
        }, 100);
    }else{
        setTimeout(() => {
            toggle.querySelector("img").src = "Public/Images/icon/arrow.png";
            close=true;
        }, 100);
        
    }
})
hamburger = true;
button.addEventListener("click",()=>{
    if(hamburger){
        sidebar.style.width = "88px";
        sidebar.style.backgroundColor = "#303030";
        sidebar.style.borderRight = "white solid 1px";
        button.querySelector("img").src = "Public/Images/icon/cross.png";
        hamburger = false;
    }else{
        sidebar.style.width = "0px";
        sidebar.style.backgroundColor = "transparent";
        sidebar.style.borderRight = "none";
        button.querySelector("img").src = "Public/Images/icon/hamburger.png";
        hamburger = true;
    }
})

window.addEventListener("resize", function() {
    if (window.matchMedia("(min-width: 900px)").matches) {
        sidebar.style.width = "";
        sidebar.style.backgroundColor = "#303030";
        sidebar.style.borderRight = "white solid 1px";
        button.querySelector("img").src = "Public/Images/icon/cross.png";
        hamburger = false;
    }else{
        sidebar.style.width = "0px";
        sidebar.style.backgroundColor = "transparent";
        sidebar.style.borderRight = "none";
        button.querySelector("img").src = "Public/Images/icon/hamburger.png";
        hamburger = true;
    }
  })