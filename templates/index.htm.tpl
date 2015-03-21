<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
  <head>
    <title>{$sCompanyName} - {'Products Catalogue'|__}</title>

    <!-- HEAD {include file='head.tpl'}-->
    <!-- /HEAD -->

  </head>
  <body>

    <!-- HEADER {include file='header.tpl'}-->
    <!-- /HEADER -->

    <!-- MENU {include file='menu.tpl'}-->
    <!-- /MENU -->

    <div id="content">
      <div class="homeimg">
        {if $oLogoImage}
        <img id="imgHome" title="{$sCompanyName}" alt="{$sCompanyName} Logo"
             src="../include/image.php?cod={$oLogoImage->iCod}" 
             {size dim=$oLogoImage->GetDimensions()} />
        {/if}
      </div>
      <h1>{'Products Catalogue'|__}</h1>
      
      <br/>
      <p>{'Welcome to the interactive products catalogue of'|__}
      <a href="{$sCompanyURL}" target="_blank">{$sCompanyName}</a>.</p>
      <br/>
      <p>{'Please select the method you want to explore its contents'|__}:</p>
      <br/>

      <div class="box">
        <h3>{'Brands listing'|__}</h3>
        <br/>
        <p>{'Click'|__} <a href="brands.php">{'here'|__}</a>
        {'if you want to explore the catalogue selecting a brand to view its products'|__}.</p>
        <br/>
        <div class="category">{'Brands'|__}</div>
        <p class="info">{'Total number of brands'|__}: {$iNumBrands}</p>
      </div>

      <div class="box">
        <h3>{'Categories clasification'|__}</h3>
        <br/>
        <p>{'Click'|__} <a href="categories.php">{'here'|__}</a>
        {'to dive into the tree of the products categories'|__}.</p>
        <br/>
        <div class="category">{'Categories'|__}</div>
        <p class="info">{'Total number of categories'|__}: {$iNumCategories}</p>
      </div>
      
      <div class="box">
        <h3>{'Products search'|__}</h3>
        <br/>
        <p>{'Click'|__} <a href="products_search.php">{'here'|__}</a>
        {'to search any products on the database, based on different criteria'|__}.</p>
        <br/>
        <div class="category">{'Products'|__}</div>
        <p class="info">{'Total number of products'|__}: {$iNumProducts}</p>
      </div>

    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </body>
</html>
