<?php
// Include koneksi database
include 'functions.php';

$pdo = pdo_connect();

// Cek apakah ID disediakan
if (!isset($_GET['id'])) {
    die('ID not provided');
}

$id = $_GET['id'];

// Ambil data berdasarkan ID
$stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
$stmt->execute([$id]);
$contact = $stmt->fetch(PDO::FETCH_ASSOC);

// Validasi apakah kontak ditemukan
if (!$contact) {
    die('Contact not found');
}

// Cek apakah form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $title = $_POST['title'];

    // Query update
    $stmt = $pdo->prepare('UPDATE contacts SET name = ?, email = ?, phone = ?, title = ? WHERE id = ?');
    $stmt->execute([$name, $email, $phone, $title, $id]);

    // Redirect ke index.php setelah berhasil update
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #FAD961, #FF9A9E, #FF6A88);
            background-size: 300% 300%;
            animation: gradientShift 8s infinite;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            animation: fadeIn 1s ease-in-out;
        }

        h2 {
            color: #34495e;
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #27ae60;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2ecc71;
        }

        .btn-secondary {
            background-color: #bdc3c7;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #95a5a6;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Contact</h2>
        <form method="POST" action="update.php?id=<?= $id ?>">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($contact['name']) ?>" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($contact['email']) ?>" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($contact['phone']) ?>" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($contact['title']) ?>" required autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
            <a href="index.php" class="btn btn-secondary btn-block">Cancel</a>
        </form>
    </div>
</body>
</html>
