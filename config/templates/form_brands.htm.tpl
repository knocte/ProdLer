<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
  <head>
    <title>{$sCompanyName} - {'Brands Management'|__}</title>

    <!-- HEAD {include file='head.tpl'}-->
    <!-- /HEAD -->

<!-- LITERAL {literal}-->
<script language="JavaScript" type="text/javascript">
<!--
function UpdateFormStatus(){
  Select0Button(window.document.frmBrand.selBrand,window.document.frmBrand.btnMod);
  Select0Button(window.document.frmBrand.selBrand,window.document.frmBrand.btnDel);
  SelectButton(window.document.frmBrand.selBrand,window.document.frmBrand.btnProd);
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
      <h4>{'Brands Management'|__}.</h4>

      <div class="box">
      <form name="frmBrand" method="post" action="form_brands_post.php">
        <table cellspacing="0" border="0" width="100%">
          <tr>
            <td colspan="2">
              {'Brands'|__}:
            </td>
          </tr>
          <tr>
            <td width="40%">
              <select name="selBrand" size="10" style="width: 90%;"
               {if !$aBrands}disabled="disabled"{/if} onchange="UpdateFormStatus();" >
                <option value="0" class="meta">{if $aBrands}[{'ALL BRANDS'|__}]
                                  {else}[{'No brands set'|__}]{/if}</option>
              {foreach from=$aBrands item=aBrand}
                <option value="{$aBrand.cod}">{$aBrand.name}</option>
              {/foreach}
              </select>
            </td>
            <td> 
              <input type="submit" name="btnAdd" value="{'Add new brand'|__}" style="width: 50%;" />
              <br/><br/>
              <input type="submit" name="btnMod" value="{'Modify selected brand'|__}"
               {if !$aBrands}disabled="disabled"{/if} style="width: 50%;" />
              <br/><br/>
              <input type="submit" name="btnDel" value="{'Delete selected brand'|__}"
               {if !$aBrands}disabled="disabled"{/if} style="width: 50%;" />
              <br/><br/>
              <input type="submit" name="btnProd" value="{'Products of selected brand'|__}"
               {if !$aBrands}disabled="disabled"{/if} style="width: 50%;" />
            </td>
          </tr>
        </table>
      </form>
      <p class="info">{'Total number of brands'|__}: {$iNumBrands}</p>
      </div>

    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </body>
</html>
