<?php
require_once('C_Enseignant.php');

$ens = new C_Enseignant('1','1','1990-01-01','1','1','1','1','1');
if (isset($_GET['edit']) && isset($_GET['id'])) {
    $enseignant_id = $_GET['id'];
    $ensignant_details = $ens->getEnseignantDetails($enseignant_id);
    if ($ensignant_details) {
?>
        <h2>Modifier  Enseignant</h2>
        <form action='liste_enseignant.php' method='post'>
            <input type='hidden' name='enseignant_id' value='<?php echo $ensignant_details["code_enseignant"]; ?>'>
            
            <label for='nom'>Nom:</label>
            <input type='text' name='edit_nom' value='<?php echo $ensignant_details["nom"]; ?>'>
            <label for='prenom'>prenom:</label>
            <input type='text' name='edit_prenom' value='<?php echo $ensignant_details["prenom"]; ?>'>
            
            <label for='date_naissance'>Date de recrutment:</label>
            <input type='text' name='edit_date_recrutement' value='<?php echo $ensignant_details["date_recrutement"]; ?>'>
            
            <label for='Tel'>Tel:</label>
            <input type='text' name='edit_tel' value='<?php echo $ensignant_details["tel"]; ?>'>
            
            <label for='mail'>Mail:</label>
            <input type='text' name='edit_mail' value='<?php echo $ensignant_details["mail"]; ?>'>
            
            <label for='adress'>Adresse:</label>
            <input type='text' name='edit_adress' value='<?php echo $ensignant_details["adress"]; ?>'>
            
            <?php

                require_once('C_Grade.php');
                $grades= new C_Grade();
                $res=$grades->listGrade();
            ?>
            <label for='nom_grade'>Nom de Grade:</label>
            <select name="edit_nom_grade" >
                <?php
                    while($row_grades=$res->fetch_assoc())
                    {
                        echo"<option value='".$row_grades['code_grade']."'>".$row_grades['nom_grade']." </option>";
                    }
                ?>
            </select>

            <?php

                require_once('C_Departement.php');
                $deps= new C_Departement();
                $res=$deps->listDepartement();
            ?>
            <label for='nom_departement'>Nom de departement:</label>
            <select name="edit_nom_departement" >
                <?php
                    while($row_deps=$res->fetch_assoc())
                    {
                        echo"<option value='".$row_deps['code_departement']."'>".$row_deps['nom_departement']." </option>";
                    }
                ?>
            </select>
            <input type='submit' name='update_enseignant' value='Update Enseignant'>
        </form>
<?php
    } else {
        echo "Enseignant not found.";
    }
} elseif (isset($_GET['delete']) && isset($_GET['id'])) {
    $ensignant_id = $_GET['id'];
    $ens->suppEnseignant($enseignant_id);
    header("Location: liste_ensignant.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_ensignant'])) {

    $ens_id = $_POST['ensignant_id'];
    $nom = $_POST['edit_nom'];
    $prenom = $_POST['edit_prenom'];
    $date_recrutement = $_POST['edit_date_recrutement'];
    $tel = $_POST['edit_tel'];
    $mail = $_POST['edit_mail'];
    $adress = $_POST['edit_adress'];
    $nom_grade = $_POST['edit_nom_grade'];
    $nom_departtement = $_POST['edit_nom_departement'];
    echo isset($row["prenom"]) ? $row["prenom"] : '';

    $ens->modifierEnseignant($ens_id,$prenom, $nom, $date_recrutement, $tel, $mail, $adress, $nom_grade, $nom_departtement);

    header("Location: liste_enseignant.php");
    exit();
}

echo "Liste des ensignant ";
$res = $ens->listEnseignant();
if ($res->num_rows > 0) {
    require_once('C_Grade.php');
    require_once('C_Departement.php');
    $grade = new C_Grade();
    $dep= new C_Departement();
    echo "<table border='1'>";
    echo "<tr><th>Prenom</th><th>nom</th><th>Date de recrutement</th><th>Tel</th><th>mail</th><th>Adresse</th><th>code ensignant</th><th>grade</th><th>departement</th><th>modifier</th><th>supprimer</th></tr>";
    while ($row = $res->fetch_assoc()) {
        $grade_result = $grade->getNomGrade($row['code_grade']);
        $nomGrade_data = $grade_result->fetch_assoc();
        $nomGrade = $nomGrade_data['nom_grade'];

        $dep_result = $dep->getNomDepartement($row['code_departement']);
        $nomDep_data = $dep_result->fetch_assoc();
        $nomDep = $nomDep_data['nom_departement'];

        echo "<tr>";
        echo "<td>" . $row["prenom"] . "</td>";
        echo "<td>" . $row["nom"] . "</td>";
        echo "<td>" . $row["date_recrutement"] . "</td>";
        echo "<td>" . $row["tel"] . "</td>";
        echo "<td>" . $row["mail"] . "</td>";
        echo "<td>" . $row["adresse"] . "</td>";
        echo "<td>" . $row["code_enseignant"] . "</td>";
        echo "<td>" . $nomGrade . "</td>";
        echo "<td>" . $nomDep . "</td>";
        echo "<td><a href='liste_enseignant.php?edit=true&id=" . $row["code_enseignant"] . "'>Modifier</a></td>";
        echo "<td><a href='liste_enseignant.php?delete=true&id=" . $row["code_enseignant"] . "'>Supprimer</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Aucun étudiant avec ce nom !";
}

?>
Ajouter un Enseignant :
<form action='' method='post'>
            <input type='hidden' name='ensignant_id'>
            
            <label for='nom'>Nom:</label>
            <input type='text' name='add_nom'>
            <label for='prenom'>prenom:</label>
            <input type='text' name='add_prenom'>
            
            <label for='date_recrutement'>date recrutement:</label>
            <input type='text' name='add_date_recrutement'>
            
            <label for='Tel'>Tel:</label>
            <input type='text' name='add_tel'>
            
            <label for='mail'>Mail:</label>
            <input type='text' name='add_mail'>
            
            <label for='adress'>Adresse:</label>
            <input type='text' name='add_adress'>
            
            
            <?php

                require_once('C_Grade.php');
                $grades= new C_Grade();
                $res=$grades->listGrade();
            ?>
            <label for='nom_grade'>Nom de Grade:</label>
            <select name="add_nom_grade" >
                <?php
                    while($row_grades=$res->fetch_assoc())
                    {
                        echo"<option value='".$row_grades['code_grade']."'>".$row_grades['nom_grade']." </option>";
                    }
                ?>
            </select>

            <?php

                require_once('C_Departement.php');
                $deps= new C_Departement();
                $res=$deps->listDepartement();
            ?>
            <label for='nom_departement'>Nom de departement:</label>
            <select name="add_nom_departement" >
                <?php
                    while($row_deps=$res->fetch_assoc())
                    {
                        echo"<option value='".$row_deps['code_departement']."'>".$row_deps['nom_departement']." </option>";
                    }
                ?>
            </select>
            <input type='submit' name='add_enseignant' value='Ajouter Enseignant'>
        </form>
<?php
        
        if(isset($_POST['add_enseignant']))
        {
            require_once('C_Grade.php');
            $grades=new C_Grade();
            $grade=$grades->listGrade();
            require_once('C_Departement.php');
            $deps=new C_Departement();
            $dep=$deps->listDepartement();
            require_once('C_Enseignant.php');
            $add_nom=$_POST['add_nom'];
            $add_prenom=$_POST['add_prenom'];
            $add_date_recrutement=$_POST['add_date_recrutement'];
            $add_tel=$_POST['add_tel'];
            $add_mail=$_POST['add_mail'];
            $add_adress=$_POST['add_adress'];
            $id_grade=$_POST['add_nom_grade'];
            $id_departement=$_POST['add_nom_departement'];
            $ens->addEnseignant( $add_nom, $add_prenom, $add_date_recrutement, $add_adress, $add_mail, $add_tel,$id_grade,$id_departement);
    
        }
?>
<?php
$grades->CloseConnection();
$deps->CloseConnection();
?>
