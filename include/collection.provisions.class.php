<?php

  class ProdLer_Collection_Provisions extends ProdLer_Collection {
    var $sTableName='Provisions';

    //public
    function GetObjects(){
      $aProvisions = array();

      if ($this->Size()>0){
        $aProvisionsList = $this->ObtainList('dealer',
                                             'price',
                                             'date_created',
                                             'date_modified');

        $oColDealers = new ProdLer_Collection_Dealers();

        $oDBH =& $this->GetDBHandler();

        foreach($aProvisionsList as $aProvision){
          $oDealer = $oColDealers->ObtainObject('cod',$aProvision['dealer']);
          $oProvision = new ProdLer_Provision($oDealer,
                                              $aProvision['price'],
                                              $oDBH->DB2Date($aProvision['date_created']),
                                              $oDBH->DB2Date($aProvision['date_modified']));
          $aProvisions[] = $oProvision;
        }
      }

      return $aProvisions;

    }

    //public
    function IncludeObject($iProductCod,$oProvision){
      $oColProvisions = new ProdLer_Collection_Provisions();
      $oColProvisions->Limit('dealer',$oProvision->oDealer->iCod);
      $oColProvisions->Limit('product',$iProductCod);

      $oDBH =& $this->GetDBHandler();

      $iSize = $oColProvisions->Size();
      if ($iSize==0){
        $oDBH->Query("INSERT INTO $this->sTableName (dealer,product,price,date_created) "
                     ."VALUES (".$oProvision->oDealer->iCod.",$iProductCod,"
                     .Price2DB($oProvision->iPrice).','.$oDBH->NowDateTime().')');
      }
      else{ // if ($iSize==1)
        
        $aProvisions =& $oColProvisions->ObtainList('price');

        if ($aProvisions[0]['price'] != Price2DB($oProvision->iPrice)){
          $oDBH->Query("UPDATE $this->sTableName SET "
                       .'price='.Price2DB($oProvision->iPrice)
                       .',date_modified='.$oDBH->NowDateTime()
                       .' WHERE (dealer = '.$oProvision->oDealer->iCod.') AND '
                       ."(product=$iProductCod)");
        }
      }
    }
  }

?>