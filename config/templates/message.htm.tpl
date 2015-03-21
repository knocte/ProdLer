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

window.alert("{/literal}{$sMessage|js}{literal} [SM]");
window.document.location = '{/literal}{$sReturn}{literal}';

//-->
</script>
<!-- /LITERAL {/literal}-->

  </head>
  <body>
    <!-- HEADER {include file='header.tpl'}-->
    <!-- /HEADER -->

    <!-- MENU {include file='menu.tpl'}-->
    <!-- /MENU -->

    <div id="content">
      <h4>{$sMessage}</h4>

      <form name="frmMessage" method="post" action="{$sReturn}">
        <input type="submit" name="btnSubmit" value="{'Accept'|__}" />
      </form>

    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </body>
</html>
