<?php declare(strict_types=1);
require_once 'db.php';
if (!isset($_SESSION['loggedin'])) {
    header('Location: logowanie.php');
    exit();
}

$user_login = preg_replace('/[^a-zA-Z0-9_-]/', '', $_SESSION['username']);
if (!is_dir($user_login)) {
    @mkdir($user_login, 0777, true);
}

function getDirectorySize($dir) {
    $size = 0;
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)) as $file) {
        if ($file->isFile()) {
            $size += $file->getSize();
        }
    }
    return $size;
}

$subdir = '';
if (!empty($_GET['subdir'])) {
    $candidate = basename($_GET['subdir']);
    if ($candidate !== '.' && $candidate !== '..' && is_dir($user_login . '/' . $candidate)) {
        $subdir = $candidate;
    }
}
$_SESSION['current_subdir'] = $subdir;
$current_path = $subdir ? ($user_login . '/' . $subdir) : $user_login;

if (isset($_GET['view'])) {
    $_SESSION['cloud_view'] = ($_GET['view'] === 'simple') ? 'simple' : 'media';
}
$view_mode = $_SESSION['cloud_view'] ?? 'media';

$user_esc = mysqli_real_escape_string($link, $_SESSION['username']);
$last_break = mysqli_query($link, "SELECT * FROM break_ins WHERE username = '$user_esc' ORDER BY id DESC LIMIT 1");
$break_row = mysqli_fetch_assoc($last_break);
// widok strony
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $tytul_strony; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="twoj_css.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="twoj_js.js"></script>
    <style>
        .katalog-link {
            color: #d63384;
            text-decoration: none;
            transition: color 0.2s;
        }
        .katalog-link:hover {
            color: #a02060;
            text-decoration: underline;
        }
    </style>
