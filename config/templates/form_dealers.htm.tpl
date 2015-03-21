<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
  <head>
    <title>{$sCompanyName} - {'Dealers Management'|__}</title>

    <!-- HEAD {include file='head.tpl'}-->
    <!-- /HEAD -->

<!-- LITERAL {literal}-->
<script language="JavaScript" type="text/javascript">
<!--
function UpdateFormStatus(){
  Select0Button(window.document.frmDealer.selDealer,window.document.frmDealer.btnMod);
  Select0Button(window.document.frmDealer.selDealer,window.document.frmDealer.btnDel);
  SelectButton(window.document.frmDealer.selDealer,window.document.frmDealer.btnProd);
}

//-->
</script>
<!-- /LITERAL {/literal}-->

  </head>
  <body onload="UpdateFormStatus();">

    <!-- HEADER {include file='header.tpl'}-->
    <!-- /HEADER -->

    <!-- MENU {include file='menu.tpl'}-->
    <!-- /MENU -->

    <div id="content">
      <h4>{'Dealers Management'|__}.</h4>

      <div class="box">
      <form name="frmDealer" method="post" action="form_dealers_post.php">

        <table cellspacing="0" border="0" width="100%">
          <tr>
            <td colspan="2">
              {'Dealers'|__}:
            </td>
          </tr>
          <tr>
            <td width="40%">
              <select name="selDealer" size="10" style="width: 90%;"
               {if !$aDealers}disabled="disabled"{/if} onchange="UpdateFormStatus();" >
                <option value="0" class="meta">{if $aDealers}[{'ALL DEALERS'|__}]
                                  {else}[{'No dealers set'|__}]{/if}</option>
                {foreach from=$aDealers item=aDealer}
                <option value="{$aDealer.cod}">{$aDealer.alias}</option>
                {/foreach}
              </select>
            </td>
            <td> 
              <input type="submit" name="btnAdd" value="{'Add new dealer'|__}" style="width: 50%;" />
              <br/><br/>
              <input type="submit" name="btnMod" value="{'Modify selected dealer'|__}"
               {if !$aDealers}disabled="disabled"{/if} style="width: 50%;" />
              <br/><br/>
              <input type="submit" name="btnDel" value="{'Delete selected dealer'|__}"
               {if !$aDealers}disabled="disabled"{/if} style="width: 50%;" />
              <br/><br/>
              <input type="submit" name="btnProd" value="{'Products of selected dealer'|__}"
               {if !$aDealers}disabled="disabled"{/if} style="width: 50%;" />
            </td>
          </tr>
        </table>

      </form>
      <p class="info">{'Total number of dealers'|__}: {$iNumDealers}</p>
      </div>

    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </body>
</html>
