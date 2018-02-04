
<?php 
ob_start();
 if(session_status() == PHP_SESSION_NONE)
   {
    session_start();
   }
 if(!isset($_SESSION['username']))
   {
    header("refresh:2,url=index.php");
   }
$isType;  
if(isset($_POST['attended']))
  {
    if(empty($_POST['min_date']) && empty($_POST['max_date']))
    {
      $result = view($attended,$f_id,0);   
      $sql = viewReturn($attended,$f_id,0); //for query return
      $isType = "Attended";
    }
    else
    {
      $result = view($attended,$f_id,1);
      $sql = viewReturn($attended,$f_id,1);
      $isType = "Attended";
    }
  } 

if(isset($_POST['organized']))
  {
    if(empty($_POST['min_date']) && empty($_POST['max_date']))
    {
      $result = view($organized,$f_id,0);
      $sql = viewReturn($organized,$f_id,0);
      $isType = "Organized";
    }
    else
    {
      $result = view($organized,$f_id,1); // 1 is for date
      $sql = viewReturn($organized,$f_id,1);
      $isType = "Organized";
    }
  }

  if(empty($_POST['min_date']) && empty($_POST['max_date']))
    $date_display=" - NULL ";
  else
    $date_display=date("d-m-Y",strtotime($_POST['min_date']))." To ".date("d-m-Y",strtotime($_POST['max_date']));
?>

<h4> Date: <b><i><?php echo $date_display;   ?></i></b></h4>  
<div class="scroll">
  <?php
  if(mysqli_num_rows($result)>0)
                      {
  ?>
                  <table border="1" class="table table-striped table-bordered ">
                    <thead>
                    <tr>
                      <?php 
                      if($_SESSION['username']=="hodextc@somaiya.edu")
                        { ?>
                      <th>Faculty Name</th>
                      <?php 
                        }
                      ?>
                      <th>Industry Name</th>
                      <th>City</th>
                      <th>Purpose</th>
                      <th>From</th>
                      <th>To</th>
                     </tr> 

<?php 

                          while($employee=mysqli_fetch_assoc($result))
                          {

                            echo"<tr>";
                            
                            if($_SESSION['username']=="hodextc@somaiya.edu")
                            {
                            $f_name = mysqli_fetch_assoc(getFacultyDetails($employee['f_id']))['F_NAME'];
                            echo "<td>".$f_name."</td>";
                            }
                            echo"<td>".$employee['ind']."</td>";
                            echo"<td>".$employee['city']."</td>";
                            echo"<td>".$employee['purpose']."</td>";
                            echo"<td>".date("d-m-Y",strtotime($employee['t_from']))."</td>";
                            echo"<td>".date("d-m-Y",strtotime($employee['t_to']))."</td>";
                            echo "</tr>";
                           }  
                         }
                         else
                            echo "<div class='alert alert-warning'>There no IV Activities</div>";
                          
 ?>
  </thead>
 </table>
</div>


                  <div>
                    <?php
                      if(mysqli_num_rows($result)>0)
                      { 
                        $_SESSION['table_query'] = $sql;
                        echo "<a href= 'IV/export_to_excel.php?flag=1&type=$isType&count=$total&date=$date_display' type='button' class='btn btn-success btn-sm' ><span class='glyphicon'>Export</span></a>";
                        echo " ";
                        echo "<a href='IV/printToPDF.php?flag=1&type=$isType&count=$total&date=$date_display' type='button' class='btn btn-success btn-sm' target='_blank'><span class='glyphicon'>Print</span></a>";
                      }
                    ?>
                  </div>


    

