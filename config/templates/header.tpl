-->
<div id="header">

  <div class="headimg">
    {if $oLogoImage}
    <img id="imgHeaderBig" title="{$sCompanyName}" alt="{$sCompanyName} Logo Image"
         src="../../include/image.php?cod={$oLogoImage->iCod}" {size dim=$oLogoImage->GetDimensions()} />
    {/if}
    {if $oLogoIcon}
    <img id="imgHeaderSmall" title="{$sCompanyName}" alt="{$sCompanyName} Logo Icon"
         src="../../include/image.php?cod={$oLogoIcon->iCod}" {size dim=$oLogoIcon->GetDimensions()} />
    {/if}
  </div>

  <div class="headline">{$sCompanyName}</div>
  <a href="{$sCompanyURL}" target="_blank">{$sCompanyURL}</a>

</div>
<!--