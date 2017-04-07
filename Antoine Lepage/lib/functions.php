<?php
function restore($element)
{
  if(isset($_POST[$element])){
    echo 'value="' . $_POST[$element] . '"';
  }
}

function restoreChecked($element, $value)
{
  if(isset($_POST[$element])){
    if(!is_array($_POST[$element])){
      if($_POST[$element] == $value){
        echo 'checked = "checked"';
      }
    }
    else{
      if(in_array($value, $_POST[$element])){
        echo 'checked = "checked"';
      }
    }
  }
}

function restoreSelected($element, $value)
{
  if(isset($_POST[$element]) && $_POST[$element] == $value){
    echo 'selected';
  }
}

function restoreDescription()
{
  if(isset($_POST['description'])){
    echo $_POST['description'];
  }
}

/*
Fonction qui permet de déterminer si le formulaire est correctement complété ou s'il manque des champs
Si le formulaire n'est pas correctement complété, le tableau $erreurs sera modifié en fonction de l'erreur
Argument : Tableau $erreurs
Renvoie : Tableau $erreurs
*/
function formulaireComplete($erreurs)
{
  /*Pour le prénom, nom, mot de passe, confirmation et description, on vérifie leur présence,
      on élimine les espace(sauf pour la description) et les balises HTML */
  //Si le prénom est renseigné
  if (isset($_POST['firstName'])){
    //Elimine les espaces
    $_POST['firstName'] = str_replace(' ','',$_POST['firstName']);
    //Elimine les balises HTML
    $_POST['firstName'] = strip_tags($_POST['firstName']);
  }

  if (isset($_POST['name'])){
    $_POST['name'] = str_replace(' ','', $_POST['name']);
    $_POST['name'] = strip_tags($_POST['name']);
  }

  if (isset($_POST['password'])){
    $_POST['password'] = str_replace(' ','', $_POST['password']);
    $_POST['password'] = strip_tags($_POST['password']);
  }

  if (isset($_POST['passwordConfirmation'])){
    $_POST['passwordConfirmation'] = str_replace(' ','', $_POST['passwordConfirmation']);
    $_POST['passwordConfirmation'] = strip_tags($_POST['passwordConfirmation']);
  }

  if (isset($_POST['description'])){
    $_POST['description'] = strip_tags($_POST['description']);
  }

  if (!isset($_POST['firstName']) || !isset($_POST['name']) || !isset($_POST['password'])
      || !isset($_POST['passwordConfirmation']) || !isset($_POST['civilite']) || !isset($_POST['city'])
      || $_FILES['picture']['error'] != 0 || !isset($_POST['description'])
      || $_POST['password'] != $_POST['passwordConfirmation']){

    //Si la variable $_POST n'est pas vide, donc que le formulaire à au moins été envoyé une fois
    if(!empty($_POST))
    {
      //Si le prénom est manquant
      if(empty($_POST['firstName'])){
        $erreurs[] = 'Prénom manquant';
      }
      //Si le nom est manquant
      if(empty($_POST['name']))
      {
        $erreurs[] = 'Nom manquant';
      }
      //Si le mot de passe est manquant
      if(empty($_POST['password']))
      {
        $erreurs[] = 'Mot de passe manquant';
      }
      //Si le mot de passe est rensigné mais qu'il fait moins de 3 caractères
      else if (strlen($_POST['password']) <= 3){
        $erreurs[] = 'Mot de passe trop court';
      }
      //Si la confirmation de mot de passe est manquante
      if(empty($_POST['passwordConfirmation']))
      {
        $erreurs[] = 'Confirmation de mot de passe manquante';
      }
      //Si la civilité est manquante
      if(empty($_POST['civilite']))
      {
        $erreurs[] = 'Civilité manquante';
      }
      //Si la ville est manquante
      if(empty($_POST['city']))
      {
        $erreurs[] = 'Ville manquante';
      }
      //Si il y a eu une erreur lors de l'envoi du fichier
      if($_FILES['picture']['error'] != 0)
      {
        $erreurs[] = 'Erreur lors de l\'envoi de l\'image';
      }
      //Si la description est manquante
      if(empty($_POST['description']))
      {
        $erreurs[] = 'Description manquante';
      }
      //Si le mot de passe ne correspond pas à sa confirmation
      if($_POST['password'] != $_POST['passwordConfirmation'])
      {
        $erreurs[] = 'Mot de passe différent de la confirmation';
      }
    }
  }
  return $erreurs;
}
?>
