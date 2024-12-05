
<?php
session_start();

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Define available products (this can later be replaced by a database)
$products = [
    1 => ['name' => 'Product 1', 'price' => 10.00],
    2 => ['name' => 'Product 2', 'price' => 20.00],
    3 => ['name' => 'Product 3', 'price' => 30.00],
];

// Handle Add/Remove actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = intval($_POST['product_id']);
    $action = $_POST['action'];

    if ($action === 'add' && isset($products[$productId])) {
        // Add product to the cart
        if (!isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] = 0;
        }
        $_SESSION['cart'][$productId]++;
    } elseif ($action === 'remove' && isset($_SESSION['cart'][$productId])) {
        // Remove product from the cart
        $_SESSION['cart'][$productId]--;
        if ($_SESSION['cart'][$productId] <= 0) {
            unset($_SESSION['cart'][$productId]);
        }
    }
}

// Calculate total cost
$total = 0.00;
foreach ($_SESSION['cart'] as $productId => $quantity) {
    $total += $products[$productId]['price'] * $quantity;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
</head>
<body>
    <h1>Products</h1>
    <ul>
        <?php foreach ($products as $id => $product): ?>
            <li>
                <?= htmlspecialchars($product['name']) ?> - $<?= number_format($product['price'], 2) ?>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="<?= $id ?>">
                    <input type="hidden" name="action" value="add">
                    <button type="submit">Add to Cart</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Your Cart</h2>
    <ul>
        <?php if (empty($_SESSION['cart'])): ?>
            <li>Your cart is empty.</li>
        <?php else: ?>
            <?php foreach ($_SESSION['cart'] as $id => $quantity): ?>
                <li>
                    <?= htmlspecialchars($products[$id]['name']) ?> x <?= $quantity ?> - $<?= number_format($products[$id]['price'] * $quantity, 2) ?>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?= $id ?>">
                        <input type="hidden" name="action" value="remove">
                        <button type="submit">Remove</button>
                    </form>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <h3>Total: $<?= number_format($total, 2) ?></h3>
</body>
</html>




























 a.create a php script that accepts a comma seperated list of product names from a form and stores them into an array.Sisplay the list of products in alphabetical order 
b. write the sorted product names to a text file . if the file already exists append the new list ensuring there are no dupplicate entries
