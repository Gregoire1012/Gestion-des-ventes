<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricule = $_POST['matricule'];
    $marque = $_POST['marque'];
    $couleur = $_POST['couleur'];
    $type = $_POST['type'];
    $prix = $_POST['prix'];

    $sql = "INSERT INTO voiture (matricule, marque, couleur, type, prix) VALUES (:matricule, :marque, :couleur, :type, :prix)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':matricule' => $matricule,
        ':marque' => $marque,
        ':couleur' => $couleur,
        ':type' => $type,
        ':prix' => $prix
    ]);

    header("Location: voiture.php");
    exit();
}

$sqlVoitures = "SELECT * FROM voiture";
$stmtVoitures = $pdo->prepare($sqlVoitures);
$stmtVoitures->execute();
$voitures = $stmtVoitures->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajouter une Voiture</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>Ajouter une Nouvelle Voiture</h2>
    <form action="voiture.php" method="POST">
        <div class="form-group">
            <label for="matricule">Matricule</label>
            <input type="text" class="form-control" id="matricule" name="matricule" placeholder="Entrez la matricule" required>
        </div>

        <div class="form-group">
            <label for="marque">Marque</label>
            <input type="text" class="form-control" id="marque" name="marque" placeholder="Entrez la marque" required>
        </div>

        <div class="form-group">
            <label for="couleur">Couleur</label>
            <input type="text" class="form-control" id="couleur" name="couleur" placeholder="Entrez la couleur" required>
        </div>

        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" class="form-control" id="type" name="type" placeholder="Entrez le type" required>
        </div>

        <div class="form-group">
            <label for="prix">Prix</label>
            <input type="number" class="form-control" id="prix" name="prix" placeholder="Entrez le prix" required>
        </div>

        <button type="submit" class="btn btn-success">Ajouter la Voiture</button>
        <a href="index.php" class="btn btn-default">Retour au menu principal</a>
    </form>

    <hr>

    <h3>Liste des Voitures</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Marque</th>
                <th>Couleur</th>
                <th>Type</th>
                <th>Prix (Ar)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($voitures as $voiture): ?>
                <tr>
                    <td><?php echo htmlspecialchars($voiture['matricule']); ?></td>
                    <td><?php echo htmlspecialchars($voiture['marque']); ?></td>
                    <td><?php echo htmlspecialchars($voiture['couleur']); ?></td>
                    <td><?php echo htmlspecialchars($voiture['type']); ?></td>
                    <td><?php echo htmlspecialchars($voiture['prix']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

</body>
</html>
