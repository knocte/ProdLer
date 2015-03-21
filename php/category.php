<?php

  require_once '../include/init.inc.php';

  $_DATA = $_REQUEST;

  $oColCategories = new Prodler_Collection_Categories();
  $oCategory = $oColCategories->ObtainObject('cod',$_DATA['cod']);

  $oSmarty = new Xsmarty();

  $sDisplay = 'products.htm.tpl';

  if (!$oCategory){
    $sDisplay = 'error.htm.tpl';

    $oSmarty->assign('sMessage',_('Category not found'));
    $oSmarty->assign('sReturn','categories.php');
  }
  else{
    $oColCategories =& $oCategory->GetSubcategoriesCollection(FALSE);
    $oColProducts =& $oCategory->GetProductsCollection(FALSE);

    $oSmarty->assign('oCategory',$oCategory);
    $oSmarty->assign('aProducts',$oColProducts->ObtainObjectsList());
    $oSmarty->assign('aCategories',$oColCategories->ObtainObjectsList());
    $oSmarty->assign('sCurrencySymbol',ProdLer_Variable::Get('Currency_Symbol'));

    if (ProdLer_Variable::Get('Tax') == 2)
      $oSmarty->assign('sTaxSentence',ProdLer_Variable::Get('Tax_Sentence'));
  }

  $oSmarty->display($sDisplay);

  require_once '../include/exit.inc.php';

?>
