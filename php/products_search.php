<?php

  require_once '../include/init.inc.php';

  $oSmarty = new Xsmarty();

  $oColCategories = new ProdLer_Collection_Categories();
  $oSmarty->assign('aCategories',$oColCategories->ObtainHierarchy('name'));

  $oColBrands = new ProdLer_Collection_Brands();
  $oSmarty->assign('aBrands',$oColBrands->ObtainList('name','cod'));

  $oColDealers = new ProdLer_Collection_Dealers();
  $oSmarty->assign('aDealers',$oColDealers->ObtainList('alias','cod'));

  $oColProducts = new ProdLer_Collection_Products();
  $oSmarty->assign('iNumProducts',$oColProducts->Size());

  $oSmarty->display('products_search.htm.tpl');

  require_once '../include/exit.inc.php';

?>