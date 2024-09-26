<?php include('includes/header.php'); ?>
<section class="product-details py-5">
    <div class="container mt-4 mx-auto">
        

        <?php
            if(isset($_GET['book_id']) && !empty($_GET['book_id'])){
                $getbooks = (new Crud($pdo))->select('book',[],['id'=> $_GET['book_id']],'','')->fetchAll(); ?> 
                <h2 class="text-center mb-5" style="color:darkolivegreen;"> Book Details</h2>
            <?php
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
                            <input type="hidden" name="title" value="<?= $getbook['name'] ?>">
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
        <?php endforeach; ?>



    </div>



</section>
<?php include('includes/footer.php'); ?>

