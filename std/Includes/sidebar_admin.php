
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar" Style="margin-top:10px;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <div class="user-panel">
            <div class="pull-left image">
              <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php echo $_SESSION['username']; ?></p>
            </div>
      </div>
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
           
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Paper Publication</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="actcount.php"><i class="fa fa-circle-o"></i>Add Paper</a></li>
            <li><a href="2_dashboard.php"><i class="fa fa-circle-o"></i>View/Edit Activity</a></li>
            <li><a href="5_fdc_dashboard.php"><i class="fa fa-circle-o"></i>FDC details</a></li>
            <li><a href="count_your.php"><i class="fa fa-circle-o"></i>Analysis</a></li>
          </ul>
        </li>
        
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Technical Papers Reviewed</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="actcount_review.php"><i class="fa fa-circle-o"></i>Add Paper</a></li>
            <li><a href="2_dashboard_review.php"><i class="fa fa-circle-o"></i>View/Edit Activity</a></li>
            <li><a href="count_your_review.php"><i class="fa fa-circle-o"></i>Analysis</a></li>
          </ul>
        </li>
        <li class="active treeview">
            <a href="#">
              <i class="fa fa-dashboard"></i> <span>Attended</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li class="1" ><a href='template.php?x=../IV/attended/addcount.php'><i class="fa fa-circle-o"></i>Add Activity</a></li>
              <li class="2" ><a href='template.php?x=../IV/attended/edit_admin.php'><i class="fa fa-circle-o"></i>View/Edit Activity</a></li>
              <li class="3" ><a href='template.php?x=../IV/attended/view_admin.php'><i class="fa fa-circle-o"></i>Analysis</a></li>
            </ul>
        </li>

        <li class="active treeview">
            <a href="#">
              <i class="fa fa-dashboard"></i> <span>Organized</span> 
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li class="4" ><a href="template.php?x=../organized/actcount.php">Add Activity</a></li>
              <li class="5" ><a href="template.php?x=../organized/edit_admin.php">View/Edit Activity</a></li>
              <li class="6" ><a href="template.php?x=../organized/view_admin.php">Analysis</a></li>
            </ul>
        </li>
        
        
        
        
       
        
            <li><a href="../documentation/index.html"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
        <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>