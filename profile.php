<?php
session_start();
$pageTitle = "My Profile";
include "init.php";
if(isset($_SESSION['user'])) {
    $query="select * from users where username = '$sessionUser'";
    $res = $con->query($query);
    $row = $res->fetch_assoc();
    ?>
    <h1 class="text-center">My Profile</h1>
    <div class="information block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">My Information</div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li>
                            <i class="fa fa-unlock-alt fa-fw"></i>
                            <span>Login Name</span>: <?php echo $row['username'];?>
                        </li>
                        <li>
                            <i class="fa fa-envelope fa-fw"></i>
                            <span>Email</span>: <?php echo $row['email'];?>
                        </li>
                        <li>
                            <i class="fa fa-user fa-fw"></i>
                            <span>Full Name</span>: <?php echo $row['fullName'];?>
                        </li>
                        <li>
                            <i class="fa fa-calendar-alt fa-fw"></i>
                            <span>Register Date</span>: <?php echo $row['date'];?>
                            </li>
                        <li>
                            <i class="fa fa-tags fa-fw"></i>
                            <span>Fav Category</span>:
                        </li>
                    </ul>
                    <a class="btn btn-default">Edit Information</a>
                </div>
            </div>
        </div>
    </div>

    <div id="my-items" class="my--ads block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">My Items</div>
                <div class="panel-body">
                        <?php
                        $items = getAll("*", "items", "where mbr_id = {$row['id']}");
                        if(!empty($items)){
                            echo "<div class='row'>";
                            foreach ($items as $item) { ?>
                                <div class="col-sm-6 col-md-3">
                                    <div class="thumbnail item-box">
                                        <?php if($item['approve'] == 0) echo "<span class='approve-status'>Waiting Approval</span>";?>
                                        <span class="price-tag">$<?php echo $item['price']; ?></span>
                                        <img class="img-responsive img-thumbnail" src="img.png">
                                        <div class="caption">
                                            <h3><a href="items.php?id=<?php echo $item['id'];?> "> <?php echo $item['name']; ?></a></h3>
                                            <p><?php echo $item['description']; ?></p>
                                            <div class="date"><?php echo $item['addDate']; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            echo "</div>";
                        }
                        else echo "There're no Ads - <a href='newad.php'>New Ad</a>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="my-comments block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">My Comments</div>
                <div class="panel-body">
                    <?php
                        $comments = getAll("comment", "comments", "where user_id = {$row['id']}");
                        if(!empty($comments)){
                            foreach ($comments as $comment){
                                echo $comment['comment']."<br>";
                            }
                        }
                        else echo "There're no comments";
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php
}
else{
    header("location:login.php");
}
include $tpl."_footer.php";
?>