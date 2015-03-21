<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
  <head>
    <title>{$sCompanyName} - {'Products Search'|__}</title>

    <!-- HEAD {include file='head.tpl'}-->
    <!-- /HEAD -->

<!-- LITERAL {literal}-->
<script language="JavaScript" type="text/javascript">
<!--
function UpdateFormStatus2(load,reset){
  var frm = window.document.frmProductsSearch;

  TextSbutton(frm.txtCodeSearch,frm.btnCodeSearch);
  frm.btnTextSearch.disabled = (IsNothing(frm.txtTextSearch.value));
  frm.btnBoth.disabled = (IsNothing(frm.txtTextSearch.value));
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
      <h4>{'Products Search'|__}.</h4>

      <div class="box">
      <form name="frmProductsSearch" method="get" action="products.php"
            onreset="UpdateFormStatus2(false,true);" >

        <!-- Workaround method to disable submission when INTRO/ENTER key is pressed -->
        <input type="submit" name="noSubmit" class="invisible" disabled="disabled" />

        <table cellpadding="0" cellspacing="0" border="0" width="100%">
          <tr>
            <td width="50%" rowspan="3">

        <fieldset>
          <legend>{'By association'|__}</legend>

                {'Category'|__}:<br/>
                <select name="selCategory" size="6" style="width: 90%;">
                <option value="0" class="meta" selected="selected">[{'ROOT'|__}]</option>
                {foreach from=$aCategories item=aCategory}
                <option value="{$aCategory.cod}">{$aCategory.pretext|smarty:nodefaults}{$aCategory.name}</option>
                {/foreach}
                </select>

                <br /><br />

                {'Brand'|__}:
                <select name="selBrand" style="width: 80%;"
                 {if !$aBrands}disabled="disabled"{/if}>
                  <option value="0" class="meta" {if $aBrands}selected="selected">[{'ALL BRANDS'|__}]
                                    {else}>[{'No brands set'|__}]{/if}</option>
                {foreach from=$aBrands item=aBrand}
                  <option value="{$aBrand.cod}">{$aBrand.name}</option>
                {/foreach}
                </select><br /><br />

                <input type="submit" name="btnAssociationSearch" value="{'Search'|__}" />

        </fieldset>

            </td>
            <td width="50%" style="vertical-align: top;">
              <fieldset>
                <legend>{'By reference code'|__}</legend>

                <input type="text" name="txtCodeSearch" value=""
                       onkeyup="UpdateFormStatus2(false,false);"
                       onkeypress="UpdateFormStatus2(false,false);"
                       onchange="UpdateFormStatus2(false,false);" />
                <input type="submit" name="btnCodeSearch" value="{'Search'|__}" /><br/>

              </fieldset>

            </td>
          </tr>
          <tr>
            <td style="vertical-align: middle;">

              <fieldset>
                <legend>{'By text'|__}</legend>

                <input type="text" name="txtTextSearch"
                       value="" maxlength="48"
                       onkeyup="UpdateFormStatus2(false,false);"
                       onkeypress="UpdateFormStatus2(false,false);"
                       onchange="UpdateFormStatus2(false,false);" />
                <input type="submit" name="btnTextSearch" value="{'Search'|__}" /><br/>

              </fieldset>


            </td>
          </tr>
          <tr>
            <td style="vertical-align: top;">

              <input type="submit" name="btnBoth" value="{'Search by text & association'|__}"
                     style="width: 70%;" />


            </td>
          </tr>
        </table>

      </form>
      <p class="info">{'Total number of products'|__}: {$iNumProducts}</p>
      </div>


    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </body>
</html>
