<?php
$script = '
    var country = "' . $this->request->data['billing']['billcountry'] . '",
        baseUrl = "' . Router::url('/', true) . '";
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script('payment.js', array('inline' => false));
$this->Html->meta('description', 'First mover', array('inline' => false));
?>
<div class="content-container">
    <div class="eleven columns container content inner">
        <div class="twelve columns container left message-box">
            <div class="blank-space">&nbsp;</div>
            <div class="eleven columns container">
                <div class="container content inner payment">	    
                    <?php echo $this->Form->create("billing", array('url' => Router::url('/', true) . 'payment')); ?>

                    <div id="step-1">
                        <div class="ten columns text-center page-heading">
                            <h1>ORDER INFORMATION</h1>
                        </div> 
                        <div class="ten columns my-cart center-block">
                            <?php if ($cart_list) : ?>
                                <table class="cart-checkout" cellpadding="0" cellspacing="1">
                                    <thead>
                                        <th></th>
                                        <th></th>
                                        <th class="text-left" width="457">Products</th>
                                        <th width="90px">Quantity</th>
                                        <th width="90px">Unit Price</th>
                                        <th width="90px" class="text-right">Price</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cart_list as $item) : ?>
                                            <tr>
                                                <td class="v-top">
                                                    <input type="hidden" class="cart-item-id" value="<?php echo $item['CartItem']['id']; ?>"> &nbsp; &nbsp;
                                                </td>
                                                <?php 
                                                    if($item['Image']){
                                                        $img_src = HTTP_ROOT . "files/products/" . $item['Image'][0]['name'];
                                                    }
                                                    else{
                                                        $img_src = HTTP_ROOT . "img/photo_not_available.png";
                                                    }
                                                ?>
                                                <td class="product-thumb"><div class="cart-thumbnail"><a href="<?php echo $this->webroot; ?>product/<?php echo $item['Entity']['id'] . '/' . $item['Entity']['slug'];?>"><img src="<?php echo $img_src; ?>" /></a></div></td>
                                                <td class="v-top">
                                                    <h6><a href="<?php echo $this->webroot; ?>product/<?php echo $item['Entity']['id'] . '/' . $item['Entity']['slug'];?>"><?php echo $item['Entity']['name']; ?></a></h6>
                                                    <?php
                                                        $description = String::truncate($item['Entity']['description'], 25, array('ellipsis' => '...', 'exact' => true, 'html' => false));
                                                    ?>
                                                    <small class="description"><?php echo $description; ?></small>
                                                    <small class="description">SIZE: <?php echo $item['Size']['name']; ?></small>
                                                    <?php if($item['Color'] && count($item['Color']) > 0) : ?>
                                                        <small class="description">Color:
                                                            <?php
                                                                for($i = 0; $i < count($item['Color']); $i++){
                                                                    if((count($item['Color'])-1) == $i){
                                                                        echo $item['Color'][$i]['name'];
                                                                    }
                                                                    else{
                                                                        echo $item['Color'][$i]['name'] . '/ ';
                                                                    }
                                                                }
                                                            ?>
                                                        </small>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center"><?php echo $item['CartItem']['quantity']; ?></td>
                                                <td class="text-center"><?php echo $this->Number->currency($item['Entity']['price']); ?></td>
                                                <td class="text-right item-price"><?php echo $this->Number->currency($item['Entity']['price'] * $item['CartItem']['quantity']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <tr class="last">
                                            <td colspan="3" rowspan="3">
                                                <!-- Enable only when total is equal or more than $120 -->
                                                <?php //if($cart_total >= 120 && !$vip_flag && !$landing_flag) :	//before changes ?> 
                                                <?php if($cart_total >= 120 && (!$vip_flag || !$landing_flag)) : //after changes --shubham ?>
                                                    <div class= "promo-code-cont">
                                                        <div class="srs-form columns four left" style="margin-left:10px;">
                                                            <div class="form">
                                                               <div class="input text" style="margin-bottom: 0;">
                                                                    <?php
                                                                        echo $this->Form->input('promocode', array('div'=> false, 'label'=> false, 'id'=>'promocode', 'style' => 'letter-spacing:1px;', 'autocomplete' => 'off', 'placeholder' => 'Promo Code', 'onkeypress' => 'return isAlphaNumber(event)'));
                                                                    ?>
                                                               </div>
                                                               <a href="" class="remove-pc hide">Remove Promo Code</a>                    
                                                            </div>
                                                        </div>
                                                        <div class="srs-form columns two left">
                                                            <div class="form">
                                                                <div class="input text" style="margin-bottom: 0;">
                                                                    <a href="#" id="apply-promo" class="link-btn black-btn " style="padding: 6.5px 15px; margin:0 0 0 10px; width: auto; ">Apply</a>
                                                                </div>                   
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <?php
                                                if ($landing_flag):
                                                $cart_total = $cart_total - $user_offer['UserOffer']['discount'];
                                            ?> 
                                                <td colspan="2" class="text-right bold">(-) Discount:</td>
                                                <td class="text-right cart-discount">
                                                    <?php echo $this->Number->currency($user_offer['UserOffer']['discount']); ?>
                                                    <input type="hidden" name="offer-discount" value="<?php echo $user_offer['UserOffer']['discount']; ?>" />
                                                </td>
                                            <?php
                                                elseif($cart_total >= 250 && $vip_flag) : 
                                                $cart_total = $cart_total - 50;
                                            ?>
                                                <td colspan="2" class="text-right bold">(-) Discount:</td>
                                                <td class="text-right cart-discount">
                                                    <?php echo $this->Number->currency(50); ?>
                                                    <input type="hidden" name="vip-discount" value="50" />
                                                </td>
                                            <?php else : ?>
                                                <td colspan="2" class="text-right bold">(-) Discount:</td>
                                                <td class="text-right cart-discount"><?php echo $this->Number->currency(0); ?></td>
                                            <?php endif; ?>

                                        </tr>
                                        <tr class="last">
                                            <td colspan="2" class="text-right bold">(+) Tax<span class="cart-tax-percent"></span>:</td>
                                            <td class="text-right cart-tax"><?php echo $this->Number->currency(0); ?></td>
                                        </tr>
                                        <tr class="last">
                                            <td colspan="2" class="text-right bold">Total Amount:</td>
                                            <td class="text-right cart-total"><?php echo $this->Number->currency($cart_total); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" name="checkout-cart-id" value="<?php echo $cart_id; ?>" />
                                <input type="hidden" name="checkout-tax" id="checkout-tax"  value="0" />
                                <input type="hidden" name="checkout-initial-price" id="checkout-initial-price"  value="<?php echo $grand_total;  // $cart_total was the variable used initially --shubham ?>" />
                                <input type="hidden" name="checkout-total-price" id="checkout-total-price"  value="<?php echo $cart_total; ?>" />
                            <?php endif; ?>
                            <div class="clear-fix"></div>
                        </div>
                    </div>
                    <div class="profile text-center continue-block">
                        <br>
                        <a class="link-btn black-btn" id="continue-1" tabindex="25" href="">Continue</a>
                        <p class="loader hide"><img src="<?php echo HTTP_ROOT; ?>img/loader.gif"></p>
                    </div>


                    <div id="step-2" class="hide">
                        <div class="ten columns text-center page-heading" id="billing-data-head">
                            <h1 class="sub">BILLING INFORMATION</h1>
                        </div> 

                        <div class="contact-container billing-shipping ten columns center-block" id="billing-data">
                            <div class="srs-form columns five left">            
                                <div class="form">
                                    <div class="input text required">
                                        <?php
                                            echo $this->Form->input('billfirst_name', array('label'=>'First Name','required'=>'required', 'id'=>'billFirstName', 'maxlength'=>'45', 'tabindex'=>'5'));
                                        ?>
                                    </div>

                                    <div class="input text required">
                                        <?php
                                            echo $this->Form->input('billcompany', array('label'=>'Company', 'id'=>'billCompany', 'maxlength'=>'45', 'tabindex'=>'7'));
                                        ?>
                                    </div>

                                    <div class="input text required">
                                        <?php
                                            echo $this->Form->input('billaddress', array('label'=>'Address','required'=>'required', 'id'=>'billAddress', 'tabindex'=>'9', 'maxlength'=>'255'));
                                        ?>
                                    </div>

                                    <div class="input text required">
                                        <?php
                                            echo $this->Form->input('billstate', array('label'=>'State/Province','required'=>'required', 'id'=>'billState', 'tabindex'=>'11', 'maxlength'=>'45'));
                                        ?>
                                    </div>

                                    <div class="input text required">
                                        <?php
                                            //echo $this->Form->select('billcountry', $country_list, array('options' => $country_list, 'empty' => 'PLEASE SELECT ONE COUNTRY', 'selected' => true, 'value' => $this->request->data['billing']['billcountry']));
                                        ?>
                                        <label for="billCountry">Country</label>
                                        <select required="required" id="billCountry" tabindex="13" name="data[billing][billcountry]">
                                            <option value="">SELECT COUNTRY</option>
                                            <option value="USA">USA</option>
                                            <option value="CAN">CANADA</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="srs-form columns five right">
                                <div class="form form1">   
                                     <div class="input text required">
                                         <?php
                                            echo $this->Form->input('billlast_name', array('label'=>'Last Name','required'=>'required', 'id'=>'billLastName', 'tabindex'=>'6', 'maxlength'=>'45'));
                                         ?>
                                     </div>

                                     <div class="input text required">
                                         <?php
                                            echo $this->Form->input('billemail', array('label'=>'Email', 'id'=>'billEmail', 'maxlength'=>'255', 'tabindex'=>'8', 'readonly'=>'readonly'));
                                         ?>
                                     </div>

                                     <div class="input text required">
                                         <?php
                                            echo $this->Form->input('billcity', array('label'=>'City','required'=>'required', 'id'=>'billCity', 'tabindex'=>'10', 'maxlength'=>'45'));
                                         ?>
                                     </div>

                                     <div class="input text required">
                                         <?php
                                            echo $this->Form->input('billzip', array('label'=>'Zipcode','required'=>'required', 'id'=>'billZip', 'tabindex'=>'12', 'maxlength'=>'16'));
                                         ?>
                                     </div>

                                     <div class="input text required">
                                         <?php
                                            echo $this->Form->input('billphone', array('label'=>'Phone', 'required' => 'required', 'id'=>'billPhone', 'tabindex'=>'14', 'maxlength'=>'45'));
                                         ?>
                                     </div>
                                </div>  
                            </div>
                                <div class="clear-fix"></div>   
                        </div>
                        <div class="divider"></div>

                        <div class="ten columns text-center page-heading" id="shipping-data-head">
                            <h1 class="sub">SHIPPING INFORMATION</h1>

                            <h6 class="ten columns offset-by-two alpha omega text-left"><?php echo $this->Form->checkbox('copybilling', array('label' => false, 'type' => 'checkbox','tabindex'=>'16', 'class' => 'copy-billing-info', 'style' => 'width: auto;' )); ?> Same as Billing Information</h6>
                        </div>
                        <div class="clear-fix"></div>
                        <div class="contact-container billing-shipping shipping-data ten columns center-block" id="shipping-data">
                            <div class="srs-form columns five left">
                                <div class="form">
                                    <div class="input text required">
                                        <?php
                                        echo $this->Form->input('shipfirst_name', array('label'=>'First Name','required'=>'required', 'id'=>'shipFirstName', 'tabindex'=>'17', 'maxlength'=>'45'));
                                        ?>
                                    </div>

                                    <div class="input text required">
                                        <?php
                                        echo $this->Form->input('shipcompany', array('label'=>'Company', 'id'=>'shipCompany', 'tabindex'=>'19', 'maxlength'=>'45'));
                                        ?>
                                    </div>

                                    <div class="input text required">
                                        <?php
                                        echo $this->Form->input('shipaddress', array('label'=>'Address','required'=>'required', 'id'=>'shipAddress', 'tabindex'=>'21', 'maxlength'=>'255'));
                                        ?>
                                    </div>

                                    <div class="input text required">
                                        <?php
                                        echo $this->Form->input('shipzip', array('label'=>'Zipcode','required'=>'required', 'id'=>'shipZip', 'tabindex'=>'23', 'maxlength'=>'16'));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="srs-form columns five right">
                                <div class="form form1">
                                    <div class="input text required">
                                        <?php
                                            echo $this->Form->input('shiplast_name', array('label'=>'Last Name','required'=>'required', 'id'=>'shipLastName', 'tabindex'=>'18', 'maxlength'=>'45'));
                                        ?>
                                    </div>

                                    <div class="input text required">
                                        <?php
                                            echo $this->Form->input('shipcity', array('label'=>'City','required'=>'required', 'id'=>'shipCity', 'tabindex'=>'20', 'maxlength'=>'45'));
                                        ?>
                                    </div>

                                    <div class="input text required">
                                        <?php
                                            echo $this->Form->input('shipstate', array('label'=>'State/Province','required'=>'required', 'id'=>'shipState', 'tabindex'=>'22', 'maxlength'=>'45'));
                                        ?>
                                    </div>

                                    <div class="input text required">
                                        <label for="billCountry">Country</label>
                                        <select required="required" tabindex="24" id="shipCountry" name="data[billing][shipcountry]">
                                            <option value="">SELECT COUNTRY</option>
                                            <option value="USA">USA</option>
                                            <option value="CAN">CANADA</option>
                                        </select>
                                    </div>                              
                                </div>  
                            </div> <div class="clear-fix"></div>
                        </div>
                        <div class="profile text-center continue-block">
                            <br>
                            <a class="link-btn black-btn" id="continue-2" tabindex="25" href="">Continue</a>
                            <p class="loader hide"><img src="<?php echo HTTP_ROOT; ?>img/loader.gif"></p>
                        </div>
                    </div>




                    <div id="step-3" class="hide">

                        <div class="ten columns text-center page-heading pay-info">
                            <h1 class="sub">PAYMENT INFORMATION</h1>
                        </div>    

                        <div class="ten columns center-block">
                            <div class="card-strip text-center">
                                <img src="<?php echo HTTP_ROOT; ?>img/credit-card-strip.jpg"/>                   
                            </div>
                        </div>

                        <div class="card-expiration ten columns center-block" id="card-data">
                            <div class="srs-form columns four">
                                <div class="form">
                                       <div class="input text required card-number">
                                                <?php
                                                    echo $this->Form->input('billcardnumber', array('label'=>'Card Number','required'=>'required', 'id'=>'billCardNumber', 'maxlength'=>'16', 'tabindex'=>'1', 'onkeypress' => 'return isNumber(event)', 'style' => 'letter-spacing:1px;', 'autocomplete' => 'off'));
                                                ?>
                                                <small>*(enter number without spaces or dashes)</small> 
                                       </div>                    
                                </div>
                            </div>
                            <div class="srs-form columns two">
                                <div class="form">
                                       <div class="input text required">
                                                <?php
                                                    echo $this->Form->input('billcardcode', array('label'=>'CVV/ CVV2','required'=>'required', 'id'=>'billCardCode', 'maxlength'=>'4', 'tabindex'=>'2', 'autocomplete' => 'off'));
                                                ?>
                                       </div>                    
                                </div>
                            </div>
                            <div class="srs-form columns two">
                                <div class="form">
                                       <div class="input text required">
                                                <label>Expiration Date</label>
                                                <?php echo $this->Form->month('exp', array('empty' => 'Month', 'monthNames' => false, 'tabindex'=>'3', 'required')); ?>
                                                <small>*(mm)</small>                            
                                       </div>                    
                                </div>
                            </div>
                            <div class="srs-form columns two">
                                <div class="form">
                                       <div class="input text required">
                                                <label for="ExpirationDate">&nbsp;</label>
                                                <?php echo $this->Form->year('exp', date('Y'), date('Y', strtotime('+10 year')), array('orderYear' => 'asc', 'empty' => 'Year', 'tabindex'=>'4', 'required')); ?>
                                                <small>*(yyyy)</small>
                                       </div>                    
                                </div>
                            </div>
                        </div>

                        <div class="contact-container ten columns center-block continue-block">
                            <div class="profile text-center" >
                                <a class="link-btn black-btn" id="confirm-payment" tabindex="25" href="">Make Payment</a>
                                <br>
                                <p class="loader hide clear-fix"><img src="<?php echo HTTP_ROOT; ?>img/loader.gif"></p><br>
                            </div>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>