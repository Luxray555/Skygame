const body = document.querySelector('body'),
      main = document.querySelector('main'),
      page = body.querySelector('.main'),
      sidebar = body.querySelector('nav'),
      toggle = body.querySelector(".toggle");

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