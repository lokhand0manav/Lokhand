      <?php
      $conn=mysqli_connect('localhost','root','','preyash');
      if(isset($_POST['update']))
      {


        if($_FILES["permission"]["name"]!="")
        {
          $sql="SELECT permission FROM attended where f_id='$_POST[id]'";
          $records=mysqli_query($conn,$sql);
          $iv=mysqli_fetch_object($records);
          unlink($iv->permission);

          $sql="SELECT report FROM attended where f_id='$_POST[id]'";
          $records=mysqli_query($conn,$sql);
          $report=mysqli_fetch_object($records)->report;
          
          $sql="SELECT certificate FROM attended where f_id='$_POST[id]'";
          $records=mysqli_query($conn,$sql);
          $certificate=mysqli_fetch_object($records)->certificate;
          
          $target_dir_permission = "../../uploads/attended/permission/";
          $target_file_permission = $target_dir_permission . basename($_FILES["permission"]["name"]); 

          $uploadOk_permission = 1;
          $imageFileType = pathinfo($target_file_permission,PATHINFO_EXTENSION);
      // Check if image file is a actual image or fake image

          $check = getimagesize($_FILES["permission"]["tmp_name"]);
          if($check !== false) 
            {
              $uploadOk_permission = 1;
            } 
          else 
            {
              $uploadOk_permission = 0;
            }

          if ($uploadOk_permission == 0) 
            {
              echo "Sorry, your file was not uploaded.";
     
            } 
          else 
            {
             // if everything is ok, try to upload file
            if (move_uploaded_file($_FILES["permission"]["tmp_name"], $target_file_permission)) 
            else 
              {
               echo "Sorry, there was an error uploading your file.";
              }
            }



          $sql="UPDATE attended SET f_name='$_POST[fname]',ind='$_POST[ind]',city='$_POST[city]',purpose='$_POST[purp]',date='$_POST[date]',permission='$target_file_permission',report='$report', certificate='$certificate' WHERE f_id='$_POST[id]'";
          if(mysqli_query($conn,$sql))
            header("refresh:1; url=../../includes/template.php?x=../IV/attended/view.php");
        }


        if($_FILES["report"]["name"]!="")
        {
          $sql="SELECT report FROM attended where f_id='$_POST[id]'";
          $records=mysqli_query($conn,$sql);
          $iv=mysqli_fetch_object($records);
          unlink($iv->report);
        
          $sql="SELECT permission FROM attended where f_id='$_POST[id]'";
          $records=mysqli_query($conn,$sql);
          $permission=mysqli_fetch_object($records)->permission;
        
          $sql="SELECT certificate FROM attended where f_id='$_POST[id]'";
          $records=mysqli_query($conn,$sql);
          $certificate=mysqli_fetch_object($records)->certificate;

          $target_dir_report = "../../uploads/attended/report/";
          $target_file_report = $target_dir_report . basename($_FILES["report"]["name"]); 
          $uploadOk_report = 1;
          $imageFileType = pathinfo($target_file_report,PATHINFO_EXTENSION);
      
      // Check if image file is a actual image or fake image
          if(isset($_POST["submit"])) 
          {
            $check = getimagesize($_FILES["report"]["tmp_name"]);
            if($check !== false) 
            {
              $uploadOk_report = 1;
            } 
            else 
            {
              $uploadOk_report = 0;
            }
          }

          if ($uploadOk_report == 0) 
          {
            echo "Sorry, your file was not uploaded.";
          } 
          else 
          {
           // if everything is ok, try to upload file
            if (move_uploaded_file($_FILES["report"]["tmp_name"], $target_file_report))

            else 
            {
              echo "Sorry, there was an error uploading your file.";
            }
          }



          $sql="UPDATE attended SET f_name='$_POST[fname]',ind='$_POST[ind]',city='$_POST[city]',purpose='$_POST[purp]',date='$_POST[date]',permission='$permission',report='$target_file_report', certificate='$certificate' WHERE f_id='$_POST[id]'";
          if(mysqli_query($conn,$sql))
            header("refresh:1; url=../../includes/template.php?x=../IV/attended/view.php");
        }


    if($_FILES["certificate"]["name"]!="")
    {
      $sql="SELECT certificate FROM attended where f_id='$_POST[id]'";
      $records=mysqli_query($conn,$sql);
      $iv=mysqli_fetch_object($records);
      unlink($iv->certificate);

      $sql="SELECT permission FROM attended where f_id='$_POST[id]'";
      $records=mysqli_query($conn,$sql);
      $permission=mysqli_fetch_object($records)->permission;
      
      $sql="SELECT report FROM attended where f_id='$_POST[id]'";
      $records=mysqli_query($conn,$sql);
      $report=mysqli_fetch_object($records)->report;

      $target_dir_certificate = "../../uploads/attended/certificate/";
      $target_file_certificate = $target_dir_certificate . basename($_FILES["certificate"]["name"]); 
      $uploadOk_certificate = 1;
      $imageFileType = pathinfo($target_file_certificate,PATHINFO_EXTENSION);
      // Check if image file is a actual image or fake image
      if(isset($_POST["submit"])) 
      {
        $check = getimagesize($_FILES["certificate"]["tmp_name"]);
        if($check !== false) {
          $uploadOk_certificate = 1;
        } 
        else {
          $uploadOk_certificate = 0;
        }
      }

      if ($uploadOk_certificate == 0) 
      {
       echo "Sorry, your file was not uploaded.";
      
     } 
     else 
     {
        // if everything is ok, try to upload file
       if (move_uploaded_file($_FILES["certificate"]["tmp_name"], $target_file_certificate)) {

       } 
       else 
       {
        echo "Sorry, there was an error uploading your file.";
      }
    }


    $sql="UPDATE attended SET f_name='$_POST[fname]',ind='$_POST[ind]',city='$_POST[city]',purpose='$_POST[purp]',date='$_POST[date]',permission='$permission',report='$report', certificate='$target_file_certificate' WHERE f_id='$_POST[id]'";
    if(mysqli_query($conn,$sql))
      header("refresh:1; url=../../includes/template.php?x=../IV/attended/view.php");
  }
  else
  {
   $sql="SELECT permission FROM attended where f_id='$_POST[id]'";
   $records=mysqli_query($conn,$sql);
   $permission=mysqli_fetch_object($records)->permission;
   
   $sql="SELECT report FROM attended where f_id='$_POST[id]'";
   $records=mysqli_query($conn,$sql);
   $report=mysqli_fetch_object($records)->report;
   
   $sql="SELECT certificate FROM attended where f_id='$_POST[id]'";
   $records=mysqli_query($conn,$sql);
   $certificate=mysqli_fetch_object($records)->certificate;

   $sql="UPDATE attended SET f_name='$_POST[fname]',ind='$_POST[ind]',city='$_POST[city]',purpose='$_POST[purp]',date='$_POST[date]',permission='$permission',report='$report', certificate='$certificate' WHERE f_id='$_POST[id]'";
   if(mysqli_query($conn,$sql))
    header("refresh:1; url=../../includes/template.php?x=../IV/attended/view.php");
}

}
else if(isset($_POST['delete']))
{
 $sql="SELECT permission FROM attended where f_id='$_POST[id]'";
 $records=mysqli_query($conn,$sql);
 $iv=mysqli_fetch_object($records);
 unlink($iv->permission);

 $sql="SELECT report FROM attended where f_id='$_POST[id]'";
 $records=mysqli_query($conn,$sql);
 $iv=mysqli_fetch_object($records);
 unlink($iv->report);

 $sql="SELECT certificate FROM attended where f_id='$_POST[id]'";
 $records=mysqli_query($conn,$sql);
 $iv=mysqli_fetch_object($records);
 unlink($iv->certificate);


 $sql="DELETE FROM attended WHERE f_id='$_POST[id]'";
 if(mysqli_query($conn,$sql))
  header("refresh:1; url=../../includes/template.php?x=../IV/attended/view.php");
}
?>