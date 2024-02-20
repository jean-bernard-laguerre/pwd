<?php
  namespace App;

  require_once '../vendor/autoload.php';
  session_start();


  $auth = new AuthenticationController();
  $shopController = new ShopController();
  $allProduct = $shopController->showCart();
  $profile = $auth->profile();

  if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['delete_product'])) {
        $shopController->deleteProductFromCart(intval($_POST['delete_product']));
    }
    if(isset($_POST['add_product'])) {
        $shopController->addProductToCart(1, intval($_POST['add_product']));
    }
    if(isset($_POST['remove_product'])) {
        $shopController->addProductToCart(-1, intval($_POST['remove_product']));
    }
    header("Location: cart.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/job14/style.css">

    <title>Document</title>
</head>
<body>
    <?php if($profile): ?>

<section class="h-100 gradient-custom " style="border:1px solid black">
  <div class="container py-5">
    <div class="row d-flex justify-content-center my-4">
      <div class="col-md-8">
        <div class="card mb-4">
          <div class="card-header py-3">
            <h5 class="mb-0">Panier - <?= $profile->getFullname() ?></h5>
          </div>

            <!-- All Item -->
            <?php foreach($allProduct as $product): ?>
              <div class="card-body">
                <!-- Single item -->
                <div class="row">
                  <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                    <!-- Image -->
                    <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                      <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Vertical/12a.webp"
                        class="w-100" alt="Blue Jeans Jacket" />
                      <a href="#!">
                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                      </a>
                    </div>
                    <!-- Image -->
                  </div>

                  <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                    <!-- Data -->
                    <p><strong><?= $product['product_name']?></strong></p>

                    <p><strong>Description</strong> :  <?= $product['description']?></p>
                    <p><strong>Catégorie</strong> :  <?= $product['category_name']?></p>
                    <span>
                        <form method="POST">
                                <button type="submit" name="delete_product" value="<?= $product['id_product']?>" class="btn btn-primary btn-sm me-1 mb-2" data-mdb-toggle="tooltip"
                                title="Remove item">
                                  <i class="fa fa-trash"></i>
                                </button>
                        </form>
                    </span>
                    <!-- Data -->
                  </div>


                  <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <!-- Quantity -->
                    <div class="d-flex mb-4" style="max-width: 300px">
                      <form method="POST">
                        <button class="btn btn-primary px-3 me-2"
                          type="submit"
                          name="remove_product" value= "<?= $product['id_product']?>"
                        >
                          <i class="fa fa-minus"></i>
                        </button>
                      </form>
                      <div class="form-outline">
                        <input id="form1" min="0" name="quantity" value="<?= $product['id_quantity']?>" type="number" class="form-control" />
                        <label class="form-label" for="form1">Quantity</label>
                      </div>
                      <form method="POST">
                        <button class="btn btn-primary px-3 ms-2"
                          type="submit"
                          name="add_product" value= "<?= $product['id_product']?>"
                        >
                          <i class="fa fa-plus"></i>
                        </button>
                      </form>
                    </div>
                    <!-- Quantity -->

                    <!-- Price -->
                    <p class="text-start text-md-center">
                      <strong><?=$product['price'] * $product['id_quantity']?> €</strong>
                    </p>
                    <!-- Price -->
                  </div>
                </div>
                <!-- Single item -->

                <hr class="my-4" />

                <!-- Single item -->
              </div>
            <!-- End All Item -->
            <?php endforeach; ?>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card mb-4">
          <div class="card-header py-3">
            <h5 class="mb-0">Total</h5>
          </div>
          <div class="card-body">
            <ul class="list-group list-group-flush">
              <li
                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                Produits
                <span>
                    <?php
                        $total = 0;
                        foreach($allProduct as $product){
                            $total += $product["price"] * $product["id_quantity"];
                        }
                        echo $total;
                    ?>
                    €
            </span>
              </li>
              <!-- <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                Shipping
                <span>Gratis</span>
              </li> -->
              <li
                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                <div>
                  <strong>Montant Total</strong>
                  <strong>
                    <p class="mb-0">(TVA Incluse)</p>
                  </strong>
                </div>
                 <span><strong> <?php
                        $total = 0;
                        foreach($allProduct as $product){
                            $total += $product["price"] * $product["id_quantity"];
                        }
                        echo $total;
                    ?>
                    €</strong></span> 
              </li>
            </ul>

            <button type="button" class="btn btn-primary btn-lg btn-block">
              Paiement
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>