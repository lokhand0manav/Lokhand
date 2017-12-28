

<script>
$(document).ready(function(){
    // $("select").change(function(){
    //     $(location).attr('href', 'template.php?x=../IV/'+$(this).val()+'/edit.php');
    // });
    var table = $('#viewAttended').DataTable( {       
        scrollX:  true,
        scrollCollapse: true,
        autoWidth:      true,  
        paging:         true,  
        columnDefs: [
        { "width": "100px", "targets": [5,6,7,8] }
      
    ]     
     
    } );
});
</script>


<?php
  if(session_status() == PHP_SESSION_NONE)
   {
    //session has not started
    session_start();
   }
  if($_SESSION['username']=="")
   {
    header("refresh:2,url=../login.php");
    die("Login Required");
   }
  else
  {
   $username = $_SESSION['username'];
  }

 //if(isset($_POST))
$conn=mysqli_connect('localhost','root','','preyash');
$sql="SELECT * FROM attended where f_name='$username'";
$records=mysqli_query($conn,$sql);

if(isset($_POST['upload']))
{
  $_SESSION['type']   = $_POST['type']; 
  $_SESSION['id']   = $_POST['id']; 
  $_SESSION['file']   = $_POST['file']; 
  //header("location:template.php?x=../IV/attended/form.php");
  header("location:template.php?x=../IV/upload.php");
}

if (isset($_POST['edit']))
{
  
  $_SESSION['id'] = $_POST['id'];
  header("location:template.php?x=../IV/attended/form.php"); 
}

if (isset($_POST['delete']))
{
  $_SESSION['type']   = $_POST['type']; 
  $_SESSION['id'] = $_POST['id'];
  header("location:../IV/delete.php"); 
}
?>
<style>
  th{
    padding:0px;
    border: 1px solid black;
    background-color: #4CAF50;
      color: white;
    }

</style>
 
  </head>
  
        <!-- Main content -->
              <div class="box">
           
                <div class="box-body">
                        <br>
                  <div class="scroll">
                  <table id="viewAttended" class="table table-striped table-bordered ">
                    <thead>
                    <tr>
                      <th>Faculty Id</th>
                      <th>Faculty name</th>
                      <th>Industry Name</th>
                      <th>City</th>
                      <th>Purpose</th>
                      <th>Date</th>
                      <th>Permission</th>
                      <th>Report</th>
                      <th>Certificate</th>
                      <th>Edit</th>
                      <th>delete</th>  
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        //the values for id of user will be also sent from her (upload)
                        if(mysqli_num_rows($records)>0)
                        {
                          while($employee=mysqli_fetch_assoc($records))
                          {
                            echo"<tr>";
                            echo"<td>".$employee['f_id']."</td>";
                            echo"<td>".$employee['f_name']."</td>";
                            echo"<td>".$employee['ind']."</td>";
                            echo"<td>".$employee['city']."</td>";
                            echo"<td>".$employee['purpose']."</td>";
                            echo"<td>".$employee['date']."</td>";
                          
                            echo"<td><table class='table-bordered' ><tr>";
                            
                            if(($employee['permission']) != "")
                            {
                              if(($employee['permission']) == "NULL")
                                echo "<td>not yet available</td>";
                              else if(($employee['permission']) == "not_applicable") 
                                echo "<td>not applicable</td>";
                              else
                                echo "<td> <a href = '".$employee['permission']."'>View permission</td>";
                            }
                            else
                              echo "<td>no status</td>";

                             echo "<td>
                                    <form action = 'template.php?x=../IV/attended/edit.php' method = 'POST'>
                                      <input type = 'hidden' name = 'file' value = 'permission'>
                                      <input type = 'hidden' name = 'id' value = '".$employee['f_id']."'>
                                      <input type = 'hidden' name = 'type' value = 'attended'>
                                        <button name ='upload' type = 'submit' class = 'btn btn-primary btn-sm'>
                                        <span class='glyphicon glyphicon-upload'></span>
                                        </button>
                                    </form>
                                  </td>";
                            echo"</tr></table></td>";  
                            
                            echo"<td><table class='table-bordered' ><tr>";
                            if(($employee['report']) != "")
                            {
                              if(($employee['report']) == "NULL")
                                echo "<td>not yet available</td>";
                              else if(($employee['report']) == "not_applicable") 
                                echo "<td>not applicable</td>";
                              else
                                echo "<td> <a href = '".$employee['report']."'>View report</td>";
                            }
                            else
                              echo "<td>no status </td>";
                            echo "<td>
                                    <form action = 'template.php?x=../IV/attended/edit.php' method = 'POST'>
                                      <input type = 'hidden' name = 'file' value = 'report'>
                                      <input type = 'hidden' name = 'id' value = '".$employee['f_id']."'>
                                      <input type = 'hidden' name = 'type' value = 'attended'>
                                        <button name ='upload' type = 'submit' class = 'btn btn-primary btn-sm'>
                                        <span class='glyphicon glyphicon-upload'></span>
                                        </button>
                                    </form>
                                  </td>";
                            echo"</tr></table></td>";

                            echo"<td><table class='table-bordered' ><tr>";
                            if(($employee['certificate']) != "")
                            {
                              if(($employee['certificate']) == "NULL")
                                echo "<td>not yet available</td>";
                              else if(($employee['certificate']) == "not_applicable") 
                                echo "<td>not applicable</td>";
                              else
                                echo "<td> <a href = '".$employee['certificate']."'>View certificate</td>";
                            }
                            else
                              echo "<td>no status </td>";
                            echo "<td>
                                    <form action = 'template.php?x=../IV/attended/edit.php' method = 'POST'>
                                      <input type = 'hidden' name = 'file' value = 'certificate'>
                                      <input type = 'hidden' name = 'id' value = '".$employee['f_id']."'>
                                      <input type = 'hidden' name = 'type' value = 'attended'>
                                        <button name ='upload' type = 'submit' class = 'btn btn-primary btn-sm'>
                                        <span class='glyphicon glyphicon-upload'></span>
                                        </button>
                                    </form>
                                  </td>";
                            echo"</tr></table></td>";

                             echo "<td>
                                    <form action = 'template.php?x=../IV/attended/edit.php' method = 'POST'>
                                      <input type = 'hidden' name = 'id' value = '".$employee['f_id']."'> 
                                      <input type = 'hidden' name = 'type' value = 'attended'>
                                      <button name = 'edit' type = 'submit' class = 'btn btn-primary btn-sm'>
                                        <span class='glyphicon glyphicon-edit'></span>
                                      </button>
                                    </form>
                                  </td>";

                             echo "<td>
                                    <form action = 'template.php?x=../IV/attended/edit.php' method = 'POST'>
                                      <input type = 'hidden' name = 'id' value = '".$employee['f_id']."'> 
                                      <input type = 'hidden' name = 'type' value = 'attended'>
                                      <button name ='delete' type = 'submit' class = 'btn btn-primary btn-sm'>
                                        <span class='glyphicon glyphicon-trash'></span>
                                      </button>
                                    </form>
                                  </td>";
                            echo"</tr>";
                          }
                         }
                         else
                         {
                           echo "<div class='alert alert-warning'>You have no papers</div>";
                         } 
                    ?>
                    </tbody>
                   
                  </table>
               
                </div>
                  <form method='POST' action="template.php?x=../IV/select_menu/addcount.php">
                    
                  <button type=submit name='add' class="btn btn-primary" >Add Activity
                  </button>
                  </form>
    
                </div><!-- /.box-body -->
              </div><!-- /.box -->

  </body>
  </html>