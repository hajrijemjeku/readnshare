<?php include('includes/header.php'); ?>
<section class="product-details py-5">
    <div class="container mt-4 mx-auto">
        

        <?php
            if(isset($_GET['book_id']) && !empty($_GET['book_id'])){
                $getbooks = (new Crud($pdo))->select('book',[],['id'=> $_GET['book_id']],'','')->fetchAll(); ?> 
                <h2 class="text-center mb-5" style="color:darkolivegreen;"> Book Details</h2>
                
            <?php
            // $reviews = (new Crud($pdo))->select('review', [], ['bookid'=>$_GET['book_id']], '', '');
            }
            if(isset($_GET['genre_id']) && !empty($_GET['genre_id'])){
                $getbooks = (new Crud($pdo))->select('book',[],['genreid'=> $_GET['genre_id']],'','')->fetchAll(); 
                $getgenre = (new Crud($pdo))->select('genre',[],['id'=> $_GET['genre_id']],'','')->fetch(); ?> 
                <h2 class="text-center mb-5" style="color:darkolivegreen;"> Books in the Genre of: <strong> <?= $getgenre['name'];?> </strong>  </h2>
                <?php

            }
            if(isset($_GET['category_id']) && !empty($_GET['category_id'])){
                $getbooks = (new Crud($pdo))->select('book',[],['categoryid'=> $_GET['category_id']],'','')->fetchAll(); 
                $getcategory = (new Crud($pdo))->select('category',[],['id'=> $_GET['category_id']],'','')->fetch(); ?> 
                <h2 class="text-center mb-5" style="color:darkolivegreen;"> Books in the Category of: <strong> <?= $getcategory['name'];?> </strong>  </h2>
                <?php

            }
            if (isset($getbooks) && !empty($getbooks)) {
                foreach($getbooks as $getbook):

                    $categoryname = (new Crud($pdo))-> select('category',[],['id'=> $getbook['categoryid']],1,'')->fetch();
                    $genrename = (new Crud($pdo))-> select('genre',[],['id'=> $getbook['genreid']], 1,'')->fetch();
                    
        
        
        ?>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 d-flex flex-column align-items-center">
            <div class="d-flex flex-column align-items-center">
                <!-- Big Image -->
                <img id="big-image" src="./assets/images/books/<?= $getbook['image']; ?>" class="img-fluid mb-3" alt="Book Image" style="max-height: 400px; width: auto; border-radius: 10px;">

                <!-- Book Info -->
                <div class="info-box p-4 border rounded text-center" style="width: 100%;">
                    <h2 class="font-weight-bold"><?= $getbook['title']; ?></h2>
                    <p><strong>Condition:</strong> <?= ($getbook['isnew'] == 0) ? 'Old' : 'New'; ?></p>
                    <p><strong>Price:</strong> <?= $getbook['price']; ?> &euro;</p>
                    <p><strong>Category:</strong> <?= $categoryname['name']; ?></p>
                    <p><strong>Stock:</strong> <?= $getbook['stock']; ?></p>
                    <p><strong>Published Year:</strong> <?= $getbook['published_year']; ?></p>
                    <p><strong>Language:</strong> <?= $getbook['language']; ?></p>
                    <p><strong>Genre:</strong> <?= $genrename['name']; ?></p>
                    <p><strong>Description:</strong> <?= $getbook['description']; ?></p>

                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <form action="my-items.php" method="POST" class="mt-3">
                            <input type="hidden" name="book_id" value="<?= $getbook['id'] ?>">
                            <input type="hidden" name="book_title" value="<?= $getbook['title'] ?>">
                            <input type="hidden" name="book_price" value="<?= $getbook['price'] ?>">

                            <?php if ($getbook['stock'] > 0): ?>
                                <input type="number" name="book_stock" value="1" min="1" max="<?= $getbook['stock']; ?>" class="form-control mb-2" style="width: 80px; display: inline-block;">
                                <button name="add-to-cart" type="submit" class="btn btn-primary">Add to Cart</button>
                            <?php else: ?>
                                <p class="text-danger">Out of Stock!</p>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-4">
</div>

        <?php endforeach; } else {
            echo "<h2>No books found.</h2>";
        } ?>

<div class="row mt-4 w-50 mx-auto">
    <div class="col-12">
        
        <div class="row">
            <?php if(isset($_GET['book_id'])):
            echo '<h3 class="text-left mb-4">Reviews</h3>';
            $crudObj = new Crud($pdo);
            $reviews = $crudObj->select('review', [], ['bookid' => $_GET['book_id']], '', '');
            if ($reviews) {
                $reviews = $reviews->fetchAll();
                foreach ($reviews as $review):
                    $getuser = (new Crud($pdo))->select('person', [], ['id' => $review['personid']], 1, '')->fetch(); // Fetch user info for each review
            ?>
            <div class="col-12 mb-4">
                <div class="border p-3 rounded" style="background-color: #f8f9fa;">
                    <div class="row">
                        <!-- User ID on the left -->
                        <div class="col-6">
                            <h5 class="mb-0"><?= $getuser['name'] . ' ' . $getuser['surname']; ?></h5>
                        </div>

                        <!-- Rating and Date on the right -->
                        <div class="col-6 text-end">
                            <span class="badge bg-primary"><?= $review['rating']; ?> ⭐</span>
                            <span class="text-muted ms-2"><?= (new DateTime($review['created_at']))->format('Y-m-d'); ?></span>
                        </div>
                    </div>

                    <!-- Comment below rating -->
                    <div class="row mt-2">
                        <div class="col-12">
                            <p class="mb-0">Comment:  <?= $review['comment']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; } else { ?>
            <div class="col-12 mb-4">
                <div class="alert alert-info" role="alert">
                    No reviews available for this book.
                </div>
            </div>
            <?php };  ?>
        </div>
        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>

        <h4 class="mt-4">Add a Review</h4>
        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mt-3">
            <input type="hidden" id="bookid" name="bookid" value="<?= $_GET['book_id'] ?>">
            <div class="mb-3">
                <label for="addrating" class="form-label">Rating (1-5)</label>
                <input type="number" min="1" max="5" id="addrating" name="addrating" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="addcomment" class="form-label">Comment</label>
                <input type="text" id="addcomment" name="addcomment" class="form-control" placeholder="Add comment" required>
            </div>
            <button type="submit" name="addreview" class="btn btn-primary">Add Review</button>
        </form> <?php endif; endif;?>
    </div>
</div>

<?php
    if(isset($_POST['addreview'])){
        $rating = $_POST['addrating'];
        $comment = $_POST['addcomment'];
        $bookid = $_POST['bookid'];

        if(!empty($rating) && !empty($comment)){
            $addreview = (new Crud($pdo))->insert('review',['rating', 'comment','bookid', 'personid'], [$rating, $comment, $bookid, $_SESSION['user_id']]);

            if($addreview){
                header('Location: ' . $_SERVER['PHP_SELF'] . '?book_id=' . $bookid);
            }else{
                header('Location:books.php');
            }
        }
    }


?>


</section>
<?php include('includes/footer.php'); ?>

