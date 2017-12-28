<script>
$(document).ready(function(){
    // $("select").change(function(){
    //     $(location).attr('href', 'template.php?x=../IV/'+$(this).val()+'/edit.php');
    // });
   alert("are you sure");
});
</script>
<?php
if(session_status() == PHP_SESSION_NONE)
	{
    //session has not started
     session_start();
    }
//check if user has logged in or not
 if(!isset($_SESSION['username']))
    {
    //send the user to login page
    header("location:../login.php");
    }
 
 $id   = $_SESSION['id'];
 $type = $_SESSION['type'] ;
 unset($_SESSION['id']); 
 unset($_SESSION['type']);

 $conn=mysqli_connect('localhost','root','','preyash');   
 
 $sql="SELECT permission FROM $type where f_id='$id'";
 $records=mysqli_query($conn,$sql);
 $iv=mysqli_fetch_object($records);
 if(!strcmp($iv->permission,"NULL") && !strcmp($iv->permission,"not_applicable"))
 {
 	unlink($iv->permission);	
 }
 
 $sql="SELECT report FROM $type where f_id='$id'";
 $records=mysqli_query($conn,$sql);
 $iv=mysqli_fetch_object($records);
  if(!strcmp($iv->report,"NULL") && !strcmp($iv->report,"not_applicable"))
 {
 	unlink($iv->report);	
 }

 $sql="SELECT certificate FROM $type where f_id='$id'";
 $records=mysqli_query($conn,$sql);
 $iv=mysqli_fetch_object($records);
  if(!strcmp($iv->certificate,"NULL") && !strcmp($iv->certificate,"not_applicable"))
 {
 	unlink($iv->certificate);	
 }
 	
if(strcmp($type,"organized"))
{
 $sql="SELECT attendance FROM $type where f_id='$id'";
 $records=mysqli_query($conn,$sql);
 $iv=mysqli_fetch_object($records);
  if(!strcmp($iv->attendance,"NULL") && !strcmp($iv->attendance,"not_applicable"))
 {
 	unlink($iv->attendance);	
 }
}

 $sql="DELETE FROM $type WHERE f_id='$id'";
 if(mysqli_query($conn,$sql))
  {
  	if($_SESSION['username'] == 'hodextc@somaiya.edu')
				{
	               header("location:../includes/template.php?x=../IV/select_menu/edit_menu_admin.php&alert=delete");

				}
				else
				{
					header("location:../includes/template.php?x=../IV/select_menu/edit_menu.php&alert=delete");

				}
	
  }


?>