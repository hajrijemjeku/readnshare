<?php include('includes/header.php'); ?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $element = $_GET['item'];
    unset($_SESSION['cart'][$element]);
    header('Location:my-items.php');
}
?>

<section class="my-items py-5">
    <div class="container">
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            $myorders = (new Crud($pdo))->select('orders', [], ['personid' => $_SESSION['user_id']], '', '');
            $myorders = $myorders->fetchAll();
        ?>
            <h2 class="text-center mb-4">Shopping Cart (<?= count($_SESSION['cart']); ?>)</h2>
            <?php if (isset($_SESSION['cart']) && (!empty($_SESSION['cart']))) { ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            foreach ($_SESSION['cart'] as $book_id => $book) {
                                $total += $book['price'] * $book['stock']; // Update total calculation
                            ?>
                                <tr>
                                    <td><?= $book_id; ?></td>
                                    <td><?= $book['title']; ?></td>
                                    <td><?= number_format($book['price'], 2); ?>&euro;</td>
                                    <td><?= $book['stock']; ?></td>
                                    <td><?= number_format($book['price'] * $book['stock'], 2); ?>&euro;</td>
                                    <td>
                                        <a href='?action=delete&item=<?= $book_id ?>' class='btn btn-danger btn-sm' onclick="return confirm('Are you sure?');">Remove</a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr class="table-success">
                                <td colspan="4" class="text-right"><strong>Total</strong></td>
                                <td colspan="2"><strong><?= number_format($total, 2); ?>&euro;</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3 class="mt-4">Checkout</h3>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" class="row g-3 mt-3">
                    <div class="col-md-4">
                        <label for="fullname" class="form-label">Fullname</label>
                        <input type="text" name="fullname" class="form-control" placeholder="Fullname" required>
                    </div>
                    <div class="col-md-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" required value="<?= $_SESSION['email']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Address" required>
                    </div>
                    <div class="col-md-12">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="col-md-12 text-end">
                        <button class="btn btn-primary" type="submit" name="checkout">Check Out</button>
                    </div>
                </form>

            <?php } else { ?>
                <h2 class="text-center mt-5" style="color:#00a004;">Your cart is empty.
                    <a href="books.php" class="link rounded text-decoration-none" style="color:#00a994;"> Explore our Books </a> and save your favorites to your cart!</h2>
            <?php } ?>

            <?php if (count($myorders) > 0) { ?>
                <h2 class="text-center mt-5"> My Orders (<?= count($myorders); ?>)</h2>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Notes</th>
                                <th>Total</th>
                                <th>Created_at</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($myorders as $order) { ?>
                                <tr>
                                    <td><?= $order['id'] ?></td>
                                    <td><?= $order['fullname'] ?></td>
                                    <td><?= $order['email'] ?></td>
                                    <td><?= $order['address'] ?></td>
                                    <td><?= $order['notes'] ?></td>
                                    <td><?= number_format($order['total'], 2); ?>&euro;</td>
                                    <td><?= $order['created_at'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <h2 class="text-center mt-5" style="color:darkolivegreen;"> You've got (<?= count($myorders); ?>) Orders</h2>
                <p class="text-center mt-5" style="color:darkslategrey;">You haven’t made any orders yet.
                    <a href="books.php" class="link rounded text-decoration-none" style="color:#00d974;">Explore our books</a> and make your first purchase today!
                </p>
            <?php } ?>
        <?php } else {
            header('Location:index.php');
        } ?>
    </div>
</section>

<?php include('includes/footer.php'); ?>
