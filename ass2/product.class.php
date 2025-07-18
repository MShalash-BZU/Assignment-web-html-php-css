<?php
class Product
{
    private $id, $name, $category, $description, $price, $rating, $image, $quantity;
    public function __construct($id, $name, $category, $description, $price, $rating, $image, $quantity)
    {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->description = $description;
        $this->price = $price;
        $this->rating = $rating;
        $this->image = $image;
        $this->quantity = $quantity;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getCategory()
    {
        return $this->category;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getRating()
    {
        return $this->rating;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function setImage($image)
    {
        $this->image = $image;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function displayInTable()
    {
        echo '<tr style="height: 160px;">';
        echo "<td style='width: 160px;'><img src='Images/{$this->image}' width='160'></td>";
        echo "<td style='width: 30px;'><a href='view.php?id={$this->id}'>{$this->id}</a></td>";
        echo "<td>{$this->name}</td>";
        echo "<td style='width: 80px;'>{$this->category}</td>";
        echo "<td style='width: 60px;'>{$this->price}</td>";
        echo "<td style='width: 50px;'>{$this->quantity}</td>";
        echo "<td>
                <a href='edit.php?id={$this->id}'><button><img src='Images/edit.png' alt='Edit Product'></button></a>
                <a href='delete.php?id={$this->id}'><button><img src='Images/del.png' alt='Delete Product'></button></a> 
              </td>";
        echo "</tr>";
    }
    public function displayProductPage()
    {
        echo "<main>";
        echo "<fieldset>
            <legend><h1>{$this->name}</h1></legend>
        ";
        echo "<figure ><img src='Images/{$this->image}' class='product-details__image' width='200'><figcaption class='product-details__info description'>{$this->description}</figcaption></figure>";
        echo "<p class='product-details__info category'><strong>Category:</strong> {$this->category}</p>";
        echo "<p class='product-details__info rating'><strong>Price:</strong> \${$this->price}</p>";
        echo "<p class='product-details__info quantity'><strong>Rating:</strong> {$this->rating}/5</p>";
        echo "</fieldset></main>";
    }
}
