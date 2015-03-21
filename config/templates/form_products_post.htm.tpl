<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
  <head>
    <title>{$sCompanyName} - {'Products Management'|__}</title>

    <!-- HEAD {include file='head.tpl'}-->
    <!-- /HEAD -->

<!-- LITERAL {literal}-->
<script language="JavaScript" type="text/javascript">
<!--
function UpdateFormStatus(){
  SelectButton(window.document.frmProduct.selProduct,window.document.frmProduct.btnMod);
  SelectButton(window.document.frmProduct.selProduct,window.document.frmProduct.btnDel);
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
      <h4>{'Products Management'|__}.</h4>

      <div class="box">
      <form name="frmProduct" method="post" action="form_products_post.php">
      {if $iBrandCod}
        <input type="hidden" name="hidBrandCod" value="{$iBrandCod}" />
      {/if}
      {if $iCategoryCod}
        <input type="hidden" name="hidCategoryCod" value="{$iCategoryCod}" />
      {/if}
      {if $iDealerCod}
        <input type="hidden" name="hidDealerCod" value="{$iDealerCod}" />
      {/if}

      <table cellspacing="0" border="0" width="100%">
        <tr>
          <td colspan="2">
            {'Products'|__} {$sSource}:
          </td>
        </tr>
        <tr>
          <td width="50%">
            <select name="selProduct" size="10" style="width: 90%;"
              {if !$aProducts}disabled="disabled"{/if} onchange="UpdateFormStatus();" >
              {if !$aProducts}<option value="0">[{'No products'|__}]</option>{/if}
              {foreach from=$aProducts item=aProduct}
              <option value="{$aProduct.cod}">{$aProduct.brand} {$aProduct.model}</option>
              {/foreach}
            </select>
          </td>
          <td><br/>
            <input type="submit" name="btnAdd" style="width: 70%;"
                   value="{'Add new product'|__}" />
            <br/><br/>
            <input type="submit" name="btnMod" style="width: 70%;"
                   value="{'Modify selected product'|__}"
                   {if !$aProducts}disabled="disabled"{/if} />
            <br/><br/>
            <input type="submit" name="btnDel" style="width: 70%;"
                   value="{'Delete selected product'|__}"
                   {if !$aProducts}disabled="disabled"{/if} />
            <br/><br/>
            </td>
          </tr>
        </table>

      </form>
      <p class="info">{'Number of products'|__}: {$iNumProducts}</p>
      </div>

    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </body>
</html>
