          <?php $user = $this->Session->read('user'); ?>
          <header class="main-header">
            <!-- Logo -->
            <a href="/" class="logo"><img src="<?php echo ADMIN_LTE ?>dist/img/logo.png" alt="Savilerowsociety" /></a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
              <!-- Sidebar toggle button-->
              <?php /* ?>
              <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
              </a>
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                  <!-- Messages: style can be found in dropdown.less-->
                  <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-envelope-o"></i>
                      <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li class="header">You have 4 messages</li>
                      <li>
                        <!-- inner menu: contains the actual data -->
                        <ul class="menu">
                          <li><!-- start message -->
                            <a href="#">
                              <div class="pull-left">
                                <img src="<?php echo ADMIN_LTE ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
                              </div>
                              <h4>
                                Support Team
                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                              </h4>
                              <p>Why not buy a new awesome theme?</p>
                            </a>
                          </li><!-- end message -->
                          <li>
                            <a href="#">
                              <div class="pull-left">
                                <img src="<?php echo ADMIN_LTE ?>dist/img/user3-128x128.jpg" class="img-circle" alt="user image"/>
                              </div>
                              <h4>
                                AdminLTE Design Team
                                <small><i class="fa fa-clock-o"></i> 2 hours</small>
                              </h4>
                              <p>Why not buy a new awesome theme?</p>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <div class="pull-left">
                                <img src="<?php echo ADMIN_LTE ?>dist/img/user4-128x128.jpg" class="img-circle" alt="user image"/>
                              </div>
                              <h4>
                                Developers
                                <small><i class="fa fa-clock-o"></i> Today</small>
                              </h4>
                              <p>Why not buy a new awesome theme?</p>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <div class="pull-left">
                                <img src="<?php echo ADMIN_LTE ?>dist/img/user3-128x128.jpg" class="img-circle" alt="user image"/>
                              </div>
                              <h4>
                                Sales Department
                                <small><i class="fa fa-clock-o"></i> Yesterday</small>
                              </h4>
                              <p>Why not buy a new awesome theme?</p>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <div class="pull-left">
                                <img src="<?php echo ADMIN_LTE ?>dist/img/user4-128x128.jpg" class="img-circle" alt="user image"/>
                              </div>
                              <h4>
                                Reviewers
                                <small><i class="fa fa-clock-o"></i> 2 days</small>
                              </h4>
                              <p>Why not buy a new awesome theme?</p>
                            </a>
                          </li>
                        </ul>
                      </li>
                      <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                  </li>
                  <!-- Notifications: style can be found in dropdown.less -->
                  <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-bell-o"></i>
                      <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li class="header">You have 10 notifications</li>
                      <li>
                        <!-- inner menu: contains the actual data -->
                        <ul class="menu">
                          <li>
                            <a href="#">  
                              <i class="fa fa-users text-aqua"></i> 5 new members joined today
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <i class="fa fa-users text-red"></i> 5 new members joined
                            </a>
                          </li>

                          <li>
                            <a href="#">
                              <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <i class="fa fa-user text-red"></i> You changed your username
                            </a>
                          </li>
                        </ul>
                      </li>
                      <li class="footer"><a href="#">View all</a></li>
                    </ul>
                  </li>
                  <!-- Tasks: style can be found in dropdown.less -->
                  <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-flag-o"></i>
                      <span class="label label-danger">9</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li class="header">You have 9 tasks</li>
                      <li>
                        <!-- inner menu: contains the actual data -->
                        <ul class="menu">
                          <li><!-- Task item -->
                            <a href="#">
                              <h3>
                                Design some buttons
                                <small class="pull-right">20%</small>
                              </h3>
                              <div class="progress xs">
                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                  <span class="sr-only">20% Complete</span>
                                </div>
                              </div>
                            </a>
                          </li><!-- end task item -->
                          <li><!-- Task item -->
                            <a href="#">
                              <h3>
                                Create a nice theme
                                <small class="pull-right">40%</small>
                              </h3>
                              <div class="progress xs">
                                <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                  <span class="sr-only">40% Complete</span>
                                </div>
                              </div>
                            </a>
                          </li><!-- end task item -->
                          <li><!-- Task item -->
                            <a href="#">
                              <h3>
                                Some task I need to do
                                <small class="pull-right">60%</small>
                              </h3>
                              <div class="progress xs">
                                <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                  <span class="sr-only">60% Complete</span>
                                </div>
                              </div>
                            </a>
                          </li><!-- end task item -->
                          <li><!-- Task item -->
                            <a href="#">
                              <h3>
                                Make beautiful transitions
                                <small class="pull-right">80%</small>
                              </h3>
                              <div class="progress xs">
                                <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                  <span class="sr-only">80% Complete</span>
                                </div>
                              </div>
                            </a>
                          </li><!-- end task item -->
                        </ul>
                      </li>
                      <li class="footer">
                        <a href="#">View all tasks</a>
                      </li>
                    </ul>
                  </li>
                  <!-- User Account: style can be found in dropdown.less -->
                  <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <img src="<?php echo ADMIN_LTE ?>admin-default.jpg" class="user-image" alt="User Image"/>
                      <span class="hidden-xs"><?= $user['User']['first_name']; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- User image -->
                      <li class="user-header">
                        <img src="<?php echo ADMIN_LTE ?>admin-default.jpg" class="img-circle" alt="User Image" />
                        <p>
                          <?= $user['User']['full_name']; ?>
                          <small>Savilerowsociety</small>
                        </p>
                      </li>
                      <!-- Menu Body -->
                      <li class="user-body">
                        <div class="col-xs-4 text-center">
                          <a href="#">Followers</a>
                        </div>
                        <div class="col-xs-4 text-center">
                          <a href="#">Sales</a>
                        </div>
                        <div class="col-xs-4 text-center">
                          <a href="#">Friends</a>
                        </div>
                      </li>
                      <!-- Menu Footer-->
                      <li class="user-footer">
                        <div class="pull-left">
                          <a href="#" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                          <a href="#" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </nav>
           <?php */ ?> 
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

                <li class="treeview <?php echo @$this->params['action']=='blog' || @$this->params['action']=='outfit_comments' || @$this->params['action']=='add_blogpost' || @$this->params['action']=='edit_blogpost' || @$this->params['action']=='add_comments' || @$this->params['action']=='edit_comments'  ?'active':''?>">
                  <a href="#">
                    <i class="fa fa-fw fa-home"></i> <span>Home Page</span> <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li class="<?php echo @$this->params['action']=='blog' || @$this->params['action']=='add_blogpost' || @$this->params['action']=='edit_blogpost' ? 'active':''?>"><a href="/admins/blog"><i class="fa fa-circle-o"></i> Blog</a></li>
                    <li class="<?php echo @$this->params['action']=='outfit_comments' || @$this->params['action']=='add_comments' || @$this->params['action']=='edit_comments'  ?'active':''?>"><a href="/admins/outfit_comments"><i class="fa fa-circle-o"></i> Outfits Comments</a></li>
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