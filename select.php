<?php declare(strict_types=1);
require_once 'db.php';
if (!isset($_SESSION['loggedin'])) {
    header('Location: logowanie.php');
    exit();
}
$subdir = $_SESSION['current_subdir'] ?? '';
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
    <section class="sekcja1 container" style="max-width: 550px;">
        <div class="card p-4 shadow-sm">
            <h4>Przesyłanie pliku na dysk MyCloud (select.php)</h4>
            <p class="text-muted">Docelowy katalog: <code>/<?php echo htmlspecialchars($_SESSION['username'] . ($subdir ? '/' . $subdir : '')); ?></code></p>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="fileToUpload" class="form-label">Select file to upload:</label>
                    <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" required>
                </div>
                <input type="submit" value="Upload" name="submit" class="btn btn-primary">
                <a href="index.php?subdir=<?php echo urlencode($subdir); ?>" class="btn btn-secondary ms-2">Anuluj</a>
            </form>
        </div>
    </section>
</main>
<?php require_once 'footer.php'; ?>
</body>
</html>