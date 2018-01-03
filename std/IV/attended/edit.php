

<script>
$(document).ready(function(){
    // $("select").change(function(){
    //     $(location).attr('href', 'template.php?x=../IV/'+$(this).val()+'/edit.php');
    // });
    var table = $('#viewAttended').DataTable( {       
        scrollX:  true,
        scrollY: 300,
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

//$sql="SELECT * FROM attended where f_name='$username'";

$records = edit("attended",0); 

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
                        //the values for id of user will be also sent from here (upload)
                        if(mysqli_num_rows($records)>0)
                        {
                          while($temp=mysqli_fetch_assoc($records))
                          {
                            $employee=changeAssociation("attended",$temp);
                            echo"<tr>";
                            echo"<td>".$employee[0]."</td>";
                            echo"<td>".$employee[1]."</td>";
                            echo"<td>".$employee[2]."</td>";
                            echo"<td>".$employee[3]."</td>";
                            echo"<td>".$employee[4]."</td>";
                            echo"<td>".$employee[5]."</td>";
                          
                            echo"<td><table class='table-bordered' ><tr>";
                            
                            if(($employee[6]) != "")
                            {
                              if(($employee[6]) == "NULL")
                                echo "<td>not yet available</td>";
                              else if(($employee[6]) == "not_applicable") 
                                echo "<td>not applicable</td>";
                              else
                                echo "<td> <a href = '".$employee[6]."'>View permission</td>";
                            }
                            else
                              echo "<td>no status</td>";

                             echo "<td>
                                    <form action = 'template.php?x=../IV/attended/edit.php' method = 'POST'>
                                      <input type = 'hidden' name = 'file' value = 'permission'>
                                      <input type = 'hidden' name = 'id' value = '".$employee[0]."'>
                                      <input type = 'hidden' name = 'type' value = 'attended'>
                                        <button name ='upload' type = 'submit' class = 'btn btn-primary btn-sm'>
                                        <span class='glyphicon glyphicon-upload'></span>
                                        </button>
                                    </form>
                                  </td>";
                            echo"</tr></table></td>";  
                            
                            echo"<td><table class='table-bordered' ><tr>";
                            if(($employee[7]) != "")
                            {
                              if(($employee[7]) == "NULL")
                                echo "<td>not yet available</td>";
                              else if(($employee['report']) == "not_applicable") 
                                echo "<td>not applicable</td>";
                              else
                                echo "<td> <a href = '".$employee[7]."'>View report</td>";
                            }
                            else
                              echo "<td>no status </td>";
                            echo "<td>
                                    <form action = 'template.php?x=../IV/attended/edit.php' method = 'POST'>
                                      <input type = 'hidden' name = 'file' value = 'report'>
                                      <input type = 'hidden' name = 'id' value = '".$employee[0]."'>
                                      <input type = 'hidden' name = 'type' value = 'attended'>
                                        <button name ='upload' type = 'submit' class = 'btn btn-primary btn-sm'>
                                        <span class='glyphicon glyphicon-upload'></span>
                                        </button>
                                    </form>
                                  </td>";
                            echo"</tr></table></td>";

                            echo"<td><table class='table-bordered' ><tr>";
                            if(($employee[8]) != "")
                            {
                              if(($employee[8]) == "NULL")
                                echo "<td>not yet available</td>";
                              else if(($employee[8]) == "not_applicable") 
                                echo "<td>not applicable</td>";
                              else
                                echo "<td> <a href = '".$employee[8]."'>View certificate</td>";
                            }
                            else
                              echo "<td>no status </td>";
                            echo "<td>
                                    <form action = 'template.php?x=../IV/attended/edit.php' method = 'POST'>
                                      <input type = 'hidden' name = 'file' value = 'certificate'>
                                      <input type = 'hidden' name = 'id' value = '".$employee[0]."'>
                                      <input type = 'hidden' name = 'type' value = 'attended'>
                                        <button name ='upload' type = 'submit' class = 'btn btn-primary btn-sm'>
                                        <span class='glyphicon glyphicon-upload'></span>
                                        </button>
                                    </form>
                                  </td>";
                            echo"</tr></table></td>";

                             echo "<td>
                                    <form action = 'template.php?x=../IV/attended/edit.php' method = 'POST'>
                                      <input type = 'hidden' name = 'id' value = '".$employee[0]."'> 
                                      <input type = 'hidden' name = 'type' value = 'attended'>
                                      <button name = 'edit' type = 'submit' class = 'btn btn-primary btn-sm'>
                                        <span class='glyphicon glyphicon-edit'></span>
                                      </button>
                                    </form>
                                  </td>";

                             echo "<td>
                                    <form action = 'template.php?x=../IV/attended/edit.php' method = 'POST'>
                                      <input type = 'hidden' name = 'id' value = '".$employee[0]."'> 
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