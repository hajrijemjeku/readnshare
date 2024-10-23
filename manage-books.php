<?php include('includes/header.php'); ?>

<?php
$errors[] = '';
if(!(isset($_SESSION['logged_in'])) && !($_SESSION['logged_in'] == true)){
    header('Location:index.php');}


$books = (new CRUD($pdo))->select('book',[],[],'','')->fetchAll();

if(isset($_GET['action']) && $_GET['action'] == 'delete'){
    $deletebook = (new CRUD($pdo))->delete('book','id',$_GET['id']);

    header('Location:manage-books.php');
    exit;
}

if(isset($_POST['edit-btn'])){

    $image = $_FILES['image']['name'] ? time() . $_FILES['image']['name'] : '';
    if(!empty($image)){
        

        if((!empty($_POST['title'])) && (!empty($_POST['published_year'])) && ($_POST['condition'] !== null) && (!empty($_POST['userid'])) && (!empty($_POST['genreid'])) && (!empty($_POST['authorid'])) && ($_POST['stock'] !== null) && (!empty($_POST['price'])) && (!empty($_POST['categoryid'])) && (!empty($_POST['description'])) && (!empty($_POST['language']))){

            $updatebook = (new CRUD($pdo)) -> update('book',['title','published_year','isnew','userid','genreid','authorid','stock','price', 'categoryid','description', 'language', 'image'],[$_POST['title'],$_POST['published_year'],$_POST['condition'],$_POST['userid'],$_POST['genreid'],$_POST['authorid'],$_POST['stock'],$_POST['price'],$_POST['categoryid'],$_POST['description'], ucfirst($_POST['language']), $image],['id'=>$_POST['id']]);
            move_uploaded_file($_FILES['image']['tmp_name'],'assets/images/books/'.$image);

            header('Location:manage-books.php');
            // exit;


        }else {
            $errors [] = 'Something went wrong';
        }
    }
    else{
        if((!empty($_POST['title'])) && (!empty($_POST['published_year'])) && ($_POST['condition'] !== null) && (!empty($_POST['userid'])) && (!empty($_POST['genreid'])) && (!empty($_POST['authorid'])) && ($_POST['stock'] !== null) && (!empty($_POST['price'])) && (!empty($_POST['categoryid'])) && (!empty($_POST['description'])) && (!empty($_POST['language']))){

            $updatebook = (new CRUD($pdo)) -> update('book',['title','published_year','isnew','userid','genreid','authorid','stock','price', 'categoryid','description', 'language'],[$_POST['title'],$_POST['published_year'],$_POST['condition'],$_POST['userid'],$_POST['genreid'],$_POST['authorid'],$_POST['stock'],$_POST['price'],$_POST['categoryid'],$_POST['description'], ucfirst($_POST['language'])],['id'=>$_POST['id']]);

            header('Location:manage-books.php');
            // exit;


        }else {
            $errors [] = 'Something went wrong';
        }
    }

}


?>

<?php 
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true):
    if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): 
