<?php
//$_SESSION['f_id'] is created in index.php
//here the connection is established so any changes in db only have to be reflected in connection function;
	function connection()
	{
		$conn=mysqli_connect('localhost','root','','department');
		return $conn;
	}

//this is simpleQuery, carrying simple structure of a query, call through various functions
	function simpleQuery($what,$from,$where) 
	{
		$conn=connection();
		$query = "SELECT $what from $from where $where";
		$result=mysqli_query($conn,$query);
		mysqli_close($conn);
		return $result;
	}

//this is simple query returning only sql query, which is needed for export to excel
	function simpleQueryReturn($what,$from,$where) 
	{
		$conn=connection();
		$query = "SELECT $what from $from where $where";
		mysqli_close($conn);
		return $query;
	}

//get the faculty details from the facultydetails table 
	function getFacultyDetails($f_id)
	{
		if(strcmp($f_id,"")==0)
		{
			return simpleQuery("*","facultydetails","1=1");	
		}
		else
		{
			return simpleQuery("*","facultydetails","Fac_ID = $f_id");
		}
	}

//for returning count in view_menu
	function count_query($from,$f_id,$isDate) 
	{
		if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
		{
				if($isDate==0) //is the date mentioned? 0 means not
				{	
					if($f_id==0 || $f_id==9) //ALL//9 is for HOD
						return simpleQuery("count('id') as total", $from ,"1=1");
					else
						return simpleQuery("count('id') as total", $from ,"f_id='".$f_id."'");
				}
				else
				{
					if($f_id==0 || $f_id==9) //ALL//9 is for HOD
						return simpleQuery("count('id') as total", $from , "date >='".$GLOBALS['min_date']."' AND date <='".$GLOBALS['max_date']."'");		
					else
						return simpleQuery("count('id') as total", $from , "f_id='".$f_id."'AND date >='".$GLOBALS['min_date']."' AND date <='".$GLOBALS['max_date']."'");		

				}
	
		}
		else
		{
			if($isDate==0)
			{
				return simpleQuery("count('id') as total", $from ,"f_id = '".$f_id."'");

			}
			else
			{
			
				return simpleQuery("count('id') as total", $from , "f_id='".$f_id."'AND date >='".$GLOBALS['min_date']."' AND date <='".$GLOBALS['max_date']."'"); //no where condition

			}	
		}
		
     
	}

//the name suggests, it is for view.php
	function view($from,$f_id,$isDate)
	{

		if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
		{
			
				if($isDate==0)
				{
					if($f_id==0) //ALL,
						return simpleQuery("ind,city,purpose,date",$from,"1=1 ORDER BY DATE ASC");
					else
						return simpleQuery("ind,city,purpose,date",$from,"f_id = '".$f_id."' ORDER BY DATE ASC");
				}
				else
				{
					if($f_id==0) //ALL faculty
						return simpleQuery("ind,city,purpose,date",$from,"date >='".$GLOBALS['min_date']."' AND date <='".$GLOBALS['max_date']."' ORDER BY DATE ASC");
					else
						return simpleQuery("ind,city,purpose,date",$from,"f_id = '".$f_id."' AND date >='".$GLOBALS['min_date']."' AND date <='".$GLOBALS['max_date']."' ORDER BY DATE ASC");

				}
		
		}
		else
		{
			if($isDate==0)
			{
				return simpleQuery("ind,city,purpose,date",$from,"f_id = '".$f_id."' ORDER BY DATE ASC");
			}
			else
			{
				
				return simpleQuery("ind,city,purpose,date",$from,"f_id='".$f_id."'AND date >='".$GLOBALS['min_date']."' AND date <='".$GLOBALS['max_date']."' ORDER BY DATE ASC"); //no where condition
			}

		}	
	}


