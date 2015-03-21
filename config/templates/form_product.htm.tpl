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
  var frm = window.document.frmProduct;

  var texts = new Array(frm.txtNewBrand,
                        frm.txtModel,
                        frm.txtDescription,
                        frm.txtNewCategory,
                        frm.txaCharacts,
                        frm.txaSpecs,
                        frm.txtPrice,
                        frm.txtNewDealerID,
                        frm.txtNewDealerName,
                        frm.txtNewDealerPrice);

  var cod = {/literal}{$iProductCod}{literal};

  Select0Button(frm.selDealer,frm.btnAddPrice);
  TextSbutton(frm.txtNewDealerName,frm.btnAddDealer);
  CheckedDisabled(frm.chkSubcategory,frm.txtNewCategory);
  CheckedDisabled(frm.radBrandA,frm.selBrand);
  CheckedDisabled(frm.radBrandB,frm.txtNewBrand);

  if (cod==0){
    if ((frm.selBrand.selectedIndex>0)||
        (frm.selCategory.selectedIndex>-1)||
        (frm.selDealer.selectedIndex>0)||
        (frm.radBrandA.checked)||
        (frm.radBrandB.checked)||
        (frm.chkSubcategory.checked))
      frm.btnReset.disabled = false;
    else{
      TextsRbutton(texts,frm.btnReset);
    }

    frm.btnSubmit.disabled = !((!IsNothing(frm.txtModel.value))&&
                               (frm.selCategory.selectedIndex>-1)&&
                               (((frm.radBrandA.checked)&&
                                 (frm.selBrand.selectedIndex>0))||
                                ((frm.radBrandB.checked)&&
                                 (!IsNothing(frm.txtNewBrand.value)))));
  }
  else{
    if (load){
      frm.btnReset.disabled = true;
    }
    else if (!reset){
      frm.btnSubmit.disabled = false;
      frm.btnReset.disabled = false;
    }
  }


  if (load)
    ScrollSelect(frm.selCategory);

  if (reset){
    frm.reset();
    frm.btnReset.disabled = true;
    frm.btnSubmit.disabled = true;
    frm.btnAddPrice.disabled = true;
    frm.btnAddDealer.disabled = true;
  }

}

