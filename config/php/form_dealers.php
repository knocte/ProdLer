<?php

  require_once '../../include/init.inc.php';

  $oColDealers = new ProdLer_Collection_Dealers();

  $oSmarty = new Xsmarty();
  $oSmarty->assign('aDealers',$oColDealers->ObtainList('alias','cod'));
  $oSmarty->assign('iNumDealers',$oColDealers->Size());

  $oSmarty->display('form_dealers.htm.tpl');

  require_once '../../include/exit.inc.php';

?>