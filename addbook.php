<?php include('includes/header.php'); ?>
<?php
$errors = [];

//fill form if edit button clicked
if(isset($_GET['action']) && $_GET['action'] == 'edit'){
    $getbook = (new Crud($pdo))->select('book',[],['id'=> $_GET['id']],1,'')->fetch();
    
}

?>


<section class="add-book py-5">
    <div class="container">
    <div class="row mt-4">
    <div class="container d-flex justify-content-center">
        
        <!-- ADD BOOK -->
         <?php if(!(isset($_GET['action']) && $_GET['action']== 'edit')): ?>
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
        <?php else: ?>
        <!-- UPDATE BOOK -->
        <div class="addbook-form w-50 p-4 shadow rounded bg-light">
            <div class="text-center mb-4">
                <h3 class="mb-3 text-secondary">Update Book</h3>
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
                    <input type="hidden" name="userid-modify"  class="form-control" id="userid-modify" value="<?=$_SESSION['user_id']?>" required>
                </div>
                <div class="mb-3">
                    <label for="title-modify" class="form-label">Title</label>
                    <input type="text" name="title-modify" class="form-control" id="title-modify" value="<?= $getbook['title'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="authorid-modify" class="form-label">Author</label>
                    <?php
                        $getauthor = (new Crud($pdo))->select('person',[],['id'=> $getbook['authorid']],1,'')->fetch();
                     ?>
                    <input type="text" name="authorid-modify" class="form-control" id="authorid-modify" value="<?= $getauthor['name'] . ' ' . $getauthor['surname'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="price-modify" class="form-label">Price</label>
                    <input type="text" name="price-modify" class="form-control" id="price-modify" min="1" value="<?= $getbook['price'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description-modify" class="form-label">Description</label>
                    <textarea name="description-modify" class="form-control" id="description-modify" value="<?= $getbook['description'] ?>" required><?= $getbook['description'] ?>
                    </textarea>
                </div>
                <div class="mb-3">
                    <label for="stock-modify" class="form-label">Stock</label>
                    <input type="number" name="stock-modify" class="form-control" id="stock-modify" min="1" value="<?= $getbook['stock'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" id="image-modify" ><br><br>
                    <?php if(!empty($getbook['image'])) {?>
                    <img class="mx-auto" height="200px"  src="./assets/images/books/<?= $getbook['image']; ?>"/>
                    <?php } else { echo "<em>There is no image set here</em>"; } ?><br><br>
                </div>                             
                <div class="mb-3">
                    <label for="condition-modify" class="form-label">Condition</label>
                    <select name="condition-modify" id="condition-modify" class="form-control mb-2">
                        <option value="" disabled>Select Condition</option>
                        <?php
                            $conditions = (new CRUD($pdo))->distinctSelect('book','isnew')->fetchAll();
                            
                            foreach($conditions as $condition):
                        ?>
                        <option value="<?= $condition['isnew'];?>" <?php if($getbook['isnew']==$condition['isnew']): ?>selected <?php endif; ?>><?= ($condition['isnew'] === 1) ? 'New' : 'Old'; ?></option>
                            <?php endforeach; ?>
                    </select>
                    
                </div>
                <div class="mb-3">
                    <label for="published_year-modify" class="form-label">Published Year</label>
                    <input type="number" name="published_year-modify" class="form-control" id="published_year-modify" value="<?= $getbook['published_year'] ?>" required min="1901" max="2024">
                </div>
                <div class="mb-3">
                    <label for="language-modify" class="form-label">Language</label>
                    <input type="text" name="language-modify" class="form-control" value="<?= $getbook['language'] ?>" id="language-modify" required>
                </div>
                <div class="mb-3">
                    <label for="genreid-modify" class="form-label">Genre</label>
                    <select name="genreid-modify" id="genreid-modify" class="form-control mb-2">
                        <option value="" disabled>Select Genre</option>
                        <?php
                            $genres = (new CRUD($pdo))->select('genre',[],[],'','')->fetchAll();
                            
                            foreach($genres as $genre):
                        ?>
                        <option value="<?=$genre['id'];?>" <?php if($getbook['genreid']==$genre['id']): ?>selected <?php endif; ?>><?= $genre['name']; ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="categoryid-modify" class="form-label">Category</label>
                    <select name="categoryid-modify" id="categoryid-modify" class="form-control mb-2">
                        <option value="" disabled>Select Category</option>
                        <?php
                            $categories = (new CRUD($pdo))->select('category',[],[],'','')->fetchAll();
                            
                            foreach($categories as $category):
                        ?>
                        <option value="<?=$category['id'];?>" <?php if($getbook['categoryid']==$category['id']): ?>selected <?php endif; ?>><?= $category['name']; ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                
                <button type="submit" name="updatebook-btn" class="btn btn-primary w-100">Update Book</button>
            </form>
        </div>
        <?php endif; ?>
        </div>
    </div>
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
                        $insertauthor = (new Crud($pdo))->insert('person',['name','surname', 'role'], [$name, $surname, 'author']);
                        if($insertauthor){
                            $insertauthor = (new Crud($pdo))->select('person',[],[],1,'')->fetch();
                        }
                        $insert = (new Crud($pdo))-> insert('book',['title','authorid','price','description','stock','isnew','published_year','language','userid','genreid','categoryid', 'image'],[$title, $insertauthor['id'], $price, $description, $stock, $condition, $published_year, $language, $_SESSION['user_id'], $genre, $category, $image]);
                        header('Location:books.php');
                        move_uploaded_file($tempname,'assets/images/books/'.$image);
                    }else{
                        $insertauthor = (new Crud($pdo))->insert('person',['name','surname', 'role'], [$name, $surname, 'author']);
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

        <?php
        
        //update book
        if(isset($_POST['updatebook-btn'])){
            $title_modify = $_POST['title-modify'];
            $authorid_modify = $_POST['authorid-modify'];
            $price_modify = $_POST['price-modify'];
            $description_modify = $_POST['description-modify'];
            $stock_modify = $_POST['stock-modify'];
            $condition_modify = $_POST['condition-modify'];
            $published_year_modify = $_POST['published_year-modify'];
            $language_modify = $_POST['language-modify'];
            $genre_modify = $_POST['genreid-modify'];
            $category_modify = $_POST['categoryid-modify'];      
            
            
            $image = $_FILES['image']['name'] ? time() . $_FILES['image']['name'] : '';


            if( !empty($title_modify) && !empty($authorid_modify) && !empty($price_modify) && !empty($description_modify) && !empty($stock_modify) && ($condition_modify !== null) && !empty($published_year_modify) && !empty($language_modify) && !empty($genre_modify) && !empty($category_modify) ){
                $author = ucwords(strtolower(trim($authorid_modify)));

                
                $authorArray = explode(' ', $author);
                $surname = array_pop($authorArray); // Last part of array always surname
                $name = implode(' ', $authorArray); // The rest -> name


                $checkauthor = (new Crud($pdo))->select('person',[],['name'=>$name, 'surname'=>$surname],1,'')->fetch();
                if($checkauthor){
                    if(!(empty($image))){
                        $update = (new Crud($pdo))-> update('book',['title','authorid','price','description','stock','isnew','published_year','language','userid','genreid','categoryid','image'],[$title_modify, $checkauthor['id'], $price_modify, $description_modify, $stock_modify,  $condition_modify, $published_year_modify, $language_modify, $_SESSION['user_id'], $genre_modify, $category_modify, $image], ['id'=>$_GET['id']]);
                        move_uploaded_file($_FILES['image']['tmp_name'],'assets/images/books/'.$image);

                        if($update){
                            header('Location:books.php');
                        }else{
                            $errors[] = 'Author found, image too but update not successful!';
                        }
                        
                    }else{
                        $update = (new Crud($pdo))-> update('book',['title','authorid','price','description','stock','isnew','published_year','language','userid','genreid','categoryid'],[$title_modify, $checkauthor['id'], $price_modify, $description_modify, $stock_modify, $condition_modify, $published_year_modify, $language_modify, $_SESSION['user_id'], $genre_modify, $category_modify],['id'=>$_GET['id']]);
                        if($update){
                            header('Location:books.php');
                        }else{
                            $errors[] = 'Author found, image no and update not successful!';

                        }
                    }
                    
                }else{
                    if(!(empty($image))){
                        $insertauthor = (new Crud($pdo))->insert('person',['name','surname'], [$name, $surname]);
                        if($insertauthor){
                            $insertauthor = (new Crud($pdo))->select('person',[],[],1,'')->fetch();
                        }
                        $update = (new Crud($pdo))-> update('book',['title','authorid','price','description','stock','isnew','published_year','language','userid','genreid','categoryid', 'image'],[$title_modify, $insertauthor['id'], $price_modify, $description_modify, $stock_modify, $condition_modify, $published_year_modify, $language_modify, $_SESSION['user_id'], $genre_modify, $category_modify, $image],['id'=>$_GET['id']]);
                        move_uploaded_file($tempname,'assets/images/books/'.$image);

                        if($update){
                            header('Location:books.php');
                        }else{
                            $errors[] = 'Image found, author no and update not successful!';

                        }
                    }else{
                        $insertauthor = (new Crud($pdo))->insert('person',['name','surname'], [$name, $surname]);
                        if($insertauthor){
                            $lastinsertauthor = $pdo->lastInsertId();
                        }
                        $update = (new Crud($pdo))-> update('book',['title','authorid','price','description','stock','isnew','published_year','language','userid','genreid','categoryid'],[$title_modify, $lastinsertauthor, $price_modify, $description_modify, $stock_modify, $condition_modify, $published_year_modify, $language_modify, $_SESSION['user_id'], $genre_modify, $category_modify],['id'=>$_GET['id']]);

                        if($update){
                            header('Location:books.php');
                        }else{
                            $errors[] = 'Image not found, author not found and update not successful!';

                        }
                    }
                    
                }

            }




        }
        ?>

<?php 
$mybooks = (new Crud($pdo))->select('book',[],['userid'=>$_SESSION['user_id']],'','')->fetchAll();
//delete book
if(isset($_GET['action']) && $_GET['action'] == 'delete'){
    $deletebook = (new Crud($pdo))->delete('book','id', $_GET['id']);
    header('Location:addbook.php');
}



if(count($mybooks) > 0): ?>
        <h2 class="text-center mt-4">My Books (<?= count($mybooks); ?>)</h2>
    
    <div class="row mt-4">
        <table class="table">
            <tr>
                <!-- <th>Id</th> -->
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Language</th>
                <th>Actions</th>
            </tr>
           <?php foreach($mybooks as $mybook): ?>
            <tr>
                <!-- <td><?//= $mybook['userid'] ?></td> -->
                <td><?= $mybook['title'] ?></td>
                <td><?= $mybook['description'] ?></td>
                <td><?= $mybook['price'] ?>&euro;</td>
                <td><?= $mybook['language'] ?></td>
                <td>
                    <!-- <a href="?action=view&id=<?=$mybook['id'];?>" class="btn btn-sm btn-success">View Reviews</a> / -->
                    <a href="?action=delete&id=<?=$mybook['id'];?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a> /
                    <a href="?action=edit&id=<?=$mybook['id'];?>" class="btn btn-sm btn-secondary">Edit</a> 
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: echo '<h3 class="text-center mt-4">0 Books offered from you! </h3>'; ?>
    </div>
    <?php endif; ?>
    
</div>
</section>


<?php include('includes/footer.php'); ?>