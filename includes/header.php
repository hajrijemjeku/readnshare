<?php session_start();
include 'db.php';
ob_start();
//error_reporting(E_ALL);
$errors = [];    

//show a message if user registered successfully!
if (isset($_SESSION['success_message'])) {
    echo $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}


spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});
    

?>

<!-- SIGN UP -->
<?php
    if(isset($_POST['signup-btn'])){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];


        if(!empty($firstname) && !empty($lastname)){
            if(!empty($email) && !empty($password)){
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $getemail = (new Crud($pdo))->select('person',[],['email'=> $email],'','')->fetch();
                    if(!($email == $getemail['email'])){
                        $password = password_hash($password, PASSWORD_BCRYPT);
                        if($password){
                            $sigunp = (new Crud($pdo))->insert('person',['name','surname','email','password'], [$firstname, $lastname, $email, $password]);
    
                            if($sigunp){
                                $_SESSION['success_message'] = '<h3 class="alert alert-info text-center"> You registered successfully! Please sign in to access our services. </h3>';
                                header('Location:index.php');
                                
                            }else{
                                $errors[] = "Something went wrong while inserting";
                            }
                        } else {
                            $errors[] =  "Password not encrypted";
                        }
                    }else {
                        $errors[] = "Email already registered. Please signIn!";
                    }
                    
                }else{
                    $errors[] =  "Please enter a valid email";
                }
            } else {
                $errors[] =  "Please fill email and password fields";
            }
        }else{
            $errors[] =  "Fill firstname and lastname fields";
        }
    }
?>
<!-- SIGN IN -->
<?php
            if(isset($_POST['signin-btn'])){
                $email = $_POST['email'];
                $password = $_POST['password'];


                if(!empty($email) && !empty($password)){
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                        $checkacc = (new Crud($pdo))->select('person',[],['email'=> $email],1,'')->fetch();
                        if($email == $checkacc['email']){
                            $password = password_verify( $password, $checkacc   ['password']);
                            if($password){
                                $_SESSION['logged_in'] = true;
                                $_SESSION['email'] = $email;
                                $_SESSION['user_id'] = $checkacc['id'];
                                $_SESSION['is_admin'] = $checkacc['isadmin'];
                                header('Location: index.php');
                            }else{
                                $errors[] = 'Wrong password';}
                        } else{
                            $errors[] = 'Email not found on our database';}

                    }else{
                        $errors[] =  "Please enter a valid email";}
                } else {
                    $errors[] =  "Please fill email and password fields";}
            }
        
        ?>

<!-- Log Out -->
 <?php
    if(isset($_GET['logout-btn'])){
        session_unset();
        session_destroy();
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_id']);
        unset($_SESSION['email']);
        unset($_SESSION['is_admin']);
        header('Location:index.php');
    }

?>

