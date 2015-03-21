<?php

  require_once '../include/init.inc.php';

  $_DATA = $_REQUEST;

  $oColBrands = new Prodler_Collection_Brands();
  $oBrand = $oColBrands->ObtainObject('cod',$_DATA['cod']);
  
  $oColProducts =& $oBrand->GetProductsCollection(FALSE);

  $oSmarty = new Xsmarty();

  $oSmarty->assign('oBrand',$oBrand);
  $oSmarty->assign('aProducts',$oColProducts->ObtainObjectsList());
  $oSmarty->assign('sCurrencySymbol',ProdLer_Variable::Get('Currency_Symbol'));
  $oSmarty->display('products.htm.tpl');

  require_once '../include/exit.inc.php';

?>
