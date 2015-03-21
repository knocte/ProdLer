<?php

  class ProdLer_Collection_Products extends ProdLer_Collection {
    var $sTableName='Products';


    //public
    function DeleteObject($sKey,$vValue){
      if (($sKey=='cod')&&is_numeric($vValue)){
        $oColProvisions = new ProdLer_Collection_Provisions();
        $oColProvisions->Limit('product',$vValue);

        $oColProvisions->DeleteObjects($vValue);

        $this->DecrementReferencedImage($vValue);
      }

      $this->DeleteObjectAux($sKey,$vValue);

      return TRUE;
    }


    //public
    function IncludeObject(&$oProduct){
      $oColProducts = new ProdLer_Collection_Products();
      $oColProducts->Limit('model',$oProduct->sModel);
      $oColProducts->Limit('brand',$oProduct->oBrand->iCod);
      if ($oColProducts->Size() > 0)
        return FALSE;

      $iImageCod = 0;
      $sImageFilename = '';
      if ($oProduct->oImage){
        $oColImages = new ProdLer_Collection_Images();
        if (!$oColImages->IncludeObject($oProduct->oImage))
          return FALSE;
        $iImageCod = $oProduct->oImage->iCod;
        $sImageFilename = $oProduct->oImage->sFileName;
      }

      $oDBH =& $this->GetDBHandler();

      $oProduct->SetCod($this->InsertionCode());
      $oDBH->Query("INSERT INTO $this->sTableName (cod,model,brand,category,"
                  .'description,characts,specs,date_created'
                  .',img_cod,img_filename) VALUES '
                  ."($oProduct->iCod,'$oProduct->sModel',"
                  .$oProduct->oBrand->iCod.','
                  .$oProduct->oCategory->iCod.",'"
                  .$oProduct->sDescription."','"
                  .TA2DB($oProduct->sCharacts)."','"
                  .TA2DB($oProduct->sSpecs)."',"
                  .$oDBH->NowDateTime().','
                  .$iImageCod.",'".$sImageFilename."')");

      if ($oProduct->aProvisions){
        $oColProvisions = new ProdLer_Collection_Provisions();

        foreach($oProduct->aProvisions as $oProvision)
          $oColProvisions->IncludeObject($oProduct->iCod,$oProvision);
      }

      return TRUE;
    }


    //public
    function &ObtainObject($sKey,$vID){
      $oObj = NULL;

      $oDBH =& $this->ObtainObjectAux($sKey,$vID);

      if ($oDBH->iRows != 1)
        return $oObj;

      $aProductRecord = $oDBH->aRecord[0];

      $oColBrands = new ProdLer_Collection_Brands();
      $oBrand = $oColBrands->ObtainObject('cod',$aProductRecord['brand']);

      $oColCategories = new ProdLer_Collection_Categories();
      $oCategory = $oColCategories->ObtainObject('cod',$aProductRecord['category']);

      if ((!$oBrand)||(!$oCategory))
        return $oObj;

      $oColProvisions = new ProdLer_Collection_Provisions();
      $oColProvisions->Limit('product',$vID);
      $aProvisions = $oColProvisions->GetObjects();

      $oColImages = new ProdLer_Collection_Images();
      $oImage = $oColImages->ObtainObject('cod',$aProductRecord['img_cod']);

      $oObj = new ProdLer_Product($aProductRecord['cod'],
                                  $aProductRecord['model'],
                                  $oBrand,
                                  $oCategory,
                                  $aProductRecord['description'],
                                  DB2TA($aProductRecord['characts']),
                                  DB2TA($aProductRecord['specs']),
                                  $aProvisions,
                                  $oDBH->DB2Date($aProductRecord['date_created']),
                                  $oDBH->DB2Date($aProductRecord['date_modified']),
                                  $oImage);

      return $oObj;
    }


    //public
    function &ObtainProductsList(){
      $oColProducts = $this;
      $oColBrands = new ProdLer_Collection_Brands();
      $oColProducts->Relation('brand',$oColBrands,'cod','name');

      return $oColProducts->ObtainList('brand','model','cod');
    }

    //public
    function &ObtainObjectsList(){
      $aProducts = $this->ObtainProductsList();

      if (!$aProducts)
        return NULL;

      $aObjects = array();
      foreach($aProducts as $aProduct)
        $aObjects[] = $this->ObtainObject('cod',$aProduct['cod']);
      
      return $aObjects;
    }

    //public
    function UpdateObject($oProduct){
      $oColProducts = new ProdLer_Collection_Products();
      $oColProducts->Limit('model',$oProduct->sModel);
      $oColProducts->Limit('brand',$oProduct->oBrand->iCod);
      $oColProducts->Exception('cod',$oProduct->iCod);
      if ($oColProducts->Size() > 0)
        return FALSE;

      $iImageCod = 0;
      $sImageFilename = '';
      if ($oProduct->oImage){
        $oColImages = new ProdLer_Collection_Images();
        if (!$oColImages->IncludeObject($oProduct->oImage))
          return FALSE;
        $iImageCod = $oProduct->oImage->iCod;
        $sImageFilename = $oProduct->oImage->sFileName;
      }
      $this->DecrementReferencedImage($oProduct->iCod);

      $oDBH =& $this->GetDBHandler();
      $oDBH->Query("UPDATE $this->sTableName SET "
                  ."model='$oProduct->sModel',"
                  .'brand='.$oProduct->oBrand->iCod.','
                  .'category='.$oProduct->oCategory->iCod.','
                  ."description='$oProduct->sDescription',"
                  ."characts='".TA2DB($oProduct->sCharacts)."',"
                  ."specs='".TA2DB($oProduct->sSpecs)."',"
                  ."date_modified=".$oDBH->NowDateTime()
                  .",img_cod=$iImageCod,img_filename='$sImageFilename'"
                  ." WHERE cod=$oProduct->iCod");

      $oColProvisions = new ProdLer_Collection_Provisions();
      $oColProvisions->Limit('product',$oProduct->iCod);
      foreach($oProduct->aProvisions as $oProvision){
        $oColProvisions->IncludeObject($oProduct->iCod,$oProvision);
        $oColProvisions->Exception('dealer',$oProvision->oDealer->iCod);
      }
      $oColProvisions->DeleteObjects();

      return TRUE;
    }

  }

?>