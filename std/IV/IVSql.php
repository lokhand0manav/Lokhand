<?php
//$conn = "";	
//using array of the respective tables so whatever the changes are needed to be made will be made direct in the array
	function attended()
	{
		$attended = array('f_id','f_name','ind','city','purpose','date','permission','report','certificate');
		return $attended;
	}

	function organized()
	{
		$organized = array('f_id','f_name','ind','city','purpose','date','t_audience','staff','permission','report','certificate','attendance','t_from','t_to');
		return $organized;
	}

	//$organized=

//associative to indexed array conversion
	function changeAssociation($type,$arr)
	{
		
		if(strcmp($type,"attended")==0)
		{
			$attended = attended();
			$temp = array($arr[$attended[0]],$arr[$attended[1]],$arr[$attended[2]],$arr[$attended[3]],$arr[$attended[4]],$arr[$attended[5]],$arr[$attended[6]],$arr[$attended[7]],$arr[$attended[8]]);
			return $temp;	
		}
		else
		{
			$organized = organized();
			$temp = array($arr[$organized[0]],$arr[$organized[1]],$arr[$organized[2]],$arr[$organized[3]],$arr[$organized[4]],$arr[$organized[5]],$arr[$organized[6]],$arr[$organized[7]],$arr[$organized[8]],$arr[$organized[9]],$arr[$organized[10]],$arr[$organized[11]],$arr[$organized[12]],$arr[$organized[13]]);
			return $temp;
		}
		
	}

	function changeAssociationT($type,$arr)
	{
		if(strcmp($type,"attended")==0)
		{
			$attended = attended();
			$temp = array('2'=>$arr[$attended[2]],'3'=>$arr[$attended[3]],'4'=>$arr[$attended[4]],'5'=>$arr[$attended[5]]);
			return $temp;	
		}
		else
		{
			$organized = organized();
			$temp = array('2'=>$arr[$organized[2]],'3'=>$arr[$organized[3]],'4'=>$arr[$organized[4]],'5'=>$arr[$organized[5]]);
			return $temp;
		}
	}
