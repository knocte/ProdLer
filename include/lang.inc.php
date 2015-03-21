<?php

  function LanguagesAvailable($sPath){
    $sLangPath = $sPath.'locale/';

    $aLangDirs = scandir($sLangPath);
    $aLanguages = array('en');

    foreach($aLangDirs as $sLangDir){
      $sLangFilePath = $sLangPath.$sLangDir.'/LC_MESSAGES/prodler.mo';
      if ((substr($sLangDir, 0, 1) != '.')&&
          (IsOneWord($sLangDir))&&
          (file_exists($sLangFilePath))&&
          (filesize($sLangFilePath)!=0))
      $aLanguages[] = $sLangDir;
    }

    return $aLanguages;
  }

  function LangDetection($sPath){
    if (ConfigZone()){
      $sDefaultLang = Prodler_Variable::Get('Lang_Config');
      if (Prodler_Variable::Get('Lang_Config_Mode')==2)
        return $sDefaultLang;
    }
    else{
      $sDefaultLang = Prodler_Variable::Get('Lang_Visitors');
      if (Prodler_Variable::Get('Lang_Visitors_Mode')==2)
        return $sDefaultLang;
    }

    $aLanguagesDetected = explode(",",substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'],';')));
    $aLanguagesAvailable = LanguagesAvailable($sPath);

    //echo "Languages Detected: ";
    //print_r($aLanguagesDetected);
    //echo "Languages Available: ";
    //print_r($aLanguagesAvailable);

    function UniformLangRef($sLangRef){
      //Example: converts 'en-US' to 'en_us'

      return str_replace('-', '_', strtolower($sLangRef));
    }

    function FirstLangPart($sLang){
      if (strstr($sLang,'_'))
        return substr($sLang, 0, strpos($sLang,'_'));
      else
        return $sLang;
    }

    function Catch($sLang1,$sLang2){
      return (UniformLangRef($sLang1)==UniformLangRef($sLang2));
    }

    function SemiCatch($sLang1,$sLang2){
      return (FirstLangPart(UniformLangRef($sLang1))==
              FirstLangPart(UniformLangRef($sLang2)));
    }

    $aSemiCatchBeforeLangs = array();

    foreach($aLanguagesDetected as $sLanguageDetected){

      $aSemiCatchLangs = array();

      foreach($aLanguagesAvailable as $sLanguageAvailable){
        if (!$aSemiCatchBeforeLangs &&
            Catch($sLanguageDetected,$sLanguageAvailable))
          return $sLanguageAvailable;
        else if (!$aSemiCatchBeforeLangs && 
                 SemiCatch($sLanguageDetected,$sLanguageAvailable))
          $sSemiCatchLangs[] = $sLanguageAvailable;
        else if ($aSemiCatchBeforeLangs &&
                 Catch($sLanguageDetected,$sLanguageAvailable)){
          foreach($aSemiCatchBeforeLangs as $sSemiCatchBeforeLang){
            if (SemiCatch($sSemiCatchBeforeLang,$sLanguageAvailable))
              return $sLanguageAvailable;
          }
        }
      }

      if (!$aSemiCatchBeforeLangs)
        $aSemiCatchBeforeLangs = $aSemiCatchLangs;
    }

    if (!$aSemiCatchBeforeLangs)
      return $sDefaultLang;
    else{
      foreach($aSemiCatchBeforeLangs as $sSemiCatchBeforeLang){
        if (Catch($sDefaultLang,$sSemiCatchBeforeLang))
          return $sDefaultLang;
      }
      return $aSemiCatchBeforeLangs[0];
    }


  }


  $sLanguage = LangDetection($sPath);
  //echo "Language applied: ".$sLanguage;

  if ($sLanguage!='en'){
    putenv("LANG=$sLanguage");
    /* $locale = */ setlocale(LC_ALL, $sLanguage);
    /* $locale = */ setlocale(LC_MESSAGES, $sLanguage);
    //echo "locale: ".$locale;

    $sDomain = 'prodler';
    bindtextdomain($sDomain,$sPath.'locale');
    textdomain($sDomain);
  }

?>
