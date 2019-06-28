<?php
session_start();
$pageTitle = "Members";
if (isset($_SESSION['username'])){
    include "init.php";
    if(isset($_GET["do"])) $do = $_GET["do"];
    else $do = "manage";

    if($do == "manage"){ ?>
        <h1 class="text-center">Manage Members</h1>
        <div class="container">
            <a href='members.php?do=add' class="btn btn-primary"><i class="fa fa-plus"></i>New Member</a>
            <div class="table-responsive">
                <table class=" text-center table table-bordered main-table">
                    <tr>
                        <td>#ID</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Registerd Date</td>
                        <td>Control</td>
                    </tr>
                    <?php
                        $pen_query = "";
                        if(isset($_GET['page']) && $_GET['page'] == "pending")
                            $pen_query = "and regStatus = 0";
                        $query = "SELECT * FROM users WHERE group_id != 1 $pen_query ORDER BY id DESC ";
                        $res = mysqli_query($con, $query);
                        while ($row = mysqli_fetch_assoc($res)){
                            echo "<tr>";
                                echo "<td>".$row['id']."</td>";
                                echo "<td>".$row['username']."</td>";
                                echo "<td>".$row['email']."</td>";
                                echo "<td>".$row['fullName']."</td>";
                                echo "<td>".$row['date']."</td>";
                                echo "<td> <a href='members.php?do=edit&id=".$row['id']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>".
                                    "<a href='members.php?do=delete&id=".$row['id']."' class='btn btn-danger confirm'><i class='fa fa-window-close'></i>Delete</a>";
                                if($row['regStatus'] == 0)
                                    echo "<a href='members.php?do=activate&id=".$row['id']."' class='btn btn-info'><i class='fa fa-check'></i>Activate</a>";
                                echo "</td></tr>";
                        }
                    ?>
                </table>
            </div>
        </div>
    <?php
    }
    //------------------------------------------------------------------------------
    elseif($do == "add"){ ?>
        <h1 class="text-center">Add New Member</h1>
            <form class="container" action="?do=insert" method="post" style="width:450px;">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="password form-control" autocomplete="new-password">
                    <i class="show-password fa fa-eye fa-2x"></i>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>

                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" name="fullName" id="fullName" class="form-control">
                </div>
                <input type="submit" value="Add Member" class="btn btn-primary">
                <input type="reset" value="Cancel" class="btn btn-danger">
            </form>
    <?php
    }
    //--------------------------------------------------------------------
    elseif ($do == "insert"){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            echo "<h1 class='text-center'>Insert Member</h1>";
            $username = $_POST['username'];
            $password = $_POST['password'];
            $hashedPassword = sha1($_POST['password']);
            $email = $_POST['email'];
            $fullName = $_POST['fullName'];

            $check = checkItem("username", "users", $username );
            if($check == 1){
                echo "<div class='container'>";
                $theMsg = "<div class='alert alert-danger'> Sorry this user already exists.</div>";
                redirectHome($theMsg, "back");
                echo "</div>";
            }
            else{
            $query = "insert into users (username, password, email, fullName, regStatus, date) 
                      VALUES ('$username', '$hashedPassword', '$email', '$fullName', 1, now())";
            $res = mysqli_query($con, $query);

            echo "<div class='container'>";
            if($res)$theMsg = "<div class='alert alert-success'> 1 record inserted.</div>";
            else $theMsg = "<div class='alert alert-danger'> 0 records inserted</div>";
            redirectHome($theMsg, "back");
            echo "</div>";
            }
        }
        else{
            echo "<div class='container'>";
            $theMsg = "<div class='alert alert-danger'> Sorry you can't browse this page directly</div>";
            redirectHome($theMsg);
            echo "</div>";
        }
    }
    //------------------------------------------------------------------------
    elseif($do == "edit") {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) $id = intval($_GET['id']);
        else $id = 0;

        $query = "SELECT * FROM users WHERE id = $id limit 1";
        $res = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($res);
        $count = $res->num_rows;
        if ($count > 0) { ?>

            <h1 class="text-center">Edit Member</h1>
            <form class="container" action="?do=update" method="post" style="width:450px;">
                <input type="hidden" name = "id" value="<?php echo $id;?>">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control"
                           value="<?php echo $row['username'] ?>">
                </div>

                <div class="form-group">
                    <label for="newPassword">Password</label>
                    <input type="hidden" name="oldPassword" value="<?php echo $row['password'];?>">
                    <input type="password" name="newPassword" id="newPassword" class="form-control"
                           autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $row['email'] ?>">
                </div>

                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" name="fullName" id="fullName" class="form-control"
                           value="<?php echo $row['fullName'] ?>">
                </div>
                <input type="submit" value="Save" class="btn btn-primary">
                <input type="reset" value="Cancel" class="btn btn-danger">
            </form>
        <?php }
    }
    //-----------------------------------------------------------------
    elseif ($do == "update"){
        echo "<h1 class='text-center'>Update Member</h1>";
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $id = $_POST['id'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $fullName = $_POST['fullName'];
            $password = "";
            if (empty($_POST['newPassword'])) $password = $_POST['oldPassword'];
            else $password = sha1($_POST['newPassword']);

            $query = "update users set username = '$username', email = '$email', password = '$password', fullName = '$fullName' WHERE id = $id";
            $res = mysqli_query($con, $query);

            echo "<div class='container'>";
            if($res)$theMsg = "<div class='alert alert-success'> 1 record updated.</div>";
            else $theMsg = "<div class='alert alert-danger'> 0 records updated</div>";
            redirectHome($theMsg, "back");
            echo "</div>";
        }
        else{
            echo "<div class='container'>";
            $theMsg = "<div class='alert alert-danger'> Sorry you can't browse this page directly</div>";
            redirectHome($theMsg);
            echo "</div>";
        }
    }
    //------------------------------------------------------------------
    elseif($do =="delete"){
        echo "<h1 class='text-center'>Delete Member</h1>";
        if(isset($_GET['id'])) {
            $check = checkItem("id", "users", $_GET['id'] );
            if($check == 1) {
                $query = "delete from users WHERE id =" . $_GET['id'];
                $res = mysqli_query($con, $query);

                echo "<div class='container'>";
                if ($res) $theMsg = "<div class='alert alert-success'> 1 record deleted.</div>";
                else $theMsg = "<div class='alert alert-danger'> 0 records deleted.</div>";
                redirectHome($theMsg, "back");
                echo "</div>";
            }
            else {
                echo "<div class='container'>";
                $theMsg = "<div class='alert alert-danger'> There is no such ID.</div>";
                redirectHome($theMsg);
                echo "</div>";
            }
        }
        else {
            echo "<div class='container'>";
            $theMsg = "<div class='alert alert-danger'>ID is required.</div>";
            redirectHome($theMsg);
            echo "</div>";
        }
    }

    //-----------------------------------------------------------------

    else if($do == "activate"){
        echo "<h1 class='text-center'>Activate Member</h1>";
        if(isset($_GET['id'])) {
            $check = checkItem("id", "users", $_GET['id'] );
            if($check == 1) {
                $query = "update users set regStatus = 1 WHERE id =" . $_GET['id'];
                $res = mysqli_query($con, $query);

                echo "<div class='container'>";
                if ($res) $theMsg = "<div class='alert alert-success'> 1 record activated.</div>";
                else $theMsg = "<div class='alert alert-danger'> 0 records activated.</div>";
                redirectHome($theMsg, "back");
                echo "</div>";
            }
            else {
                echo "<div class='container'>";
                $theMsg = "<div class='alert alert-danger'> There is no such ID.</div>";
                redirectHome($theMsg);
                echo "</div>";
            }
        }
        else {
            echo "<div class='container'>";
            $theMsg = "<div class='alert alert-danger'>ID is required.</div>";
            redirectHome($theMsg);
            echo "</div>";
        }
    }

    //-----------------------------------------------------------------

    include $tpl."_footer.php";
}
//--------------------------------------------------------------------
else{
    header("location:index.php");
    exit();
}
