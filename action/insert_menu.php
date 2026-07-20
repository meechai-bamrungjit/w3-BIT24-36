<?php

    $menu_id = $_POST["menu_id"];
    $menu_name = $_POST["menu_name"];
    $menu_price = $_POST["menu_price"];
    $menu_image = $_POST["menu_image"];
    $type_id = $_POST["type_id"];



    include "connect.php";
    // SELECT * FROM menu_types ดึง ทั้งหมดจากตะราง menu_types
    $sql = "INSERT INTO `menus`
     (`menu_id`,`menu_name`,`menu_price`,`menu_image`, `type_id`)

     VALUES 
     ('$menu_id','$menu_name','$menu_price','$menu_image','$type_id')";

    $result = mysqli_query($con, $sql);
    
    if(!$result){
        echo"Error go back to fix NiggaDum";
    }else{
        header("location: ../index.php");
        exit;
    }
?>