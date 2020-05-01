<?php
/**
 * Cron schedule
 * * * * * * /path/to/php /path/to/alert.php
 * As long this is just sending some mails, and there are no other jobs to run 
 */
require_once "src/app.php";
$app = new app();
$app->alert();
?>
