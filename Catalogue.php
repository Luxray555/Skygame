<?php
    require_once "Setup/database.php";
    session_start();

    require "FonctionPHP/phpFunction.php";

    if(isset($_SESSION['idUtilisateur'])){
        if ($_SESSION['timestamp']!=null) {
          $_SESSION['timestamp'] = expiredSession($_SESSION['timestamp']);
        }else{
          $_SESSION['chargement'] = 'deconnexion par innactivité';
          header('Location: Chargement.php');
        }
        $user = informationUser($_SESSION['idUtilisateur'],$bdd);
      }
    
    $platforme = array("Toutes" => "6,14,7,8,9,38,48,167,11,12,49,169,5,20,37,41,130","PC" => "6,14","Playstation" => "7,8,9,38,48,167","Xbox" => "11,12,49,169","Nintendo" => "5,20,37,41,130");
    $genre = array("Tous" => "5,7,8,9,10,12,13,14,15,25,31,32,36","Adventure" => "31","Shooter" => "5","Role-playing (RPG)" => "12","Sport" => "14","Simulator" => "13","Racing" => "10","Platform" => "8","Strategy" => "15","Indie" => "32","Hack and slash/Beat" => "25","Puzzle" => "9","MOBA" => "36","Music" => "7");
    

    if((!isset($_GET['search']) || !isset($_GET['page'])) && (isset($_GET['search']) || isset($_GET['page']))){
        header('Location: Catalogue.php');
    }
    if(isset($_GET['search']) && isset($_GET['page'])){
        if(!isset($_GET['genres'])){
            if(!isset($_GET['platforms'])){
                header('Location: Catalogue.php?search='.$_GET['search'].'&page='.$_GET['page'].'&genres[]=Tous&platforms[]=Toutes');
            }else{
                $text = 'Location: Catalogue.php?search='.$_GET['search'].'&page='.$_GET['page'].'&genres[]=Tous';
                for($i=0;$i<count($_GET['platforms']);$i++){
                    $text.='&platforms[]='.$_GET['platforms'][$i];
                }
                header($text);
            }
        }else{
            if(keyArrayExistArray($_GET['genres'],$genre)){
                if(!isset($_GET['platforms'])){
                    $text='Location: Catalogue.php?search='.$_GET['search'].'&page='.$_GET['page'];
                    for($i=0;$i<count($_GET['genres']);$i++){
                        $text.='&genres[]='.$_GET['genres'][$i];
                    }
                    $text .= '&platforms[]=Toutes';
                    header($text);
                }else{
                    if(!keyArrayExistArray($_GET['platforms'],$platforme)){
                        $text='Location: Catalogue.php?search='.$_GET['search'].'&page='.$_GET['page'];
                    for($i=0;$i<count($_GET['genres']);$i++){
                        $text.='&genres[]='.$_GET['genres'][$i];
                    }
                    $text .= '&platforms[]=Toutes';
                    header($text);
                    }
                }
            }else{
                if(!isset($_GET['platforms'])){
                    header('Location: Catalogue.php?search='.$_GET['search'].'&page='.$_GET['page'].'&genres[]=Tous&platforms[]=Toutes');
                }else{
                    if(keyArrayExistArray($_GET['platforms'],$platforme)){
                        $text='Location: Catalogue.php?search='.$_GET['search'].'&page='.$_GET['page'].'&genres[]=Tous';
                        for($i=0;$i<count($_GET['platforms']);$i++){
                            $text.='&platforms[]='.$_GET['platforms'][$i];
                        }
                        header($text);
                    }else{
                        header('Location: Catalogue.php?search='.$_GET['search'].'&page='.$_GET['page'].'&genres[]=Tous&platforms[]=Toutes');
                    }
                }
            }
        }
    }
    if(isset($_GET['search']) && $_GET['search']==""){
        header('Location: Catalogue.php');
    }

    if(isset($_GET['search']) && $_GET['search']!="" && isset($_GET['page'])){
        if($_GET['page']=="" || $_GET['page']<1){
            $text='Location: Catalogue.php?search='.$_GET['search'].'&page=1';
                for($i=0;$i<count($_GET['genres']);$i++){
                    $text.='&genres[]='.$_GET['genres'][$i];
                }
                for($i=0;$i<count($_GET['platforms']);$i++){
                    $text.='&platforms[]='.$_GET['platforms'][$i];
                }
                header($text);
        }
    }
