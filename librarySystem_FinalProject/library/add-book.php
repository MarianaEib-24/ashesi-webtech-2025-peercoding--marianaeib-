<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Initialize Modal
    $msg_title = "";
    $msg_content = "";
    $msg_type = "";
    $msg_redirect = "";

    if(isset($_POST['add'])) {
        $bookname = $_POST['bookname'];
        $category = $_POST['category'];
        $author = $_POST['author'];
        $isbn = $_POST['isbn'];
        $price = $_POST['price'];
        
        // Image logic can be added here, for now usingplaceholder or text
        $bookimg = "default-book.png"; 

        $sql = "INSERT INTO tblbooks(BookName,CatId,AuthorId,ISBNNumber,BookPrice,bookImage,isIssued) VALUES(:bookname,:category,:author,:isbn,:price,:bookimg,NULL)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bookname', $bookname, PDO::PARAM_STR);
        $query->bindParam(':category', $category, PDO::PARAM_STR);
        $query->bindParam(':author', $author, PDO::PARAM_STR);
        $query->bindParam(':isbn', $isbn, PDO::PARAM_STR);
        $query->bindParam(':price', $price, PDO::PARAM_STR);
        $query->bindParam(':bookimg', $bookimg, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        
        if($lastInsertId) {
            $msg_title = "Success";
            $msg_content = "Book Listed Successfully";
            $msg_type = "success";
            $msg_redirect = "manage-books.php"; // Redirect to list
        } else {
            $msg_title = "Error";
            $msg_content = "Something went wrong. Please try again";
            $msg_type = "error";
        }
    }
?>
<?php include('../includes/header.php');?>

<div class="content-wrapper">
    <div class="container">
        <div class="heading">
            <span class="form-header">ADD NEW BOOK</span>
        </div>

        <div class="panel" style="max-width: 600px;">
            <div class="panel-heading">BOOK INFO</div>
            <div class="panel-body">
                <form method="post">
                    
                    <div class="form-group">
                        <label>Book Name</label>
                        <input class="form-control" type="text" name="bookname" required>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" name="category" required>
                            <option value="">Select Category</option>
                            <?php 
                                $sql = "SELECT id,CategoryName from tblcategory where Status=1";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                if($query->rowCount() > 0) {
                                    foreach($results as $result) { ?>
                                        <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->CategoryName);?></option>
                            <?php }} ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Author</label>
                         <select class="form-control" name="author" required>
                            <option value="">Select Author</option>
                            <?php 
                                $sql = "SELECT id,AuthorName from tblauthors";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                if($query->rowCount() > 0) {
                                    foreach($results as $result) { ?>
                                        <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->AuthorName);?></option>
                            <?php }} ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>ISBN Number</label>
                        <input class="form-control" type="text" name="isbn" required>
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input class="form-control" type="text" name="price" required>
                    </div>
                
                    <button type="submit" name="add" class="btn btn-info">ADD BOOK</button>
                    
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php');?>
<script>
    <?php if($msg_title != "") { ?>
        showModal('<?php echo $msg_title;?>', '<?php echo $msg_content;?>', '<?php echo $msg_type;?>', '<?php echo $msg_redirect;?>');
    <?php } ?>
</script>
<?php } ?>
