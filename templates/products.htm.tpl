<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
  <head>
    <title>{$sCompanyName} - {'Products'|__}</title>

    <!-- HEAD {include file='head.tpl'}-->
    <!-- /HEAD -->

  </head>
  <body>

    <!-- HEADER {include file='header.tpl'}-->
    <!-- /HEADER -->

    <!-- MENU {include file='menu.tpl'}-->
    <!-- /MENU -->

    <div id="content">
      <h4>
      {if $oBrand}<strong>{'Brand'|__}</strong>: {$oBrand->sName}{/if}
      {if $oCategory}
        {if $oCategory->iCod>0}
          <strong>{'Category'|__}</strong>: {$oCategory->sName}
        {else}
          {'Categories'|__}
        {/if}
      {/if}
      {if (!$oBrand) && (!$oCategory)}{'Products found'|__}:{/if}
      </h4>

      {if $aCategories}
        <div class="box">

        <table style="margin-left: 25px;">
          <tr>
          {foreach name=aCategories from=$aCategories item=oCategory}
            <td width="100" align="center" height="75">
            {if ($oCategory->oImage)}
              <img src="../include/image.php?cod={$oCategory->oImage->iCod}&amp;dim=75"
                   {size dim=$oCategory->oImage->GetDimensions(75)} alt="{$oCategory->sName}"
                   title="{$oCategory->sName}" align="left" />
            {/if}
            </td>
            <td align="left">
              <a href="category.php?cod={$oCategory->iCod}"
                 style="margin-right: 75px;" >{$oCategory->sName}</a>
            </td>

            {if ((($smarty.foreach.aCategories.iteration % 2) == 0) &&
                ($aCategories|@count != $smarty.foreach.aCategories.iteration))}
              </tr><tr>
            {/if}
          {/foreach}
          </tr>
	</table>

      </div>
      {/if}

      {if $aProducts}
      <table style="margin-left: 25px;">
        <tr>
        {foreach name=aProducts from=$aProducts item=oProduct}
          <td width="100" align="center" height="75">
          {if ($oProduct->oImage)}
            <img src="../include/image.php?cod={$oProduct->oImage->iCod}&amp;dim=75"
                 {size dim=$oProduct->oImage->GetDimensions(75)} alt="{$oProduct->sName}"
                 title="{$oProduct->sName}" align="left" />
          {/if}
          </td>
          <td align="left">
            <a href="product.php?cod={$oProduct->iCod}"
               style="margin-right: 75px;">{$oProduct->oBrand->sName}
              {$oProduct->sModel}</a><br/><br/>
            {'Price'|__}:
            {if (($oProduct->GetFinalPrice())>0)}
              {$oProduct->GetFinalPrice()}               {$sCurrencySymbol}
            {else}
              [{'Contact us'|__}]
            {/if}
          </td>
          {if ((($smarty.foreach.aProducts.iteration % 2) == 0) &&
              ($aProducts|@count != $smarty.foreach.aProducts.iteration))}
            </tr><tr>
          {/if}
        {/foreach}
        </tr>
      </table>
      {/if}

      <br/>

      {if $sTaxSentence!=''}
      <div style="padding-top: 50px; text-align: center;">
      <strong>{$sTaxSentence}</strong>
      </div>
      {/if}

    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </body>
</html>