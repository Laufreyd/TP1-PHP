<?php
//Inclut le fichier de fonctions php
include'lib/functions.php';

//Ouvre le fichier qui contient toutes les adresses IP

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Formulaire</title>
  </head>
  <body>
    <?php
    //Déclaration du tableau qui contient les erreurs
    $erreurs = array();
    $erreurs = formulaireComplete($erreurs);

      //Si le formulaire n'est pas entièrement et correctement rempli
      if (!empty($erreurs) || empty($_POST))
      {
     ?>
    <h1>Formulaire d'inscription</h1>
    <?php
    //S'il y a au moins une erreur alors rentre dans la condition et affiche les erreurs correspondantes
      foreach ($erreurs as $erreur){
        if(isset($erreur)){
          echo '<p class="erreur">' . $erreur . '</p>';
        }
      }
     ?>
    <form action="index.php" method="post" enctype="multipart/form-data">
      <div>
        <label class="title" for="firstName">Prénom :</label>
        <input type="text" name="firstName" id="firstName" <?php restore('firstName'); ?>>
      </div>
      <div>
        <label class="title" for="name">Nom :</label>
        <input type="text" name="name" id="name" <?php restore('name'); ?>>
      </div>
      <div>
        <label class="title" for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" >
        (3 caractères minimum)
      </div>
      <div>
        <label class="title" for="passwordConfirmation">Confirmation :</label>
        <input type="password" name="passwordConfirmation" id="passwordConfirmation">
      </div>
      <div>
        <span class="title">Civilité :</span>
        <input id="civ1" type="radio" name="civilite" value="Monsieur" <?php restoreChecked('civilite', 'Monsieur'); ?>>
        <label for="civ1">Monsieur</label>
        <input id="civ2" type="radio" name="civilite" value="Madame" <?php restoreChecked('civilite', 'Madame'); ?>>
        <label for="civ2">Madame</label>
      </div>
      <div>
        <label class="title" for="city">Ville :</label>
        <select name="city" id="city">
          <option value=""></option>
          <option value="Paris" <?php restoreSelected('city', 'Paris'); ?>>
            Paris</option>
          <option value="Marseille" <?php restoreSelected('city', 'Marseille'); ?>>
            Marseille</option>
          <option value="LesVerchersSurLayon" <?php restoreSelected('city', 'LesVerchersSurLayon'); ?>>
            Les Verchers sur Layon</option>
          <option value="Other" <?php restoreSelected('city', 'Other'); ?>>
            Autre</option>
        </select>
      </div>
      <div>
        <span class="title">Sports (optionnel) :</span>
        <input id="sport1" type="checkbox" name="sport[]" value="Football" <?php restoreChecked('sport', 'Football'); ?>>
        <label for="sport1">Football</label>
        <input id="sport2" type="checkbox" name="sport[]" value="Tennis" <?php restoreChecked('sport', 'Tennis'); ?>>
        <label for="sport2">Tennis</label>
        <input id="sport3" type="checkbox" name="sport[]" value="Handball" <?php restoreChecked('sport', 'Handball'); ?>>
        <label for="sport3">Handball</label>
        <input id="sport4" type="checkbox" name="sport[]" value="Equitation" <?php restoreChecked('sport', 'Equitation'); ?>>
        <label for="sport4">Equitation</label>
        <input id="sport5" type="checkbox" name="sport[]" value="Natation" <?php restoreChecked('sport', 'Natation'); ?>>
        <label for="sport5">Natation</label>
        <input id="sport6" type="checkbox" name="sport[]" value="Golf" <?php restoreChecked('sport', 'Golf'); ?>>
        <label for="sport6">Golf</label>
      </div>
      <div>
        <label class="title" for="picture">Photo :</label>
        <input type="file" name="picture" id="picture">
      </div>
      <div>
        <label class="title" for="description">Description :</label>
        <textarea id="description" name="description" rows="8" cols="80" placeholder="Entrez une petite description"><?php restoreDescription(); ?></textarea>
      </div>
      <div>
        <input type="submit" value="Envoyer le formulaire">
      </div>
    </form>
    <?php
    }
    else  //Si le formulaire est correctement rempli
    {
      //Récupère l'adresse IP et transforme les points en underscore
      $adresse_ip = str_replace(".","_",$_SERVER["REMOTE_ADDR"]);

      //Créé un dossier avec l'adresse ip
      mkdir("./" . $adresse_ip, 0700);

      //Créé un fichier
      $fichier = fopen("./" . $adresse_ip . "/reponses.txt", "a");

      //Ecriture dans le fichier les éléments du formulaire
      foreach($_POST as $index=>$value) {
        if(!is_array($_POST[$index])) {
          fputs($fichier, $index . ":" . $value . PHP_EOL);
        }
        else {
          fputs($fichier, $index . ":" . PHP_EOL);
          foreach($_POST[$index] as $indexSecond=>$value){
              fputs($fichier, $indexSecond . ":" . $value . PHP_EOL);
          }
        }
      }

      //Mets le fuseau horaire de Paris par défaut
      date_default_timezone_set('Europe/Paris');
      //Ajouter la date et l'heure de l'enregistrement
      fputs($fichier, date('l j/F/Y H:i:s'));

      //Fermeture du fichier
      fclose($fichier);

      //Enregistre la photo définitivement
      move_uploaded_file($_FILES['picture']['tmp_name'], './' . $adresse_ip . '/' . basename($_FILES['picture']['name']));

      //Renvoie vers la page de remerciement
      header('Location: remerciement.php');
    }
    ?>
  </body>
</html>
