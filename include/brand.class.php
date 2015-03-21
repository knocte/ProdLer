<?php

  class ProdLer_Brand{
    var $iCod;
    var $sName;
    var $sURL = '';
    var $aDateCreated;
    var $aDateModified;

    var $oImage;

    function ProdLer_Brand(/* 1 or 6 args */){
      if (func_num_args()>1){
        $this->iCod = func_get_arg(0);
        $this->sName = func_get_arg(1);
        $this->sURL = func_get_arg(2);
        $this->aDateCreated = func_get_arg(3);
        $this->aDateModified = func_get_arg(4);
        $this->oImage = func_get_arg(5);
      }

      else{
        $this->iCod = 0;
        $this->sName = func_get_arg(0);
        $this->sURL = '';
      }
    }

    function SetCod($iCod){
      $this->iCod = $iCod;
    }

    function SetURL($sURL){
      $this->sURL=$sURL;
    }

    function SetName($sName){
      $this->sName=$sName;
    }

    function SetImage($oImage){
      $this->oImage=$oImage;
    }

    function &GetProductsCollection(){
      $oColProducts = new ProdLer_Collection_Products();

      if ($this->iCod!=0)
        $oColProducts->Limit('brand',$this->iCod);

      return $oColProducts;
    }

  }

?>