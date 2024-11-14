<?php
    class C_Departement
    {
        public $mysqli;
        public function __construct() {
            require_once('config.php');
            $this->mysqli=new mysqli(db_host, db_user, db_password, db_database);
        }
        public function listDepartement()
        {
            $sql="SELECT * FROM t_departement";
            $res=$this->mysqli->query($sql);
            return $res;
        }
        public function getNomDepartement($id)
        {
            $sql="SELECT `nom_departement` FROM t_departement WHERE code_departement=$id";
            $res=$this->mysqli->query($sql);
            return $res;
        }
        public function CloseConnection()
        {
            $this->mysqli->close();
        }
    }
?>