function CheckInsertions(){
  var frm = window.document.frmProduct;

  if (!IsNothing(frm.txtPrice.value)||
     !IsNothing(frm.txtNewDealerID.value)||
     !IsNothing(frm.txtNewDealerName.value)||
     !IsNothing(frm.txtNewDealerPrice.value))
    return window.confirm('{/literal}{'You have inserted some dealer or price information which was not inserted as a provision.'|__}{literal}');
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
      <form name="frmProduct" method="post" action="form_product.php"
            onreset="UpdateFormStatus2(false,true);">
        <input type="hidden" name="hidProductCod" value="{$iProductCod}" />
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
          <tr>
            <td  width="50%">
              {'Brand'|__}:
            </td>
            <td  width="50%">
              {'Category'|__}:
            </td>
          </tr>
          <tr>
            <td>

              <table border="0" cellspacing="0" width="90%">
                <tr>
                  <td width="30%">

                    <input type="radio" name="radBrand" id="radBrandA" value="1"
                           onchange="UpdateFormStatus2(false,false);"
                           {if $iBrandType == '1'}checked="checked"
                           {else}{if !$aBrands}disabled="disabled"{/if}
                           {/if} />
                    <label for="radBrandA">{'Existing'|__}:</label>

                  </td>
                  <td width="70%">
                    <select name="selBrand" size="1" style="width: 95%;"
                            onchange="UpdateFormStatus2(false,false);"
                            {if !$aBrands}disabled="disabled"{/if}>
                      <option value="0" class="meta">
                      {if !$aBrands}[{'No brands set'|__}]
                      {else}[{'Select a brand'|__}]
                      {/if}</option>
                      {foreach from=$aBrands item=aBrand}
                      <option value="{$aBrand.cod}" {if $aBrand.cod == $iProductBrand}selected="selected"{/if}>
                      {$aBrand.name}</option>
                      {/foreach}
                    </select>
                  </td>

                </tr>
                <tr>
                  <td>
                    <input type="radio" name="radBrand" id="radBrandB" value="0"
                           {if ($iBrandType == '0')||(!$aBrands)}checked="checked"{/if}
                           onchange="UpdateFormStatus2(false,false);" />
                    <label for="radBrandB">{'New'|__}:</label>
                  </td>
                  <td>
                    <input type="text" name="txtNewBrand" value="{$sProductBrand}"
                           style="width: 95%;" maxlength="48" id="txtNewBrand"
                           onkeyup="UpdateFormStatus2(false,false);"
                           onkeypress="UpdateFormStatus2(false,false);"
                           onchange="UpdateFormStatus2(false,false);" />
                  </td>
                </tr>

                <tr>
                  <td>
                    <br/>
                  </td>
                </tr>

                <tr>
                  <td>
                    &nbsp;<label for="txtModel">{'Model'|__}:</label>

                  </td>
                  <td>
                    <input type="text" name="txtModel" value="{$sModel}"
                           style="width: 95%;" maxlength="28" id="txtModel"
                           onkeyup="UpdateFormStatus2(false,false);"
                           onkeypress="UpdateFormStatus2(false,false);"
                           onchange="UpdateFormStatus2(false,false);" />
                  </td>

                </tr>
                <tr>
                  <td>
                    &nbsp;<label for="txtDescription">{'Description'|__}:</label>
                  </td>
                  <td>
                    <input type="text" name="txtDescription" value="{$sDescription}"
                           style="width: 95%;" maxlength="48" id="txtDescription"
                           onkeyup="UpdateFormStatus2(false,false);"
                           onkeypress="UpdateFormStatus2(false,false);"
                           onchange="UpdateFormStatus2(false,false);" />
                  </td>
                </tr>

              </table>

              <br/><br/>
              {if $iProductCod>0}
              <input type="hidden" name="hidDateCreated" value="{$sDateCreated}"/>
              <input type="hidden" name="hidDateModified" value="{$sDateModified}"/>
              {/if}

            </td>
            <td>
              <select name="selCategory" size="7" style="width: 90%;"
                      onchange="UpdateFormStatus2(false,false);" >
                <option value="0" class="meta"
                {if $iProductCategory == '0'}selected="selected"{/if}>[{'ROOT'|__}]</option>
                {foreach from=$aCategories item=aCategory}
                <option value="{$aCategory.cod}"
                {if $aCategory.cod == $iProductCategory}selected="selected"{/if}>
                {$aCategory.pretext|smarty:nodefaults}{$aCategory.name}</option>
                {/foreach}
              </select><br/>
              <input type="checkbox" name="chkSubcategory" id="chkSubcategory"
                     {if $iSubCategory == '1'}checked="checked"{/if} value="1"
                     onchange="UpdateFormStatus2(false,false);" />
              <label for="chkSubcategory">{'Create subcategory'|__}:</label>
              <br/>
              <input type="text" name="txtNewCategory" value="{$sProductCategory}"
                     style="width: 90%;" maxlength="48" id="txtNewCategory"
                     onkeyup="UpdateFormStatus2(false,false);"
                     onkeypress="UpdateFormStatus2(false,false);"
                     onchange="UpdateFormStatus2(false,false);" />
              <br/><br/>
            </td>
          </tr>
          <tr>
            <td>
              &nbsp;<label for="txaCharacts">{'Characteristics'|__}:</label><br/>
              <textarea name="txaCharacts" id="txaCharacts"
                        rows="5" cols="33" style="width: 90%;"
                        onkeyup="UpdateFormStatus2(false,false);"
                        onkeypress="UpdateFormStatus2(false,false);"
                        onchange="UpdateFormStatus2(false,false);"
              >{$sCharacts}</textarea>
            </td>
            <td>
              &nbsp;<label for="txaSpecs">{'Specifications'|__}:</label>
              <br/>
              <textarea name="txaSpecs" id="txaSpecs" rows="5"
                        cols="33" style="width: 90%;"
                        onkeyup="UpdateFormStatus2(false,false);"
                        onkeypress="UpdateFormStatus2(false,false);"
                        onchange="UpdateFormStatus2(false,false);"
              >{$sSpecs}</textarea>
            </td>
          </tr>
        </table>

        <!-- Workaround method to disable submission when INTRO/ENTER key is pressed -->
        <input type="submit" name="noSubmit" class="invisible" disabled="disabled" />

        <br/>


        <table width="95%" border="1" cellspacing="0" >
          <tr>
            <th width="20%" align="center">
              {'Date'|__}
            </th>

            <th width="30%" align="center">
              {'Dealer'|__}
            </th>

            <th width="20%" align="center">
              {'Dealer price'|__}
            </th>

            <th width="30%" align="center">
              [{'Action'|__}]
            </th>
          </tr>

          {foreach name=aProvisions from=$aProvisions item=aProvision}
          <tr>
            <td align="center">

              <input type="hidden" value="{$aProvision.sDealerID}"
                     name="hidProvisions[][sDealerID]" />
              <input type="hidden" value="{$aProvision.iDealerCod}"
                     name="hidProvisions[{$smarty.foreach.aProvisions.iteration-1}][iDealerCod]" />
              <input type="hidden" value="{$aProvision.sDealerName}"
                     name="hidProvisions[{$smarty.foreach.aProvisions.iteration-1}][sDealerName]" />
              <input type="hidden" value="{$aProvision.sDateCreated}"
                     name="hidProvisions[{$smarty.foreach.aProvisions.iteration-1}][sDateCreated]" />
              <input type="hidden" value="{$aProvision.sDateModified}"
                     name="hidProvisions[{$smarty.foreach.aProvisions.iteration-1}][sDateModified]" />

              {if $aProvision.sDateCreated}
                {$aProvision.sDateCreated} | {$aProvision.sDateModified}
              {else}
                {'NEW'|__}
              {/if}
            </td>

            <td align="center">
              {$aProvision.sDealerName}
            </td>

            <td align="center">
              <input type="text" size="5" value="{$aProvision.iPrice}"
                     name="hidProvisions[{$smarty.foreach.aProvisions.iteration-1}][iPrice]"
                     style="text-align: right;"
                     onkeyup="UpdateFormStatus2(false,false);"
                     onkeypress="UpdateFormStatus2(false,false);"
                     onchange="UpdateFormStatus2(false,false);" />
              {$sCurrencySymbol}
            </td>

            <td align="center">
              <input type="submit" value="{'Delete provision'|__}" style="width: 75%;"
                     name="btnDelPrice{$smarty.foreach.aProvisions.iteration-1}" />
            </td>

          </tr>
          {/foreach}

          <tr>
            <td colspan="4">&nbsp;
              <input type="hidden" name="hidNumProvisions" value="{$iNumProvisions}" />
            </td>
          </tr>

          <tr>
            <th align="center">
              <label for="txtNewDealerID">{$sDealerIDName}</label>
            </th>

            <td align="center">
              <select name="selDealer" style="width: 85%;"
                      onchange="UpdateFormStatus2(false,false);"
                {if !$aDealers}disabled="disabled"{/if}>
                {if $aDealers}<option value="0" class="meta">[{'Select a dealer'|__}]</option>
                {else}{if $aProvisions}<option value="0">[{'No more dealers'|__}]</option>
                {else}<option value="0">[{'No dealers'|__}]</option>
                {/if}{/if}
                {foreach from=$aDealers item=aDealer}
                  <option value="{$aDealer.cod}">{$aDealer.alias}</option>
                {/foreach}
              </select>
            </td>

            <td align="center">
              <input type="text" name="txtPrice" {if !$aDealers}disabled="disabled"{/if}
                     style="text-align: right;" size="5" value=""
                     onkeyup="UpdateFormStatus2(false,false);"
                     onkeypress="UpdateFormStatus2(false,false);"
                     onchange="UpdateFormStatus2(false,false);" />
              {$sCurrencySymbol}
            </td>

            <td align="center">
              <input type="submit" name="btnAddPrice" {if !$aDealers}disabled="disabled"{/if}
                     value="{'Add price'|__}" style="width: 85%;" />
            </td>
          </tr>
          <tr>
            <td align="center">
              <input type="text" id="txtNewDealerID"
                     name="txtNewDealerID" size="10" value=""
                     onkeyup="UpdateFormStatus2(false,false);"
                     onkeypress="UpdateFormStatus2(false,false);"
                     onchange="UpdateFormStatus2(false,false);" />
            </td>
            <td align="center">
              <input type="text" name="txtNewDealerName" value=""
                     style="width: 85%;"
                     onkeyup="UpdateFormStatus2(false,false);"
                     onkeypress="UpdateFormStatus2(false,false);"
                     onchange="UpdateFormStatus2(false,false);" />
            </td>
            <td align="center">
              <input type="text" name="txtNewDealerPrice" value=""
                     style="text-align: right;" size="5"
                     onkeyup="UpdateFormStatus2(false,false);"
                     onkeypress="UpdateFormStatus2(false,false);"
                     onchange="UpdateFormStatus2(false,false);" />
              {$sCurrencySymbol}
            </td>
            <td align="center">
              <input type="submit" name="btnAddDealer"
                     value="{'Add price and dealer'|__}"
                     style="width: 85%;" />
            </td>
          </tr>
        </table>

        <br/>

        <table cellpadding="0" cellspacing="0" border="0" width="100%">
          <tr>
            <td align="center">
              <input type="reset" name="btnReset" value="{'Restore'|__}" />
              <input type="submit" name="btnSubmit" value="{'Next'|__} >>" 
                     onclick="return CheckInsertions();" />
            </td>
          </tr>
        </table>

      </form>
      {if $iProductCod>0}
      <p class="info">
      &nbsp;[ {'Creation'|__}: {$sDateCreated} | {'Modification'|__}:{$sDateModified} ]
      </p>
      {/if}
      </div>

    </div>

  <!-- FOOTER {include file='footer.tpl'}-->
  <!-- /FOOTER -->

  </body>
</html>
