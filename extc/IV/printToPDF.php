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

   include_once("IVsql.php");
    set_include_path(get_include_path() . PATH_SEPARATOR . "/dompdf");
   include_once 'dompdf/dompdf_config.inc.php';

   $conn=mysqli_connect('localhost','root','','department');
		
	 if($_SESSION['username']=="hodextc@somaiya.edu")
	{
		$selection="<th>Faculty Name</th>";
	}
	else
		$selection="";	
   $sql = $_SESSION['table_query'];
   $table="";

   $result=mysqli_query($conn,$sql);  
   $dompdf = new DOMPDF();
   if(isset($_GET['flag']))
   {
    $table="<table border=1 width=100% align=center>
            <tr>
            <th>Activity Name</th>
            <th>Total Number of Activity</th>
            </tr>
            <tr>
            <td align=center>$_GET[type]</td>
            <td align=center>$_GET[count]</td>
            </tr>
            </table>
            <br>
            <hr>
            <center><p>Date :$_GET[date]</p></center>
            <hr>
           ";
   } 
  if(mysqli_num_rows($result)>0)
                      {

                        $table =$table."<table border=1 width=100%>
                           <thead>
                            <tr>
                            ".$selection."<th>Industry Name</th>
                            <th>City</th>
                            <th>Purpose</th>
                            <th>Date</th>
                            </tr>" ;

                          while($employee=mysqli_fetch_assoc($result))
                          {
                            $table = $table."<tr>";

                          	if($_SESSION['username']=="hodextc@somaiya.edu")
                            {
                            $table = $table."<td>".$employee['F_NAME']."</td>";
                        	}
                        	

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
                  $dompdf->set_paper('a4', 'portrait');
                  //$dompdf->stream("hello.pdf");
                  $dompdf->stream('hi',array('Attachment'=>0));

?>