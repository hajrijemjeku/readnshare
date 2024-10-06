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
        
        
        ?>

        <div class="row mb-5">
            <!-- Column 2: One big image -->
            <div class="d-flex justify-content-center">
                <img id="big-image" src="./assets/images/books/<?= $getbook['image']; ?>" class="img-fluid mx-auto" alt="..." style="height:400px; width:300px; ">

            </div>
                
                

            <!-- Column 3: Book info -->
                <div class="p-3 border mt-5 mx-auto w-50 d-flex flex-column justify-content-center align-items-center">
                    <h4>Book Info</h4>
                    <p><strong>Title:    </strong>  <?php echo $getbook['title']; ?></p>
                    <p><strong>Price:   </strong>  <?php echo $getbook['price']; ?> &euro;</p>
                    <p><strong>Category:    </strong>  <?php echo $getbook['categoryid']; ?></p>
                    <p><strong>BookId:    </strong>  <?php echo $getbook['id']; ?></p>

                <!-- </div>
                <div class="p-3 border mt-3 w-50"> -->

                    <?php if(isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] === true)): ?>
                        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" class="d-inline" style="margin-left:140px;">
                            <input type="hidden" name="book_id" id="book_id" value="<?= $getbook['id'] ?>">
                            <input type="hidden" name="title" value="<?= $getbook['title'] ?>">
                            <input type="hidden" name="categoryid"  value="<?= $getbook['categoryid'] ?>">
                            <input type="hidden" name="price"  value="<?= $getbook['price'] ?>">
                            <input type="hidden" name="stock"  value="<?= $getbook['stock'] ?>">

                            <button name="add-to-cart" id="add-to-cart" class="btn-cart" type="submit">Add to cart   <i class="fa-solid fa-cart-shopping"></i></i></button>
                        </form>
                    <?php endif; ?>

                </div>
            <div class="row mt-4">
                <div class="col-12">
                    <hr class="mx-auto mt-5 border-secondary">
                </div>
            </div>
        </div>
        <?php endforeach; } else {
            echo "<h2>No books found.</h2>";
        } ?>

<div class="row mt-4 w-50 mx-auto">
    <div class="col-12">
        <h3 class="text-left mb-4">Reviews</h3>
        <div class="row">
            <?php
            $crudObj = new Crud($pdo);
            $reviews = $crudObj->select('review', [], ['bookid' => $_GET['book_id']], '', '');
            if ($reviews) {
                $reviews = $reviews->fetchAll();
                foreach ($reviews as $review):
                    $getuser = (new Crud($pdo))->select('person', [], ['id' => $review['userid']], 1, '')->fetch(); // Fetch user info for each review
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
            <?php } ?>
        </div>

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
        </form>
    </div>
</div>

<?php
    if(isset($_POST['addreview'])){
        $rating = $_POST['addrating'];
        $comment = $_POST['addcomment'];
        $bookid = $_POST['bookid'];

        if(!empty($rating) && !empty($comment)){
            $addreview = (new Crud($pdo))->insert('review',['rating', 'comment','bookid', 'userid'], [$rating, $comment, $bookid, $_SESSION['user_id']]);

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

