<?php include('includes/header.php'); ?>
<?php

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $element = $_GET['item'];
    unset($_SESSION['cart'][$element]);
    header('Location:my-items.php');
}

if(isset($_GET['action']) && $_GET['action'] == 'decrement'){
    $element = $_GET['item'];
    if($_SESSION['cart'][$element]['stock'] == 1){
        unset($_SESSION['cart'][$element]);
        header('Location:my-items.php');

    } else {
        $_SESSION['cart'][$element]['stock'] = $_SESSION['cart'][$element]['stock'] - 1 ;
    }
}

if(isset($_GET['action']) && $_GET['action'] == 'increment'){
    $element = $_GET['item'];
    $getstock = (new Crud($pdo))->select('book',[],['id'=>$element],1,'')->fetch();
    if($_SESSION['cart'][$element]['stock'] == $getstock['stock']){
        echo '<script type="text/javascript">alert("INFO: Already all books from stock added to your order!");</script>';
    }else{
        $_SESSION['cart'][$element]['stock'] = $_SESSION['cart'][$element]['stock'] + 1 ;

    }

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

<section class="my-items py-5">
    <div class="container">
    <?php
        function calculateTotal($cart){
            $total = 0.0;
            if(is_array($cart) && count($cart)>0){
                foreach($cart as $item){
                    $total += $item['price'];
                }
            }
            return $total;
        }?>
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            $myorders = (new Crud($pdo))->select('orders', [], ['personid' => $_SESSION['user_id']], '', '');
            $myorders = $myorders->fetchAll();
        ?>
            <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>
                <h2 class="text-center">Shopping Cart (<?= count($_SESSION['cart']); ?>)</h2>
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $book_id => $book) :
                        $subtotal = $book['price'] * $book['stock'];
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td><?= $book_id; ?></td>
                            <td><?= $book['title']; ?></td>
                            <td><?= number_format($book['price'], 2); ?>&euro;</td>
                            <td>
                                <a href='?action=decrement&item=<?= $book_id ?>' class='btn btn-sm btn-primary'>-</a>
                                <?= $book['stock']; ?>
                                <a href='?action=increment&item=<?=$book_id ?>' class='btn btn-sm btn-primary'>+</a>
                            </td>

                            <td><?= $subtotal; ?>&euro;</td>
                            <td>
                                <a href='?action=delete&item=<?= $book_id ?>' class='btn btn-sm btn-danger' onclick="return confirm('Are you sure?');">x</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan='4' class='text-right'><strong>Total:</strong></td>
                        <td colspan='2'><h5><?= $total; ?>&euro;</h5></td>
                    </tr>
                </table>

                <h3 class="text-center mt-4">Checkout</h3>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" class="row g-3 justify-content-center">
                    <input type="hidden" name="total" value="<?= $total ?>" required>
                    <div class="col-md-3">
                        <label for="fullname" class="form-label">Fullname</label>
                        <input type="text" name="fullname" class="form-control" placeholder="Fullname" required>
                    </div>
                    <div class="col-md-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" required value="<?= $_SESSION['email']; ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Address" required>
                    </div>
                    <div class="col-md-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" class="form-control" rows="1" required></textarea>
                    </div>
                    <div class="col-md-3 text-center">
                        <button class="btn btn-primary" type="submit" name="checkout">Check Out</button>
                    </div>
                </form>

                <?php
                if (isset($_POST['checkout']) && (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0)) {
                    $user_id = $_SESSION['user_id'];
                    $fullname = $_POST['fullname'];
                    $email = $_POST['email'];
                    $address = $_POST['address'];
                    $notes = $_POST['notes'];
                    $total = $_POST['total'];
                    // $total = calculateTotal($_SESSION['cart']);

                    $crudObj = new Crud($pdo);

                    if ($crudObj->insert('orders', ['personid', 'fullname', 'email', 'address', 'notes', 'total'], [$user_id, $fullname, $email, $address, $notes, $total])) {
                        $insertOrder = $crudObj->select('orders', ['id'], ['personid' => $_SESSION['user_id']], 1, 'id DESC');
                        $lastOrderId = $insertOrder->fetch()['id'];
                    }

                    foreach ($_SESSION['cart'] as $book) {
                        $checkoutdone = $crudObj->insert('order_book', ['orderid', 'bookid', 'qty'], [$lastOrderId, $book['id'], $book['stock']]);

                        if ($checkoutdone) {
                            $getbook = (new Crud($pdo))->select('book', [], ['id' => $book['id']], '', '')->fetch();
                            if (($getbook['stock'] > 0)) {
                                $updatestock = $crudObj->update('book', ['stock'], [$getbook['stock'] - $book['stock']], ['id' => $getbook['id']]);
                            }
                        }
                    }
                    unset($_SESSION['cart']);
                    header('Location: my-items.php');
                }
                ?>

            <?php } else { ?>
                <h2 class="text-center mt-5" style="color:#00a004;">Your cart is empty.  
                <a href="books.php" style="color:#00a994;" class="link rounded text-decoration-none"> Explore our Books </a> and save your favorites to your cart!</h2>
            <?php } ?>

            <?php if (count($myorders) > 0) : ?>
                <h2 class="text-center mt-5">My Orders (<?= count($myorders); ?>)</h2>
                <div class="row mt-4">
                    <table class="table">
                        <tr>
                            <th>Id</th>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Notes</th>
                            <th>Total</th>
                            <th>Created_at</th>
                        </tr>
                        <?php foreach ($myorders as $order) : ?>
                            <tr>
                                <td><?= $order['id'] ?></td>
                                <td><?= $order['fullname'] ?></td>
                                <td><?= $order['email'] ?></td>
                                <td><?= $order['address'] ?></td>
                                <td><?= $order['notes'] ?></td>
                                <td><?= number_format( $order['total'], 2); ?>&euro;</td>
                                <td><?= $order['created_at'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php else : ?>
                <h2 class="text-center mt-5" style="color:darkolivegreen;">You've got (<?= count($myorders); ?>) Orders</h2>
                <p class="text-center mt-5" style="color:darkslategrey;">You haven’t made any orders yet. 
                    <a href="books.php" style="color:#00d974;" class="link rounded text-decoration-none">Explore our books</a> and make your first purchase today!
                </p>
            <?php endif; ?>

        <?php } else {
            header('Location:index.php');
        } ?>

