<?php

  $bNotCheckStatus = TRUE;

  require_once '../../include/init.inc.php';

  $_DATA = $_POST;

  $sCompanyName = 'ProdLer';
  $sCompanyURL = '';

  $sDisplay='error.htm.tpl';

  if (IsNothing($_DATA['txtCompanyName'])){
    $sMessage = _('Company name is a required field').'.';
  }
  else if (strlen($_DATA['txtCompanyName'])>48){
    $sMessage = _('You have exceeded the maximum number of characters for the company name').'.';
  }
  else if ((!IsNothing($_DATA['txtCompanyURL']))&&(strlen($_DATA['txtCompanyURL'])>48)){
    $sMessage = _('You have exceeded the maximum number of characters for the company URL').'.';
  }
  else if ((!IsNothing($_DATA['txtCompanyURL']))&&(!IsOneWord($_DATA['txtCompanyURL']))){
    $sMessage = _('URL cannot have spaces').'.';
  }
  else{
    
    ProdLer_Variable::Set('Company_Name',FixString($_DATA['txtCompanyName']));
    ProdLer_Variable::Set('Company_URL',FixString($_DATA['txtCompanyURL']));

    $sMessage=_('Preferences have been successfully initialized').'.';

    $sDisplay='message.htm.tpl';

  }

  $oSmarty = new Xsmarty();
  $oSmarty->assign('sCompanyName',$sCompanyName);
  $oSmarty->assign('sCompanyURL',$sCompanyURL);
  $oSmarty->assign('sReturn','./');
  $oSmarty->assign('sMessage',$sMessage);
  $oSmarty->display($sDisplay);

  require_once '../../include/exit.inc.php';

?>