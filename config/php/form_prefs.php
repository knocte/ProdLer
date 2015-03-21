<?php

  require_once '../../include/init.inc.php';

  $oSmarty = new Xsmarty();

  $oColImages = new ProdLer_Collection_Images();

  $oSmarty->assign('iDefaultBenefit',Prodler_Variable::Get('Default_Benefit'));
  $oSmarty->assign('iBenefitType',Prodler_Variable::Get('Benefit_Type'));
 
  $oSmarty->assign('sTaxName',Prodler_Variable::Get('Tax_Name'));
  $oSmarty->assign('iTax',Prodler_Variable::Get('Tax'));
  $oSmarty->assign('iTaxQuantity',Prodler_Variable::Get('Tax_Quantity'));
  $oSmarty->assign('sTaxSentence',Prodler_Variable::Get('Tax_Sentence'));

  $oSmarty->assign('sDealerIDName',Prodler_Variable::Get('Dealer_ID_Name'));
  $oSmarty->assign('sDateSyntax',Prodler_Variable::Get('Date_Syntax'));
  $oSmarty->assign('sCurrencyName',Prodler_Variable::Get('Currency_Name'));
  $oSmarty->assign('sCurrencySymbol',Prodler_Variable::Get('Currency_Symbol'));
  $oSmarty->assign('sDecimalDivisor',Prodler_Variable::Get('Decimal_Divisor'));

  $oSmarty->assign('aLanguages',LanguagesAvailable($sPath));
  $oSmarty->assign('sLangConfig',Prodler_Variable::Get('Lang_Config'));
  $oSmarty->assign('iLangConfig',Prodler_Variable::Get('Lang_Config_Mode'));
  $oSmarty->assign('sLangVisitors',Prodler_Variable::Get('Lang_Visitors'));
  $oSmarty->assign('iLangVisitors',Prodler_Variable::Get('Lang_Visitors_Mode'));

  $oSmarty->assign('aThemes',ThemesAvailable($sPath));
  $oSmarty->assign('sThemeConfig',Prodler_Variable::Get('Theme_Config'));
  $oSmarty->assign('sThemeVisitors',Prodler_Variable::Get('Theme_Visitors'));

  $aImagesInfo = array();
  $aImageInfo1[] = Prodler_Variable::Get('Logo_Image');
  $aImageInfo1[] = _('Logo Image');
  $aImagesInfo[] = $aImageInfo1;
  $aImageInfo2[] = Prodler_Variable::Get('Logo_Icon');
  $aImageInfo2[] = _('Logo Icon');
  $aImagesInfo[] = $aImageInfo2;

  $oSmarty->assign('aImagesInfo',$aImagesInfo);
  $oSmarty->assign('aImages',$oColImages->ObtainList('filename','cod'));

  $oSmarty->display('form_prefs.htm.tpl');

  require_once '../../include/exit.inc.php';

?>