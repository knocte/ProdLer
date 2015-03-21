<?php

  function DefaultPref($sPrefName){
    switch($sPrefName){
      case 'Benefit_Type'      : return      1 ;
      case 'Currency_Name'     : return 'euros';
      case 'Currency_Symbol'   : return     '€';
      case 'Date_Syntax'       : return 'd-m-y';
      case 'Dealer_ID_Name'    : return   'CIF';
      case 'Decimal_Divisor'   : return     "'";
      case 'Decimal_Numbers'   : return      2 ;
      case 'Default_Benefit'   : return     15 ;
      case 'Lang_Visitors'     : return    'en';
      case 'Lang_Visitors_Mode': return      1 ;
      case 'Lang_Config'       : return    'en';
      case 'Lang_Config_Mode'  : return      1 ;
      case 'Tax'               : return      1 ;
      case 'Tax_Name'          : return   'IVA';
      case 'Tax_Quantity'      : return     16 ;
      case 'Tax_Sentence'      : return '* '.DefaultPref('Tax_Name').' '._('not included').' *';
      case 'Theme_Config'      : return 'plain';
      case 'Theme_Visitors'    : return 'plain';
      default                  : return     '' ;
    }
  }

?>
