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
$alert = "";
$count ="";
if(isset($_GET['alert']))  
   {
     $alert = $_GET['alert'];
   }

if(isset($_GET['count']))  
    $count = $_GET['count'];

$successMessage="";

    if($alert=="success")
    {

        $successMessage='<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
            </button>
        <strong>Record added successfully</strong>
        </div>';  

    }
    elseif($alert=="update")
    {
        $successMessage='<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
            </button>
        <strong>Record updated successfully</strong>
        </div>';  

    }
    elseif($alert=="delete")
    {
        $successMessage='<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
            </button>
        <strong>Record deleted successfully</strong>
        </div>';  

    }


?>

<?php include_once('../includes/head.php'); ?>
<?php include_once('../includes/header.php'); ?>
<?php 
  
  // if($_SESSION['username'] == 'hodextc@somaiya.edu')
  // {
  //     include_once('../includes/sidebar.php');

  // }
  // else
      include_once('../includes/sidebar.php'); 
?>

<div class="content-wrapper">
 <?php 
      {
        
          echo $successMessage;
          //$successMessage="";  
      }
    ?>
 
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
   
<?php include_once('../includes/footer.php'); ?>