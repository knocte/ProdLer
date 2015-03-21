<?php

  require_once '../../include/init.inc.php';

  $oSmarty = new Xsmarty();

  $oColCategories = new ProdLer_Collection_Categories();
  $oSmarty->assign('aCategories',$oColCategories->ObtainHierarchy('name'));
  $oSmarty->assign('iNumCategories',$oColCategories->Size());

  $oSmarty->display('form_categories.htm.tpl');

  require_once '../../include/exit.inc.php';

?>