{include file="_menu.tpl" addons="kontrolki"}

<div class="ui-corner-all content">
   <a href="/"><span class="ui-icon ui-icon-home pull-left" style="margin-top:2px"></span></a> >
   <a href="/pokaz/lista">lista pokazów</a> >
   <a href="/pokaz/edytuj/{$pokaz.id}">pokaz: {$pokaz.name}</a> >
   <a href="/pokaz/ekran/{$idEkranu}">ekran: {$nazwaEkranu}</a>
</div>

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
   {rdelim});
   {/foreach}
</script>
<div class="ui-corner-all content" style="height:100%;">
   <h2>{$nazwaEkranu} ({$pokaz.name})</h2>
   <div class="screenHolder" onClick="screenHolderClick(arguments[0], this);" style="width:{$theme.width}px; height:{$theme.height}px">
      
   </div>
   <form method="post" id="saveScreenForm" onSubmit="return prepareSaveScreen()">
      <button type="submit">
         <span class="ui-icon ui-icon-check"></span>
         Zapisz
      </button>
   </form>
</div>

<div style="clear:both"></div>