<?php
require_once('C_Matiere.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['code'])) {
    $code = $_POST['code'];
    $ma = new C_Matiere();
    $result = $ma->getMatiere($code);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nom = $row['nom_matiere'];
        $nbhcours = $row['NbreHeureCoursParSemaine'];
        $nbhtd = $row['NbreHeureTDParSemaine'];
        $nbhtp = $row['NbreHeureTPParSemaine'];
        if (!empty($_POST['nom'])) {
            $nom = $_POST['nom'];
        }
        if (!empty($_POST['nbhcours'])) {
            $nbhcours = $_POST['nbhcours'];
        }
        if (!empty($_POST['nbhtd'])) {
            $nbhtd = $_POST['nbhtd'];
        }
        if (!empty($_POST['nbhtp'])) {
            $nbhtp = $_POST['nbhtp'];
        }
        $ma->modifierMatiere($code, $nom, $nbhcours, $nbhtd, $nbhtp);
        header('location:liste_Matiere.php');
        exit;

    } else {
        echo "Matière non trouvée.";
        exit;
    }
} 
    
?>