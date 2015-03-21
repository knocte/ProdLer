<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
  <head>
    <title>{$sCompanyName} - {'Message to the user'|__}</title>

    <!-- HEAD {include file='head.tpl'}-->
    <!-- /HEAD -->

<!-- LITERAL {literal}-->
<script language="JavaScript" type="text/javascript">
<!--
function SendForm(){
  window.document.getElementById('body').className='invisible';
  window.document.frmConfirm.hidConfirmation.value="1";
  window.document.frmConfirm.submit();
}

if (!window.confirm("{/literal}{$sMessage|js}{literal} [SM]"))
  window.history.back();
//-->
</script>
<!-- /LITERAL {/literal}-->

  </head>
  <body onload="SendForm();"><div id="body">

    <!-- HEADER {include file='header.tpl'}-->
    <!-- /HEADER -->

    <!-- MENU {include file='menu.tpl'}-->
    <!-- /MENU -->

    <div id="content">
      <h4>{$sMessage}</h4>

       <form name="frmConfirm" method="post" action="{$sForm}">
        <input type="hidden" name="hidConfirmation" value="0" />
        {foreach from=$aFormControls item=sFormControlValue key=sFormControlKey}
          <input type="hidden" name="{$sFormControlKey}" value="{$sFormControlValue}" />
        {/foreach}

        <input type="submit" name="btnAccept" value="{'Accept'|__}" />
        <input type="submit" name="btnCancel" value="{'Cancel'|__}" 
               onclick="return GoBack();" />
      </form>

    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </div></body>
</html>
