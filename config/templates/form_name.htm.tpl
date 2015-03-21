<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
  <head>
    <title>{$sCompanyName} - {'Database Initialization'|__}</title>

    <!-- HEAD {include file='head.tpl'}-->
    <!-- /HEAD -->

<!-- LITERAL {literal}-->
<script language="JavaScript" type="text/javascript">
<!--
function SubmitCheck(frm){
  if (!OneWord(frm.txtCompanyURL.value)){
    window.alert("{/literal}{'URL cannot have spaces'|__|js}. [CM]{literal}");
    frm.txtCompanyName.value = Trim(frm.txtCompanyName.value);
    frm.txtCompanyURL.value = Trim(frm.txtCompanyURL.value);
    frm.txtCompanyURL.focus();
    frm.txtCompanyURL.select();
    return false;
  }

  return true;
}

function UpdateFormStatus(){
  var frm = window.document.frmName;
  var texts = new Array(frm.txtCompanyName,frm.txtCompanyURL);

  TextsRbutton(texts,frm.btnReset);
  TextSbutton(frm.txtCompanyName,frm.btnSubmit);
}

//-->
</script>
<!-- /LITERAL {/literal}-->

  </head>
  <body onload="UpdateFormStatus()">

    <!-- HEADER {include file='header.tpl'}-->
    <!-- /HEADER -->

    <!-- MENU {include file='menu.tpl'}-->
    <!-- /MENU -->

    <div id="content">
      <h4>{'ProdLer database is not initialized'|__}.<br/>
          {'Please fill the following form'|__}.</h4>

      <div class="box">
      <form name="frmName" method="post" action="form_name_post.php"
            onsubmit="return SubmitCheck(this);"
            onreset="FormResetSubmitText(this,this.btnReset,this.btnSubmit,this.txtCompanyName);">
        <table cellspacing="0" width="70%" border="0">
          <tr>
            <td width="50%">
              <label for="txtCompanyName">{'Your company name'|__}:</label>
            </td>
            <td width="50%">
              <input type="text" name="txtCompanyName" size="35" value=""
                     maxlength="48" id="txtCompanyName"
                     onkeyup="UpdateFormStatus();"
                     onkeypress="UpdateFormStatus();"
                     onchange="UpdateFormStatus();" />
            </td>
          </tr>
          <tr>
            <td width="50%">
              <label for="txtCompanyURL">{'Your company URL'|__}:</label>
            </td>
            <td width="50%">
              <input type="text" name="txtCompanyURL" size="35" value=""
                     maxlength="48" id="txtCompanyURL"
                     onkeyup="UpdateFormStatus();"
                     onkeypress="UpdateFormStatus();"
                     onchange="UpdateFormStatus();" />
            </td>
          </tr>
          <tr>
            <td width="50%" colspan="2" rowspan="1" align="center"><br/>
              <input type="reset" name="btnReset" value="{'Restore'|__}" />
              <input type="submit" name="btnSubmit" value="{'Send'|__}" />
            </td>
          </tr>
        </table>
      </form>
      </div>

    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </body>
</html>
