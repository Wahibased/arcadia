<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zoo_arcadia";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for add/update/delete
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add' || $action === 'update') {
            $type = $_POST['type'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $image = $_POST['image'];
            
            if ($action === 'update') {
                $id = $_POST['id'];
                $sql = "UPDATE services SET type='$type', title='$title', description='$description', image='$image' WHERE id=$id";
                $message = "Service mis à jour avec succès";
            } else { // action === 'add'
                $sql = "INSERT INTO services (type, title, description, image) VALUES ('$type', '$title', '$description', '$image')";
                $message = "Nouveau service ajouté avec succès";
            }

            if ($conn->query($sql) === FALSE) {
                $message = "Erreur lors de l'opération : " . $conn->error;
            }
        } elseif ($action === 'delete' && isset($_POST['id'])) {
            $id = $_POST['id'];
            $sql = "DELETE FROM services WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                $message = "Service supprimé avec succès";
            } else {
                $message = "Erreur lors de la suppression : " . $conn->error;
            }
        }
    }
}

// Fetch all services
$sql = "SELECT * FROM services";
$result = $conn->query($sql);

$services = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Services</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Nos Services au Zoo Arcadia</h1>
    </header>
    <>
        <section id="services">
            <h2>Services Disponibles</h2>
            <?php if (!empty($message)) : ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>

            <div class="service-cards">
                <?php foreach ($services as $service): ?>
                    <div class="card">
                        <img src="<?php echo $service['image']; ?>" alt="<?php echo htmlspecialchars($service['title']); ?>">
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($service['title']); ?></h3>
                            <p><?php echo htmlspecialchars($service['description']); ?></p>
                            <form method="post" action="">
                                <input type="hidden" name="id" value="<?php echo $service['id']; ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit">Supprimer</button>
                            </section> voila tout le code sau ce trouve la parti il la toujour un probleme <button onclick="editService(
                                '<?php echo $service['id']; ?>',
                                '<?php echo $service['type']; ?>',
                                '<?php echo htmlspecialchars($service['title'], ENT_QUOTES, 'UTF-8'); ?>',
                                '<?php echo htmlspecialchars($service['description'], ENT_QUOTES, 'UTF-8'); ?>',
                                '<?php echo $service['image']; ?>'
                            )">Modifier</button>      
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
                </main>

        <section id="form">
            <h2>Ajouter/Modifier un Service</h2>
            <form method="post" action="">
                <input type="hidden" name="id" id="service-id">
                <input type="hidden" name="action" id="form-action" value="add">
                <label for="type">Type:</label>
                <select name="type" id="type">
                    <option value="menu">Menu</option>
                    <option value="guide">Guide</option>
                    <option value="train">Train</option>
                </select>
                <br>
                <label for="title">Titre:</label>
                <input type="text" name="title" id="title" required>
                <br>
                <label for="description">Description:</label>
                <textarea name="description" id="description" required></textarea>
                <br>
                <label for="image">URL de l'image:</label>
                <input type="text" name="image" id="image" required>
                <br>
                <button type="submit">Enregistrer</button>
                <button type="button" onclick="clearForm()">Annuler</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Zoo Arcadia. Tous droits réservés.</p>
    </footer>

    <script>
        function editService(id, type, title, description, image) {
            document.getElementById('service-id').value = id;
            document.getElementById('type').value = type;
            document.getElementById('title').value = title;
            document.getElementById('description').value = description;
            document.getElementById('image').value = image;
            document.getElementById('form-action').value = 'update';
        }

        function clearForm() {
            document.getElementById('service-id').value = '';
            document.getElementById('type').value = 'menu';
            document.getElementById('title').value = '';
            document.getElementById('description').value = '';
            document.getElementById('image').value = '';
            document.getElementById('form-action').value = 'add';
        }
    </script>
</body>
</html>