//for returning the sql query in view, which is required in export to excel
	function viewReturn($from,$f_id,$isDate) 
	{

		if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
		{
			
				if($isDate==0)
				{
					if($f_id==0) //ALL faculty
						return simpleQueryReturn("ind,city,purpose,date",$from,"1=1 ORDER BY DATE ASC");
					else
						return simpleQueryReturn("ind,city,purpose,date",$from,"f_id = '".$f_id."' ORDER BY DATE ASC");	
				}
				else
				{
					if($f_id==0) //ALL faculty
						return simpleQueryReturn("ind,city,purpose,date",$from,"date >='".$GLOBALS['min_date']."' AND date <='".$GLOBALS['max_date']."' ORDER BY DATE ASC");	
					else
						return simpleQueryReturn("ind,city,purpose,date",$from,"f_id = '".$f_id."' AND date >='".$GLOBALS['min_date']."' AND date <='".$GLOBALS['max_date']."' ORDER BY DATE ASC");

				}
			
		}
		else
		{
			if($isDate==0)
			{

				return simpleQueryReturn("ind,city,purpose,date",$from,"f_id = '".$f_id."' ORDER BY DATE ASC");
			}
			else
			{
		
				return simpleQueryReturn("ind,city,purpose,date",$from,"f_id='".$f_id."'AND date >='".$GLOBALS['min_date']."' AND date <='".$GLOBALS['max_date']."' ORDER BY DATE ASC"); //no where condition
			}

		}	
	}

//both for attended and organized and admin aswell, in edit.php
	function edit($from,$f_id) 
	{

		if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
		{
			if($f_id==0) //0 is for all
				return simpleQuery("*",$from,"1=1");
			else
				return simpleQuery("*",$from,"f_id = '".$f_id."'");
		}
		else
		{
			return simpleQuery("*",$from,"f_id = '".$f_id."'");
		}
	}

