<?php

  require_once '../include/init.inc.php';

  $_DATA = $_REQUEST;

  if (!$_DATA['cod'])
    Redirect('products_search.php');

  $oColProducts = new Prodler_Collection_Products();
  $oProduct = $oColProducts->ObtainObject('cod',$_DATA['cod']);

  $oSmarty = new Xsmarty();

  $sDisplay = 'product.htm.tpl';

  if (!$oProduct){
    $sDisplay = 'error.htm.tpl';

    $oSmarty->assign('sMessage',_('Product not found'));
    $oSmarty->assign('sReturn','products_search.php');
  }
  else{
    $oSmarty->assign('oProduct',$oProduct);
    $oSmarty->assign('sCurrencySymbol',ProdLer_Variable::Get('Currency_Symbol'));
  }

  $oSmarty->display($sDisplay);

  require_once '../include/exit.inc.php';

?>
