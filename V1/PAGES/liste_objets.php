<?php
require_once '../includes/fonctions.php';
session_start();
if (!isset($_SESSION['id_membre'])) {
    header("Location: login.php");
    exit();
}
$categorie_id = isset($_GET['categorie']) ? $_GET['categorie'] : '';
$objets = lister_objets($categorie_id);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des objets</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Liste des objets</h1>
        <a href="deconnexion.php">Se déconnecter</a>
        <form method="GET" action="">
            <label>Filtrer par catégorie :</label>
            <select name="categorie">
                <option value="">Toutes</option>
                <?php
                $categories = lister_categories();
                foreach ($categories as $categorie) {
                    echo "<option value='{$categorie['id_categorie']}'>{$categorie['nom_categorie']}</option>";
                }
                ?>
            </select>
            <button type="submit">Filtrer</button>
        </form>
        <table>
            <tr>
                <th>Objet</th>
                <th>Catégorie</th>
                <th>Propriétaire</th>
                <th>Statut</th>
            </tr>
            <?php
            foreach ($objets as $objet) {
                echo "<tr>";
                echo "<td>{$objet['nom_objet']}</td>";
                echo "<td>{$objet['nom_categorie']}</td>";
                echo "<td>{$objet['proprietaire']}</td>";
                echo "<td>" . ($objet['date_retour'] ? "Emprunté (retour le {$objet['date_retour']})" : "Disponible") . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>