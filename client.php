<?php
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];

    $sql = "INSERT INTO client (nom, prenom, telephone, adresse) VALUES (:nom, :prenom, :telephone, :adresse)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':nom' => $nom, ':prenom' => $prenom, ':telephone' => $telephone, ':adresse' => $adresse]);

    header("Location: client.php");
    exit();
}

$sql = "SELECT * FROM client";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajouter un Client</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>Ajouter un Client</h2>
    <form action="client.php" method="POST">
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" required>
        </div>
        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="text" class="form-control" id="telephone" name="telephone" required>
        </div>
        <div class="form-group">
            <label for="adresse">Adresse</label>
            <input type="text" class="form-control" id="adresse" name="adresse" required>
        </div>
        <button type="submit" class="btn btn-success">Ajouter le client</button>
    </form>
    <br>
    <a href="index.php" class="btn btn-default">Retour au menu principal</a>

    <h2>Liste des Clients</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Téléphone</th>
                <th>Adresse</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?php echo htmlspecialchars($client['idclient']); ?></td>
                    <td><?php echo htmlspecialchars($client['nom']); ?></td>
                    <td><?php echo htmlspecialchars($client['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($client['telephone']); ?></td>
                    <td><?php echo htmlspecialchars($client['adresse']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
