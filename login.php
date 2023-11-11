
<?php 
session_start();
$msg = null;
// the button subbmits successfilly to the server
if (isset($_POST['login'])) {

$my_conn = mysqli_connect('localhost','root','','yo_com'); 

$email = mysqli_real_escape_string($my_conn, $_POST['email_addr']);
$password = mysqli_real_escape_string($my_conn,$_POST['pass']);
$query = "SELECT * FROM user WHERE email='$email'";
$result = mysqli_query($my_conn , $query);
$row = mysqli_fetch_assoc($result);

    if ( !is_array($row) ){
        $msg = "User does not exist";
    } else if ($row["email"] == $email) {
        if ($row["password"] == $password) {
             $_SESSION['user_id'] = $row['id'];
             $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['gender'] = $row['gender'];
            $_SESSION['usr_type'] = $row['usr_type'];

            header("location: home.php");



        }else {
            $msg = "incorrect password or email";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dist/css/bootstrap.min.css">
    <title>chat_app</title>
</head>
<body>
    <style>
        body {
      font-family: Arial, sans-serif;
      background-color: indigo;
      margin-top: 100px; 
    }
    </style>

  
<div class="col-5 mx-auto bg-light mt-5 p-1 rounded">
<form action="" method="POST" class="mb-0">

    
    <table class="table mb-0">

    <h5 class="text-center p-3 bg-info rounded text-white">Zella</h5>  

<?php
if (!$msg == '') { echo "<div class = 'alert alert-warning'>" . $msg . "</div>"; }
?>
    <!-- <p class="mb-1 text-center">Fill in the fields below to login</p> -->
    <p class="mb-1 text-center"><a href="register.php">Sign up</a> if you dont have an account
</p>

        <tr>
        <td><label for="" class="form-label">Email</label></td>
        <td><input type="email" name="email_addr" class="form-control" required></td>
        </tr>

        <tr>
        <td><label for="" class="form-label">Password</label></td>
        <td><input type="password" name="pass" class="form-control" required></td>
        </tr>

        <tr>

        <td><button class="btn btn-dark w-100" type="clear">Clear</button></td>

        <td><button class="btn btn-success w-100" type="submit" name="login">Submit</button></td>

        </tr>

        </table>


</form>
</div>

</body>
</html>