?>
    <section class="myresidences py-5">
        <div class="container">
        <?php if(count($books) > 0): ?>
            <h2 class="text-center">All Books (<?= count($books); ?>)</h2>
        
        <div class="row mt-4">
            <table class="table">
                <tr>
                    <!-- <th>Id</th> -->
                    <th>Title</th>
                    <th>Authorid</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>IsNew</th>
                    <th>Published_Year</th>
                    <th>Language</th>
                    <th>Userid</th>
                    <th>Genreid</th>
                    <th>Categoryid</th>
                </tr>
            <?php foreach($books as $book): ?>
                <tr>
                    <!-- <td><?//= $book['userid'] ?></td> -->
                    <td><?= $book['title'] ?></td>
                    <td><?= $book['authorid'] ?></td>
                    <td><?= $book['price'] ?>&euro;</td>
                    <td><?= $book['description'] ?></td>
                    <td><?= $book['stock'] ?></td>
                    <td><?= $book['image'] ?></td>
                    <td><?= $book['isnew'] ?></td>
                    <td><?= $book['published_year'] ?></td>
                    <td><?= $book['language'] ?></td>
                    <td><?= $book['userid'] ?></td>
                    <td><?= $book['genreid'] ?></td>
                    <td><?= $book['categoryid'] ?></td>
                    <td>
                        <a href="?action=delete&id=<?=$book['id'];?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a> /
                        <a href="?action=edit&id=<?=$book['id'];?>" class="btn btn-sm btn-secondary">Edit</a> 
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php else: echo '<p>0 Books </p>'; ?>
        </div>
        <?php endif; ?>

        <?php if(isset($_GET['action']) && $_GET['action']=='edit'): 
            
                $fillinputs = (new CRUD($pdo))->select('book',[],['id'=>$_GET['id']],1,'');
                if($fillinputs):
                    $fillinput = $fillinputs->fetch();
                    $fullname = (new CRUD($pdo))->select('person',[],['id'=>$fillinput['userid']],1,'');
                    $fullname = $fullname->fetch();

                
            
            ?>
            
        <!-- <div class="container d-flex justify-content-center"> -->
            <div class="residence-form w-50 p-4 shadow rounded bg-light">
                <div class="text-center mb-4">
                    <h3 class="mb-3 text-secondary">Modify Book</h3>
                </div>
                
                <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="hidden" name="id" class="form-control" id="id" value="<?= $fillinput['id']; ?>" >
                    </div>
                    <div class="mb-3">
                        <label for="userid" class="form-label">Userid</label>
                        <input type="number" name="userid" class="form-control" id="userid" value="<?=$fillinput['userid'];?>" >
                    </div>
                    <div class="mb-3">
                        <label for="authorid" class="form-label">Authorid</label>
                        <input type="number" name="authorid" class="form-control" id="authorid" value="<?=$fillinput['authorid'];?>" >
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="title" value="<?=$fillinput['title'];?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="condition" class="form-label">Condition</label>
                        <select name="condition" id="condition" class="form-control mb-2">
                            <option value="" disabled>Choose Condition</option>
                            <?php
                                $conditions = (new CRUD($pdo))->distinctSelect('book','isnew')->fetchAll();
                                
                                foreach($conditions as $condition):
                            ?>
                            
                            <option value="<?= $condition['isnew']?>"<?php if($fillinput['isnew']==$condition['isnew']): ?>selected <?php endif; ?>><?= $condition['isnew']; ?></option>
                                <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="published_year" class="form-label">Published Year</label>
                        <input type="number" min="1901" name="published_year" class="form-control" id="published_year" value="<?=$fillinput['published_year'];?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="price" class="form-control" id="price" min="1" value="<?=$fillinput['price'];?>" required>
                    </div>                
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" min="0" id="stock" value="<?=$fillinput['stock'];?>" required>
                    </div>                
                    <div class="mb-3">
                        <label for="genreid" class="form-label">Genre</label>
                        <select name="genreid" id="genreid" class="form-control mb-2">
                            <option value="" disabled>Select Genre</option>
                            <?php
                                $types = (new CRUD($pdo))->select('genre',[],[],'','');
                                $types = $types->fetchAll();
                                
                                foreach($types as $type):
                            ?>
                            <option value="<?=$type['id'];?>" <?php if($fillinput['genreid']==$type['id']): ?>selected <?php endif; ?>><?= $type['name']; ?></option>
                                <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="categoryid" class="form-label">Category</label>
                        <select name="categoryid" id="categoryid" class="form-control mb-2">
                            <option value="" disabled>Select Category</option>
                            <?php
                                $types = (new CRUD($pdo))->select('category',[],[],'','');
                                $types = $types->fetchAll();
                                
                                foreach($types as $type):
                            ?>
                            <option value="<?=$type['id'];?>" <?php if($fillinput['categoryid']==$type['id']): ?>selected <?php endif; ?>><?= $type['name']; ?></option>
                                <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="language" class="form-label">Language</label>
                        <input type="text" name="language" class="form-control" id="language" value="<?=$fillinput['language'];?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="price" class="form-control" min="1" id="price" value="<?=$fillinput['price'];?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description" value="<?=$fillinput['description'];?>" required><?=$fillinput['description'];?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" id="image" value="<?=$fillinput['image'];?>" ><img style="height: 100px; margin: 10px 250px;" src="assets/images/books/<?=$fillinput['image'];?>" alt="<?=$fillinput['image'];?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control bg-light" id="email" required value="<?=$fullname['email']; ?>" readonly>
                    </div>
                    
                    <button type="submit" name="edit-btn" class="btn btn-primary w-100">Update</button>
                </form>
            </div>
        <!-- </div> -->
        <?php endif;endif; ?>


        </div>
    </section>


<?php else: header('location:index.php');?>
<?php endif; endif; ?>





<?php include('includes/footer.php'); ?>