<?php
// index.php
$config = require __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
$pdo = get_pdo($config['db']);
$key = $config['crypto_key'];


// ambil semua
$stmt = $pdo->query('SELECT * FROM contacts ORDER BY id DESC');
$rows = $stmt->fetchAll();
?>
<!doctype html>
<html>

<head>
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
        }

        button {
            background: #2c7be5;
            color: #fff;
            padding: 10px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #1a5bb8;
        }

        a {
            color: #2c7be5;
        }
    </style>
    <meta charset="utf-8">
    <title>Daftar Contacts (Encrypted)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 24px auto;
            background: #f5f7fa;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th {
            background: #2c7be5;
            color: white;
            text-align: left;
        }

        td,
        th {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
        }

        tr:hover {
            background: #f1f1f1;
        }

        a {
            color: #2c7be5;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .btn {
            background: #2c7be5;
            color: #fff;
            padding: 8px 14px;
            border-radius: 4px;
            display: inline-block;
        }

        .btn:hover {
            background: #1a5bb8;
        }

        .btn-action {
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 5px;
            min-width: 80px;
        }

        .edit-btn {
            background: #007bff;
        }

        .delete-btn {
            background: #dc3545;
        }

        .btn-action:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <h1>Daftar Kontak (Encrypted fields)</h1>
    <p><button type="button" onclick="window.location.href='create.php'" class="button">Tambah Kontak</button></p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r): ?>
                <?php
                // decrypt fields (stored as base64)
                $name = decrypt($r['name'], $key);
                $email = decrypt($r['email'], $key);
                $phone = $r['phone'];
                $notes = $r['notes'] ? decrypt($r['notes'], $key) : '';
                ?>
                <tr>
                    <td><?= htmlspecialchars($r['id']) ?></td>
                    <td><?= htmlspecialchars($name) ?></td>
                    <td><?= htmlspecialchars($email) ?></td>
                    <td><?= htmlspecialchars($phone) ?></td>
                    <td><?= nl2br(htmlspecialchars($notes)) ?></td>
                    <td>
                        <button type="button"
                            onclick="window.location.href='update.php?id=<?= urlencode($r['id']) ?>'"
                            class="btn-action edit-btn">
                            Edit
                        </button>

                        <button type="button"
                            onclick="if(confirm('Hapus?')) window.location.href='delete.php?id=<?= urlencode($r['id']) ?>';"
                            class="btn-action delete-btn">
                            Hapus
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>