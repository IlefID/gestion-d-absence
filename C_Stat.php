<?php
class C_Stat
{
    function liste_absence_etudiant_par_matiere($code_etud, $code_mat, $date_D, $date_F)
    {
        require_once('config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);
        
        $sql = "SELECT f.date_jour, s.nom_seance, s.HeureDebut, s.HeureFin FROM t_ficheabsence f
        JOIN t_ficheabsenceseance fs ON (fs.codeFicheAbsence = f.codeFicheAbsence) 
        JOIN t_seance s ON (fs.code_seance = s.code_seance)
        JOIN t_ligneficheabsence lf ON (lf.codeFicheAbsence = f.codeFicheAbsence) AND lf.code_etudiant = $code_etud
        JOIN t_matiere m ON (f.code_matiere = m.code_matiere)
        WHERE f.date_jour BETWEEN '$date_D' AND '$date_F' AND m.code_matiere = $code_mat";

        $res = $mysqli->query($sql);
        $mysqli->close();

        return $res; 
    }
    public function liste_absence_etudiant($nom, $prenom, $classe, $dated, $datef)
    {
        require_once('config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);
        if ($mysqli->connect_error) {
            die('Erreur de connexion (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }
        $req = "SELECT t_matiere.nom_matiere, COUNT(t_ligneficheabsence.codeFicheAbsence) AS nombre_absences
                FROM t_ficheabsence
                JOIN t_matiere ON t_ficheabsence.code_matiere = t_matiere.code_matiere
                JOIN t_etudiant ON t_ficheabsence.code_classe = t_etudiant.code_classe
                JOIN t_ligneficheabsence ON t_ficheabsence.codeFicheAbsence = t_ligneficheabsence.codeFicheAbsence
                WHERE t_etudiant.nom = '$nom'
                AND t_etudiant.prenom = '$prenom'
                AND t_etudiant.code_classe IN (SELECT code_classe FROM t_classe WHERE nom_classe = '$classe')
                AND t_ficheabsence.date_jour BETWEEN '$dated' AND '$datef'
                GROUP BY t_matiere.code_matiere";

        $res=$mysqli->query($req);
        return $res;
        $mysqli->close();
    }
}
?>