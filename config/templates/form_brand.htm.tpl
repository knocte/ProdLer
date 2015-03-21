<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
  <head>
    <title>{$sCompanyName} - {$sAccessType}</title>

    <!-- HEAD {include file='head.tpl'}-->
    <!-- /HEAD -->

<!-- LITERAL {literal}-->
<script language="JavaScript" type="text/javascript">
<!--
function SubmitCheck(frm){
  if (!OneWord(frm.txtBrandURL.value)){
    window.alert("{/literal}{'URL cannot have spaces'|__|js}.  [CM]{literal}");
    frm.txtBrandName.value = Trim(frm.txtBrandName.value);
    frm.txtBrandURL.value = Trim(frm.txtBrandURL.value);
    frm.txtBrandURL.focus();
    frm.txtBrandURL.select();
    return false;
  }

  return true;
}

function UpdateFormStatus2(load,reset){
  var frm = window.document.frmBrand;

  var texts = new Array(frm.txtBrandName,frm.txtBrandURL);
  var cod = {/literal}{$iBrandCod}{literal};

  if (cod==0){
    TextsRbutton(texts,frm.btnReset);
    TextSbutton(frm.txtBrandName,frm.btnSubmit);

    if (load)
      frm.txtBrandName.focus();
  }
  else{
    if (load){
      frm.btnSubmit.disabled = true;
      frm.btnReset.disabled = true;
    }
    else if (!reset){
      frm.btnSubmit.disabled = false;
      frm.btnReset.disabled = false;
    }
  }

  if (reset)
    FormResetSubmitText(frm,frm.btnReset,frm.btnSubmit,frm.txtBrandName);

}

//-->
</script>
<!-- /LITERAL {/literal}-->

  </head>
  <body onload="UpdateFormStatus2(true,false);">

    <!-- HEADER {include file='header.tpl'}-->
    <!-- /HEADER -->

    <!-- MENU {include file='menu.tpl'}-->
    <!-- /MENU -->

    <div id="content">
      <h4>{$sAccessType}.</h4>

      <div class="box">
      <form name="frmBrand" method="post" action="form_brand_post.php"
            enctype="multipart/form-data"
            onsubmit="return SubmitCheck(this);"
            onreset="UpdateFormStatus2(false,true); ">
        <input type="hidden" name="hidBrandCod" value="{$iBrandCod}" />
        <table cellspacing="0" width="70%" border="0">
          <tr>
            <td width="50%">
              <label for="txtBrandName">{'Brand name'|__}:</label>
            </td>
            <td width="50%">
              <input type="text" name="txtBrandName" size="35" value="{$sBrandName}"
                     maxlength="48" id="txtBrandName"
                     onkeyup="UpdateFormStatus2(false,false);"
                     onkeypress="UpdateFormStatus2(false,false);"
                     onchange="UpdateFormStatus2(false,false);" />
            </td>
          </tr>
          <tr>
            <td>
              <label for="txtBrandURL">{'Brand URL'|__}:</label>
            </td>
            <td>
              <input type="text" name="txtBrandURL" size="35" value="{$sBrandURL}" 
                     maxlength="48" id="txtBrandURL"
                     onkeyup="UpdateFormStatus2(false,false);"
                     onkeypress="UpdateFormStatus2(false,false);"
                     onchange="UpdateFormStatus2(false,false);"/>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <br/>
              <input type="reset" name="btnReset" value="{'Restore'|__}" />
              <input type="submit" name="btnSubmit" value="{'Send'|__}" />
            </td>
          </tr>
        </table>

        <br/>
        <!-- IMG {include file='img.tpl'}-->
        <!-- /IMG -->

      </form>
      {if $sBrandName}
      <p class="info">
      [{'Creation'|__}: {$sDateCreated} | {'Modification'|__}: {$sDateModified}]
      </p>
      {/if}
      
      </div>

    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </body>
</html>
