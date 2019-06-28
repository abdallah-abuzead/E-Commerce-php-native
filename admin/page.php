
<?php

    $do = "";
    if(isset($_GET["do"])) $do = $_GET["do"];
    else $do = "manage";

    if($do == "manage") {
        echo "Manage Category<br>";
        echo "<a href = '?do=add'>Add New Category +</a>>";
    }
    elseif($do == "add") echo "Add Category";
    elseif($do == "delete") echo "Delete Category";
    else echo "Error, there\'s no page with this name";

