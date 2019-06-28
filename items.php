<?php ob_start();
session_start();
$pageTitle = "Show Items";
include "init.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) $id = intval($_GET['id']);
else $id = 0;

//$query = "SELECT * FROM items WHERE id = $id";
//$res = mysqli_query($con, $query);
//$row = mysqli_fetch_assoc($res);
//$count = $res->num_rows;
$query = "SELECT i.*, u.username, c.name as cat_name 
          FROM items i, users u , categories c
          where i.cat_id = c.id && i.mbr_id = u.id
          AND i.id = $id AND i.approve = 1";
$res = mysqli_query($con, $query);
$count = $res->num_rows;
$row = mysqli_fetch_assoc($res);
if ($count > 0) {
    ?>
    <h1 class="text-center"><?php echo $row['name']; ?></h1>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <img class="img-responsive img-thumbnail center-block" src="img.png">
            </div>
            <div class="col-md-9 item-info">
                <h2><?php echo $row['name'];?></h2>
                <p><?php echo $row['description'];?></p>
                <ul class="list-unstyled">
                    <li>
                        <i class="fa fa-calendar-alt fa-fw"></i>
                        <span>Added Date</span>: <?php echo $row['addDate'];?>
                    </li>
                    <li>
                        <i class="fa fa-money-bill-alt fa-fw"></i>
                        <span>Price</span>: $<?php echo $row['price'];?>
                    </li>
                    <li>
                        <i class="fa fa-building fa-fw"></i>
                        <span>Made in</span>: <?php echo $row['countryMade'];?>
                    </li>
                    <li>
                        <i class="fa fa-tags fa-fw"></i>
                        <span>Category</span>: <a href="categories.php?id=<?php echo $row['cat_id']?>&name=<?php echo $row['cat_name']?>"><?php echo $row['cat_name'];?></a>
                    </li>
                    <li>
                        <i class="fa fa-user fa-fw"></i>
                        <span>Added by</span>: <a href="#"><?php echo $row['username'];?></a>
                    </li>
                </ul>
            </div>
        </div>
        <hr class="custom-hr">
        <?php if(isset($_SESSION['user'])) {?>
        <div class="row">
            <div class="col-md-offset-3">
                <div class="add-comment">
                    <h3>Add Your Comment</h3>
                    <form action="<?php echo $_SERVER['PHP_SELF'].'?id='.$row['id'];?>" method="post">
                        <textarea name="comment" required></textarea>
                        <input type="submit" class="btn btn-primary" value="Add Comment">
                    </form>
                    <?php
                        if($_SERVER['REQUEST_METHOD'] == "POST"){
                            $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                            $item_id = $row['id'];
                            $user_id = $_SESSION['uid'];
                            if(empty(!$comment)){
                                $query2 = "insert into comments (comment, commentDate, item_id, user_id)
                                            VALUES ('$comment', now(), '$item_id', '$user_id')";
                                $res2 = mysqli_query($con, $query2);
                                if($res2) {
                                    $theMsg = "<div class='alert alert-success'>Comment Added</div>";
                                    redirectHome($theMsg, "back");
                                }
                            }
                            else
                                echo "<div class='container alert alert-danger'>You can't send an empty comment</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php }
        else echo "<a href='login.php'>Login</a> or <a href='login.php'>Register</a> to add comment"?>
        <hr class="custom-hr">
        <?php
                $query3 = "SELECT c.*, u.username
                FROM comments c, users u
                WHERE c.user_id = u.id AND c.status = 1 AND item_id = ".$row['id']." 
                ORDER BY c.id DESC ";
                $res3 = mysqli_query($con, $query3);
                while ($row3 = mysqli_fetch_assoc($res3)){
                    ?>
                    <div class='row'>
                        <div class="comment-box">
                            <div class='col-md-2 text-center'>
                                <img class="img-responsive img-thumbnail center-block img-circle" src="img.png">
                                <?php echo $row3['username'];?>
                            </div>
                            <div class='col-md-10 lead'><?php echo $row3['comment'];?></div>
                        </div>
                    </div>
                    <hr class="custom-hr">
        <?php
                }
}

//------------------------------------------------------

else{
    echo "<div class='container alert alert-danger'>This item doesn't exist or may be waiting approval.</div>";
    redirectHome("","back", 5);
}
include $tpl."_footer.php";
ob_end_flush();
?>