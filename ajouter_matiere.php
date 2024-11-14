<?php
require_once('C_Matiere.php');
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $code=$_POST['code'];
    $nom=$_POST['nom'];
    $nbhcours=$_POST['nbhcours'];
    $nbhtd=$_POST['nbhtd'];
    $nbhtp=$_POST['nbhtp'];
    $ma=new C_Matiere($code,$nom,$nbhcours,$nbhtd,$nbhtp);
    $res=$ma->recherche($code);
    $row=$res->fetch_array(MYSQLI_NUM);
    if($row[0]==0)
    {
        $ma->addMatiere($code,$nom,$nbhcours,$nbhtd,$nbhtp);
        header("location:liste_matiere.php");
        exit;
    }
    else
    {
        echo"cette matiere existe deja ";
    }
}
?>
