<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Ventes</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>

<style>
        body {
            padding: 150px;
            background-color: #f8f9fa;
        }
        .nav .btn{
            width: 500px;
            padding: 10px;
            margin-left: 320px !important;
            margin:10px;
        }
        
    </style>

<div class="container">
    <h2 class="text-center">Gestion des Ventes de Voitures</h2>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills nav-stacked">
                <li><a href="client.php" class="btn btn-primary btn-block">Client</a></li>
                <li><a href="voiture.php" class="btn btn-primary btn-block">Voiture</a></li>
                <li><a href="vente.php" class="btn btn-primary btn-block">Vente</a></li>
            </ul>
        </div>
    </div>
 
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            var found = false;
            $('table tbody tr').filter(function() {
                var isVisible = $(this).find('td:nth-child(1)').text().toLowerCase().indexOf(value) > -1;
                $(this).toggle(isVisible);
                if (isVisible) {
                    found = true;
                }
            });

            if (found) {
                $('#noResults').hide();
            } else {
                $('#noResults').show();
            }
        });
    });
</script>

</body>
</html>
