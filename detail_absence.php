<?php
require_once('C_stat.php');

if ($_POST) {
    if (!empty($_POST['dated']) && !empty($_POST['datef']) && !empty($_POST['nomclasse']) && !empty($_POST['nom']) && !empty($_POST['prenom'])) {
        $com = new C_stat();
        $res=$com->liste_absence_etudiant($_POST['nom'], $_POST['prenom'], $_POST['nomclasse'], $_POST['dated'], $_POST['datef']);
        echo "<table border='2'>
            <tr>
                <td>Matiere</td>
                <td>Nombre d'absence</td>
            </tr>";
        while($row=$res->fetch_assoc())
        {
            echo"<tr><td>$row[nom_matiere]</td><td>$row[nombre_absences]</td></tr>";
        }        
        

        echo '</table>';
    } else {
        echo "Erreur";
    }
}
?>
