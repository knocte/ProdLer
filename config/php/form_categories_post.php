<?php

  require_once '../../include/init.inc.php';

  $sOption = WhichOption($_POST,'btnAdd','btnMod','btnDel','btnProd');

  $oSmarty = new Xsmarty();

  switch ($sOption) {
    case 'btnAdd':

      $oColCategories = new ProdLer_Collection_Categories();
      $aCategories = $oColCategories->ObtainHierarchy(name);

      $oSmarty->assign('aCategories',$aCategories);
      $oSmarty->assign('sAccessType',_('Category creation'));
      $oSmarty->assign('iCategoryCod',0);
      $oSmarty->assign('sCategoryName','');

      if (count($aCategories)==0)
        $oSmarty->assign('iCategoryParent',0);
      else
        $oSmarty->assign('iCategoryParent','-1');

      $oColImages = new ProdLer_Collection_Images();
      $oSmarty->assign('aImages',$oColImages->ObtainList('filename','cod'));

      $sDisplay='form_category.htm.tpl';

      break;
    case 'btnMod':
      $sDisplay='error.htm.tpl';

      if (IsNothing($_POST['selCategory'])||($_POST['selCategory']=='0')){
        $oSmarty->assign('sMessage',_('You have to select a particular category to modify an entry').'.');
        $oSmarty->assign('sReturn','form_categories.php');
      }
      else if((!is_numeric($_POST['selCategory']))
               ||($_POST['selCategory']<0)
               ||(strlen($_POST['selCategory'])>48)){

        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
        $oSmarty->assign('sReturn','form_categories.php');
      }
      else{
        $oColCategories = new ProdLer_Collection_Categories();
        $oCategory = $oColCategories->ObtainObject('cod',$_POST['selCategory']);
        if (!$oCategory){
          $oSmarty->assign('sMessage',_('Category not found').'.');
          $oSmarty->assign('sReturn','form_categories.php');
          $sDisplay='message.htm.tpl';
        }
        else{
          $oColCategories->Exception('cod',$_POST['selCategory']);

          $oSmarty->assign('aCategories',$oColCategories->ObtainHierarchy(name));
          $oSmarty->assign('sAccessType',_('Category modification'));
          $oSmarty->assign('iCategoryCod',$_POST['selCategory']);
          $oSmarty->assign('sCategoryName',$oCategory->sName);
          $oSmarty->assign('iCategoryParent',$oCategory->iParent);
          $oSmarty->assign('iImageCod',$oCategory->oImage->iCod);
          $oSmarty->assign('iImageFilename',$oCategory->oImage->iFileName);

          $oColImages = new ProdLer_Collection_Images();
          $oSmarty->assign('aImages',$oColImages->ObtainList('filename','cod'));

          $oSmarty->assign('sDateCreated',CustomDate($oCategory->aDateCreated));
          $oSmarty->assign('sDateModified',CustomDate($oCategory->aDateModified));
          $sDisplay='form_category.htm.tpl';
        }
      }

      break;
    case 'btnDel':

      $oSmarty->assign('sReturn','form_categories.php');
      $sDisplay='error.htm.tpl';

      if (IsNothing($_POST['selCategory'])||($_POST['selCategory']=='0')){
        $oSmarty->assign('sMessage',_('You have to select a particular category to delete an entry').'.');
      }
      else if((!is_numeric($_POST['selCategory']))
               ||($_POST['selCategory']<0)
               ||(strlen($_POST['selCategory'])>48)){
        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
      }
      else{
        $oColCategories = new ProdLer_Collection_Categories();

        if ($oColCategories->DeleteObject('cod',$_POST['selCategory'])){
          $oSmarty->assign('sMessage',_('Category successfully deleted').'.');
          $sDisplay='message.htm.tpl';
        }
        else
          $oSmarty->assign('sMessage',_('You cannot delete a category which contains subcategories and/or products').'.');
      }

      break;
    case 'btnProd':
      $sDisplay='form_products_post.htm.tpl';

      if (IsNothing($_POST['selCategory'])){
        $oSmarty->assign('sMessage',_('You have to select a particular category to show its products').'.');
        $oSmarty->assign('sReturn','form_categories.php');
        $sDisplay='error.htm.tpl';
      }
      else if((!is_numeric($_POST['selCategory']))
               ||($_POST['selCategory']<0)
               ||(strlen($_POST['selCategory'])>48)){

        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
        $oSmarty->assign('sReturn','form_categories.php');
        $sDisplay='error.htm.tpl';
      }
      else{
        $oColCategories = new ProdLer_Collection_Categories();
        $oCategory = $oColCategories->ObtainObject('cod',$_POST['selCategory']);
        $oColProducts =& $oCategory->GetProductsCollection(TRUE);

        $oSmarty->assign('aProducts',$oColProducts->ObtainProductsList());
        $oSmarty->assign('sSource',_('of category').' '.$oCategory->sName);
        $oSmarty->assign('iNumProducts',$oColProducts->Size());
        $oSmarty->assign('iCategoryCod',$_POST['selCategory']);
      }
      break;
    default:
      $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
      $oSmarty->assign('sReturn','form_categories.php');
      $sDisplay='error.htm.tpl';
      break;
  }

  $oSmarty->display($sDisplay);

  require_once '../../include/exit.inc.php';

?>