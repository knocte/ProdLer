<?php

  require_once '../../include/init.inc.php';

  $oSmarty = new Xsmarty();

  $oSmarty->assign('sLogin',$_SERVER['REMOTE_USER']);
  $oSmarty->display('index.htm.tpl');

  require_once '../../include/exit.inc.php';

?>
