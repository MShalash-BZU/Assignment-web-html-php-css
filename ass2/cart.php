<?php
session_start();
require_once 'dbconfig.inc.php';
require_once 'product.class.php';

if (isset($_GET['add_id'])) {
    $productId = intval($_GET['add_id']);
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$productId] = [
                'title' => $row['name'],
                'price' => $row['price'],
                'quantity' => 1
            ];
        }
    } 
}

if (isset($_GET['remove'])) {
    $removeId = intval($_GET['remove']);
    if (isset($_SESSION['cart'][$removeId])) {
        unset($_SESSION['cart'][$removeId]);
    }
}


if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
} else {
    $cart = [];
}
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Shopping Cart</title>
    <style>.cart-page {
  max-width: 800px;
  margin: 2.5rem auto;
  padding: 2rem 2.5rem;
  background: linear-gradient(135deg, #e3f2fd 60%, #f7fafd 100%);
  border-radius: 18px;
  box-shadow: 0 4px 24px rgba(25, 118, 210, 0.10), 0 1.5px 6px rgba(0, 0, 0, 0.07);
}

.cart-page h2 {
  color: #1976d2;
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: 1.5rem;
  letter-spacing: 1px;
  text-align: center;
}

.cart-page table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 2rem;
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 12px #e3e3e3;
}

.cart-page th, .cart-page td {
  padding: 1rem 0.7rem;
  text-align: center;
  font-size: 1.08rem;
}

.cart-page th {
  background: #1976d2;
  color: #fff;
  font-weight: 600;
  border-bottom: 2px solid #90caf9;
}

.cart-page tr:nth-child(even) {
  background: #e3f2fd;
}

.cart-page tr:nth-child(odd) {
  background: #f7fafd;
}

.cart-page tr:last-child td {
  background: #fffde7;
  color: #388e3c;
  font-size: 1.15rem;
  font-weight: bold;
  border-top: 2px solid #fbc02d;
}

.cart-page a {
  color: #1976d2;
  background: #e3f2fd;
  padding: 0.3rem 0.8rem;
  border-radius: 6px;
  text-decoration: none;
  font-weight: 500;
  transition: background 0.2s, color 0.2s;
}

.cart-page a:hover {
  background: #1976d2;
  color: #fff;
}

.cart-page p {
  font-size: 1.1rem;
  color: #37474F;
  text-align: center;
  margin: 1.5rem 0;
}</style>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <img src="Images/mshalash.png" width="200">
    <p><b>Go to the Home Page :<a href="products.php"><img src="Images/Home.png" alt="Home Page" width="30"></a></b></p>
    <hr>
</header>
<main class="cart-page">
    <section>
        <h2>Your Shopping Cart</h2>
        <?php if (empty($cart)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $id => $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['title']) ?></td>
                    <td>$<?= $item['price'] ?></td>
                    <td>
                        <?= $item['quantity'] ?>
                    </td>
                    <td>$<?= $item['price'] * $item['quantity'] ?></td>
                    <td>
                        <a href="cart.php?remove=<?= $id ?>">Remove</a>
                    </td>
                    
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><b>Total:</b></td>
                    <td colspan="2"><b>$<?= $total?></b></td>
                </tr>
            </tbody>
        </table>
        <?php endif; ?>
        
    </section>
</main>
<footer>
    <hr>
    <p><b> Mohamad Shalash E_Clothes 2025 &copy; <br>
    Address : Palestine,Ramallah,Al-Irsal Street <br>
    Phone : +970 595972507 <br>
    Email : codetine@gmail.com</b></p>
    <a href="">Contact Us</a>
</footer>
</body>
</html>