  <script>
$(document).ready(function(){
  $(".6").attr("class","active");
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
        ?>

    	<?php
        $flag="";
        $sql="";
        if(isset($_POST['view_organized']))
        {
        $flag= 1;
        //echo "<center>".$_POST['from_date']."</center>";
    	$conn=mysqli_connect('localhost','root','','preyash');
    	$sql="SELECT * FROM organized where date >='$_POST[from_date]' AND date <='$_POST[to_date]'";
    	$records=mysqli_query($conn,$sql);
        }

        else if(isset($_POST['view_organized_all']))
        {
        $flag= 1;
        echo "<center>".$_POST['from_date']."</center>";
        $conn=mysqli_connect('localhost','root','','preyash');
        $sql="SELECT * FROM organized"; 
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
        <input type="submit" class="btn btn-warning btn-lg" name="view_organized" value = "View"></input>
        <input type="submit" class="btn btn-warning btn-lg" name="view_organized_all" value = "View All"></input>
    </div>
</form>


<!-- Main content -->
<section class="content">
 <div class="row">
    <div class="col-xs-12">


       <div class="box">
          <div class="box-header">
             <h3 class="box-title">View-Organized</h3>
         </div><!-- /.box-header -->
         <div class="box-body">
             <div style="overflow-x:auto;">
                <table id="example1" class="table table-bordered table-striped">
                   <thead>
                      <tr>
                         <th>Faculty Id</th>
                         <th>Faculty name</th>
                         <th>Industry Name</th>

                         <th>Purpose</th>
                         <th>Date</th>
                         <th>Target Audience</th>
                         <th>Staff</th>
                         <th>Certificate</th>
                         <th>Permission</th>
                         <th>Report</th>

                         <th>Attendance</th>
                         <!--<th>permission</th>-->
                     </tr>
                 </thead>
                 <tbody>
                  <?php

                  if($flag==1)
                  { 
                  while($iv=mysqli_fetch_assoc($records))
                  {
                     echo"<tr>";
                     echo"<td>".$iv['f_id']."</td>";
                     echo"<td>".$iv['f_name']."</td>";
                     echo"<td>".$iv['ind'].",".$iv['city']."</td>";
                     echo"<td>".$iv['purpose']."</td>";

                                                echo"<td>".$iv['date']."</td>"; //$iv['certificate']
                                                echo"<td>".$iv['t_audience']."</td>";
                                                echo"<td>".$iv['staff']."</td>";
                                                echo"<td>".$iv['t_from']."</td>";
                                                echo"<td>".$iv['t_to']."</td>";
  //echo"<td>".$iv['t_audience']."</td>";
                                                echo"<td><a href=".$iv['certificate']." download>download</a></td>";
                                                echo"<td><a href=".$iv['permission']." download>download</a></td>";
                                                echo"<td><a href=".$iv['report']." download>download</a></td>";
                                                echo"<td><a href=".$iv['attendance']." download>download</a></td>";
  //echo"<td><img src=".$iv['permission']." alt='permission' height='42' width='42'>";
                                                echo"</tr>";

                                            }
                                        }
                                            ?>
                                    
                                        </tbody>

                                    </table>

                                </div>
                                <div>
                                    <?php $_SESSION['table_name'] = 'organized';
                                        $_SESSION['table_query'] = $sql;
                                    ?>


                                    <a href="../Includes/export_to_excel.php" type="button" class="btn btn-success btn-sm"><span class="glyphicon ">Export</span></a>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
    
    </body>
    </html>