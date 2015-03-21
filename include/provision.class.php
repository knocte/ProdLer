<?php

  class ProdLer_Provision{

    var $oDealer;
    var $iPrice;

    var $aDateCreated;
    var $aDateModified;

    function Prodler_Provision($oDealer,$iPrice,$aDateCreated,$aDateModified){
      $this->oDealer = $oDealer;
      $this->iPrice = $iPrice;

      $this->aDateCreated = $aDateCreated;
      $this->aDateModified = $aDateModified;
    }
  }

?>