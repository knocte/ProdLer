<?php

  require_once '../../include/init.inc.php';

  $_DATA = $_POST;

  $sDisplay='error.htm.tpl';

  require_once '../../include/img.inc.php';

  if (IsNothing($_DATA['txtCategoryName'])){
    $sMessage = _('Category name is a required field').'.';
  }
  else if (IsNothing($_DATA['selParentCategory'])){
    $sMessage = _('Parent category is a required field').'.';
  }
  else if (IsNothing($_DATA['hidCategoryCod'])
           ||(!is_numeric($_DATA['hidCategoryCod']))
           ||($_DATA['hidCategoryCod']<0)){
    $sMessage = _('Invalid data received from the form').'.';
  }
  else if ((strlen($_DATA['selParentCategory'])>48)
           ||(!is_numeric($_DATA['selParentCategory']))
           ||($_DATA['selParentCategory']<0)){
    $sMessage = _('Invalid data received from the form').'.';
  }
  else if ( IsNothing($_DATA['radImage'])
       ||(!is_numeric($_DATA['radImage']))
       ||($_DATA['radImage']>3)
       ||($_DATA['radImage']<0) ){
    $sMessage = _('Invalid data received from the form').'.';
  }
  else if (strlen($_DATA['txtCategoryName'])>48){
    $sMessage = _('You have exceeded the maximum number of characters for the category name').'.';
  }
  else{
    $sDisplay='message.htm.tpl';

    $sCategoryName = FixString($_DATA['txtCategoryName']);

    if ($_DATA['hidCategoryCod']=='0'){
      //Category creation

      $oCategory = new ProdLer_Category($sCategoryName,$_DATA['selParentCategory']);
      if ($oImage) $oCategory->SetImage($oImage);

      $oColCategories = new ProdLer_Collection_Categories();
      $oColCategories->Limit('cod',$_DATA['selParentCategory']);
      if (($_DATA['selParentCategory']!='0')&&($oColCategories->Size()!=1)){
        $sMessage=_('Parent category not found').'.';
      }
      else if ($oColCategories->IncludeObject($oCategory))
        $sMessage=_('The category has been successfully created').'.';
      else{
        $sMessage=_('There is already a category with that name').'.';
        $sDisplay='error.htm.tpl';
      }

    }
    else{
      //Category modification

      $oColCategories = new ProdLer_Collection_Categories();
      $oCategory = $oColCategories->ObtainObject('cod',$_DATA['hidCategoryCod']);
      $oParentCategory = $oColCategories->ObtainObject('cod',$_DATA['selParentCategory']);


      if (!$oCategory)
        $sMessage=_('Category not found').'.';
      else if (!$oParentCategory)
        $sMessage=_('Parent category not found').'.';
      else if (($_DATA['selParentCategory']==$_DATA['hidCategoryCod'])||
               ($oColCategories->IsParent($oCategory,$oParentCategory)))
        $sMessage=_('Error').': '._('Invalid data received from the form').'.';
      else{
        $oCategory->SetName($sCategoryName);
        $oCategory->SetParent($_DATA['selParentCategory']);
        $oCategory->SetImage($oImage);

        if ($oColCategories->UpdateObject($oCategory))
          $sMessage=_('The category has been successfully modified').'.';
        else{
          $sMessage=_('There is already a category with that name').'.';
          $sDisplay='error.htm.tpl';
        }
      }
    }
  }

  $oSmarty = new Xsmarty();

  $oSmarty->assign('sReturn','form_categories.php');
  $oSmarty->assign('sMessage',$sMessage);
  $oSmarty->display($sDisplay);

  require_once '../../include/exit.inc.php';

?>