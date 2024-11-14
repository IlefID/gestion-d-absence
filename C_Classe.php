<?php
    class C_Classe
    {
        public $mysqli;
        public function __construct() {
            require_once('config.php');
            $this->mysqli=new mysqli(db_host, db_user, db_password, db_database);
        }
        public function listClasse()
        {
            $sql="SELECT * FROM t_classe";
            $res=$this->mysqli->query($sql);
            return $res;
        }
        public function getNomClasse($id)
        {
            $sql="SELECT `nom_classe` FROM t_classe WHERE code_classe=$id";
            $res=$this->mysqli->query($sql);
            return $res;
        }
        public function CloseConnection()
        {
            $this->mysqli->close();
        }
    }
?>