const filtre = document.querySelector(".filtre"),
            filtre_list = document.querySelector(".filtreList");
        let close1 = true;
        filtre.onclick = function() {
            if(close1){
                filtre_list.style.height = "350px";
                document.getElementById("bottom-hr").style.display = "flex";
                setTimeout(() => {
                    document.getElementById("bottom-hr").style.opacity = "1";
                }, 100);
                close1 = false;
            }else{
                document.getElementById("bottom-hr").style.opacity = 0;
                setTimeout(() => {
                    document.getElementById("bottom-hr").style.display = "none";
                }, 300);
                filtre_list.style.height = "0px";
                close1 = true;
            }
        }