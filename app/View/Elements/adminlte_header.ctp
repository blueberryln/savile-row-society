          <?php $user = $this->Session->read('user'); ?>
          <header class="main-header">
            <!-- Logo -->
            <a href="/" class="logo"><img src="<?php echo ADMIN_LTE ?>dist/img/logo.png" alt="Savilerowsociety" /></a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">               
          </header>
          <!-- Left side column. contains the logo and sidebar -->
          <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
              <!-- Sidebar user panel -->
              <div class="user-panel">
                <div class="pull-left image">
                  <img src="<?php echo ADMIN_LTE ?>admin-default.jpg" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                  <p><?= $user['User']['first_name']; ?></p>

                  <a href="#"><i class="text-success"></i> Savilerowsociety</a>
                </div>
              </div>
              <!-- search form -->
              <!-- <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                  <input type="text" name="q" class="form-control" placeholder="Search..."/>
                  <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                  </span>
                </div>
              </form> -->
              <!-- /.search form -->
              <!-- sidebar menu: : style can be found in sidebar.less -->
              <ul class="sidebar-menu">

                <li class="treeview <?php echo @$this->params['action']=='blog' || @$this->params['action']=='outfit_comments' || @$this->params['action']=='add_blogpost' || @$this->params['action']=='edit_blogpost' || @$this->params['action']=='add_comments' || @$this->params['action']=='edit_comments' || @$this->params['action']=='slide_blogpost' || @$this->params['action']=='add_slide_blogpost' || @$this->params['action']=='edit_slide_blogpost'  ?'active':''?>">
                  <a href="#">
                    <i class="fa fa-fw fa-home"></i> <span>Home Page</span> <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li class="<?php echo @$this->params['action']=='blog' || @$this->params['action']=='add_blogpost' || @$this->params['action']=='edit_blogpost' ? 'active':''?>"><a href="/admins/blog"><i class="fa fa-circle-o"></i> Blog</a></li>
                    <li class="<?php echo @$this->params['action']=='outfit_comments' || @$this->params['action']=='add_comments' || @$this->params['action']=='edit_comments'  ?'active':''?>"><a href="/admins/outfit_comments"><i class="fa fa-circle-o"></i> Outfits Comments</a></li>
                    <li class="<?php echo @$this->params['action']=='slide_blogpost' || @$this->params['action']=='add_slide_blogpost' || @$this->params['action']=='edit_slide_blogpost'  ?'active':''?>"><a href="/admins/slide_blogpost"><i class="fa fa-circle-o"></i> Slide Blogpost</a></li>
                  </ul>
                </li>
                <li class="treeview <?php echo @$this->params['action']=='sales_team_email' || @$this->params['action']=='add_sales_email' || @$this->params['action']=='email_content' ?'active':''?>">
                  <a href="#">
                    <i class="fa fa-fw fa-envelope"></i> <span>Email Sales Team</span> <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li class="<?php echo @$this->params['action']=='sales_team_email' || @$this->params['action']=='add_sales_email' ? 'active':''?>"><a href="/admins/sales_team_email"><i class="fa fa-circle-o"></i> Sales Team Members</a></li>
                    <li class="<?php echo @$this->params['action']=='email_content'  ?'active':''?>"><a href="/admins/email_content"><i class="fa fa-circle-o"></i> Email Content</a></li>
                  </ul>
                </li>

                <li> <a href="/admin/users"> <i class="fa fa-fw fa-user"></i> <span>Users</span></a> </li>
                <li> <a href="/admin/styles"> <i class="fa fa-fw fa-users"></i> <span>Style Profile</span></a> </li>
                <li> <a href="/admin/products"> <i class="fa fa-shopping-cart"></i> <span>Products</span></a> </li>
                <li> <a href="/admin/brands"> <i class="fa fa-fw fa-archive"></i> <span>Brands</span></a> </li>
                <li> <a href="/admin/colors"> <i class="fa fa-fw fa-pencil"></i> <span>Colors</span></a> </li>
                <li> <a href="/admin/sizes"> <i class="fa fa-fw fa-text-height"></i> <span>Size</span></a> </li>
                <li> <a href="/admin/categories"> <i class="fa fa-fw fa-th-list"></i> <span>Categories</span></a> </li>
                <li> <a href="/admin/seasons"> <i class="fa fa-fw fa-sun-o"></i> <span>Seasons</span></a> </li>
                <li> <a href="/admin/orders"> <i class="fa fa-fw fa-tasks"></i> <span>Orders</span></a> </li>

                <li class="treeview">
                  <a href="Javascript:;">
                    <i class="fa fa-fw fa-sign-in"></i> <span>Account</span><i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="/"><i class="fa fa-circle-o"></i> View Website</a></li>
                    <li><a href="/signout"><i class="fa fa-circle-o"></i> Sign Out</a></li>
                  </ul>
                </li>
            
              </ul>
            </section>
            <!-- /.sidebar -->
          </aside>