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
  var frm = window.document.frmProductImg;

  if ((!load)&&(!reset)){
    frm.btnReset.disabled = false;
  }
  else{
    frm.btnReset.disabled = true;
    if (reset)
      frm.reset();
  }
}

//-->
</script>
<!-- /LITERAL {/literal}-->

  </head>
  <body onload="UpdateFormStatus2(true,false);" >

    <!-- HEADER {include file='header.tpl'}-->
    <!-- /HEADER -->

    <!-- MENU {include file='menu.tpl'}-->
    <!-- /MENU -->

    <div id="content">
      <h4>{$sAccessType}.</h4>

      <div class="box">
      <form name="frmProductImg" method="post" action="form_product-img_post.php"
            enctype="multipart/form-data"
            onreset="UpdateFormStatus2(false,true);">

        <input type="hidden" name="hidProductCod" value="{$iProductCod}" />

        <input type="hidden" name="radBrand" value="{$iBrandType}" />
        <input type="hidden" name="selBrand" value="{$iProductBrand}" />
        <input type="hidden" name="txtNewBrand" value="{$sProductBrand}" />

        <input type="hidden" name="selCategory" value="{$iProductCategory}" />
        <input type="hidden" name="chkSubcategory" value="{$iSubCategory}" />
        <input type="hidden" name="txtNewCategory" value="{$sProductCategory}" />

        <input type="hidden" name="txtModel" value="{$sModel}" />
        <input type="hidden" name="txtDescription" value="{$sDescription}" />
        <input type="hidden" name="txaCharacts" value="{$sCharacts}" />
        <input type="hidden" name="txaSpecs" value="{$sSpecs}" />

        <input type="hidden" name="hidNumProvisions" value="{$iNumProvisions}" />
        {foreach name=aProvisions from=$aProvisions item=aProvision}
        <input type="hidden" value="{$aProvision.sDealerID}" 
               name="hidProvisions[][sDealerID]" />
        <input type="hidden" value="{$aProvision.iDealerCod}"
               name="hidProvisions[{$smarty.foreach.aProvisions.iteration-1}][iDealerCod]" />
        <input type="hidden" value="{$aProvision.sDealerName}"
               name="hidProvisions[{$smarty.foreach.aProvisions.iteration-1}][sDealerName]" />
        <input type="hidden" size="10" value="{$aProvision.iPrice}"
               name="hidProvisions[{$smarty.foreach.aProvisions.iteration-1}][iPrice]" />
        {/foreach}

        <!-- IMG {include file='img.tpl'}-->
        <!-- /IMG -->
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
