<script>
$(document).ready(function(){
  $(".2").attr("class","active");
  $("button.close").click(function(){
  	window.location.replace("../includes/template.php?x=../IV/select_menu/edit_menu.php");
  });
});

</script>
<?php 
function change()
{
	echo "SELECTED";
}
if(isset($_GET['alert']))
			{
				//header("Refresh:0;url=../includes/template.php?x=../IV/select_menu/edit_menu.php");
				
			}
?>
<div class="box">
	<div class="box-body">

		<form role='form' action='' method='POST'>
			<!-- ===== Select Activity==== -->
			<div class='box-header with-border'>
				<h3 class='box-title'>View/Edit Activities</h3>
				<select name="activity" class="box-title" style="margin-left: 100px;">
					<option value="attended"  <?php if(isset($_POST['activity'])){if($_POST['activity']=="attended") change();}?>>Attended</option>
					<option value="organized" <?php if(isset($_POST['activity'])){if($_POST['activity']=="organized") change();}?>>Organized</option>
				</select>
			</div><!-- /.box-header   -->
			
			<div class='box-footer'>
				<button type='submit' name='submit_view' id='submit' value='' class='btn btn-primary'>View</button>
				<button type='submit' name='cancel' id='cancel' value='' class='btn btn-primary'>Cancel</button>
			</div>
			
		</form>
		
	</div>
	
	<?php 
	if(isset($_POST['submit_view']))
	{		
	  
		include_once("../IV/".$_POST['activity']."/edit.php");// $_POST['submit_view']="";
	}
	

	if(isset($_POST['cancel']))
	{
		
		header("location:template.php");
		
		
	}
	
	?>