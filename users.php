<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
</head>

<body>

    <h1>Liste des Utilisateurs</h1>

    <table border="1">
        <tr>
            <th>NOM</th>
            <th>PRENOM</th>
            <th>TELEPHONE</th>
            <th>Email</th>
        </tr>

        <?php foreach ($_SESSION['liste'] as $li) : ?>
            <tr>
                <td><?php echo $li['nom']; ?></td>
                <td><?php echo $li['prenom']; ?></td>
                <td><?php echo $li['telephone']; ?></td>
                <td><?php echo $li['email']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p>Bienvenue sur E-TaxiBOKKO</p>

</body>

</html>