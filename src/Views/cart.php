  <section class="h-100 gradient-custom " style="border:1px solid black">
    <div class="container py-5">
      <div class="row d-flex justify-content-center my-4">
        <div class="col-md-8">
          <div class="card mb-4">
            <div class="card-header py-3">
              <h5 class="mb-0">Panier - <?= $props['profile']->getFullname() ?></h5>
            </div>

              <!-- All Item -->
              <?php foreach($props['products'] as $product): ?>
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
                          foreach($props['products'] as $product){
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
                          foreach($props['products'] as $product){
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