</head>
<body onload="myLoadHeader()">
<div id='myHeader'><?php @include 'header.php'; ?></div>
<main>
    <section class="sekcja1 container">
        <?php if ($break_row): ?>
            <div class="alert alert-danger fw-bold shadow-sm">
                ⚠️ OSTRZEŻENIE: Odnotowano nieudane próby logowania na Twoje konto! Ostatnia blokada:
                <?php echo htmlspecialchars($break_row['datetime']); ?> z adresu IP: <?php echo htmlspecialchars($break_row['ipaddress']); ?>
            </div>
        <?php endif; ?>

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 p-3 bg-white border rounded shadow-sm">
            <div>
                <h4 class="mb-0">
                    📁 Katalog:
                    <code>
                        / <a href="index.php" class="katalog-link" title="Wróć na stronę główną dysku"><?php echo htmlspecialchars($user_login); ?></a>
                        <?php if ($subdir !== ''): ?>
                            / <?php echo htmlspecialchars($subdir); ?>
                        <?php endif; ?>
                    </code>
                </h4>
            </div>
            <div class="d-flex gap-2 align-items-center mt-2 mt-md-0">
                <?php if ($subdir !== ''): ?>
                    <a href="index.php" class="btn btn-warning btn-sm fw-bold shadow-sm">
                        Powrót na stronę główną
                    </a>
                <?php else: ?>
                    <form action="mkdir.php" method="post" class="d-flex gap-1">
                        <input type="text" name="folder_name" class="form-control form-control-sm" placeholder="Nowy podkatalog..." pattern="[a-zA-Z0-9_-]+" required>
                        <button type="submit" class="btn btn-success btn-sm shadow-sm">➕📁 Utwórz</button>
                    </form>
                <?php endif; ?>

                <a href="select.php" class="btn btn-primary btn-sm shadow-sm">
                    ⬆️📄 Upload pliku
                </a>

                <?php if ($view_mode === 'media'): ?>
                    <a href="index.php?subdir=<?php echo urlencode($subdir); ?>&view=simple" class="btn btn-outline-secondary btn-sm bg-light">Widok: Zwykła lista</a>
                <?php else: ?>
                    <a href="index.php?subdir=<?php echo urlencode($subdir); ?>&view=media" class="btn btn-outline-secondary btn-sm bg-light">Widok: Multimedia</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="table-responsive bg-white rounded shadow-sm border">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary">
                <tr>
                    <th class="ps-3 py-3">Nazwa pliku / podkatalogu</th>
                    <th class="py-3">Podgląd / Odtwarzacz</th>
                    <th class="py-3">Rozmiar</th>
                    <th class="py-3">Data utworzenia</th>
                    <th class="text-center py-3">Usuń</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $items = scandir($current_path);
                $empty = true;
                foreach ($items as $item) {
                    if ($item === '.' || $item === '..') continue;
                    $empty = false;
                    $full_path = $current_path . '/' . $item;
                    $mtime = date('Y-m-d H:i:s', filemtime($full_path));

                    if (is_dir($full_path)) {
                        $dir_size_kb = round(getDirectorySize($full_path) / 1024, 2) . ' KB';
                        echo "<tr>
                            <td class='ps-3'>
                                <a href='index.php?subdir=" . urlencode($item) . "' class='fw-bold text-decoration-none fs-5'>
                                    📁 " . htmlspecialchars($item) . "
                                </a>
                            </td>
                            <td><span class='badge bg-secondary'>Podkatalog</span></td>
                            <td>{$dir_size_kb}</td>
                            <td>{$mtime}</td>
                            <td class='text-center'>
                                <a href='usun.php?item=" . urlencode($item) . "&subdir=" . urlencode($subdir) . "' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Usunąć ten katalog wraz ze wszystkimi plikami w środku?\");'>🗑️ Usuń</a>
                            </td>
                        </tr>";
                    } else {
                        $size_kb = round(filesize($full_path) / 1024, 2) . ' KB';
                        $ext = strtolower(pathinfo($item, PATHINFO_EXTENSION));
                        $url_path = implode('/', array_map('rawurlencode', explode('/', $full_path)));

                        $preview = "-";
                        if ($view_mode === 'media') {
                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'avif'])) {
                                $preview = "<a href='{$url_path}' target='_blank'>
                                    <img src='{$url_path}' alt='" . htmlspecialchars($item) . "' style='height: 60px; object-fit: cover;' class='img-thumbnail shadow-sm'>
                                </a>";
                            } elseif ($ext === 'mp3' || $ext === 'wav' || $ext === 'ogg') {
                                $preview = "<audio controls preload='none' style='height: 35px; width: 220px;'><source src='{$url_path}'></audio>";
                            } elseif ($ext === 'mp4' || $ext === 'webm') {
                                $preview = "<video controls preload='none' style='height: 80px;'><source src='{$url_path}' type='video/mp4'></video>";
                            }
                        }

                        $download_attr = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'avif', 'mp3', 'mp4', 'pdf']) ? "target='_blank'" : "download";

                        echo "<tr>
                            <td class='ps-3'>
                                <a href='{$url_path}' {$download_attr} class='text-decoration-none'>
                                    📄 " . htmlspecialchars($item) . "
                                </a>
                                <br>
                                <a href='{$url_path}' download class='badge bg-light text-dark border text-decoration-none mt-1' title='Wymuś pobranie na dysk'>⬇️ Pobierz</a>
                            </td>
                            <td>{$preview}</td>
                            <td>{$size_kb}</td>
                            <td>{$mtime}</td>
                            <td class='text-center'>
                                <a href='usun.php?item=" . urlencode($item) . "&subdir=" . urlencode($subdir) . "' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Na pewno usunąć ten plik?\");'>🗑️ Usuń</a>
                            </td>
                        </tr>";
                    }
                }
                if ($empty) {
                    echo "<tr><td colspan='5' class='text-center text-muted py-5'>Ten folder jest pusty. Użyj przycisku 'Upload pliku' aby coś dodać.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<?php require_once 'footer.php'; ?>
</body>
</html>