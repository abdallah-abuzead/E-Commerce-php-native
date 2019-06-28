<?php
    session_start();
    $noNavbar = "";
    $pageTitle = "Login";
    if (isset($_SESSION['username'])){
        header("location:dashboard.php");
    }
?>

<?php
    include "init.php";

    //check if user is coming from HTTP POST method

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashedPassword = sha1($password);

//        check if user is existed in database and is an Admin

        $query = "SELECT id, username, password FROM users WHERE username = '$username' AND password = '$hashedPassword' AND group_id=1 limit 1";
        $res = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($res);
        $count = $res->num_rows;

//        $stmt = $con->prepare("SELECT id, username, password FROM users WHERE username = ? AND password = ? AND group_id=1 limit 1");
//        $stmt->execute(array($username, $hashedPassword));
//        $count = $stmt->rowCount();

        if($count > 0){
            $_SESSION['username']=$username;
            $_SESSION['id']=$row['id'];
            header("location:dashboard.php");
            exit();
        }
    }
?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	<h4 class="text-center">Admin login</h4>
	<input class="form-control" type="text" name="username" placeholder="username" autocomplete="off">
	<input class="form-control" type="password" name="password" placeholder="password" autocomplete="new-password">
	<input class="btn btn-primary btn-block" type="submit" value="Login">
</form>

<?php include $tpl."_footer.php";?>