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
                $allbooks = $crudObj->select('book', [], [], '', '');
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
</div>



</section>





<?php include('includes/footer.php'); ?>
