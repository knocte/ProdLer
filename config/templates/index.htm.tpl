<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
  <head>
    <title>{$sCompanyName} - {'Catalogue Administration'|__}</title>

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
        <img id="imgHome" title="{$sCompanyName}" alt="{$sCompanyName} Logo"
             src="../../include/image.php?cod={$oLogoImage->iCod}" 
             {size dim=$oLogoImage->GetDimensions()} />
      </div>
      <h1>{'Catalogue Administration'|__}</h1>

      <br/>
      <p>{'Welcome to the administrative zone'|__}, <strong>{$sLogin}</strong>.</p>

      <div class="box">
        <ul>
        <li><h3><a href="form_brands.php">{'Brands'|__}</a></h3></li>
        <li><h3><a href="form_categories.php">{'Categories'|__}</a></h3></li>
        <li><h3><a href="form_dealers.php">{'Dealers'|__}</a></h3></li>
        <li><h3><a href="form_products.php">{'Products'|__}</a></h3></li>
        </ul>

      </div>

      <h3><a href="form_prefs.php">{'Preferences'|__}</a></h3>

    </div>

    <!-- FOOTER {include file='footer.tpl'}-->
    <!-- /FOOTER -->

  </body>
</html>