<!-- Modify acc -->
 <?php
    if(isset($_POST['modify-btn'])){
        $modify_firstname = $_POST['modify-firstname'];
        $modify_lastname = $_POST['modify-lastname'];
        $modify_email = $_POST['modify-email'];

        if(!empty($modify_firstname) && !empty($modify_lastname) && !empty($modify_email)){
            $modify_acc = (new Crud($pdo))->update('person',['name','surname','email'], [$modify_firstname, $modify_lastname, $modify_email],['id'=>$_SESSION['user_id']]);

            if($modify_acc){
                $_SESSION['success_message'] = '<h4 class="alert alert-info text-center mx-auto mt-2 w-75">Your account information has been updated successfully.!</h4>';
                header('Location:index.php');
            }else{
                $errors[] = 'Something went wrong while updating account informations!';
            }

        } else {
            $errors[] = 'Fill input fields to update account information!';
        }
    }
 
 
 
 ?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReadnShare</title>
    <link href='https://fonts.googleapis.com/css?family=Allan' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body style="overflow-x:hidden;">

    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand mx-4" href="index.php">ReadnShare</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item mx-4">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link active" aria-current="page" href="books.php">Books</a>
                    </li>
                    <li class="nav-item dropdown mx-4">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Genre
                        </a>
                        <ul class="dropdown-menu">
                            <?php 
                                $genres = (new Crud($pdo))->select('genre',[],[],'','')->fetchAll();
                                foreach($genres as $genre):
                                 
                            ?>
                            <li><a class="dropdown-item" href="book_details.php?genre_id=<?=$genre['id'];?>"><?= $genre['name'] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="nav-item dropdown mx-4">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Category
                        </a>
                        <ul class="dropdown-menu">
                        <?php 
                                $categories = (new Crud($pdo))->select('category',[],[],'','')->fetchAll();
                                foreach($categories as $category):
                                 
                            ?>
                            <li><a class="dropdown-item" href="book_details.php?category_id=<?=$category['id'];?>"><?= $category['name'] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    
                </ul>
                <div class="d-flex flex-column w-25" style="margin-right:80px;">
                    <?php if(basename($_SERVER['SCRIPT_FILENAME']) == "books.php"): ?>
                    <form class="d-flex my-2" name="search-form"  method="get" action="<?= $_SERVER['REQUEST_URI']; ?>">
                        <input class="form-control me-2" type="search" name="search-value" placeholder="Search by title or published year" aria-label="Search">
                        <button class="btn btn-outline-success" name="search-btn" type="submit">Search</button>
                    </form>
                    <?php endif; ?>
                    <div class="d-flex justify-content-center">
                    <?php if(!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)): ?>
                    <div class="dropdown mx-2 w-50">
                        <button type="button" class="btn btn-success dropdown-toggle w-100" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            Sign In
                        </button>
                        <form class="dropdown-menu p-4 mt-2" method="post" action="<?= $_SERVER['PHP_SELF']; ?>" style="width:250px;">
                            <div class="mb-3">
                            <label for="exampleDropdownFormEmail" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="exampleDropdownFormEmail" placeholder="email@example.com">
                            </div>
                            <div class="mb-3">
                            <label for="exampleDropdownFormPassword" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleDropdownFormPassword" placeholder="Password">
                            </div>
                            <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="dropdownCheck2">
                                <label class="form-check-label" for="dropdownCheck2">
                                Remember me
                                </label>
                            </div>
                            </div>
                            <button type="submit" name="signin-btn" class="btn btn-primary">Sign in</button>
                        </form>
                    </div>
                    <div class="dropdown mx-2 w-50">
                        <button type="button" class="btn btn-success dropdown-toggle w-100" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            Sign Up
                        </button>
                        <form class="dropdown-menu p-4 mt-2" style="width:250px;"  method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
                            <div class="mb-3">
                            <label for="exampleDropdownFormName2" class="form-label">First Name</label>
                            <input type="text" name="firstname" class="form-control" id="exampleDropdownFormName2" placeholder="John">
                            </div>
                            <div class="mb-3">
                            <label for="exampleDropdownFormLastName2" class="form-label">Last Name</label>
                            <input type="text" name="lastname" class="form-control" id="exampleDropdownFormLastName2" placeholder="Doe">
                            </div>
                            <div class="mb-3">
                            <label for="exampleDropdownFormEmail2" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="email@example.com">
                            </div>
                            <div class="mb-3">
                            <label for="exampleDropdownFormPassword2" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleDropdownFormPassword2" placeholder="Password">
                            </div>
                            <button type="submit" name="signup-btn" class="btn btn-primary">Sign Up</button>
                        </form>
                    </div>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): 
                        $logged_user = (new Crud($pdo))->select('person',[],['id'=> $_SESSION['user_id']],1,'')->fetch();    
                        
                    ?>
                    <div class="dropdown mx-2 w-50">
                        <button type="button" class="btn btn-success dropdown-toggle w-100" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside"> Modify Account    </button>
                        <form class="dropdown-menu p-4 mt-2" style="width:250px;"  method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" id="userid" value="<?= $logged_user['id'] ?>">
                            <div class="mb-3">
                            <label for="modify-firstname" class="form-label">First Name</label>
                            <input type="text" name="modify-firstname" class="form-control" id="modifyname" required value="<?= $logged_user['name'] ?>">
                            </div>
                            <div class="mb-3">
                            <label for="modify-lastname" class="form-label">Last Name</label>
                            <input type="text" name="modify-lastname" class="form-control" id="modifylastname" required value="<?= $logged_user['surname'] ?>">
                            </div>
                            <div class="mb-3">
                            <label for="modify-email" class="form-label">Email address</label>
                            <input type="email" name="modify-email" class="form-control" id="modifyemail" required value="<?= $logged_user['email'] ?>">
                            </div>
                            <!-- <div class="mb-3">
                            <label for="modify-password" class="form-label">Password</label>
                            <input type="password" name="modify-password" class="form-control" id="modifypassword" value="<?= $logged_user['password'] ?>">
                            </div> -->
                            <button type="submit" name="modify-btn" class="btn btn-primary">Modify</button>
                            <button type="submit" name="delete-btn" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                    <div>
                        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
                            <button type="submit" name="logout-btn" class="btn btn-success w-100">Log Out</button>
                        </form>

                    </div>

                    <?php endif; ?>


                    </div>
                    
                    
                </div>
                
                </div>
            </div>
        </nav>
    </header>
    <?php if(count($errors) > 0): ?>
    <div class="alert alert-warning w-50 d-flex justify-content-center align-content-center mt-2 mx-auto">
        
            <?php foreach($errors as $error): ?>
            <p class="p-0 m-0"><?= $error; ?></p>
            <?php endforeach; ?> 

    </div>
    <?php endif; ?>
    