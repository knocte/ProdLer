-->
<fieldset>
<legend>{if !$aImageInfo}{'Image'|__}
        {else}{$aImageInfo[1]}{assign var="iImageCod" value=$aImageInfo[0]}
        {/if}</legend>
  <!-- 512KiloBytes maximum -->
  <input name="MAX_FILE_SIZE{$smarty.foreach.aImagesInfo.iteration}"
         type="hidden" value="524288" />

  <table cellpadding="10" cellspacing="0" width="100%" border="0">
    <tr>
      <td width="27%">

<label for="radNone{$smarty.foreach.aImagesInfo.iteration}"><input
                            name="radImage{$smarty.foreach.aImagesInfo.iteration}"
                            id="radNone{$smarty.foreach.aImagesInfo.iteration}"
                            type="radio" value="0"
       onclick="UpdateImgStatus{$smarty.foreach.aImagesInfo.iteration}(false);"
       onchange="UpdateImgStatus{$smarty.foreach.aImagesInfo.iteration}(false);"
                            {if !$iImageCod}checked="checked"{/if} />{'None'|__}.</label>

      </td>
      <td width="33%">

      </td>
      <td width="40%" rowspan="2">

<fieldset>
<legend><input name="btnPreview{$smarty.foreach.aImagesInfo.iteration}"
               id="btnPreview{$smarty.foreach.aImagesInfo.iteration}"
               type="submit" value="{'Preview'|__}:" disabled="disabled"
               onclick="return Preview{$smarty.foreach.aImagesInfo.iteration}();" /></legend>
<img name="imgPreview{$smarty.foreach.aImagesInfo.iteration}"
     src="{if $iImageCod}../../include/image.php?cod={$iImageCod}{/if}"
     alt="{'Image preview'|__}" />
</fieldset>

      </td>

    </tr>
    <tr>
      <td>

<label for="radDBcod{$smarty.foreach.aImagesInfo.iteration}"><input
                             type="radio" value="1"
                             name="radImage{$smarty.foreach.aImagesInfo.iteration}"
                             id="radDBcod{$smarty.foreach.aImagesInfo.iteration}" 
       onclick="UpdateImgStatus{$smarty.foreach.aImagesInfo.iteration}(false);"
       onchange="UpdateImgStatus{$smarty.foreach.aImagesInfo.iteration}(false);"
                             {if !$aImages}disabled="disabled"{/if} />{'Image code'|__}:</label><br/>
<label for="radFilename{$smarty.foreach.aImagesInfo.iteration}"><input
                                value="2" type="radio"
                                name="radImage{$smarty.foreach.aImagesInfo.iteration}"
                                id="radFilename{$smarty.foreach.aImagesInfo.iteration}"
       onclick="UpdateImgStatus{$smarty.foreach.aImagesInfo.iteration}(false);"
       onchange="UpdateImgStatus{$smarty.foreach.aImagesInfo.iteration}(false);"
                                {if !$aImages}disabled="disabled"{/if}
                                {if $iImageCod}checked="checked"{/if} />{'Image filename'|__}:</label><br/>
<label for="radUpload{$smarty.foreach.aImagesInfo.iteration}"><input
                              name="radImage{$smarty.foreach.aImagesInfo.iteration}"
                              id="radUpload{$smarty.foreach.aImagesInfo.iteration}"
                              value="3" type="radio"
       onclick="UpdateImgStatus{$smarty.foreach.aImagesInfo.iteration}(false);"
       onchange="UpdateImgStatus{$smarty.foreach.aImagesInfo.iteration}(false);" />{'New image'|__}:</label><br/>

      </td>

      <td>

<input type="text" name="txtImageCod{$smarty.foreach.aImagesInfo.iteration}"
       value="{$iImageCod}" size="4" maxlength="4" /><br/>
<select name="selImageFilename{$smarty.foreach.aImagesInfo.iteration}"
        onchange="UpdateImgStatus{$smarty.foreach.aImagesInfo.iteration}(false);"
        style="width: 90%;" {if !$aImages}disabled="disabled"{/if}>
{if !$aImages}<option value="0" class="meta">[{'No images'|__}]</option>
{else}
  {if !$iImageCod}
    <option value="0" class="meta">[{'Select a file'|__}]</option>
  {/if}
{/if}
{foreach from=$aImages item=aImage}
<option value="{$aImage.cod}" {if $iImageCod==$aImage.cod}selected="selected"{/if}>{$aImage.filename}</option>
{/foreach}</select><br />
<input name="filImage{$smarty.foreach.aImagesInfo.iteration}"
       type="file" size="10" />

      </td>
    </tr>
  </table>
</fieldset>
<script language="JavaScript" type="text/javascript"
       src="../../include/img.js.php{if
       $aImageInfo}?i={$smarty.foreach.aImagesInfo.iteration}{/if}"></script>
<!--