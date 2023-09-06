<?php

require_once "config.php";
require_once "session.php";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $fullname = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $passwordConfirm = trim($_POST['passwordConfirm']);
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    if($query = $db->prepare("SELECT * FROM users WHERE email = ?")) {
        $error = '';
        $query->bind_param('s', $email);
        $query->execute();
        $query->store_result();
        if($query->num_rows > 0){
            $error .= '<p class="error">That email is already in use</p>';
        } else {
            if (strlen($password) < 5) {
                $error .= '<p class="error>Password must have at least 5 characters</p>' ;
            }
            
        if(empty($passwordConfirm)) {
            $error .= '<p class="error>Please confirm your password</p>';
        } else {
            if (empty($error) && ($password != $passwordConfirm)){
                $error .= '<p class="error>Passwords did not match</p>'
            }
        }
        
        if(empty($error)) {
            $insertQuery = $db->prepare("INSERT INTO users(name, email, password) VALUES (?, ?, ?);");
            $insertQuery->bind_param("sss", $fullname, $email, $passwordHash);
            $result = $insertQuery->execute();
            if ($result) {
                $error .= '<p class=success>You have successfully registered!</p>';
            } else {
                $error .= '<p class=error>Something went wrong!</p>';
            }
        }

        }
    }

    $query->close();
    $insertQuery->close();
    mysqli_close($db)
}
?>
<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="style.css">
    
</head>

<body>
    <div class="wrapper">
        <div class = "regHead">
            <h2>Register</h2>
            <p>Please fill out the following form to create your account</p>
        </div>
        <div class="regBody">
            <form action="" method="post">
                <div class="formGroup">
                    <input type="text" name="name" class="formControl" required>
                    <label for="name">Full Name</label>
                </div>
                <div class="formGroup">
                    <input type="text" name="email" class="formControl" required>
                    <label for="email">Email Address</label>
                </div>
                <div class="formGroup">
                    <input type="text" name="password" class="formControl" required>
                    <label for="password">Enter Password</label>
                </div>
                <div class="formGroup">
                    <input type="text" name="confirm" class="formControl" required>
                    <label for="confirm">Confirm Password</label>
                </div>
                <div class="formGroup">
                    <input type="submit" name="submit" class="btn btnPrimary" value="Submit">
                </div>
                <p>Already have an account? <a href="">Login here</a></p>
            </form>
        </div>
    </div>
</body>
