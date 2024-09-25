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
    <div class="container">
    <div class="row mt-4">
    
<?php
        $crudObj = new Crud($pdo);

        $allbooks = $crudObj->select('book',[],[],'','');
        if($allbooks){
            $allbooks = $allbooks->fetchAll();
        foreach($allbooks as $book):
    
    ?>
                <div class="col-lg-4 col-md-3 col-sm-12 mb-3" >
                <div class="card" style="width: 22rem; height:500px;">
                <input type="hidden" name="book_id" id="book_id" value="<?= $book['id'] ?>">
                
                <a href="book_details.php?book_id=<?=$book['id'];?>">
                    <img src="./assets/images/books/<?= $book['image']; ?>" class="card-img-top p-3" alt="<?= $book['image']; ?>" height="400px">
                </a>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $book['title'] ?></h5>
                    <p class="card-text"> 
                        Price: <strong> <?php echo number_format($book['price'],2);  ?> &euro; </strong> / Language: <strong><?= $book['language'] ?> </strong>
                    </p>

                </div>
            </div>
        </div>
        <?php endforeach; }?>




</div>
</div>

</section>





<?php include('includes/footer.php'); ?>
