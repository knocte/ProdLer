<?php

  //abstract
  class DB {
    var $sHost     = ''; // Hostname of our server.
    var $iDbxType  = ''; // Type of database (http://www.php.net/manual/en/ref.dbx.php)
    var $sDatabase = ''; // Logical database name on the server.
    var $sUser     = ''; // User und Password for login.
    var $sPassword = '';

    var $oLink        = NULL; // Result of dbx_connect().
    var $oQueryResult = NULL; // Result of most recent dbx_query().
    var $aRecord      = NULL; // Current array containing data from QueryResult.
    var $iRows        = 0;    // Number of rows returned.

    var $sError = '';  // Error state of query...

    var $sDateFormat;  //argument for date() function


    //private
    function Connect(){
      if (!$this->oLink){
        $this->oLink = dbx_connect($this->iDbxType,$this->sHost,
                                   $this->sDatabase,$this->sUser,
                                   $this->sPassword);

        $this->sError = dbx_error($this->oLink);
        if (!$this->oLink)
          $this->Halt('Link-ID == false, connect failed');
      }
    }

    //private
    function Finish(){
      if ($this->oLink){
        dbx_close($this->oLink);
        $this->oLink = NULL;
      }
    }


    //private
    function Halt($sMessage){
      printf("<b>Database error:</b> $sMessage<br/>\n");
      printf("<b>DBX Error</b>: %s<br>\n",$this->sError);

      die("\nSession halted.");
    }


    //public
    function NowDateTime(){
      return "'".date($this->sDateFormat)."'";
    }


    //public
    function Query($sSQL){
      //uncomment this line for debugging
      //echo "<br/>\n".$sSQL;

      $this->Connect();

      $this->oQueryResult = dbx_query($this->oLink,$sSQL);
      $this->iRows = $this->oQueryResult->rows;

      $this->sError = dbx_error($this->oLink);
      if (!$this->oQueryResult){
        $this->aRecord = NULL;
        $this->Halt("Invalid SQL: $sSQL");
      }
      else
        $this->aRecord = $this->oQueryResult->data;

      return $this->oQueryResult;
    }
  }

  class DB_ProdLer extends DB {
    var $sHost       = 'localhost'  ;
    var $iDbxType    = DBX_MYSQL    ;
    var $sDatabase   = 'prodler'    ;
    var $sUser       = 'root'       ;
    var $sPassword   = ''   ;

    var $sDateFormat = 'Y-m-d H:i:s';  //example: '2003-12-14 13:03:02'

    //public
    function DB2Date($sDBDate){
      if (IsNothing($sDBDate))
        return NULL;

      $aDate = array();

      $aDate['d'] = substr($sDBDate,8,2);
      $aDate['m'] = substr($sDBDate,5,2);
      $aDate['y'] = substr($sDBDate,2,2);

      return $aDate;
    }

    //static
    function &StaticHandler($bReturnObject){
      static $oHandler = NULL;

      if ($bReturnObject){
        if (!$oHandler)
          $oHandler = new DB_ProdLer();
        return $oHandler;
      }

      if ($oHandler)
        $oHandler->Finish();
    }
  }


  class DB_ProdLer_Images extends DB {
    var $sHost       = 'localhost'      ;
    var $iDbxType    =  DBX_MYSQL       ;
    var $sDatabase   = 'prodler_images' ;
    var $sUser       = 'root'           ;
    var $sPassword   = ''               ;

    var $sDateFormat = 'Y-m-d H:i:s';  //example: '2003-12-14 13:03:02'

    //public
    function DB2Date($sDBDate){
      if (IsNothing($sDBDate))
        return NULL;

      $aDate = array();

      $aDate['d'] = substr($sDBDate,8,2);
      $aDate['m'] = substr($sDBDate,5,2);
      $aDate['y'] = substr($sDBDate,2,2);

      return $aDate;
    }

    //static
    function &StaticHandler($bReturnObject){
      static $oHandler = NULL;

      if ($bReturnObject){
        if (!$oHandler)
          $oHandler = new DB_ProdLer_Images();
        return $oHandler;
      }

      if ($oHandler)
        $oHandler->Finish();
    }
  }


?>
