<?php

  require_once 'path.inc.php';

  //When debugging, uncomment the following line:
  //error_reporting (E_ALL);

  //When not debugging, uncomment the following line:
  error_reporting (E_ERROR);

  require_once $sWebPath.'libs/Smarty.class.php';

  require_once $sPath.'include/funcs.inc.php';
  require_once $sPath.'include/db.class.php';
  require_once $sPath.'include/prodler.class.php';

  require_once $sPath.'include/xsmarty.class.php';

  require_once $sPath.'include/lang.inc.php';

  if (!$bNotCheckStatus)
    CheckProdlerStatus();

?>