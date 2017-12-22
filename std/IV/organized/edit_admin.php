<script>
$(document).ready(function(){
  $(".5").attr("class","active");
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
  header("refresh:1,url=../login.php");
  die("Login Required");
  }
   else
  {
    $username = $_SESSION['username'];
  }

$conn=mysqli_connect('localhost','root','','preyash');
$sql="SELECT * FROM organized";
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
                  <h3 class="box-title">Organized</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div style="overflow-x:auto;">
                  <table id="example1" class="table table-bordered ">
                    <thead>
                    <tr>
                     <tr>
    <th>Faculty Id</th>
    <th>Faculty name</th>
    <th>Industry Name</th>
    <th>City</th>
    <th>Purpose</th>
    <th>Date</th>
    <th>Target Audience</th>
    <th>Staff</th>
    <th>from</th>
    <th>To</th>
        <th>Permission</th>
        <th>Report</th>
        <th>Certificate</th>
        <th>Attendance</th>
        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                     <?php
while($employee=mysqli_fetch_assoc($records))
{
  echo"<tr><form action=../organized/update_admin.php method=POST enctype=multipart/form-data>";
  echo"<td><input type=hidden name=id value='".$employee['f_id']."'>".$employee['f_id']."</td>";
  echo"<td><input type=text name=fname value='".$employee['f_name']."'></td>";
  echo"<td><input type=text name=ind value='".$employee['ind']."'></td>";
  echo"<td><input type=text name=city value='".$employee['city']."'></td>";
  echo"<td><input type=text name=purp value='".$employee['purpose']."'></td>";
  echo"<td><input type=text name=date value='".$employee['date']."'></td>";
  // echo"<td><input type=text name=from value='".$employee['frm']."'></td>";
  // echo"<td><input type=text name=to value='".$employee['tu']."'></td>";
    echo"<td>Selected: ".$employee['t_audience']."<br><select class= 'form-control' name='t_audience'>
              <option value='1'>1</option>
              <option value='2'>2</option>
              <option value='3'>3</option>
              <option value='4'>4</option>
        </select></td>";
    echo"<td><input type=text name=staff value='".$employee['staff']."'></td>";
    echo"<td><input type=date name=t_from value='".$employee['t_from']."'></td>";
    echo"<td><input type=date name=t_to value='".$employee['t_to']."'></td>";
  echo"<td><input type=file name=permission id='permission' value=''></td>";
  echo"<td><input type=file name=report id='report' value=''></td>";
  echo"<td><input type=file name=certificate id='certificate' value=''></td>";
  echo"<td><input type=file name=attendance id='attendance' value=''></td>";

  echo"<td>&nbsp<input type=submit name=update value=Update class='btn btn-primary' >";
  echo"<br><br><input type=submit name=delete value=Delete class='btn btn-primary' >&nbsp</td>";
  echo"</form></tr>";
}
?>
                    </tbody>
                   
                  </table>
                </div>
                  <form action="template.php?x=../organized/form_admin.php">
<input type=submit name="add" value="Add Activity To Organized" class="btn btn-primary">
</form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
     
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