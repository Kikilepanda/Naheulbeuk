<?php

// création base de donnée
$mechant = array(
    array(
      "nom" => "Pirate",
      "lieu" => "Village",
      "gros" =>  "Base",
      "EV" => 12,
      "Groupe1" => "Pirate",
      "Groupe2" => "",
      "Groupe3" =>"",
      "menace" => 1,
      "Agressivite" => 3,

    ),
    array(     
    "nom" => "Chien",
    "lieu" => "Village",
    "gros" => "Horde",
    "EV" => 8,
    "Groupe1" => "Creature",
    "Groupe2" => "Bandit",
    "Groupe3" => "Pirate",
    "menace" => 1,
    "Agressivite" => 3,),

    array(
      "nom" => "Garde",
      "lieu" => "Village",
      "gros" => "Base",
      "EV" => 20,
      "Groupe1" => "Garde",
      "Groupe2" => "",
      "Groupe3" => "",
      "menace" => 1,
      "Agressivite" => 1,
    ),
    array(
      "nom" => "Invocatrice",
      "lieu" => "Village",
      "gros" => "Boss",
      "EV" => 65,
      "Groupe1" => "",
      "Groupe2" =>"",
      "Groupe3" =>"",
      "menace" =>3,
      "Agressivite" =>0,
    ),

    array(
      "nom" => "Nounouk",
      "lieu" => "Village",
      "gros" => "Boss",
      "EV" => 80,
      "Groupe1" => "Bandit",
      "Groupe2" =>"Barbare",
      "Groupe3" => "",
      "menace" => 3,
      "Agressivite" => 3,
    
    ),
    array(
      "nom" => "Garde Elite",
      "lieu" => "Village",
      "gros" =>  "Boss",
      "EV" => 90,
      "Groupe1" => "Garde",
      "Groupe2" =>"",
      "Groupe3" =>"",
      "menace" =>1,
      "Agressivite" =>1,
    ),

    array(
      "nom" => "Chef de Garde",
      "lieu" => "Village",
      "gros" => "Mini Boss",
      "EV" => 20,
      "Groupe1" => "Garde",
      "Groupe2" =>"",
      "Groupe3" =>"",
      "menace" =>1,
      "Agressivite" =>1,
    ),

    array(
      "nom" => "Pirate Vétéran",
      "lieu" => "Village",
      "gros" => "Mini Boss",
      "EV" => 55,
      "Groupe1" => "Pirate",
      "Groupe2" => "",
      "Groupe3" =>"",
      "menace" =>1,
      "Agressivite" =>3,
    ),
    array(
      "nom" => "Chef Pirate",
      "lieu" => "Village",
      "gros" => "Boss",
      "EV" => 90,
      "Groupe1" =>"Pirate",
      "Groupe2" =>"",
      "Groupe3" =>"",
      "menace" =>3,
      "Agressivite" =>3,
    ),
  );
  
  //fin base de donnée

  //Création des variables :

  $evgroupe = rand(8,400); // EV de tous les perso du groupe qui serait à rentrer à la main
  $evinitialegroupe = $evgroupe; // Garder une trace des EV initiaux
  $taillerencontre = ["Solo", "Groupe", "Horde"]; // 3 Types de rencontre possible
  $choixrencontre = rand(0,2); // choix aléatoire du type de rencontre, Envisager qu'on puisse le déterminer en amont avec un if pas choist ça le fait automatiquement
  $a = 0; //incrément pour les choix des mobs dans les groupes + hordes
  $monstretotal = 0; //nombre de mobs total
  $monstrerestant = 0; //nombre de mobs restant à choisir
  $evgroupemonstre = 0; //EV du groupe de mobs
  $nombre = 0; //Variable pour if dans les boucles
  $existe = 0; //Variable pour if dans les boucles
  $recap = []; //Tableau récap total de la rencontre 
  $repertoire = []; //Tableau des ID déjà tirés
  $taillegros = [];// Tableau récap des type de mobs (Boss, Mini Boss.. etc.)
  $info = []; //Tableau des ID déjà testé dans les boucles
  $recapgroupe1= []; //Tableau récap des "groupe1" des mobs pour filtrer dessus
  $recapgroupe2 = [];//Tableau récap des "groupe2" des mobs pour filtrer dessus
  $recapgroupe3 = [];//Tableau récap des "groupe3" des mobs pour filtrer dessus
  $miniboss = [] //compter le nombre de mini boss
  $EVmini = min(array_column($mechant,"EV")); // test on s'en fou

