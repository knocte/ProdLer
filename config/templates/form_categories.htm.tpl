<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
  <head>
    <title>{$sCompanyName} - {'Categories Management'|__}</title>

    <!-- HEAD {include file='head.tpl'}-->
    <!-- /HEAD -->

<!-- LITERAL {literal}-->
<script language="JavaScript" type="text/javascript">
<!--
function UpdateFormStatus(){
  Select0Button(window.document.frmCategory.selCategory,window.document.frmCategory.btnMod);
  Select0Button(window.document.frmCategory.selCategory,window.document.frmCategory.btnDel);
  SelectButton(window.document.frmCategory.selCategory,window.document.frmCategory.btnProd);
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
      <h4>{'Categories Management'|__}.</h4>

      <div class="box">
      <form name="frmCategory" method="post" action="form_categories_post.php">

        <table cellspacing="0" border="0" width="100%">
          <tr>
            <td colspan="2">
              {'Categories'|__}:
            </td>
          </tr>
          <tr>
            <td width="50%">
              <select name="selCategory" size="10" style="width: 90%;"
                      onchange="UpdateFormStatus();">
              <option value="0" class="meta">[{'ROOT'|__}]</option>
              {foreach from=$aCategories item=aCategory}
              <option value="{$aCategory.cod}">{$aCategory.pretext|smarty:nodefaults}{$aCategory.name}</option>
              {/foreach}
              </select>
            </td>
            <td> 
              <input type="submit" name="btnAdd" style="width: 70%;"
                     value="{'Add new category'|__}" />
              <br/><br/>
              <input type="submit" name="btnMod" style="width: 70%;"
                     value="{'Modify selected category'|__}"
                     {if !$aCategories}disabled="disabled"{/if} />
              <br/><br/>
              <input type="submit" name="btnDel"  style="width: 70%;"
                     value="{'Delete selected category'|__}"
                     {if !$aCategories}disabled="disabled"{/if} />
              <br/><br/>
              <input name="btnProd" type="submit" style="width: 70%;"
                     value="{'Products of selected category'|__}" />
            </td>
          </tr>
        </table>
      </form>
      <p class="info">{'Total number of categories'|__}: {$iNumCategories}</p>
      </div>

    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </body>
</html>
