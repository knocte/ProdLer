<?php

  require_once '../include/init.inc.php';

  $oColBrands = new ProdLer_Collection_Brands();

  $oSmarty = new Xsmarty();

  $oSmarty->assign('aBrands',$oColBrands->ObtainObjectsList());
  $oSmarty->display('brands.htm.tpl');

  require_once '../include/exit.inc.php';

?>
