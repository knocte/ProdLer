<?php

  class ProdLer_Image{
    var $iCod;
    var $sFileName;
    var $sType;
    var $iSize;
    var $sDescription;

    var $xData = NULL;

    //We don't need these variables yet:
    //var $aDateCreated;
    //var $aDateModified;

    //private
    function &GetData(){
      if (!$this->xData){
        $oDBH =& DB_ProdLer_Images::StaticHandler(TRUE);

        $oDBH->Query('SELECT filedata FROM Images_data WHERE cod='.$this->iCod);
        $this->xData = base64_decode($oDBH->aRecord[0]['filedata']);
      }

      return $this->xData;
    }

    //private
    function GetFullURL(){
      $sReplace = '/php/../';

      if (ConfigZone())
        $sReplace .= '../';

      return str_replace('/php/',$sReplace.'include/',
                         LocalURL('image.php').'?cod='.$this->iCod);

    }

    //private
    function GetImageSize(){
      return getimagesize($this->GetFullURL());
    }

    //private
    function Show_Aux(){
      header ('Content-type: '.$this->sType);
      header ('Content-length: '.$this->iSize);
      header ('Content-Disposition: filename="'.$this->sFileName.'"');
      header ('Content-Description: PHP Generated Data');

      echo $this->GetData();
    }

    //public
    function Prodler_Image(/* 1 or 5 args */){
      if (func_num_args()>1){
        $this->iCod = func_get_arg(0);
        $this->sFileName = func_get_arg(1);
        $this->sType = FixImageType(func_get_arg(2));
        $this->iSize = func_get_arg(3);
        $this->sDescription = func_get_arg(4);
      }
      else{
        $this->iCod = 0;

        $oFile =& func_get_arg(0);

        $this->sFileName = $oFile->getProp('name');
        $this->sType = FixImageType($oFile->getProp('type'));
        $this->iSize = $oFile->getProp('size');

        $oFileHandle = fopen($oFile->getProp('tmp_name'), 'rb');
        $this->xData = base64_encode(fread($oFileHandle,$this->iSize));

        fclose ($oFileHandle);
      }
    }


    //public
    function GetDimensions($iDim){
      $aImageSize = $this->GetImageSize();
      $iX = $aImageSize[0];
      $iY = $aImageSize[1];
      if((!IsNothing($iDim))&&
        (($iX>$iDim)||($iY>$iDim))){

        if ($iX>$iY)
          $iRatio = ( $iDim / $iX );
        else
          $iRatio = ( $iDim / $iY );

        $iX = ceil($iRatio * $iX);
        $iY = ceil($iRatio * $iY);
      }

      $aDimensions['x']= $iX;
      $aDimensions['y']= $iY;

      return $aDimensions;
    }

    //public
    function GetDimensionX($iDim){
      $aDimensions = $this->GetDimensions($iDim);

      return $aDimensions['x'];
    }

    //public
    function GetDimensionY($iDim){
      $aDimensions = $this->GetDimensions($iDim);

      return $aDimensions['y'];
    }

    //public
    function Show($iDim){
      if (IsNothing($iDim))
        return $this->Show_Aux();

      $aImageSize = $this->GetImageSize();
      $iX = $aImageSize[0];
      $iY = $aImageSize[1];
      if (($iX<$iDim)&&($iY<$iDim))
        return $this->Show_Aux();

      if ($iX>$iY)
        $iRatio = ( $iDim / $iX );
      else
        $iRatio = ( $iDim / $iY );

      $iNewX = ceil($iRatio * $iX);
      $iNewY = ceil($iRatio * $iY);

      $oNewImg = imagecreate($iNewX, $iNewY);

      switch($this->sType){
        case 'image/gif':
          //GIF's are converted to PNG's when resizing, because imagegif() seems
          //not to be working correctly
          //header ('Content-type: '.$this->sType);
          header ('Content-type: '.str_replace('gif','png',$this->sType));
          header ('Content-Disposition: filename="thumb_'
          .substr($this->sFileName,0,strrpos($this->sFileName, 'gif')).'png'.'"');
          header ('Content-Description: PHP Generated Data');

          $oImg = imagecreatefromgif($this->GetFullURL());
          imagecopyresized($oNewImg, $oImg, 0, 0, 0, 0, $iNewX, $iNewY, $aImageSize[0], $aImageSize[1]);

          //imagegif($oNewImg);
          imagepng($oNewImg);
        break;
        case 'image/jpg':
          header ('Content-type: '.$this->sType);
          header ('Content-Disposition: filename="thumb_'.$this->sFileName.'"');
          header ('Content-Description: PHP Generated Data');

          $oImg = imagecreatefromjpeg($this->GetFullURL());
          imagecopyresized($oNewImg, $oImg, 0, 0, 0, 0, $iNewX, $iNewY, $aImageSize[0], $aImageSize[1]);
          imagejpeg($oNewImg);
        break;
        case 'image/png':
          header ('Content-type: '.$this->sType);
          header ('Content-Disposition: filename="thumb_'.$this->sFileName.'"');
          header ('Content-Description: PHP Generated Data');

          $oImg = imagecreatefrompng($this->GetFullURL());
          imagecopyresized($oNewImg, $oImg, 0, 0, 0, 0, $iNewX, $iNewY, $aImageSize[0], $aImageSize[1]);                                             
          imagepng($oNewImg);
        break;
      }
    }

    //public
    function SetCod($iCod){
      $this->iCod = $iCod;
    }

    function CorrectSize($iMax){
      return ($iMax >= $this->iSize);
    }

  }

?>