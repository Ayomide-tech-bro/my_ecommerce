<!-- <!DOCTYPE html>
<html>
<head>
    <title>E-commerce Homepage</title>
</head>
<body>
    <h1>Welcome to our E-commerce Store</h1>
    <div id="product">
        < Products will be displayed here -->
        </div>
</body>
</html> 







 <?php
require_once('user\includes\conn.php'); 
require_once('user\header.php');
require_once('user\includes\functions.php');

require_once('nav.php');
?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="stylee.css">
   <title>Document</title>
</head>
<body>
   

<style>
	.pro {
		width: 25%;
        min-width: 200px;
        padding: 10px 12px;
        border: 1px solid rgb(150, 135, 135);
        border-radius: 25px;
        cursor: pointer;
        /* box-shadow: 20px 20px 30px rgb(148, 136, 136); */
        /* margin: 15px 0; */
        /* transition: 0.2s ; */
        /* position: relative;  */
        display: absolute ;
        height: 500px;
        
        /* display: flex; */
    justify-content: center; /* To center the image horizontally */
    align-items: center; /* To center the image vertically */
        }




   .pro img {
    border: 4px;
    border-radius: 30px;

    
  -ms-transform: scale(1.1);
  transform: scale(1.1);
}
   


    
</style>
 






 <?php
$connection = mysqli_connect('localhost' , 'root', '' , 'yo_com');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

        <?php
        $showq = "SELECT * FROM products_tb";
        $runq = mysqli_query($connection , $showq);
        $row = mysqli_num_rows($runq);
        if ( $row > 0) {
            while ( $arr = mysqli_fetch_assoc($runq) ) {
				
                echo ' <div class ="pro"> 
              
                <img src="uploads/'.$arr['pimage'].'" />
                
                    <h1> '.$arr['pname'].' </h1>
                    <p> '.$arr['pdesc'].' </p>
                    <p> '.$arr['pprice'].' </p>
                    <a href = "details.php?id='.$arr['id'].'" >View </a>
					</div> <br>';
            }
        } else {
            echo 'No product added';
        }

            require_once('footer.php')
        ?>


</body>
</html>

</body>
