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

function UpdateFormStatus2(load,reset){
  var frm = window.document.frmDealer;

  var texts = new Array(frm.txtDealerName,
                        frm.txtDealerAlias,
                        frm.txtDealerURL,
                        frm.txtDealerID,
                        frm.txaDealerAddress,
                        frm.txtDealerPhone1,
                        frm.txtDealerPhone2,
                        frm.txtDealerContact,
                        frm.txaDealerNotes);

  var cod = {/literal}{$iDealerCod}{literal};

  if (cod==0){
    if (frm.selDealerPayment.selectedIndex != 0)
      frm.btnReset.disabled = false;
    else{
      TextsRbutton(texts,frm.btnReset);
    }

    TextSbutton(frm.txtDealerName,frm.btnSubmit);

    if (load)
      frm.txtDealerName.focus();
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
    FormResetSubmitText(frm,frm.btnReset,frm.btnSubmit,frm.txtDealerName);

}

function SubmitCheck(frm){
  if (!OneWord(frm.txtDealerURL.value)){
    window.alert("{/literal}{'URL cannot have spaces'|__|js}.  [CM]{literal}");
    frm.txtDealerName.value = Trim(frm.txtDealerName.value);
    frm.txtDealerURL.value = Trim(frm.txtDealerURL.value);
    frm.txtDealerURL.focus();
    frm.txtDealerURL.select();
    return false;
  }

  return true;
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
      <form name="frmDealer" method="post" action="form_dealer_post.php"
            onsubmit="return SubmitCheck(this);"
            onreset="UpdateFormStatus2(false,true);" >
        <input type="hidden" name="hidDealerCod" value="{$iDealerCod}" />
        <table cellspacing="0" border="0" width="95%">
          <tr>
            <td width="15%">
              <label for="txtDealerName">{'Name'|__}:</label>
            </td>
            <td width="40%">
              <input type="text" name="txtDealerName" value="{$sDealerName}"
                     maxlength="48" id="txtDealerName" style="width: 95%;"
                     onkeyup="UpdateFormStatus2(false,false);"
                     onkeypress="UpdateFormStatus2(false,false);"
                     onchange="UpdateFormStatus2(false,false);" />
            </td>

            <td width="15%">
              <label for="txtDealerAlias">{'Alias'|__}:</label>
            </td>
            <td>
              <input type="text" name="txtDealerAlias" value="{$sDealerAlias}"
                     maxlength="13" id="txtDealerAlias" style="width: 95%;"
                     onkeyup="UpdateFormStatus2(false,false)"
                     onkeypress="UpdateFormStatus2(false,false)"
                     onchange="UpdateFormStatus2(false,false);" />
            </td>
          </tr>
          <tr>
            <td>
              <label for="txtDealerURL">URL:</label>
            </td>
            <td>
              <input type="text" name="txtDealerURL" value="{$sDealerURL}"
                     maxlength="48" id="txtDealerURL" style="width: 95%;"
                     onkeyup="UpdateFormStatus2(false,false);"
                     onkeypress="UpdateFormStatus2(false,false);"
                     onchange="UpdateFormStatus2(false,false);" />
            </td>
            <td>
              <label for="txtDealerID">{$sDealerIDName}:</label>
            </td>
            <td>
              <input type="text" name="txtDealerID" value="{$sDealerID}"
                     maxlength="13" id="txtDealerID" style="width: 95%;"
                     onkeyup="UpdateFormStatus2(false,false);"
                     onkeypress="UpdateFormStatus2(false,false);"
                     onchange="UpdateFormStatus2(false,false);" />
            </td>
          </tr>
          <tr>
            <td rowspan="2">
              <label for="txaDealerAddress">{'Address'|__}:</label><br /><br />
            </td>
            <td rowspan="2">
              <textarea name="txaDealerAddress" rows="1" id="txaDealerAddress" style="width: 95%;"
                        onkeyup="UpdateFormStatus2(false,false);" cols="31"
                        onkeypress="UpdateFormStatus2(false,false);"
                        onchange="UpdateFormStatus2(false,false);">{$sDealerAddress}</textarea>
            </td>
            <td>
              <label for="txtDealerPhone1">{'Phone'|__} 1:</label>
            </td>
            <td>
              <input type="text" name="txtDealerPhone1" value="{$sDealerPhone1}"
                     maxlength="13" id="txtDealerPhone1" style="width: 95%;"
                     onkeyup="UpdateFormStatus2(false,false);"
                     onkeypress="UpdateFormStatus2(false,false);"
                     onchange="UpdateFormStatus2(false,false);" />
            </td>
          </tr>
          <tr>
            <td>
              <label for="txtDealerPhone2">{'Phone'|__} 2:</label>
            </td>
            <td>
              <input type="text" name="txtDealerPhone2" value="{$sDealerPhone2}"
                     maxlength="13" id="txtDealerPhone2" style="width: 95%;"
                     onkeyup="UpdateFormStatus2(false,false);"
                     onkeypress="UpdateFormStatus2(false,false);"
                     onchange="UpdateFormStatus2(false,false);" />
            </td>
          </tr>
          <tr>
            <td>
              <label for="txtDealerContact">{'Contact'|__}:</label>
            </td>
            <td>
              <input type="text" name="txtDealerContact" value="{$sDealerContact}" 
                     maxlength="28" id="txtDealerContact" style="width: 95%;"
                     onkeyup="UpdateFormStatus2(false,false);"
                     onkeypress="UpdateFormStatus2(false,false);"
                     onchange="UpdateFormStatus2(false,false);" />
            </td>
            <td>
              {'Payment'|__}:
            </td>
            <td>
              <select name="selDealerPayment" style="width: 100%;"
                      onchange="UpdateFormStatus2(false,false);">
                <option value="0" {if $iDealerPayment == 0}selected="selected"{/if}>[{'Undefined'|__}]</option>
                <option value="1" {if $iDealerPayment == 1}selected="selected"{/if}>{'Account charge'|__}</option>
                <option value="2" {if $iDealerPayment == 2}selected="selected"{/if}>{'Bank transfer'|__}</option>
                <option value="3" {if $iDealerPayment == 3}selected="selected"{/if}>{'Check'|__}</option>
                <option value="4" {if $iDealerPayment == 4}selected="selected"{/if}>{'Cash'|__}</option>
                <option value="5" {if $iDealerPayment == 5}selected="selected"{/if}>[{'Other'|__}]</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>
              <label for="txaDealerNotes">{'Notes'|__}:</label><br/><br/><br/>
            </td>
            <td colspan="3">
              <textarea name="txaDealerNotes" id="txaDealerNotes"
                        rows="2" style="width: 95%;" cols="31"
                        onkeyup="UpdateFormStatus2(false,false);"
                        onkeypress="UpdateFormStatus2(false,false);"
                        onchange="UpdateFormStatus2(false,false);"
              >{$sDealerNotes}</textarea>
            </td>
          </tr>
          <tr>
            <td colspan="3" align="center"><br/>
              <input type="reset" name="btnReset" value="{'Restore'|__}" />
              <input type="submit" name="btnSubmit" value="{'Send'|__}" />
            </td>
          </tr>
        </table>
      </form>
      <p class="info">
      {if $sDealerName}
      [{'Creation'|__}: {$sDateCreated} | {'Modification'|__}: {$sDateModified}]
      {/if}
      </p>
      </div>

    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </body>
</html>
