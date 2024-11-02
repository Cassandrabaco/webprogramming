<?php

require_once 'product.class.php';

class ProductImage extends Product{
    public $file_path = '';
    public $image_role = '';

    function addImage() {
        $maxFileSize = 5 * 1024 * 1024;

        if (isset($_FILES['uploaded_file'])) 
        { $fileSize = $_FILES['uploaded_file']['size'];

         if ($fileSize > $maxFileSize) { 
             echo "Error: File size exceeds the maximum limit of 5MB."; 
             return false;
         } else {
             $this->file_path = "uploads/" . $_FILES['uploaded_file']['name']; 
             move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $this->file_path);
             
             $sql = "INSERT INTO product_image (product_id, file_path, image_role) VALUES (:product_id, :file_path, :image_role);";
             $query = $this->db->connect()->prepare($sql);
             
             $last_inserted_product = $this->db->connect()->lastInsertId();
             
             $query->bindParam(':product_id', $last_inserted_product); 
             $query->bindParam(':file_path', $this->file_path); 
             $query->bindParam(':image_role', $this->image_role);

             return $query->execute(); 
         } 
        } else { 
            echo "No file was uploaded."; 
            return false; 
        } 
    } 
}
