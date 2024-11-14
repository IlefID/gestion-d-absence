<?php
class C_Matiere
{
    public $code_matiere;
    public $nom_matiere;
    public $NbreHeureCoursParSemaine;
    public $NbreHeureTDParSemaine;
    public $NbreHeureTPParSemaine;

    function __construct($code_matiere=null,$nom_matiere=null, $NbreHeureCoursParSemaine=null,$NbreHeureTDParSemaine=null,$NbreHeureTPParSemaine=null) {
        $this->code_matiere=$code_matiere;
        $this->nom_matiere=$nom_matiere;
        $this->NbreHeureCoursParSemaine=$NbreHeureCoursParSemaine;
        $this->NbreHeureTDParSemaine=$NbreHeureTDParSemaine;
        $this->NbreHeureTPParSemaine=$NbreHeureTPParSemaine;
    }

    function addMatiere($cm,$n, $nbhc, $nbhtd, $nbhtp)
    {
        require_once('config.php');
        $mysqli=new mysqli(db_host,db_user,db_password, db_database);
        $sql = "INSERT INTO `t_matiere`(`code_matiere`, `nom_matiere`, `NbreHeureCoursParSemaine`, `NbreHeureTDParSemaine`, `NbreHeureTPParSemaine`) VALUES (NULL, '$n', '$nbhc', '$nbhtd', '$nbhtp')";
        $mysqli->query($sql);
        $mysqli->close();
    }

    function listMatiere()
    {
        require_once('config.php');
        $mysqli=new mysqli(db_host,db_user,db_password, db_database);
        $sql="SELECT * FROM `t_matiere`";
        $res=$mysqli->query($sql);
        return $res;
        $mysqli->close();
    }

    function modifierMatiere($cm,$n,$nbhc,$nbhtd,$nbhtp)
    {
        require_once('config.php');
        $mysqli=new mysqli(db_host,db_user,db_password, db_database);
        $sql="UPDATE `t_matiere` SET `code_matiere`='[$cm]',`nom_matiere`='[$n]',`NbreHeureCoursParSemaine`='[$nbhc]',`NbreHeureTDParSemaine`='[$nbhtd]',`NbreHeureTPParSemaine`='[$nbhtp]' WHERE 'code_matiere'=$cm";
        $mysqli->query($sql);
        $mysqli->close();
    }
    
    function suppMatiere($cm)
    {
        require_once('config.php');
        $mysqli=new mysqli(db_host,db_user,db_password, db_database);
        $sql="DELETE FROM `t_matiere` WHERE `code_matiere`=$cm";
        $mysqli->query($sql);
        $mysqli->close();
    }

    function rechercheMatiere($nom)
    {
        require_once('config.php');
        $mysqli=new mysqli(db_host, db_user, db_password, db_database);
        $sql="SELECT code_matiere FROM `t_matiere` WHERE nom_matiere='$nom'";
        $res=$mysqli->query($sql);
        return $res;
        $mysqli->close();
    }
    public function getMatiere($code)
    {
        require_once('config.php');
        $mysqli=new mysqli(db_host,db_user,db_password,db_database);
        $req="SELECT * FROM t_matiere WHERE code_matiere='$code'";
        $res=$mysqli->query($req);
        return $res;
        $mysqli->close();
    }
    public function recherche($code)
    {
        require_once('config.php');
        $mysqli=new mysqli(db_host,db_user,db_password,db_database);
        $req="SELECT count(*) FROM t_matiere WHERE code_matiere='$code'";
        $res=$mysqli->query($req);
        return $res;
        $mysqli->close();
    }
}
    
?>