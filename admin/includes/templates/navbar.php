<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header"><a class="navbar-brand" href="dashboard.php">My Shop</a></div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav ">
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="items.php">Items</a></li>
                <li><a href="members.php">Members</a></li>
                <li><a href="comments.php">Comments</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['username'];?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="../index.php">Visit Shop</a></li>
                        <li><a href="members.php?do=edit&id=<?php echo $_SESSION['id'];?>">Edit Profile</a></li>
                        <li><a href="#">Setting</a></li>
                        <li><a href="logout.php">Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
