<?php

  require_once '../include/init.inc.php';

  $oColBrands = new ProdLer_Collection_Brands();
  $oColCategories = new ProdLer_Collection_Categories();
  $oColProducts = new ProdLer_Collection_Products();

  $oSmarty = new Xsmarty();

  $oSmarty->assign('iNumBrands',$oColBrands->Size());  
  $oSmarty->assign('iNumCategories',$oColCategories->Size());
  $oSmarty->assign('iNumProducts',$oColProducts->Size());
  $oSmarty->display('index.htm.tpl');

  require_once '../include/exit.inc.php';

?>
