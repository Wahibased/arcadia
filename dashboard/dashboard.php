<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard - Zoo Arcadia</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../index.html">Accueil</a></li>
                <li><a href="services.html">Services</a></li>
                <li><a href="habitats.html">Habitats</a></li>
                <li><a href="avis.html">Avis</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="dashboard.html">Dashboard</a></li>
                <li class="admin-login">
                    <a href="connexion.html"><i class="fas fa-user"></i> Connexion</a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="dashboard">
            <h2>Tableau de Bord</h2>
            <div class="dashboard-menu">
                <a href="inscription.html" class="btn">Inscription Utilisateur</a>
                <a href="compte_rendu.html" class="btn">Compte Rendu Vétérinaire</a>
                <a href="gerer_utilisateurs.html" class="btn">Gérer Utilisateurs</a>
                <a href="gerer_comptes_rendus.html" class="btn">Gérer Comptes Rendus</a>
                <a href="submit_avis.html" class="btn">Soumettre Avis Visiteur</a>
                <a href="admin_services.html" class="btn">Services</a>
            </div>
        </section>

        <section id="admin_dashboard">
            <h2>Tableau de Bord Administrateur</h2>
            <div class="filters">
                <h3>Filtres des Comptes Rendus</h3>
                <form action="admin_dashboard.php" method="get">
                    <label for="animal">Animal:</label>
                    <select id="animal" name="animal">
                        <option value="">Tous</option>
                        <?php
                        $conn = new mysqli("localhost", "root", "", "zoo_arcadia");
                        $result = $conn->query("SELECT * FROM animaux");
                        while ($row = $result->fetch_assoc()):
                        ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nom']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date">
                    
                    <button type="submit" class="btn">Filtrer</button>
                </form>
            </div>
            <div class="reports">
                <h3>Comptes Rendus</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Utilisateur</th>
                            <th>Animal</th>
                            <th>Diagnostic</th>
                            <th>Traitement</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $animal_filter = isset($_GET['animal']) ? $_GET['animal'] : '';
                        $date_filter = isset($_GET['date']) ? $_GET['date'] : '';
                        
                        $sql = "SELECT cr.*, u.nom AS utilisateur_nom, a.nom AS animal_nom FROM compte_rendu_veterinaire cr
                                JOIN utilisateurs u ON cr.utilisateur_id = u.id
                                JOIN animaux a ON cr.animal_id = a.id
                                WHERE 1=1";
                                
                        if ($animal_filter) {
                            $sql .= " AND cr.animal_id = '$animal_filter'";
                        }
                        
                        if ($date_filter) {
                            $sql .= " AND cr.date_examen = '$date_filter'";
                        }
                        
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['utilisateur_nom']; ?></td>
                            <td><?php echo $row['animal_nom']; ?></td>
                            <td><?php echo $row['diagnostic']; ?></td>
                            <td><?php echo $row['traitement']; ?></td>
                            <td><?php echo $row['date_examen']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div class="statistics">
                <h3>Statistiques des Consultations</h3>
                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Zoo Arcadia. Tous droits réservés.</p>
    </footer>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script>
    window.onload = function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title:{
                text: "Nombre de Consultations par Animal"
            },
            axisY:{
                title: "Nombre de Consultations"
            },
            data: [{
                type: "column",
                dataPoints: [
                    <?php
                    $result = $conn->query("SELECT a.nom AS animal_nom, COUNT(cr.id) AS nb_consultations FROM compte_rendu_veterinaire cr
                                            JOIN animaux a ON cr.animal_id = a.id
                                            GROUP BY cr.animal_id");
                    while ($row = $result->fetch_assoc()):
                    ?>
                    { label: "<?php echo $row['animal_nom']; ?>", y: <?php echo $row['nb_consultations']; ?> },
                    <?php endwhile; ?>
                ]
            }]
        });
        chart.render();
    }
    </script>
</body>
</html>
