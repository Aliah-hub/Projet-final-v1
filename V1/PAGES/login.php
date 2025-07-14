<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Connexion</h1>
        <form method="POST" action="">
            <label>Email :</label>
            <input type="email" name="email" required><br>
            <label>Mot de passe :</label>
            <input type="password" name="mdp" required><br>
            <button type="submit" name="connexion">Se connecter</button>
        </form>
        <a href="inscription.php">Pas de compte ? S'inscrire</a>

        <?php
        session_start();
        require_once '../includes/fonctions.php';
        if (isset($_POST['connexion'])) {
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];
            $membre = connecter_membre($email, $mdp);
            if ($membre) {
                $_SESSION['id_membre'] = $membre['id_membre'];
                $_SESSION['nom'] = $membre['nom'];
                header("Location: liste_objets.php");
                exit();
            } else {
                echo "<p>Erreur : Email ou mot de passe incorrect. Vérifiez vos informations ou inscrivez-vous.</p>";
            }
        }
        ?>
    </div>
</body>
</html>