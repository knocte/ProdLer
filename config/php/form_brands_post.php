<?php

  require_once '../../include/init.inc.php';

  $_DATA = $_POST;

  $sOption = WhichOption($_DATA,'btnAdd','btnMod','btnDel','btnProd');

  $oSmarty = new Xsmarty();

  switch ($sOption) {
    case 'btnAdd':

      $oSmarty->assign('sAccessType',_('Brand creation'));
      $oSmarty->assign('iBrandCod',0);
      $sDisplay='form_brand.htm.tpl';

      $oColImages = new ProdLer_Collection_Images();
      $oSmarty->assign('aImages',$oColImages->ObtainList('filename','cod'));

      break;
    case 'btnMod':
      if (IsNothing($_DATA['selBrand'])||($_DATA['selBrand']=='0')){
        $oSmarty->assign('sMessage',
                         _('You have to select a particular brand to modify an entry').'.');
        $oSmarty->assign('sReturn','form_brands.php');
        $sDisplay='error.htm.tpl';
      }
      else if((!is_numeric($_DATA['selBrand']))
               ||($_DATA['selBrand']<0)
               ||(strlen($_DATA['selBrand'])>48)){

        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
        $oSmarty->assign('sReturn','form_brands.php');
        $sDisplay='error.htm.tpl';
      }
      else{
        $oColBrands = new ProdLer_Collection_Brands();
        $oBrand = $oColBrands->ObtainObject('cod',$_DATA['selBrand']);
        if (!$oBrand){
          $oSmarty->assign('sMessage',_('Brand not found').'.');
          $oSmarty->assign('sReturn','form_brands.php');
          $sDisplay='message.htm.tpl';
        }
        else{
          $oSmarty->assign('sAccessType',_('Brand modification'));
          $oSmarty->assign('iBrandCod',$_DATA['selBrand']);
          $oSmarty->assign('sBrandName',$oBrand->sName);
          $oSmarty->assign('sBrandURL',$oBrand->sURL);
          $oSmarty->assign('iImageCod',$oBrand->oImage->iCod);
          $oSmarty->assign('iImageFilename',$oBrand->oImage->iFileName);

          $oColImages = new ProdLer_Collection_Images();
          $oSmarty->assign('aImages',$oColImages->ObtainList('filename','cod'));

          $oSmarty->assign('sDateCreated',CustomDate($oBrand->aDateCreated));
          $oSmarty->assign('sDateModified',CustomDate($oBrand->aDateModified));
          $sDisplay='form_brand.htm.tpl';
        }
      }

      break;
    case 'btnDel':
      $oSmarty->assign('sReturn','form_brands.php');
      $sDisplay='error.htm.tpl';

      if (IsNothing($_DATA['selBrand'])||($_DATA['selBrand']=='0')){
        $oSmarty->assign('sMessage',_('You have to select a particular brand to delete an entry').'.');
      }
      else if((!is_numeric($_DATA['selBrand']))
               ||($_DATA['selBrand']<0)
               ||(strlen($_DATA['selBrand'])>48)){
        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
      }
      else{
        $oColBrands = new ProdLer_Collection_Brands();
        if ($oColBrands->DeleteObject('cod',$_DATA['selBrand'])){
          $oSmarty->assign('sMessage',_('Brand successfully deleted').'.');
          $sDisplay='message.htm.tpl';
        }
        else
          $oSmarty->assign('sMessage',_('You cannot delete a brand which contains products').'.');
      }

      break;
    case 'btnProd':
      $sDisplay='form_products_post.htm.tpl';

      if (IsNothing($_DATA['selBrand'])||($_DATA['selBrand']=='0')){
        $oSmarty->assign('sMessage',_('You have to select a particular brand to show its products').'.');
        $oSmarty->assign('sReturn','form_brands.php');
        $sDisplay='error.htm.tpl';
      }
      else if((!is_numeric($_DATA['selBrand']))
               ||($_DATA['selBrand']<0)
               ||(strlen($_DATA['selBrand'])>48)){

        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
        $oSmarty->assign('sReturn','form_brands.php');
        $sDisplay='error.htm.tpl';
      }
      else{
        $oColBrands = new ProdLer_Collection_Brands();
        $oBrand = $oColBrands->ObtainObject('cod',$_DATA['selBrand']);
        $oColProducts =& $oBrand->GetProductsCollection();

        $oSmarty->assign('aProducts',$oColProducts->ObtainProductsList());
        $oSmarty->assign('sSource',_('of brand').' '.$oBrand->sName);
        $oSmarty->assign('iNumProducts',$oColProducts->Size());
        $oSmarty->assign('iBrandCod',$_DATA['selBrand']);
      }

      break;
    default:
      $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
      $oSmarty->assign('sReturn','form_brands.php');
      $sDisplay='error.htm.tpl';
      break;
  }

  $oSmarty->display($sDisplay);

  require_once '../../include/exit.inc.php';

?>