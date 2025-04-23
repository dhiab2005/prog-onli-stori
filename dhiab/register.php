<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $birthday_day = $_POST['birthday_day'] ?? '';
    $birthday_month = $_POST['birthday_month'] ?? '';
    $birthday_year = $_POST['birthday_year'] ?? '';
    $email = trim($_POST['email'] ?? '');


    if (empty($username) || empty($password) || empty($gender) || empty($birthday_day) || empty($birthday_month) || empty($birthday_year) || empty($email)) {
        echo "❌ الرجاء ملء جميع الحقول.";
        exit();
    }


    $birthday = sprintf("%04d-%02d-%02d", $birthday_year, $birthday_month, $birthday_day);


    // $checkStmt = $conn->prepare("SELECT id FROM ueser WHERE username = ? OR email = ?");
    // $checkStmt->bind_param("ss", $username, $email);
    // $checkStmt->execute();
    // $checkStmt->store_result();

    // if ($checkStmt->num_rows > 0) {
    //     echo "❌ اسم المستخدم أو البريد الإلكتروني مستخدم بالفعل.";
    //     $checkStmt->close();
    //     exit();
    // }
    // $checkStmt->close();


    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO ueser (username, password, gender, birthday, email) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $hashedPassword, $gender, $birthday, $email);

    if ($stmt->execute()) {
        session_start();
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        echo "❌ حدث خطأ أثناء التسجيل. حاول مرة أخرى.";
    }

    $stmt->close();
}

$conn->close();
?>