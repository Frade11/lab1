<?php
require_once 'connection.php';

$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 'acasa';

$pagini = ['acasa', 'carti', 'adauga_carte', 'utilizatori', 'adauga_utilizator'];
if (!in_array($pagina, $pagini)) {
    $pagina = 'acasa';
}

$titlu = [
    'acasa' => 'Acasă',
    'carti' => 'Cărți',
    'adauga_carte' => 'Adaugă Carte',
    'utilizatori' => 'Utilizatori',
    'adauga_utilizator' => 'Adaugă Utilizator'
][$pagina];
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotecă Online - <?php echo $titlu; ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1><i class="fas fa-book"></i> Biblioteca Online</h1>
            <p>Sistem de gestionare pentru biblioteca digitală</p>
        </header>

        <nav class="nav-menu">
            <ul>
                <li><a href="index.php?pagina=acasa" class="<?php echo $pagina == 'acasa' ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i> Acasă
                </a></li>
                <li><a href="index.php?pagina=carti" class="<?php echo $pagina == 'carti' ? 'active' : ''; ?>">
                    <i class="fas fa-book"></i> Cărți
                </a></li>
                <li><a href="index.php?pagina=adauga_carte" class="<?php echo $pagina == 'adauga_carte' ? 'active' : ''; ?>">
                    <i class="fas fa-plus-circle"></i> Adaugă Carte
                </a></li>
                <li><a href="index.php?pagina=utilizatori" class="<?php echo $pagina == 'utilizatori' ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i> Utilizatori
                </a></li>
                <li><a href="index.php?pagina=adauga_utilizator" class="<?php echo $pagina == 'adauga_utilizator' ? 'active' : ''; ?>">
                    <i class="fas fa-user-plus"></i> Adaugă Utilizator
                </a></li>
            </ul>
        </nav>

        <main>
            <?php
            switch ($pagina) {
                case 'acasa':
                    include 'pagina_acasa.php';
                    break;
                case 'carti':
                    include 'pagina_carti.php';
                    break;
                case 'adauga_carte':
                    include 'adauga_carte.php';
                    break;
                case 'utilizatori':
                    include 'pagina_utilizatori.php';
                    break;
                case 'adauga_utilizator':
                    include 'adauga_utilizator.php';
                    break;
                default:
                    include 'pagina_acasa.php';
            }
            ?>
        </main>

        <footer class="footer">
            <p>© <?php echo date('Y'); ?> Biblioteca Online. Toate drepturile rezervate.</p>
            <p>Proiect laborator - Gestionare bază de date</p>
        </footer>
    </div>

    <script>
    function confirmaStergere(mesaj) {
        return confirm(mesaj || 'Sigur doriți să efectuați această acțiune?');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const dataInputs = document.querySelectorAll('input[type="date"]');
        const today = new Date().toISOString().split('T')[0];
        
        dataInputs.forEach(input => {
            if (!input.value) {
                input.value = today;
            }
        });
    });
    </script>
</body>
</html>

<?php
$conn->close();
?>