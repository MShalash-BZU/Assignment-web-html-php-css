<?php
require_once 'dbconfig.inc.php';
require_once 'product.class.php';

function fetchProducts($pdo, $filters = [])
{
    $sql = "SELECT * FROM products WHERE 1";
    $params = [];

    if (!empty($filters['name'])) {
        $sql .= " AND name LIKE :name";
        $params[':name'] = "%" . $filters['name'] . "%";
    }

    if (!empty($filters['price'])) {
        $sql .= " AND price <= :price";
        $params[':price'] = $filters['price'];
    }

    if (!empty($filters['category']) && $filters['category'] != "select category") {
        $sql .= " AND category = :category";
        $params[':category'] = $filters['category'];
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $products[] = new Product(
            $row['id'],
            $row['name'],
            $row['category'],
            $row['description'],
            $row['price'],
            $row['rating'],
            $row['image'],
            $row['quantity']
        );
    }

    return $products;
}


$filters = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name'])) {
        $filters['name'] = $_POST['name'];
    } else {
        $filters['name'] = '';
    }
    if (isset($_POST['price'])) {
        $filters['price'] = $_POST['price'];
    } else {
        $filters['price'] = '';
    }
    if (isset($_POST['category'])) {
        $filters['category'] = $_POST['category'];
    } else {
        $filters['category'] = '';
    }
}



if (isset($_GET['page'])) {
    $page = max(1, intval($_GET['page']));
} else {
    $page = 1;
}
$productsPerPage = 10;
$allProducts = fetchProducts($pdo, $filters);
$totalProducts = count($allProducts);
if ($totalProducts % $productsPerPage === 0) {
    $total = $totalProducts / $productsPerPage;
} else {
    $total = (int)($totalProducts / $productsPerPage) + 1;
}
$start = ($page - 1) * $productsPerPage;
$products = [];
for ($i = $start; $i < $start + $productsPerPage && $i < $totalProducts; $i++) {
    $products[] = $allProducts[$i];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>E-Clothes Store</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <img src="Images/mshalash.png" width="200">
        <p><b>Add a new Product :<a href="add.php"><img src="Images/ADD.png" alt="Add product" width="30"></a></b></p>
        <p><b>Go to the Home Page :<a href="products.php"><img src="Images/Home.png" alt="Home Page" width="30"></a></b></p>
        <p><b>Back to Assignments :<a href="../index.html"><img src="Images/assi.png" alt="Assignments Page" width="30"></a></b></p>
        <hr>
    </header>

    <section class="page-grid">
        <aside class="search">
            <form method="POST" action="products.php">
                <?php if (isset($filters['name'])): ?>
                    <input type="text" name="name" placeholder="Product Name" value="<?= htmlspecialchars($filters['name']) ?>">
                <?php else: ?>
                    <input type="text" name="name" placeholder="Product Name" value="">
                <?php endif; ?>
                <input type="number" step="0.01" name="price" placeholder="Max Price" value="<?= htmlspecialchars($filters['price'] ?? '') ?>">
                <select name="category">
                    <option>select category</option>
                    <?php
                    if (isset($filters['category']) && $filters['category'] == 'Formal Shirt') {
                        echo '<option selected>Formal Shirt</option>';
                    } else {
                        echo '<option>Formal Shirt</option>';
                    }
                    if (isset($filters['category']) && $filters['category'] == 'Hoodies') {
                        echo '<option selected>Hoodies</option>';
                    } else {
                        echo '<option>Hoodies</option>';
                    }
                    if (isset($filters['category']) && $filters['category'] == 'T-Shirt') {
                        echo '<option selected>T-Shirt</option>';
                    } else {
                        echo '<option>T-Shirt</option>';
                    }
                    if (isset($filters['category']) && $filters['category'] == 'Polo shirt') {
                        echo '<option selected>Polo shirt</option>';
                    } else {
                        echo '<option>Polo shirt</option>';
                    }
                    if (isset($filters['category']) && $filters['category'] == 'OverSize Shirt') {
                        echo '<option selected>OverSize Shirt</option>';
                    } else {
                        echo '<option>OverSize Shirt</option>';
                    }
                    ?>
                </select>
                <button type="submit">Filter</button>
            </form>
        </aside>

        <main class="product-main">
            <h2>Product List</h2>
            <section class="product-grid">
                <?php if (empty($products)): ?>
                    <section class="pagination-bar">No products found.</section>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <section class="product-card">
                            <img src="Images/<?= htmlspecialchars($product->getImage()) ?>" alt="<?= htmlspecialchars($product->getName()) ?>">
                            <section class="product-id">
                                <h2>Product #<?= htmlspecialchars($product->getId()) ?></h2>
                            </section>
                            <section class="product-name" >
                                <p><?= htmlspecialchars($product->getName()) ?></p>
                            </section>
                            <section class="tooltip">
                                <section>
                                    <?php if ($product->getQuantity() <= 5): ?>
                                        <h2 class="quantity-low">
                                            Quantity: <?= htmlspecialchars($product->getQuantity()) ?>
                                        </h2>
                                    <?php else: ?>
                                        <h2 class="quantity-normal">
                                            Quantity: <?= htmlspecialchars($product->getQuantity()) ?>
                                        </h2>
                                    <?php endif; ?>
                                    <p><?= htmlspecialchars($product->getDescription()) ?></p>
                                </section>
                            </section>
                            <span class="category-filed <?= str_replace(' ', '', $product->getCategory()) ?>">
                                Category:<?= htmlspecialchars($product->getCategory()) ?>
                            </span>
                            <section class="product-price">Price: $<?= htmlspecialchars(number_format($product->getPrice(), 2)) ?></section>
                            <nav class="action-bar">
                                <a class="view-btn" href="view.php?id=<?= $product->getId() ?>">View</a>
                                <a class="cart-btn" href="cart.php?add_id=<?= htmlspecialchars($product->getId()) ?>">Add to Cart</a>
                            </nav>
                        </section>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ($total > 1): ?>
                    <nav class="pagination-bar">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?= $page - 1 ?>" class="pagination-btn"><button type="button"> << Previous</button></a>
                        <?php else: ?>
                            <span></span>
                        <?php endif; ?>
                        <span>Page <?= $page ?> of <?= $total ?></span>
                        <?php if ($page < $total): ?>
                            <a href="?page=<?= $page + 1 ?>" class="pagination-btn"><button type="button">Next >> </button></a>
                        <?php else: ?>
                            <span></span>
                        <?php endif; ?>
                    </nav>
                <?php endif; ?>
            </section>
        </main>
    </section>

    <footer>
        <hr>
        <p><b> Mohamad Shalash E_Clothes 2025 &copy; <br>
                Address : Palestine,Ramallah,Al-Irsal Street <br>
                Phone : +970 595972507 <br>
                Email : codetine@gmail.com</b>
        </p>
        <a href="">Contact Us</a>
    </footer>
</body>

</html>