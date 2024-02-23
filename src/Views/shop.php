    <table>
        <caption>Products</caption>
        <th>
            <td>Name</td>
            <td>Price</td>
            <td>Quantity</td>
        </th>
        <tbody>
            <?php
                foreach($props['products'] as $product) {
                    echo '<tr>';
                    echo '<td><a href="/pwd/product/' . $product->getId() . '">' . $product->getName() . '</a></td>';
                    echo '<td>' . $product->getPrice() . '</td>';
                    echo '<td>' . $product->getQuantity() . '</td>';
                    echo '</tr>';
                }
            ?>
            <!-- pagination buttons (previous, next) -->
            <tr>
                <td>
                    <a href="/pwd/shop/1">First</a>
                </td>
                <td>
                    <a href="/pwd/shop/<?= $props['page'] - 1 ?>">Previous</a>
                </td>
                <td>
                    <a href="/pwd/shop/<?= $props['page'] + 1 ?>">Next</a>
                </td>
        </tbody>
    </table>

