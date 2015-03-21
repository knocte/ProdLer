<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
  <head>
    <title>{$sCompanyName} - {'Error'|__}</title>

    <!-- HEAD {include file='head.tpl'}-->
    <!-- /HEAD -->

<!-- LITERAL {literal}-->
<script language="JavaScript" type="text/javascript">
<!--

window.alert("{/literal}{'Error'|__|js}: {$sMessage|js}{literal}  [SM]");
window.history.back();

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
      <h4>{'Error'|__}: {$sMessage} [SM]</h4>

      <form name="frmError" method="post" action="{$sReturn}">
        <input type="submit" name="btnSubmit" value="{'Accept'|__}"
               onclick="return GoBack();" />
      </form>
    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </body>
</html>
