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

    set_include_path(get_include_path() . PATH_SEPARATOR . "/dompdf");
   include_once 'dompdf/dompdf_config.inc.php';

   $conn=mysqli_connect('localhost','root','','department');
		
   $sql = $_SESSION['table_query'];
   $table="";

   $result=mysqli_query($conn,$sql);  
   $dompdf = new DOMPDF();
  
  if(mysqli_num_rows($result)>0)
                      {
                        $table ="<table border=1>
                           <thead>
                            <tr>
                            <th>Faculty Name</th>
                            <th>Industry Name</th>
                            <th>City</th>
                            <th>Purpose</th>
                            <th>Date</th>
                            </tr>" ;

                          while($employee=mysqli_fetch_assoc($result))
                          {

                            $table = $table."<tr>";
                            $table = $table."<td>".$employee['ind']."</td>";
                            $table = $table."<td>".$employee['city']."</td>";
                            $table = $table."<td>".$employee['purpose']."</td>";
                            $table = $table."<td>".$employee['date']."</td>";
                            $table = $table."</tr>";
                           }  
                         }                          
 ?>

</thead></table>
<?php 
   
                  $dompdf->load_html($table);
                   $dompdf->render();
                $dompdf->stream("hello.pdf");

?>