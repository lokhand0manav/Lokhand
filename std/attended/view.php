<script>
$(document).ready(function(){
  $(".3").attr("class","active");
});
</script>

<?php 
if(session_status() == PHP_SESSION_NONE){
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
?>

<?php
        $flag="";
        $sql="";
        if(isset($_POST['view_attended']))
        {
        $flag= 1;
        //echo "<center>".$_POST['from_date']."</center>";
        $conn=mysqli_connect('localhost','root','','preyash');
        $sql="SELECT * FROM attended where date >='$_POST[from_date]' AND date <='$_POST[to_date]' AND f_name ='$username' ";
        
        $records=mysqli_query($conn,$sql);
        }

        else if(isset($_POST['view_attended_all']))
        {
        $flag= 1;
        echo "<center>".$_POST['from_date']."</center>";
        $conn=mysqli_connect('localhost','root','','preyash');
        $sql="SELECT * FROM attended where f_name='$username'"; 
        $records=mysqli_query($conn,$sql);
        }
?>

  
      <!-- ============== View by particular Date =============== -->

        <form role="form" action = "" method="post">
          <div class="box-body">

           <div class="form-group">
            <label for="InputDateFrom">Date from :</label>
            <input type="date" name="from_date">

            <label for="InputDateTo">Date To :</label>
            <input type="date" name="to_date"></p>
        </div>
    </div>

    <div class="box-footer">
        <input type="submit" class="btn btn-warning btn-lg" name="view_attended" value = "View"></input>
        <input type="submit" class="btn btn-warning btn-lg" name="view_attended_all" value = "View All"></input>
    </div>
</form>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">View-Attended</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Faculty name</th>
                        <th>I.V Details</th>
                        <th>Purpose</th>
                        <th>Date</th>
                        <th>Certificate</th>
                        <th>permission</th>
                     </tr>
                    </thead>
                    <tbody>
                      <?php
                      if($flag==1)
                      {
                        while($iv=mysqli_fetch_assoc($records))
                        {
                         echo"<tr>";
                         echo"<td>".$iv['f_name']."</td>";
                         echo"<td>".$iv['ind'].",".$iv['city']."</td>";
                         echo"<td>".$iv['purpose']."</td>";
                         echo"<td>".$iv['date']."</td>"; //$iv['certificate']
                         //echo"<td>".$iv['certificate']."</td>";
                         echo"<td><a href=".$iv['certificate']." download>download</a></td>";
                          echo"<td>".$iv['permission']."</td>";
  //echo"<td><img src=".$iv['permission']." alt='permission' height='42' width='42'>";
                         echo"</tr>";

                        }
                       }
                        
                      ?>
                    </tbody>
                   
                  </table>
                  <div>
                    <?php $_SESSION['table_name'] = 'attended';
                                        $_SESSION['table_query'] = $sql;
                                    ?>
                    <a href="../Includes/export_to_excel.php" type="button" class="btn btn-success btn-sm"><span class="glyphicon ">Export</span></a>
                  </div>

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