<?php
require_once 'dbconfig.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $rating = $_POST['rating'];
    $quantity = $_POST['quantity'];
    if($category=="select category"){
        $category=null;
        echo "select category !!!";
        exit();

    }else{
        $stmt = $pdo->prepare("INSERT INTO products (name, category, description, price, rating, image,quantity)
                           VALUES (?,?,?,?,?,'',?)");
    $stmt->execute([$name, $category, $description, $price, $rating, $quantity]);
            
            $product_id = $pdo->lastInsertId();
            $new_filename = $product_id . '.jpeg';
            $target = "Images/" . $new_filename;
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
            $stmt = $pdo->prepare("UPDATE products SET image = ? WHERE id = ?");
            $stmt->execute([$new_filename, $product_id]);

    }


    
    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <style>.add-page {
  max-width: 600px;
  margin: 2.5rem auto;
  padding: 2rem 2.5rem;
  background: linear-gradient(135deg, #f7fafd 60%, #e3f2fd 100%);
  border-radius: 18px;
  box-shadow: 0 4px 24px rgba(25, 118, 210, 0.13), 0 1.5px 6px rgba(0, 0, 0, 0.07);
}

.add-page fieldset {
  border: 2px solid #607D8B;
  border-radius: 12px;
  padding: 2rem 1.5rem 1.5rem 1.5rem;
  background: #fff;
  box-shadow: 0 2px 8px #e3e3e3;
}

.add-page legend {
  font-size: 1.4rem;
  color: #1976d2;
  font-weight: bold;
  letter-spacing: 1px;
  padding: 0 1rem;
}

.add-page label {
  display: block;
  margin-top: 1.1rem;
  font-weight: 600;
  color: #1565c0;
  letter-spacing: 0.5px;
}

.add-page input[type="text"],
.add-page input[type="number"],
.add-page select,
.add-page textarea {
  width: 100%;
  padding: 0.6rem;
  margin-top: 0.3rem;
  border: 1.5px solid #90caf9;
  border-radius: 7px;
  font-size: 1rem;
  background: #f9f9f9;
  transition: border 0.2s, background 0.2s;
  box-sizing: border-box;
}

.add-page input[type="file"] {
  margin-top: 0.5rem;
}

.add-page input:focus,
.add-page textarea:focus,
.add-page select:focus {
  background-color: #e3f0ff;
  border-color: #1976d2;
  outline: none;
}

.add-page button[type="submit"] {
  margin-top: 1.5rem;
  padding: 0.7rem 2rem;
  background: linear-gradient(90deg, #1976d2 60%, #90caf9 100%);
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 1.08rem;
  font-weight: 600;
  box-shadow: 0 2px 8px #e3e3e3;
  cursor: pointer;
  transition: background 0.2s, box-shadow 0.2s;
}

.add-page button[type="submit"]:hover {
  background: linear-gradient(90deg, #0056b3 60%, #1976d2 100%);
  box-shadow: 0 4px 16px #b0bec5;
}

.add-page option:first-child {
  color: #b71c1c;
  font-weight: bold;
}

.add-page textarea {
  min-height: 80px;
  resize: vertical;
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
    <main class="add-page">
        <fieldset>
            <legend><B>Add New Product</B></legend>
            <form method="POST" enctype="multipart/form-data">
                <label>Name: </label>
                <input type="text" name="name" required>
                <br>
                <br>
                <label>Category: </label>
                <select name="category" required>
                    <option>select category</option>
                    <option>Formal Shirt</option>
                    <option>Hoodies</option>
                    <option>T-Shirt</option>
                    <option>Polo shirt</option>
                    <option>OverSize Shirt</option>
                </select>
                <br>
                <br>
                <label for="pr">Price: </label>
                <input type="number" id="pr" step="0.1" name="price" required>
                <br>
                <br>
                <label>Quantity:</label>
                <input type="number" name="quantity" required>
                <br>
                <br>
                <label for="ra">Rating: </label>
                <input type="number" id="ia" min="0" max="5" step="0.1" name="rating" required>
                <br>
                <br>
                <label>Description:</label>
                <br>
                <textarea name="description" required></textarea>
                <br>
                <br>
                <label for="im">Image: </label>
                <input type="file" id="im" name="image" accept="image/jpeg" required>
                <br>
                <br>
                <button type="submit">Add Product</button>
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