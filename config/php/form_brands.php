<?php

  require_once '../../include/init.inc.php';

  $oSmarty = new Xsmarty();

  $oColBrands = new ProdLer_Collection_Brands();

  $oSmarty->assign('aBrands',$oColBrands->ObtainList('name','cod'));
  $oSmarty->assign('iNumBrands',$oColBrands->Size());
  $oSmarty->display('form_brands.htm.tpl');

  require_once '../../include/exit.inc.php';

?>