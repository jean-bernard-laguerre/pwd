<?php
    require_once '../vendor/autoload.php';

    $product = new App\Product();

    $page = 1;
    
    if(isset($_GET['page']) && $_GET['page'] > 0) {
        $page = $_GET['page'];
    }

    $products = $product->findPaginated($page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <caption>Products</caption>
        <th>
            <td>Name</td>
            <td>Price</td>
            <td>Quantity</td>
        </th>
        <tbody>
            <?php
                foreach($products as $product) {
                    echo '<tr>';
                    echo '<td><a href="product.php?id=' . $product->getId() . '">' . $product->getName() . '</a></td>';
                    echo '<td>' . $product->getPrice() . '</td>';
                    echo '<td>' . $product->getQuantity() . '</td>';
                    echo '</tr>';
                }
            ?>
            <!-- pagination buttons (previous, next) -->
            <tr>
                <td>
                    <a href="shop.php?page=1">First</a>
                </td>
                <td>
                    <a href="shop.php?page=<?= $page - 1 ?>">Previous</a>
                </td>
                <td>
                    <a href="shop.php?page=<?= $page + 1 ?>">Next</a>
                </td>
        </tbody>
    </table>
</body>
</html>
