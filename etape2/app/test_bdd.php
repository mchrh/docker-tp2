<?php
$host = 'data';
$db   = 'testdb';
$user = 'testuser';
$pass = 'testpassword';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Requête CREATE (insertion)
    $stmt = $pdo->prepare("INSERT INTO messages (content) VALUES (?)");
    $content = "Message ajouté le " . date('Y-m-d H:i:s');
    $stmt->execute([$content]);
    echo "Nouveau message ajouté.<br>";

    // Requête READ (lecture)
    $stmt = $pdo->query("SELECT * FROM messages ORDER BY RAND() LIMIT 1");
    $row = $stmt->fetch();
    if ($row) {
        echo "Message aléatoire : " . htmlspecialchars($row['content']) . "<br>";
    } else {
        echo "Aucun message trouvé.<br>";
    }

} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>