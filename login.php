<?php session_start();
// coding the login from
$users=["kody"=>123 ,"leon"=>321];
$error="";

if ($_SERVER['REQUEST_METHOD']=="POST")
    {
        $username=$_POST['username'];
        $password=$_POST['password'];

        if(isset($users[$username]) && $users[$username]==$password)
            {
                $_SESSION['logged_in']=true;
                $_SESSION['username']=$username;
                header("location: calculator.php");
                exit();
            }
            else
                {
                    $error="Invalid username or password !";
                }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login_calculator</title>
        
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h2>Student grade Calculator-Login</h2>
        <?php if($error !="") { echo "<p style='color:red; '>$error</p>";}?>
        <form method="POST" action="login.php">
            username: <input type="text" name="username"required><br><br>
            password: <input type="password" name="password" required> <br><br>
            <input type="submit" value="Login">
        </form>
    </body>
    </html>