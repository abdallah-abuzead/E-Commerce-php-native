<?php
session_start();
$pageTitle = "Create New Item";
include "init.php";
if(isset($_SESSION['user'])) {
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $formErrors = array();

        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
        $country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
        $status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
        $category = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);

        if(strlen($name) < 4) $formErrors[] = "Name must be at least 4 characters";
        if(strlen($description) < 10) $formErrors[] = "Description must be at least 10 characters";
        if(strlen($country) < 2) $formErrors[] = "Country must be at least 2 characters";
        if(empty($price)) $formErrors[] = "Not valid Price";
        if(empty($status)) $formErrors[] = "Not valid Status";
        if(empty($category)) $formErrors[] = "Not valid Category";

        if(empty($formErrors)) {
            $query = "insert into items (name, description, price, countryMade, status, addDate, cat_id, mbr_id)
                  VALUES ('$name', '$description', '$price', '$country', '$status', now(), $category, ".$_SESSION['uid'].")";
            $res = mysqli_query($con, $query);
            if($res) $successMsg = "1 item had been added.";
        }
    }
    ?>
    <h1 class="text-center"><?php echo $pageTitle;?></h1>
    <div class="create-ad block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading"><?php echo $pageTitle;?></div>
                <div class="panel-body">
                    <div class="col-md-8">
                        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                            <div class="form-group form-group">
                                <label class="col-sm-3 control-label" for="name">Name</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="name" id="name" class="form-control live" data-class=".live-title"
                                           required="required" pattern=".{4,}" title="Name must be at least 4 characters">
                                </div>
                            </div>

                            <div class="form-group form-group">
                                <label class="col-sm-3 control-label" for="description">Description</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="description" id="description" class="form-control live" data-class=".live-description"
                                           required="required" pattern=".{10,}" title="Description must be at least 10 characters">
                                </div>
                            </div>

                            <div class="form-group form-group">
                                <label class="col-sm-3 control-label" for="price">Price</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="price" id="price" class="form-control live" data-class=".live-price" required="required">
                                </div>
                            </div>

                            <div class="form-group form-group">
                                <label class="col-sm-3 control-label" for="country">Country of Made</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="country" id="country" class="form-control" required="required">
                                </div>
                            </div>

                            <div class="form-group form-group">
                                <label class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-10 col-md-9">
                                    <select  name="status" required>
                                        <option value="0">...</option>
                                        <option value="1">New</option>
                                        <option value="2">Like New</option>
                                        <option value="3">Used</option>
                                        <option value="4">Very Old</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-group">
                                <label class="col-sm-3 control-label">Category</label>
                                <div class="col-sm-10 col-md-9">
                                    <select  name="category" required>
                                        <option value="0">...</option>
                                        <?php
                                        $rows = getAll("*", "categories");
                                        foreach ($rows as $row){
                                            echo "<option value='".$row['id']."'>".$row['name']."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <input type="submit" value="Add Item" class="btn btn-primary btn-md">
                                    <input type="reset" value="Cancel" class="btn btn-danger btn-md">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <div class="thumbnail item-box live-preview">
                            <span class="price-tag">
                                $
                                <span class="live-price"></span>
                            </span>
                            <img class="img-responsive" src="img.png">
                            <div class="caption">
                                <h3 class="live-title">Title</h3>
                                <p class="live-description">Description</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if(!empty($formErrors)){
                    foreach ($formErrors as $error)
                        echo "<div class='alert alert-danger'>".$error."</div>";
                }
                if(isset($successMsg)){
                    echo "<div class='alert alert-success success'>$successMsg</div>";
                }
                ?>
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