?>
<!doctype html>
<html lang="fr">
  <?php
  include "header.php";
  ?>
    <main class="main close">
        <div class="top">
            <h1>Catalogue</h1>
		    <form class="search-bar" action="Catalogue.php" type="GET">
            <div class="search">
			    <input id="search" type="search" name="search" value="<?php
                if(isset($_GET['search'])){
                    echo $_GET['search'];
                }
                ?>" placeholder="Recherche" autocomplete="off" />
			    <button type="submit" name="page" value="1">Chercher</button>
            </div>
            <div class="filtre">
                <img src="Public/Images/icon/filtre.png">
                <span>FILTRES</span>
            </div>
            <hr style="margin-bottom:10px">
            <div class="filtreList">
                <div class="genre">
                    <span>Genre</span>
                    <hr>
                    <ul>
                    <?php
                    foreach($genre as $key => $value){
                        if($key!="Tous"){
                            echo "<li><label><input type='checkbox' name='genres[]' value='$key'";
                            if(isset($_GET['genres'])){
                                for($i=0;$i<count($_GET['genres']);$i++){
                                    if( $_GET['genres'][$i]==$key){
                                        echo "checked";
                                    }
                                }
                            }
                            echo ">$key</label></li>";
                        }
                    }
                    ?>
                    </ul>
                </div>
                <div class="platforme">
                    <span>Platforme</span>
                    <hr>
                    <ul>
                    <?php
                    foreach($platforme as $key => $value){
                        if($key!="Toutes"){
                            echo "<li><label><input type='checkbox' name='platforms[]' value='$key'";
                            if(isset($_GET['platforms'])){
                                for($i=0;$i<count($_GET['platforms']);$i++){
                                    if( $_GET['platforms'][$i]==$key){
                                        echo "checked";
                                    }
                                }
                            }
                            echo ">$key</label></li>";
                        }
                    }
                    ?>
                    </ul>
                </div>
            </div>
            <hr id="bottom-hr" style="margin:10px 0px;opacity:0;transition: all .5s ease-out;display:none;">
	        </form>
        </div>
        <div class="game-panel">
        <?php
        if(!isset($_GET['search']) || $_GET['search']==""){
            echo '<h2>A la une</h2>
            <ul class="ALaUne">';
            for($i=0;$i<4;$i++){
                afficheJeuxCatalogue();
            }
            echo '</ul>
            <h2>Meilleurs Ventes</h2>
            <ul class="MeilleurVente">';
            for($i=0;$i<4;$i++){
                afficheJeuxCatalogue();;
            }
            echo '</ul>';
        }else{
            echo '<ul class="SearchList">';
            for ($i=0; $i < 16; $i++) { 
                afficheJeuxCatalogue();
            }
            echo '</ul>
            <div class="nbPage">
                <button class="precedent"><a href="Catalogue.php?search='.$_GET['search'].'&page='.($_GET['page']-1);
                for($i=0;$i<count($_GET['genres']);$i++){
                    echo '&genres[]='.$_GET['genres'][$i];
                }
                for($i=0;$i<count($_GET['platforms']);$i++){
                    echo '&platforms[]='.$_GET['platforms'][$i];
                }
                echo '"><img src="Public/Images/icon/arrow.png"></a></button>
                <span></span>
                <button class="suivant">
                <a href="Catalogue.php?search='.$_GET['search'].'&page='.($_GET['page']+1);
                for($i=0;$i<count($_GET['genres']);$i++){
                    echo '&genres[]='.$_GET['genres'][$i];
                }
                for($i=0;$i<count($_GET['platforms']);$i++){
                    echo '&platforms[]='.$_GET['platforms'][$i];
                }
                echo '"><img src="Public/Images/icon/arrow.png"></a></button>
            </div>';
            }
        ?>
            
        </div>
        <?php
            include "footer.php";
        ?>
    </main>
    </body>
    <script type="text/javascript">

        const filtre = document.querySelector(".filtre"),
            filtre_list = document.querySelector(".filtreList");
        let close1 = true;
        filtre.onclick = function() {
            if(close1){
                filtre_list.style.height = "325px";
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
</script>
    <script type="text/javascript">
        
        function undefinedCover(image){
            if(typeof(image) == "undefined"){
                return "Public/Images/background/no-cover-image.png";
            }else{
                return "https://images.igdb.com/igdb/image/upload/t_cover_big/"+image.image_id+".jpg";
            }
        }

        function undefinedPlatforms(platforms,placement){
            if(typeof(platforms) != "undefined"){
                platforms.forEach((p,nb) => {
                    placement.querySelector(".platforms").appendChild(document.createElement("span"));
                    placement.querySelectorAll(".platforms span")[nb].innerHTML = platforms[nb].name;
                });
            }else{
                placement.querySelector(".platforms").appendChild(document.createElement("span"));
                placement.querySelector(".platforms span").innerHTML = "Aucun";
            }
        }
        function undefinedGenres(genres,placement){
            if(typeof(genres) != "undefined"){
                genres.forEach((g,nb) => {
                    placement.querySelector(".genres").appendChild(document.createElement("span"));
                    placement.querySelectorAll(".genres span")[nb].innerHTML = genres[nb].name;
                });
            }else{
                placement.querySelector(".genres").appendChild(document.createElement("span"));
                placement.querySelector(".genres span").innerHTML = "Aucun";
            }
        }
        function undefinedSummary(summary){
            if(typeof(summary) != "undefined"){
                return summary.substring(0, 250)+"...";
            }else{
                return "Aucune description...";
            }
        }
        <?php
        if(!isset($_GET['search']) || !isset($_GET['page']) ){
            echo 'function accueilCatalogue(list,custom_where){
                var httpr = new XMLHttpRequest();
                httpr.open("POST", "FonctionPHP/LoadIGDBGame.php");
		        httpr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		        httpr.send("limit="+4+"&sort="+"follows desc"+"&platforms='.$platforme['Toutes'].'&genres='.$genre['Tous'].'&custom_where="+custom_where);
                httpr.onload = function(){
			        var game = eval(httpr.response);
                    if((game.length)<list[1].length){
                        var e = game.length;
                        for(i=list[1].length-1;i>game.length-1;i--){
                            list[0].removeChild(list[1][i]);
                        }
                    }else{
                        var e = list[1].length;
                    }
                    for(i=0;i<e;i++){
                        list[1][i].querySelector("h4").innerHTML = game[i].name;
                        list[1][i].querySelector("h3").innerHTML = game[i].name;
                        list[1][i].querySelector("a").href = "PageJeu.php?idJeu="+game[i].id;
                        list[1][i].querySelector("p").innerHTML = undefinedSummary(game[i].summary);
                        list[1][i].querySelector(".block").style.background = "black";
                        list[1][i].querySelector("img").src = undefinedCover(game[i].cover);
                        undefinedPlatforms(game[i].platforms,list[1][i]);
                        undefinedGenres(game[i].genres,list[1][i]);
                    }
		        }
            }
            var custom_where = ["total_rating > 80","total_rating > 90"],
                list = [[document.querySelector(".ALaUne"),document.querySelectorAll(".ALaUne .game")],[document.querySelectorAll(".MeilleurVente"),document.querySelectorAll(".MeilleurVente .game")]];
            accueilCatalogue(list[0],custom_where[0]);
            setTimeout(() => {
                accueilCatalogue(list[1],custom_where[1]);
            }, "1000");';
        }else{
            $platforme_total = "";
            if(isset($_GET['platforms'])){
                foreach($_GET['platforms'] as $key){
                    $platforme_total .= $platforme[$key];
                }
            }else{
                $platforme_total = $platforme['Toutes'];
            }
            
            $genre_total = "";
            if(isset($_GET['genres'])){
                foreach($_GET['genres'] as $key){
                    $genre_total .= $genre[$key];
                }
            }else{
                $genre_total = $genre['Tous'];
            }
            echo 'function searchCatalogue(list){
                var httpr = new XMLHttpRequest();
                httpr.open("POST", "FonctionPHP/LoadIGDBGame.php");
		        httpr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		        httpr.send("search='.$_GET['search'].'"+"&platforms='.$platforme_total.'&genres='.$genre_total.'");
                httpr.onload = function(){
			        var game = eval(httpr.response);
                    if((game.length-('.$_GET['page'].'-1)*16)<list[1].length){
                        var e = (game.length-('.$_GET['page'].'-1)*16);
                        for(i=list[1].length-1;i>e-1;i--){
                            list[0].removeChild(list[1][i]);
                        }
                    }else{
                        var e = list[1].length;
                    }
                    for(i=0;i<e;i++){
                        list[1][i].querySelector("h4").innerHTML = game[i+'.($_GET['page']-1)*16 .'].name;
                        list[1][i].querySelector("h3").innerHTML = game[i+'.($_GET['page']-1)*16 .'].name;
                        list[1][i].querySelector("p").innerHTML = undefinedSummary(game[i].summary);
                        list[1][i].querySelector(".block").style.background = "black";
                        list[1][i].querySelector("img").src = undefinedCover(game[i+'.($_GET['page']-1)*16 .'].cover);
                        undefinedPlatforms(game[i+'.($_GET['page']-1)*16 .'].platforms,list[1][i]);
                        undefinedGenres(game[i+'.($_GET['page']-1)*16 .'].genres,list[1][i]);
                        list[1][i].querySelector("a").href = "PageJeu.php?idJeu="+game[i+'.($_GET['page']-1)*16 .'].id;
                    }
                    if(game.length==0){
                        console.log("ok");
                        document.querySelector(".game-panel").innerHTML = "<h3 class='."'".'no-game'."'".'>Aucun jeu trouvé</h3>";
                    }
                    document.querySelector(".nbPage span").innerHTML ="'.$_GET['page'].'"+" / "+(Math.ceil((game.length/16))).toString();
                    if('.$_GET['page'].'==1){
                        document.querySelector(".nbPage .precedent").disabled = true;
                        document.querySelector(".nbPage .precedent a").style.pointerEvents = "none";
                    }
                    if('.$_GET['page'].'==Math.ceil((game.length/16))){
                        document.querySelector(".nbPage .suivant").disabled = true;
                        document.querySelector(".nbPage .suivant a").style.pointerEvents = "none";
                    }

		        }
            }
            var list = [document.querySelector(".SearchList"),document.querySelectorAll(".SearchList .game")];
            searchCatalogue(list)';
        }
        ?>
        
    </script>
</html>