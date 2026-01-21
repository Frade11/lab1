<?php
if (isset($_GET['sterge_utilizatori_fara_email'])) {
    $sql = "DELETE FROM utilizatori WHERE email IS NULL OR email = ''";
    if ($conn->query($sql) === TRUE) {
        afiseazaMesaj('success', 'Utilizatorii fără email au fost șterși cu succes!');
    } else {
        afiseazaMesaj('error', 'Eroare la ștergere: ' . $conn->error);
    }
}

if (isset($_GET['sterge_utilizator'])) {
    $id = intval($_GET['sterge_utilizator']);
    $sql = "DELETE FROM utilizatori WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        afiseazaMesaj('success', 'Utilizatorul a fost șters cu succes!');
    } else {
        afiseazaMesaj('error', 'Eroare la ștergere: ' . $conn->error);
    }
    $stmt->close();
}
?>
<div class="section">
    <h2><i class="fas fa-users"></i> Gestionare Utilizatori</h2>
    
    <h3><i class="fas fa-list"></i> Toți utilizatorii</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Nume</th>
            <th>Prenume</th>
            <th>Email</th>
            <th>Telefon</th>
            <th>Data înregistrării</th>
            <th>Acțiuni</th>
        </tr>
        <?php
        $sql = "SELECT * FROM utilizatori ORDER BY data_inregistrare DESC";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $email = $row['email'] ?: '<span style="color: #e74c3c; font-style: italic;">Nespecificat</span>';
                
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td><strong>{$row['nume']}</strong></td>
                        <td>{$row['prenume']}</td>
                        <td>{$email}</td>
                        <td>{$row['nr_telefon']}</td>
                        <td>{$row['data_inregistrare']}</td>
                        <td>
                            <a href='index.php?pagina=utilizatori&sterge_utilizator={$row['id']}' 
                               onclick='return confirmaStergere(\"Sigur doriți să ștergeți utilizatorul {$row['nume']} {$row['prenume']}?\")'
                               class='btn btn-danger' style='padding: 5px 10px; font-size: 14px;'>
                                <i class='fas fa-trash'></i> Șterge
                            </a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Nu există utilizatori înregistrați</td></tr>";
        }
        ?>
    </table>
    
    <div class="btn-group">
        <button onclick="window.location.href='index.php?pagina=adauga_utilizator'" class="btn btn-success">
            <i class="fas fa-user-plus"></i> Adaugă utilizator nou
        </button>
        <a href="index.php?pagina=utilizatori&sterge_utilizatori_fara_email" 
           onclick="return confirmaStergere('Sigur doriți să ștergeți toți utilizatorii fără email?')"
           class="btn btn-danger">
            <i class="fas fa-trash"></i> Șterge utilizatorii fără email
        </a>
    </div>
    
    <h3><i class="fas fa-search"></i> Interogări speciale</h3>
    
    <div style="margin-bottom: 30px;">
        <h4><i class="fas fa-user-clock"></i> Utilizatori înregistrați în ultimele 15 zile</h4>
        <table>
            <tr>
                <th>Nume</th>
                <th>Prenume</th>
                <th>Email</th>
                <th>Data înregistrării</th>
            </tr>
            <?php
            $sql = "SELECT nume, prenume, email, data_inregistrare FROM utilizatori 
                    WHERE data_inregistrare >= DATE_SUB(CURDATE(), INTERVAL 15 DAY) 
                    ORDER BY data_inregistrare DESC";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['nume']}</td>
                            <td>{$row['prenume']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['data_inregistrare']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nu există utilizatori înregistrați în ultimele 15 zile</td></tr>";
            }
            ?>
        </table>
    </div>
    
    <div>
        <h4><i class="fas fa-envelope"></i> Utilizatori cu email .md</h4>
        <table>
            <tr>
                <th>Nume</th>
                <th>Prenume</th>
                <th>Email</th>
                <th>Data înregistrării</th>
            </tr>
            <?php
            $sql = "SELECT nume, prenume, email, data_inregistrare FROM utilizatori 
                    WHERE email LIKE '%.md' 
                    ORDER BY nume, prenume";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['nume']}</td>
                            <td>{$row['prenume']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['data_inregistrare']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nu există utilizatori cu email .md</td></tr>";
            }
            ?>
        </table>
    </div>
</div>