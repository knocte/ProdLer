<?php

  require_once '../../include/init.inc.php';

  $_DATA = $_POST;
  $sOption = WhichOption($_DATA,'btnAdd','btnMod','btnDel','btnProd');

  $oSmarty = new Xsmarty();

  switch ($sOption) {
    case 'btnAdd':

      $oSmarty->assign('sAccessType',_('Dealer creation'));
      $oSmarty->assign('iDealerCod',0);
      $oSmarty->assign('iDealerPayment',0);
      $oSmarty->assign('sDealerIDName',Prodler_Variable::Get('Dealer_ID_Name'));
      $sDisplay='form_dealer.htm.tpl';

      break;
    case 'btnMod':
      $sDisplay='error.htm.tpl';

      if (IsNothing($_DATA['selDealer'])||($_DATA['selDealer']=='0')){
        $oSmarty->assign('sMessage',_('You have to select a particular dealer to modify an entry').'.');
        $oSmarty->assign('sReturn','form_dealers.php');
      }
      else if((!is_numeric($_DATA['selDealer']))
               ||($_DATA['selDealer']<0)
               ||(strlen($_DATA['selDealer'])>48)){

        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
        $oSmarty->assign('sReturn','form_dealers.php');
      }
      else{
        $oColDealers = new ProdLer_Collection_Dealers();
        $oDealer = $oColDealers->ObtainObject('cod',$_DATA['selDealer']);
        if (!$oDealer){
          $oSmarty->assign('sMessage',_('Dealer not found').'.');
          $oSmarty->assign('sReturn','form_dealers.php');
          $sDisplay='message.htm.tpl';
        }
        else{
          $oSmarty->assign('sAccessType',_('Dealer modification'));
          $oSmarty->assign('iDealerCod',$_DATA['selDealer']);
          $oSmarty->assign('sDealerName',$oDealer->sName);
          $oSmarty->assign('sDealerAlias',$oDealer->sAlias);
          $oSmarty->assign('sDealerURL',$oDealer->sURL);
          $oSmarty->assign('sDealerID',$oDealer->sID);
          $oSmarty->assign('sDealerAddress',$oDealer->sAddress);
          $oSmarty->assign('sDealerPhone1',$oDealer->sPhone1);
          $oSmarty->assign('sDealerPhone2',$oDealer->sPhone2);
          $oSmarty->assign('sDealerContact',$oDealer->sContact);
          $oSmarty->assign('iDealerPayment',$oDealer->iPayment);
          $oSmarty->assign('sDealerNotes',$oDealer->sNotes);

          $oSmarty->assign('sDateCreated',CustomDate($oDealer->aDateCreated));
          $oSmarty->assign('sDateModified',CustomDate($oDealer->aDateModified));

          $oSmarty->assign('sDealerIDName',Prodler_Variable::Get('Dealer_ID_Name'));
          $sDisplay='form_dealer.htm.tpl';
        }
      }

      break;
    case 'btnDel':

      $oSmarty->assign('sReturn','form_dealers.php');
      $sDisplay='error.htm.tpl';

      if (IsNothing($_DATA['selDealer'])||($_DATA['selDealer']=='0')){
        $oSmarty->assign('sMessage',_('You have to select a particular dealer to delete an entry').'.');
      }
      else if((!is_numeric($_DATA['selDealer']))
               ||($_DATA['selDealer']<0)
               ||(strlen($_DATA['selDealer'])>48)){

        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
      }
      else{
        $oColDealers = new ProdLer_Collection_Dealers();
        if($oColDealers->DeleteObject('cod',$_DATA['selDealer'])){
          $oSmarty->assign('sMessage',_('Dealer successfully deleted').'.');
          $sDisplay='message.htm.tpl';
        }
        else
          $oSmarty->assign('sMessage',_('You cannot delete a dealer which contains provisions').'.');
      }

      break;
    case 'btnProd':
      $sDisplay='form_products_post.htm.tpl';

      if (IsNothing($_DATA['selDealer'])||($_DATA['selDealer']=='0')){
        $oSmarty->assign('sMessage',_('You have to select a particular dealer to show its products').'.');
        $oSmarty->assign('sReturn','form_dealers.php');
        $sDisplay='error.htm.tpl';
      }
      else if((!is_numeric($_DATA['selDealer']))
               ||($_DATA['selDealer']<0)
               ||(strlen($_DATA['selDealer'])>48)){

        $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
        $oSmarty->assign('sReturn','form_dealers.php');
        $sDisplay='error.htm.tpl';
      }
      else{
        $oColDealers = new ProdLer_Collection_Dealers();
        $oDealer = $oColDealers->ObtainObject('cod',$_DATA['selDealer']);
        $oColProducts =& $oDealer->GetProductsCollection();

        $oSmarty->assign('aProducts',$oColProducts->ObtainProductsList());
        $oSmarty->assign('sSource',_('of dealer').' '.$oDealer->sAlias);
        $oSmarty->assign('iNumProducts',$oColProducts->Size());
        $oSmarty->assign('iDealerCod',$_DATA['selDealer']);
      }

      break;
    default:
      $oSmarty->assign('sMessage',_('Invalid data received from the form').'.');
      $oSmarty->assign('sReturn','form_dealers.php');
      $sDisplay='error.htm.tpl';
      break;
  }

  $oSmarty->display($sDisplay);

  require_once '../../include/exit.inc.php';

?>