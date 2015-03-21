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
      <h1><strong>{$oProduct->oBrand->sName} {$oProduct->sModel}</strong></h1>
      <h4>{$oProduct->sDescription}</h4>


      <div class="box">
        {if $oProduct->oImage}
        <div>
          <img title="{$oProduct->oBrand->sName} {$oProduct->sModel}"
               alt="{$oProduct->oBrand->sName} {$oProduct->sModel}"
               src="../include/image.php?cod={$oProduct->oImage->iCod}" align="right"
               {size dim=$oProduct->oImage->GetDimensions()}
               style="margin: 25px 25px 25px 50px;" />
        </div>
        {/if}

        {if $oProduct->sCharacts!=''}
        <h3>{'Characteristics'|__}</h3>

        <p align="justify">{$oProduct->sCharacts|nl2br}</p>
        {/if}

        {if $oProduct->sSpecs!=''}
        <h3>{'Specifications'|__}</h3>

        <ul>
        {foreach from=$oProduct->GetSpecsList()|smarty:nodefaults item=sSpecLine}
        <li>{$sSpecLine}</li>
        {/foreach}
        </ul>
        {/if}

        <h4><strong>{'Price'|__}</strong>:
        {if (($oProduct->GetFinalPrice())>0)}{$oProduct->GetFinalPrice()} {$sCurrencySymbol}
        {else}[{'Contact us'|__}]{/if}</h4>
      </div>
    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </body>
</html>