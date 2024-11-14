<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Liste des étudiants</title>
    <!-- Add your additional styles or custom CSS here -->
</head>

<body>
    <div class="container mt-5">
        <?php
        require_once('C_Etudiant.php');

        $etud = new C_Etudiant(null, null, null, null, null, null, null, null, null);

        if (isset($_GET['edit']) && isset($_GET['id'])) {
            $etudiant_id = $_GET['id'];
            $etudiant_details = $etud->getEtudiantDetails($etudiant_id);

            if ($etudiant_details) {
        ?>
                <h2 class="mb-4">Modifier Étudiant</h2>
                <form action='liste_etudiant.php' method='post'>

                    <input type='hidden' name='etudiant_id' value='<?php echo $etudiant_details["code_etudiant"]; ?>'>

                    <div class="form-group">
                        <label for='nom'>Nom:</label>
                        <input type='text' class="form-control" name='edit_nom' value='<?php echo $etudiant_details["nom"]; ?>'>
                    </div>
                    <div class="form-group">
                        <label for='prenom'>Prénom:</label>
                        <input type='text' class="form-control" name='edit_prenom' value='<?php echo $etudiant_details["prenom"]; ?>'>
                    </div>
                    <div class="form-group">
                        <label for='num_inscription'>Num Inscription:</label>
                        <input type='text' class="form-control" name='edit_num_inscription' value='<?php echo $etudiant_details["num_inscription"]; ?>'>
                    </div>
                    <div class="form-group">
                        <label for='Tel'>Téléphone:</label>
                        <input type='text' class="form-control" name='edit_tel' value='<?php echo $etudiant_details["tel"]; ?>'>
                    </div>
                    <div class="form-group">
                        <label for='mail'>Mail:</label>
                        <input type='text' class="form-control" name='edit_mail' value='<?php echo $etudiant_details["mail"]; ?>'>
                    </div>
                    <div class="form-group">
                        <label for='adress'>Adresse:</label>
                        <input type='text' class="form-control" name='edit_adress' value='<?php echo $etudiant_details["adress"]; ?>'>
                    </div>
                    <div class="form-group">
                        <label for='date_naissance'>Date de Naissance:</label>
                        <input type='text' class="form-control" name='edit_date_naissance' value='<?php echo $etudiant_details["date_naissance"]; ?>'>
                    </div>
                    <?php

                    require_once('C_Classe.php');
                    $classe1 = new C_Classe();
                    $res = $classe1->listClasse();
                    ?>
                    <div class="form-group">
                        <label for='nom_classe'>Nom de Classe:</label>
                        <select class="form-control" name="edit_nom_classe">
                            <?php
                            while ($row_classe = $res->fetch_assoc()) {
                                echo "<option value='" . $row_classe['code_classe'] . "'>" . $row_classe['nom_classe'] . " </option>";
                            }
                            ?>
                        </select>
                    </div>

                    <button type='submit' class="btn btn-primary" name='update_etudiant'>Mettre à Jour Étudiant</button>
                </form>
        <?php
            } else {
                echo "<p class='text-danger'>Étudiant non trouvé.</p>";
            }
        } elseif (isset($_GET['delete']) && isset($_GET['id'])) {

            $etudiant_id = $_GET['id'];
            $etud->suppEtudiant($etudiant_id);

            header("Location: liste_etudiant.php");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_etudiant'])) {
            $etudiant_id = $_POST['etudiant_id'];
            $nom = $_POST['edit_nom'];
            $prenom = $_POST['edit_prenom'];
            $num_inscription = $_POST['edit_num_inscription'];
            $tel = $_POST['edit_tel'];
            $mail = $_POST['edit_mail'];
            $adress = $_POST['edit_adress'];
            $date_naissance = $_POST['edit_date_naissance'];
            $nom_classe = $_POST['edit_nom_classe'];

            $etud->modifierEtudiant($etudiant_id, $prenom, $nom, $num_inscription, $tel, $mail, $adress, $date_naissance, $nom_classe);

            header("Location: liste_etudiant.php");
            exit();
        }
        ?>
        
        <h2 class="mt-5 mb-4">Liste des Étudiants</h2>
        <?
        $res = null;
        if ($res !== null) {
            echo "<table class='table table-bordered'>";
            echo "<thead class='thead-light'>";
            echo "<tr><th>Prenom</th><th>Nom</th><th>Num Inscription</th><th>Tel</th><th>Mail</th><th>Adresse</th><th>Code Étudiant</th><th>Date de Naissance</th><th>Classe</th><th>Modifier</th><th>Supprimer</th></tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $res->fetch_assoc()) {
                $classe_result = $classe->getNomClasse($row['code_classe']);
                $nomClasse_data = $classe_result->fetch_assoc();
                $nomClasse = $nomClasse_data['nom_classe'];

                echo "<tr>";
                echo "<td>" . $row["prenom"] . "</td>";
                echo "<td>" . $row["nom"] . "</td>";
                echo "<td>" . $row["num_inscription"] . "</td>";
                echo "<td>" . $row["tel"] . "</td>";
                echo "<td>" . $row["mail"] . "</td>";
                echo "<td>" . $row["adress"] . "</td>";
                echo "<td>" . $row["code_etudiant"] . "</td>";
                echo "<td>" . $row["date_naissance"] . "</td>";
                echo "<td>" . $nomClasse . "</td>";
                echo "<td><a href='liste_etudiant.php?edit=true&id=" . $row["code_etudiant"] . "' class='btn btn-warning btn-sm'>Modifier</a></td>";
                echo "<td><a href='liste_etudiant.php?delete=true&id=" . $row["code_etudiant"] . "' class='btn btn-danger btn-sm'>Supprimer</a></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }else {
            echo "<p class='text-info'>Aucun étudiant avec ce nom!</p>";
        }
        
        
        ?>
    </div>

    <div class="container mt-5">
        <h2 class="mb-4">Ajouter un Étudiant</h2>
        <form action='' method='post'>

            <input type='hidden' name='etudiant_id'>

            <div class="form-group">
                <label for='nom'>Nom:</label>
                <input type='text' class="form-control" name='add_nom'>
            </div>
            <div class="form-group">
                <label for='prenom'>Prénom:</label>
                <input type='text' class="form-control" name='add_prenom'>
            </div>
            <div class="form-group">
                <label for='num_inscription'>Num Inscription:</label>
                <input type='text' class="form-control" name='add_num_inscription'>
            </div>
            <div class="form-group">
                <label for='Tel'>Téléphone:</label>
                <input type='text' class="form-control" name='add_tel'>
            </div>
            <div class="form-group">
                <label for='mail'>Mail:</label>
                <input type='text' class="form-control" name='add_mail'>
            </div>
            <div class="form-group">
                <label for='adress'>Adresse:</label>
                <input type='text' class="form-control" name='add_adress'>
            </div>
            <div class="form-group">
                <label for='date_naissance'>Date de Naissance:</label>
                <input type='text' class="form-control" name='add_date_naissance'>
            </div>

            <?php
            require_once('C_Classe.php');
            $classe1 = new C_Classe();
            $res = $classe1->listClasse();
            ?>

            <div class="form-group">
                <label for='nom_classe'>Nom de Classe:</label>
                <select class="form-control" name="add_nom_classe">
                    <?php
                    while ($row_classe = $res->fetch_assoc()) {
                        echo "<option value='" . $row_classe['code_classe'] . "'>" . $row_classe['nom_classe'] . " </option>";
                    }
                    ?>
                </select>
            </div>

            <button type='submit' class="btn btn-success" name='add_etudiant'>Ajouter Étudiant</button>
        </form>
    </div>

    <?php
    
    $classe1->CloseConnection();
    ?>

    <!-- Bootstrap JS and any additional scripts go here -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
