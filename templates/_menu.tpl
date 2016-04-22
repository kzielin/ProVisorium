<div class="leftMenu">

   {if $rola >= $R_MASTER}
   <ul class="ui-corner-all">
         <li><a class="block" href="/motywy">motywy</a></li>
         <li><a class="block" href="/komponenty">komponenty</a></li>
   </ul>
   {/if}
   <ul class="ui-corner-all">
      <li><a class="block" href="/pokaz/lista">pokazy</a></li>
   </ul>
   <ul class="ui-corner-all">
      {if $rola >= $R_ADMIN}
         <li><a class="block" href="/logowanie/listaUzytkownikow">użytkownicy</a></li>
      {/if}
      <li><a href="/logowanie/zmianaHasla">zmiana hasła</a></li>
      <li><a href="/logowanie/wyloguj">wyloguj</a></li>
   </ul>
   {if $addons|contains:'file2base64'}
      <ul class="ui-corner-all ohix">
         <span class="dtxt stxt">osadź obrazek w css</span>
         <form method="post" target="_blank" action="/komponenty/file2base64" enctype="multipart/form-data">
            <input type="file" name="image" onchange="$(this).closest('form').submit();">
         </form>
      </ul>
   {/if}

   {if $addons|contains:'kontrolki'}
      <ul class="ui-corner-all ohix">
         <div class="dtxt stxt">dostępne komponenty</div>

         {foreach from=$kontrolki item="item"}
            <img class="iconHolder ui-corner-all" width=32 height=32 src="data:image/png;base64,{$item.icon}" alt="{$item.name}" title="{$item.name}" data-id="{$item.id}" data-name="{$item.name}" data-props="{$item.props|base64encode}" data-html="{$item.html|base64encode}" data-js="{$item.js|base64encode}" data-css="{$item.css|base64encode}">
         {/foreach}
      </ul>
      <ul class="ui-corner-all ohix props-wrapper" style="display:none">
         <div class="dtxt stxt props-title has-spinner">
            <span class="spinner"><span class="glyphicon glyphicon-spin glyphicon-refresh"></span></span>
            <span>Właściwości</span>
         </div>
         <div class="props-area"></div>
      </ul>
   {/if}

</div>
{if !empty($warning)}
   <div class="warning ui-corner-all">{$warning}</div>
{/if}

{if !empty($message)}
<div class="message">
   <div class="ui-corner-bottom">
	{$message}
   <span class="ui-icon ui-icon-close ui-icon-inline ui-corner-all ui-icon-active href"
      onClick="$(this).parent().fadeOut('slow');"></span>
   </div>
</div>
{/if}

{if !empty($listaEkranow)}
   <input type="hidden" id="listaEkranow" value="{$listaEkranow|json_encode|base64_encode}">
{/if}