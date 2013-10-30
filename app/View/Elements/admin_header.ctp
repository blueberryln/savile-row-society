<div class="header">
    <div class="container">
        <div style="padding-top: 16px;">
        </div>
        <div class="sixteen columns text-center" style="height: 75px;">

            <!--            <div class="banner"></div> -->
            <a href="<?php echo $this->request->webroot; ?>" style="display: inline-block;"><img class="logo" src="<?php echo $this->request->webroot; ?>img/srs_logo_white.png" alt="Savile Row Society" title="Savile Row Society" /></a>
        </div>
        <div class="sixteen columns alpha omega menu">
            <ul>
                <li>
                    <a href="<?php echo $this->request->webroot; ?>admin/users">Users</a>
                    <ul class="submenu">
                        <li><a href="<?php echo $this->request->webroot; ?>admin/users/newusers">New Users</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>admin/users/export">Export</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo $this->request->webroot; ?>admin/products">Products</a>
                    <ul class="submenu">
                        <li><a href="<?php echo $this->request->webroot; ?>admin/products/add">Add New Product</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo $this->request->webroot; ?>admin/brands">Brands</a>
                    <ul class="submenu">
                        <li><a href="<?php echo $this->request->webroot; ?>admin/brands/add">Add New Brand</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo $this->request->webroot; ?>admin/colors">Colors</a>
                    <ul class="submenu">
                        <li><a href="<?php echo $this->request->webroot; ?>admin/colors/add">Add New Color</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo $this->request->webroot; ?>admin/sizes">Sizes</a>
                    <ul class="submenu">
                        <li><a href="<?php echo $this->request->webroot; ?>admin/sizes/add">Add New Size</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo $this->request->webroot; ?>admin/categories">Categories</a>
                    <ul class="submenu">
                        <li><a href="<?php echo $this->request->webroot; ?>admin/categories/add">Add New Category</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo $this->request->webroot; ?>admin/seasons">Seasons</a>
                    <ul class="submenu">
                        <li><a href="<?php echo $this->request->webroot; ?>admin/seasons/add">Add New Seasons</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo $this->request->webroot; ?>admin/orders">Orders</a>
                    <ul class="submenu">
                        <li><a href="<?php echo $this->request->webroot; ?>admin/orders/items">Ordered Items</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" title="Account"><img src="<?php echo $this->request->webroot; ?>img/profile-icon.png" alt="Account" /></a>
                    <ul class="submenu">
                        <li><a href="<?php echo $this->request->webroot; ?>">View website</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>signout">Sign out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>