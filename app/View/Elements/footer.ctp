
<style>
    .hidden-from-view { left: -5000px; position: absolute; }
    .ie-lte7 .hidden-from-view {display:none;}
    html[dir=rtl] .hidden-from-view{
            right:-5000px;
            left:auto;
        }
</style>

        <!-- footer_wrapper -->
        <div class="footer_wrapper">
            <div class="center_row">

                <!-- column -->
                <div class="column">
                    <div class="section-one">
                        <a href="#">
                            <img src="<?php echo HTTP_ROOT ?>img/home/footer_logo.jpg" alt="Savil.Me" />
                        </a>
                        <span>&copy; Savile Row Society 2015</span>
                    </div>
                </div>
                <!-- /column -->


                <!-- column -->
                <div class="column">
                    <div class="section-two">
                        <button class="btn-vip_access" id="block-vip-access">VIP ACCESS</button>
                        <ul>
                            <li><a href="http://www.savilerowsociety.com/blog" class="blogList">Blog</a></li>
                            <li><a href="#">Facebook</a></li>
                            <li><a href="#">Instagaram</a></li>
                            <li><a href="#">Twitter</a></li>
                        </ul>
                    </div>
                </div>
                <!-- /column -->


                <!-- column -->
                <div class="column">
                    <div class="section-three">
                        <ul>
                            <li><a href="<?php echo $this->webroot; ?>#two">About Us</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>company/team">Our Team</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>company/brands">Our Brands</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>contact">Contact Us</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>faq">FAQ</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>company/privacy">Privacy</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>company/terms">Terms</a></li>
                        </ul>
                    </div>
                </div>
                <!-- /column -->

                <!-- column -->
                <div class="column last">
                    <div class="section-four">
                        <h2>Sign Up For Savile.me News</h2>
                        <form action="http://savilerowsociety.us8.list-manage2.com/subscribe/post" method="POST">
                                <input type="hidden" name="u" value="88bda5a8e85fc9df8f8b8f5b2">
                                <input type="hidden" name="id" value="6c6fbf69c3">
                                <input type="hidden" name="MERGE1" id="MERGE1" size="25" value="null">
                                <input type="hidden" name="MERGE2" id="MERGE2" size="25" value="null">
                                <input type="email" autocapitalize="off" autocorrect="off" name="MERGE0" id="MERGE0" size="25" value="" placeholder ="Your email address">
                                <div class="hidden-from-view"><input type="text" name="b_88bda5a8e85fc9df8f8b8f5b2_6c6fbf69c3" tabindex="-1" value=""></div>
                                <input type="submit" class="btn-sign_up" name="submit" value="Sign Up">
                        </form>
                    </div>
                </div>
                <!-- /column -->
            </div>
        </div>
        <!-- /footer_wrapper -->