//here the connection is established so any changes in db only have to be reflected in connection function;
	function connection()
	{
		$conn=mysqli_connect('localhost','root','','preyash');
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

//for returning count in view_menu
	function count_query($from,$f_name,$isDate) 
	{
		$attended = attended();
		$organized = organized();
		if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
		{
			if($f_name="all")
			{
				if($isDate==0)
				{
					if(strcmp($from,"attended")==0)
						return simpleQuery("count($attended[0]) as total", $from ,"1=1");
					else
						return simpleQuery("count($organized[0]) as total", $from ,"1=1");
				}
				else
				{
					if(strcmp($from,"attended")==0)
						return simpleQuery("count($attended[0]) as total", $from , "$attended[5] >='".$min_date."' AND $attended[5] <='".$max_date."'");	
					else
						return simpleQuery("count($organized[0]) as total", $from , "$organized[5] >='".$min_date."' AND $organized[5] <='".$max_date."'");		
				}
			}
			else
			{
				if($isDate==0)
				{
					if(strcmp($from,"attended")==0)
						return simpleQuery("count($attended[0]) as total", $from ,"$attended[1]='".$f_name."'");
					else
						return simpleQuery("count($organized[0]) as total", $from ,"$organized[1]='".$f_name."'");
				}
				else
				{
					if(strcmp($from,"attended")==0)
						return simpleQuery("count($attended[0]) as total", $from , "$attended[1]='".$f_name."'AND $attended[5] >='".$min_date."' AND $attended[5] <='".$max_date."'");	
					else
						return simpleQuery("count($organized[0]) as total", $from , "$organized[1]='".$f_name."'AND $organized[5] >='".$min_date."' AND $organized[5] <='".$max_date."'");	

				}
			}
		}
		else
		{
			if($isDate==0)
			{
				if(strcmp($from,"attended")==0)
					return simpleQuery("count($attended[5]) as total", $from ,"$attended[1] = '".$_SESSION['username']."'");
				else
					return simpleQuery("count($organized[5]) as total", $from ,"$organized[1] = '".$_SESSION['username']."'");

			}
			else
			{
				if(strcmp($from,"attended")==0)
					return simpleQuery("count($attended[5]) as total", $from , "$attended[1]='".$_SESSION['username']."'AND $attended[5] >='".$GLOBALS['min_date']."' AND $attended[5] <='".$GLOBALS['max_date']."'"); //no where condition
				else
					return simpleQuery("count($organized[5]) as total", $from , "$organized[1]='".$_SESSION['username']."'AND $organized[5] >='".$GLOBALS['min_date']."' AND $organized[5] <='".$GLOBALS['max_date']."'"); //no where condition

			}	
		}
		
     
	}

//the name suggests, it is for view.php
	function view($from,$f_name,$isDate)
	{
		$attended = attended();
		$organized = organized();
		if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
		{
			if($f_name="all")
			{
				if($isDate==0)
				{
					if(strcmp($from,"attended")==0)
						return simpleQuery("$attended[2],$attended[3],$attended[4],$attended[5]", $from ,"1=1 ORDER BY DATE ASC");
					else
						return simpleQuery("$organized[2],$organized[3],$organized[4],$organized[5]",$from,"1=1 ORDER BY DATE ASC");
				}
				else
				{
					if(strcmp($from,"attended")==0)
						return simpleQuery("$attended[2],$attended[3],$attended[4],$attended[5]", $from , "$attended[5] >='".$min_date."' AND $attended[5] <='".$max_date."' ORDER BY DATE ASC");	
					else
						return simpleQuery("$organized[2],$organized[3],$organized[4],$organized[5]",$from,"$organized[5] >='".$min_date."' AND $organized[5] <='".$max_date."' ORDER BY DATE ASC");
				}
			}
			else
			{
				if($isDate==0)
				{
					if(strcmp($from,"attended")==0)
						return simpleQuery("$attended[2],$attended[3],$attended[4],$attended[5]", $from ,"$attended[1]='".$f_name."' ORDER BY DATE ASC");
					else
						return simpleQuery("$organized[2],$organized[3],$organized[4],$organized[5]",$from,"$organized[1]='".$f_name."' ORDER BY DATE ASC");
				}
				else
				{
					if(strcmp($from,"attended")==0)
						return simpleQuery("$attended[2],$attended[3],$attended[4],$attended[5]", $from , "$attended[1]='".$f_name."'AND $attended[5] >='".$min_date."' AND $attended[5] <='".$max_date."' ORDER BY DATE ASC");	
					else
						return simpleQuery("$organized[2],$organized[3],$organized[4],$organized[5]",$from,"$organized[1]='".$f_name."'AND $organized[5] >='".$min_date."' AND $organized[5] <='".$max_date."' ORDER BY DATE ASC");
				}
			}
		}
		else
		{
			if($isDate==0)
			{
				if(strcmp($from,"attended")==0)
					return simpleQuery("$attended[2],$attended[3],$attended[4],$attended[5]", $from ,"$attended[1] = '".$_SESSION['username']."' ORDER BY DATE ASC");
				else
					return simpleQuery("$organized[2],$organized[3],$organized[4],$organized[5]",$from,"$organized[1] = '".$_SESSION['username']."' ORDER BY DATE ASC");
			}
			else
			{
				if(strcmp($from,"attended")==0)
					return simpleQuery("$attended[2],$attended[3],$attended[4],$attended[5]", $from , "$attended[1]='".$_SESSION['username']."'AND $attended[5] >='".$GLOBALS['min_date']."' AND $attended[5] <='".$GLOBALS['max_date']."' ORDER BY DATE ASC"); //no where condition
				else
					return simpleQuery("$organized[2],$organized[3],$organized[4],$organized[5]",$from,"$organized[1]='".$_SESSION['username']."'AND $organized[5] >='".$GLOBALS['min_date']."' AND $organized[5] <='".$GLOBALS['max_date']."' ORDER BY DATE ASC"); //no where condition
			}

		}	
	}


//for returning the sql query in view, which is required in export to excel
	function viewReturn($from,$f_name,$isDate) 
	{
		$attended = attended();
		$organized = organized();
		if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
		{
			if($f_name="all")
			{
				if($isDate==0)
				{
					if(strcmp($from,"attended")==0)
						return simpleQueryReturn("$attended[2],$attended[3],$attended[4],$attended[5]", $from ,"1=1 ORDER BY DATE ASC");
					else
					    return simpleQueryReturn("$organized[2],$organized[3],$organized[4],$organized[5]",$from,"1=1 ORDER BY DATE ASC");
				}
				else
				{
					if(strcmp($from,"attended")==0)
						return simpleQueryReturn("$attended[2],$attended[3],$attended[4],$attended[5]", $from , "$attended[5] >='".$min_date."' AND $attended[5] <='".$max_date."' ORDER BY DATE ASC");	
					else
						return simpleQueryReturn("$organized[2],$organized[3],$organized[4],$organized[5]",$from,"$organized[5] >='".$min_date."' AND $organized[5] <='".$max_date."' ORDER BY DATE ASC");	
				}
			}
			else
			{
				if($isDate==0)
				{
					if(strcmp($from,"attended")==0)
						return simpleQueryReturn("$attended[2],$attended[3],$attended[4],$attended[5]", $from ,"$attended[1]='".$f_name."' ORDER BY DATE ASC");
					else
						return simpleQueryReturn("$organized[2],$organized[3],$organized[4],$organized[5]",$from,"$organized[1]ded[1]='".$f_name."' ORDER BY DATE ASC");
				}
				else
				{
					if(strcmp($from,"attended")==0)
						return simpleQueryReturn("$attended[2],$attended[3],$attended[4],$attended[5]", $from , "$attended[1]='".$f_name."'AND $attended[5] >='".$min_date."' AND $attended[5] <='".$max_date."' ORDER BY DATE ASC");	
					else
						return simpleQueryReturn("$organized[2],$organized[3],$organized[4],$organized[5]",$from,"$organized[1]='".$f_name."'AND $organized[5] >='".$min_date."' AND $organized[5] <='".$max_date."' ORDER BY DATE ASC");	
				}
			}
		}
		else
		{
			if($isDate==0)
			{
				if(strcmp($from,"attended")==0)
					 simpleQueryReturn("$attended[2],$attended[3],$attended[4],$attended[5]", $from ,"$attended[1] = '".$_SESSION['username']."' ORDER BY DATE ASC");
				else
					return simpleQueryReturn("$organized[2],$organized[3],$organized[4],$organized[5]",$from,"$organized[1] = '".$_SESSION['username']."' ORDER BY DATE ASC");
			}
			else
			{
				if(strcmp($from,"attended")==0)
					 simpleQueryReturn("$attended[2],$attended[3],$attended[4],$attended[5]", $from , "$attended[1]='".$_SESSION['username']."'AND $attended[5] >='".$GLOBALS['min_date']."' AND $attended[5] <='".$GLOBALS['max_date']."' ORDER BY DATE ASC"); //no where condition
				else
					return simpleQueryReturn("$organized[2],$organized[3],$organized[4],$organized[5]",$from,"$organized[1]='".$_SESSION['username']."'AND $organized[5] >='".$GLOBALS['min_date']."' AND $organized[5] <='".$GLOBALS['max_date']."' ORDER BY DATE ASC"); //no where condition
			}

		}	
	}

//both for attended and organized and admin aswell
	function edit($from,$f_name) 
	{
		$attended = attended();
		$organized = organized();
		if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
		{
		}
		else
		{
				if(strcmp($from,"attended")==0)
					return simpleQuery("*",$from,"$attended[1] = '".$_SESSION['username']."'");		
				else
					return simpleQuery("*",$from,"$organized[1] = '".$_SESSION['username']."'");
		}
	}

//this is the core function, used in form.php,update.php,delete.php can be used in attended, organized and admin of both
	function IV($what,$from,$arr,$select)
	{
		$attended = attended();
		$organized = organized();
		switch($select)
		{
			case "select" :  if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
							 {
							 
							 }
							 else
							 {
							 	if(strcmp($from,"attended")==0)
							 		return simpleQuery($what,$from,"$attended[0]= $arr");
							 	else
							 		return simpleQuery($what,$from,"$organized[0]= $arr");
							 }		
								 
							 break;
			
			case "update" :  
								if(strcmp($from,"attended")==0)
							 	{
							 		
							 		if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
									{

									}
									else
									{
										$sql = "UPDATE attended set $attended[1] ='$arr[1]' ,$attended[2] ='$arr[2]', $attended[3]='$arr[3]', $attended[4]='$arr[4]', $attended[5]='$arr[5]',$attended[6]='$arr[6]',$attended[7]='$arr[7]',$attended[8]='$arr[8]' where $attended[0]= $arr[0];";
							 			$result=mysqli_query($GLOBALS['conn'],$sql);
							 			mysqli_close($GLOBALS['conn']);
										return $result;	
									}	
							 			
							 	}
							    else //organized
							 	{
							 		if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
									{

									}
									else
									{
										
										$sql = "UPDATE organized set $organized[1] ='$arr[1]', $organized[2] ='$arr[2]', $organized[3]='$arr[3]', $organized[4]='$arr[4]', $organized[5]='$arr[5]',$organized[6]='$arr[6]',$organized[7]='$arr[7]',$organized[8]='$arr[8]',$organized[9]='$arr[9]',$organized[10]='$arr[10]',$organized[11]='$arr[11]',$organized[12]='$arr[12]',$organized[13]='$arr[13]' where $organized[0]= $arr[0];";
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

									}
									else
									{
										//$conn=connection();
										$sql="INSERT INTO attended ($attended[1],$attended[2],$attended[3],$attended[4],$attended[5]) VALUES ('$arr[1]','$arr[2]','$arr[3]','$arr[4]','$arr[5]')";
										$result=mysqli_query($GLOBALS['conn'],$sql);
										return $result;	
									}
								}	
								else
								{
									if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
								    {
														
									}
									else
									{
										$sql="INSERT INTO organized ($organized[1],$organized[2],$organized[3],$organized[4],$organized[5],$organized[6],$organized[7],$organized[12],$organized[13]) VALUES ('$arr[1]','$arr[2]','$arr[3]','$arr[4]','$arr[5]','$arr[6]','$arr[7]','$arr[12]','$arr[13]')";
										$result=mysqli_query($GLOBALS['conn'],$sql);
										return $result;	
									}	
								}	
								break;

			case "delete" : 	if(strcmp($from,"attended")==0)
								{

									if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
									{
									}
									else
									{
										
										$sql="DELETE FROM attended WHERE $attended[0]='$arr'";
										$result=mysqli_query($GLOBALS['conn'],$sql);
							 			mysqli_close($GLOBALS['conn']);
										return $result;	
									}
									
								}
							 else
							 	{
							 		if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
									{
									}
									else
									{
										
										$sql="DELETE FROM organized WHERE $organized[0]='$arr'";
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