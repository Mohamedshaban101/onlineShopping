<?php include 'inc/header.php'; ?>
<?php 
use OnlineShoping\Products\Product;
use OnlineShoping\Session\Session;

require_once __DIR__.'/classes/Product.php';
require_once __DIR__.'/classes/Session.php';


$product = new Product();
if($session->exist('userId')){
    $userId = $session->get('userId');
    if(isset($_GET['page'])){
        $page=$_GET['page'];
    }else{
        $page = 1;
    }
    $limit = 3;
    $offset = ($page - 1) * $limit;
    $productDetails = $product->readAll($userId , $page , $limit , $offset);
    $products = $productDetails['products'];
    $totalNumPages = $productDetails['totalNumPage'];
}
?>


<div class="container my-5">
    <div class="row">
        <?php if(!empty($products)):?>
            <?php foreach($products as $product):?>
                <div class="col-lg-4 mb-3">
                    <div class="card">
                        <img src="./uploads/<?= $product['image']?>" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['title']?></h5>
                            <p class="text-muted"><?= $product['price']?> EGP</p>
                            <p class="card-text"><?= $product['details']?></p>
                            <a href="show.php" class="btn btn-primary">Show</a>

                            <a href="./edit.php?id=<?= $product['id']?>" class="btn btn-info">Edit</a>
                            <a href="./handlers/handleProduct/handleDelete.php?id=<?= $product['id']?>" class="btn btn-danger">Delete</a>

                        </div>
                    </div>
                </div>
            <?php endforeach?>
        <?php else:?>
            <div class="alert alert-danger">Empty Products</div>
        <?php endif?>
    </div>

    <?php if($session->exist('userId')):?>
            <?php if(!empty($products)):?>
                <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>"><a class="page-link"
                        href="index.php?page=<?= $page - 1?>">previous</a></li>
                <?php for($i = 1 ; $i <= $totalNumPages ; $i++):?>
                <li class="page-item"><a class="page-link" href="index.php?page=<?= $i?>"><?= $i?></a></li>
                <?php endfor?>
                <li class="page-item <?= $page == $totalNumPages ? 'disabled' : ''?>"><a class="page-link"
                        href="index.php?page=<?= $page + 1?>">next</a></li>
            </ul>
        </nav>
            <?php endif?>
        <?php endif?>
</div>



<?php include 'inc/footer.php'; ?>