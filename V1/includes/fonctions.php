<?php
require_once 'connexion.php';

function inscrire_membre($nom, $date_naissance, $genre, $email, $ville, $mdp) {
    global $bdd;
    // Vérifier si l'email existe déjà
    $email = mysqli_real_escape_string($bdd, $email);
    $requete_verif = "SELECT * FROM vmembre WHERE email = '$email'";
    $resultat_verif = mysqli_query($bdd, $requete_verif);
    if (mysqli_num_rows($resultat_verif) > 0) {
        echo "Erreur : Cet email est déjà utilisé.";
        return false;
    }

    // Protection contre les injections SQL
    $nom = mysqli_real_escape_string($bdd, $nom);
    $date_naissance = mysqli_real_escape_string($bdd, $date_naissance);
    $genre = mysqli_real_escape_string($bdd, $genre);
    $ville = mysqli_real_escape_string($bdd, $ville);
    $mdp = mysqli_real_escape_string($bdd, $mdp);

    $requete = "INSERT INTO vmembre (nom, date_naissance, genre, email, ville, mdp) VALUES ('$nom', '$date_naissance', '$genre', '$email', '$ville', '$mdp')";
    $resultat = mysqli_query($bdd, $requete);
    if (!$resultat) {
        echo 'Erreur SQL : ' . mysqli_error($bdd);
        return false;
    }
    return true;
}

function connecter_membre($email, $mdp) {
    global $bdd;
    $email = mysqli_real_escape_string($bdd, $email);
    $requete = "SELECT * FROM vmembre WHERE email = '$email'";
    $resultat = mysqli_query($bdd, $requete);
    if (!$resultat) {
        echo 'Erreur SQL : ' . mysqli_error($bdd);
        return false;
    }
    $membre = mysqli_fetch_assoc($resultat);
    if ($membre && password_verify($mdp, $membre['mdp'])) {
        return $membre;
    }
    return false;
}

function lister_categories() {
    global $bdd;
    $requete = "SELECT * FROM vcategorie_objet";
    $resultat = mysqli_query($bdd, $requete);
    $categories = [];
    while ($row = mysqli_fetch_assoc($resultat)) {
        $categories[] = $row;
    }
    return $categories;
}

function lister_objets($categorie_id) {
    global $bdd;
    $requete = "SELECT * FROM vue_objets";
    if ($categorie_id) {
        $categorie_id = mysqli_real_escape_string($bdd, $categorie_id);
        $requete .= " WHERE id_categorie = '$categorie_id'";
    }
    $resultat = mysqli_query($bdd, $requete);
    if (!$resultat) {
        echo 'Erreur SQL : ' . mysqli_error($bdd);
        return [];
    }
    $objets = [];
    while ($row = mysqli_fetch_assoc($resultat)) {
        $objets[] = $row;
    }
    return $objets;
}
?>