<?php
// require_once('nav.php');
session_start();
$uid = $_SESSION['user_id'];
// echo $uid;
$connection = mysqli_connect('localhost' , 'root', '' , 'yo_com');

if (isset($_GET['id'])) {
    // die($_GET['id']);
    $pid = $_GET['id'];
    // die($pid);
    $show = "SELECT * FROM products_tb WHERE id = $pid"; 
    $ressr = mysqli_query($connection , $show);
    $rr = mysqli_affected_rows($connection);
     $arr = mysqli_fetch_assoc($ressr);
        
}
if ( isset($_POST['add_to_cart']) ) {
    $qq = "INSERT INTO `cart_tb`( `user_id`, `product_id`) VALUES ('$uid','$pid')";  
     $runq = mysqli_query($connection , $qq);
    $rows = mysqli_affected_rows($connection);
    if ( $rows > 0) {
        echo '<script> alert("Product added to cart successfully")</script>';
    } else {
        echo 'Something went wrong';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   <link rel="stylesheet" href="css\style.css">
</head>
<body>


<style>
       .product1 .pro {
        width: 23%;
        min-width: 250px;
        padding: 10px 12px;
        border: 1px solid rgb(150, 135, 135);
        border-radius: 25px;
        cursor: pointer;
        box-shadow: 20px 20px 30px rgb(148, 136, 136);
        margin: 15px 0;
        transition: 0.2s ;
        position: relative; 
    }
    </style>

<?php
require_once('nav.php');
?>


    
    <img src=" uploads/<?php echo $arr['pimage'] ?> " alt="" srcset="">
    
    <h1> <?php echo $arr['pname'] ?> </h1>

    <p> <?php echo $arr['pdesc'] ?> </p>

    <p> <?php echo $arr['pprice'] ?> </p>



<form action="#" method = "POST">
    <button type="submit" class="btn btn-success" name="add_to_cart">Add to cart</button> </form>
</body>
</html>