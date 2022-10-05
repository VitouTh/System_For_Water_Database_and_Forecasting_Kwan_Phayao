<?php

session_start();
require_once 'config/db.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style_login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">


</head>

<body>
    <div class="container " >
        <header class="py-3 mb-4 ">
            <div class="container d-flex flex-wrap justify-content-center p-5">
                <h2>ระบบฐานข้อมูลและการคาดการณ์ปริมาณน้ำในกว๊านพะเยา</h2>
                <h3>Database system and water volume forecasting in Kwan Phayao</h3>
            </div>
        
            <div class="container d-flex flex-wrap justify-content-center pt-5">
            <div class="login">
                <h1 class="text-center">กรุณาเข้าสู่ระบบ</h1>
                <form action="login_db.php" method="post">
                    <?php if (isset($_SESSION['error'])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php } ?>
                    <?php if (isset($_SESSION['success'])) { ?>
                        <div class="alert alert-success" role="alert">
                            <?php
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                            ?>
                        </div>
                    <?php } ?>
                    <div class="form-group mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" aria-describedby="username" placeholder="กรุณากรอกชื่อผู้ใช้" required>
                    </div>
                    <div class="form-group mb-3">
                        <label form="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="กรุณากรอกรหัสผ่าน" required>
                    </div>
                    <div class="form-group modal-footer">
                        <button type="submit" name="login" class="btn btn-primary">Login</button>
                        <a class="btn btn-secondary" href="index.php" role="button">Back</a>
                    </div>
                </form>
            </div>
            </div>
        </header>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>