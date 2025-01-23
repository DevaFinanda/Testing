<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Include file koneksi database
include 'functions.php';

try {
    $pdo = pdo_connect();
    $stmt = $pdo->prepare('SELECT * FROM contacts');
    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error retrieving data: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Contacts</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #ff7eb3, #65b0ff, #85ffbd);
            background-size: 300% 300%;
            animation: newRgbMotion 8s infinite;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 1000px;
            animation: fadeIn 1s ease-in-out;
            overflow: hidden;
            height: auto;
        }

        .title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2c3e50;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #34495e;
            color: white;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .create-contact, .btn-logout {
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .create-contact {
            background-color: #3498db;
        }

        .create-contact:hover {
            background-color: #2980b9;
        }

        .btn-logout {
            background-color: #e74c3c;
            border: none;
            cursor: pointer;
        }

        .btn-logout:hover {
            background-color: #c0392b;
        }

        .btn-warning {
            background-color: #f39c12;
            color: white;
            border: none;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-warning:hover {
            background-color: #e67e22;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes newRgbMotion {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Read Contacts</h1>
        <div class="btn-container">
            <a href="create.php" class="create-contact">Create Contact</a>
            <button id="logout-btn" class="btn-logout">Logout</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Title</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?= htmlspecialchars($contact['id']) ?></td>
                    <td><?= htmlspecialchars($contact['name']) ?></td>
                    <td><?= htmlspecialchars($contact['email']) ?></td>
                    <td><?= htmlspecialchars($contact['phone']) ?></td>
                    <td><?= htmlspecialchars($contact['title']) ?></td>
                    <td><?= htmlspecialchars($contact['created']) ?></td>
                    <td>
                        <a href="update.php?id=<?= $contact['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $contact['id'] ?>">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Konfirmasi Logout
        const logoutBtn = document.getElementById('logout-btn');
        logoutBtn.addEventListener('click', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out of the session.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, log out!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'logout.php';
                }
            });
        });

        // Konfirmasi Delete
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const contactId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74c3c',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `delete.php?id=${contactId}`;
                    }
                });
            });
        });
    });
    </script>
</body>
</html>
