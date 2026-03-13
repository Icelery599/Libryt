<?php
header("Location: delete.php" . (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? "?" . $_SERVER['QUERY_STRING'] : ""));
exit();
?>
