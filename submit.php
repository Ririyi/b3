<?php
// Данные доступа к базе InfinityFree
$host = 'sql101.infinityfree.com';  // MySQL Hostname
$db   = 'if0_39759967_riyi';               // Database Name
$user = 'if0_39759967';             // Username
$pass = '5Qc1kmacyBr';         // Password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // показывать ошибки
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // возвращать ассоциативный массив
    PDO::ATTR_EMULATE_PREPARES   => false,                  // реальные prepared statements
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

$stmt = $pdo->query("SELECT DATABASE()");
$row = $stmt->fetch();
echo "Подключено к базе: " . $row['DATABASE()'];

// === Получаем данные формы ===
$fio = trim($_POST['fio'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$birth_date = $_POST['birth_date'] ?? '';
$gender = $_POST['gender'] ?? '';
$languages = $_POST['languages'] ?? [];
$biography = trim($_POST['biography'] ?? '');
$agreed = isset($_POST['agreed']) ? 1 : 0;

// === Валидация ===
$errors = [];
if (!preg_match("/^[a-zA-Zа-яА-ЯёЁ\s]+$/u", $fio) || mb_strlen($fio) > 150) {
    $errors[] = "ФИО должно содержать только буквы и пробелы (не длиннее 150 символов).";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Некорректный email.";
}
if (!in_array($gender, ['male','female'])) {
    $errors[] = "Некорректное значение поля Пол.";
}
if (empty($languages)) {
    $errors[] = "Выберите хотя бы один язык программирования.";
}

if (!empty($errors)) {
    echo "<h3>Ошибки:</h3><ul>";
    foreach ($errors as $err) {
        echo "<li>$err</li>";
    }
    echo "</ul><a href='index.html'>Назад</a>";
    exit;
}

// === Сохраняем заявку ===
$stmt = $pdo->prepare("INSERT INTO application (name, phone, email, birth_date, gender, biography, agreed) 
                       VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$fio, $phone, $email, $birth_date, $gender, $biography, $agreed]);
$appId = $pdo->lastInsertId();

// === Сохраняем выбранные языки ===
$stmtLang = $pdo->prepare("INSERT INTO application_languages (application_id, language_id) VALUES (?, ?)");
foreach ($languages as $langId) {
    $stmtLang->execute([$appId, $langId]);
}

echo "<h3> Данные успешно сохранены!</h3>";
echo "<p>Ваш ID заявки: " . htmlspecialchars($appId) . "</p>";
echo "<a href='index.html'>Заполнить снова</a>";
?>