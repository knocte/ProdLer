<?php

  class ProdLer_Collection_Images extends ProdLer_Collection {
    var $sTableName  = 'Images_info';
    var $sClassDB    = 'DB_ProdLer_Images';


    //public
    function IncludeObject(&$oImage){
      $oDBH =& $this->GetDBHandler();

      $oColImages = new ProdLer_Collection_Images();
      if ($oImage->iCod > 0){
        //Increment referenced attribute
        $oColImages->Limit('cod',$oImage->iCod);
        $aReferenced = $oColImages->ObtainList('referenced');
        $iNewReferenced = $aReferenced[0]['referenced']+1;
        $oDBH->Query("UPDATE Images_info SET referenced=$iNewReferenced WHERE cod=".$oImage->iCod);
      }
      else{
        $oColImages->Limit('filename',$oImage->sFileName);
        if ($oColImages->Size() > 0)
          return FALSE;

        $oImage->SetCod($this->InsertionCode());
        $oDBH->Query('INSERT INTO Images_info(cod,filename,type,size,referenced) VALUES('.$oImage->iCod.",'"
                  .$oImage->sFileName."','".$oImage->sType."',".$oImage->iSize.",1)");
        $oDBH->Query('INSERT INTO Images_data (cod, filedata) VALUES('.$oImage->iCod.",'".$oImage->GetData()."')");

      }

      return TRUE;
    }

    //public
    function DecrementReferenced($iCod){
      $oDBH =& $this->GetDBHandler();

      $oDBH->Query("SELECT referenced FROM Images_info WHERE cod=$iCod");

      if ($oDBH->aRecord[0]['referenced'] < 2){
        $oDBH->Query("DELETE FROM Images_info WHERE cod=$iCod");
        $oDBH->Query("DELETE FROM Images_data WHERE cod=$iCod");
      }
      else{
        $iNewReferenced = $oDBH->aRecord[0]['referenced']-1;
        $oDBH->Query('UPDATE Images_info SET referenced='.$iNewReferenced." WHERE cod=$iCod");
      }
    }


    //public
    function &ObtainObject($sKey,$vID){
      $oObj = NULL;

      $oDBH =& $this->ObtainObjectAux($sKey,$vID);

      if ($oDBH->iRows != 1)
        return $oObj;

      $oObj = new ProdLer_Image($oDBH->aRecord[0]['cod'],
                                $oDBH->aRecord[0]['filename'],
                                $oDBH->aRecord[0]['type'],
                                $oDBH->aRecord[0]['size'],
                                $oDBH->aRecord[0]['description']);

      return $oObj;
    }

  }

?>