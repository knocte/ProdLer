<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
  <head>
    <title>{$sCompanyName} - {'Preferences'|__}</title>

    <!-- HEAD {include file='head.tpl'}-->
    <!-- /HEAD -->

<!-- LITERAL {literal}-->
<script language="JavaScript" type="text/javascript">
<!--
function UpdateFormStatus2(load,reset){
  var frm = window.document.frmPreferences;

  frm.btnReset.disabled = (load||reset);
  frm.btnSubmit.disabled = (load||reset);

  if (reset)
    frm.reset();

  frm.txtTaxName.disabled = (frm.radTaxNot.checked);

  CheckedDisabled(frm.radTaxQuantity,frm.txtTaxQuantity);
  CheckedDisabled(frm.radTaxSentence,frm.txtTaxSentence);

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
      <h4>{'Preferences'|__}.</h4>

      <div class="box">
      <form name="frmPreferences" method="post" action="form_prefs_post.php"
            enctype="multipart/form-data"
            onreset="UpdateFormStatus2(false,true);" >

        <fieldset>
          <legend>{'Company'|__}</legend>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td width="50%">

          <label for="txtCompanyName">{'Name'|__}:
            &nbsp;<input type="text" name="txtCompanyName" id="txtCompanyName"
                         value="{$sCompanyName}" size="30" maxlength="48"
                         onkeyup="UpdateFormStatus2(false,false);"
                         onkeypress="UpdateFormStatus2(false,false);"
                         onchange="UpdateFormStatus2(false,false);" /></label><br/>

              </td>
              <td width="50%">

          <label for="txtCompanyURL">URL:
            &nbsp;<input type="text" name="txtCompanyURL" id="txtCompanyURL"
                         value="{$sCompanyURL}" size="30" maxlength="48"
                         onkeyup="UpdateFormStatus2(false,false);"
                         onkeypress="UpdateFormStatus2(false,false);"
                         onchange="UpdateFormStatus2(false,false);" /></label>

              </td>
            </tr>
          </table>
          <hr/>
          <label for="txtDefaultBenefit">{'Default benefit'|__}:
                  <input type="text" name="txtDefaultBenefit" id="txtDefaultBenefit"
                         value="{$iDefaultBenefit}" size="5" maxlength="48"
                         style="text-align: right;"
                         onkeyup="UpdateFormStatus2(false,false);"
                         onkeypress="UpdateFormStatus2(false,false);"
                         onchange="UpdateFormStatus2(false,false);" />%</label><br />
          <label for="radBenefitTypeFinal"><input type="radio" name="radBenefitType" 
                                                  id="radBenefitTypeFinal" value="1"
                                                  onclick="UpdateFormStatus2(false,false);"
                                                  onchange="UpdateFormStatus2(false,false);"
                                                  {if $iBenefitType==1}checked="checked"{/if} /> {'Over final price'|__}.</label><br />
          <label for="radBenefitTypeDealer"><input type="radio" name="radBenefitType" 
                                                   id="radBenefitTypeDealer" value="2"
                                                   onclick="UpdateFormStatus2(false,false);"
                                                   onchange="UpdateFormStatus2(false,false);"
                                                   {if $iBenefitType==2}checked="checked"{/if} /> {'Over dealer price'|__}.</label>
        </fieldset>

        <br/>

        <table cellpadding="0" cellspacing="0" border="0" width="100%">
          <tr>
            <td width="50%">

              <fieldset>
                <legend>{'Tax'|__}</legend>
                <label for="txtTaxName">{'Name'|__}: <input type="text" id="txtTaxName" name="txtTaxName"
                                                           value="{$sTaxName}"
                                                           onkeyup="UpdateFormStatus2(false,false);"
                                                           onkeypress="UpdateFormStatus2(false,false);"
                                                           onchange="UpdateFormStatus2(false,false);" /></label>
                <br />
                <label for="radTaxQuantity"><input type="radio" name="radTax" id="radTaxQuantity" value="1"
                                                   onclick="UpdateFormStatus2(false,false);"
                                                   onchange="UpdateFormStatus2(false,false);"
                                                   {if $iTax==1}checked="checked"{/if} />
                  {'Include tax on prices'|__}:</label>
                  &nbsp;<input type="text" name="txtTaxQuantity" value="{$iTaxQuantity}" size="3"
                               style="text-align: right;"
                               onkeyup="UpdateFormStatus2(false,false);"
                               onkeypress="UpdateFormStatus2(false,false);"
                               onchange="UpdateFormStatus2(false,false);" />%<br />
                <label for="radTaxSentence"><input type="radio" name="radTax" id="radTaxSentence" value="2"
                                                   onclick="UpdateFormStatus2(false,false);"
                                                   onchange="UpdateFormStatus2(false,false);"
                                                   {if $iTax==2}checked="checked"{/if} /> {'Include sentence'|__}:</label>
                  &nbsp;<input type="text" name="txtTaxSentence" value="{$sTaxSentence}"
                               onkeyup="UpdateFormStatus2(false,false);"
                               onkeypress="UpdateFormStatus2(false,false);"
                               onchange="UpdateFormStatus2(false,false);" /><br />
                <label for="radTaxNot"><input type="radio" name="radTax" id="radTaxNot" value="3"
                                              onclick="UpdateFormStatus2(false,false);"
                                              onchange="UpdateFormStatus2(false,false);"
                                              {if $iTax==3}checked="checked"{/if} /> {'Do not use tax'|__}.</label>
                <br/>
              </fieldset>

            </td>
            <td width="50%">

              <fieldset>
                <legend>{'Miscellaneous'|__}</legend>
                <label for="txtDealerIDName">{'Name for dealer identification'|__}:
                  &nbsp;<input type="text" name="txtDealerIDName" id="txtDealerIDName"
                               size="10" value="{$sDealerIDName}"
                               onkeyup="UpdateFormStatus2(false,false);"
                               onkeypress="UpdateFormStatus2(false,false);"
                               onchange="UpdateFormStatus2(false,false);" /></label><br/>
                <label for="txtDateSyntax">{'Date syntax'|__}
                  (<b>d</b>:{'day'|__},<b>m</b>:{'month'|__},<b>y</b>:{'year'|__}):
                  &nbsp;<input type="text" name="txtDateSyntax" id="txtDateSyntax"
                               value="{$sDateSyntax}" size="10"
                               onkeyup="UpdateFormStatus2(false,false);"
                               onkeypress="UpdateFormStatus2(false,false);"
                               onchange="UpdateFormStatus2(false,false);" /></label><br/>
                <label for="txtCurrencyName">{'Currency'|__}:
                  &nbsp;<input type="text" name="txtCurrencyName" id="txtCurrencyName"
                               value="{$sCurrencyName}" size="7"
                               onkeyup="UpdateFormStatus2(false,false);"
                               onkeypress="UpdateFormStatus2(false,false);"
                               onchange="UpdateFormStatus2(false,false);" /></label>
                <label for="txtCurrencySymbol">&nbsp;&nbsp;{'Symbol'|__}:
                  &nbsp;<input type="text" name="txtCurrencySymbol" id="txtCurrencySymbol"
                               value="{$sCurrencySymbol}" size="3"
                               onkeyup="UpdateFormStatus2(false,false);"
                               onkeypress="UpdateFormStatus2(false,false);"
                               onchange="UpdateFormStatus2(false,false);" /></label><br />
                <label for="txtDecimalDivisor">{'Decimal divisor character'|__}:
                  &nbsp;<input type="text" name="txtDecimalDivisor" id="txtDecimalDivisor"
                               value="{$sDecimalDivisor}" size="1" maxlength="1"
                               onkeyup="UpdateFormStatus2(false,false);"
                               onkeypress="UpdateFormStatus2(false,false);"
                               onchange="UpdateFormStatus2(false,false);" /></label>
              </fieldset>
            </td>
          </tr>
        </table>

        <br />

        <fieldset>
          <legend>{'Language'|__}</legend>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td width="50%">

                {'Default for visitors'|__}:
                <select name="selLangVisitors" onchange="UpdateFormStatus2(false,false);">
                {foreach from=$aLanguages item=aLang}
                  <option value="{$aLang}" {if $sLangVisitors==$aLang}selected="selected"{/if}>{$aLang}</option>
                {/foreach}
                </select><br/>
                <label for="radLangVisitorsAuto"><input type="radio" name="radLangVisitors"
                                                        id="radLangVisitorsAuto" value="1"
                                                        onclick="UpdateFormStatus2(false,false);"
                                                        onchange="UpdateFormStatus2(false,false);"
                                                        {if $iLangVisitors==1}checked="checked"{/if} />
                  {'Auto-detect'|__}.</label><br />
                <label for="radLangVisitorsForce"><input type="radio" name="radLangVisitors"
                                                        id="radLangVisitorsForce" value="2"
                                                        onclick="UpdateFormStatus2(false,false);"
                                                        onchange="UpdateFormStatus2(false,false);"
                                                        {if $iLangVisitors==2}checked="checked"{/if} />
                  {'Force to default'|__}.</label>

              </td>
              <td width="50%">

                {'Default for configuration zone'|__}:
                <select name="selLangConfig" onchange="UpdateFormStatus2(false,false);">
                {foreach from=$aLanguages item=aLang}
                  <option value="{$aLang}" {if $sLangConfig==$aLang}selected="selected"{/if}>{$aLang}</option>
                {/foreach}
                </select><br/>
                <label for="radLangConfigAuto"><input type="radio" name="radLangConfig"
                                                        id="radLangConfigAuto" value="1"
                                                        onclick="UpdateFormStatus2(false,false);"
                                                        onchange="UpdateFormStatus2(false,false);"
                                                        {if $iLangConfig==1}checked="checked"{/if} />
                  {'Auto-detect'|__}.</label><br />
                <label for="radLangConfigForce"><input type="radio" name="radLangConfig"
                                                        id="radLangConfigForce" value="2"
                                                        onclick="UpdateFormStatus2(false,false);"
                                                        onchange="UpdateFormStatus2(false,false);"
                                                        {if $iLangConfig==2}checked="checked"{/if} />
                  {'Force to default'|__}.</label>
              </td>
            </tr>
          </table>

        </fieldset>


        <br />

        <fieldset>
          <legend>{'Web style'|__}</legend>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td width="50%">

                {'Default for visitors'|__}:
                <select name="selThemeVisitors" onchange="UpdateFormStatus2(false,false);">
                {foreach from=$aThemes item=aTheme}
                  <option value="{$aTheme}" {if $sThemeVisitors==$aTheme}selected="selected"{/if}>{$aTheme}</option>
                {/foreach}
                </select>
              </td>
              <td width="50%">

                {'Default for configuration zone'|__}:
                <select name="selThemeConfig" onchange="UpdateFormStatus2(false,false);">
                {foreach from=$aThemes item=aTheme}
                  <option value="{$aTheme}" {if $sThemeConfig==$aTheme}selected="selected"{/if}>{$aTheme}</option>
                {/foreach}
                </select>
              </td>
            </tr>
          </table>

        </fieldset>

        <br/>

        {foreach name=aImagesInfo from=$aImagesInfo item=aImageInfo}
        <!-- IMG {include file='img.tpl'}-->
        <!-- /IMG -->
        <br/>
        {/foreach}

        <br/>

        <table cellpadding="0" cellspacing="0" border="0" width="90%">
          <tr>
            <td align="center">
              <input type="reset" name="btnReset" value="{'Restore'|__}" />
              <input type="submit" name="btnSubmit" value="{'Send'|__}" />
            </td>
          </tr>
        </table>

      </form>
      </div>

    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </body>
</html>
