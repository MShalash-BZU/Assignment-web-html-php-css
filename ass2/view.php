<?php
require_once 'dbconfig.inc.php';
require_once 'product.class.php';

if (!isset($_GET['id'])) {
    die("Product ID not provided.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    die("Product not found.");
}

$product = new Product(
    $row['id'],
    $row['name'],
    $row['category'],
    $row['description'],
    $row['price'],
    $row['rating'],
    $row['image'],
    $row['quantity']
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product Details</title>
    <style>main {
  max-width: 700px;
  margin: 2.5rem auto;
  padding: 2rem 2.5rem;
  background: linear-gradient(135deg, #f7fafd 60%, #e3f2fd 100%);
  border-radius: 18px;
  box-shadow: 0 4px 24px rgba(25, 118, 210, 0.13), 0 1.5px 6px rgba(0, 0, 0, 0.07);
}

.product-details {
  display: flex;
  flex-wrap: wrap;
  gap: 2rem;
  align-items: flex-start;
  margin-bottom: 2rem;
}

.product-details__image {
  flex: 1 1 220px;
  max-width: 220px;
  border-radius: 12px;
  box-shadow: 0 2px 12px #b0bec5;
  background: #fff;
  padding: 1rem;
}

.product-details__info {
  flex: 2 1 350px;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px #e3e3e3;
  padding: 1.5rem;
}

.product-details__info h2 {
  color: #1976d2;
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: 1rem;
  letter-spacing: 1px;
}

.product-details__info p {
  font-size: 1.08rem;
  color: #37474F;
  margin-bottom: 0.7rem;
}

.product-details__info .price {
  color: #388e3c;
  font-size: 1.3rem;
  font-weight: bold;
  margin-bottom: 1rem;
}

.product-details__info .category {
  background: #e3f2fd;
  color: #1976d2;
  padding: 0.3rem 0.8rem;
  border-radius: 6px;
  font-weight: 500;
  display: inline-block;
  margin-bottom: 1rem;
}

.product-details__info .rating {
  color: #fbc02d;
  font-size: 1.15rem;
  font-weight: bold;
  margin-bottom: 1rem;
}

.product-details__info .quantity {
  color: #1565c0;
  font-size: 1.08rem;
  font-weight: 500;
  margin-bottom: 1rem;
}

.product-details__info .description {
  margin-top: 1rem;
  font-size: 1.08rem;
  color: #37474F;
  background: #f7fafd;
  border-radius: 8px;
  padding: 1rem;
  box-shadow: 0 1px 4px #e3e3e3;
}</style>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <img src="Images/mshalash.png" width="200">

        <p><B>Add a new Product :<a href="add.php"><img src="Images/ADD.png" alt="Add product" width="30"></a></B></p>
        <p><B>Go to the Home Page :<a href="products.php"><img src="Images/Home.png" alt="Home Page" width="30"></a></B></p>

        <hr>
    </header>
    <main class="product-details">
        <?php $product->displayProductPage(); ?>
    </main>


    <footer>
        <hr>
        <p><B> Mohamad Shalash E_Clothes 2025 &copy; <br>
                Address : Palestine,Ramallah,Al-Irsal Street <br>
                Phone : +970 595972507 <br>
                Email : codetine@gmail.com</B>
        </p>
        <a href="">Contact Us</a>
    </footer>
</body>

</html>