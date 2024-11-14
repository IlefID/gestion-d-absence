<?php
class C_Etudiant{
    public $code_etudiant;
    public $nom;
    public $prenom;
    public $date_naissance;
    public $code_classe;
    public $num_inscription;
    public $adress;
    public $mail;
    public $tel;

    public function __construct($ce=null, $n=null, $p=null, $dn=null, $cc=null, $numins=null, $a=null, $m=null, $t=null) {
        $this->code_etudiant = $ce;
        $this->nom=$n;
        $this->prenom=$p;
        $this->date_naissance=$dn;
        $this->code_classe=$cc;
        $this->num_inscription=$numins;
        $this->adress=$a;
        $this->mail=$m;
        $this->tel=$t;
    }
    function addEtudiant( $n, $p, $dn, $cc, $numins, $a, $m, $t)
    {
        require_once('config.php');
        $mysqli=new mysqli(db_host, db_user, db_password, db_database);
        $sql = "INSERT INTO `t_etudiant`(`nom`, `prenom`, `date_naissance`, `code_classe`, `num_inscription`, `adress`, `mail`, `tel`) VALUES ('$n','$p','$dn',$cc,$numins,'$a','$m',$t)";
        $mysqli->query($sql);
        $mysqli->close();
    }

    function modifierEtudiant($ce, $n, $p, $dn, $cc, $numins, $a, $m, $t)
    {
        require_once('config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);

        $checkClasseQuery = "SELECT COUNT(*) AS count FROM t_classe WHERE code_classe = '$cc'";
        $checkClasseResult = $mysqli->query($checkClasseQuery);
        $classeCount = $checkClasseResult->fetch_assoc()['count'];

        if ($classeCount > 0) {
            $sql = "UPDATE `t_etudiant` SET `nom`='$n', `prenom`='$p', `date_naissance`='$dn', `code_classe`='$cc', `num_inscription`='$numins', `adress`='$a', `mail`='$m', `tel`='$t' WHERE code_etudiant='$ce'";

            if ($mysqli->query($sql)) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $mysqli->error;
                echo "Query: $sql";
            }
        } else {
            echo "Invalid code_classe value.";
        }
        echo "Debugging: SQL Query - $sql";

        $mysqli->close();
    }

    function suppEtudiant($id)
    {
        require_once('config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);

        $sqlCheckEtudiant = "SELECT * FROM t_etudiant WHERE code_etudiant = ?";
        $stmtCheckEtudiant = $mysqli->prepare($sqlCheckEtudiant);
        $stmtCheckEtudiant->bind_param("i", $id);
        $stmtCheckEtudiant->execute();
        $result = $stmtCheckEtudiant->get_result();

        if ($result->num_rows > 0) {
            $stmtCheckEtudiant->close();

            $sqlUpdateForeignKey = "UPDATE t_ligneficheabsence SET code_etudiant = NULL WHERE code_etudiant = ?";
            $stmtUpdateForeignKey = $mysqli->prepare($sqlUpdateForeignKey);
            $stmtUpdateForeignKey->bind_param("i", $id);
            $stmtUpdateForeignKey->execute();

            $sqlDeleteEtudiant = "DELETE FROM t_etudiant WHERE code_etudiant = ?";
            $stmtDeleteEtudiant = $mysqli->prepare($sqlDeleteEtudiant);
            $stmtDeleteEtudiant->bind_param("i", $id);

            if ($stmtDeleteEtudiant->execute()) {
                echo "Record deleted successfully";
            } else {
                echo "Error deleting record: " . $stmtDeleteEtudiant->error;
                echo "Query: $sqlDeleteEtudiant";
            }
        } else {
            echo "Etudiant not found.";
        }


        echo "Debugging: SQL Query - $sqlCheckEtudiant, $sqlUpdateForeignKey, $sqlDeleteEtudiant";

        $stmtCheckEtudiant->close();
        $stmtUpdateForeignKey->close();
        $stmtDeleteEtudiant->close();
        $mysqli->close();
    }


    function getEtudiantDetails($etudiant_id)
    {
        require_once('config.php');
        $mysqli=new mysqli(db_host, db_user, db_password, db_database);
        $sql="SELECT * FROM `t_etudiant` WHERE  code_etudiant='$etudiant_id'";
        $result = $mysqli->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $result->close();
            $mysqli->close();
            return $data;
        } else {
            $mysqli->close();
            return false;
        }
    }
    function listEtudiant()
    {
        require_once('config.php');
        $mysqli=new mysqli(db_host, db_user, db_password, db_database);
        $sql = "SELECT * FROM `t_etudiant`";
        $res=$mysqli->query($sql);
        return $res;
        $mysqli->close();
    }
    function getAbsentStudentsForDay($jour)
    {
        require_once('config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);
        $jour = $mysqli->real_escape_string($jour);

        $sql = "SELECT e.code_etudiant, e.nom, e.prenom, e.num_inscription, c.nom_classe
        FROM t_etudiant e
        JOIN t_ligneficheabsence lfa ON e.code_etudiant = lfa.code_etudiant
        JOIN t_ficheabsence fa ON lfa.codeficheabsence = fa.codeficheabsence
        JOIN t_classe c ON e.code_classe = c.code_classe
        WHERE DATE(fa.date_jour) = '$jour'";
        
        $result = $mysqli->query($sql);

        $absenceEtudiant = [];

        while ($row = $result->fetch_assoc()) {
            $absenceEtudiant[] = $row;
        }

        $mysqli->close();

        return $absenceEtudiant;
    }
}

    
?>