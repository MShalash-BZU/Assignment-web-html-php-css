CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100),
    category VARCHAR(50),
    description TEXT,
    price DECIMAL(10,2),
    quantity INT,
    rating DECIMAL(3,1),
    image_name VARCHAR(100)
);