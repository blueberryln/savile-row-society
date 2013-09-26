<?php

header("Expires: Mon, 28 Oct 2025 05:00:00 GMT");
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"" . $this->viewVars['filename'] . ".xls");
header("Content-Description: Generated Report");
?>
<?php echo $this->fetch('content'); ?>