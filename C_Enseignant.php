<?php
       class C_Enseignant {
        public $code_enseignant;
        public $nom;
        public $prenom;
        public $date_recrutement;
        public $adresse;
        public $mail;
        public $tel;
        public $code_department;
        public $code_grade;

        function  __construct( $code_enseignant=null, $nom=null, $prenom=null, $date_recrutement=null, $adresse=null, $mail=null, $tel=null, $code_department=null, $code_grade=null) {
            $this->code_enseignant=$code_enseignant;
            $this->nom=$nom;
            $this->prenom=$prenom;
            $this->date_recrutement=$date_recrutement;
            $this->adresse=$adresse;
            $this->mail=$mail;
            $this->tel=$tel;
            $this->code_department=$code_department;
            $this->code_grade=$code_grade;
        }
        function addEnseignant($n,$p,$dr,$a,$m,$t,$cd,$cg)
        {
            require_once('config.php');
            $mysqli=new mysqli(db_host,db_user, db_password, db_database);
            $sql="INSERT INTO `t_enseignant` (`code_enseignant`, `nom`, `prenom`, `date_recrutement`, `adresse`, `mail`, `tel`, `code_departement`, `code_grade`) VALUES (NULL, '$n', '$p', '$dr', '$a', '$m', ',$t', '$cd', '$cg')";
            $mysqli->query($sql);
            $mysqli->close();
        }
        function listEnseignant()
        {
            require_once('config.php');
            $mysqli=new mysqli(db_host,db_user, db_password, db_database);
            $sql="SELECT * FROM t_enseignant";
            $res=$mysqli->query($sql);
            return $res;
            $mysqli->close();
        }
        function modifierEnseignant($ce,$n,$p,$dr,$a,$m,$t,$cg,$cd)
        {
            require_once('config.php');
            $mysqli=new mysqli(db_host,db_user, db_password, db_database);
            $sql="UPDATE `t_enseignant` SET `code_enseignant`='$ce', `nom`='$n', `prenom`='$p', `date_recrutement`='$dr', `adresse`='$a', `mail`='$m', `tel`='$t', `code_departement`='$cd', `code_grade`='$cg' WHERE `code_enseignant`='$ce'";
            $mysqli->query($sql);
            $mysqli->close();
        }
        function suppEnseignant($ce)
        {
            require_once('config.php');
            $mysqli=new mysqli(db_host,db_user, db_password, db_database);
            $sql="DELETE FROM `t_enseignant` WHERE code_enseignant=$ce";
            $mysqli->query($sql);
            $mysqli->close();
        }
        function rechercheEnseignant($id)
        {
            require_once('config.php');
            $mysqli=new mysqli(db_host, db_user, db_password, db_database);
            $sql="SELECT count(*) FROM `t_enseignant` WHERE code_ensegnant=$id";
            $res=$mysqli->query($sql);
            return $res;
            $mysqli->close();
        }
        function getEnseignantDetails($ens_id)
        {
            require_once('config.php');
            $mysqli=new mysqli(db_host, db_user, db_password, db_database);
            $sql="SELECT * FROM `t_enseignant` WHERE  code_enseignant='$ens_id'";
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

    }    



?>