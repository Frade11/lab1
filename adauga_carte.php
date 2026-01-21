<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adauga_carte'])) {
    $titlu_carte = $_POST['titlu_carte'];
    $autor = $_POST['autor'];
    $gen_literar = $_POST['gen_literar'];
    $an_publicare = $_POST['an_publicare'];
    $nr_pagini = $_POST['nr_pagini'];
    $descriere = $_POST['descriere'];
    $stare_disponibilitate = isset($_POST['stare_disponibilitate']) ? 1 : 0;
    
    $erori = [];
    if (empty($titlu_carte)) $erori[] = "Titlul cărții este obligatoriu.";
    if (empty($autor)) $erori[] = "Autorul este obligatoriu.";
    if ($an_publicare > date('Y')) $erori[] = "Anul publicării nu poate fi în viitor.";
    
    if (empty($erori)) {
        $sql = "INSERT INTO carti_biblioteca (titlu_carte, autor, gen_literar, an_publicare, nr_pagini, descriere, stare_disponibilitate) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiisi", $titlu_carte, $autor, $gen_literar, $an_publicare, $nr_pagini, $descriere, $stare_disponibilitate);
        
        if ($stmt->execute()) {
            afiseazaMesaj('success', 'Cartea a fost adăugată cu succes!');
            
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
    <h2><i class="fas fa-plus-circle"></i> Adaugă carte nouă</h2>
    
    <form method="POST" action="index.php?pagina=adauga_carte">
        <div class="form-row">
            <div class="form-group">
                <label for="titlu_carte"><i class="fas fa-heading"></i> Titlul cărții *</label>
                <input type="text" id="titlu_carte" name="titlu_carte" 
                       value="<?php echo isset($_POST['titlu_carte']) ? htmlspecialchars($_POST['titlu_carte']) : ''; ?>"
                       required placeholder="Introduceți titlul cărții">
            </div>
            <div class="form-group">
                <label for="autor"><i class="fas fa-user-edit"></i> Autor *</label>
                <input type="text" id="autor" name="autor" 
                       value="<?php echo isset($_POST['autor']) ? htmlspecialchars($_POST['autor']) : ''; ?>"
                       required placeholder="Numele autorului">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="gen_literar"><i class="fas fa-tags"></i> Gen literar</label>
                <select id="gen_literar" name="gen_literar">
                    <option value="">Selectați genul</option>
                    <option value="SF" <?php echo (isset($_POST['gen_literar']) && $_POST['gen_literar'] == 'SF') ? 'selected' : ''; ?>>SF</option>
                    <option value="Roman" <?php echo (isset($_POST['gen_literar']) && $_POST['gen_literar'] == 'Roman') ? 'selected' : ''; ?>>Roman</option>
                    <option value="Poveste" <?php echo (isset($_POST['gen_literar']) && $_POST['gen_literar'] == 'Poveste') ? 'selected' : ''; ?>>Poveste</option>
                    <option value="Poezie" <?php echo (isset($_POST['gen_literar']) && $_POST['gen_literar'] == 'Poezie') ? 'selected' : ''; ?>>Poezie</option>
                    <option value="Dramă" <?php echo (isset($_POST['gen_literar']) && $_POST['gen_literar'] == 'Dramă') ? 'selected' : ''; ?>>Dramă</option>
                    <option value="Biografie" <?php echo (isset($_POST['gen_literar']) && $_POST['gen_literar'] == 'Biografie') ? 'selected' : ''; ?>>Biografie</option>
                    <option value="Istorie" <?php echo (isset($_POST['gen_literar']) && $_POST['gen_literar'] == 'Istorie') ? 'selected' : ''; ?>>Istorie</option>
                    <option value="Thriller" <?php echo (isset($_POST['gen_literar']) && $_POST['gen_literar'] == 'Thriller') ? 'selected' : ''; ?>>Thriller</option>
                    <option value="Fantasy" <?php echo (isset($_POST['gen_literar']) && $_POST['gen_literar'] == 'Fantasy') ? 'selected' : ''; ?>>Fantasy</option>
                </select>
            </div>
            <div class="form-group">
                <label for="an_publicare"><i class="fas fa-calendar-alt"></i> Anul publicării</label>
                <input type="number" id="an_publicare" name="an_publicare" 
                       value="<?php echo isset($_POST['an_publicare']) ? $_POST['an_publicare'] : date('Y'); ?>"
                       min="1000" max="<?php echo date('Y'); ?>" 
                       placeholder="YYYY">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="nr_pagini"><i class="fas fa-file-alt"></i> Număr de pagini</label>
                <input type="number" id="nr_pagini" name="nr_pagini" 
                       value="<?php echo isset($_POST['nr_pagini']) ? $_POST['nr_pagini'] : ''; ?>"
                       min="1" placeholder="Ex: 250">
            </div>
            <div class="form-group" style="display: flex; align-items: center; padding-top: 25px;">
                <input type="checkbox" id="stare_disponibilitate" name="stare_disponibilitate" 
                       <?php echo (!isset($_POST['stare_disponibilitate']) || $_POST['stare_disponibilitate']) ? 'checked' : ''; ?>>
                <label for="stare_disponibilitate" style="margin-left: 10px; margin-bottom: 0;">
                    <i class="fas fa-check-circle"></i> Disponibilă pentru împrumut
                </label>
            </div>
        </div>
        
        <div class="form-group">
            <label for="descriere"><i class="fas fa-align-left"></i> Descriere</label>
            <textarea id="descriere" name="descriere" 
                      placeholder="Introduceți o scurtă descriere a cărții..."><?php echo isset($_POST['descriere']) ? htmlspecialchars($_POST['descriere']) : ''; ?></textarea>
        </div>
        
        <div class="btn-group">
            <button type="submit" name="adauga_carte" class="btn btn-success">
                <i class="fas fa-save"></i> Salvează cartea
            </button>
            <button type="reset" class="btn">
                <i class="fas fa-redo"></i> Resetează formularul
            </button>
            <a href="index.php?pagina=carti" class="btn">
                <i class="fas fa-arrow-left"></i> Înapoi la lista de cărți
            </a>
        </div>
        
        <p style="margin-top: 20px; color: #7f8c8d; font-size: 0.9rem;">
            <i class="fas fa-info-circle"></i> Câmpurile marcate cu * sunt obligatorii
        </p>
    </form>
</div>