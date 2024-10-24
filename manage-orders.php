<?php include('includes/header.php'); ?>

<?php

if((!isset($_SESSION['logged_in'])) || (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] !== true))){
    header('Location: index.php');     
}

if(isset($_SESSION["logged_in"]) && ($_SESSION["logged_in"] == true)) {
    
    if(!(isset($_SESSION["is_admin"]) && ($_SESSION["is_admin"] == 1))){

        echo "<h1> NOT ALLOWED HERE.  <a href='index.php'>Go Back</a> ! </h1>";        
        die();
            //header('Location:index.php');  
    }   
}

?>

<?php
    $errors = [];

    
        
    $orders = (new Crud($pdo))->select('orders', ['id','personid','email','fullname','address','notes','created_at','total'], [], '', '')->fetchAll();
        
    
?>

<section class="books py-5">
    <div class="container">
        
        <?php if(count($errors) > 0){ ?>
            <div class="alert alert-warning ">
                <?php foreach($errors as $error): ?>
                    <p class="m-0 p-0">
                        <?= $error; ?>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php } ?>

        <?php if(count($orders) > 0): ?>
        <h2 class="text-center">Manage Orders (<?= count($orders) ?>)</h2>
        <div class="row mt-4">
            <table class="table">
                <tr>
                    <th>Id</th>
                    <th>Personid</th>
                    <th>Fullname</th>
                    <th>Address</th>
                    <th>Notes</th>
                    <th>CreatedAt</th>
                    <th>Total</th>
                    <?php if(isset($_SESSION["is_admin"]) && ($_SESSION["is_admin"] == true)) { ?>
                    <th>Action</th>
                    <?php } ?>
                </tr>
                <?php foreach($orders as $order): ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= $order['personid'] ?></td>
                        <td><?= $order['fullname'] ?></td>
                        <td><?= $order['address'] ?></td>
                        <td><?= $order['notes'] ?></td>
                        <td><?= $order['created_at'] ?></td>
                        <td><?= $order['total'] ?> &euro;</td>
                        <?php if(isset($_SESSION["is_admin"]) && ($_SESSION["is_admin"] == true)) { ?>
                        <td>
                            <a class="btn btn-sm btn-danger" href="?action=delete&id=<?= $order['id'] ?>" onclick="return confirm('Are you sure?');">delete</a>

                        </td>
                        <?php } ?>

                    </tr>

                    <?php
                    if(isset($_SESSION["is_admin"]) && ($_SESSION["is_admin"] == true)) {

                       

                        if(isset($_GET['action']) && $_GET['action'] == 'delete'){
                            $orderId = $_GET['id'];
                            $order = (new Crud($pdo))->select('orders', [], ['id' => $orderId], '', '')->fetch();
                            
                            $deleteOrderBooks = (new Crud($pdo))->delete('order_book', 'orderid', $orderId);
                            $deleteOrder = (new Crud($pdo))->delete('orders', 'id', $orderId);

                            if ($deleteOrderBooks && $deleteOrder) {
                                header('Location: manage-orders.php');
                                exit;
                            } else {
                                echo 'Failed to delete order or order books.';
                                exit;
                            }
                        }
                    }
                    ?>
                    <?php endforeach; ?>
            </table>
        </div>
        <?php else :  ?> 
                <h2 class="text-center mt-5">You've got (<?= count($orders); ?>) Orders to Manage</h2>
                <p class="text-center mt-5" >
                    <a href="books.php" class="link rounded text-decoration-none">Head to the books</a> section to ensure everything is up-to-date and ready for new orders!
                </p>
        <?php endif; ?>

        <?php

?>
        
    </div>
</section>

<?php include('includes/footer.php'); ?>