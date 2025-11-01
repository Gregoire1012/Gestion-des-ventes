<?php
include 'db.php';

$sqlClients = "SELECT * FROM client";
$stmtClients = $pdo->prepare($sqlClients);
$stmtClients->execute();
$clients = $stmtClients->fetchAll(PDO::FETCH_ASSOC);

$sqlVoitures = "SELECT * FROM voiture";
$stmtVoitures = $pdo->prepare($sqlVoitures);
$stmtVoitures->execute();
$voitures = $stmtVoitures->fetchAll(PDO::FETCH_ASSOC);

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idclient = $_POST['idclient'];
    $idvoiture = $_POST['idvoiture'];
    $montant = $_POST['montant'];
    $date_vente = date('Y-m-d');

    $sqlCheck = "SELECT COUNT(*) FROM vente WHERE idvoiture = :idvoiture";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute([':idvoiture' => $idvoiture]);
    $voitureExists = $stmtCheck->fetchColumn();

    if ($voitureExists > 0) {
        $errorMessage = "Erreur: Efa misy ao io Maticule io, mampidira hafa tompoko!!";
    } else {
        $sql = "INSERT INTO vente (idclient, idvoiture, montant, date_vente) VALUES (:idclient, :idvoiture, :montant, :date_vente)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':idclient' => $idclient,
            ':idvoiture' => $idvoiture,
            ':montant' => $montant,
            ':date_vente' => $date_vente
        ]);

        header("Location: vente.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enregistrer une Vente</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function showClientInfo() {
            var clientSelect = document.getElementById("idclient");
            var clientInfo = document.getElementById("client-info");
            var selectedClient = clientSelect.options[clientSelect.selectedIndex];
            var clientNom = selectedClient.getAttribute("data-nom");
            var clientPrenom = selectedClient.getAttribute("data-prenom");
            var clientTelephone = selectedClient.getAttribute("data-telephone");
            var clientAdresse = selectedClient.getAttribute("data-adresse");

            clientInfo.innerHTML = "Nom: " + clientNom + "<br>Prénom: " + clientPrenom +
                "<br>Téléphone: " + clientTelephone + "<br>Adresse: " + clientAdresse;
        }

        function showVoitureInfo() {
            var voitureSelect = document.getElementById("idvoiture");
            var voitureInfo = document.getElementById("voiture-info");
            var selectedVoiture = voitureSelect.options[voitureSelect.selectedIndex];
            var voitureMatricule = selectedVoiture.getAttribute("data-matricule");
            var voitureMarque = selectedVoiture.getAttribute("data-marque");
            var voitureCouleur = selectedVoiture.getAttribute("data-couleur");
            var voitureType = selectedVoiture.getAttribute("data-type");
            var voiturePrix = selectedVoiture.getAttribute("data-prix");

            voitureInfo.innerHTML = "Matricule: " + voitureMatricule + "<br>Marque: " + voitureMarque +
                "<br>Couleur: " + voitureCouleur + "<br>Type: " + voitureType + "<br>Prix: " + voiturePrix;

            document.getElementById("montant").value = voiturePrix;
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Enregistrer une Vente</h2>

    <?php if ($errorMessage): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($errorMessage); ?>
        </div>
    <?php endif; ?>

    <form action="vente.php" method="POST">
        <div class="form-group">
            <label for="idclient">Sélectionnez un Client</label>
            <select class="form-control" id="idclient" name="idclient" required onchange="showClientInfo()">
                <option value="" disabled selected>Sélectionnez un client</option>
                <?php foreach ($clients as $client): ?>
                    <option value="<?php echo htmlspecialchars($client['idclient']); ?>"
                        data-nom="<?php echo htmlspecialchars($client['nom']); ?>"
                        data-prenom="<?php echo htmlspecialchars($client['prenom']); ?>"
                        data-telephone="<?php echo htmlspecialchars($client['telephone']); ?>"
                        data-adresse="<?php echo htmlspecialchars($client['adresse']); ?>">
                        <?php echo htmlspecialchars($client['nom'] . " " . $client['prenom']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="client-info" class="well"></div>

        <div class="form-group">
            <label for="idvoiture">Sélectionnez une Matricule</label>
            <select class="form-control" id="idvoiture" name="idvoiture" required onchange="showVoitureInfo()">
                <option value="" disabled selected>Sélectionnez une voiture</option>
                <?php foreach ($voitures as $voiture): ?>
                    <option value="<?php echo htmlspecialchars($voiture['idvoiture']); ?>"
                        data-matricule="<?php echo htmlspecialchars($voiture['matricule']); ?>"
                        data-marque="<?php echo htmlspecialchars($voiture['marque']); ?>"
                        data-couleur="<?php echo htmlspecialchars($voiture['couleur']); ?>"
                        data-type="<?php echo htmlspecialchars($voiture['type']); ?>"
                        data-prix="<?php echo htmlspecialchars($voiture['prix']); ?>">
                        <?php echo htmlspecialchars($voiture['matricule']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="voiture-info" class="well"></div>

        <div class="form-group">
            <label for="montant">Montant (Ar)</label>
            <input type="text" class="form-control" id="montant" name="montant" readonly required>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer la Vente</button>
        <a href="index.php" class="btn btn-default">Retour au menu principal</a>
    </form>

    <hr>

    <h3>Historique des Ventes</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom du Client</th>
                <th>Prénom</th>
                <th>Téléphone</th>
                <th>Adresse</th>
                <th>Matricule de Voiture</th>
                <th>Montant (Ar)</th>
                <th>Date de Vente</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sqlVentes = "
                SELECT c.nom, c.prenom, c.telephone, c.adresse, v.matricule, ve.montant, ve.date_vente
                FROM vente ve
                JOIN client c ON ve.idclient = c.idclient
                JOIN voiture v ON ve.idvoiture = v.idvoiture";
            $stmtVentes = $pdo->prepare($sqlVentes);
            $stmtVentes->execute();
            $ventes = $stmtVentes->fetchAll(PDO::FETCH_ASSOC);

            foreach ($ventes as $vente): ?>
                <tr>
                    <td><?php echo htmlspecialchars($vente['nom']); ?></td>
                    <td><?php echo htmlspecialchars($vente['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($vente['telephone']); ?></td>
                    <td><?php echo htmlspecialchars($vente['adresse']); ?></td>
                    <td><?php echo htmlspecialchars($vente['matricule']); ?></td>
                    <td><?php echo htmlspecialchars($vente['montant']); ?></td>
                    <td><?php echo htmlspecialchars($vente['date_vente']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
