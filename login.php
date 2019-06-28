<?php ob_start();
session_start();
$pageTitle = "Login";
if (isset($_SESSION['user'])){
    header("location:index.php");
}
include "init.php";

//check if user is coming from HTTP POST method

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST["login"])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashedPassword = sha1($password);

        //        check if user is existed in database and is an Admin

        $query = "SELECT id, username, password FROM users WHERE username = '$username' AND password = '$hashedPassword'";
        $res = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($res);
        $count = $res->num_rows;

        if ($count > 0) {
            $_SESSION['user'] = $username;
            $_SESSION['uid']=$row['id'];
            header("location:index.php");
            exit();
        }
    }
    else{
        $formErrors = array();
        $username = $_POST['username'];
        $password = $_POST['password'];
        $repeatPassword = $_POST['repeatPassword'];
        $email = $_POST['email'];

        if(isset($username)){
            $filterdUser = filter_var($username, FILTER_SANITIZE_STRING);
            if(strlen($filterdUser)< 2) $formErrors[]= "Username must be at least 2 characters";
        }

        if(isset($email)){
            $filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
            if(filter_var($filterdEmail, FILTER_SANITIZE_EMAIL) != true)
                $formErrors[]= "Not Valid Email";
        }

        if(isset($password) && isset($repeatPassword)){
            if(empty($password) && empty($repeatPassword))
                $formErrors[]= "Password can't be empty";
            else {
                $hashedPassword = sha1($password);
                $hashedRepeatedPassword = sha1($_POST['repeatPassword']);
                if ($hashedPassword !== $hashedRepeatedPassword)
                    $formErrors[] = "Password doesn't match";
            }
        }

        if(empty($formErrors)){
            $check = checkItem("username", "users", $username );
            if($check == 1)
                $formErrors[] = "Sorry this user already exists.";
            else{
                $query = "insert into users (username, password, email, date) 
                      VALUES ('$username', '$hashedPassword', '$email', now())";
                $res = mysqli_query($con, $query);

                if($res)$successMsg = "You are successfully registered.";
            }
        }

    }
}
?>

    <div class="container login-page">
        <h1 class="text-center"><span data-class="login" class="selected">Login</span> | <span data-class="signup">Signup</span></h1>
        <form  class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input class="form-control" type="text" name="username" placeholder="username" autocomplete="off" required>
            <input class="form-control" type="password" name="password" placeholder="password" autocomplete="new-password" required>
            <input class="btn btn-primary btn-block" type="submit" name="login" value="Login">
        </form>

        <form class="signup" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input  pattern=".{2,}" title="Username must be at least 2 characters"
                    class="form-control" type="text" name="username" placeholder="username" autocomplete="off" required>
            <input class="form-control" type="email" name="email" placeholder="email" required>
            <input minlength="3" class="form-control" type="password" name="password" placeholder="password" autocomplete="new-password" required>
            <input minlength="3" class="form-control" type="password" name="repeatPassword" placeholder="repeat password" autocomplete="new-password" required>
            <input class="btn btn-success btn-block" type="submit" name="signup" value="SignUp">
        </form>
        <div class="the-errors text-center">
            <?php
            if(!empty($formErrors)){
                foreach ($formErrors as $error)
                    echo "<div class='msg error'>".$error."</div>";
            }
            if(isset($successMsg)){
                echo "<div class='msg success'>$successMsg</div>";
            }
            ?>
        </div>
    </div>

<?php include $tpl."_footer.php"; ob_end_flush();?>
