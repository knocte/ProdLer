<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
  <head>
    <title>{$sCompanyName} - {'Brands'|__}</title>

    <!-- HEAD {include file='head.tpl'}-->
    <!-- /HEAD -->

  </head>
  <body>

    <!-- HEADER {include file='header.tpl'}-->
    <!-- /HEADER -->

    <!-- MENU {include file='menu.tpl'}-->
    <!-- /MENU -->

    <div id="content">
      <h4>{'Brands'|__}</h4>

      {if $aBrands}<div class="box">
        <table style="margin-left: 25px;">
          <tr>
          {foreach name=aBrands from=$aBrands item=oBrand}
            <td height="50" align="right">
              <a href="brand.php?cod={$oBrand->iCod}"
                 style="margin-right: 10px;">{$oBrand->sName}</a>
            </td>
            {if ($oBrand->oImage)}
            <td>
              <img src="../include/image.php?cod={$oBrand->oImage->iCod}&amp;dim=100"
                   alt="{$oBrand->sName}" title="{$oBrand->sName}"
                   {size dim=$oBrand->oImage->GetDimensions(100)} align="left" />
            </td>
            {/if}
            <td {if (!$oBrand->oImage)}colspan="2"{/if}>
              {if (($oBrand->sURL)&&($oBrand->sURL!=''))}
              <a href="{$oBrand->sURL}" target="_blank"
                 style="margin-right: 75px; margin-left: 10px;">
              <img title="{$oBrand->sName} {'site'|__}" alt="{$oBrand->sName} {'site'|__}"
                   src="../images/arrow.gif" /></a>&nbsp;
              {/if}
            </td>
            {if ((($smarty.foreach.aBrands.iteration % 2) == 0) &&
                ($aBrands|@count != $smarty.foreach.aBrands.iteration))}
              </tr><tr>
            {/if}
          {/foreach}
          </tr>
	</table>
      </div>
      {/if}
    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </body>
</html>