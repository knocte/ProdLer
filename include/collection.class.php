<?php

  //abstract
  class ProdLer_Collection {
    var $sClassDB    = 'DB_ProdLer';
    var $sTableName;
    var $aLimits     = array();
    var $aExceptions = array();
    var $aRelations  = array();

    var $aSearchFields = array();
    var $aSearchTerms  = array();

    var $oDBHandler;


    //private
    function DeleteObjectAux($sKey,$vValue){
      $oDBH =& $this->GetDBHandler();

      $vValue = FixValueSQL($vValue);

      $oDBH->Query("DELETE FROM $this->sTableName WHERE $sKey = $vValue");
    }


    //private
    function GetDBHandler(){
      if (!$this->oDBHandler){
        $sEval = '$this->oDBHandler =& '.$this->sClassDB.'::StaticHandler(TRUE);';
        eval($sEval);
      }

      return $this->oDBHandler;
    }


    //private
    function GetTables(){
      $sTables = $this->sTableName;

      foreach($this->aRelations as $aRelation){
        $oCollection =& $aRelation[1];
        $sTables .= ','.$oCollection->sTableName;
      }

      return $sTables;
    }


    //private
    function InsertionCode(){
      $oDBH =& $this->GetDBHandler();

      $iCod = 1;
      $oDBH->Query("SELECT cod FROM $this->sTableName ORDER BY cod");

      $i = 0;
      $bEnd = FALSE;
      while($i<$oDBH->iRows && !$bEnd){
        if ($oDBH->aRecord[$i]['cod'] != $iCod)
          $bEnd = TRUE;
        else{
          $iCod++;
	    $i++;
	  }
      }

      return $iCod;
    }


    //private
    function &ObtainObjectAux($sKey,$vValue){
      $oDBH =& $this->GetDBHandler();

      $vValue = FixValueSQL($vValue);

      $oDBH->Query("SELECT * FROM $this->sTableName WHERE $sKey = $vValue");

      return $oDBH;
    }


    //private static
    function SplitSearch($sTerms){
    //splits a search string into smallest substrings
    //i.e.: term1 "larger term 2" "term3" -> 
    //   -> Array ( [0] => term1 [1] => larger term 2 [3] => term3 )

      $aDoubleQuotes = explode('"',$sTerms);
      $aFinalResult = array();

      foreach($aDoubleQuotes as $iKey => $sPart){
        if (!IsNothing($sPart)){
          if (Even($iKey))
            $aFinalResult = array_merge($aFinalResult,
                                        explode(' ',trim($sPart)));
          else
            $aFinalResult[]= $sPart;
        }
      }

      return $aFinalResult;
    }


    //public
    function AddSearchField($sSearchField){
      $this->aSearchFields[] = $sSearchField;
    }


    //public
    function AddSearchTerms($sSearchTerms){
      $this->aSearchTerms = $this->SplitSearch($sSearchTerms);
    }


    //public
    function DecrementReferencedImage($iCod){
      $oDBH =& $this->GetDBHandler();
      $oDBH->Query("SELECT img_cod FROM ".$this->GetTables()." WHERE cod=$iCod");

      $iImageCod = $oDBH->aRecord[0]['img_cod'];

      if ((!(IsNothing($iImageCod)))&&(is_numeric($iImageCod))&&($iImageCod!=0)){
        $oColImages = new ProdLer_Collection_Images();
        $oColImages->DecrementReferenced($iImageCod);
      }
    }


    //public
    function DeleteObjects(){
      $oDBH =& $this->GetDBHandler();

      $oDBH->Query("DELETE FROM $this->sTableName ".$this->Where());
    }

    //public
    function Exception($sKey,$vValue){
      $aException = array();

      $aException[] = $sKey;
      $aException[] = FixValueSQL($vValue);

      $this->aExceptions[] = $aException;
    }


    //public
    function Limit(/* many args */){
    // adds "(arg0 = arg1 OR arg0 = arg2)"
    // to the WHERE clause

      $iNumArgs = func_num_args();

      $aValues = array();
      $aLimit = array();

      if ($iNumArgs > 1){
        $aLimit[] = func_get_arg(0);

        for ($i = 1; $i < $iNumArgs; $i++) {
          $aValues[] = FixValueSQL(func_get_arg($i));
        }

        $aLimit[] = $aValues;
        $this->aLimits[] = $aLimit;
      }
    }


    //public
    function LimitMultiple($sColumn,$aValues){
    // Similar functionality as 
    // function "Limit"

      if ($aValues){
        $aLimit = array();

        $aLimit[] = $sColumn;

        foreach($aValues as $iKey => $vValue) {
          $aValues[$iKey] = FixValueSQL($vValue);
        }

        $aLimit[] = $aValues;
        $this->aLimits[] = $aLimit;
      }

    }


    //public
    function &ObtainList(){
      $sSelect = '';
      $bFirst = TRUE;

      if (func_num_args()>0){
        $aStrings = func_get_args();

        $bRenamedColumns=FALSE;

        foreach($aStrings as $sColumn){
          if (!$bFirst)
            $sSelect .= ',';
          else
            $bFirst = FALSE;

          $bRenamedColumn=FALSE;
          if ($this->aRelations){
            foreach($this->aRelations as $aRelation){
              if ((!$bRenamedColumn)&&
                  ($aRelation[0]==$sColumn)&&(!IsNothing($aRelation[3]))){
                $bRenamedColumn=TRUE;
                $bRenamedColumns=TRUE;

                $oCollection =& $aRelation[1];

                $sSelect .= $oCollection->sTableName.'.'.$aRelation[3];
              }
            }
          }

          if (!$bRenamedColumn)
            $sSelect .= "$this->sTableName.$sColumn";
        }
      }
      else
        $sSelect = '*';

      $oDBH =& $this->GetDBHandler();

      $oDBH->Query("SELECT $sSelect FROM ".$this->GetTables().' '
                   .$this->Where()." ORDER BY $sSelect");

      if (!$bRenamedColumns)
        return $oDBH->aRecord;


      //////////////////////////////////////////////////////////
      // Code to fix the array returned by the DB
      // when there are renamed columns

      $aRecord = $oDBH->aRecord;
      $aNewRecord = array();

      foreach($aRecord as $aElement){
        $aNewElement = $aElement;

        foreach($this->aRelations as $aRelation){
          if (!IsNothing($aRelation[3])){
            $sColumn = $aRelation[3];
            $sOldColumn = $aRelation[0];

            $aNewElement[$sOldColumn] = $aElement[$sColumn];
          }
        }

        $aNewRecord[] = $aNewElement;
      }

      return $aNewRecord;                                      //
                                                               //
      ///////////////////////////////////////////////////////////
    }


    //public
    function Relation($sOwnColumn,$oCollection,$sForeignColumn){

      $sOwnColumn = func_get_arg(0);
      $oCollection = func_get_arg(1);
      $sForeignColumn = func_get_arg(2);

      if (func_num_args()>3)
        $sRenameColumn = func_get_arg(3);
      else
        $sRenameColumn = '';

      $aRelation = array();

      $aRelation[] = $sOwnColumn;
      $aRelation[] = $oCollection;
      $aRelation[] = $sForeignColumn;
      $aRelation[] = $sRenameColumn;

      $this->aRelations[] = $aRelation;

    }


    //public
    function Size(){
      $oDBH =& $this->GetDBHandler();

      $oDBH->Query("SELECT COUNT(*) FROM ".$this->GetTables().' '.$this->Where());

      return $oDBH->aRecord[0][0];
    }


    //public
    function Where(){
      if ((!$this->aLimits)&&(!$this->aExceptions)&&(!$this->aRelations)
          &&((!$this->aSearchFields)||(!$this->aSearchTerms)))
        return '';

      $sWhereSQL = 'WHERE ';

      $bFirst1 = TRUE;

      if ($this->aLimits){
        foreach($this->aLimits as $aLimit){
          if (!$bFirst1)
            $sWhereSQL .= ' AND ';
          else
            $bFirst1 = FALSE;

          $sWhereSQL .= '(';

          $sColumn = $aLimit[0];
          $bFirst2 = TRUE;
          foreach($aLimit[1] as $sValue){
            if (!$bFirst2)
              $sWhereSQL .= ' OR ';
            else
              $bFirst2 = FALSE;

            $sWhereSQL .= "$this->sTableName.$sColumn=$sValue";
          }
          $sWhereSQL .= ')';
        }
      }

      if ($this->aExceptions){
        foreach($this->aExceptions as $aException){
          if (!$bFirst1)
            $sWhereSQL .= ' AND ';
          else
            $bFirst1 = FALSE;

          $sWhereSQL .= "($this->sTableName.".$aException[0].'!='.$aException[1].')';
        }
      }

      if ($this->aRelations){
        foreach($this->aRelations as $aRelation){
          if (!$bFirst1)
            $sWhereSQL .= ' AND ';
          else
            $bFirst1 = FALSE;

          $oCollection =& $aRelation[1];
          $sWhereSQL .= "($this->sTableName.".$aRelation[0]
                     ."=$oCollection->sTableName.".$aRelation[2].')';

          $sWhereRelation =& $oCollection->Where();
          if (!IsNothing($sWhereRelation))

            //ATTENTION: strlen('WHERE ')==6
            $sWhereSQL .= ' AND '.substr($sWhereRelation, 6); 
        }
      }

      if (($this->aSearchFields)&&($this->aSearchTerms)){
        if (!$bFirst1)
          $sWhereSQL .= ' AND ';
        else
          $bFirst1 = FALSE;

        $sWhereSQL .= '(';
        $bFirst2 = TRUE;

        foreach($this->aSearchTerms as $sTerm){

          if (!$bFirst2)
            $sWhereSQL .= ' AND ';
          else
            $bFirst2 = FALSE;

          $sWhereSQL .= '(';
          $bFirst3 = TRUE;

          foreach($this->aSearchFields as $sField){
            if (!$bFirst3)
              $sWhereSQL .= ' OR ';
            else
              $bFirst3 = FALSE;

            $sWhereSQL .= $this->sTableName . '.' .$sField." LIKE '%".$sTerm."%'";
          }

          $sWhereSQL .= ')';
        }
        $sWhereSQL .= ')';
      }

      return $sWhereSQL;
    }


  }

?>