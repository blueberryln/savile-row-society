<?php
header("Content-Type: application/pdf");
header('Content-Disposition:attachment; filename="order.pdf"');
?>
<?php echo $this->fetch('content'); ?>