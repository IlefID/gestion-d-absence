<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['start_date'])) {
    $startOfWeek = date('Y-m-d', strtotime("this Monday", strtotime($_POST['start_date'])));
} else {
    $startOfWeek = date('Y-m-d', strtotime("this Monday"));
}

$endOfWeek = date('Y-m-d', strtotime("+6 days", strtotime($startOfWeek)));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <title>Absence de la semaine</title>
    <style>
        body {
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="post" action="" class="mb-4">
            <div class="form-row">
                <div class="col-8">
                    <input type="date" id="start_date" name="start_date" required class="form-control">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary btn-block">Afficher</button>
                </div>
            </div>
        </form>

        <h2 class="mb-3">Absences de la semaine</h2>
        <div class="alert alert-info" role="alert">
            Semaine: <?php echo $startOfWeek; ?> - <?php echo $endOfWeek; ?>
        </div>

        <?php
        $currentDate = strtotime($startOfWeek);
        require_once('C_Etudiant.php');
        $etud = new C_Etudiant();

        while ($currentDate <= strtotime($endOfWeek)) {
            $currentDay = date('Y-m-d', $currentDate);

            echo "<h3>$currentDay</h3>";

            $absenceEtudiant = $etud->getAbsentStudentsForDay($currentDay);

            if (!empty($absenceEtudiant)) {
                echo "<ul class='list-group mb-4'>";
                foreach ($absenceEtudiant as $etudiant) {
                    echo "<li class='list-group-item'>{$etudiant['prenom']} {$etudiant['nom']} ({$etudiant['num_inscription']}) - {$etudiant['nom_classe']}</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Aucune absence le $currentDay.</p>";
            }

            $currentDate = strtotime("+1 day", $currentDate);
        }
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap