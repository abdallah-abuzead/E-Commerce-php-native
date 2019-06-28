<?php
session_start();
$pageTitle = "Comments";
if (isset($_SESSION['username'])){
    include "init.php";
    if(isset($_GET["do"])) $do = $_GET["do"];
    else $do = "manage";

    if($do == "manage"){ ?>
        <h1 class="text-center">Manage Comments</h1>
        <div class="container">
            <div class="table-responsive">
                <table class=" text-center table table-bordered main-table">
                    <tr>
                        <td>#ID</td>
                        <td>Comment</td>
                        <td>Item Name</td>
                        <td>User Name</td>
                        <td>Added Date</td>
                        <td>Control</td>
                    </tr>
                    <?php
                    $query = "SELECT c.*, i.name, u.username 
                              FROM comments c, items i, users u 
                              WHERE c.item_id = i.id && c.user_id = u.id
                              ORDER BY c.id DESC ";
                    $res = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_assoc($res)){
                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".$row['comment']."</td>";
                        echo "<td>".$row['name']."</td>";
                        echo "<td>".$row['username']."</td>";
                        echo "<td>".$row['commentDate']."</td>";
                        echo "<td> <a href='?do=edit&id=".$row['id']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>".
                            "<a href='?do=delete&id=".$row['id']."' class='btn btn-danger confirm'><i class='fa fa-window-close'></i>Delete</a>";
                        if($row['status'] == 0)
                            echo "<a href='?do=approve&id=".$row['id']."' class='btn btn-info'><i class='fa fa-check'></i>Approve</a>";
                        echo "</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
        <?php
    }

    //------------------------------------------------------------------------------

    elseif($do == "edit") {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) $id = intval($_GET['id']);
        else $id = 0;

        $query = "SELECT * FROM comments WHERE id = $id";
        $res = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($res);
        $count = $res->num_rows;
        if ($count > 0) {
?>
            <h1 class="text-center">Edit Comment</h1>
            <form class="container" action="?do=update" method="post" style="width:450px;">
                <input type="hidden" name = "id" value="<?php echo $id;?>">
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea name="comment" id="comment" class="form-control"><?php echo $row['comment'] ?></textarea>
                </div>

                <input type="submit" value="Save" class="btn btn-primary">
                <input type="reset" value="Cancel" class="btn btn-danger">
            </form>
<?php
        }
    }
    //-----------------------------------------------------------------
    elseif ($do == "update"){
        echo "<h1 class='text-center'>Update Comment</h1>";
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $id = $_POST['id'];
            $comment = $_POST['comment'];
            $query = "update comments set comment = '$comment' WHERE id = $id";
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
        echo "<h1 class='text-center'>Delete Comment</h1>";
        if(isset($_GET['id'])) {
            $check = checkItem("id", "comments", $_GET['id'] );
            if($check == 1) {
                $query = "delete from comments WHERE id =" . $_GET['id'];
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

    else if($do == "approve"){
        echo "<h1 class='text-center'>Approve Member</h1>";
        if(isset($_GET['id'])) {
            $check = checkItem("id", "comments", $_GET['id'] );
            if($check == 1) {
                $query = "update comments set status = 1 WHERE id =" . $_GET['id'];
                $res = mysqli_query($con, $query);

                echo "<div class='container'>";
                if ($res) $theMsg = "<div class='alert alert-success'> 1 record approved.</div>";
                else $theMsg = "<div class='alert alert-danger'> 0 records approved.</div>";
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
