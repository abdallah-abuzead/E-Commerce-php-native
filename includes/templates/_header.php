<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php getTitle();?></title>
		<link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $css; ?>fontawesome.min.css">
		<link rel="stylesheet" href="<?php echo $css; ?>all.min.css">
        <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css">
        <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css">
        <link rel="stylesheet" href="<?php echo $css; ?>_frontend.css">
    </head>
	<body>
        <div class="upper-bar">
            <div class="container">
                <?php if (isset($_SESSION['user'])){
                    ?>
                    <img class="my-image img-circle img-thumbnail" src="img.png">
                    <div class="btn-group my-info">
                        <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <?php echo $sessionUser;?>
                            <span class="caret"></span>
                        </span>
                        <ul class="dropdown-menu">
                            <li><a href="profile.php">My Profile</a></li>
                            <li><a href="newad.php">New Item</a></li>
                            <li><a href="profile.php#my-items">My Items</a></li>
                            <li><a href="logout.php">Log out</a></li>
                        </ul>
                    </div>
                    <?php
                    if(!isActivated($sessionUser)) echo ", You need to be activated.";
                }
                else{ ?>
                <a href="login.php">
                    <span class="pull-right">Login | Signup</span>
                </a>
                <?php }?>
            </div>
        </div>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="index.php">My Shop</a></div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right" >
<?php
                        foreach (getAll("*", "categories", "where parent = 0", "", "ASC") as $cat)
                            echo "<li><a href='categories.php?id=".$cat['id']."'>".$cat['name']."</a></li>";
?>
                    </ul>
                </div>
            </div>
        </nav>


