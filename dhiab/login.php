<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    echo  $username;
    // Get user data from DB
    $stmt = $conn->prepare("SELECT * FROM ueser WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        echo  $user['username'];
        // Verify hashed password
        if (password_verify($password, $username['password'])) {
            session_start();
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            echo "❌ كلمة المرور غير صحيحة.";
        }
    } else {
        echo "❌ اسم المستخدم غير موجود.";
    }

    $stmt->close();
}

$conn->close();
?>