If ($choixrencontre === 0){ //Si rencontre d'un monstre simple
    echo "Rencontre de type : $taillerencontre[$choixrencontre] \n" ; //Ecrit le type de rencontre
    $nbmechant = 1; // Nombre de méchant fixé à 1
    echo "Le groupe à " .$evgroupe. " PV" ."\n\n"; //Avoir une trace des PV du groupe pour test à dégager ?
do{ //Boucle choix du mobs
        $id = rand(0,8); //choix rand de l'ID à tester
        $evtotale = $mechant[$id]["EV"]; //Détermination de EV mob pour la fin et tableau recap
      }while($mechant[$id]["gros"] === "Horde"); // Si mob est de la famille Horde choisir un autre ID

    $nom = $mechant[$id]["nom"]; //création variable pour tableau récap
    $taille = $mechant[$id]["gros"];//création variable pour tableau récap
    $recap[$a] = [ //Création tableau Récap
      "nom" => $nom,// Nom du mob
      "taille" => $taille,// Type de mobs
      "ev" => $evtotale, //Ev mobs
      "nombre" => $nbmechant,// nombre de mob --> forcément 1

    ]; //fin si rencontre type Solo


}elseif($choixrencontre === 1){//Si rencontre d'un Groupe
    echo "Rencontre de type : $taillerencontre[$choixrencontre] \n";//Ecrit le type de rencontre
    $randtaille = rand(3,10); // Randomise le nombre de mob max (3 à 10 au dessus de 10 hordes)
    $evmaxigroup = $evgroupe/2; //Valeur EV max du mob à choisir
    $evgroupedivise = $evgroupe / $randtaille; //pv minimum du mob
    $arrondit = round($evgroupedivise); //pv minimum du mob arrondit
    $max = $randtaille - 1; //Valeur créée pour stopper la boucle
  do{ //Début de la boucle
    if ($a === 0){//Premier mobs à choisir
      do{//Boucle du choix
      $id = rand(0,8);//Choisir un ID aléatoirement
      $evtotale = $mechant[$id]["EV"]; // Création de la variable $evtotale
      $taille = $mechant[$id]["gros"]; //création de la variable $taille

      if ($evtotale >= $arrondit && $evtotale <= $evmaxigroup){ // Si EV mob compris dans les bornes min/max
        $nombre = 0; //Alors variable $nombre =0
      }else{
        $nombre = 1; //Sinon $nombre = 1
      }

 
    }while($taille === "Horde" || $nombre === 1 ); //Faire tant que la taille du mob est horde ou que les EV sortes des bornes
    if ($mechant[$id]["gros"] === "Base"){//si le mob est une base
      do{
        $nbmechant = rand(1,$randtaille); //Rand le nombre de mob entre 1 et le max possible
        $evtotale = $mechant[$id]["EV"] * $nbmechant; //Calcul les EV max du sous groupe
        }while($evtotale > $evgroupe); // continuer tant que les EV mobs sont supérieur à celui du groupe --> USeless avec la boucle du dessus ???
      }elseif($mechant[$id]["gros"] === "Mini Boss"){  //si mob est un Mini boss
        $nbmechant = 1;       
        $evtotale = $mechant[$id]["EV"] * $nbmechant;  //Calcul les EV max du sous groupe
    }elseif($mechant[$id]["gros"] === "Boss"){    
        $nbmechant = 1;     
        $evtotale = $mechant[$id]["EV"] * $nbmechant;   //Calcul les EV max du sous groupe
    };
  };

  if ($a <> 0){//Si ce n'est plus le premier mob à choisir

    if (in_array("Boss",$taillegros) and in_array("Mini Boss", $taillegros)){ //si il y a déjà un boss et un mini boss
      do{ //Début boucle
      $id = rand(0,8); //Rand le choix du mob
      $evtotale = $mechant[$id]["EV"]; //creation des variables
      $taille = $mechant[$id]["gros"]; //creation des variables
      $groupe1 = $mechant[$id]["Groupe1"];//creation des variables
      $groupe2 = $mechant[$id]["Groupe2"];//creation des variables
      $groupe3 = $mechant[$id]["Groupe3"];//creation des variables

      if ($groupe1 == "" && $groupe2 == "" && $groupe3 ==""){//si mob sans appartenance 
        $existe = 0; 
      }elseif($groupe1 <> "" && (in_array($groupe1, $recapgroupe1) || in_array($groupe1, $recapgroupe2)|| in_array($groupe1, $recapgroupe3))){ //Si appartenance du mob choisit est dans un tbleau de groupe recap
        $existe = 0;
      }elseif($groupe2 <> "" && (in_array($groupe2, $recapgroupe1) || in_array($groupe2, $recapgroupe2)|| in_array($groupe2, $recapgroupe3))){//Si appartenance du mob choisit est dans un tbleau de groupe recap
        $existe = 0;
      }elseif($groupe3 <> "" && (in_array($groupe3, $recapgroupe1) || in_array($groupe3, $recapgroupe2)|| in_array($groupe3, $recapgroupe3))){//Si appartenance du mob choisit est dans un tbleau de groupe recap
        $existe = 0;
      }else{//Si aucune condition n'est bonne ça dégage
        $existe = 1;
      }

      if ($evtotale >= $arrondit && $evtotale <= $evmaxigroup){// Si EV mob compris dans les bornes min/max
        $nombre = 0;
      }else{//Sinon ça dégage
        $nombre = 1;
      }

      if (!in_array($id, $info)){//Création d'un tableau pour si plus de mobs dispo sortir de la boucle et stopper le processus
        array_push ($info, $id);//Création d'une ligne pour une nouvel ID non présent dans le tableau
        if(count($info) == 8){ //si 8 ligne créée on stop --> changer car BDD plus grande en théorie
        break 2; //Stop toutes les boucles en cours
      }
    }
    }while(in_array($id,$repertoire) || $taille === "Boss" || $taille === "Mini Boss" || $taille === "Horde" || $existe === 1 || $nombre === 1);
/*     Continuer tant que :
    - Mob déjà sélectionné
    - le mob est un boss 
    - Le mob est un miniboss
    - Fait partie des mob horde 
    - Premiere condition pas remplit 
    - Deuxième condition pas remplit */

  } elseif(in_array("Mini Boss",$taillegros)){// PAreil qu'avant mais que si il y a déjà un miniboss
    do{
      $id = rand(0,8);
      $evtotale = $mechant[$id]["EV"];
      $taille = $mechant[$id]["gros"];
      $groupe1 = $mechant[$id]["Groupe1"];
      $groupe2 = $mechant[$id]["Groupe2"];
      $groupe3 = $mechant[$id]["Groupe3"];

      if ($groupe1 == "" && $groupe2 == "" && $groupe3 == ""){
        $existe = 0;
      }elseif($groupe1 <> "" && (in_array($groupe1, $recapgroupe1) || in_array($groupe1, $recapgroupe2)|| in_array($groupe1, $recapgroupe3))){
        $existe = 0;
      }elseif($groupe2 <> "" && (in_array($groupe2, $recapgroupe1) || in_array($groupe2, $recapgroupe2)|| in_array($groupe2, $recapgroupe3))){
        $existe = 0;
      }elseif($groupe3 <> "" && (in_array($groupe3, $recapgroupe1) || in_array($groupe3, $recapgroupe2)|| in_array($groupe3, $recapgroupe3))){
        $existe = 0;
      }elseif($recapgroupe1[0] == "" && $recapgroupe2[0] == "" && $recapgroupe3[0] == ""){
        $existe = 0;
      }else{
        $existe = 1;
      }

      if ($evtotale >= $arrondit && $evtotale <= $evmaxigroup){
        $nombre = 0;
      }else{
        $nombre = 1;
      }


      if (!in_array($id, $info)){
        array_push ($info, $id);
        if(count($info) == 8){
        break 2;
      }
    }
    }while(in_array($id,$repertoire)|| $taille === "Mini Boss" || $taille === "Horde" || $existe === 1 || $nombre === 1); 

  }elseif (in_array("Boss",$taillegros)){// Pareil qu'avant mais que si il y a déjà un boss
    do{
    $id = rand(0,8);
    $evtotale = $mechant[$id]["EV"];
    $taille = $mechant[$id]["gros"];
    $groupe1 = $mechant[$id]["Groupe1"];
    $groupe2 = $mechant[$id]["Groupe2"];
    $groupe3 = $mechant[$id]["Groupe3"];

    if ($groupe1 == "" && $groupe2 == "" && $groupe3 ==""){
      $existe = 0;
    }elseif($groupe1 <> "" && (in_array($groupe1, $recapgroupe1) || in_array($groupe1, $recapgroupe2)|| in_array($groupe1, $recapgroupe3))){
      $existe = 0;
    }elseif($groupe2 <> "" && (in_array($groupe2, $recapgroupe1) || in_array($groupe2, $recapgroupe2)|| in_array($groupe2, $recapgroupe3))){
      $existe = 0;
    }elseif($groupe3 <> "" && (in_array($groupe3, $recapgroupe1) || in_array($groupe3, $recapgroupe2)|| in_array($groupe3, $recapgroupe3))){
      $existe = 0;
    }elseif($recapgroupe1[0] == "" && $recapgroupe2[0] == "" && $recapgroupe3[0] == ""){
      $existe = 0;
    }else{
      $existe = 1;
    }

    if ($evtotale >= $arrondit && $evtotale <= $evmaxigroup){
      $nombre = 0;
    }else{
      $nombre = 1;
    }

    if (!in_array($id, $info)){
      array_push ($info, $id);
      if(count($info) == 8){
      break 2;
    }
  }
}while(in_array($id,$repertoire)|| $taille === "Boss" || $taille === "Horde" || $existe === 1 || $nombre === 1);

}else{//sinon Pareil qu'avant mais pas encore de Boss ou mini boss
    do{
    $id = rand(0,8);
    $evtotale = $mechant[$id]["EV"];
    $taille = $mechant[$id]["gros"];
    $groupe1 = $mechant[$id]["Groupe1"];
    $groupe2 = $mechant[$id]["Groupe2"];
    $groupe3 = $mechant[$id]["Groupe3"];

      if ($groupe1 == "" && $groupe2 == "" && $groupe3 ==""){
        $existe = 0;
      }elseif($groupe1 <> "" && (in_array($groupe1, $recapgroupe1) || in_array($groupe1, $recapgroupe2)|| in_array($groupe1, $recapgroupe3))){
        $existe = 0;
      }elseif($groupe2 <> "" && (in_array($groupe2, $recapgroupe1) || in_array($groupe2, $recapgroupe2)|| in_array($groupe2, $recapgroupe3))){
        $existe = 0;
      }elseif($groupe3 <> "" && (in_array($groupe3, $recapgroupe1) || in_array($groupe3, $recapgroupe2)|| in_array($groupe3, $recapgroupe3))){
        $existe = 0;
      }else{
        $existe = 1;
      }

      if ($evtotale >= $arrondit && $evtotale <= $evmaxigroup){
        $nombre = 0;
      }else{
        $nombre = 1;
      }


    if (!in_array($id, $info)){
      array_push ($info, $id);
      if(count($info) == 8){
      break 2;
    }
  }

  }while(in_array($id,$repertoire) || $taille === "Horde" ||$existe === 1 || $nombre === 1);
};
    $taille = $mechant[$id]["gros"];//création variable
    if ($mechant[$id]["gros"] === "Base"){//si le mob est une base
        do{
           $nbmechant = rand(1,$monstrerestant);//Rand le nombre de mob entre 1 et le max possible
           $evtotale = $mechant[$id]["EV"] * $nbmechant;// continuer tant que les EV mobs sont supérieur à celui du groupe --> USeless avec la boucle du dessus ???
        }while($evtotale > $evgroupe);
    }elseif($mechant[$id]["gros"] === "Mini Boss"){  //si mob est un Mini boss
            $nbmechant = 1;     
            $evtotale = $mechant[$id]["EV"] * $nbmechant;  //Calcul les EV max du sous group
    }elseif($mechant[$id]["gros"] === "Boss"){   //si mob est un Mini boss
            $nbmechant = 1;     
            $evtotale = $mechant[$id]["EV"] * $nbmechant;   //Calcul les EV max du sous group 
    };
  };

   array_push ($recap, $id); //Création ligne récap
   array_push ($repertoire, $id);//Création ligne répertoire des ID déjà selectionnés
   array_push ($taillegros, $mechant[$id]["gros"]); //Création tableau des tailles de mobs sélectionné
   array_push ($recapgroupe1, $mechant[$id]["Groupe1"]); //création tableau des groupe1
   array_push ($recapgroupe2, $mechant[$id]["Groupe2"]);//création tableau des groupe2
   array_push ($recapgroupe3, $mechant[$id]["Groupe3"]);//création tableau des groupe3


  $evgroupe = $evgroupe - $evtotale; //Calcul des EV max restant

  $nom = $mechant[$id]["nom"]; //création Variable
  $ev = $mechant[$id]["EV"];//création Variable
  $taille = $mechant[$id]["gros"];//création Variable
  $groupe1 = $mechant[$id]["Groupe1"];//création Variable
  $groupe2 = $mechant[$id]["Groupe2"];//création Variable
  $groupe3 = $mechant[$id]["Groupe3"];//création Variable

  $recap[$a] = [ //création tableau récap
    "id"=> $id,
    "nom" => $nom,
    "numero" => $id,
    "taille" => $taille,
    "ev" => $ev,
    "groupe1" => $groupe1,
    "groupe2" => $groupe2,
    "groupe3" => $groupe3,
    "nombre" => $nbmechant,
    "evtotale" => $evtotale,
  ];

  $a++; //incrément de $a pour savoir où on en est
  $monstretotal = $monstretotal + $nbmechant; //calcul du nombre de mobs déjà sélectionné
  $monstrerestant = $randtaille - $monstretotal; //calcul des mobs à choisir restant
  $info = []; //réinitialisation du tableau info pour la suite
  $evgroupemonstre = $evgroupemonstre + $evtotale; //Total des EV déjà utilisée
  $evmaxigroup = $evgroupe-$evgroupemonstre; //EV maxi restant à choisir
  if ($monstrerestant > 0){//si il reste des mobs à selectionner
  $arrondit = round($evmaxigroup/$monstrerestant); //Calcul des nouveaux EV mini
  }
}while($evgroupe >= 0 && $a <= $max && $monstretotal < $randtaille); 
  /* Faire la boucle tant que :
  -  les EV ne sont utilisés
  - ET pas atteint le nombre de mob max
  - ET pas atteint le nombre de mob max --> je pense qu'on peut en supprimer un....*/ 

}elseif($choixrencontre == 2){ // si horde --> tout pareil sauf les chiffres change
  echo "Rencontre de type : $taillerencontre[$choixrencontre] \n";
  $randtaille = rand(10,30);
  $evmaxigroup = $evgroupe/10;
  $evgroupedivise = $evgroupe / $randtaille; //pv minimum du mob
  $arrondit = round($evgroupedivise); //pv minimum du mob arrondit
  echo "Le groupe à " .$evgroupe. " PV" ."\n\n";
  echo "les EV min doivent être de : $arrondit \n";
  echo "les EV max doivent être de : $evmaxigroup \n";
  $max = $randtaille - 1;
  echo "Le groupe des monstres comprend : $randtaille \n\n";

do{

  if ($a === 0){

    do{
    $id = rand(0,8);
    $evtotale = $mechant[$id]["EV"];
    $taille = $mechant[$id]["gros"];

    if ($evtotale >= $arrondit && $evtotale <= $evmaxigroup){
      $nombre = 0;
    }else{
      $nombre = 1;
    }


  }while(in_array($id,$repertoire) || $nombre === 1 );

  $taille = $mechant[$id]["gros"];
  if ($mechant[$id]["gros"] === "Base"){
    do{
      $nbmechant = rand(1,$randtaille);
      $evtotale = $mechant[$id]["EV"] * $nbmechant;
      }while($evtotale > $evgroupe);
  }elseif($mechant[$id]["gros"] === "Horde"){ 
    do{   
      $nbmechant = rand(2,$randtaille);
      $evtotale = $mechant[$id]["EV"] * $nbmechant;
    }while($evtotale > $evgroupe); 
  }elseif($mechant[$id]["gros"] === "Mini Boss"){  
    do{    
      $nbmechant = 1;       
      $evtotale = $mechant[$id]["EV"] * $nbmechant;  
    }while($evtotale > $evgroupe);
  }elseif($mechant[$id]["gros"] === "Boss"){   
    do{    
      $nbmechant = 1;     
      $evtotale = $mechant[$id]["EV"] * $nbmechant;   
    }while($evtotale > $evgroupe);  
  };
};

if ($a <> 0){

  if (in_array("Boss",$taillegros) and count($miniboss) == 3){
    do{
    $id = rand(0,8);
    $evtotale = $mechant[$id]["EV"];
    $taille = $mechant[$id]["gros"];
    $groupe1 = $mechant[$id]["Groupe1"];
    $groupe2 = $mechant[$id]["Groupe2"];
    $groupe3 = $mechant[$id]["Groupe3"];

    if ($groupe1 == "" && $groupe2 == "" && $groupe3 ==""){
      $existe = 0;
    }elseif($groupe1 <> "" && (in_array($groupe1, $recapgroupe1) || in_array($groupe1, $recapgroupe2)|| in_array($groupe1, $recapgroupe3))){
      $existe = 0;
    }elseif($groupe2 <> "" && (in_array($groupe2, $recapgroupe1) || in_array($groupe2, $recapgroupe2)|| in_array($groupe2, $recapgroupe3))){
      $existe = 0;
    }elseif($groupe3 <> "" && (in_array($groupe3, $recapgroupe1) || in_array($groupe3, $recapgroupe2)|| in_array($groupe3, $recapgroupe3))){
      $existe = 0;
    }else{
      $existe = 1;
    }

    if ($evtotale >= $arrondit && $evtotale <= $evmaxigroup){
      $nombre = 0;
    }else{
      $nombre = 1;
    }

    if (!in_array($id, $info)){
      array_push ($info, $id);
      if(count($info) == 8){
      break 2;
    }
  }
  }while(in_array($id,$repertoire) || $taille === "Boss" || $taille === "Mini Boss" || $existe === 1 || $nombre === 1);

} elseif(count($miniboss) == 3){
  do{
    $id = rand(0,8);
    $evtotale = $mechant[$id]["EV"];
    $taille = $mechant[$id]["gros"];
    $groupe1 = $mechant[$id]["Groupe1"];
    $groupe2 = $mechant[$id]["Groupe2"];
    $groupe3 = $mechant[$id]["Groupe3"];

    if ($groupe1 == "" && $groupe2 == "" && $groupe3 == ""){
      $existe = 0;
    }elseif($groupe1 <> "" && (in_array($groupe1, $recapgroupe1) || in_array($groupe1, $recapgroupe2)|| in_array($groupe1, $recapgroupe3))){
      $existe = 0;
    }elseif($groupe2 <> "" && (in_array($groupe2, $recapgroupe1) || in_array($groupe2, $recapgroupe2)|| in_array($groupe2, $recapgroupe3))){
      $existe = 0;
    }elseif($groupe3 <> "" && (in_array($groupe3, $recapgroupe1) || in_array($groupe3, $recapgroupe2)|| in_array($groupe3, $recapgroupe3))){
      $existe = 0;
    }elseif($recapgroupe1[0] == "" && $recapgroupe2[0] == "" && $recapgroupe3[0] == ""){
      $existe = 0;
    }else{
      $existe = 1;
    }

    if ($evtotale >= $arrondit && $evtotale <= $evmaxigroup){
      $nombre = 0;
    }else{
      $nombre = 1;
    }


    if (!in_array($id, $info)){
      array_push ($info, $id);
      if(count($info) == 8){
      break 2;
    }
  }
  }while(in_array($id,$repertoire)|| $taille === "Mini Boss" || $existe === 1 || $nombre === 1); 

}elseif (in_array("Boss",$taillegros)){
  do{
  $id = rand(0,8);
  $evtotale = $mechant[$id]["EV"];
  $taille = $mechant[$id]["gros"];
  $groupe1 = $mechant[$id]["Groupe1"];
  $groupe2 = $mechant[$id]["Groupe2"];
  $groupe3 = $mechant[$id]["Groupe3"];

  if ($groupe1 == "" && $groupe2 == "" && $groupe3 ==""){
    $existe = 0;
  }elseif($groupe1 <> "" && (in_array($groupe1, $recapgroupe1) || in_array($groupe1, $recapgroupe2)|| in_array($groupe1, $recapgroupe3))){
    $existe = 0;
  }elseif($groupe2 <> "" && (in_array($groupe2, $recapgroupe1) || in_array($groupe2, $recapgroupe2)|| in_array($groupe2, $recapgroupe3))){
    $existe = 0;
  }elseif($groupe3 <> "" && (in_array($groupe3, $recapgroupe1) || in_array($groupe3, $recapgroupe2)|| in_array($groupe3, $recapgroupe3))){
    $existe = 0;
  }elseif($recapgroupe1[0] == "" && $recapgroupe2[0] == "" && $recapgroupe3[0] == ""){
    $existe = 0;
  }else{
    $existe = 1;
  }

  if ($evtotale >= $arrondit && $evtotale <= $evmaxigroup){
    $nombre = 0;
  }else{
    $nombre = 1;
  }

  if (!in_array($id, $info)){
    array_push ($info, $id);
    if(count($info) == 8){
    break 2;
  }
}
}while(in_array($id,$repertoire)|| $taille === "Boss" || $existe === 1 || $nombre === 1);

}else{
  do{
  $id = rand(0,8);
  $evtotale = $mechant[$id]["EV"];
  $taille = $mechant[$id]["gros"];
  $groupe1 = $mechant[$id]["Groupe1"];
  $groupe2 = $mechant[$id]["Groupe2"];
  $groupe3 = $mechant[$id]["Groupe3"];

    if ($groupe1 == "" && $groupe2 == "" && $groupe3 ==""){
      $existe = 0;
    }elseif($groupe1 <> "" && (in_array($groupe1, $recapgroupe1) || in_array($groupe1, $recapgroupe2)|| in_array($groupe1, $recapgroupe3))){
      $existe = 0;
    }elseif($groupe2 <> "" && (in_array($groupe2, $recapgroupe1) || in_array($groupe2, $recapgroupe2)|| in_array($groupe2, $recapgroupe3))){
      $existe = 0;
    }elseif($groupe3 <> "" && (in_array($groupe3, $recapgroupe1) || in_array($groupe3, $recapgroupe2)|| in_array($groupe3, $recapgroupe3))){
      $existe = 0;
    }else{
      $existe = 1;
    }

    if ($evtotale >= $arrondit && $evtotale <= $evmaxigroup){
      $nombre = 0;
    }else{
      $nombre = 1;
    }


  if (!in_array($id, $info)){
    array_push ($info, $id);
    if(count($info) == 8){
    break 2;
  }
}

}while(in_array($id,$repertoire) ||$existe === 1 || $nombre === 1);
};
  $taille = $mechant[$id]["gros"];
  if ($mechant[$id]["gros"] === "Base"){
      do{
         $nbmechant = rand(3,$monstrerestant);
         $evtotale = $mechant[$id]["EV"] * $nbmechant;
      }while($evtotale > $evgroupe);
  }elseif($mechant[$id]["gros"] === "Horde"){
      do{  
        $nbmechant = rand(5,$monstrerestant);
        $evtotale = $mechant[$id]["EV"] * $nbmechant;
      }while($evtotale > $evgroupe); 
  }elseif($mechant[$id]["gros"] === "Mini Boss"){  
      do{    
          $nbmechant = rand(1,3);     
          $evtotale = $mechant[$id]["EV"] * $nbmechant;  
      }while($evtotale > $evgroupe);
  }elseif($mechant[$id]["gros"] === "Boss"){   
      do{    
          $nbmechant = 1;     
          $evtotale = $mechant[$id]["EV"] * $nbmechant;   
      }while($evtotale > $evgroupe);  
  };
};

 array_push ($recap, $id);
 array_push ($repertoire, $id);
 array_push ($taillegros, $mechant[$id]["gros"]);
 array_push ($recapgroupe1, $mechant[$id]["Groupe1"]);
 array_push ($recapgroupe2, $mechant[$id]["Groupe2"]);
 array_push ($recapgroupe3, $mechant[$id]["Groupe3"]);
 array_push ($miniboss, $id)


$evgroupe = $evgroupe - $evtotale;

$nom = $mechant[$id]["nom"];
$ev = $mechant[$id]["EV"];
$taille = $mechant[$id]["gros"];
$groupe1 = $mechant[$id]["Groupe1"];
$groupe2 = $mechant[$id]["Groupe2"];
$groupe3 = $mechant[$id]["Groupe3"];

$recap[$a] = [
  "id"=> $id,
  "nom" => $nom,
  "numero" => $id,
  "taille" => $taille,
  "ev" => $ev,
  "groupe1" => $groupe1,
  "groupe2" => $groupe2,
  "groupe3" => $groupe3,
  "nombre" => $nbmechant,
  "evtotale" => $evtotale,
];

$a++;
$monstretotal = $monstretotal + $nbmechant;
$monstrerestant = $randtaille - $monstretotal;
$info = [];
$evgroupemonstre = $evgroupemonstre + $evtotale;
$evmaxigroup = $evgroupe-$evgroupemonstre;
if ($monstrerestant > 0){
$arrondit = round($evmaxigroup/$monstrerestant);
}

}while($evgroupe >= 8 && $a <= $max && $monstretotal < $randtaille);
};

print_r ($recap);

if ($evgroupemonstre <> 0){
  $evgroupemonstre = $evgroupemonstre;
}else{
  $evgroupemonstre = $evtotale;
}

if ($evgroupemonstre < 0.75*$evinitialegroupe){
echo "\n Rencontre Facile";
}elseif(0.75*$evinitialegroupe <= $evgroupemonstre && $evgroupemonstre <= $evinitialegroupe){
  echo "\n Rencontre Normale";
}elseif($evinitialegroupe < $evgroupemonstre && $evgroupemonstre <= 1.25*$evinitialegroupe){
  echo "\n rencontre Difficile";
}elseif(1.25*$evinitialegroupe < $evgroupemonstre){
  echo "\n Rencontre Mortelle";
}

  ?>