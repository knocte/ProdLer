<?php

  class ProdLer_Collection_Dealers extends ProdLer_Collection {
    var $sTableName='Dealers';

    //public
    function DeleteObject($sKey,$vValue){
      if (($sKey=='cod')&&(is_numeric($vValue))){
        $oDealer = $this->ObtainObject('cod',$vValue);
        $oColProducts =& $oDealer->GetProductsCollection();
        if ($oColProducts->Size()>0)
          return FALSE;
      }

      $this->DeleteObjectAux($sKey,$vValue);

      return TRUE;
    }


    //public
    function IncludeObject(&$oDealer){
      $oDBH =& $this->GetDBHandler();

      $oColDealers = new ProdLer_Collection_Dealers();
      $oColDealers->Limit('name',$oDealer->sName);
      if ($oColDealers->Size() > 0)
        return FALSE;

      $oColDealers = new ProdLer_Collection_Dealers();
      $oColDealers->Limit('alias',$oDealer->sAlias);
      if ($oColDealers->Size() > 0)
        return FALSE;

      if (!IsNothing($oDealer->sID)){
        $oColDealers = new ProdLer_Collection_Dealers();
        $oColDealers->Limit('id',$oDealer->sID);
        if ($oColDealers->Size() > 0)
          return FALSE;
      }

      $oDealer->SetCod($this->InsertionCode());
      $oDBH->Query("INSERT INTO $this->sTableName "
                  ."(cod,name,alias,id,url,address,phone_1,phone_2,contact,payment,notes"
                  .",date_created) VALUES ($oDealer->iCod,"
                  ."'$oDealer->sName',"
                  ."'$oDealer->sAlias',"
                  ."'$oDealer->sID',"
                  ."'$oDealer->sURL','"
                  .TA2DB($oDealer->sAddress)."',"
                  ."'$oDealer->sPhone1',"
                  ."'$oDealer->sPhone2',"
                  ."'$oDealer->sContact',"
                  ."$oDealer->iPayment,'"
                  .TA2DB($oDealer->sNotes)."',"
                  .$oDBH->NowDateTime().')');

      return TRUE;
    }


    //public
    function &ObtainObject($sKey,$vID){
      $oObj = NULL;

      $oDBH =& $this->ObtainObjectAux($sKey,$vID);

      if ($oDBH->iRows != 1)
        return $oObj;

      $oObj = new ProdLer_Dealer($oDBH->aRecord[0]['cod'],
                                 $oDBH->aRecord[0]['name'],
                                 $oDBH->aRecord[0]['alias'],
                                 $oDBH->aRecord[0]['url'],
                                 $oDBH->aRecord[0]['id'],
                                 DB2TA($oDBH->aRecord[0]['address']),
                                 $oDBH->aRecord[0]['phone_1'],
                                 $oDBH->aRecord[0]['phone_2'],
                                 $oDBH->aRecord[0]['contact'],
                                 $oDBH->aRecord[0]['payment'],
                                 DB2TA($oDBH->aRecord[0]['notes']),
                                 $oDBH->DB2Date($oDBH->aRecord[0]['date_created']),
                                 $oDBH->DB2Date($oDBH->aRecord[0]['date_modified']));

      return $oObj;
    }


    //public
    function UpdateObject($oDealer){
      $oColDealers = new ProdLer_Collection_Dealers();
      $oColDealers->Limit('name',$oDealer->sName);
      $oColDealers->Exception('cod',$oDealer->iCod);
      if ($oColDealers->Size() > 0)
        return FALSE;

      $oColDealers = new ProdLer_Collection_Dealers();
      $oColDealers->Limit('alias',$oDealer->sAlias);
      $oColDealers->Exception('cod',$oDealer->iCod);
      if ($oColDealers->Size() > 0)
        return FALSE;

      if (!IsNothing($oDealer->sID)){
        $oColDealers = new ProdLer_Collection_Dealers();
        $oColDealers->Limit('id',$oDealer->sID);
        $oColDealers->Exception('cod',$oDealer->iCod);
        if ($oColDealers->Size() > 0)
          return FALSE;
      }

      $oDBH =& $this->GetDBHandler();
      $oDBH->Query("UPDATE $this->sTableName SET "
                  ."name='$oDealer->sName',"
                  ."alias='$oDealer->sAlias',"
                  ."id='$oDealer->sID',"
                  ."url='$oDealer->sURL',"
                  ."address='$oDealer->sAddress',"
                  ."phone_1='$oDealer->sPhone1',"
                  ."phone_2='$oDealer->sPhone2',"
                  ."contact='$oDealer->sContact',"
                  ."payment=$oDealer->iPayment,"
                  ."notes='$oDealer->sNotes',"
                  ."date_modified=".$oDBH->NowDateTime()
                  ." WHERE cod=$oDealer->iCod");

      return TRUE;
    }

  }

?>