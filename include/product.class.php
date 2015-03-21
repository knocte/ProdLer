<?php

  class ProdLer_Product{

    var $iCod;
    var $sModel;
    var $oBrand;
    var $oCategory;
    var $sDescription;
    var $sCharacts;
    var $sSpecs;

    var $aProvisions;
    var $oImage;

    var $aDateCreated;
    var $aDateModified;

    function Prodler_Product(/* 11 or 3 args */){
      if (func_num_args()>3){
        $this->iCod = func_get_arg(0);
        $this->sModel = func_get_arg(1);
        $this->oBrand = func_get_arg(2);
        $this->oCategory = func_get_arg(3);
        $this->sDescription = func_get_arg(4);
        $this->sCharacts = func_get_arg(5);
        $this->sSpecs = func_get_arg(6);
        $this->aProvisions = func_get_arg(7);
        $this->aDateCreated = func_get_arg(8);
        $this->aDateModified = func_get_arg(9);
        $this->oImage = func_get_arg(10);
      }
      else{
        $this->iCod = 0;
        $this->sModel = func_get_arg(0);
        $this->oBrand = func_get_arg(1);
        $this->oCategory = func_get_arg(2);
      }
    }

    function GetFinalPrice(){
      $iPrice = 0;

      if (!$this->aProvisions)
        return $iPrice;

      foreach($this->aProvisions as $oProvision){
        if ($iPrice==0)
          $iPrice = $oProvision->iPrice;
        else if ($oProvision->iPrice < $iPrice)
          $iPrice = $oProvision->iPrice;
      }

      if (ProdLer_Variable::Get('Benefit_Type')==1)
        $iPrice /= ((100 - ProdLer_Variable::Get('Default_Benefit'))/100);
      else
        $iPrice *= (1 + (ProdLer_Variable::Get('Default_Benefit')/100));

      if (ProdLer_Variable::Get('Tax')==1)
        $iPrice *= (1 + (ProdLer_Variable::Get('Tax_Quantity')/100));

      return FinalPrice($iPrice);
    }
 

    function GetProvisionsList(){
      $aProvisions = array();

      $oColDealers = new ProdLer_Collection_Dealers();

      if ($this->aProvisions)
        foreach($this->aProvisions as $oProvision){
          $aProvision = array();

          $aProvision['iDealerCod'] = $oProvision->oDealer->iCod;
          $aProvision['sDealerName'] = $oProvision->oDealer->sName;
          $aProvision['sDealerID'] = $oProvision->oDealer->sID;
          $aProvision['iPrice'] = DB2Price($oProvision->iPrice);
          $aProvision['sDateCreated'] = CustomDate($oProvision->aDateCreated);
          $aProvision['sDateModified'] = CustomDate($oProvision->aDateModified);

          $aProvisions[] = $aProvision;
        }

      return $aProvisions;
    }

    //public
    function GetSpecsList(){
    //print_r(explode("\r\n",$this->sSpecs));
      return explode("\r\n",$this->sSpecs);
    }


    function SetCod($iCod){
      $this->iCod = $iCod;
    }

    function SetModel($sModel){
      $this->sModel = $sModel;
    }

    function SetBrand($oBrand){
      $this->oBrand = $oBrand;
    }

    function SetCategory($oCategory){
      $this->oCategory = $oCategory;
    }

    function SetDescription($sDescription){
      $this->sDescription = $sDescription;
    }

    function SetCharacts($sCharacts){
      $this->sCharacts = $sCharacts;
    }

    function SetSpecs($sSpecs){
      $this->sSpecs = $sSpecs;
    }

    function SetProvisions($aProvisions){
      $this->aProvisions = array(); //Firstly delete all old provisions
      $oColDealers = new ProdLer_Collection_Dealers();

      if ($aProvisions)
        foreach($aProvisions as $aProvision){
          if ($aProvision['iDealerCod'] > 0){ // existing dealer

            $oDealer = $oColDealers->ObtainObject('cod',$aProvision['iDealerCod']);
            $oProvision = new ProdLer_Provision($oDealer,
                                                Price2DB($aProvision['iPrice']),
                                                NULL,NULL);

            $this->aProvisions[] = $oProvision;
          }
        }
    }

    function SetImage($oImage){
      $this->oImage=$oImage;
    }

  }

?>