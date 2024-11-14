<html>
    <form action="liste_absence_etudiant_par_matiere.php" method="post">
        Nom de l'etudiant: <input type="text" name="nom_etud"><br>
        Prenom de l'etudiant: <input type="text" name="pre_etud"><br>
        Nom de la matiere: <input type="text" name="nom_matiere"><br>
        Date de debut : <input type="text" name="date_d"><br>
        Date du fin : <input type="text" name="date_fin"><br>
        <input type="submit" name="search" value="rechercher">
    </form>
</html>
<?php
    require_once('config.php');
    require_once('C_Etudiant.php');
    require_once('C_Matiere.php');
    require_once('C_Stat.php');
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['search']))
    {
        if($_POST['nom_etud'] && $_POST['nom_matiere'] && $_POST['date_d'] && $_POST['date_fin'])
        {
            $etud=new C_Etudiant();
            $mat=new C_Matiere();
            $stat=new C_Stat();
            $nom_etud=$_POST['nom_etud'];
            $pre_etud=$_POST['pre_etud'];
            $nom_matiere=$_POST['nom_matiere'];
            $date_d=$_POST['date_d'];
            $date_f=$_POST['date_fin'];


            $code_etud_result=$etud->rechercheEtudiant($nom_etud,$pre_etud);
            $code_etud_data=$code_etud_result->fetch_assoc();
            $code_etud=$code_etud_data['code_etudiant'];

            $code_mat_result=$mat->rechercheMatiere($nom_matiere);
            $code_mat_data=$code_mat_result->fetch_assoc();
            $code_mat=$code_mat_data['code_matiere'];

            $res=$stat->liste_absence_etudiant_par_matiere($code_etud,$code_mat,$date_d,$date_f);
            echo"Matiere : ".$nom_matiere;
            if($res->num_rows>0)
            {
                echo"<table border='1'>";
                echo"<tr><th>date jour</th><th>seance</th></tr>";
                while($row=$res->fetch_assoc())
                {
                    echo"<tr>";
                    echo"<td>".$row['date_jour']."</td>";
                    echo"<td>".$row['nom_seance']."</td>";
                }
                echo"</table>";
            }
            $nb_absence=$res->num_rows;
            echo"le nombre total des absence est ".$nb_absence;

        }
    }
?>