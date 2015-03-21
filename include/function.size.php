<?php

  function smarty_function_size($params,&$smarty){
    return ' width="'.$params['dim']['x'].'" height="'.$params['dim']['y'].'" ';
  }
  
?>