<?php
// functions.php
function xor_stream(string $data, string $key): string
{
    $out = '';
    $keyLen = strlen($key);
    if ($keyLen === 0) {
        throw new \Exception('Key must not be empty');
    }
    for ($i = 0, $n = strlen($data); $i < $n; $i++) {
        $out .= chr(ord($data[$i]) ^ ord($key[$i % $keyLen]));
    }
    return $out;
}

function encrypt(string $plaintext, string $key): string
{
    // XOR -> raw bytes -> base64
    $cipherRaw = xor_stream($plaintext, $key);
    return base64_encode($cipherRaw);
}

function decrypt(string $cipherbase64, string $key): string
{
    $raw = base64_decode($cipherbase64, true);
    if ($raw === false) return '';
    return xor_stream($raw, $key);
}

function get_pdo(array $dbconfig): PDO
{
    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        $dbconfig['host'],
        $dbconfig['dbname'],
        $dbconfig['charset']
    );
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    return new PDO($dsn, $dbconfig['user'], $dbconfig['pass'], $opt);
}
