<table cellpadding="0" cellspacing="0" border="0" style="max-width:550">
    <tr>
        <td style="background-color: #000; text-align:center; padding: 8px 0;"><img src="http://www.savilerowsociety.com/img/logo.png" alt="Savile Row Society" /></td>
    </tr>
    <tr>
        <td valign="top">
        	<br />
            Hi <?php echo $client['User']['full_name']; ?>,
            <br /><br />
            Your personal stylist just designed a new outfit for you. Click the picture to view details.
            <br /><br />
            
           	<table cellspacing="0" cellpadding="5" border="0" width="100%" style="border: 1px solid #444; border-bottom: none; border-right: none;">
                <tr>
               		<?php foreach($entities as $item) : ?>
                        <?php
                            if($item['Entity']['Image']){
                                $img_src = Router::url('/', true) . 'products/resize/' . $item['Entity']['Image'][0]['name'] . '/110/149'; 
                            }
                            else{
                                $img_src = Router::url('/', true) . "img/image_not_available-small.png";
                            } 
                            $url = Router::url('/', true) . $item['Entity']['id'];
                        ?>
                        <td><a href="<?php echo $url; ?>"><img src="<?php echo $img_src; ?>" /></a></td>
                    <?php endforeach; ?>
                </tr>
           	</table>
            
            <br /><br />
            For any queries please contact us at, <a href="mailto:admin@savilerowsociety.com">admin@savilerowsociety.com</a>
            <br /><br />
            Best,
            <br/>
            <a href="http://www.savilerowsociety.com">Savile Row Society</a>
            <br /><br /><br />
        </td>
    </tr>
</table>