<?php

  //path of the file that the browser called
  $sCurrentPath = getcwd();
  
  //example: /var/www/html/prodler/include
  $sCurrentScriptPath = dirname(__FILE__);

  chdir($sCurrentScriptPath.'/../');

  //example: /var/www/html/prodler/
  $sPath = getcwd().'/';

  chdir($sCurrentScriptPath.'/../../');

  //example: /var/www/html/
  $sWebPath = getcwd().'/';

  //restore working folder
  chdir($sCurrentPath);

?>