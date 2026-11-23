<?php declare(strict_types=1);
require_once 'db.php';

$avatar_url = "https://cdn-icons-png.flaticon.com/512/149/149071.png";
$avatar_file = $_SESSION['avatar'] ?? '';
$avatar_file = trim(ltrim($avatar_file, '/\\'));

if (!empty($avatar_file) && strpos($avatar_file, 'info.svg') === false) {
    if (file_exists($avatar_file)) {
        $avatar_url = $avatar_file;
    } else {
        foreach (['z2', 'z3', 'z4', 'z5'] as $dir) {
            if (file_exists("../$dir/$avatar_file")) {
                $avatar_url = "../$dir/$avatar_file";
                break;
            }
        }
    }
}
?>
<header>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top mt-0 mb-0 ms-0 me-0 pt-0 pb-0 ps-0 pe-0">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="main_nav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">MySpotify (z6a)</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="index.php">Strona Główna (Lista)</a></li>
                                <li><a class="dropdown-item" href="select.php">Wgraj nowy utwór</a></li>
                                <li><a class="dropdown-item" href="create_playlist.php">Utwórz Playlistę</a></li>
                            </ul>
                        </li>
                    </ul>

                    <div class="d-flex ms-auto align-items-center mt-2 mt-lg-0 pb-2 pb-lg-0">
                        <div class="text-white me-3 d-flex align-items-center">
                            <img src="<?php echo htmlspecialchars($avatar_url); ?>" alt="Avatar" width="32" height="32" class="rounded-circle border border-2 border-white me-2" style="object-fit: cover; background-color: #fff;">
                            <span class="fw-bold"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Gość'); ?></span>
                        </div>
                        <?php if (isset($_SESSION['loggedin'])): ?>
                            <a href="logout.php" class="btn btn-danger btn-sm d-flex align-items-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                </svg>
                                Wyloguj
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>