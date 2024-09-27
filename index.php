<?php include('includes/header.php'); ?>



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
        <!-- Sidebar for Filters -->
        <div class="col-md-3 mt-4">
            <div class="card p-3">
                <h4>Filter by:</h4>
                <div class="filter-section">
                    <h5>Price Range</h5>
                    <input type="range" min="0" max="100" value="50" class="form-range" id="priceRange">
                    
                    <h5>Language</h5>
                    <select class="form-select mb-3" aria-label="Language Filter">
                        <option selected>Choose Language</option>
                        <option value="1">English</option>
                        <option value="2">Albanian</option>
                        <option value="3">French</option>
                    </select>
                    
                    <h5>Author</h5>
                    <select class="form-select mb-3" aria-label="Author Filter">
                        <option selected>Choose Author</option>
                        <option value="1">Author A</option>
                        <option value="2">Author B</option>
                        <option value="3">Author C</option>
                    </select>
                    
                    <h5>Publication Year</h5>
                    <select class="form-select mb-3" aria-label="Publication Year Filter">
                        <option selected>Choose Year</option>
                        <option value="new">New (Last 5 years)</option>
                        <option value="old">Old (More than 5 years)</option>
                    </select>
                    
                    <h5>Genre</h5>
                    <select class="form-select mb-3" aria-label="Genre Filter">
                        <option selected>Choose Genre</option>
                        <option value="fiction">Fiction</option>
                        <option value="non-fiction">Non-Fiction</option>
                        <option value="fantasy">Fantasy</option>
                    </select>

                    <h5>Category</h5>
                    <select class="form-select mb-3" aria-label="Category Filter">
                        <option selected>Choose Category</option>
                        <option value="best-sellers">Best Sellers</option>
                        <option value="new-releases">New Releases</option>
                        <option value="top-rated">Top Rated</option>
                    </select>
                    
                    <button class="btn btn-primary w-100">Apply Filters</button>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row mt-4">
                <?php
                $crudObj = new Crud($pdo);
                $allbooks = $crudObj->select('book', [], [], 4, '');
                if ($allbooks) {
                    $allbooks = $allbooks->fetchAll();
                    foreach ($allbooks as $book):
                ?>
                <div class="col-md-6 col-lg-12 mb-4">
                    <div class="list-group">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="book_details.php?book_id=<?= $book['id']; ?>" style="width:200px;">
                                <img src="./assets/images/books/<?= $book['image']; ?>" class="card-img-top p-3" style="height:250px" alt="<?= $book['image']; ?>">
                            </a>
                            <div class="book-details text-center" style="flex-grow: 1;">
                                <a href="book_details.php?book_id=<?= $book['id']; ?>" style="text-decoration: none; color: inherit;">
                                    <h5 class="mb-1"><?= $book['title']; ?></h5>
                                    <p class="mb-1">Price: <strong><?= number_format($book['price'], 2); ?> &euro;</strong></p>
                                    <p class="mb-1">Language: <strong><?= $book['language']; ?></strong></p>
                                </a>
                            </div>
                            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" class="d-flex align-items-center">
                                <input type="hidden" name="book_id" value="<?= $book['id']; ?>">
                                <input type="hidden" name="book_title" value="<?= $book['title']; ?>">
                                <input type="hidden" name="book_price" value="<?= $book['price']; ?>">
                                <input type="hidden" name="book_stock" value="<?= $book['stock']; ?>">
                                <input type="number" name="stock" value="1" min="1" class="form-control me-2" style="width: 60px;">
                                <button name="add-to-cart" type="submit" class="btn btn-success">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; } ?>
            </div>
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
                        
                      
                 ?>
                <div class="col-lg-3 col-md-3 col-sm-12 mx-auto">
                    <div class="card" style="width: 18rem;">
                        
                        <img src="./assets/images/books/<?php echo $bs_book['image']; ?>" class="card-img-top" alt="..." height="300px">
                        <a href="book_details.php?book_id=<?= $book['id']; ?>" class="btn btn-secondary mt-3 w-50" style="margin-left:70px;"> View Details</a>
                    <div class="card-body">
                            <h5 class="card-title"><?php echo $bs_book['title'] ?></h5>
                            <p class="card-text"> <?php echo number_format($bs_book['price'],2);  ?> &euro;</p>
                            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" class="d-flex justify-content-between">
                                <input type="hidden" name="book_id" id="book_id" value="<?= $bs_book['id'] ?>">
                                <input type="hidden" name="book_title" id="book_title" value="<?= $bs_book['title'] ?>">
                                <input type="hidden" name="book_price" id="book_price" value="<?= $bs_book['price'] ?>">
                                <input type="hidden" name="book_stock" id="book_stock" value="<?= $bs_book['stock'] ?>"> <!--Kjo qe nese don e i shtu ne cart books ma shume se qe kemi ne stock ne db -->
                                <input type="number" name="stock" id="stock" value="1" min="0" class="form-control">
                                <button name="add-to-cart" type="submit" class="btn btn-primary mx-2">Add to cart</button>
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
        <form action="" method="POST">
            <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Enter your email" aria-label="Email" required>
                <button class="btn btn-success" type="submit">Subscribe</button>
            </div>
        </form>
        <p class="mt-3">Stay updated with the latest books and offers!</p>
    </div>
</div>








</div>
</section>





<?php include('includes/footer.php'); ?>