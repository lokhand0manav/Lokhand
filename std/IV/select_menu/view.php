
<?php 
ob_start();
 if(session_status() == PHP_SESSION_NONE)
   {
    session_start();
   }
 if(!isset($_SESSION['username']))
   {
    header("refresh:2,url=../login.php");
   }
   
if(isset($_POST['attended']))
  {
    if(empty($_POST['min_date']) && empty($_POST['max_date']))
    {
      $result = view("attended",$_SESSION['f_id'],0);   
      $sql = viewReturn("attended",$_SESSION['f_id'],0); //for query return
    }
    else
    {
      $result = view("attended",$_SESSION['f_id'],1);
      $sql = viewReturn("attended",$_SESSION['f_id'],1);
    }
  }  
if(isset($_POST['organized']))
  {
    if(empty($_POST['min_date']) && empty($_POST['max_date']))
    {
      $result = view("organized",$_SESSION['f_id'],0);
      $sql = viewReturn("organized",$_SESSION['f_id'],0);
    }
    else
    {
      $result = view("organized",$_SESSION['f_id'],1); // 1 is for date
      $sql = viewReturn("organized",$_SESSION['f_id'],0);
    }
  }


?>

<div class="scroll">
                  <table border="1" class="table table-striped table-bordered ">
                    <thead>
                    <tr>
                      <th>Industry Name</th>
                      <th>City</th>
                      <th>Purpose</th>
                      <th>Date</th>
                     </tr> 

<?php 
if(mysqli_num_rows($result)>0)
                  {
                          while($employee=mysqli_fetch_assoc($result))
                          {
                            echo"<tr>";
                            echo"<td>".$employee['ind']."</td>";
                            echo"<td>".$employee['city']."</td>";
                            echo"<td>".$employee['purpose']."</td>";
                            echo"<td>".$employee['date']."</td>";
                            echo "</tr>";
                           }  
                         }                          
 ?>
  </thead>
 </table>
</div>
        <div>
                    <?php 
                     $_SESSION['table_query'] = $sql;
                     ?>
                    <a href="export_to_excel.php" type="button" class="btn btn-success btn-sm"><span class="glyphicon ">Export</span></a>
                  </div>