<?php 
            $mybooks = (new Crud($pdo))->select('book',[],['userid'=> $_SESSION['user_id']],'','')->fetchAll();
            if($mybooks){
                foreach($mybooks as $mybook){
                    $soldbooks = (new Crud($pdo))->select('order_book',[],['bookid'=>$mybook['id']],'',' orderid')->fetchAll();
                    if($soldbooks){ 
                        
                    ?>

                    <div class="row mt-4">
                        
                    <h2 class="text-center mt-5">My Sold Books (<?= count($soldbooks); ?>)</h2>
                        <table class="table">
                            <tr>
                                <th>OrderId</th>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Notes</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Date</th>
                            </tr>
                            <?php foreach ($soldbooks as $sold) : 

                                    $orders = (new Crud($pdo))->select('orders', [],['id'=> $sold['orderid']],'','')->fetchAll();
                                    //$myacc = (new Crud($pdo))->select('person',[],['id'=>2],'','')->fetch(); 
                                    foreach($orders as $anorder):
                                
                                
                            ?>
                                <tr>
                                    <td><?= $sold['orderid'] ?></td>
                                    <td><?= $anorder['fullname'] ?></td>
                                    <td><?= $anorder['email'] ?></td>
                                    <td><?= $anorder['address'] ?></td>
                                    <td><?= $anorder['notes'] ?></td>
                                    <td><?= $sold['qty'] ?></td>
                                    <td><?= number_format($anorder['total'], 2); ?>&euro;</td>
                                    <td><?= $anorder['created_at'] ?></td>
                                </tr>
                            <?php endforeach; endforeach; ?>
                        </table>
                    </div>
                <?php


                    }
                }

            }
        
        
        ?>
        
    </div>
</section>
<?php include('includes/footer.php'); ?>
