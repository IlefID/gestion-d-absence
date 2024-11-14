<?php
    class C_Grade
    {
        public $mysqli;
        public function __construct() {
            require_once('config.php');
            $this->mysqli=new mysqli(db_host, db_user, db_password, db_database);
        }
        public function listGrade()
        {
            $sql="SELECT * FROM t_grade";
            $res=$this->mysqli->query($sql);
            return $res;
        }
        public function getNomGrade($id)
        {
            $sql="SELECT `nom_grade` FROM t_grade WHERE code_grade=$id";
            $res=$this->mysqli->query($sql);
            return $res;
        }
        public function CloseConnection()
        {
            $this->mysqli->close();
        }
    }
?>