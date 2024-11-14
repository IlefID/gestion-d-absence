<html>
<head>
<title>liste des absences </title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<style>
   h1
    {
        color: cyan;
    }
    
    label {
            color: #007bff;
        }
</style>
</head>
<body class="bg-light">
    <div class="container mt-5">
    <form name="f1" method="post" action="detail_absence.php" >

<fieldset >
    <h1 class="text-center" >Liste des absences</h1>
    <table class="mx-auto">
        <tr>
            <td>
                <label name="dateD">Date de debut:</label></td>
                <td><input type="date" name="dated" id="dated"  required  class="form-control" aria-label="Date de debut">
            </td>
            <td>
               <label name="dateF">Date de Fin:</label></td>
               <td> <input type="date" name="datef" id="datef" required class="form-control" aria-label="Date de fin">
            </td>
        </tr>
        <tr>
            <td>
                <label name="classe">Classe:</label></td>
                <td>
                <?php 
                require_once('config.php');
                $mysqli=new mysqli(db_host,db_user,db_password,db_database);
                if(!$mysqli)
                {
                    die("Erreur de connexion a la base de donnees :". mysqli_connect_error());
                }
                $req="SELECT nom_classe FROM t_classe ";
                $res=mysqli_query($mysqli,$req);
                $resultat=array();
                while($row = mysqli_fetch_assoc($res))
                {
                    $resultat[] =$row['nom_classe'];
                }
                echo'<select name="nomclasse" required class="form-select" aria-label="Disabled select example" >';
                echo'<option value="choisir le nom de classe"selected>choisir une classe</option>';
                foreach($resultat as $value)
                {
                    echo'<option value="'.$value.'">'.$value.'</option>';
                }
                echo'</select><br>';
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <label name="nometudiant">Nom Etudiant:</label>
            </td>
            <td>
                <input type="text" id="nom" name="nom"required placeholder="votre nom" class="form-control"  aria-label="Username" aria-describedby="addon-wrapping">
            </td>
            <td>
            <label name="prenometudiant">Prenom Etudiant:</label>
            </td>
            <td>
                <input type="text" id="prenom" name="prenom"required placeholder="votre prenom" class="form-control"  aria-label="Username" aria-describedby="addon-wrapping">
            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td>

            </td>
            <td>
        
            </td>
            <td>
                <input type="submit" value="Recherche" class="btn btn-outline-info">
            </td>        
    </table>
</fieldset>
</form>



    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

