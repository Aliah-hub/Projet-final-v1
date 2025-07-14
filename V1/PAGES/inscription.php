<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Inscription</h1>
        <form method="POST" action="">
            <label>Nom :</label>
            <input type="text" name="nom" required><br>
            <label>Date de naissance :</label>
            <input type="date" name="date_naissance" required><br>
            <label>Genre :</label>
            <input type="text" name="genre" placeholder="Homme, Femme, etc." required><br>
            <label>Email :</label>
            <input type="email" name="email" required><br>
            <label>Ville :</label>
            <input type="text" name="ville" required><br>
            <label>Mot de passe :</label>
            <input type="password" name="mdp" required><br>
            <button type="submit" name="inscription">S'inscrire</button>
        </form>
        <a href="login.php">Déjà un compte ? Se connecter</a>

        <?php
        require_once '../includes/fonctions.php';
        if (isset($_POST['inscription'])) {
            $nom = $_POST['nom'];
            $date_naissance = $_POST['date_naissance'];
            $genre = $_POST['genre'];
            $email = $_POST['email'];
            $ville = $_POST['ville'];
            $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

            $resultat = inscrire_membre($nom, $date_naissance, $genre, $email, $ville, $mdp);
            if ($resultat) {
                echo "<p>Inscription réussie ! <a href='login.php'>Connectez-vous</a></p>";
            } else {
                echo "<p>Erreur lors de l'inscription : " . mysqli_error($bdd) . "</p>";
            }
        }
        ?>
    </div>
</body>
</html>