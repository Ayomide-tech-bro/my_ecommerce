<?php $msg='';
require_once('user\includes\conn.php'); 
require_once('user\header.php');
require_once('user\includes\functions.php');



require_once('nav.php');

$user_id = $_SESSION['user_id'];
$server_host = $_SERVER['HTTP_HOST'];
$folder = 'uploads/user_dp/';
$dummy_img_url = 'assets\img\dummy_user.png';







if (isset($_POST['btn_update_dp'])) {
    $active_user_id = $_SESSION['user_id'];

    if (isset($_FILES['user_dp'])) { 
        $file_name = $_FILES['user_dp']['name'];
        $file_size = $_FILES['user_dp']['size'];
        $file_type = $_FILES['user_dp']['type'];
        $file_tmp_name = $_FILES['user_dp']['tmp_name'];
        $new_file_name = $active_user_id.'_'. time().'_'. $file_name;

        $old_file_name = sanitize_var($my_conn, $_POST['old_dp']);
        // die($old_file_name);

        // echo '<pre>';
        //   print_r($_FILES);
        // echo '<pre>';


        $supported_types = [
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/webp'
        ];
        if (in_array($file_type, $supported_types)) { 
            if ($file_size<=2000000) {
                $upload = move_uploaded_file($file_tmp_name, 'uploads/user_dp/'.$new_file_name);
                if ($upload) { 
                    $sql = "UPDATE user SET display_pic=? WHERE id=?";
                    $stmt = mysqli_prepare($my_conn, $sql);
                    mysqli_stmt_bind_param($stmt, "ss", $new_file_name, $active_user_id);
                    mysqli_stmt_execute($stmt);
                    $n_row2 = mysqli_stmt_affected_rows($stmt);
                    if ($n_row2 > 0) { 
                        if (is_writable('uploads/user_dp'.$old_file_name)&&($old_file_name!='')) {
                            unlink('uploads/user_dp/'.$old_file_name);
                        }
                        // overwrite the user_dp saved in session
                        $_SESSION['display_pic'] = $new_file_name;
                        $msg = 'Upload was successful';
                    } else {
                        $msg .= 'Something went wrong, please try again';
                    }
                } else {
                    $msg .= 'Something went wrong please try again';
                }
        }   else {
            $msg .= 'Filesize too large, must be lower than 2MB';
        }
    } else {
        $msg .= 'Unsupported file format/type';
    }



    }

}






if ($url_user_id==0) {
    $active_user_id = $_SESSION['user_id'];

    $user_fn = $_SESSION['first_name'];
    $user_ln = $_SESSION['last_name'];
    $user_em = $_SESSION['email'];
    $user_gd = $_SESSION['gender'];

    // fetch the current display_picture
    $query = "SELECT display_pic FROM user WHERE id='$active_user_id'";
    $result = mysqli_query($my_conn, $query);
    $row    = mysqli_fetch_assoc($result);
    $current_dp = $row['display_pic'];

    if (strlen($current_dp)>0) {
        $user_img_url = $folder.$current_dp;
    } else { $user_img_url = $dummy_img_url ; }





} else {
    // fetch user info from database

    $query = "SELECT * FROM user WHERE id='$url_user_id'";
    $result = mysqli_query($my_conn, $query);
    $row    = mysqli_fetch_assoc($result);
    $current_dp = $row['display_pic'];

    $user_fn = $row['first_name'];
    $user_ln = $row['last_name'];
    $user_em = $row['email'];
    $user_gd = $row['gender'];

    if (strlen($current_dp)>0) {
        $user_img_url = $folder.$current_dp;
    } else { $user_img_url = $dummy_img_url ; }


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Template - Bootstrap v5.3</title>

    <link rel="stylesheet" href="../dist/css/bootstrap.min.css">
    <style>

        .cust{ text-align: left;
            font-size: 14px; background-color: #74aaff; padding: 7px;
            color: #000; width: 85%; float: left; border-radius: 5px;
            }

            .tmcus{ font-size: .8em; float: right!important; }
            .tmcomp { font-size: .8em; float: right!important; }

            .comp { text-align: left;
            font-size: 14px; background-color: #bedaff;
            color: #000; padding: 7px; width: 85%;
            float: right; border-radius: 5px;
            }

    </style>

    <style>
        .img_user{ border-radius: 50%; width: 30px;}
    </style>

</head>
<body class="bg-dark">

<div class="container-fluid">
    <div class="row text-primary">
        <main class="col-md-8 mx-auto text-primary">
       


        <div class="pt-3 pb-2 mb-3">

<div class="row">
<?php
if ($msg != '') {
    echo '<div class="alert alert-primary alert-dismissible">'.$msg.'</div>';
}
?>


        <div class="col-md-4">
            <div class="border mb-2 border-light p-1">
                <div class="card  text-light">
                    <div class="card-header">
                        User Profile
                    </div>
                    <div class="card-body text-center p-2" style="height: 200px;">
                    <img src="<?=$user_img_url?>" class="w-100 h-100 rounded" alt="">
                    </div>
                    <div class="card-footer">
                        <p class="text-center lead mb-0"><?php echo"$user_fn $user_ln"; ?></p>
                    </div>
                </div>

            </div>
            <!-- e -->
            <div class="border border-light p-1">
                <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-secondary w-100">Update Picture</button>
            </div>
            <?php  ?>
        </div>
        <div class="col md-8">
            <div class="border border-light p-1 mb-2">
                <table class="table table-dark mb-0">
                <tr>
                    <td><label for="" class="_1bl">Fullname</label></td>
                    <td><label for="" class="1bl_"><?php echo "$user_fn $user_ln"; ?></label></td>
                </tr>
                <tr>
                    <td><label for="" class="_1bl">Email</label></td>
                    <td><label for="" class="1bl_"><?php echo "$user_em"; ?></label></td>
                </tr>
                <tr>
                    <td><label for="" class="_1bl">Gender</label></td>
                    <td><label for="" class="1bl_"><?php echo "$user_gd"; ?></label></td>
                </tr>
            </table>
    </div>

    <!-- <?php if ((int)$url_user_id==0) { ?> -->
    <div class="border border-light p-1 mb-2">
        <table class="table table-dark mb-0">
            <tr>
                <td><label for="" class="_1bl">Fullname</label></td>
                <td>
                    <input type="text" value="<?php echo "$user_fn $user_ln"; ?>" class="form-control">
                </td>
            </tr>
            <tr>
                <td><label for="" class="_1bl">Email</label></td>
                <td>
                    <input type="text" value="<?php echo "$user_em"; ?>" class="form-control">
                </td>
            </tr>
            <tr>
                <td><label for="" class="_1bl">Gender</label></td>
                <td>
                    <select name="" id="" required class="form-select">
                        <option value=""></option>
                        <option value="male">MALE</option>
                        <option value="female">FEMALE</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><button id="" type="reset" class="btn btn-secondary">Clear</button></td>
                <td><button id="" type="submit"  class="btn btn-primary">Submit</button></td>
            </tr>
        </table>
    </div>
<?php } ?>
</div>
</div>


        </div>
    </main>
</div>
</div>



<!-- Modal     -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-light" id="exampleModalLabel">Select New Picture</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <input name="user_dp" type="file" class="form-control bg-dark border border-light text-light">
                        <input type="hidden" value="<?=$current_dp?>"  name="old_dp">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="btn_update_dp" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>



    <script src="dist\js\bootstrap.bundle.min.js"></script>
    <script src="dist\js\jQuery.js"></script>

    </body>
</html>