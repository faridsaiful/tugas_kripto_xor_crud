<?php
// delete.php
$config = require __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
$pdo = get_pdo($config['db']);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id) {
    $stmt = $pdo->prepare('DELETE FROM contacts WHERE id=:id');
    $stmt->execute([':id' => $id]);
}
header('Location: index.php');
exit;
