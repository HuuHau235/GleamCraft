<?php

class Shopping_Cart
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getCartDetails()
    {
        try {
            $query = "
                SELECT 
                    p.name, 
                    p.image, 
                    p.description, 
                    oi.quantity,
                    p.price
                FROM 
                    order_items oi
                JOIN 
                    products p 
                ON 
                    oi.product_id = p.product_id
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}

$shoppingCart = new Shopping_Cart($conn);
$cartDetails = $shoppingCart->getCartDetails();
?>