//this is the core function, used in form.php,update.php,delete.php can be used in attended, organized and admin of both
//*note for developer : for time being all the if else statement(HOD) have same blocks of statement, if no changes are found remove*	
	function IV($what,$from,$arr,$select)
	{

		switch($select)
		{
			case "select" :  if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
							 {
							 	if(strcmp($from,"attended")==0)
							 		return simpleQuery($what,$from,"id= $arr");
							 	else
							 		return simpleQuery($what,$from,"id= $arr");
							 }
							 else
							 {
							 	if(strcmp($from,"attended")==0)
							 		return simpleQuery($what,$from,"id= $arr");
							 	else
							 		return simpleQuery($what,$from,"id= $arr");
							 }		
								 
							 break;
			
			case "update" :  
								if(strcmp($from,"attended")==0)
							 	{
							 		
							 		if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
									{
										$sql = "UPDATE attended set f_id ='$arr[1]' ,ind ='$arr[2]', city='$arr[3]', purpose='$arr[4]', date='$arr[5]',permission='$arr[6]',report='$arr[7]',certificate='$arr[8]' where id= $arr[0];";
							 			$result=mysqli_query($GLOBALS['conn'],$sql);
							 			mysqli_close($GLOBALS['conn']);
										return $result;
									}
									else
									{
										$sql = "UPDATE attended set f_id ='$arr[1]' ,ind ='$arr[2]', city='$arr[3]', purpose='$arr[4]', date='$arr[5]',permission='$arr[6]',report='$arr[7]',certificate='$arr[8]' where id= $arr[0];";
							 			$result=mysqli_query($GLOBALS['conn'],$sql);
							 			mysqli_close($GLOBALS['conn']);
										return $result;	
									}	
							 			
							 	}
							    else //organized
							 	{
							 		if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
									{
										$sql = "UPDATE organized set f_id ='$arr[1]', ind ='$arr[2]', city='$arr[3]', purpose='$arr[4]', date='$arr[5]',t_audience='$arr[6]',staff='$arr[7]',permission='$arr[8]',report='$arr[9]',certificate='$arr[10]',attendance='$arr[11]',t_from='$arr[12]',t_to='$arr[13]' where id= $arr[0];";
							 			$result=mysqli_query($GLOBALS['conn'],$sql);
							 			mysqli_close($GLOBALS['conn']);
										return $result;	
									}
									else
									{
										
										$sql = "UPDATE organized set f_id ='$arr[1]', ind ='$arr[2]', city='$arr[3]', purpose='$arr[4]', date='$arr[5]',t_audience='$arr[6]',staff='$arr[7]',permission='$arr[8]',report='$arr[9]',certificate='$arr[10]',attendance='$arr[11]',t_from='$arr[12]',t_to='$arr[13]' where id= $arr[0];";
							 			$result=mysqli_query($GLOBALS['conn'],$sql);
							 			mysqli_close($GLOBALS['conn']);
										return $result;	
									}		
							 	}
							 break;
			
			case "insert" :  
								if(strcmp($from,"attended")==0)
								{
									if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
									{
										$sql="INSERT INTO attended (f_id,ind,city,purpose,date) VALUES ('$arr[1]','$arr[2]','$arr[3]','$arr[4]','$arr[5]')";
										$result=mysqli_query($GLOBALS['conn'],$sql);
										return $result;
									}
									else
									{
										//$conn=connection();
										$sql="INSERT INTO attended (f_id,ind,city,purpose,date) VALUES ('$arr[1]','$arr[2]','$arr[3]','$arr[4]','$arr[5]')";
										$result=mysqli_query($GLOBALS['conn'],$sql);
										return $result;	
									}
								}	
								else
								{
									if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
								    {
										$sql="INSERT INTO organized (f_id,ind,city,purpose,date,t_audience,staff,t_from,t_to) VALUES ('$arr[1]','$arr[2]','$arr[3]','$arr[4]','$arr[5]','$arr[6]','$arr[7]','$arr[12]','$arr[13]')";
										$result=mysqli_query($GLOBALS['conn'],$sql);
										return $result;			
									}
									else
									{
										$sql="INSERT INTO organized (f_id,ind,city,purpose,date,t_audience,staff,t_from,t_to) VALUES ('$arr[1]','$arr[2]','$arr[3]','$arr[4]','$arr[5]','$arr[6]','$arr[7]','$arr[12]','$arr[13]')";
										$result=mysqli_query($GLOBALS['conn'],$sql);
										return $result;	
									}	
								}	
								break;

			case "delete" : 	if(strcmp($from,"attended")==0)
								{

									if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
									{
										$sql="DELETE FROM attended WHERE id='$arr'";
										$result=mysqli_query($GLOBALS['conn'],$sql);
							 			mysqli_close($GLOBALS['conn']);
										return $result;
									}
									else
									{
										
										$sql="DELETE FROM attended WHERE id='$arr'";
										$result=mysqli_query($GLOBALS['conn'],$sql);
							 			mysqli_close($GLOBALS['conn']);
										return $result;	
									}
									
								}
							 else
							 	{
							 		if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
									{
										$sql="DELETE FROM organized WHERE id='$arr'";
										$result=mysqli_query($GLOBALS['conn'],$sql);
							 			mysqli_close($GLOBALS['conn']);
										return $result;	
									}
									else
									{
										
										$sql="DELETE FROM organized WHERE id='$arr'";
										$result=mysqli_query($GLOBALS['conn'],$sql);
							 			mysqli_close($GLOBALS['conn']);
										return $result;	
									}	
							 	}
							 break;			 
		}

	}



	//create a query function with one of the argument describing:
		//1. whether it is view.php or not, 
			//for view.php we only have few comuns to be shown and there is order by clause used
	    //2.count query, this will count the query, an argument specifying : count using date or not
	//it seems like count_query and view_menu are same
	//edit form and updated will have an argument specifying attended or organized
	   //edit will only have : simple query with argument specifying faculty id *in og we used faculty name*
	   //form, in this we haveto select that particular row which we are supposed to edit, sent from edit.php
		//so we will need a row id (attended_id or organized_id or just simply row_id)
		//apart from this, we have to update and insert values using form.php file, so
			//an update query with arguments for either attended or organized(use switch case) and row_id 
 			//an Insert query will insert the values, argument : either attended or organzied(switch case) and faculty id 
	//update.php 	
 ?>	