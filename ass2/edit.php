<?php
require_once 'dbconfig.inc.php';

if (!isset($_GET['id'])) {
    die("Product ID not provided.");
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $rating = $_POST['rating'];
    $image = $_FILES['image']['name'];
    $quantity = $_POST['quantity'];


    if ($image) {
        $new_filename = $id . '.jpeg';
        $target = "images/" . $new_filename;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $stmt = $pdo->prepare("UPDATE products SET name=?, category=?, description=?, price=?, rating=?, image=? WHERE id=?");
        $stmt->execute([$name, $category, $description, $price, $rating, $new_filename, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE products SET name=?, category=?, description=?, price=?, rating=? WHERE id=?");
        $stmt->execute([$name, $category, $description, $price, $rating, $id]);
    }

    header("Location: products.php");
    exit();
}


$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
</head>

<body>
    <header>
        <img src="Images/mshalash.png" width="200">

        <p><B>Add a new Product :<a href="add.php"><img src="Images/ADD.png" alt="Add product" width="30"></a></B></p>
        <p><B>Go to the Home Page :<a href="products.php"><img src="Images/Home.png" alt="Home Page" width="30"></a></B></p>

        <hr>
    </header>
    <main>
        <fieldset>
            <legend><B>Edit Product</B></legend>
            <form method="POST" enctype="multipart/form-data">
                <label>Product ID:</label>
                <input type="text" value="<?= $product['id'] ?>" readonly>
                <br>
                <br>
                <label for="na">Name: </label>
                <input type="text" id="na" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                <br>
                <br>
                <label>Category: </label>
                <select name="category" required>
                    <option> <?= htmlspecialchars($product['category']) ?> </option>
                    <option>Formal Shirt</option>
                    <option>Hoodies</option>
                    <option>T-Shirt</option>
                    <option>Polo shirt</option>
                    <option>OverSize Shirt</option>
                </select>
                <br>
                <br>
                <label for="pr">Price: </label>
                <input type="number" id="pr" step="0.1" name="price" value="<?= $product['price'] ?>" required>
                <br>
                <br>
                <label for="qu">Quantity:</label>
                <input type="number" id="qu" name="quantity" value="<?= $product['quantity'] ?>" required>
                <br>
                <br>
                <label for="ra">Rating: </label>
                <input type="number" id="ra" min="0" max="5" name="rating" value="<?= $product['rating'] ?>" required>
                <br>
                <br>
                <label for="des">Description:</label>
                <br>
                <textarea name="description" id="des" required><?= htmlspecialchars($product['description']) ?></textarea>
                <br>
                <br>
                <label for="im">Image: </label>
                <input type="file" id="im" accept="Image/jpeg" name="image">
                <br>
                <br>
                <p>Current image: <img src="Images/<?= $product['image'] ?>" width="120"></p>
                <br><br>
                <button type="submit">Save Changes</button>
            </form>
        </fieldset>
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