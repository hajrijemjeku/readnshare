<?php include('includes/header.php'); ?>
<?php
$errors = [];


?>


<section class="add-book py-5">
    <div class="container d-flex justify-content-center">
        <div class="addbook-form w-50 p-4 shadow rounded bg-light">
            <div class="text-center mb-4">
                <h3 class="mb-3 text-secondary">Add a book</h3>
            </div>
            <?php if(count($errors) > 0): ?>
            <div class="alert alert-warning">
                <?php foreach($errors as $error): ?>
                    <p class="p-0 m-0"><?= $error; ?></p>
                <?php endforeach;?>
            </div>
            <?php endif; ?>
            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
            <div class="mb-3">
                    <input type="hidden" name="userid"  class="form-control" id="userid" value="<?=$_SESSION['user_id']?>" required>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="title" required>
                </div>
                <div class="mb-3">
                    <label for="authorid" class="form-label">Author</label>
                    <input type="text" name="authorid" class="form-control" id="authorid" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" name="price" class="form-control" id="price" min="1" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" id="description" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control" id="stock" min="1" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" id="image" >
                </div>                             
                <div class="mb-3">
                    <label for="condition" class="form-label">Condition</label>
                    <select name="condition" id="condition" class="form-control mb-2">
                        <option value="">Select Condition</option>
                        <?php
                            $conditions = (new CRUD($pdo))->distinctSelect('book','isnew');
                            $conditions = $conditions->fetchAll();
                            
                            foreach($conditions as $condition):
                        ?>
                        <option value="<?= $condition['isnew'];?>" required><?= ($condition['isnew'] === 1) ? 'New' : 'Old'; ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="published_year" class="form-label">Published Year</label>
                    <input type="number" name="published_year" class="form-control" id="published_year" required min="1901" max="2024">
                </div>
                <div class="mb-3">
                    <label for="language" class="form-label">Language</label>
                    <input type="text" name="language" class="form-control" id="language" required>
                </div>
                <div class="mb-3">
                    <label for="genreid" class="form-label">Genre</label>
                    <select name="genreid" id="genreid" class="form-control mb-2">
                        <option value="">Select Genre</option>
                        <?php
                            $genres = (new CRUD($pdo))->select('genre',[],[],'','')->fetchAll();
                            
                            foreach($genres as $genre):
                        ?>
                        <option value="<?= $genre['id']; ?>" required><?= $genre['name']; ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="categoryid" class="form-label">Category</label>
                    <select name="categoryid" id="categoryid" class="form-control mb-2">
                        <option value="">Select Category</option>
                        <?php
                            $categories = (new CRUD($pdo))->select('category',[],[],'','')->fetchAll();
                            
                            foreach($categories as $category):
                        ?>
                        <option value="<?= $category['id']; ?>" required><?= $category['name']; ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                
                <button type="submit" name="addbook-btn" class="btn btn-primary w-100">Add Book</button>
            </form>
        </div>
    </div>
</section>
<?php 

// Insert a book
if(isset($_POST['addbook-btn'])){
    $title = $_POST['title'];
    $authorid = $_POST['authorid'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    $condition = $_POST['condition'];
    $published_year = $_POST['published_year'];
    $language = $_POST['language'];
    $genre = $_POST['genreid'];
    $category = $_POST['categoryid'];

    $image = $_FILES['image']['name'] ? time() . $_FILES['image']['name'] : '';
    //$tempname = $_FILES['image']['tmp_name'];



    if( !empty($title) && !empty($authorid) && !empty($price) && !empty($description) && !empty($stock) && ($condition !== null) && !empty($published_year) && !empty($language) && !empty($genre) && !empty($category) ){
        $author = ucwords(strtolower(trim($authorid)));

        
        $authorArray = explode(' ', $author);
        $surname = array_pop($authorArray); // Last part of array always surname
        $name = implode(' ', $authorArray); // The rest -> name


        $checkauthor = (new Crud($pdo))->select('person',[],['name'=>$name, 'surname'=>$surname],1,'')->fetch();
        if($checkauthor){
            if(!(empty($image))){
                $insert = (new Crud($pdo))-> insert('book',['title','authorid','price','description','stock','isnew','published_year','language','userid','genreid','categoryid','image'],[$title, $checkauthor['id'], $price, $description, $stock,  $condition, $published_year, $language, $_SESSION['user_id'], $genre, $category, $image]);
                move_uploaded_file($_FILES['image']['tmp_name'],'assets/images/books/'.$image);
                header('Location:books.php');
            }else{
                $insert = (new Crud($pdo))-> insert('book',['title','authorid','price','description','stock','isnew','published_year','language','userid','genreid','categoryid'],[$title, $checkauthor['id'], $price, $description, $stock,  $condition, $published_year, $language, $_SESSION['user_id'], $genre, $category]);
                header('Location:books.php');
            }
            
        }else{
            if(!(empty($image))){
                $insertauthor = (new Crud($pdo))->insert('person',['name','surname'], [$name, $surname]);
                if($insertauthor){
                    $insertauthor = (new Crud($pdo))->select('person',[],[],1,'')->fetch();
                }
                $insert = (new Crud($pdo))-> insert('book',['title','authorid','price','description','stock','isnew','published_year','language','userid','genreid','categoryid', 'image'],[$title, $insertauthor['id'], $price, $description, $stock, $condition, $published_year, $language, $_SESSION['user_id'], $genre, $category, $image]);
                header('Location:books.php');
                move_uploaded_file($tempname,'assets/images/books/'.$image);
            }else{
                $insertauthor = (new Crud($pdo))->insert('person',['name','surname'], [$name, $surname]);
                if($insertauthor){
                    $lastinsertauthor = $pdo->lastInsertId();
                }
                $insert = (new Crud($pdo))-> insert('book',['title','authorid','price','description','stock','isnew','published_year','language','userid','genreid','categoryid'],[$title, $lastinsertauthor, $price, $description, $stock, $condition, $published_year, $language, $_SESSION['user_id'], $genre, $category]);
                header('Location:books.php');
            }
            
        }



    }

} 

?>

<?php include('includes/footer.php'); ?>