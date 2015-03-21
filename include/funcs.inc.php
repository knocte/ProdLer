<?php

  function InvalidWhenDefined($iOption,$iMin){
    if (!$iOption)
      return FALSE;
    if (!is_numeric($iOption)||
        ($iOption<$iMin)||
        (strlen($iOption)>48))
      return TRUE;
    return FALSE;
  }

  function CheckProdlerStatus(){
    if (IsNothing(ProdLer_Variable::Get('Company_Name')))
      InitializeProdler();
  }

  function InitializeProdler(){
    $sInitForm = 'form_name.php';

    if (ConfigZone())
      Redirect($sInitForm);
    else
      Redirect('../config/php/'.$sInitForm);
  }

  //Function to prevent HTML escaping in JS alert boxes
  function js($sNoEscape){
    return strtr($sNoEscape, array_flip(get_html_translation_table(HTML_ENTITIES)));
  }

  function __($sTranslate){
    return CustomEscape(_($sTranslate));
  }

  function CustomEscape($vSmartyVariable){
    if (is_string($vSmartyVariable))
      return htmlentities($vSmartyVariable, ENT_QUOTES, 'ISO-8859-15');

    return $vSmartyVariable;
  }

  function ConfigZone(){
    return strstr($_SERVER['PHP_SELF'],'/config/');
  }

  function ThemesAvailable($sPath){
    $sStylePath = $sPath.'themes/';

    $aStyleDirs = scandir($sStylePath);
    $aStyles = array();

    foreach($aStyleDirs as $sStyleDir){
      if ((substr($sStyleDir, 0, 1) != '.')&&
          ($sStyleDir!='common.css'))
        $aStyles[] = $sStyleDir;
    }

    return $aStyles;
  }

  function Even($iNumber){
    return (($iNumber % 2)==0);
  }

  //Function to correct bad behaviour of some versions of IE
  //when handling image types.
  function FixImageType($sType){
    $sType = str_replace('pjpeg','jpg',$sType);
    return str_replace('jpeg','jpg',$sType);
  }

  //According to http://www.php.net/manual/en/function.scandir.php ,
  //this will not be needed with PHP5.
  function scandir($sPath){
    $oHandler  = opendir($sPath);
    $aFiles = array();

    while (FALSE !== ($sFilename = readdir($oHandler)))
      $aFiles[] = $sFilename;

    rsort($aFiles);

    return $aFiles;
  };

  function CustomDate($aDate){
    if (!$aDate)
      return _('NEVER');

    $sDate = ProdLer_Variable::Get('Date_Syntax');

    $sDate = str_replace('d',$aDate['d'],$sDate);
    $sDate = str_replace('m',$aDate['m'],$sDate);
    $sDate = str_replace('y',$aDate['y'],$sDate);

    return $sDate;
  }

  function FullURL($sResource){
    return 'http://'
           .$_SERVER['HTTP_HOST']
           .dirname($_SERVER['PHP_SELF'])
           .'/'.$sResource;
  }

  function LocalURL($sResource){
    return 'http://localhost/'
           .dirname($_SERVER['PHP_SELF'])
           .'/'.$sResource;
  }

  function Redirect($sResource){
    // regarding comments on: http://es2.php.net/header#37928

    header("HTTP/1.0 200 OK");
    header("HTTP/1.1 303 REDIRECT");

    $sURL = FullURL($sResource);

    header("Location: $sURL");
    header('Status: 303');
    header('Connection: close');
    exit('Redirected: <a href="'.$sURL.'">'.$sURL.'</a>.');
  }

  function FixPrice($sNumber){
    $sSymbol = ProdLer_Variable::Get('Decimal_Divisor');

    $iNumber = str_replace(",",$sSymbol,stripslashes($sNumber));
    $iNumber = str_replace("'",$sSymbol,$iNumber);
    $iNumber = str_replace(".",$sSymbol,$iNumber);

    return $iNumber;
  }

  function Price2DB($sNumber){
    $iNumber = str_replace(',','.',stripslashes($sNumber));
    $iNumber = str_replace("'",'.',$iNumber);
    $iNumber = str_replace("\'",'.',$iNumber);

    return $iNumber;
  }

  function DB2Price($iNumber){
    $sSymbol = ProdLer_Variable::Get('Decimal_Divisor');

    $sNumber = str_replace(".",$sSymbol,$iNumber);

    return $sNumber;
  }

  function FinalPrice($iNumber){
    $iNumber = sprintf("%.2f",$iNumber);

    return FixPrice($iNumber);
  }

  function TA2DB($sTA){
    $sDB = ereg_replace("\r\n","\\\\r\\\\n",$sTA);
    $sDB = ereg_replace("\r","\\\\r\\\\n",$sDB);
    $sDB = ereg_replace("\n","\\\\r\\\\n",$sDB);

    return $sDB;
  };

  function DB2TA($sDB){
    $sTA = ereg_replace("\\\\r\\\\n","\r\n",$sDB);

    return $sTA;
  };

  function FixValueSQL($vValue){
    if (is_numeric($vValue))
      return $vValue;
    return "'$vValue'";
  }

  function IsNothing($sString){
  //returns true if string is null
  //or empty or only contains spaces

    return (!isset($sString) || ($sString == NULL) || (trim($sString) == ''));
  }

  function IsOneWord($string){
  // returns true if string has no spaces
  // inside the trimmed string

    $i=0;
    $space=FALSE;
    $sTrimmed = trim($string);

    if (strlen($sTrimmed)==0)
      return FALSE;

    $length = strlen($sTrimmed);

    while(!$space && ($i<$length)){
      if (substr($sTrimmed,$i,1) == ' ')
        $space=TRUE;
      else
        $i++;
    }

    return !$space;
  }

  function WhichDelete($iMax){
    for ($i = 0; $i < $iMax; $i++) {
      $sButton = 'btnDelPrice'.$i;
      if (!IsNothing($_POST[$sButton]))
        return $i;
    }
    return -1;
  };

  function WhichOption(/* many args */){
    $aStrings = func_get_args();

    $bFirst = TRUE;
    foreach($aStrings as $sGetVariable){
      if ($bFirst)
        $bFirst = FALSE;

      else if (!IsNothing($aStrings[0][$sGetVariable]))
        return $sGetVariable;
    }
    return NULL;
  }

  function RemoveElement($aArray,$iIndex){

    $iCount=count($aArray)-1;

    switch($iIndex){
      case 0:
        $aArray = array_slice($aArray, 1);
      break;
      case $iCount:
        $aArray = array_slice($aArray, 0,-1);
      break;
      default:
        $aArrayStart = array_slice($aArray,0, $iIndex);
        $aArrayEnd = array_slice($aArray, $iIndex+1);
        $aArray = array_merge ($aArrayStart, $aArrayEnd);
      break;
    }

    return $aArray;
  }

  function FixString($string){
    return ereg_replace(' +', ' ', trim($string));
  }

  function Xstripslashes($vVar){
    return is_array($vVar) ? array_map('Xstripslashes', $vVar) : stripslashes($vVar);
  }

  function Xhtmlspecialchars($vVar){
    return is_array($vVar) ? array_map('Xhtmlspecialchars', $vVar) : htmlspecialchars($vVar);
  }

  function Ahtmlspecialchars($vVar){
    return is_array($vVar) ? $vVar : htmlspecialchars($vVar);
  }

?>
