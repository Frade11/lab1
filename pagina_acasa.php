<?php
$statistici = [];

$sql = "SELECT COUNT(*) as total FROM carti_biblioteca";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$statistici['carti_total'] = $row['total'];

$sql = "SELECT COUNT(*) as disponibile FROM carti_biblioteca WHERE stare_disponibilitate = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$statistici['carti_disponibile'] = $row['disponibile'];

$sql = "SELECT COUNT(*) as total FROM utilizatori";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$statistici['utilizatori_total'] = $row['total'];

$sql = "SELECT COUNT(*) as recente FROM carti_biblioteca WHERE an_publicare >= YEAR(CURDATE())";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$statistici['carti_recente'] = $row['recente'];
?>
<div class="section">
    <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
    
    <div class="stats">
        <div class="stat-card">
            <i class="fas fa-book fa-2x" style="color: #4a6491;"></i>
            <h3><?php echo $statistici['carti_total']; ?></h3>
            <p>Cărți totale</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-check-circle fa-2x" style="color: #27ae60;"></i>
            <h3><?php echo $statistici['carti_disponibile']; ?></h3>
            <p>Cărți disponibile</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-users fa-2x" style="color: #e74c3c;"></i>
            <h3><?php echo $statistici['utilizatori_total']; ?></h3>
            <p>Utilizatori înregistrați</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-calendar-alt fa-2x" style="color: #f39c12;"></i>
            <h3><?php echo $statistici['carti_recente']; ?></h3>
            <p>Cărți recente</p>
        </div>
    </div>

    <h3><i class="fas fa-history"></i> Ultimele cărți adăugate</h3>
    <table>
        <tr>
            <th>Titlu</th>
            <th>Autor</th>
            <th>Gen</th>
            <th>An</th>
            <th>Disponibilitate</th>
        </tr>
        <?php
        $sql = "SELECT * FROM carti_biblioteca ORDER BY id DESC LIMIT 5";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $disponibilitate = $row['stare_disponibilitate'] ? 
                    '<span class="available">Disponibilă</span>' : 
                    '<span class="unavailable">Indisponibilă</span>';
                
                echo "<tr>
                        <td>{$row['titlu_carte']}</td>
                        <td>{$row['autor']}</td>
                        <td>{$row['gen_literar']}</td>
                        <td>{$row['an_publicare']}</td>
                        <td>{$disponibilitate}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nu există cărți în bibliotecă</td></tr>";
        }
        ?>
    </table>

    <h3 style="margin-top: 30px;"><i class="fas fa-user-clock"></i> Utilizatori înregistrați recent</h3>
    <table>
        <tr>
            <th>Nume</th>
            <th>Prenume</th>
            <th>Email</th>
            <th>Data înregistrării</th>
        </tr>
        <?php
        $sql = "SELECT * FROM utilizatori ORDER BY data_inregistrare DESC LIMIT 5";
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
            echo "<tr><td colspan='4'>Nu există utilizatori înregistrați</td></tr>";
        }
        ?>
    </table>
</div>