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

    // Delete Code
    if(isset($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "delete from tblbooks WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        
        $msg_title = "Deleted";
        $msg_content = "Book deleted successfully.";
        $msg_type = "success";
        $msg_redirect = "manage-books.php";
    }
?>
<?php include('../includes/header.php');?>

<div class="content-wrapper">
    <div class="container">
        <div class="heading">
            <span class="form-header">MANAGE BOOKS LIBRARY</span>
        </div>
        
        <div style="text-align: right; margin-bottom: 20px;">
            <a href="add-book.php" class="btn btn-info">ADD NEW BOOK</a>
        </div>

        <div class="panel">
            <div class="panel-heading">ALL BOOKS LIST</div>
            <div class="panel-body" style="padding: 0;">
                <div class="table-responsive">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Book Name</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>ISBN</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sql = "SELECT tblbooks.BookName,tblcategory.CategoryName,tblauthors.AuthorName,tblbooks.ISBNNumber,tblbooks.BookPrice,tblbooks.id as bookid from  tblbooks join tblcategory on tblcategory.id=tblbooks.CatId join tblauthors on tblauthors.id=tblbooks.AuthorId";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                
                                $cnt=1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) { ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt);?></td>
                                        <td><?php echo htmlentities($result->BookName);?></td>
                                        <td><?php echo htmlentities($result->CategoryName);?></td>
                                        <td><?php echo htmlentities($result->AuthorName);?></td>
                                        <td><?php echo htmlentities($result->ISBNNumber);?></td>
                                        <td><?php echo htmlentities($result->BookPrice);?></td>
                                        <td>
                                            <a href="edit-book.php?bookid=<?php echo htmlentities($result->bookid);?>" class="btn btn-info" style="padding: 5px 10px; font-size: 0.8rem; height: auto; margin:0;">Edit</a>
                                            <a href="manage-books.php?del=<?php echo htmlentities($result->bookid);?>" onclick="return confirm('Are you sure you want to delete?');" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.8rem; height: auto; margin:0;">Delete</a>
                                        </td>
                                    </tr>
                             <?php $cnt++; }
                                } ?>
                        </tbody>
                    </table>
                </div>
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
