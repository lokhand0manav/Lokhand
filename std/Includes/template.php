<?php 
ob_start();
if(session_status() == PHP_SESSION_NONE){
    //session has not started
    session_start();
}
$conn=mysqli_connect('localhost','root','','preyash');
if($_SESSION['username']=="")
{
  header("refresh:2,url=../login.php");
  die("Login Required");
}
else
{
  $username = $_SESSION['username'];
}

?>

<?php include_once('../Includes/head.php'); ?>
<?php include_once('../Includes/header.php'); ?>
<?php 
  
  if($_SESSION['username'] == 'hodextc@somaiya.edu')
  {
      include_once('../Includes/sidebar_admin.php');

  }
  else
      include_once('../Includes/sidebar.php'); 
?>

<div class="content-wrapper">

<!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div id="includes" >                 
                 <?php 
                    if(isset($_GET['x']))
                    {
                      $url = $_GET['x'];  
                      include_once($url);
                    }
                 ?>
              </div>
           </div>      
        </section>               
  </div><!-- /.content-wrapper -->        
   
<?php include_once('../Includes/footer.php'); ?>