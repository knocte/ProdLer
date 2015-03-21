<?php

  class ProdLer_Collection_Brands extends ProdLer_Collection {
    var $sTableName='Brands';

    //public
    function DeleteObject($sKey,$vValue){
      if (($sKey=='cod')&&(is_numeric($vValue))){
        $oBrand = $this->ObtainObject('cod',$vValue);
        $oColProducts =& $oBrand->GetProductsCollection();
        if ($oColProducts->Size()>0)
          return FALSE;
        $this->DecrementReferencedImage($vValue);
      }

      $this->DeleteObjectAux($sKey,$vValue);

      return TRUE;
    }


    //public
    function IncludeObject(&$oBrand){
      $oDBH =& $this->GetDBHandler();

      $oColBrands = new ProdLer_Collection_Brands();
      $oColBrands->Limit('name',$oBrand->sName);
      if ($oColBrands->Size() > 0)
        return FALSE;

      $iImageCod = 0;
      $sImageFilename = '';
      if ($oBrand->oImage){
        $oColImages = new ProdLer_Collection_Images();
        if (!$oColImages->IncludeObject($oBrand->oImage))
          return FALSE;
        $iImageCod = $oBrand->oImage->iCod;
        $sImageFilename = $oBrand->oImage->sFileName;
      }

      $oBrand->SetCod($this->InsertionCode());
      $oDBH->Query("INSERT INTO $this->sTableName (cod,name,url,date_created,img_cod,img_filename)"
                  ." VALUES ($oBrand->iCod,'$oBrand->sName','$oBrand->sURL',"
                  .$oDBH->NowDateTime().','.$iImageCod.",'".$sImageFilename."')");

      return TRUE;
    }


    //public
    function &ObtainObject($sKey,$vID){
      $oObj = NULL;

      if ($vID==0)
        $oObj = new ProdLer_Brand('['._('ALL BRANDS').']');
      else{
        $oDBH =& $this->ObtainObjectAux($sKey,$vID);

        if ($oDBH->iRows != 1)
          return $oObj;

        $aBrandRecord = $oDBH->aRecord[0];

        $oColImages = new ProdLer_Collection_Images();
        $oImage = $oColImages->ObtainObject('cod',$aBrandRecord['img_cod']);

        $oObj = new ProdLer_Brand($aBrandRecord['cod'],
                                  $aBrandRecord['name'],
                                  $aBrandRecord['url'],
                                  $oDBH->DB2Date($aBrandRecord['date_created']),
                                  $oDBH->DB2Date($aBrandRecord['date_modified']),
                                  $oImage);
      }

      return $oObj;
    }

    //public
    function &ObtainObjectsList(){
      $aBrands = $this->ObtainList('name','cod');

      if (!$aBrands)
        return NULL;

      $aObjects = array();
      foreach($aBrands as $aBrand)
        $aObjects[] = $this->ObtainObject('cod',$aBrand['cod']);

      return $aObjects;
    }

    //public
    function UpdateObject($oBrand){
      $oColBrands = new ProdLer_Collection_Brands();

      $oColBrands->Limit('name',$oBrand->sName);
      $oColBrands->Exception('cod',$oBrand->iCod);
      if ($oColBrands->Size() > 0)
        return FALSE;

      $iImageCod = 0;
      $sImageFilename = '';
      if ($oBrand->oImage){
        $oColImages = new ProdLer_Collection_Images();
        if (!$oColImages->IncludeObject($oBrand->oImage))
          return FALSE;
        $iImageCod = $oBrand->oImage->iCod;
        $sImageFilename = $oBrand->oImage->sFileName;
      }
      $this->DecrementReferencedImage($oBrand->iCod);

      $oDBH =& $this->GetDBHandler();
      $oDBH->Query("UPDATE $this->sTableName SET name='$oBrand->sName',"
                  ."url='$oBrand->sURL',date_modified=".$oDBH->NowDateTime()
                  .",img_cod=$iImageCod,img_filename='$sImageFilename'"
                  ." WHERE cod=$oBrand->iCod");

      return TRUE;
    }

  }

?>