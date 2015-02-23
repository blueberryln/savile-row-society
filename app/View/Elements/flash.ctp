<div id="flash-box" class="hide box-modal">
    <div class="box-modal-inside">
        <a class="notification-close" href=""></a>
        <div class="notification-msg">
            <?php
                if(isset($title)){
                    echo "<span class='heading'>" . $title . "</span>";
                }
            ?>
            <?php echo $message; ?>
        </div>
    </div>
</div>