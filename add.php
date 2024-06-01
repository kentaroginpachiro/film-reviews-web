<?php
include 'components/connect.php';

if(isset($_POST['submit'])){
    $id = create_unique_id();
    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);

    // Uploading image
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = create_unique_id().'.'.$ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_files/'.$rename;

    if(!empty($image)){
        if($image_size > 2000000){
            $warning_msg[] = 'Image size is too large!';
        }else{
            move_uploaded_file($image_tmp_name, $image_folder);
        }
    }else{
        $rename = '';
    }

    // Inserting data into the posts table
    $insert_post = $conn->prepare("INSERT INTO `posts`(id, title, image) VALUES(?,?,?)");
    $insert_post->execute([$id, $title, $rename]);
    $success_msg[] = 'Post added successfully!';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post</title>
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <!-- Header section -->
    <?php include 'components/header.php'; ?>

    <!-- Add post section -->
    <section class="account-form">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Add New Post</h3>
            <p class="placeholder">Title <span>*</span></p>
            <input type="text" name="title" required maxlength="100" placeholder="Enter post title" class="box">
            <p class="placeholder">Image <span>*</span></p>
            <input type="file" name="image" class="box" accept="image/*">
            <input type="submit" value="Add Post" name="submit" class="btn">
        </form>
    </section>

    <!-- SweetAlert CDN link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Custom JavaScript file link -->
    <script src="js/script.js"></script>

    <?php include 'components/alers.php'; ?>

</body>
</html>
