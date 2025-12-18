<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:landingpage.php');
} else {
?>
<?php include('../includes/header.php');?>

<div class="content-wrapper">
    <div class="container">
        <div class="heading">
            <span class="form-header">LIBRARY CATALOG</span>
        </div>

        <!-- Search Bar -->
        <div class="panel" style="margin-bottom: 30px; max-width: 800px;">
            <div class="panel-body">
                <form method="get">
                    <div style="display: flex; gap: 10px;">
                        <input type="text" name="search" class="form-control" placeholder="Search by Book Name, Author, or Category..." value="<?php echo htmlentities($_GET['search']); ?>">
                        <button type="submit" class="btn btn-info" style="width: auto; margin-bottom: 0;">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Books Grid -->
        <div class="dashboard-grid">
            <?php 
                $sql = "SELECT tblbooks.BookName,tblcategory.CategoryName,tblauthors.AuthorName,tblbooks.ISBNNumber,tblbooks.bookImage,tblbooks.isIssued,tblbooks.id as bookid from  tblbooks join tblcategory on tblcategory.id=tblbooks.CatId join tblauthors on tblauthors.id=tblbooks.AuthorId";
                
                if(isset($_GET['search']) && !empty($_GET['search'])){
                    $searchkey = $_GET['search'];
                    $sql .= " WHERE tblbooks.BookName LIKE :search OR tblauthors.AuthorName LIKE :search OR tblcategory.CategoryName LIKE :search";
                }

                $query = $dbh->prepare($sql);
                if(isset($_GET['search']) && !empty($_GET['search'])){
                    $bindsearch = "%$searchkey%";
                    $query->bindParam(':search', $bindsearch, PDO::PARAM_STR);
                }
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                if ($query->rowCount() > 0) {
                    foreach ($results as $result) { ?>
                        <div class="stat-card" style="text-align: left; border-left: none; border-top: 4px solid var(--primary-color); display: flex; flex-direction: column; height: 100%;">
                            <div style="height: 250px; overflow: hidden; margin-bottom: 15px; border-radius: 4px; display: flex; align-items: center; justify-content: center; background: #f9f9f9;">
                                <?php if($result->bookImage=="") { ?>
                                    <img src="../assets/img/book-icon.png" width="100">
                                <?php } else { ?>
                                    <img src="bookimg/<?php echo htmlentities($result->bookImage);?>" width="150" style="height: 100%; object-fit: contain;">
                                <?php } ?>
                            </div>
                            
                            <h4 style="margin-bottom: 5px; color: var(--text-main); font-weight: 700; font-size: 1.1rem;"><?php echo htmlentities($result->BookName);?></h4>
                            <p style="font-size: 0.9rem; color: var(--text-light); margin-bottom: 5px;">
                                By <strong><?php echo htmlentities($result->AuthorName);?></strong>
                            </p>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 15px;">
                                <?php echo htmlentities($result->CategoryName);?>
                            </p>
                            
                            <div style="margin-top: auto; display: flex; justify-content: space-between; align-items: center;">
                                <?php if($result->isIssued=='1'): ?>
                                    <span style="background: #e74c3c; color: white; padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: bold;">Issued</span>
                                <?php else: ?>
                                    <span style="background: #27ae60; color: white; padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: bold;">Available</span>
                                    <a href="request-book.php?bookid=<?php echo htmlentities($result->bookid);?>" class="btn btn-primary" onclick="return confirm('Do you want to request this book?');" style="margin-bottom: 0; padding: 5px 15px; font-size: 0.8rem;">Request</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <p style="grid-column: 1/-1; text-align: center;">No books found.</p>
                <?php } ?>
        </div>
    </div>
</div>

<?php include('../includes/footer.php');?>
<?php } ?>
