<?php

  class ProdLer_Category{
    var $iCod;
    var $sName;
    var $iParent;
    var $aDateCreated;
    var $aDateModified;

    var $oImage;

    function Prodler_Category(/* 2 or 6 args */){
      if (func_num_args()>2){
        $this->iCod = func_get_arg(0);
        $this->sName = func_get_arg(1);
        $this->iParent = func_get_arg(2);
        $this->aDateCreated = func_get_arg(3);
        $this->aDateModified = func_get_arg(4);
        $this->oImage = func_get_arg(5);
      }
      else{
        $this->iCod = 0;
        $this->sName = func_get_arg(0);
        $this->iParent = func_get_arg(1);
      }
    }

    function SetCod($iCod){
      $this->iCod = $iCod;
    }

    function SetParent($iParent){
      $this->iParent=$iParent;
    }

    function SetName($sName){
      $this->sName=$sName;
    }

    function SetImage($oImage){
      $this->oImage=$oImage;
    }

    function &GetProductsCollection($bRecursive){
      $oColProducts = new ProdLer_Collection_Products();

      if (($this->iCod!=0)&&($bRecursive)){
        $oColCategories = new ProdLer_Collection_Categories();
        $oColProducts->LimitMultiple('category',$oColCategories->ObtainSubcategoriesList($this->iCod));
      }
      else if (!$bRecursive)
        $oColProducts->Limit('category',$this->iCod);

      return $oColProducts;
    }

    function &GetSubcategoriesCollection($bRecursive){
      $oColCategories = new Prodler_Collection_Categories();

      if (!$bRecursive)
        $oColCategories->Limit('parent',$this->iCod);

      else
        $oColCategories->LimitMultiple('cod',$oColCategories->ObtainSubcategoriesList($this->iCod));

      return $oColCategories;
    }
  }

?>