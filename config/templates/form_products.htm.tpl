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
  frm.btnTextSearch.disabled = (IsNothing(frm.txtTextSearch.value) ||
                               (!frm.chkTextSearchModel.checked &&
                                !frm.chkTextSearchDescription.checked &&
                                !frm.chkTextSearchCharacts.checked &&
                                !frm.chkTextSearchSpecs.checked));
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
      <form name="frmProductsSearch" method="post" action="form_products_post.php"
            onreset="UpdateFormStatus2(false,true);" >

        <table cellpadding="0" cellspacing="0" border="0" width="100%">
          <tr>
            <td width="50%" rowspan="2">

              <fieldset>
                <legend>{'By text'|__}</legend>

                <input type="text" name="txtTextSearch"
                       value="" maxlength="48"
                       onkeyup="UpdateFormStatus2(false,false);"
                       onkeypress="UpdateFormStatus2(false,false);"
                       onchange="UpdateFormStatus2(false,false);" />
                <input type="submit" name="btnTextSearch" value="{'Search'|__}" /><br/>
                {'Search within'|__}:<br/>
                <label for="chkTextSearchModel">
                <input type="checkbox" name="chkTextSearchModel"
                       id="chkTextSearchModel" value="1" checked="checked"
                       onclick="UpdateFormStatus2(false,false);"
                       onchange="UpdateFormStatus2(false,false);" />
                {'Model'|__}</label><br/>
                <label for="chkTextSearchDescription">
                <input type="checkbox" name="chkTextSearchDescription"
                       id="chkTextSearchDescription" value="1" checked="checked"
                       onclick="UpdateFormStatus2(false,false);"
                       onchange="UpdateFormStatus2(false,false);" />
                {'Description'|__}</label><br/>
                <label for="chkTextSearchCharacts">
                <input type="checkbox" name="chkTextSearchCharacts"
                       id="chkTextSearchCharacts" value="1" checked="checked"
                       onclick="UpdateFormStatus2(false,false);"
                       onchange="UpdateFormStatus2(false,false);" />
                {'Characteristics'|__}</label><br/>
                <label for="chkTextSearchSpecs">
                <input type="checkbox" name="chkTextSearchSpecs"
                       id="chkTextSearchSpecs" value="1" checked="checked"
                       onclick="UpdateFormStatus2(false,false);"
                       onchange="UpdateFormStatus2(false,false);" />
                {'Specifications'|__}</label><br/>

              </fieldset>

            </td>
            <td width="50%" style="vertical-align: middle;">

              <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="submit" name="btnAdd" value="{'Add new product'|__}" style="width: 70%;" />
              <br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="submit" name="btnShow" value="{'Show all products'|__}" style="width: 70%;" />
              <br/>

            </td>
          </tr>
          <tr>
            <td style="vertical-align: bottom;">

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
        </table>


        <br/>


        <fieldset>
          <legend>{'By association'|__}</legend>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td width="50%">

                {'Category'|__}:<br/>
                <select name="selCategory" size="6" style="width: 90%;">
                <option value="0" class="meta" selected="selected">[{'ROOT'|__}]</option>
                {foreach from=$aCategories item=aCategory}
                <option value="{$aCategory.cod}">{$aCategory.pretext|smarty:nodefaults}{$aCategory.name}</option>
                {/foreach}
                </select>

              </td>
              <td width="50%">

                {'Brand'|__}:
                <select name="selBrand" style="width: 50%;"
                 {if !$aBrands}disabled="disabled"{/if}>
                  <option value="0" class="meta" {if $aBrands}selected="selected" >[{'ALL BRANDS'|__}]
                                    {else}>[{'No brands set'|__}]{/if}</option>
                {foreach from=$aBrands item=aBrand}
                  <option value="{$aBrand.cod}">{$aBrand.name}</option>
                {/foreach}
                </select><br /><br />

                {'Dealer'|__}:
                <select name="selDealer" style="width: 50%;"
                 {if !$aDealers}disabled="disabled"{/if}>
                  <option value="0" class="meta" {if $aDealers}selected="selected" >[{'ALL DEALERS'|__}]
                                    {else}>[{'No dealers set'|__}]{/if}</option>
                  {foreach from=$aDealers item=aDealer}
                  <option value="{$aDealer.cod}">{$aDealer.alias}</option>
                  {/foreach}
                </select><br/><br/>

                <input type="submit" name="btnAssociationSearch" value="{'Search'|__}" />

              </td>
            </tr>

          </table>

        </fieldset>

      </form>
      <p class="info">{'Total number of products'|__}: {$iNumProducts}</p>
      </div>


    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </body>
</html>
