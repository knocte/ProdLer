<?php

  class ProdLer_Variable{

    //static
    function Get($sVariableName){
      $oDBH =& DB_ProdLer::StaticHandler(TRUE);
      $oDBH->Query("SELECT name,int_value,char_value FROM Variables"
                  ." WHERE name='$sVariableName'");

      if ($oDBH->iRows==0){
        require_once 'prefs.inc.php';
        return DefaultPref($sVariableName);
      }

      if (IsNothing($oDBH->aRecord[0]['char_value']))
        return $oDBH->aRecord[0]['int_value'];
      else
        return $oDBH->aRecord[0]['char_value'];
    }

    //static
    function Clear($sVariableName){
      $oDBH =& DB_ProdLer::StaticHandler(TRUE);
      $oDBH->Query("DELETE FROM Variables WHERE name='$sVariableName'");
    }

    //static
    function Set($sVariableName,$vValue){
      ProdLer_Variable::Clear($sVariableName);

      $oDBH =& DB_ProdLer::StaticHandler(TRUE);

      if (!is_numeric($vValue))
        $sType = 'char_value';
      else
        $sType = 'int_value';

      $vValue = FixValueSQL($vValue); 

      $oDBH->Query("INSERT INTO Variables(name,$sType) "
                  ."VALUES ('$sVariableName',$vValue)");
    }

  }

?>