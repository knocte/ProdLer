

//Attention!: first form is selected, so
// be careful when adding more forms to the templates
var frm = window.document.forms[0];

function Preview<?php echo $_REQUEST['i']; ?>(){

  var imgsrc = "";
  var imgphp = "../../include/image.php?cod=";

  if (frm.radDBcod<?php echo $_REQUEST['i']; ?>.checked)
    imgsrc = imgphp + frm.txtImageCod<?php echo $_REQUEST['i']; ?>.value;
  else if (frm.radFilename<?php echo $_REQUEST['i']; ?>.checked)
    imgsrc = imgphp + frm.selImageFilename<?php echo $_REQUEST['i']; ?>.value;
  else if (frm.radUpload<?php echo $_REQUEST['i']; ?>.checked)
    imgsrc = "file:///" + frm.filImage<?php echo $_REQUEST['i']; ?>.value;

  frm.imgPreview<?php echo $_REQUEST['i']; ?>.src = imgsrc;

  return false;
}


function UpdateImgStatus<?php echo $_REQUEST['i']; ?>(load){
  CheckedDisabled(frm.radDBcod<?php echo $_REQUEST['i']; ?>,
                  frm.txtImageCod<?php echo $_REQUEST['i']; ?>);
  CheckedDisabled(frm.radFilename<?php echo $_REQUEST['i']; ?>,
                  frm.selImageFilename<?php echo $_REQUEST['i']; ?>);
  CheckedDisabled(frm.radUpload<?php echo $_REQUEST['i']; ?>,
                  frm.filImage<?php echo $_REQUEST['i']; ?>);

  //this function must be defined in the template (TPL) file
  if (!load)
    UpdateFormStatus2(false,false);
}

frm.btnPreview<?php echo $_REQUEST['i']; ?>.disabled = false;

UpdateImgStatus<?php echo $_REQUEST['i']; ?>(true);