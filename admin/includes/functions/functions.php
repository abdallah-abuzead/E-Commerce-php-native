<?php

    function getAll($field, $table, $where = null, $orderField = "id", $ordering = "DESC"){
        global $con;
        $rows = array();
        if($orderField == "") $orderField = "id";
        $query="select $field from $table $where ORDER BY $orderField $ordering";
        $res = $con->query($query);
        while($row = $res->fetch_assoc())
            $rows[] = $row;
        return $rows;
    }

    //----------------------------------------------

    function getTitle(){
        global $pageTitle;
        if(isset($pageTitle)) echo $pageTitle;
        else echo "Default";
    }

    //----------------------------------------------

    function redirectHome($theMsg, $url = null, $seconds = 0){
        echo $theMsg;
        if($url == null) {
            $url = 'index.php';
            $link = "Home page";
        }
        else {
            if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != ""){
                $url = $_SERVER['HTTP_REFERER'];
                $link = "Previous page";
            }
            else{
                $url = 'index.php';
                $link = "Home page";
            }
        }
        echo "<div class='alert alert-info'>You  will be redirected to $link page after $seconds seconds</div>";
        header("refresh:$seconds;url=$url");
        exit();
    }

    //--------------------------------------------

    function checkItem($select, $table, $value){
        global $con;
        $query="select $select from $table where $select='$value'";
        $res = mysqli_query($con, $query);
        $count = $res->num_rows;
        return $count;
    }

    //-----------------------------------------------

    function countItems($item, $table){
        global $con;
        $query = "select count($item) from $table";
        $res = $con->query($query);
        $row = $res->fetch_row();
        return $row[0];
    }

    //---------------------------------------------

    function getLatest($select, $table, $order, $limit = 5){
        global $con;
        $rows = array();
        $query="select $select from $table order by $order desc limit $limit";
        $res = $con->query($query);
        while($row = $res->fetch_assoc())
            $rows[] = $row;
        return $rows;
    }