<?php
    ob_start();
    session_start();
    $pageTitle = "Categories";
    if (isset($_SESSION['username'])){
        include "init.php";
        if(isset($_GET["do"])) $do = $_GET["do"];
        else $do = "manage";

        if($do == "manage"){
            $sort = "ASC";
            $sort_array = array("ASC", "DESC");
            if(isset($_GET["sort"]) && in_array($_GET["sort"], $sort_array)) $sort = $_GET["sort"];
            $query = "SELECT * FROM categories where parent = 0 order by ordering $sort";
            $res = mysqli_query($con, $query);
?>
            <h1 class="text-center">Manage Categories</h1>
            <div class="container categories">
                <a href='?do=add' class="add-category btn btn-primary"><i class="fa fa-plus"></i>New Category</a>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-edit"></i>Manage Categories
                        <div class="option pull-right">
                            <i class="fa fa-sort"></i>Ordering: [
                            <a class="<?php if($sort == 'ASC') echo 'active';?>" href="?sort=ASC">Asc</a> |
                            <a class="<?php if($sort == 'DESC') echo 'active';?>" href="?sort=DESC">Desc</a>]
                            <i class="fa fa-eye"></i>View: [
                            <span class="active" data-view="full">Full</span> |
                            <span>Classic</span>]
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                            while ($row = mysqli_fetch_assoc($res)) {
                                echo "<div class='cat'>";
                                    echo "<div class='hidden-buttons'>";
                                        echo "<a href='?do=edit&id=".$row['id']."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                                        echo "<a href='?do=delete&id=".$row['id']."' class='btn btn-xs btn-danger'><i class='fa fa-window-close'></i>Delete</a>";
                                    echo "</div>";
                                    echo "<h3>".$row['name'] . "</h3>";
                                    echo "<div class='full-view'>";
                                        if($row['description'] == "") echo "This Category has no Description</p>";
                                        else echo "<p>".$row['description'] . "</p>";
                                        if($row['visibility'] == 1)echo "<span class='visibility'><i class='fa fa-eye'></i>Hidden</span>";
                                        if($row['allowComments'] == 1)echo "<span class='commenting'>Comment disabled</span>";
                                        if($row['allowAds'] == 1)echo "<span class='advertises'>Ads disabled</span>";
                                    echo "</div>";
                                    $childCats = getAll("*", "categories", "where parent = {$row['id']}");
                                    if(!empty($childCats)) {
                                        echo "<h4 class='child-head'>Child Categories</h4>";
                                        echo "<ul class='list-unstyled child-cats'>";
                                        foreach ($childCats as $childCat){
                                            echo "<li class='child-link'>
                                                    <a href='?do=edit&id=".$childCat['id']."'>".$childCat['name']."</a>
                                                    <a href='?do=delete&id=".$childCat['id']."' class='show-delete pull-right'>Delete</a>
                                                </li>";
                                        }
                                    echo "</ul>";
                                }
                                echo "</div>";
                                echo "<hr>";
                            }
                        ?>
                    </div>
                </div>
            </div>
<?php
        }

        //-----------------------------------------------------------------

        elseif($do == "add"){
?>
            <h1 class="text-center">Add New Category</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=insert" method="post">
                    <div class="form-group form-group">
                        <label class="col-sm-2 control-label" for="name">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name" id="name" class="form-control" autocomplete="off" required="required">
                        </div>
                    </div>

                    <div class="form-group form-group">
                        <label class="col-sm-2 control-label" for="description">Description</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="description" id="description" class="form-control">
                        </div>
                    </div>

                    <div class="form-group form-group">
                        <label class="col-sm-2 control-label" for="ordering">Ordering</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="ordering" id="ordering" class="form-control">
                        </div>
                    </div>

                    <div class="form-group form-group">
                        <label class="col-sm-2 control-label" for="ordering">Parent Category</label>
                        <div class="col-sm-10 col-md-6">
                            <select  name="parent" required>
                                <option value="0">None</option>
                                <?php
                                    $categories = getAll("*", "categories", "where parent = 0", "", "", "ASC");
                                    foreach ($categories as $cat){
                                        echo "<option value='".$cat['id']."'>".$cat['name']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-group">
                        <label class="col-sm-2 control-label">Visible</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input type="radio" name="visibility" id="vis-yes" value="0" checked>
                                <label for="vis-yes">Yes</label>
                            </div>
                            <div>
                                <input type="radio" name="visibility" id="vis-no" value="1">
                                <label for="vis-no">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group">
                        <label class="col-sm-2 control-label">Allow Commenting</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input type="radio" name="commenting" id="com-yes" value="0" checked>
                                <label for="com-yes">Yes</label>
                            </div>
                            <div>
                                <input type="radio" name="commenting" id="com-no" value="1">
                                <label for="com-no">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group">
                        <label class="col-sm-2 control-label">Allow Ads</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input type="radio" name="ads" id="ads-yes" value="0" checked>
                                <label for="ads-yes">Yes</label>
                            </div>
                            <div>
                                <input type="radio" name="ads" id="ads-no" value="1">
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Add Category" class="btn btn-primary btn-md">
                            <input type="reset" value="Cancel" class="btn btn-danger btn-md">
                        </div>
                    </div>
                </form>
            </div>
<?php
        }

        //-----------------------------------------------------------------

        elseif($do == "insert"){
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                echo "<h1 class='text-center'>Insert Category</h1>";
                $name = $_POST['name'];
                $description = $_POST['description'];
                $ordering = $_POST['ordering'];
                $parent = $_POST['parent'];
                $visibility = $_POST['visibility'];
                $commenting = $_POST['commenting'];
                $ads = $_POST['ads'];

                $check = checkItem("name", "categories", $name );
                if($check == 1){
                    echo "<div class='container'>";
                    $theMsg = "<div class='alert alert-danger'> Sorry this Category already exists.</div>";
                    redirectHome($theMsg, "back");
                    echo "</div>";
                }
                else{
                    $query = "insert into categories (name, description, ordering, parent, visibility, allowComments, allowAds) 
                      VALUES ('$name', '$description', '$ordering', '$parent', '$visibility', '$commenting', '$ads')";
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

        //------------------------------------------------------------------

        elseif($do == "edit"){
            if (isset($_GET['id']) && is_numeric($_GET['id'])) $id = intval($_GET['id']);
            else $id = 0;

            $query = "SELECT * FROM categories WHERE id = $id";
            $res = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($res);
            $count = $res->num_rows;
            if ($count > 0) {
?>
                <h1 class="text-center">Edit Category</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=update" method="post">
                        <div class="form-group form-group">
                            <label class="col-sm-2 control-label" for="name">Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="name" id="name" class="form-control" required="required" value="<?php echo $row['name'];?>">
                                <input type="hidden" name = "id" value="<?php echo $row['id'];?>">
                            </div>
                        </div>

                        <div class="form-group form-group">
                            <label class="col-sm-2 control-label" for="description">Description</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="description" id="description" class="form-control" value="<?php echo $row['description'];?>">
                            </div>
                        </div>

                        <div class="form-group form-group">
                            <label class="col-sm-2 control-label" for="ordering">Ordering</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="ordering" id="ordering" class="form-control" value="<?php echo $row['ordering'];?>">
                            </div>
                        </div>

                        <div class="form-group form-group">
                            <label class="col-sm-2 control-label" for="ordering">Parent Category <?php echo $row['parent'];?></label>
                            <div class="col-sm-10 col-md-6">
                                <select  name="parent" required>
                                    <option value="0">None</option>
                                    <?php
                                    $categories = getAll("*", "categories", "where parent = 0", "", "", "ASC");
                                    foreach ($categories as $cat){
                                        echo "<option value='".$cat['id']."'";
                                        if($row['parent'] == $cat['id']){echo "selected";}
                                        echo ">".$cat['name']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-group">
                            <label class="col-sm-2 control-label">Visible</label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input type="radio" name="visibility" id="vis-yes" value="0" <?php if ($row['visibility'] == 0) echo "checked";?>>
                                    <label for="vis-yes">Yes</label>
                                </div>
                                <div>
                                    <input type="radio" name="visibility" id="vis-no" value="1" <?php if ($row['visibility'] == 1) echo "checked";?>>
                                    <label for="vis-no">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-group">
                            <label class="col-sm-2 control-label">Allow Commenting</label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input type="radio" name="commenting" id="com-yes" value="0" <?php if ($row['allowComments'] == 0) echo "checked";?>>
                                    <label for="com-yes">Yes</label>
                                </div>
                                <div>
                                    <input type="radio" name="commenting" id="com-no" value="1" <?php if ($row['allowComments'] == 1) echo "checked";?>>
                                    <label for="com-no">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-group">
                            <label class="col-sm-2 control-label">Allow Ads</label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input type="radio" name="ads" id="ads-yes" value="0" <?php if ($row['allowAds'] == 0) echo "checked";?>>
                                    <label for="ads-yes">Yes</label>
                                </div>
                                <div>
                                    <input type="radio" name="ads" id="ads-no" value="1" <?php if ($row['allowAds'] == 1) echo "checked";?>>
                                    <label for="ads-no">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save" class="btn btn-primary btn-md">
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
            echo "<h1 class='text-center'>Update Category</h1>";
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $id = $_POST['id'];
                $name = $_POST['name'];
                $description = $_POST['description'];
                $ordering = $_POST['ordering'];
                $parent = $_POST['parent'];
                $visibility = $_POST['visibility'];
                $commenting = $_POST['commenting'];
                $ads = $_POST['ads'];

                $query = "update categories set name = '$name', description = '$description', ordering = '$ordering', parent = '$parent', visibility = '$visibility',
                          allowComments = '$commenting', allowAds = '$ads' WHERE id = $id";
                $res = mysqli_query($con, $query);

                echo "<div class='container'>";
                if($res)$theMsg = "<div class='alert alert-success'> 1 record updated.</div>";
                else $theMsg = "<div class='alert alert-danger'> 0 records updated.</div>";
                redirectHome($theMsg, "back");
                echo "</div>";
            }
            else{
                echo "<div class='container'>";
                $theMsg = "<div class='alert alert-danger'> Sorry you can't browse this page directly.</div>";
                redirectHome($theMsg, "back");
                echo "</div>";
            }
        }

        //------------------------------------------------------------------

        elseif($do == "delete"){
            echo "<h1 class='text-center'>Delete Category</h1>";
            if(isset($_GET['id'])) {
                $check = checkItem("id", "categories", $_GET['id'] );
                if($check == 1) {
                    $query = "delete from categories WHERE id =" . $_GET['id'];
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

        include $tpl."_footer.php";
    }
    //--------------------------------------------------------------------
    else{
        header("location:index.php");
        exit();
    }
    ob_end_flush();
?>