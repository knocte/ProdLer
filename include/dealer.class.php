<?php

  class ProdLer_Dealer{
    var $iCod;
    var $sName;
    var $sAlias;
    var $sURL = '';
    var $sID = '';
    var $aDateCreated;
    var $aDateModified;

    var $sAddress = '';
    var $sPhone1  = '';
    var $sPhone2  = '';
    var $sContact = '';
    var $iPayment = 0 ;
    var $sNotes   = '';

    function Prodler_Dealer(/* one arg or many */){
      if (func_num_args()>2){
        $this->iCod     =  func_get_arg( 0);
        $this->sName    =  func_get_arg( 1);
        $this->sAlias   =  func_get_arg( 2);
        $this->sURL     =  func_get_arg( 3);
        $this->sID      =  func_get_arg( 4);
        $this->sAddress =  func_get_arg( 5);
        $this->sPhone1  =  func_get_arg( 6);
        $this->sPhone2  =  func_get_arg( 7);
        $this->sContact =  func_get_arg( 8);
        $this->iPayment =  func_get_arg( 9);
        $this->sNotes   =  func_get_arg(10);

        $this->aDateCreated  = func_get_arg(11);
        $this->aDateModified = func_get_arg(12);
      }

      else{
        $this->iCod = 0;

        $this->sName = func_get_arg(0);
        $this->sAlias = func_get_arg(1);
      }
    }

    function SetCod($iCod){
      $this->iCod = $iCod;
    }

    function SetName($sName){
      $this->sName=$sName;
    }

    function SetAlias($sAlias){
      $this->sAlias=$sAlias;
    }

    function SetURL($sURL){
      $this->sURL=$sURL;
    }
    function SetID($sID){
      $this->sID=$sID;
    }
    function SetAddress($sAddress){
      $this->sAddress=$sAddress;
    }
    function SetPhone1($sPhone1){
      $this->sPhone1=$sPhone1;
    }
    function SetPhone2($sPhone2){
      $this->sPhone2=$sPhone2;
    }
    function SetContact($sContact){
      $this->sContact=$sContact;
    }
    function SetPayment($iPayment){
      $this->iPayment=$iPayment;
    }
    function SetNotes($sNotes){
      $this->sNotes=$sNotes;
    }

    function &GetProductsCollection(){
      $oColProducts = new ProdLer_Collection_Products();

      if ($this->iCod!=0){
        $oColProvisions = new ProdLer_Collection_Provisions();
        $oColProvisions->Limit('dealer',$this->iCod);
        $oColProducts->Relation('cod',$oColProvisions,'product');
      }

      return $oColProducts;
    }

  }

?>