<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizare_carte'])) {
    $titlu = $_POST['titlu_carte'];
    $stare = $_POST['stare_disponibilitate'];
    
    $sql = "UPDATE carti_biblioteca SET stare_disponibilitate = ? WHERE titlu_carte = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $stare, $titlu);
    
    if ($stmt->execute()) {
        afiseazaMesaj('success', 'Disponibilitatea cărții a fost actualizată cu succes!');
    } else {
        afiseazaMesaj('error', 'Eroare la actualizare: ' . $conn->error);
    }
    $stmt->close();
}

if (isset($_GET['sterge_carti_fara_autor'])) {
    $sql = "DELETE FROM carti_biblioteca WHERE autor IS NULL OR autor = ''";
    if ($conn->query($sql) === TRUE) {
        afiseazaMesaj('success', 'Cărțile fără autor au fost șterse cu succes!');
    } else {
        afiseazaMesaj('error', 'Eroare la ștergere: ' . $conn->error);
    }
}

if (isset($_GET['sterge_carte'])) {
    $id = intval($_GET['sterge_carte']);
    $sql = "DELETE FROM carti_biblioteca WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        afiseazaMesaj('success', 'Cartea a fost ștearsă cu succes!');
    } else {
        afiseazaMesaj('error', 'Eroare la ștergere: ' . $conn->error);
    }
    $stmt->close();
}
?>
<div class="section">
    <h2><i class="fas fa-book"></i> Gestionare Cărți</h2>
    
    <h3><i class="fas fa-sync-alt"></i> Actualizare disponibilitate carte</h3>
    <form method="POST" action="index.php?pagina=carti">
        <div class="form-row">
            <div class="form-group">
                <label for="titlu_carte"><i class="fas fa-heading"></i> Titlul cărții:</label>
                <input type="text" id="titlu_carte" name="titlu_carte" required>
            </div>
            <div class="form-group">
                <label for="stare_disponibilitate"><i class="fas fa-toggle-on"></i> Stare disponibilitate:</label>
                <select id="stare_disponibilitate" name="stare_disponibilitate" required>
                    <option value="1">Disponibilă</option>
                    <option value="0">Indisponibilă</option>
                </select>
            </div>
        </div>
        <button type="submit" name="actualizare_carte" class="btn">
            <i class="fas fa-save"></i> Actualizează
        </button>
    </form>
    
    <h3><i class="fas fa-list"></i> Toate cărțile din bibliotecă</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Titlu</th>
            <th>Autor</th>
            <th>Gen</th>
            <th>An</th>
            <th>Pagini</th>
            <th>Disponibilitate</th>
            <th>Acțiuni</th>
        </tr>
        <?php
        $sql = "SELECT * FROM carti_biblioteca";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $disponibilitate = $row['stare_disponibilitate'] ? 
                    '<span class="available">Disponibilă</span>' : 
                    '<span class="unavailable">Indisponibilă</span>';
                
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td><strong>{$row['titlu_carte']}</strong></td>
                        <td>{$row['autor']}</td>
                        <td>{$row['gen_literar']}</td>
                        <td>{$row['an_publicare']}</td>
                        <td>{$row['nr_pagini']}</td>
                        <td>{$disponibilitate}</td>
                        <td>
                            <a href='index.php?pagina=carti&sterge_carte={$row['id']}' 
                               onclick='return confirmaStergere(\"Sigur doriți să ștergeți cartea \\\"{$row['titlu_carte']}\\\"?\")'
                               class='btn btn-danger' style='padding: 5px 10px; font-size: 14px;'>
                                <i class='fas fa-trash'></i> Șterge
                            </a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Nu există cărți în bibliotecă</td></tr>";
        }
        ?>
    </table>
    
    <div class="btn-group">
        <button onclick="window.location.href='index.php?pagina=adauga_carte'" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Adaugă carte nouă
        </button>
        <a href="index.php?pagina=carti&sterge_carti_fara_autor" 
           onclick="return confirmaStergere('Sigur doriți să ștergeți toate cărțile fără autor?')"
           class="btn btn-danger">
            <i class="fas fa-trash"></i> Șterge cărțile fără autor
        </a>
    </div>
    
    <h3><i class="fas fa-search"></i> Interogări speciale</h3>
    
    <div style="margin-bottom: 30px;">
        <h4><i class="fas fa-robot"></i> Cărți științifico-fantastice (SF)</h4>
        <table>
            <tr>
                <th>Titlu</th>
                <th>Autor</th>
                <th>An</th>
                <th>Pagini</th>
            </tr>
            <?php
            $sql = "SELECT titlu_carte, autor, an_publicare, nr_pagini FROM carti_biblioteca WHERE gen_literar = 'SF'";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['titlu_carte']}</td>
                            <td>{$row['autor']}</td>
                            <td>{$row['an_publicare']}</td>
                            <td>{$row['nr_pagini']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nu există cărți SF</td></tr>";
            }
            ?>
        </table>
    </div>
    
    <div style="margin-bottom: 30px;">
        <h4><i class="fas fa-calendar-check"></i> Cărți publicate după 2010</h4>
        <table>
            <tr>
                <th>Titlu</th>
                <th>Autor</th>
                <th>An</th>
                <th>Gen</th>
            </tr>
            <?php
            $sql = "SELECT titlu_carte, autor, an_publicare, gen_literar FROM carti_biblioteca WHERE an_publicare > 2010";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['titlu_carte']}</td>
                            <td>{$row['autor']}</td>
                            <td>{$row['an_publicare']}</td>
                            <td>{$row['gen_literar']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nu există cărți publicate după 2010</td></tr>";
            }
            ?>
        </table>
    </div>
    
    <div>
        <h4><i class="fas fa-book-open"></i> Cărți cu peste 250 de pagini (disponibile)</h4>
        <table>
            <tr>
                <th>Titlu</th>
                <th>Autor</th>
                <th>Pagini</th>
                <th>Gen</th>
            </tr>
            <?php
            $sql = "SELECT titlu_carte, autor, nr_pagini, gen_literar FROM carti_biblioteca 
                    WHERE nr_pagini > 250 AND stare_disponibilitate = 1";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['titlu_carte']}</td>
                            <td>{$row['autor']}</td>
                            <td>{$row['nr_pagini']}</td>
                            <td>{$row['gen_literar']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nu există cărți cu peste 250 de pagini disponibile</td></tr>";
            }
            ?>
        </table>
    </div>
</div>