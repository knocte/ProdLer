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
  var cod = {/literal}{$iCategoryCod}{literal};
  var frm = window.document.frmCategory;

  if (cod==0){
    frm.btnReset.disabled = !( (!IsEmpty(frm.txtCategoryName.value))||
                            (frm.selParentCategory.selectedIndex!=
                            {/literal}{$iCategoryParent}{literal}));
    frm.btnSubmit.disabled = ((IsNothing(frm.txtCategoryName.value))||
                             (frm.selParentCategory.selectedIndex==-1));

    if (load)
      frm.txtCategoryName.focus();
  }
  else{
    if (load){
      frm.btnSubmit.disabled = true;
      frm.btnReset.disabled = true;
    }
    else if (!reset){
      frm.btnSubmit.disabled = false;
      frm.btnReset.disabled = false;
    }
  }

  if (load)
    ScrollSelect(frm.selParentCategory)

  if (reset)
    FormResetSubmitText(frm,frm.btnReset,frm.btnSubmit,frm.txtCategoryName);

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
      <form name="frmCategory" method="post" action="form_category_post.php"
            enctype="multipart/form-data"
            onreset="UpdateFormStatus2(false,true);" >
        <input type="hidden" name="hidCategoryCod" value="{$iCategoryCod}" />

        <table cellspacing="0" border="0" width="100%">
          <tr>
            <td></td>
            <td width="60%">
              {'Select the parent category'|__}:
            </td>
          </tr>
          <tr>
            <td width="40%"> 
              <label for="txtCategoryName">{'Category name'|__}:</label>
              <br/><br/>
              <input type="text" name="txtCategoryName" value="{$sCategoryName}"
                     style="width: 90%;" maxlength="48" id="txtCategoryName"
                     onkeyup="UpdateFormStatus2(false,false);"
                     onkeypress="UpdateFormStatus2(false,false);"
                     onchange="UpdateFormStatus2(false,false);" />
              <br/>
            </td>
            <td rowspan="2">
              <select name="selParentCategory" size="10" style="width: 90%;"
                      onchange="UpdateFormStatus2(false,false);" >
                <option value="0" {if $iCategoryParent eq 0}selected="selected"{/if}>
                [{'ROOT'|__}]</option>
                {foreach from=$aCategories item=aCategory}
                <option value="{$aCategory.cod}" {if $iCategoryParent eq $aCategory.cod}selected="selected"{/if}>
                {$aCategory.pretext|smarty:nodefaults}{$aCategory.name}</option>
                {/foreach}
              </select>
            </td>
          </tr>
          <tr>
            <td align="center">
              <input type="reset" name="btnReset" value="{'Restore'|__}" />
              <input type="submit" name="btnSubmit" value="{'Send'|__}" />
            </td>
          </tr>
        </table>

        <br/>
        <!-- IMG {include file='img.tpl'}-->
        <!-- /IMG -->

      </form>
      <p class="info">
      {if $sCategoryName}
      [{'Creation'|__}: {$sDateCreated} | {'Modification'|__}: {$sDateModified}]
      {/if}
      </p>
      </div>
    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </body>
</html>
