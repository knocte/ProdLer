<?php

  $bNotCheckStatus = TRUE;

  require_once '../../include/init.inc.php';

  $sCompanyName = 'ProdLer';
  $sCompanyURL = '';

  $oSmarty = new Xsmarty();
  $oSmarty->assign('sCompanyName',$sCompanyName);
  $oSmarty->assign('sCompanyURL',$sCompanyURL);
  $oSmarty->display('form_name.htm.tpl');

  //Not needed here
  //require_once '../../include/exit.inc.php';

?>