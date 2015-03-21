<?php

  require_once '../../include/init.inc.php';

  function AllPricesNumeric($aProvisions){
    if (!$aProvisions)
      return TRUE;

    foreach($aProvisions as $aProvision){
      if (!is_numeric(Price2DB($aProvision['iPrice'])))
        return FALSE;
    }

    return TRUE;
  }

  $oSmarty = new Xsmarty();

  $_DATA = $_POST;

  if (IsNothing($_DATA['btnSubmit'])){ // Present or modify form

    if ((!IsNothing($_DATA['btnAddPrice']))&&
        (($_DATA['selDealer']=='0')||IsNothing($_DATA['selDealer']))){
      $oSmarty->assign('sReturn','form_product.php');
      $oSmarty->assign('sMessage',_('You have to select a valid dealer to insert a new price').'.');
      $oSmarty->display('error.htm.tpl');
    }
    else if ((!IsNothing($_DATA['btnAddDealer']))&&
        (IsNothing($_DATA['txtNewDealerName']))){
      $oSmarty->assign('sReturn','form_product.php');
      $oSmarty->assign('sMessage',_('You have to write the name of a new dealer to insert a price this way').'.');
      $oSmarty->display('error.htm.tpl');
    }
    else if ( ((!IsNothing($_DATA['btnAddPrice']))
                &&( !is_numeric(Price2DB($_DATA['txtPrice'])) ))||
              ((!IsNothing($_DATA['btnAddDealer']))
                &&( !is_numeric(Price2DB($_DATA['txtNewDealerPrice'])) )) ){
      $oSmarty->assign('sReturn','form_product.php');
      $oSmarty->assign('sMessage',_('You have to write only numbers for price fields').'.');
      $oSmarty->display('error.htm.tpl');
    }
    else{ //no error (present or modify form)

      $oColCategories = new ProdLer_Collection_Categories();
      $oColBrands = new ProdLer_Collection_Brands();
      $oColDealers = new ProdLer_Collection_Dealers();

      $oSmarty = new Xsmarty();

      $sCurrencySymbol = ProdLer_Variable::Get('Currency_Symbol');
      $oSmarty->assign('sCurrencySymbol',$sCurrencySymbol);

      if (IsNothing($_DATA['hidProductCod']))
        $_DATA['hidProductCod'] = 0;

      if ($_DATA['hidProductCod'] == 0)
        $oSmarty->assign('sAccessType',_('Product creation'));
      else
        $oSmarty->assign('sAccessType',_('Product modification'));

      $oSmarty->assign('iProductCod', $_DATA['hidProductCod']);

      if ($_DATA['radBrand'] == '1'){
        $oSmarty->assign('iBrandType','1');
        $oSmarty->assign('iProductBrand',$_DATA['selBrand']);
      }
      else if ($_DATA['radBrand'] == '0'){
        $oSmarty->assign('iBrandType','0');
        $oSmarty->assign('sProductBrand',Xstripslashes($_DATA['txtNewBrand']));
      }
      else{
        $oSmarty->assign('iProductBrand',$_DATA['selBrand']);
        $oSmarty->assign('sProductBrand',Xstripslashes($_DATA['txtNewBrand']));
      }

      $oSmarty->assign('sModel',Xstripslashes($_DATA['txtModel']));
      $oSmarty->assign('sDescription',Xstripslashes($_DATA['txtDescription']));

      $oSmarty->assign('sDateCreated',$_DATA['hidDateCreated']);
      $oSmarty->assign('sDateModified',$_DATA['hidDateModified']);

      $oSmarty->assign('iProductCategory',$_DATA['selCategory']);
      if (!IsNothing($_DATA['chkSubcategory'])&&!IsNothing($_DATA['txtNewCategory'])){
        $oSmarty->assign('iSubCategory','1');
        $oSmarty->assign('sProductCategory',Xstripslashes($_DATA['txtNewCategory']));
      }

      $oSmarty->assign('sCharacts',Xstripslashes($_DATA['txaCharacts']));
      $oSmarty->assign('sSpecs',Xstripslashes($_DATA['txaSpecs']));

      if (!IsNothing($_DATA['hidProvisions']))
        $aProvisions=$_DATA['hidProvisions'];

      if (IsNothing($_DATA['hidNumProvisions']))
        $iNumProvisions = 0;
      else{
        $iDelete = WhichDelete($_DATA['hidNumProvisions']);

        if ($iDelete!=-1){
          $aProvisions=RemoveElement($aProvisions,$iDelete);
          $iNumProvisions = $_DATA['hidNumProvisions'] - 1;
        }
        else if (!IsNothing($_DATA['btnAddDealer'])||!IsNothing($_DATA['btnAddPrice'])){
          $iNumProvisions = $_DATA['hidNumProvisions'] + 1;

          if (!IsNothing($_DATA['btnAddPrice'])){
            if (IsNothing($_DATA['txtPrice']))
              $iPrice = 0;
            else
              $iPrice = FixPrice($_DATA['txtPrice']);

            $oDealer = $oColDealers->ObtainObject('cod',$_DATA['selDealer']);

            $aProvision = array();
            $aProvision['iPrice'] = $iPrice;
            $aProvision['iDealerCod'] = $oDealer->iCod;
            $aProvision['sDealerName'] = $oDealer->sName;
            $aProvision['sDealerID'] = $oDealer->sID;
            $aProvisions[] = $aProvision;
          }

          else if (!IsNothing($_DATA['btnAddDealer'])){
            if (IsNothing($_DATA['txtNewDealerPrice']))
              $iPrice = 0;
            else
              $iPrice = FixPrice($_DATA['txtNewDealerPrice']);

            $aProvision = array();
            $aProvision['iPrice'] = $iPrice;
            $aProvision['iDealerCod'] = '0';
            $aProvision['sDealerName'] = $_DATA['txtNewDealerName'];
            $aProvision['sDealerID'] = $_DATA['txtNewDealerID'];
            $aProvisions[] = $aProvision;
          }
        }
        else
          $iNumProvisions = $_DATA['hidNumProvisions'];
      }
      $oSmarty->assign('iNumProvisions',$iNumProvisions);

      if ($aProvisions)
        foreach($aProvisions as $aProvision){
          $oColDealers->Exception('cod',$aProvision['iDealerCod']);
        }

      if ($aProvisions)
        $aProvisions = Xstripslashes($aProvisions);

      $oSmarty->assign('aProvisions',$aProvisions);

      $oSmarty->assign('aBrands',$oColBrands->ObtainList('name','cod'));
      $oSmarty->assign('aCategories',$oColCategories->ObtainHierarchy('name'));
      $oSmarty->assign('aDealers',$oColDealers->ObtainList('alias','cod'));

      $oColImages = new ProdLer_Collection_Images();
      $oSmarty->assign('aImages',$oColImages->ObtainList('filename','cod'));

      $oSmarty->assign('sDealerIDName',Prodler_Variable::Get('Dealer_ID_Name'));
      $oSmarty->display('form_product.htm.tpl');
    }
  }


  else{ // Send product

    $sReturn = 'form_product.php';
    $sDisplay='error.htm.tpl';

    if ( (($_DATA['radBrand']!=0)&&($_DATA['radBrand']!=1)) ||
         ($_DATA['selCategory']<0)||
         ((!IsNothing($_DATA['selCategory']))&&!is_numeric($_DATA['selCategory']))||
         (strlen($_DATA['selCategory'])>48)||
         (($_DATA['radBrand']==1)&&
           (($_DATA['selBrand']<0)||(!is_numeric($_DATA['selBrand']))||(strlen($_DATA['selCategory'])>48)))||
         (($_DATA['radBrand']==1)&&($_DATA['selBrand']<0)) ){

      $sMessage=_('Invalid data received from the form').'.';
    }
    else if (IsNothing($_DATA['radBrand'])){
      $sMessage=_('You have to specify if the brand is new or existing').'.';
    }
    else if (($_DATA['radBrand']==1)&&($_DATA['selBrand']==0)){
      $sMessage=_('You have to select a particular brand').'.';
    }
    else if (($_DATA['radBrand']==0)&&(IsNothing($_DATA['txtNewBrand']))){
      $sMessage=_('You have to write the name of the new brand').'.';
    }
    else if (strlen($_DATA['txtNewBrand'])>48){
      $sMessage = _('You have exceeded the maximum number of characters for the new brand').'.';
    }
    else if (IsNothing($_DATA['txtModel'])){
      $sMessage=_('Product model is a required field').'.';
    }
    else if (strlen($_DATA['txtModel'])>28){
      $sMessage = _('You have exceeded the maximum number of characters for the product model').'.';
    }
    else if (strlen($_DATA['txtDescription'])>48){
      $sMessage = _('You have exceeded the maximum number of characters for the product description').'.';
    }
    else if (strlen($_DATA['txaCharacts'])>2000){
      $sMessage = _('You have exceeded the maximum number of characters for the product characteristics').'.';
    }
    else if (strlen($_DATA['txaSpecs'])>2000){
      $sMessage = _('You have exceeded the maximum number of characters for the product specifications').'.';
    }
    else if (IsNothing($_DATA['chkSubcategory'])&&IsNothing($_DATA['selCategory'])){
      $sMessage=_('You have to select a particular category').'.';
    }
    else if (!IsNothing($_DATA['chkSubcategory'])&&IsNothing($_DATA['selCategory'])){
      $sMessage=_('You have to select the parent category of the new subcategory').'.';
    }
    else if (!IsNothing($_DATA['chkSubcategory'])&&IsNothing($_DATA['txtNewCategory'])){
      $sMessage=_('You have to write the name of the new category').'.';
    }
    else if (!AllPricesNumeric($_DATA['hidProvisions'])){
      $sMessage=_('You have to write only numbers for price fields').'.';
    }

    else{ // no error (send product)
      $oColImages = new ProdLer_Collection_Images();
      $oSmarty->assign('aImages',$oColImages->ObtainList('filename','cod'));

      if ($_DATA['hidProductCod'] == 0)
        $oSmarty->assign('sAccessType',_('Product creation'));
      else{
        $oSmarty->assign('sAccessType',_('Product modification'));

        $oColProducts = new ProdLer_Collection_Products();
        $oProduct = $oColProducts->ObtainObject('cod',$_DATA['hidProductCod']);

        if (!$oProduct){
          $oSmarty->assign('sMessage',_('Product not found').'.');
          $oSmarty->assign('sReturn','form_products.php');
          $sDisplay='error.htm.tpl';
        }

        $oSmarty->assign('iImageCod',$oProduct->oImage->iCod);
        $oSmarty->assign('iImageFilename',$oProduct->oImage->iFileName);
      }

      if(($_DATA['hidProductCod']==0)||($oProduct)){
        $oSmarty->assign('iProductCod',$_DATA['hidProductCod']);

        if ($_DATA['radBrand'] == '1'){
          $oSmarty->assign('iBrandType','1');
          $oSmarty->assign('iProductBrand',$_DATA['selBrand']);
        }
        else if ($_DATA['radBrand'] == '0'){
          $oSmarty->assign('iBrandType','0');
          $oSmarty->assign('sProductBrand',Xstripslashes($_DATA['txtNewBrand']));
        }

        $oSmarty->assign('iProductCategory',$_DATA['selCategory']);
        if (!IsNothing($_DATA['chkSubcategory'])&&!IsNothing($_DATA['txtNewCategory'])){
          $oSmarty->assign('iSubCategory','1');
          $oSmarty->assign('sProductCategory',Xstripslashes($_DATA['txtNewCategory']));
        }

        $oSmarty->assign('sModel',Xstripslashes($_DATA['txtModel']));
        $oSmarty->assign('sDescription',Xstripslashes($_DATA['txtDescription']));
        $oSmarty->assign('sCharacts',Xstripslashes($_DATA['txaCharacts']));
        $oSmarty->assign('sSpecs',Xstripslashes($_DATA['txaSpecs']));

        $oSmarty->assign('iNumProvisions',$_DATA['hidNumProvisions']);

        if (!IsNothing($_DATA['hidProvisions']))
          $oSmarty->assign('aProvisions',Xstripslashes($_DATA['hidProvisions']));

        $sDisplay='form_product-img.htm.tpl';
      }
    }

    $oSmarty->assign('sReturn',$sReturn);
    $oSmarty->assign('sMessage',$sMessage);
    $oSmarty->display($sDisplay);
  }

  require_once '../../include/exit.inc.php';

?>