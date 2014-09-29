<div class="header">
    <div class="container">
        <div style="padding-top: 3px;">
        </div>
        <div class="sixteen columns text-center">

            <!--            <div class="banner"></div> -->
            <a href="<?php echo $this->request->webroot; ?>" style="display: inline-block;"><img class="logo" src="<?php echo $this->request->webroot; ?>img/srs_logo_white.png" alt="Savile Row Society" title="Savile Row Society" /></a>
            <span class="tagline" style="visibility: visible">Meet Your Personal Stylist Now!</span>
        </div>
        <div class="sixteen columns alpha omega menu">
            <ul>
                <li>
                    <a href="<?php echo $this->request->webroot; ?>admin/users">Users</a>
                    <ul class="submenu">
                        <!-- <li><a href="<?php echo $this->request->webroot; ?>admin/users/newusers">New Users</a></li> -->
                        <li><a href="<?php echo $this->request->webroot; ?>admin/users/stylist">Stylist</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>admin/stylists/topstylist">Top Stylists</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>admin/users/export">Export</a></li>
                    </ul>
                </li>
                <!--stylish- profile-->
                <li>
                    <a href="<?php echo $this->request->webroot; ?>admin/styles">Style Profile</a>
                    <ul class="submenu">
                        <li><a href="<?php echo $this->request->webroot; ?>admin/styles/add">Add New Style</a></li>
                    </ul>
                </li>
                <!--stylish profile end-->
                
                <li>
                    <a href="<?php echo $this->request->webroot; ?>admin/products">Products</a>
                    <ul class="submenu">
                        <li><a href="<?php echo $this->request->webroot; ?>admin/products/add">Add New Product</a></li>
                        <!--bhashit code-->
                        <li><a href="<?php echo $this->request->webroot; ?>admin/products/outfitlist">Outfits</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>admin/products/highlightoutfit">Highlighted Outfits</a></li>
                        <!--bhashit code end-->
                        <li><a href="<?php echo $this->request->webroot; ?>admin/lifestyles">LifeStyles</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>admin/products/export">Export</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>admin/products/googlecsv">Google Shopping Export</a></li>
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
                        <li><a href="<?php echo $this->request->webroot; ?>admin/colors">Colors</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>admin/colors/add">Add New Color</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>admin/colorgroups">Color Groups</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>admin/colorgroups/add">Add New Color Group</a></li>
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