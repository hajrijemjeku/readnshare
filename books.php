<?php include('includes/header.php') ?>


<section class="books py-5">
    <div class="container">
    <div class="row mt-4">

                 <?php
                      $crudObj = new Crud($pdo);
                      if (isset($_GET['search-btn'])) {
                        if (isset($_GET['search-value']) && !empty($_GET['search-value'])) {
                            $all_books = $crudObj->search('book',[],['title'=> $_GET['search-value']] ,'')->fetchAll();
                            if(count($all_books) == 0){
                                echo " <h2 class='text-center mb-5' style='color:darkolivegreen;'> 0 results with searched data!</h2>" ;
                            } else{
                                echo " <h2 class='text-center mb-5' style='color:darkolivegreen;'> Results with :<strong> <u> {$_GET['search-value']}  </u></strong></h2>" ;
                            }

                        } else {
                            echo " <h2 class='text-center mb-5' style='color:darkolivegreen;'> It looks like you didn’t enter anything. Please type a title or author to search for books. </h2>" ;
                            exit;

                        } 
                    
                    
                    
                    }else{
                            $all_books = $crudObj->select('book',[],[] ,'', '')->fetchAll();
                            if(count($all_books)  > 0){
                                echo '<h2 class="text-center mb-5" style="font-family: Arial, sans-serif; font-weight: bold; color: #7b9b77;">All Books</h2>
';
                            }
                        }
                    
                      
                      if($all_books):
                      foreach($all_books as $a_book):
                        
                      
                 ?>
                <div class="col-lg-3 col-md-3 col-sm-12 mb-3" >
                    <a href="book_details.php?book_id=<?=$a_book['id'];?>" class="text-decoration-none">
                        <div class="card" style="width: 18rem; height:500px;">
                            <input type="hidden" name="book_id" id="book_id" value="<?= $a_book['id'] ?>">
                            <img src="./assets/images/books/<?= $a_book['image']; ?>" class="card-img-top" alt="..." height="300px">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $a_book['title'] ?></h5>
                                <p class="card-text"> 
                                    Price: <strong> <?php echo number_format($a_book['price'],2);  ?> &euro; </strong> / Category: <strong><?= $a_book['categoryid'] ?> </strong>
                                </p>

                                <?php if(isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] === true)): ?>
                                    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" class="d-inline" style="margin-left:140px;">
                                        <input type="hidden" name="book_id" id="book_id" value="<?= $a_book['id'] ?>">
                                        <input type="hidden" name="title" value="<?= $a_book['title'] ?>">
                                        <input type="hidden" name="size"  value="<?= $a_book['size'] ?>">
                                        <input type="hidden" name="price"  value="<?= $a_book['price'] ?>">
                                        <input type="hidden" name="stock"  value="<?= $a_book['stock'] ?>">

                                        <button name="add-to-cart" id="add-to-cart" class="btn-cart" type="submit"><i class="fa-solid fa-cart-shopping"></i></i></button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>

                <?php endforeach; endif; ?>
            
        </div>

    </div>





</section>























<?php include('includes/footer.php') ?>
