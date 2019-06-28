<?php
    ob_start(); //output buffering start: Stoe all the output in the memory except the header, No output before sending header
                //Any function that send/modify HTTP header must be invoked first before any output made
    session_start();
    $pageTitle = "Dashboard";
    if (isset($_SESSION['username'])){
        include "init.php";
        $numUsers = 5;
        $latestUsers = getLatest("*", "users", "id", $numUsers);
        $numItems = 5;
        $latestItems = getLatest("*", "items", "id", $numItems);
?>

        <div class=" home-stat container text-center">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <a href="members.php">
                        <div class="stat st-members">
                            Total Members
                            <span><?php echo countItems("id", "users");?></span>
                        </div>
                    </a>
                </div>
                    <div class="col-md-3">
                        <a href="members.php?do=manage&page=pending">
                            <div class="stat st-pending">
                                Pending Members
                                <span><?php echo checkItem("regStatus", "users", 0)?></span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="items.php">
                            <div class="stat st-items">
                                Total Items
                                <span><?php echo countItems("id", "items");?></span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="comments.php">
                            <div class="stat st-comments">
                                Total Comments
                                <span><span><?php echo countItems("id", "comments");?></span></span>
                            </div>
                        </a>
                    </div>
            </div>
        </div>

        <div class="latest container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-users"></i>Latest <?php echo $numUsers;?> registerd users
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                                <?php
                                    foreach ($latestUsers as $user) {
                                        echo "<li>" . $user['username'];
                                            echo "<a href='members.php?do=edit&id=" . $user['id'] . "'>";
                                                echo "<span class='btn btn-success pull-right'>";
                                                    echo "<i class='fa fa-edit'></i>";
                                                    echo "Edit";
                                                echo "</span>";
                                            echo "</a>";
                                            if($user['regStatus'] == 0) {
                                                echo "<a href='members.php?do=activate&id=" . $user['id'] . "' class='btn btn-info pull-right'>";
                                                echo "<i class='fa fa-check'></i>";
                                                echo "Activate";
                                                echo "</a>";
                                            }
                                        echo "</li>";
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-tag"></i>Latest <?php echo $numItems;?> items
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                                <?php
                                    foreach ($latestItems as $item) {
                                        echo "<li>" . $item['name'];
                                            echo "<a href='items.php?do=edit&id=" . $item['id'] . "'>";
                                                echo "<span class='btn btn-success pull-right'>";
                                                    echo "<i class='fa fa-edit'></i>";
                                                    echo "Edit";
                                                echo "</span>";
                                            echo "</a>";
                                            if($item['approve'] == 0) {
                                                echo "<a href='items.php?do=approve&id=" . $item['id'] . "' class='btn btn-info pull-right'>";
                                                echo "<i class='fa fa-check'></i>";
                                                echo "Approve";
                                                echo "</a>";
                                            }
                                        echo "</li>";
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

<?php
        include $tpl."_footer.php";
    }
    else{
        header("location:index.php");
        exit();
    }
    ob_end_flush();
?>

