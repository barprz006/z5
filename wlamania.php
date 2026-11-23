<?php declare(strict_types=1);
require_once 'db.php';
if (!isset($_SESSION['loggedin'])) {
    header('Location: logowanie.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title><?php echo $tytul_strony; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="twoj_css.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="twoj_js.js"></script>
</head>
<body onload="myLoadHeader()">
<div id='myHeader'></div>
<main>
    <section class="sekcja1 container">
        <h4>Rejestr prób włamań - tabela break_ins (Pkt 6.b.iv)</h4>
        <table class="table table-bordered table-striped bg-white">
            <thead class="table-danger">
            <tr>
                <th>ID</th>
                <th>Data i godzina zdarzenia</th>
                <th>Adres IP atakującego</th>
                <th>Atakowany login</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $res = mysqli_query($link, "SELECT * FROM break_ins ORDER BY id DESC");
            while ($row = mysqli_fetch_assoc($res)) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['datetime']}</td>
                    <td>" . htmlspecialchars($row['ipaddress']) . "</td>
                    <td>" . htmlspecialchars($row['username']) . "</td>
                </tr>";
            }
            ?>
            </tbody>
        </table>
    </section>
</main>
<?php require_once 'footer.php'; ?>
</body>
</html>