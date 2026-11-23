<?php declare(strict_types=1);
require_once 'db.php';
if (!isset($_SESSION['loggedin'])) {
    header('Location: logowanie.php');
    exit();
}

function ip_details(string $ip) {
    $ctx = stream_context_create(['http' => ['timeout' => 2]]);
    $json = @file_get_contents("http://ipinfo.io/{$ip}/geo", false, $ctx);
    if (!$json) return (object)['country' => '-', 'region' => '-', 'city' => '-', 'loc' => ''];
    return json_decode($json);
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $tytul_strony; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="twoj_css.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script src="twoj_js.js"></script>
</head>
<body onload="myLoadHeader()">
<div id='myHeader'></div>
<main>
    <section class="sekcja1 container-fluid">
        <h4 class="mb-3">Rejestr wizyt gości portalu (goscieportalu)</h4>
        <div class="table-responsive">
            <table id="tabelaGosci" class="table table-striped table-bordered table-sm">
                <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Data i godzina</th>
                    <th>Adres IP</th>
                    <th>Lokalizacja</th>
                    <th>Współrzędne</th>
                    <th>Mapy Google</th>
                    <th>Przeglądarka</th>
                    <th>Ekran</th>
                    <th>Okno</th>
                    <th>Kolory</th>
                    <th>Ciasteczka</th>
                    <th>Java</th>
                    <th>Język</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                // rejestr gości
$res = mysqli_query($link, "SELECT * FROM goscieportalu ORDER BY id DESC LIMIT 100");
                $geo_cache = [];
                while ($row = mysqli_fetch_assoc($res)) {
                    $ip = $row['ipaddress'];
                    if (!isset($geo_cache[$ip])) {
                        $geo_cache[$ip] = ip_details($ip);
                    }
                    $det = $geo_cache[$ip];
                    $lok = trim(($det->country ?? '-') . ', ' . ($det->region ?? '-') . ', ' . ($det->city ?? '-'), ', ');
                    $loc = $det->loc ?? '';
                    $mapa = !empty($loc) ? "<a href='https://www.google.pl/maps/place/{$loc}' target='_blank'>LINK</a>" : "-";

                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['datetime']}</td>
                        <td>" . htmlspecialchars($ip) . "</td>
                        <td>" . htmlspecialchars($lok) . "</td>
                        <td>" . htmlspecialchars($loc) . "</td>
                        <td>{$mapa}</td>
                        <td>" . htmlspecialchars($row['przegladarka'] ?? '-') . "</td>
                        <td>" . htmlspecialchars($row['ekran'] ?? '-') . "</td>
                        <td>" . htmlspecialchars($row['okno'] ?? '-') . "</td>
                        <td>" . htmlspecialchars($row['kolory'] ?? '-') . "</td>
                        <td>" . htmlspecialchars($row['ciasteczka'] ?? '-') . "</td>
                        <td>" . htmlspecialchars($row['java'] ?? '-') . "</td>
                        <td>" . htmlspecialchars($row['jezyk'] ?? '-') . "</td>
                        <td>" . htmlspecialchars($row['status'] ?? 'OK') . "</td>
                    </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<script>
    $(document).ready(function() {
        $('#tabelaGosci').DataTable({
            "order": [[ 0, "desc" ]],
            "pageLength": 10
        });
    });
</script>
<?php require_once 'footer.php'; ?>
</body>
</html>