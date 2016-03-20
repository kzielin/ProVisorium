{include file="_menu.tpl" addons="kontrolki"}
<style type="text/css">
{foreach from=$kontrolki item="kontrolka"}
div.component_{$kontrolka.name|urlencode} {ldelim}
   {$kontrolka.css}
{rdelim}
{/foreach}
</style>
<script type="text/javascript">
{foreach from=$kontrolki item="kontrolka"}
$(".component_{$kontrolka.name|urlencode}").each(function() {ldelim}
{$kontrolka.js}
{rdelim}
{/foreach}
</script>
<div class="ui-corner-all content" style="height:100%;">
   <h2>Ekran: {$nazwaEkranu}</h2> 
   <div class="screenHolder" onClick="screenHolderClick(arguments[0], this);">
      
   </div>
</div>

<div style="clear:both"></div>