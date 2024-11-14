<?php

require_once('C_Matiere.php');
$ma=new C_Matiere();
$res=$ma->listMatiere();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Your Page Title</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        table {
            background-color: #ffffff;
        }

        th, td {
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: #ffffff;
        }

        .btn {
            padding: 5px 10px;
            margin: 2px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>
<body>

<div class="container">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Code</th>
            <th>Nom Matiere</th>
            <th>nbHerCoursParSemaine</th>
            <th>nbHerTdParSemaine</th>
            <th>nbHerTpParSemaine</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row=$res->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['code_matiere']; ?></td>
                <td><?php echo $row['nom_matiere']; ?></td>
                <td><?php echo $row['NbreHeureCoursParSemaine']; ?></td>
                <td><?php echo $row['NbreHeureTDParSemaine']; ?></td>
                <td><?php echo $row['NbreHeureTPParSemaine']; ?></td>
                <td>
                    <a class="btn btn-primary" href="modifier_matiere.php?code=<?php echo $row['code_matiere']; ?>">Modifier</a>
                    <a class="btn btn-danger" href="supprimer.php?code=<?php echo $row['code_matiere']; ?>">Supprimer</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>

