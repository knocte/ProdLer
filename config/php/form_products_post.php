<?php

  require_once '../../include/init.inc.php';

  $_DATA = $_POST;
  $sOption = WhichOption($_DATA,'btnAdd','btnMod','btnDel',
                         'btnShow','btnCodeSearch',
                         'btnAssociationSearch','btnTextSearch');

  $oSmarty = new Xsmarty();

  switch ($sOption) {
    case 'btnAdd':
      $sDisplay='form_product.htm.tpl';
      $oSmarty->assign('sDealerIDName',Prodler_Variable::Get('Dealer_ID_Name'));

      $oSmarty->assign('sAccessType',_('Product creation'));
      $oSmarty->assign('iProductCod','0');

      $oColCategories = new ProdLer_Collection_Categories();
      $oColBrands = new ProdLer_Collection_Brands();
      $oColDealers = new ProdLer_Collection_Dealers();

      $oSmarty->assign('aBrands',$oColBrands->ObtainList('name','cod'));
      $oSmarty->assign('aCategories',$oColCategories->ObtainHierarchy('name'));
      $oSmarty->assign('aDealers',$oColDealers->ObtainList('alias','cod'));

      if (!IsNothing($_DATA['hidBrandCod'])){
        $oSmarty->assign('iBrandType',1);
        $oSmarty->assign('iProductBrand',$_DATA['hidBrandCod']);
      }

      if (!IsNothing($_DATA['hidCategoryCod'])){
        $oSmarty->assign('iProductCategory',$_DATA['hidCategoryCod']);
      }
      $oSmarty->assign('sCurrencySymbol',ProdLer_Variable::Get('Currency_Symbol'));
      $oSmarty->assign('iNumProvisions',0);


      break;
    case 'btnMod':
      if (IsNothing($_DATA['selProduct'])){
        $oSmarty->assign('sMessage',
                         _('You have to select a particular product to modify an entry')
                         .'.');
        $oSmarty->assign('sReturn','form_products.php');
        $sDisplay='error.htm.tpl';
      }
      else if (InvalidWhenDefined($_DATA['selProduct'],1)){

        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
        $oSmarty->assign('sReturn','form_products.php');
        $sDisplay='error.htm.tpl';
      }
      else{
        $oColProducts = new ProdLer_Collection_Products();
        $oProduct = $oColProducts->ObtainObject('cod',$_DATA['selProduct']);
        if (!$oProduct){
          $oSmarty->assign('sMessage',_('Product not found').'.');
          $oSmarty->assign('sReturn','form_products.php');
          $sDisplay='error.htm.tpl';
        }
        else{
          $oSmarty->assign('sAccessType',_('Product modification'));
          $oSmarty->assign('iProductCod',$oProduct->iCod);

          $oColCategories = new ProdLer_Collection_Categories();
          $oColBrands = new ProdLer_Collection_Brands();
          $oColDealers = new ProdLer_Collection_Dealers();

          $oSmarty->assign('aBrands',$oColBrands->ObtainList('name','cod'));
          $oSmarty->assign('aCategories',$oColCategories->ObtainHierarchy('name'));

          $oSmarty->assign('iBrandType','1');
          $oSmarty->assign('iProductBrand',$oProduct->oBrand->iCod);
          $oSmarty->assign('sModel',$oProduct->sModel);
          $oSmarty->assign('sDescription',$oProduct->sDescription);
          $oSmarty->assign('iProductCategory',$oProduct->oCategory->iCod);

          $oSmarty->assign('sCharacts',$oProduct->sCharacts);
          $oSmarty->assign('sSpecs',$oProduct->sSpecs);

          $aProvisions=$oProduct->GetProvisionsList();
          $oSmarty->assign('aProvisions',$aProvisions);
          $oSmarty->assign('iNumProvisions',count($aProvisions));

          foreach($aProvisions as $aProvision)
            $oColDealers->Exception('cod',$aProvision['iDealerCod']);

          $oSmarty->assign('aDealers',$oColDealers->ObtainList('alias','cod'));

          $oSmarty->assign('sDateCreated',CustomDate($oProduct->aDateCreated));
          $oSmarty->assign('sDateModified',CustomDate($oProduct->aDateModified));

          $oSmarty->assign('sDealerIDName',Prodler_Variable::Get('Dealer_ID_Name'));

          $sDisplay='form_product.htm.tpl';
        }
      }

      break;
    case 'btnDel':

      $oSmarty->assign('sReturn','form_products.php');
      $sDisplay='error.htm.tpl';

      if (IsNothing($_DATA['selProduct'])||($_DATA['selProduct']=='0')){
        $oSmarty->assign('sMessage',_('You have to select a particular product to delete an entry').'.');
      }
      else if (InvalidWhenDefined($_DATA['selProduct'],0)){
        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
      }
      // Product can be deleted, but needs now the confirmation
      else{
        if (($_DATA['hidConfirmation']=="1")||(!IsNothing($_DATA['btnAccept']))){
          $oColProducts = new ProdLer_Collection_Products();
          $oColProducts->DeleteObject('cod',$_DATA['selProduct']);

          $oSmarty->assign('sMessage',_('Product successfully deleted').'.');
          $sDisplay='message.htm.tpl';
        }
        else if (!IsNothing($_DATA['btnCancel'])){
          Redirect('form_products.php');
        }
        else{
          $oSmarty->assign('sForm',$PHP_SELF);
          $oSmarty->assign('aFormControls',$_DATA);
          $oSmarty->assign('sMessage',_('The product is going to be deleted from the database').'.');
          $sDisplay='confirm.htm.tpl';
          break;
        }

      }

      break;

    case 'btnShow':

      $sDisplay='form_products_post.htm.tpl';

      $oColProducts = new ProdLer_Collection_Products();

      $oSmarty->assign('aProducts',$oColProducts->ObtainProductsList());
      $oSmarty->assign('sSource',_('found'));

      $oSmarty->assign('iNumProducts',$oColProducts->Size());

      break;

    case 'btnCodeSearch':

      if (IsNothing($_DATA['txtCodeSearch'])){
        $oSmarty->assign('sMessage',
                         _('You have to write some number to search a particular product')
                         .'.');
        $oSmarty->assign('sReturn','form_products.php');
        $sDisplay='error.htm.tpl';
      }
      else if((!is_numeric($_DATA['txtCodeSearch']))
               ||(strlen($_DATA['txtCodeSearch'])>48)){
        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
        $oSmarty->assign('sReturn','form_products.php');
        $sDisplay='error.htm.tpl';
      }
      else{
        $oColProducts = new ProdLer_Collection_Products();
        $oProduct = $oColProducts->ObtainObject('cod',$_DATA['txtCodeSearch']);
        if (!$oProduct){
          $oSmarty->assign('sMessage',_('Product not found').'.');
          $oSmarty->assign('sReturn','form_products.php');
          $sDisplay='error.htm.tpl';
        }
        else{
          $oSmarty->assign('sAccessType',_('Product modification'));
          $oSmarty->assign('iProductCod',$oProduct->iCod);

          $oColCategories = new ProdLer_Collection_Categories();
          $oColBrands = new ProdLer_Collection_Brands();
          $oColDealers = new ProdLer_Collection_Dealers();

          $oSmarty->assign('aBrands',$oColBrands->ObtainList('name','cod'));
          $oSmarty->assign('aCategories',$oColCategories->ObtainHierarchy('name'));

          $oSmarty->assign('iBrandType','1');
          $oSmarty->assign('iProductBrand',$oProduct->oBrand->iCod);
          $oSmarty->assign('sModel',$oProduct->sModel);
          $oSmarty->assign('sDescription',$oProduct->sDescription);
          $oSmarty->assign('iProductCategory',$oProduct->oCategory->iCod);

          $oSmarty->assign('sCharacts',$oProduct->sCharacts);
          $oSmarty->assign('sSpecs',$oProduct->sSpecs);

          $aProvisions=$oProduct->GetProvisionsList();
          $oSmarty->assign('aProvisions',$aProvisions);
          $oSmarty->assign('iNumProvisions',count($aProvisions));

          foreach($aProvisions as $aProvision)
            $oColDealers->Exception('cod',$aProvision['iDealerCod']);

          $oSmarty->assign('aDealers',$oColDealers->ObtainList('alias','cod'));

          $oSmarty->assign('sDateCreated',CustomDate($oProduct->aDateCreated));
          $oSmarty->assign('sDateModified',CustomDate($oProduct->aDateModified));

          $oSmarty->assign('sDealerIDName',Prodler_Variable::Get('Dealer_ID_Name'));
          $sDisplay='form_product.htm.tpl';
        }
      }

      break;

    case 'btnAssociationSearch':
      $sDisplay='form_products_post.htm.tpl';

      if (IsNothing($_DATA['selCategory'])||
          !is_numeric($_DATA['selCategory'])||
          ($_DATA['selCategory']<0)||
          (strlen($_DATA['selCategory'])>48)||
          InvalidWhenDefined($_DATA['selBrand'],0)||
          InvalidWhenDefined($_DATA['selDealer'],0)){

        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
        $oSmarty->assign('sReturn','form_products.php');
        $sDisplay='error.htm.tpl';
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
        if ($_DATA['selDealer']!=0){
          $oColProvisions = new ProdLer_Collection_Provisions();
          $oColProvisions->Limit('dealer',$_DATA['selDealer']);
          $oColProducts->Relation('cod',$oColProvisions,'product');
        }

        $oSmarty->assign('aProducts',$oColProducts->ObtainProductsList());
        $oSmarty->assign('sSource',_('found'));
        $oSmarty->assign('iNumProducts',$oColProducts->Size());

        $oSmarty->assign('iCategoryCod',$_DATA['selCategory']);
        $oSmarty->assign('iBrandCod',$_DATA['selBrand']);
        $oSmarty->assign('iDealerCod',$_DATA['selDealer']);
      }
      break;

    case 'btnTextSearch':
      $sDisplay='form_products_post.htm.tpl';

      if (IsNothing($_DATA['txtTextSearch'])){
        $oSmarty->assign('sMessage',_('You have to write some string to make search').'.');
        $oSmarty->assign('sReturn','form_products.php');
        $sDisplay='error.htm.tpl';
      }
      else if (IsNothing($_DATA['chkTextSearchModel'])&&
               IsNothing($_DATA['chkTextSearchDescription'])&&
               IsNothing($_DATA['chkTextSearchCharacts'])&&
               IsNothing($_DATA['chkTextSearchSpecs'])){
        $oSmarty->assign('sMessage',_('You have to check one field at least to make a search').'.');
        $oSmarty->assign('sReturn','form_products.php');
        $sDisplay='error.htm.tpl';
      }
      else if (strlen($_DATA['txtTextSearch'])>48){
        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
        $oSmarty->assign('sReturn','form_products.php');
        $sDisplay='error.htm.tpl';
      }
      else{
        $oColProducts = new ProdLer_Collection_Products();

        if (!IsNothing($_DATA['chkTextSearchModel']))
          $oColProducts->AddSearchField('model');

        if (!IsNothing($_DATA['chkTextSearchDescription']))
          $oColProducts->AddSearchField('description');

        if (!IsNothing($_DATA['chkTextSearchCharacts']))
          $oColProducts->AddSearchField('characts');

        if (!IsNothing($_DATA['chkTextSearchSpecs']))
          $oColProducts->AddSearchField('specs');

        $oColProducts->AddSearchTerms(stripslashes($_DATA['txtTextSearch']));

        $oSmarty->assign('aProducts',$oColProducts->ObtainProductsList());
        $oSmarty->assign('sSource',_('found'));
        $oSmarty->assign('iNumProducts',$oColProducts->Size());
      }

      break;

    default:
      $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
      $oSmarty->assign('sReturn','form_products.php');
      $sDisplay='error.htm.tpl';
      break;
  }

  $oSmarty->display($sDisplay);

  require_once '../../include/exit.inc.php';

?>
