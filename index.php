<?php include('includes/header.php'); ?>
<?php
$errors = [];   
if (isset($_SESSION['success_message'])) {
    echo $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

if(isset($_POST['add-to-cart'])){
    
    $book_id = $_POST['book_id'];
    $book_title = $_POST['book_title'];
    $book_price = $_POST['book_price'];
    $book_qty = $_POST['book_stock'];


    if(isset($_SESSION['cart'])){
        if(array_key_exists($book_id, $_SESSION['cart'])){
            
            $_SESSION['cart'][$book_id]['stock'] += $book_qty;
            
        }else{
            $_SESSION['cart'][$book_id] = [
                'id' => $book_id,
                'title' => $book_title,
                'price' => $book_price,
                'stock' => $book_qty
            ];
        }
    }else{
        $_SESSION['cart'] = [];
        $_SESSION['cart'][$book_id] = [
            'id' => $book_id,
            'title' => $book_title,
            'price' => $book_price,
            'stock' => $book_qty
        ];

    }
    header('Location:my-items.php');

}

?>


<section class="slider" style="position:relative;">
    <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner p-3 my-3">
            <div class="carousel-item active">
                <img src="./assets/images/slider/5.png" class="d-block w-100" height="450px" alt="...">
            </div>
            <div class="carousel-item">
                <img src="./assets/images/slider/2.jpg" class="d-block w-100" height="450px" alt="...">
            </div>
            <div class="carousel-item">
                <img src="./assets/images/slider/1.png" class="d-block w-100" height="450px" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<section class="index py-5">
<div class="container mt-4">
<h2 class="text-center mb-3" style="font-family: Arial, sans-serif; font-weight: bold; color: #7b9b77;">Our Latest Books</h2>
    <div class="row">

            <div class="row mt-4">
                <?php
                $crudObj = new Crud($pdo);
                $allbooks = $crudObj->select('book', [], [], 4, '');
               
                if ($allbooks) {
                    $allbooks = $allbooks->fetchAll();
                    foreach ($allbooks as $book):
                        $stock = $crudObj->select('book',['stock'],['id'=>$book['id']],'','')->fetch();
                ?>
                <div class="col-md-6 col-lg-12 mb-4">
                    <div class="list-group">
                        
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <a  <?php if($book['stock'] > 0):?> href="book_details.php?book_id=<?= $book['id']; ?>" <?php endif;?> style="width:200px;"> 
                                <img src="./assets/images/books/<?= $book['image']; ?>" class="card-img-top p-3" style="height:250px" alt="<?= $book['image']; ?>">
                            </a>
                            <div class="book-details text-center" style="flex-grow: 1;">
                                <a <?php if($book['stock'] > 0):?> href="book_details.php?book_id=<?= $book['id']; ?>" <?php endif;?> style="text-decoration: none; color: inherit;">
                                    <h5 class="mb-1"><?= $book['title']; ?></h5>
                                    <p class="mb-1">Price: <strong><?= number_format($book['price'], 2); ?> &euro;</strong></p>
                                    <p class="mb-1">Language: <strong><?= $book['language']; ?></strong></p>
                                </a>
                            </div>
                            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" class="d-flex align-items-center">
                                <input type="hidden" name="book_id" value="<?= $book['id']; ?>">
                                <input type="hidden" name="book_title" value="<?= $book['title']; ?>">
                                <input type="hidden" name="book_price" value="<?= $book['price']; ?>">
                                 <?php if($book['stock'] > 0): ?>
                                <input type="number" name="book_stock" value="1" min="1" max="<?= $stock['stock'];?>" class="form-control me-2" style="width: 60px;">
                                <button name="add-to-cart" type="submit" class="btn btn-success">Add to Cart</button>
                                <?php endif; if($book['stock'] == 0):?>
                                    <h5 class="mb-1" style="color:red;">Out of Stock!</h5>
                                    <?php endif; ?>

                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; } ?>
            </div>
    </div>

    <div class="row">
        <div class="col-12">
            <hr class="mx-auto mt-5 border-secondary">
        </div>
        
    </div>



    <div class="row mt-4">
        <h2 class="text-center mb-5" style="font-family: Arial, sans-serif; font-weight: bold; color: #7b9b77;">Best Sellers</h2>

                <!-- Best seller books prej db me while -->
                 <?php
                      $crudObj = new Crud($pdo);
                      $bs_books = $crudObj->select('book',[],['categoryid'=>3] ,3, '');
                      if($bs_books):
                      while($bs_book = $bs_books->fetch()):
                        $stock = $crudObj->select('book',['stock'],['id'=>$bs_book['id']],'','')->fetch();

                        
                      
                 ?>
                <div class="col-lg-3 col-md-3 col-sm-12 mx-auto">
                    <div class="card" style="width: 18rem;">
                        
                        <img src="./assets/images/books/<?php echo $bs_book['image']; ?>" class="card-img-top" alt="..." height="300px">
                        <a href="book_details.php?book_id=<?= $bs_book['id']; ?>" class="btn btn-secondary mt-3 w-50" style="margin-left:70px;"> View Details</a>
                    <div class="card-body">
                            <h5 class="card-title"><?php echo $bs_book['title'] ?></h5>
                            <p class="card-text"> <?php echo number_format($bs_book['price'],2);  ?> &euro;</p>
                            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" class="d-flex justify-content-between">
                                <input type="hidden" name="book_id" id="book_id" value="<?= $bs_book['id'] ?>">
                                <input type="hidden" name="book_title" id="book_title" value="<?= $bs_book['title'] ?>">
                                <input type="hidden" name="book_price" id="book_price" value="<?= $bs_book['price'] ?>">

                                <?php if($bs_book['stock'] > 0): ?>
                                <input type="number" name="book_stock" value="1" min="1" max="<?= $stock['stock'];?>" class="form-control me-2" style="width: 60px;">
                                <button name="add-to-cart" type="submit" class="btn btn-primary mx-2">Add to Cart</button>
                                <?php endif; if($bs_book['stock'] == 0):?>
                                    <h5 class="mb-1" style="color:red;">Out of Stock!</h5>
                                    <?php endif; ?>
                             </form>
                        </div>
                    </div>
                </div>

                <?php endwhile; endif; ?>
            
        </div>

        <div class="row">
            <div class="col-12">
                <hr class="mx-auto mt-5 border-secondary">
            </div>
        </div>

        
    <div class="row mt-4">
        <h2 class="text-center mb-5" style="font-family: Arial, sans-serif; font-weight: bold; color: #7b9b77;">About Us</h2>
        <div class="row text-center mb-5">
            <div class="col-12">
                <h5 class="font-weight-bold text-success">
                    Welcome to ReadNShare!
                </h5>
                <p class="lead mt-3">
                    At ReadNShare, we celebrate the joy of reading. Our mission is to connect book lovers with a diverse selection of titles, from bestsellers to hidden gems. We believe that every book has a story to tell and the power to inspire.
                </p>
            </div>
        </div>

        <div class="col col-lg-6 col-md-6 col-sm-12 px-5" style="height:500px;">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <?php
                    $bookimgs = (new CRUD($pdo))->select('book',[],[],'','');
                    $bookimgs = $bookimgs->fetchAll();
                    foreach($bookimgs as $index => $bookimg): ?>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?= $index; ?>" class="<?= $index === 0 ? 'active' : ''; ?>" aria-current="true" aria-label="Slide <?= $index + 1; ?>"></button>
                    <?php endforeach; ?>
                </div>
                <div class="carousel-inner">
                    <?php foreach($bookimgs as $index => $bookimg): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                            <img src="./assets/images/books/<?= $bookimg['image']; ?>" class="d-block w-100 mt-5" height="400px" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h3 class="text-light bg-secondary"><?= $bookimg['title']; echo ", " . $bookimg['price'];?> &euro;
                            
                                </h3>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12" style="height:500px;">
            <div class="text-center py-5 my-5 bg-light rounded shadow-sm">
                <h4 class="font-weight-bold text-success">What We Offer?</h4>
                <p class="lead">Curated Book Recommendations: Explore a wide range of genres to find your next great read.</p>
                <p class="lead">Community Engagement: Share reviews, thoughts, and connect with fellow readers.</p>
                <br>
                <p class="mt-4">Thank you for visiting ReadNShare! We hope you discover something special.<br>
                <strong>Happy reading!</strong></p>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-12">
            <hr class="mx-auto mt-5 border-secondary">
        </div>
    </div>


    <div class="row mt-4">
        <h2 class="text-center mb-5" style="font-family: Arial, sans-serif; font-weight: bold; color: #7b9b77;">Subscribe</h2>
        <div class="col-md-8 col-lg-6 mx-auto text-center">
            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="input-group mb-3">
                    <input type="email" name="email-subscribe" class="form-control" placeholder="Enter your email" aria-label="Email" required>
                    <button class="btn btn-success" name="subscribe-btn" type="submit">Subscribe</button>
                </div>
            </form>
            <p class="mt-3">Stay updated with the latest books and offers!</p>
        </div>
    </div>



</div>
</section>


<!-- Subscribe code -->
<?php
    if(isset($_POST['subscribe-btn'])){
        $email = $_POST['email-subscribe'];

        if(!empty($email)){
            if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                $checkemail = (new Crud($pdo))->select('subscribers',[],['email'=>$email],1,'');
                $checkemail = $checkemail ? $checkemail->fetch() : null;
                // echo "<pre>";
                // var_dump($checkemail); 
                // echo "</pre>";

                if ($checkemail && isset($checkemail['email']) && $checkemail['email'] === $email) {
                    $errors[] =  "This email '$email' already subscribed!";
                }else{
                    $subscribeemail = (new Crud($pdo))->insert('subscribers',['email'],[$email]);
                    if($subscribeemail){
                        $_SESSION['success_message'] = '<h3 class="alert alert-info text-center"> Email ' .$email. ' subscribed successfully! </h3>';
                        header('Location:index.php');
                    }else{
                        $errors[] = 'Something went wrong! Please try again to subscribe!';
                    }
                  
                    
                    
                }
            }else{
                $errors[] = 'Invalid Email';
            }
        }else{
            $errors[] = 'Empty field';
        }

    }
    

?>

<div class="row mt-4">
        <?php if(count($errors) > 0): ?>
    <div class="alert alert-warning w-50 d-flex justify-content-center align-content-center mt-2 mx-auto">
        
            <?php foreach($errors as $error): ?>
            <p class="p-0 m-0"><?= $error; ?></p>
            <?php endforeach; ?> 

    </div>
    <?php endif; ?>
        </div>


<?php include('includes/footer.php'); ?>
