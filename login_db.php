<?php

    session_start();
    require_once 'config/db.php';

    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username)) {
            $_SESSION['error'] = 'กรุณากรอกชื่อผู้ใช้';
            header('Location: login.php');
        } else if (empty($password)) {
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header('Location: login.php');
        } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5 ) {
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
            header('Location: login.php');
        } else {
            try {
                $check_data = $conn->prepare("SELECT * FROM users WHERE username = :username");
                $check_data->bindParam(':username', $username);
                $check_data->execute();
                $row = $check_data->fetch(PDO::FETCH_ASSOC);

                if ($check_data->rowCount() > 0) {
                    
                    if ($username == $row['username']) {
                        if (password_verify($password, $row['password'])) {
                            if ($row['urole'] == 'admin' ) {
                                $_SESSION['admin_login'] = $row['id'];
                                header('Location: admin_dashboard.php');
                            } else {

                            }
                        } else {
                            $_SESSION['error'] = 'รหัสผ่านผิด';
                            header('Location: login.php');
                        }
                    } else {
                        $_SESSION['error'] = 'ชื่อผู้ใช้ผิด';
                        header('Location: login.php');
                    }
                } else {
                    $_SESSION['error'] = 'ไม่มีข้อมูลในระบบ';
                    header('Location: login.php');
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
