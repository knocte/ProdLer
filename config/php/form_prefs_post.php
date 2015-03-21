<?php

  require_once '../../include/init.inc.php';

  $_DATA = $_POST;

  $sDisplay='error.htm.tpl';

  $iImageIteration=1;
  require '../../include/img.inc.php';
  $oImage1 = $oImage;
  $iImageCod1 = $iImageCod;

  $iImageIteration=2;
  require '../../include/img.inc.php';
  $oImage2 = $oImage;
  $iImageCod2 = $iImageCod;

  if (strlen($_DATA['txtCompanyName'])>48){
    $sMessage = _('You have exceeded the maximum number of characters for the company name').'.';
  }
  else if (strlen($_DATA['txtCompanyURL'])>48){
    $sMessage = _('You have exceeded the maximum number of characters for the company URL').'.';
  }
  else if (($_DATA['radTax']==1)&&(!is_numeric($_DATA['txtTaxQuantity']))){
    $sMessage = _('The tax quantity must be numeric').'.';
  }
  else{
    $sDisplay='message.htm.tpl';
    $sMessage=_('Preferences have been succesfully saved').'.';

    ProdLer_Variable::Set('Company_Name',FixString($_DATA['txtCompanyName']));
    ProdLer_Variable::Set('Company_URL',FixString($_DATA['txtCompanyURL']));

    ProdLer_Variable::Set('Default_Benefit',FixString($_DATA['txtDefaultBenefit']));
    ProdLer_Variable::Set('Benefit_Type',$_DATA['radBenefitType']);
 

    ProdLer_Variable::Set('Tax_Name',FixString($_DATA['txtTaxName']));
    ProdLer_Variable::Set('Tax',$_DATA['radTax']);

    if ($_DATA['radTax']==1)
      ProdLer_Variable::Set('Tax_Quantity',FixString($_DATA['txtTaxQuantity']));
    else if ($_DATA['radTax']==2)
      ProdLer_Variable::Set('Tax_Sentence',FixString($_DATA['txtTaxSentence']));

    ProdLer_Variable::Set('Dealer_ID_Name',FixString($_DATA['txtDealerIDName']));
    ProdLer_Variable::Set('Date_Syntax',FixString($_DATA['txtDateSyntax']));
    ProdLer_Variable::Set('Currency_Name',FixString($_DATA['txtCurrencyName']));
    ProdLer_Variable::Set('Currency_Symbol',FixString($_DATA['txtCurrencySymbol']));
    ProdLer_Variable::Set('Decimal_Divisor',FixString($_DATA['txtDecimalDivisor']));

    ProdLer_Variable::Set('Lang_Config',$_DATA['selLangConfig']);
    ProdLer_Variable::Set('Lang_Config_Mode',$_DATA['radLangConfig']);
    ProdLer_Variable::Set('Lang_Visitors',$_DATA['selLangVisitors']);
    ProdLer_Variable::Set('Lang_Visitors_Mode',$_DATA['radLangVisitors']);

    ProdLer_Variable::Set('Theme_Config',$_DATA['selThemeConfig']);
    ProdLer_Variable::Set('Theme_Visitors',$_DATA['selThemeVisitors']);

    /*** oImage1 *************************************/
    $oColImages = new ProdLer_Collection_Images();
    if ($oImage1)
      $oColImages->IncludeObject($oImage1);

    $iLogoImage = ProdLer_Variable::Get('Logo_Image');
    if (!IsNothing($iLogoImage))
      $oColImages->DecrementReferenced($iLogoImage);

    if ($oImage1)
      ProdLer_Variable::Set('Logo_Image',$oImage1->iCod);
    else
      ProdLer_Variable::Clear('Logo_Image');

    /*** oImage2 *************************************/
    $oColImages = new ProdLer_Collection_Images();
    if ($oImage2)
      $oColImages->IncludeObject($oImage2);

    $iLogoIcon = ProdLer_Variable::Get('Logo_Icon');
    if (!IsNothing($iLogoIcon))
      $oColImages->DecrementReferenced($iLogoIcon);

    if ($oImage2)
      ProdLer_Variable::Set('Logo_Icon',$oImage2->iCod);
    else
      ProdLer_Variable::Clear('Logo_Icon');

  }

  $oSmarty = new Xsmarty();

  $oSmarty->assign('sReturn','./');
  $oSmarty->assign('sMessage',$sMessage);
  $oSmarty->display($sDisplay);

  require_once '../../include/exit.inc.php';

?>
