<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['save'])) {
        print('Спасибо, результаты сохранены!');
    }
    include('index.php');
    exit();
}

// Validate inputs
$errors = FALSE;
if (empty($_POST['fio']) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s]+$/u', $_POST['fio']) || strlen($_POST['fio']) > 150) {
    print('Пожалуйста, введите корректное ФИО (только буквы и пробелы, не более 150 символов).<br/>');
    $errors = TRUE;
}

if (empty($_POST['tel']) || !preg_match('/^[\d\s\-\+\(\)]+$/', $_POST['tel'])) {
    print('Пожалуйста, введите корректный номер телефона.<br/>');
    $errors = TRUE;
}

if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    print('Пожалуйста, введите корректный email.<br/>');
    $errors = TRUE;
}

if (empty($_POST['date']) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['date'])) {
    print('Пожалуйста, выберите корректную дату рождения.<br/>');
    $errors = TRUE;
}

if (empty($_POST['gender']) || !in_array($_POST['gender'], ['male', 'female'])) {
    print('Пожалуйста, выберите пол.<br/>');
    $errors = TRUE;
}

if (empty($_POST['plang']) || !is_array($_POST['plang'])) {
    print('Пожалуйста, выберите хотя бы один язык программирования.<br/>');
    $errors = TRUE;
}

if (empty($_POST['bio']) || strlen($_POST['bio']) > 500) {
    print('Пожалуйста, напишите биографию (не более 500 символов).<br/>');
    $errors = TRUE;
}

if (empty($_POST['check'])) {
    print('Пожалуйста, подтвердите ознакомление с контрактом.<br/>');
    $errors = TRUE;
}

if ($errors) {
    exit();
}

// Database connection
$user = 'uXXXXX'; // replace with your username
$pass = 'YYYYYYY'; // replace with your password
$dbname = 'uXXXXX'; // replace with your database name

try {
    $db = new PDO("mysql:host=localhost;dbname=$dbname", $user, $pass, [
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    // Insert main application data
    $stmt = $db->prepare("INSERT INTO applications (fio, tel, email, birth_date, gender, bio) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['fio'],
        $_POST['tel'],
        $_POST['email'],
        $_POST['date'],
        $_POST['gender'],
        $_POST['bio']
    ]);
    
    $applicationId = $db->lastInsertId();
    
    // Insert programming languages
    $stmt = $db->prepare("INSERT INTO application_languages (application_id, language_id) VALUES (?, ?)");
    foreach ($_POST['plang'] as $language) {
        // First, get or insert language to get its ID
        $langStmt = $db->prepare("SELECT id FROM programming_languages WHERE name = ?");
        $langStmt->execute([$language]);
        $langId = $langStmt->fetchColumn();
        
        if (!$langId) {
            $langStmt = $db->prepare("INSERT INTO programming_languages (name) VALUES (?)");
            $langStmt->execute([$language]);
            $langId = $db->lastInsertId();
        }
        
        $stmt->execute([$applicationId, $langId]);
    }
    
    header('Location: ?save=1');
} catch (PDOException $e) {
    print('Error: ' . $e->getMessage());
    exit();
}
