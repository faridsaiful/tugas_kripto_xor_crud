<?php
// create.php
$config = require __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
$pdo = get_pdo($config['db']);
$key = $config['crypto_key'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $notes = $_POST['notes'] ?? '';

    // encrypt fields
    $encName = encrypt($name, $key);
    $encEmail = encrypt($email, $key);
    $encNotes = $notes !== '' ? encrypt($notes, $key) : null;

    $stmt = $pdo->prepare('INSERT INTO contacts (name,email,phone,notes) VALUES (:name,:email,:phone,:notes)');
    $stmt->execute([
        ':name' => $encName,
        ':email' => $encEmail,
        ':phone' => $phone,
        ':notes' => $encNotes
    ]);

    header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Buat Contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            max-width: 800px;
            margin: 30px auto;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 12px;
            box-sizing: border-box;
        }

        button {
            background: #2c7be5;
            color: #fff;
            min-width: 80px;
            padding: 10px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-left: 10px;
            text-align: center;
        }

        button:hover {
            background: #ffe600ff;
        }
    </style>
</head>

<body>
    <h1>Tambah Kontak</h1>
    <form method="post">
        <label>Nama:<br><input name="name" required></label><br>
        <label>Email:<br><input name="email" type="email" required></label><br>
        <label>Phone:<br><input name="phone"></label><br>
        <label>Notes:<br><textarea name="notes"></textarea></label><br>
        <button type="submit">Simpan</button>
        <button type="button" onclick="window.location.href='index.php'" class="button">Kembali</button>
    </form>
</body>

</html>