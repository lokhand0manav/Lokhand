
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
   

//$sql="SELECT ind,city,purpose,date ".$_SESSION['view_query']." ORDER BY DATE ASC";
//create a separate variable for faculty name, if no admin set it to 0 or set accordingly,
if(isset($_POST['attended']))
  {
    if(empty($_POST['min_date']) && empty($_POST['max_date']))
    {
      $result = view("attended",0,0);   
      $sql = viewReturn("attended",0,0); //for query return
    }
    else
    {
      $result = view("attended",0,1);
      $sql = viewReturn("attended",0,1);
    }
  }  
if(isset($_POST['organized']))
  {
    if(empty($_POST['min_date']) && empty($_POST['max_date']))
    {
      $result = view("organized",0,0);
      $sql = viewReturn("organized",0,0);
    }
    else
    {
      $result = view("organized",0,1);
      $sql = viewReturn("organized",0,0);
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
    while($temp=mysqli_fetch_assoc($result))
    {
      if(isset($_POST['attended']))
      {
        $employee = changeAssociationT("attended",$temp);
        echo"<tr>";
        echo"<td>".$employee[2]."</td>";
        echo"<td>".$employee[3]."</td>";
        echo"<td>".$employee[4]."</td>";
        echo"<td>".$employee[5]."</td>";
        echo "</tr>";
      }
      else
      {
        $employee = changeAssociationT("organized",$temp);
        echo"<tr>";
        echo"<td>".$employee[2]."</td>";
        echo"<td>".$employee[3]."</td>";
        echo"<td>".$employee[4]."</td>";
        echo"<td>".$employee[5]."</td>";
        echo "</tr>";
      }
      
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

