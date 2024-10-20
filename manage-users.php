<?php include('includes/header.php'); ?>

<?php
$errors = [];

$users = (new CRUD($pdo))->select('person',[],[],'','');
if(!(isset($_SESSION['logged_in'])) && !($_SESSION['logged_in'] == true)){
    header('Location:index.php');}


$users = $users->fetchAll();

if(isset($_GET['action']) && $_GET['action'] == 'delete'){
    $deleteuser = (new CRUD($pdo))->delete('person','id',$_GET['id']);

    header('Location:manage-users.php');
    exit;
}

if(isset($_POST['edit-btn'])){

    if((!empty($_POST['name'])) && (!empty($_POST['surname'])) && (!empty($_POST['email']))){

        $updateuser = (new CRUD($pdo)) -> update('person',['name','surname','email'],[$_POST['name'],$_POST['surname'],$_POST['email']],['id'=>$_POST['id']]);

        header('Location:manage-users.php');


    }else {
        $errors [] = 'Something went wrong';
    }

}


?>
<?php 
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true):
    if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): 
?>

<?php 
    if(isset($_POST['adduser-btn'])) {

        $fullname = $_POST['fullname'];
        
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $crudObj = new CRUD($pdo);


        if(!empty($fullname)){

            $name_surname = explode(' ', $fullname);
            $surname = array_pop($name_surname); // Last part of array always surname
            $name = implode(' ', $name_surname); // The rest -> name

            if(!empty($role)){

                if(!empty($email)){
                

                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){

                        if(!empty($password)){
                            $password = password_hash($password, PASSWORD_BCRYPT);
                        
                            $allusers = $crudObj->select('person',[],['email'=> $email],'','')->fetch();
                            
                            if($allusers){
                                $errors[] = 'Ths email is already registered';
                            }else{
                                if($registerUser = $crudObj->insert('person',['name','surname','email','password','role'],[$name,$surname, $email, $password, $role])){
                                    header('Location:manage-users.php');
                                } else{
                                    $errors[] = 'Something went wrong';
                                }
                            }

                        }else{
                            $errors[] = 'Fill password field!';
                        }
                    }else{
                        $errors[] = 'Email was not valid';
                    }
                } else {
                    if($registerUser = $crudObj->insert('person',['name','surname','role'],[$name, $surname, $role])){
                        header('Location:manage-users.php');
                    } else{
                        $errors[] = 'Something went wrong';
                    }
                }

            }else{                            
                $errors[] = 'Fill user`s role';
            }

        }else{
            $errors[] = 'Fullname field empty!';
        }
        
    }
        

?>
    <section class="manage-users py-5">
        <div class="container">
        <?php if(count($errors) > 0): ?>
            <div class="alert alert-warning">
                <?php foreach($errors as $error): ?>
                    <p class="p-0 m-0"><?= $error; ?></p>
                <?php endforeach;?>
            </div>
            <?php endif;?>
        <?php if(count($users) > 0): ?>
            <h2 class="text-center">Users (<?= count($users); ?>)</h2>
        <div class="row mt-4">
            <div class="col text-end">
                <button type="button" class="btn btn-outline-success add-user-btn" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    Add User
                </button>
            </div>
        </div>
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addUserForm" method="POST">
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Fullname</label>
                                <input type="text" class="form-control" name="fullname" id="fullname" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="role" class="form-control mb-3">
                                    <option value="">Choose Role</option>
                                    <?php
                                        $roles = (new CRUD($pdo))->distinctSelect('person','role');
                                        $roles = $roles->fetchAll();
                                        
                                        foreach($roles as $role):
                                    ?>
                                    <option value="<?= $role['role']; ?>"><?= $role['role']; ?></option>
                                        <?php endforeach; ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="adduser-btn" class="btn btn-primary" form="addUserForm">Add User</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            
            <table class="table">
                <tr>
                    <!-- <th>Id</th> -->
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                <?php foreach($users as $user): 
                    if($user['id'] == $_SESSION['user_id'] && $_SESSION['user_id'] == $_SESSION['is_admin']){
                        continue;
                    }
                ?>
                <tr>
                    <td><?= $user['name'] ?></td>
                    <td><?= $user['surname'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['role'] ?></td>
                    <td>
                        <?php if(!($user['role'] == 'author')): ?> 
                            <a href="?action=edit&id=<?=$user['id'];?>" class="btn btn-sm btn-secondary">Edit</a> 
                        <?php if(!($user['role'] == 'admin')):?>
                            / <a href="?action=delete&id=<?=$user['id'];?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>  
                        <?php endif; endif ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php else: echo '<p>0 Users </p>'; ?>
        </div>
        <?php endif; ?>

        <?php if(isset($_GET['action']) && $_GET['action']=='edit'): 
            
                $fillinputs = (new CRUD($pdo))->select('person',[],['id'=>$_GET['id']],1,'');
                $fillinput = $fillinputs->fetch();

            ?>
            
            <div class="user-form w-50 p-4 shadow rounded bg-light mx-auto mt-5">
                <div class="text-center mb-4">
                    <h3 class="mb-3 text-secondary">Modify user data</h3>
                </div>
                
                <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="hidden" name="id" class="form-control" id="id" value="<?= $fillinput['id']; ?>" >
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" value="<?=$fillinput['name'];?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="surname" class="form-label">Surname</label>
                        <input type="text" name="surname" class="form-control" id="surname" value="<?=$fillinput['surname'];?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" required value="<?=$fillinput['email'];?>">
                    </div>
                    
                    <button type="submit" name="edit-btn" class="btn btn-primary w-100">Modify</button>
                </form>
            </div>
        <?php endif; ?>


        </div>
    </section>

<?php else: header('location:index.php');?>
<?php endif; endif; ?>


<?php include('includes/footer.php'); ?>