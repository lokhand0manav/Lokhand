<script>
$(document).ready(function(){
  $(".2").attr("class","active");
});
</script>

<?php
  if(session_status() == PHP_SESSION_NONE){
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

$conn=mysqli_connect('localhost','root','','preyash');
$sql="SELECT * FROM attended where f_name='$username";
$records=mysqli_query($conn,$sql);
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
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Attended</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div style="overflow-x:auto;">
                  <table id="example1" class="table table-bordered ">
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
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        while($employee=mysqli_fetch_assoc($records))
                        {
                          echo"<tr><form action=../attended/update.php method=POST enctype=multipart/form-data>";
                          echo"<td><input type=hidden name=id value='".$employee['f_id']."'>".$employee['f_id']."</td>";
                          echo"<td><input type=hidden name=fname value='".$employee['f_name']."'>".$employee['f_name']."</td>";
                          echo"<td><input type=text name=ind value='".$employee['ind']."'></td>";
                          echo"<td><input type=text name=city value='".$employee['city']."'></td>";
                          echo"<td><input type=text name=purp value='".$employee['purpose']."'></td>";
                          echo"<td><input type=text name=date value='".$employee['date']."'></td>";
    
                          echo"<td><input type=file name=permission id='permission' value=''></td>";
                          echo"<td><input type=file name=report id='report' value=''></td>";
                          echo"<td><input type=file name=certificate id='certificate' value=''></td>";
                          echo"<td><input type=submit name=update value=Update class='btn btn-primary'>";
                          echo"<br><br><input type=submit name=delete value=Delete class='btn btn-primary'></td>";
                          echo"</form></tr>";
                        }
                    ?>
                    </tbody>
                   
                  </table>
                  </div>
                  <form action="template.php?x=../attended/form.php"> 
<input type=submit name="add" value="Add Activity To Attended Section" class="btn btn-primary">
</form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
    <script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>
  </body>
  </html>