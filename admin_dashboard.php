<?php
include 'components/connect.php';

// Delete post if delete button is clicked
if(isset($_POST['delete_post'])){
    $post_id = $_POST['post_id'];
    $delete_post = $conn->prepare("DELETE FROM `posts` WHERE id = ?");
    $delete_post->execute([$post_id]);
    $success_msg[] = 'Post deleted successfully!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Dashboard</title>

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<!-- Header section -->
<?php include 'components/header.php'; ?>

<!-- View all posts section -->
<section class="all-posts">
   <div class="heading"><h1>All Posts</h1></div>
   <div class="box-container">
      <?php
      $select_posts = $conn->prepare("SELECT * FROM `posts`");
      $select_posts->execute();
      if($select_posts->rowCount() > 0){
         while($fetch_post = $select_posts->fetch(PDO::FETCH_ASSOC)){
            $post_id = $fetch_post['id'];
            $count_reviews = $conn->prepare("SELECT * FROM `reviews` WHERE post_id = ?");
            $count_reviews->execute([$post_id]);
            $total_reviews = $count_reviews->rowCount();
      ?>
      <div class="box">
         <img src="uploaded_files/<?= $fetch_post['image']; ?>" alt="" class="image">
         <h3 class="title"><?= $fetch_post['title']; ?></h3>
         <p class="total-reviews"><i class="fas fa-star"></i> <span><?= $total_reviews; ?></span></p>
         <a href="view_post.php?get_id=<?= $post_id; ?>" class="inline-btn">View Post</a>
         <!-- Removed edit button -->
         <form action="" method="post" class="inline-form">
            <input type="hidden" name="post_id" value="<?= $post_id; ?>">
            <button type="submit" name="delete_post" class="inline-btn" onclick="return confirm('Are you sure you want to delete this post?')">Delete Post</button>
         </form>
      </div>
      <?php
         }
      } else {
         echo '<p class="empty">No posts added yet!</p>';
      }
      ?>
   </div>
</section>

<!-- Add new post button -->
<div class="add-post-btn">
   <a href="add.php" class="btn">Add New Post</a>
</div>

<!-- SweetAlert CDN link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Custom JavaScript file link -->
<script src="js/script.js"></script>

<?php include 'components/alers.php'; ?>

</body>
</html>
