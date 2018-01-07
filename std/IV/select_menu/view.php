
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
   
include_once("../includes/connection.php");
$sql="SELECT f_name,ind,city,purpose,date ".$_SESSION['view_query']." ORDER BY DATE ASC";
$result=mysqli_query($conn,$sql);  

?>

<div class="scroll">
                  <table border="1" class="table table-striped table-bordered ">
                    <thead>
                    <tr>
                      <th>Faculty Name</th>
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
                            echo"<td>".$employee['f_name']."</td>";
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

