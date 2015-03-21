<?php

  require_once '../include/init.inc.php';

  $_DATA = $_REQUEST;
  $sOption = WhichOption($_DATA,'btnCodeSearch','btnBoth',
                         'btnAssociationSearch','btnTextSearch');

  $oSmarty = new Xsmarty();

  $oSmarty->assign('sCurrencySymbol',ProdLer_Variable::Get('Currency_Symbol'));

  switch ($sOption) {
    case 'btnCodeSearch':
      $sDisplay='error.htm.tpl';

      if (IsNothing($_DATA['txtCodeSearch'])){
        $oSmarty->assign('sMessage',
                         _('You have to write some number to search a particular product')
                         .'.');
        $oSmarty->assign('sReturn','products_search.php');
      }
      else if((!is_numeric($_DATA['txtCodeSearch']))
               ||(strlen($_DATA['txtCodeSearch'])>48)){
        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
        $oSmarty->assign('sReturn','products_search.php');
      }
      else{
        $oColProducts = new ProdLer_Collection_Products();
        $oProduct = $oColProducts->ObtainObject('cod',$_DATA['txtCodeSearch']);
        if (!$oProduct){
          $oSmarty->assign('sMessage',_('Product not found').'.');
          $oSmarty->assign('sReturn','products_search.php');
        }
        else{
          $oSmarty->assign('oProduct',$oProduct);

          $oSmarty->assign('sDateCreated',CustomDate($oProduct->aDateCreated));
          $oSmarty->assign('sDateModified',CustomDate($oProduct->aDateModified));

          $sDisplay='product.htm.tpl';
        }
      }

      break;

    case 'btnAssociationSearch':
      $sDisplay='error.htm.tpl';

      if (IsNothing($_DATA['selCategory'])||
          InvalidWhenDefined($_DATA['selCategory'])||
          InvalidWhenDefined($_DATA['selBrand'])){

        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
        $oSmarty->assign('sReturn','products_search.php');
      }
      else{
        if ($_DATA['selCategory']==0)
          $oColProducts = new ProdLer_Collection_Products();
        else{
          $oColCategories = new ProdLer_Collection_Categories();
          $oCategory = $oColCategories->ObtainObject('cod',$_DATA['selCategory']);

          $oColProducts = $oCategory->GetProductsCollection(TRUE);
        }

        if ($_DATA['selBrand']!=0)
          $oColProducts->Limit('brand',$_DATA['selBrand']);

        $oSmarty->assign('aProducts',$oColProducts->ObtainObjectsList());

        $sDisplay='products.htm.tpl';

      }
      break;

    case 'btnTextSearch':
      $sDisplay='error.htm.tpl';

      if (IsNothing($_DATA['txtTextSearch'])){
        $oSmarty->assign('sMessage',_('You have to write some string to make search').'.');
        $oSmarty->assign('sReturn','form_products.php');
      }
      else if (strlen($_DATA['txtTextSearch'])>48){
        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
        $oSmarty->assign('sReturn','form_products.php');
      }
      else{
        $oColProducts = new ProdLer_Collection_Products();

        $oColProducts->AddSearchField('model');
        $oColProducts->AddSearchField('description');
        $oColProducts->AddSearchField('characts');
        $oColProducts->AddSearchField('specs');

        $oColProducts->AddSearchTerms(stripslashes($_DATA['txtTextSearch']));

        $oSmarty->assign('aProducts',$oColProducts->ObtainObjectsList());
        $oSmarty->assign('sSource',_('found'));

        $sDisplay='products.htm.tpl';
      }

      break;

    case 'btnBoth':
      $sDisplay='error.htm.tpl';

      if (IsNothing($_DATA['selCategory'])||
          IsNothing($_DATA['selBrand'])||
          !is_numeric($_DATA['selCategory'])||
          ($_DATA['selCategory']<0)||
          (strlen($_DATA['selCategory'])>48)||
          !is_numeric($_DATA['selBrand'])||
          ($_DATA['selBrand']<0)||
          (strlen($_DATA['selBrand'])>48)){

        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
        $oSmarty->assign('sReturn','products_search.php');
      }
      else if (IsNothing($_DATA['txtTextSearch'])){
        $oSmarty->assign('sMessage',_('You have to write some string to make search').'.');
        $oSmarty->assign('sReturn','form_products.php');
      }
      else if (strlen($_DATA['txtTextSearch'])>48){
        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
        $oSmarty->assign('sReturn','form_products.php');
      }
      else{
        if ($_DATA['selCategory']==0)
          $oColProducts = new ProdLer_Collection_Products();
        else{
          $oColCategories = new ProdLer_Collection_Categories();
          $oCategory = $oColCategories->ObtainObject('cod',$_DATA['selCategory']);

          $oColProducts = $oCategory->GetProductsCollection(TRUE);
        }

        if ($_DATA['selBrand']!=0)
          $oColProducts->Limit('brand',$_DATA['selBrand']);

        $oColProducts->AddSearchField('model');
        $oColProducts->AddSearchField('description');
        $oColProducts->AddSearchField('characts');
        $oColProducts->AddSearchField('specs');

        $oColProducts->AddSearchTerms(stripslashes($_DATA['txtTextSearch']));

        $oSmarty->assign('aProducts',$oColProducts->ObtainObjectsList());

        $sDisplay='products.htm.tpl';

      }
      break;


    default:
      $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
      $oSmarty->assign('sReturn','form_products.php');
      $sDisplay='error.htm.tpl';
      break;
  }

  $oSmarty->display($sDisplay);

  require_once '../include/exit.inc.php';

?>
