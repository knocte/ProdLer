<?php

  require_once '../../include/init.inc.php';

  $_DATA = $_POST;

  require_once '../../include/img.inc.php';

  $oSmarty = new Xsmarty();

  $sDisplay = 'message.htm.tpl';
  $sReturn = './';

  $bErrorCreating = FALSE;

  if ( IsNothing($_DATA['radImage'])
       ||(!is_numeric($_DATA['radImage']))
       ||($_DATA['radImage']>3)
       ||($_DATA['radImage']<0) ){
    $sMessage = _('Invalid data received from the form').'.';
    $sReturn = 'form_product.php';
    $sDisplay='error.htm.tpl';

    $bErrorCreating = TRUE;
  }


  $aDelete = array();

  //Brand creation or validation
  if (!$bErrorCreating){
    $oColBrands = new ProdLer_Collection_Brands();
    if ($_DATA['radBrand']==1){
      $oBrand = $oColBrands->ObtainObject('cod',$_DATA['selBrand']);
      if (!$oBrand){
        $sMessage=_('Brand not found').'.';
        $sReturn = 'form_product.php';
        $sDisplay='error.htm.tpl';

        $bErrorCreating = TRUE;
      }
    }
    else if ($_DATA['radBrand']==0){
      $oBrand = new ProdLer_Brand($_DATA['txtNewBrand']);
      $oColBrands = new ProdLer_Collection_Brands();

      if ($oColBrands->IncludeObject($oBrand))
        $aDelete['Brand'] = $oBrand;
      else{
        $sMessage=_('There is already a brand with that name').'.';
        $sReturn = 'form_product.php';
        $sDisplay='error.htm.tpl';

        $bErrorCreating = TRUE;
      }
    }
  }

  //Category creation or validation
  if (!$bErrorCreating){
    $oColCategories = new ProdLer_Collection_Categories();
    if ($_DATA['chkSubcategory']!=1){
      $oCategory = $oColCategories->ObtainObject('cod',$_DATA['selCategory']);
      if (!$oCategory){
        $sMessage=_('Category not found').'.';
        $sReturn = 'form_product.php';
        $sDisplay='error.htm.tpl';

        $bErrorCreating = TRUE;
      }
    }
    else{
      $oCategory = new ProdLer_Category(FixString($_DATA['txtNewCategory']),$_DATA['selCategory']);

      $oColCategories = new ProdLer_Collection_Categories();
      $oColCategories->Limit('cod',$_DATA['selCategory']);

      if (($_DATA['selCategory']!='0')&&($oColCategories->Size()!=1)){
        $sMessage=_('Parent category not found').'.';
        $sReturn = 'form_product.php';
        $sDisplay='error.htm.tpl';

        $bErrorCreating = TRUE;
      }
      else if ($oColCategories->IncludeObject($oCategory))
        $aDelete['Category'] = $oCategory;
      else{
        $sMessage=_('There is already a category with that name').'.';
        $sReturn = 'form_product.php';
        $sDisplay='error.htm.tpl';

        $bErrorCreating = TRUE;
      }
    }
  }

  //Dealers creation or validation
  $aDealers = array();
  $oColDealers = new ProdLer_Collection_Dealers();
  $aProvisions = array();
  if ($_DATA['hidProvisions']) foreach($_DATA['hidProvisions'] as $aProvision){

    if (!$bErrorCreating){
      if ($aProvision['iDealerCod']==0){
        $oDealer = new ProdLer_Dealer($aProvision['sDealerName'],$aProvision['sDealerName']);
        $oDealer->SetID($aProvision['sDealerID']);
        if ($oColDealers->IncludeObject($oDealer)){
          $aDealers[] = $oDealer;
          $aProvision['iDealerCod']=$oDealer->iCod;
        }
        else{
          $sMessage=_('There is already a dealer with the same name, alias or ID').'.';
          $sReturn = 'form_product.php';
          $sDisplay='error.htm.tpl';

          $bErrorCreating = TRUE;
        }
      }
      $aProvisions[] = $aProvision;
    }
  }
  $aDelete['Dealers'] = $aDealers;

  if (!$bErrorCreating){
    if ((!is_numeric($_DATA['hidProductCod']))
        ||($_DATA['hidProductCod']=='0')||(IsNothing($_DATA['hidProductCod']))){
      //Product creation, not modification

      $oProduct = new ProdLer_Product(FixString($_DATA['txtModel']),$oBrand,$oCategory);
      $oProduct->SetDescription(FixString($_DATA['txtDescription']));
      $oProduct->SetCharacts(FixString($_DATA['txaCharacts']));
      $oProduct->SetSpecs(FixString($_DATA['txaSpecs']));

      $oProduct->SetProvisions($aProvisions);
      if ($oImage) $oProduct->SetImage($oImage);

      $oColProducts = new ProdLer_Collection_Products();
      if ($oColProducts->IncludeObject($oProduct))
        $sMessage=_('The product has been successfully created').'.';
      else{
        $sMessage=_('There is already a product with the same brand and model').'.';
        $sReturn = 'form_product.php';
        $sDisplay='error.htm.tpl';

        $bErrorCreating = TRUE;
      }
    }
    else{
      //Product modification
      $oColProducts = new ProdLer_Collection_Products();
      $oProduct = $oColProducts->ObtainObject('cod',$_DATA['hidProductCod']);

      if (!$oProduct){
        $oSmarty->assign('sMessage',_('Product not found').'.');
        $oSmarty->assign('sReturn','form_products.php');
        $sDisplay='message.htm.tpl';

        $bErrorCreating = TRUE;
      }
      else{
        $oProduct->SetModel(FixString($_DATA['txtModel']));
        $oProduct->SetBrand($oBrand);
        $oProduct->SetCategory($oCategory);
        $oProduct->SetDescription(FixString($_DATA['txtDescription']));
        $oProduct->SetCharacts(FixString($_DATA['txaCharacts']));
        $oProduct->SetSpecs(FixString($_DATA['txaSpecs']));

        $oProduct->SetProvisions($_DATA['hidProvisions']);
        $oProduct->SetImage($oImage);

        if ($oColProducts->UpdateObject($oProduct))
          $sMessage=_('The product has been successfully modified').'.';
        else{
          $sMessage=_('There is already a product with the same brand and model').'.';
          $sReturn = 'form_product.php';
          $sDisplay='error.htm.tpl';

          $bErrorCreating = TRUE;
        }
      }
    }
  }

  //Brand/Category/Dealer Elimination
  if ($bErrorCreating){

    if ($oBrand = $aDelete['Brand']){
      $oColBrands = new ProdLer_Collection_Brands();
      $oColBrands->DeleteObject('cod',$oBrand->iCod);
    }

    if ($oCategory = $aDelete['Category']){
      $oColCategories = new ProdLer_Collection_Categories();
      $oColCategories->DeleteObject('cod',$oCategory->iCod);
    }

    if ($aDealers = $aDelete['Dealers']){
      $oColDealers = new ProdLer_Collection_Dealers();
      foreach($aDealers as $oDealer){
        $oColDealers->DeleteObject('cod',$oDealer->iCod);
      }
    }
  }

  $oSmarty->assign('sReturn',$sReturn);
  $oSmarty->assign('sMessage',$sMessage);
  $oSmarty->display($sDisplay);

  require_once '../../include/exit.inc.php';

?>