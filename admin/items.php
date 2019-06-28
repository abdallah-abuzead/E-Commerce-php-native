<?php
    ob_start();
    session_start();
    $pageTitle = "Items";
    if (isset($_SESSION['username'])){
        include "init.php";
        if(isset($_GET["do"])) $do = $_GET["do"];
        else $do = "manage";

        if($do == "manage"){
?>
            <h1 class="text-center">Manage Items</h1>
            <div class="container">
                <a href='?do=add' class="btn btn-primary"><i class="fa fa-plus"></i>New Item</a>
                <div class="table-responsive">
                    <table class=" text-center table table-bordered main-table">
                        <tr>
                            <td>#ID</td>
                            <td>Name</td>
                            <td>Description</td>
                            <td>Price</td>
                            <td>Adding Date</td>
                            <td>Category</td>
                            <td>Added By</td>
                            <td>Control</td>
                        </tr>
<?php
                            $query = "SELECT i.*, u.username, c.name as cat_name 
                                      FROM items i, users u , categories c
                                      where i.cat_id = c.id && i.mbr_id = u.id
                                      ORDER BY i.id DESC ";
                            $res = mysqli_query($con, $query);
                            while ($row = mysqli_fetch_assoc($res)){
                                echo "<tr>";
                                echo "<td>".$row['id']."</td>";
                                echo "<td>".$row['name']."</td>";
                                echo "<td>".$row['description']."</td>";
                                echo "<td>".$row['price']."</td>";
                                echo "<td>".$row['addDate']."</td>";
                                echo "<td>".$row['cat_name']."</td>";
                                echo "<td>".$row['username']."</td>";
                                echo "<td> <a href='?do=edit&id=".$row['id']."' class='btn btn-success btn-sm'><i class='fa fa-edit'></i>Edit</a>".
                                    "<a href='?do=delete&id=".$row['id']."' class='btn btn-danger confirm btn-sm'><i class='fa fa-window-close'></i>Delete</a>";
                                if($row['approve'] == 0)
                                    echo "<a href='?do=approve&id=".$row['id']."' class='btn btn-info btn-sm'><i class='fa fa-check'></i>Approve</a>";
                                echo "</td></tr>";
                            }
?>
                    </table>
                </div>
            </div>
<?php
        }

        //-----------------------------------------------------------------

        elseif($do == "add"){
?>
            <h1 class="text-center">Add New Item</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=insert" method="post">
                    <div class="form-group form-group">
                        <label class="col-sm-2 control-label" for="name">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name" id="name" class="form-control" required="required">
                        </div>
                    </div>

                    <div class="form-group form-group">
                        <label class="col-sm-2 control-label" for="description">Description</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="description" id="description" class="form-control" required="required">
                        </div>
                    </div>

                    <div class="form-group form-group">
                        <label class="col-sm-2 control-label" for="price">Price</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="price" id="price" class="form-control" required="required">
                        </div>
                    </div>

                    <div class="form-group form-group">
                        <label class="col-sm-2 control-label" for="country">Country of Made</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="country" id="country" class="form-control" required="required">
                        </div>
                    </div>

                    <div class="form-group form-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10 col-md-6">
                            <select  name="status">
                                <option value="0">...</option>
                                <option value="1">New</option>
                                <option value="2">Like New</option>
                                <option value="3">Used</option>
                                <option value="4">Very Old</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-group">
                        <label class="col-sm-2 control-label">Member</label>
                        <div class="col-sm-10 col-md-6">
                            <select  name="member">
                                <option value="0">...</option>
<?php
                                $query = "SELECT * FROM users";
                                $res = mysqli_query($con, $query);
                                while ($row = mysqli_fetch_assoc($res)){
                                    echo "<option value='".$row['id']."'>".$row['username']."</option>";
                                }
?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-group">
                        <label class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10 col-md-6">
                            <select  name="category">
                                <option value="0">...</option>
<?php
                                $query = "SELECT * FROM categories";
                                $res = mysqli_query($con, $query);
                                while ($row = mysqli_fetch_assoc($res)){
                                    echo "<option value='".$row['id']."'>".$row['name']."</option>";
                                }
?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Add Item" class="btn btn-primary btn-md">
                            <input type="reset" value="Cancel" class="btn btn-danger btn-md">
                        </div>
                    </div>
                </form>
            </div>
<?php
        }

        //-----------------------------------------------------------------

        elseif($do == "insert"){
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                echo "<h1 class='text-center'>Insert Item</h1>";
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $country = $_POST['country'];
                $status = $_POST['status'];
                $member= $_POST['member'];
                $category = $_POST['category'];

                $query = "insert into items (name, description, price, countryMade, status, addDate, cat_id, mbr_id) 
                  VALUES ('$name', '$description', '$price', '$country', '$status', now(), $category, $member)";
                $res = mysqli_query($con, $query);

                echo "<div class='container'>";
                if ($res) $theMsg = "<div class='alert alert-success'> 1 record inserted.</div>";
                else $theMsg = "<div class='alert alert-danger'> 0 records inserted</div>";
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

        elseif($do == "edit"){
            if (isset($_GET['id']) && is_numeric($_GET['id'])) $id = intval($_GET['id']);
            else $id = 0;

            $query = "SELECT * FROM items WHERE id = $id";
            $res = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($res);
            $count = $res->num_rows;
            if ($count > 0) {
?>
                <h1 class="text-center">Edit Item</h1>
                <div class="container">
                    <form class="form-horizontal" action="items.php?do=update" method="post">
                        <div class="form-group form-group">
                            <label class="col-sm-2 control-label" for="name">Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="hidden" name = "id" value="<?php echo $id;?>">
                                <input type="hidden" name = "id" value="<?php echo $id;?>">
                                <input type="text" name="name" id="name" class="form-control" required="required" value="<?php echo $row['name'];?>">
                            </div>
                        </div>

                        <div class="form-group form-group">
                            <label class="col-sm-2 control-label" for="description">Description</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="description" id="description" class="form-control" required="required" value="<?php echo $row['description'];?>">
                            </div>
                        </div>

                        <div class="form-group form-group">
                            <label class="col-sm-2 control-label" for="price">Price</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="price" id="price" class="form-control" required="required" value="<?php echo $row['price'];?>">
                            </div>
                        </div>

                        <div class="form-group form-group">
                            <label class="col-sm-2 control-label" for="country">Country of Made</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="country" id="country" class="form-control" required="required" value="<?php echo $row['countryMade'];?>">
                            </div>
                        </div>

                        <div class="form-group form-group">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10 col-md-6">
                                <select  name="status">
                                    <option value="0">...</option>
                                    <option value="1" <?php if($row['status'] == 1) echo "selected";?>>New</option>
                                    <option value="2" <?php if($row['status'] == 2) echo "selected";?>>Like New</option>
                                    <option value="3" <?php if($row['status'] == 3) echo "selected";?>>Used</option>
                                    <option value="4" <?php if($row['status'] == 4) echo "selected";?>>Very Old</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-group">
                            <label class="col-sm-2 control-label">Member</label>
                            <div class="col-sm-10 col-md-6">
                                <select  name="member">
                                    <option value="0">...</option>
<?php
                                    $query2 = "SELECT * FROM users";
                                    $res2 = mysqli_query($con, $query2);
                                    while ($row2 = mysqli_fetch_assoc($res2)){
                                        echo "<option value='".$row2['id']."'";
                                        if($row['mbr_id'] == $row2['id']) echo "selected";
                                        echo ">".$row2['username']."</option>";
                                    }
?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-group">
                            <label class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-10 col-md-6">
                                <select  name="category">
                                    <option value="0">...</option>
<?php
                                    $query3 = "SELECT * FROM categories";
                                    $res3 = mysqli_query($con, $query3);
                                    while ($row3 = mysqli_fetch_assoc($res3)){
                                        echo "<option value='".$row3['id']."'";
                                        if($row['cat_id'] == $row3['id']) echo "selected";
                                        echo ">".$row3['name']."</option>";
                                    }
?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save Item" class="btn btn-primary btn-md">
                                <input type="reset" value="Cancel" class="btn btn-danger btn-md">
                            </div>
                        </div>
                    </form>
                </div>
<?php
            }
        }

        //------------------------------------------------------------------

        elseif($do == "update"){
            echo "<h1 class='text-center'>Update Item</h1>";
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $id = $_POST['id'];
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $country = $_POST['country'];
                $status = $_POST['status'];
                $member= $_POST['member'];
                $category = $_POST['category'];

                $query = "update items set name = '$name', description = '$description', price = '$price', countryMade = '$country', 
                                           status = '$status', cat_id = '$category', mbr_id = '$member' where id = $id";
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

        elseif($do == "delete"){
            echo "<h1 class='text-center'>Delete Item</h1>";
            if(isset($_GET['id'])) {
                $check = checkItem("id", "items", $_GET['id'] );
                if($check == 1) {
                    $query = "delete from items WHERE id =" . $_GET['id'];
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

        elseif($do == "approve"){
            echo "<h1 class='text-center'>Approve Item</h1>";
            if(isset($_GET['id'])) {
                $check = checkItem("id", "items", $_GET['id'] );
                if($check == 1) {
                    $query = "update items set approve = 1 WHERE id =" . $_GET['id'];
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
    ob_end_flush();
?>