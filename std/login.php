<html>
<head>
<?php 
session_start();
  if(isset($_POST['login']))  
  {  

    $flag = 0;
    if(array_key_exists('password', $_POST))
      $pass = $_POST['password'];
      if(empty($pass)) {
      $flag = 1;
      $passErr = "Password can't be empty";
      }
  
    if(array_key_exists('username', $_POST))
      $username = $_POST['username'];
    if(empty($username)) {
      $flag = 1;
      $usernameErr = "Please Fill username";
    }
      if($flag==0)
      {
      $conn=mysqli_connect('localhost','root','','preyash');
  
      if (!$conn)
      {
      echo "Failed to connect to MySQL: ";
      }
      
    $username=$_POST['username'];  
    $password=$_POST['password'];  
    $check_user="select * from signin WHERE Username='$username' AND Password='$password'";  
    $return = mysqli_query($conn,$check_user);
   
    if($return)
      {
        if($return->num_rows != 0) {
          while($row=mysqli_fetch_array($return))
          {
            if($row['Username']==$username && $row['Password']==$password ) {
             session_start();
              $_SESSION['username'] = $username; 
              header("refresh:1,url= includes/template.php");

              exit();
            }
          }
        }
        else {
                echo "You are not Registered";
        }
      } 
          

      mysqli_close($conn);  
    }
  }
  ?>
	<title></title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</head>
<body>
  <center>
  <div class="container col-sm-4" style="border: 1px solid black;margin: 125px 450px;box-shadow: 2px 2px 5px #888888;">
	<form method="POST">
	<div class="form-group">
  <label><h3>Username:</h3></label> 
  <input type="text" name="username" class="form-control"  placeholder="Enter Username">
  <span style = "color: red;"><?php
    if(!empty($usernameErr)) echo "*".$usernameErr; ?></span>
  </div>
  <div class="form-group">
    <label><h3>Password</h3></label>
    <input type="password" name="password" class="form-control"  placeholder="Enter Password">
    &nbsp;
    <span style = "color: red;">
      <?php
    if(!empty($passErr)) echo "*".$passErr; ?></span>

  </div>
  <div style="text-align:center"> 
		<input type="submit" name="login" Value="Sign in" class="btn btn-primary"> 
<!--     &nbsp;
    <input type="submit" name="signup" Value="Sign Up" class="btn btn-primary" formaction="signup.php"> --> 
	</div>
  </form>
  </div>
</center>
</body>
</html>