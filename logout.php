<?php
// ABSOLUTELY NOTHING before this line
ob_start();
session_start();
session_unset();
session_destroy();

// DEBUG: Use absolute URL if relative doesn't work
header("Location: http://localhost/AQUASENSEBD/index.php?logout=success");
exit();
ob_end_flush();
?>
