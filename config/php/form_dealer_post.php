<?php

  require_once '../../include/init.inc.php';

  $_DATA = $_POST;

  $sDisplay='error.htm.tpl';

  if (IsNothing($_DATA['txtDealerName'])){
    $sMessage = _('Dealer name is a required field').'.';
  }
  else if (IsNothing($_DATA['txtDealerAlias'])){
    $sMessage = _('Dealer alias is a required field').'.';
  }
  else if (IsNothing($_DATA['hidDealerCod'])
           ||(!is_numeric($_DATA['hidDealerCod']))
           ||($_DATA['hidDealerCod']<0)
           ||(IsNothing($_DATA['selDealerPayment']))
           ||(!is_numeric($_DATA['selDealerPayment']))
           ||($_DATA['selDealerPayment']<0)
           ||(strlen($_DATA['selDealerPayment'])>3)){
    $sMessage = _('Invalid data received from the form').'.';
  }
  else if (strlen($_DATA['txtDealerName'])>48){
    $sMessage = _('You have exceeded the maximum number of characters for the dealer name').'.';
  }
  else if (strlen($_DATA['txtDealerAlias'])>13){
    $sMessage = _('You have exceeded the maximum number of characters for the dealer alias').'.';
  }
  else if ((!IsNothing($_DATA['txtDealerURL']))&&(strlen($_DATA['txtDealerURL'])>48)){
    $sMessage = _('You have exceeded the maximum number of characters for the dealer URL').'.';
  }
  else if ((!IsNothing($_DATA['txtDealerURL']))&&(!IsOneWord($_DATA['txtDealerURL']))){
    $sMessage = _('URL cannot have spaces').'.';
  }
  else if ((!IsNothing($_DATA['txtDealerID']))&&(strlen($_DATA['txtDealerID'])>13)){
    $sMessage = _('You have exceeded the maximum number of characters for the ')
              . Prodler_Variable::Get('Dealer_ID_Name').'.';
  }
  else if ((!IsNothing($_DATA['txaDealerAddress']))&&(strlen($_DATA['txaDealerAddress'])>253)){
    $sMessage = _('You have exceeded the maximum number of characters for the dealer address').'.';
  }
  else if ((!IsNothing($_DATA['txtDealerPhone1']))&&(strlen($_DATA['txtDealerPhone1'])>13)){
    $sMessage = _('You have exceeded the maximum number of characters for a phone field').'.';
  }
  else if ((!IsNothing($_DATA['txtDealerPhone2']))&&(strlen($_DATA['txtDealerPhone2'])>13)){
    $sMessage = _('You have exceeded the maximum number of characters for a phone field').'.';
  }
  else if ((!IsNothing($_DATA['txtDealerContact']))&&(strlen($_DATA['txtDealerContact'])>28)){
    $sMessage = _('You have exceeded the maximum number of characters for the dealer contact').'.';
  }
  else if ((!IsNothing($_DATA['txaDealerNotes']))&&(strlen($_DATA['txaDealerNotes'])>253)){
    $sMessage = _('You have exceeded the maximum number of characters for the notes').'.';
  }
  else{
    $sDisplay='message.htm.tpl';

    $sDealerName = FixString($_DATA['txtDealerName']);
    $sDealerAlias = FixString($_DATA['txtDealerAlias']);
    $sDealerURL = FixString($_DATA['txtDealerURL']);
    $sDealerID = FixString($_DATA['txtDealerID']);
    $sDealerAddress = FixString($_DATA['txaDealerAddress']);
    $sDealerPhone1 = FixString($_DATA['txtDealerPhone1']);
    $sDealerPhone2 = FixString($_DATA['txtDealerPhone2']);
    $sDealerContact = FixString($_DATA['txtDealerContact']);
    $sDealerNotes = FixString($_DATA['txaDealerNotes']);

    if ($_DATA['hidDealerCod']=='0'){
      //Dealer creation

      $oDealer = new ProdLer_Dealer($sDealerName,$sDealerAlias);
      $oDealer->SetURL($sDealerURL);
      $oDealer->SetID($sDealerID);
      $oDealer->SetAddress($sDealerAddress);
      $oDealer->SetPhone1($sDealerPhone1);
      $oDealer->SetPhone2($sDealerPhone2);
      $oDealer->SetContact($sDealerContact);
      $oDealer->SetPayment($_DATA['selDealerPayment']);
      $oDealer->SetNotes($sDealerNotes);

      $oColDealers = new ProdLer_Collection_Dealers();
      if ($oColDealers->IncludeObject($oDealer))
        $sMessage=_('The dealer has been successfully created').'.';
      else{
        $sMessage=_('There is already a dealer with the same name, alias or ')
                 .Prodler_Variable::Get('Dealer_ID_Name').'.';
        $sDisplay='error.htm.tpl';
      }

    }
    else{
      //Dealer modification

      $oColDealers = new ProdLer_Collection_Dealers();
      $oDealer = $oColDealers->ObtainObject('cod',$_DATA['hidDealerCod']);

      if (!$oDealer)
        $sMessage=_('Dealer not found').'.';
      else{
        $oDealer->SetName($sDealerName);
        $oDealer->SetAlias($sDealerAlias);

        $oDealer->SetURL($sDealerURL);
        $oDealer->SetID($sDealerID);
        $oDealer->SetAddress($sDealerAddress);
        $oDealer->SetPhone1($sDealerPhone1);
        $oDealer->SetPhone2($sDealerPhone2);
        $oDealer->SetPayment($_DATA['selDealerPayment']);
        $oDealer->SetContact($sDealerContact);

        $oDealer->SetNotes($sDealerNotes);

        if ($oColDealers->UpdateObject($oDealer))
          $sMessage=_('The dealer has been successfully modified').'.';
        else{
          $sMessage=_('There is already a dealer with the same name, alias or ')
                   .Prodler_Variable::Get('Dealer_ID_Name').'.';
          $sDisplay='error.htm.tpl';
        }
      }
    }
  }

  $oSmarty = new Xsmarty();

  $oSmarty->assign('sReturn','form_dealers.php');
  $oSmarty->assign('sMessage',$sMessage);
  $oSmarty->display($sDisplay);

  require_once '../../include/exit.inc.php';

?>