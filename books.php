<?php include('includes/header.php') ?>
<?php




?>
<section class="books py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar for Filters -->
            <div class="col-md-3" style="margin-top:135px;">
                <div class="card p-3">
                    <h4>Filter by:</h4>
                    <div class="filter-section mt-3">
                        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
                        
                        <h5>Price Range</h5>
                        <div class="form-number">
                            <?php
                                $crudObj = new Crud($pdo);
                                $minprice = $crudObj->select('book',['min(price)'],[],'','')->fetch();
                                // echo "<pre>";
                                // print_r($minprice['min(price)']);
                                // echo "</pre>";

                                $maxprice = $crudObj->select('book',['max(price)'],[],'','')->fetch();
                                //print_r($maxprice[0]);
                            ?>
                            <input name="minprice" type="number" min="<?=$minprice[0]; ?>" max="<?= $maxprice[0] - 1;?>" value="" class="form-number" id="minPrice">
                            <input name="maxprice" type="number" min="<?=$minprice[0]; ?>" max="<?= $maxprice[0];?>" value="" class="form-number" id="maxPrice">
                        </div>

                        <h5>Language</h5>
                        <select name="language" class="form-select mb-3" aria-label="Language Filter">
                            <option value="">Choose Language</option>
                            <?php 
                            $languages = (new Crud($pdo))->distinctSelect('book','language')->fetchAll();
                            foreach($languages as $language): 
                            ?>
                            <option value="<?= $language['language'] ?>"><?= $language['language'] ?></option>
                            <?php endforeach; ?>
                        </select>

                        <h5>Author</h5>
                        <select name="author" class="form-select mb-3" aria-label="Author Filter">
                            <option value="">Choose Author</option>
                            <?php 
                            $authors = (new Crud($pdo))->distinctSelect('book','authorid')->fetchAll();
                            
                            foreach($authors as $author): 
                                $authorname = (new Crud($pdo))->select('person',[],['id'=>$author['authorid']],'','')->fetch();
                            ?>
                            <option value="<?= $author['authorid'] ?>"><?php echo $authorname['name'] . ' '. $authorname['surname']; ?></option>
                            <?php endforeach; ?>
                        </select>

                        <h5>Condition</h5>
                        <select name="condition" class="form-select mb-3" aria-label="Condition Filter">
                            <option value="">Choose Condition </option>
                            <?php
                            $conditions = (new Crud($pdo))->distinctSelect('book','isnew')->fetchAll();
                            foreach($conditions as $condition):
                            ?>
                            <option value="<?= $condition['isnew'] ?>"><?= ($condition['isnew']==1) ? 'New' : 'Used' ?></option>
                            <?php endforeach; ?>
                        </select>

                        <h5>Genre</h5>
                        <select name="genre" class="form-select mb-3" aria-label="Genre Filter">
                            <option value="">Choose Genre</option>
                            <?php 
                            $genres = (new Crud($pdo))->select('genre',[],[],'','')->fetchAll();
                            foreach($genres as $genre): 
                            ?>
                            <option value="<?= $genre['id'] ?>"><?= $genre['name'] ?></option>
                            <?php endforeach; ?>
                        </select>

                        <h5>Category</h5>
                        <select name="category" class="form-select mb-3" aria-label="Category Filter">
                            <option value="">Choose Category</option>
                            <?php 
                            $categories = (new Crud($pdo))->select('category',[],[],'','')->fetchAll();
                            foreach($categories as $category): 
                            ?>
                            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="row p-0">
                            <button class="btn btn-success w-50 mb-3" style="margin-left:-1px;" name="apply-filter" type="submit">Apply Filters</button>
                            <button type="submit" class="btn btn-primary w-50 mb-3" style="margin-left:1px;" name="with-reviews-btn">Books With Reviews</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Books Section -->
            <div class="col-md-9 mt-5">
                <div class="row">
                    <?php
                    $crudObj = new Crud($pdo);
                    if (isset($_GET['with-reviews-btn'])) {
                        $filterConditions = [];
                        $reviews = (new Crud($pdo))->distinctSelect('review', 'bookid')->fetchAll();
                        // var_dump($reviews); 
                        if ($reviews) {
                            $filterConditions['id'] = $reviews;
                        }
                    }
                    
            
                    //FILTER SECTION CODE
                    if(isset($_GET['apply-filter'])){
                        $language = $_GET['language'] ?? null;
                        $author = $_GET['author'] ?? null;
                        $condition = $_GET['condition'] ?? null;
                        $genre = $_GET['genre'] ?? null;
                        $category = $_GET['category'] ?? null;
                        $minprice = $_GET['minprice'] ?? null;
                        $maxprice = $_GET['maxprice'] ?? null;
        
                        $filterConditions = [];
                        if (!empty($language)) {
                            $filterConditions['language'] = $language;
                        }
                        if (!empty($author)) {
                            $filterConditions['authorid'] = $author;
                            $getauthor = $crudObj->select('person', [], ['id'=>$author], '', '')->fetch();
                        }
                        if (!empty($genre)) {
                            $filterConditions['genreid'] = $genre;
                            $getgenre = $crudObj->select('genre', [], ['id'=>$genre], '', '')->fetch();
                        }
                        if (!empty($category)) {
                            $filterConditions['categoryid'] = $category;
                            $getcategory = $crudObj->select('category', [], ['id'=>$category], '', '')->fetch();
                        }
                        if (!($condition == null)) {
                            $filterConditions['isnew'] = $condition;
                        } 
                        if (!empty($minprice)) {
                            $filterConditions['ROUND(price, 2) >= '] = $minprice;
                        }
                        if (!empty($maxprice)) {
                            $filterConditions['ROUND(price, 2) <= '] = $maxprice;
                        }
                        
        
                        $all_books = $crudObj->select('book', [], $filterConditions, '','');
                        $all_books = $all_books->fetchAll();

                        if (count($all_books) == 0) {
                            echo "<h2 class='text-center mb-5' style='color:darkolivegreen;'>0 results with filtered data!</h2>";
                        } else {
                          
                            $conditionsDisplay = [];
                            
                            if (!empty($language)) {
                                $conditionsDisplay[] = "Language: {$language}";
                            }
                            if (!empty($author) && $getauthor) {
                                $conditionsDisplay[] = "Author: {$getauthor['name']}   {$getauthor['surname']}"; 
                            }
                            if (!empty($genre) && $getgenre) {
                                $conditionsDisplay[] = "Genre: {$getgenre['name']}"; 
                            }
                            if (!empty($category) && $getcategory) {
                                $conditionsDisplay[] = "Category: {$getcategory['name']}";
                            }
                            if (!($condition == null)) {
                                $conditionsDisplay[] = "Condition: " . ($condition ? "New" : "Used");
                            }
                            if (!empty($minprice)) {
                                $conditionsDisplay[] = "Min Price: {$minprice}";
                            }
                            if (!empty($maxprice)) {
                                $conditionsDisplay[] = "Max Price: {$maxprice}";
                            }

                            $conditionsString = implode(', ', $conditionsDisplay);
                            if($conditionsString == ""){
                                echo "<h2 class='text-center mb-5' style='color:darkolivegreen;'>All Books</h2>";

                            }else{
                                echo "<h2 class='text-center mb-5' style='color:darkolivegreen;'>
                                <strong><u>{$conditionsString}</u></strong></h2>";

                            }
                            
                        }


                    } else if (isset($_GET['search-btn'])) {
                        if (isset($_GET['search-value']) && !empty(trim($_GET['search-value']))) {
                            $all_books = $crudObj->search('book', [], ['title' => $_GET['search-value'], 'published_year'=> $_GET['search-value']], '')->fetchAll();
                            if (count($all_books) == 0) {
                                echo "<h2 class='text-center mb-5' style='color:darkolivegreen;'>0 results with searched data!</h2>";
                            } else {
                                echo "<h2 class='text-center mb-5' style='color:darkolivegreen;'>Results with: <strong><u>{$_GET['search-value']}</u></strong></h2>";
                            }
                        } else {
                            echo "<h2 class='text-center mb-5' style='color:darkolivegreen;'>It looks like you didn’t enter anything. Please type a title or author to search for books.</h2>";
                            exit;
                        }
                    } else if(isset($_GET['with-reviews-btn'])){
                        $all_books = $crudObj->select('book', [], $filterConditions, '','');
                        $all_books = $all_books->fetchAll();
                        if (count($all_books) == 0) {
                            echo "<h2 class='text-center mb-5' style='color:darkolivegreen;'>0 books with reviews!</h2>";
                        } else {
                            echo "<h2 class='text-center mb-5' style='color:darkolivegreen;'>Books with reviews!</h2>";
                        }
                    } else {
                        $all_books = $crudObj->select('book', [], [], '', '')->fetchAll();
                        if (count($all_books) > 0) {
                            echo '<h2 class="text-center mb-5" style="font-family: Arial, sans-serif; font-weight: bold; color: #7b9b77;">All Books</h2>';
                        }
                    }

                    if ($all_books):
                        foreach ($all_books as $a_book):
                    ?>
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                            <a href="book_details.php?book_id=<?= $a_book['id']; ?>" class="text-decoration-none">
                                <div class="card" style="height: 500px;">
                                    <img src="./assets/images/books/<?= $a_book['image']; ?>" class="card-img-top" alt="..." height="300px">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $a_book['title'] ?></h5>
                                        <p class="card-text"> 
                                            Price: <strong><?= number_format($a_book['price'], 2); ?>&euro;</strong> / Category: <strong><?= $a_book['categoryid'] ?></strong>
                                        </p>

                                        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                                            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" class="d-inline" style="margin-left: 140px;">
                                                <input type="hidden" name="book_id" id="book_id" value="<?= $a_book['id'] ?>">
                                                <input type="hidden" name="title" value="<?= $a_book['title'] ?>">
                                                <input type="hidden" name="size" value="<?= $a_book['genreid'] ?>">
                                                <input type="hidden" name="price" value="<?= $a_book['price'] ?>">
                                                <input type="hidden" name="stock" value="<?= $a_book['stock'] ?>">
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.php') ?>
