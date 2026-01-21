<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adauga_utilizator'])) {
    $nume = $_POST['nume'];
    $prenume = $_POST['prenume'];
    $email = $_POST['email'];
    $nr_telefon = $_POST['nr_telefon'];
    $data_inregistrare = $_POST['data_inregistrare'];
    
    $erori = [];
    if (empty($nume)) $erori[] = "Numele este obligatoriu.";
    if (empty($prenume)) $erori[] = "Prenumele este obligatoriu.";
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erori[] = "Adresa de email nu este validă.";
    }
    
    if (empty($erori)) {
        $sql = "INSERT INTO utilizatori (nume, prenume, email, nr_telefon, data_inregistrare) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $nume, $prenume, $email, $nr_telefon, $data_inregistrare);
        
        if ($stmt->execute()) {
            afiseazaMesaj('success', 'Utilizator adăugat cu succes!');
            $_POST = array(); 
        } else {
            afiseazaMesaj('error', 'Eroare la adăugare: ' . $conn->error);
        }
        $stmt->close();
    } else {
        foreach ($erori as $eroare) {
            afiseazaMesaj('error', $eroare);
        }
    }
}
?>
<div class="section">
    <h2><i class="fas fa-user-plus"></i> Adaugă utilizator nou</h2>
    
    <form method="POST" action="index.php?pagina=adauga_utilizator">
        <div class="form-row">
            <div class="form-group">
                <label for="nume"><i class="fas fa-user"></i> Nume *</label>
                <input type="text" id="nume" name="nume" 
                       value="<?php echo isset($_POST['nume']) ? htmlspecialchars($_POST['nume']) : ''; ?>"
                       required placeholder="Introduceți numele">
            </div>
            <div class="form-group">
                <label for="prenume"><i class="fas fa-user"></i> Prenume *</label>
                <input type="text" id="prenume" name="prenume" 
                       value="<?php echo isset($_POST['prenume']) ? htmlspecialchars($_POST['prenume']) : ''; ?>"
                       required placeholder="Introduceți prenumele">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                       placeholder="exemplu@domeniu.md">
            </div>
            <div class="form-group">
                <label for="nr_telefon"><i class="fas fa-phone"></i> Număr de telefon</label>
                <input type="text" id="nr_telefon" name="nr_telefon" 
                       value="<?php echo isset($_POST['nr_telefon']) ? htmlspecialchars($_POST['nr_telefon']) : ''; ?>"
                       placeholder="07XXXXXXXX">
            </div>
        </div>
        
        <div class="form-group">
            <label for="data_inregistrare"><i class="fas fa-calendar-alt"></i> Data înregistrării *</label>
            <input type="date" id="data_inregistrare" name="data_inregistrare" 
                   value="<?php echo isset($_POST['data_inregistrare']) ? $_POST['data_inregistrare'] : date('Y-m-d'); ?>"
                   required>
        </div>
        
        <div class="btn-group">
            <button type="submit" name="adauga_utilizator" class="btn btn-success">
                <i class="fas fa-save"></i> Salvează utilizator
            </button>
            <button type="reset" class="btn">
                <i class="fas fa-redo"></i> Resetează formularul
            </button>
            <a href="index.php?pagina=utilizatori" class="btn">
                <i class="fas fa-arrow-left"></i> Înapoi la lista de utilizatori
            </a>
        </div>
        
        <p style="margin-top: 20px; color: #7f8c8d; font-size: 0.9rem;">
            <i class="fas fa-info-circle"></i> Câmpurile marcate cu * sunt obligatorii
        </p>
    </form>
</div>