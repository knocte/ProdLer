<?php

  class ProdLer_Collection_Categories extends ProdLer_Collection {
    var $sTableName='Categories';

    //private
    function GetCategories($iParent,$sPreText,$sOrderColumn){
      $oColCategories = $this;
      $oColCategories->Limit('parent',$iParent);
      $aBaseCategories = $oColCategories->ObtainList(name,cod);

      $aCategories = array();

      foreach($aBaseCategories as $iKey => $aCategory){
        $aFixedCategory = array();

        $aFixedCategory['cod'] = $aCategory['cod'];

        $aFixedCategory['pretext'] = $sPreText;
        if ($iKey != count($aBaseCategories)-1)
          //if element is not the last
          $aFixedCategory['pretext'] .= '&#9500;';
        else
          //if element is the last
          $aFixedCategory['pretext'] .= '&#9492;';

        $aFixedCategory['pretext'].= ' ';
        $aFixedCategory['name'] = $aCategory['name'];

        $aCategories[] = $aFixedCategory;

        if ($iKey != count($aBaseCategories)-1)
          //if element is not the last
          $aCategories = array_merge($aCategories,
                                     $this->GetCategories($aCategory['cod'],
                                                          $sPreText.'&#9474; ',
                                                          $sOrderColumn));
        else
          //if element is the last
          $aCategories = array_merge($aCategories,
                                     $this->GetCategories($aCategory['cod'],
                                                          $sPreText.'&nbsp; ',
                                                          $sOrderColumn));

      }

      return $aCategories;
    }


    //public
    function DeleteObject($sKey,$vValue){
      if (($sKey=='cod')&&(is_numeric($vValue))){
        $oCategory = $this->ObtainObject('cod',$vValue);
        $oColProducts =& $oCategory->GetProductsCollection(TRUE);
        if (($oColProducts->Size()>0)||($this->IsParent($vValue)))
          return FALSE;
        $this->DecrementReferencedImage($vValue);
      }

      $this->DeleteObjectAux($sKey,$vValue);

      return TRUE;
    }


    //public
    function IncludeObject(&$oCategory){
      $oDBH =& $this->GetDBHandler();

      $oColCategories = new ProdLer_Collection_Categories();
      $oColCategories->Limit('name',$oCategory->sName);
      if ($oColCategories->Size() > 0)
        return FALSE;

      $iImageCod = 0;
      $sImageFilename = '';
      if ($oCategory->oImage){
        $oColImages = new ProdLer_Collection_Images();
        if (!$oColImages->IncludeObject($oCategory->oImage))
          return FALSE;
        $iImageCod = $oCategory->oImage->iCod;
        $sImageFilename = $oCategory->oImage->sFileName;
      }

      $oCategory->SetCod($this->InsertionCode());
      $oDBH->Query("INSERT INTO $this->sTableName (cod,name,parent,"
                  ."date_created,img_cod,img_filename) VALUES ($oCategory->iCod,'$oCategory->sName',"
                  .$oCategory->iParent.','.$oDBH->NowDateTime().','.$iImageCod.",'".$sImageFilename."')");

      return TRUE;
    }


    //public
    function IsParent(/* 1 or 2 arguments */){
    // if 1 arg: check if category has any subcategories
    // else if 2 args: check if category2 is subcategory of category1

      if (func_num_args()==2){
        $iCodCategory1 = func_get_arg(0);
        $iCodCategory2 = func_get_arg(1);

        $oColCategories = new ProdLer_Collection_Categories();
        $oColCategories->Limit('parent',$iCodCategory1);
        if ($oColCategories->Size()==0)
          return FALSE;

        $aBaseCategories = $oColCategories->ObtainList(cod,parent);

        foreach($aBaseCategories as $aCategory){
          if (($aCategory['cod'] == $iCodCategory2)||
              ($this->IsParent($aCategory['cod'],$iCodCategory2)))
            return TRUE;
        }

        return FALSE;
      }
      else if (func_num_args()==1){
        $iCodCategory = func_get_arg(0);

        $oColCategories = new ProdLer_Collection_Categories();
        $oColCategories->Limit('parent',$iCodCategory);
        if ($oColCategories->Size()>0)
          return TRUE;
        else
          return FALSE;
      }
    }


    //public
    function &ObtainHierarchy(/* one argument or none */){
      $sOrderColumn = func_get_arg(0);

      if (IsNothing($sOrderColumn))
        $sOrderColumn = 'name';

      return $this->GetCategories(0,'&nbsp;',$sOrderColumn);
    }


    //public
    function &ObtainObject($sKey,$vID){
      $oObj = NULL;

      if ($vID==0)
        $oObj = new ProdLer_Category('['._('ROOT').']',0);
      else{
        $oDBH =& $this->ObtainObjectAux($sKey,$vID);

        if ($oDBH->iRows != 1)
          return $oObj;

        $oColImages = new ProdLer_Collection_Images();
        $oImage = $oColImages->ObtainObject('cod',$oDBH->aRecord[0]['img_cod']);

        $oObj = new ProdLer_Category($oDBH->aRecord[0]['cod'],
                                     $oDBH->aRecord[0]['name'],
                                     $oDBH->aRecord[0]['parent'],
                                     $oDBH->DB2Date($oDBH->aRecord[0]['date_created']),
                                     $oDBH->DB2Date($oDBH->aRecord[0]['date_modified']),
                                     $oImage);
      }

      return $oObj;
    }

    //public
    function &ObtainObjectsList(){
      $aCategories = $this->ObtainList('name','cod');

      if (!$aCategories)
        return NULL;

      $aObjects = array();
      foreach($aCategories as $aCategory)
        $aObjects[] = $this->ObtainObject('cod',$aCategory['cod']);

      return $aObjects;
    }


    //public
    function ObtainSubcategoriesList($iCod){
      if ($iCod == 0)
        return NULL;

      $aCategories = array($iCod);

      $oColCategories = $this; //make a copy of the collection, not referencing
      $oColCategories->Limit('parent',$iCod);
      $aSubcategories = $oColCategories->ObtainList('cod');

      foreach($aSubcategories as $aCategory){
        $aCategories = array_merge($aCategories,$this->ObtainSubcategoriesList($aCategory['cod']));
      }

      return $aCategories;
    }


    //public
    function UpdateObject($oCategory){
      $oColCategories = new ProdLer_Collection_Categories();

      $oColCategories->Limit('name',$oCategory->sName);
      $oColCategories->Exception('cod',$oCategory->iCod);
      if ($oColCategories->Size() > 0)
        return FALSE;

      $iImageCod = 0;
      $sImageFilename = '';
      if ($oCategory->oImage){
        $oColImages = new ProdLer_Collection_Images();
        if (!$oColImages->IncludeObject($oCategory->oImage))
          return FALSE;
        $iImageCod = $oCategory->oImage->iCod;
        $sImageFilename = $oCategory->oImage->sFileName;
      }
      $this->DecrementReferencedImage($oCategory->iCod);

      $oDBH =& $this->GetDBHandler();
      $oDBH->Query("UPDATE $this->sTableName SET name='$oCategory->sName',"
                  ."parent=$oCategory->iParent,date_modified="
                  .$oDBH->NowDateTime()
                  .",img_cod=$iImageCod,img_filename='$sImageFilename'"
                  ." WHERE cod=$oCategory->iCod");

      return TRUE;
    }


  }

?>