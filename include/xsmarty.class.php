<?php

  class Xsmarty extends Smarty {

    var $default_modifiers = array('CustomEscape');
    var $template_dir = '../templates/';
    var $plugins_dir = array('plugins','../include/','../../include/');

    function Xsmarty(){
      $this->load_filter('output','trimwhitespace');

      $this->assign('sCompanyName',ProdLer_Variable::Get('Company_Name'));
      $this->assign('sCompanyURL',ProdLer_Variable::Get('Company_URL'));
      $this->assign('sThemeConfig',ProdLer_Variable::Get('Theme_Config'));
      $this->assign('sThemeVisitors',ProdLer_Variable::Get('Theme_Visitors'));

      $oColImages = NULL;
      $iLogoImageCod = ProdLer_Variable::Get('Logo_Image');
      $iLogoIconCod = ProdLer_Variable::Get('Logo_Icon');

      if (!IsNothing($iLogoImageCod)){
        $oColImages = new ProdLer_Collection_Images();
        $this->assign('oLogoImage',$oColImages->ObtainObject('cod',$iLogoImageCod));
      }
      if (!IsNothing($iLogoIconCod)){
        if (!$oColImages)
          $oColImages = new ProdLer_Collection_Images();
        $this->assign('oLogoIcon',$oColImages->ObtainObject('cod',$iLogoIconCod));
      }
    }
  }

?>