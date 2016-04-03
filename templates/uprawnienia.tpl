{include file="_menu.tpl"}

<div class="content ui-corner-all">
   <h2>Dostępne pokazy dla użytkownika: {$dlaLoginu}</h2>
   {foreach from=$pokazy item="item" name="pokazy"}
      {if $smarty.foreach.pokazy.first}
         <span class="dtxt">wybierz pokazy, do których będzie miał dostęp użytkownik {$dlaLoginu}</span><br>
         <form method="post">
            <input type="hidden" name="dlaLoginu" value="{$dlaLoginu}">
            <select size="20" style="min-width:50%" multiple="multiple" name="pokazy[]">
         {/if}
            {assign var="itemid" value=$item.id}
            <option value="{$item.id}" {if $zaznaczone.$itemid}selected="selected"{/if}>
               {$item.name}
            </option>
         {if $smarty.foreach.pokazy.last}
            </select>
            <div style="min-width:50%; width: auto; display: inline-block">
               <button type="submit">
                  <span class="ui-icon ui-icon-check"></span>
                  Zapisz
               </button>
               <a href="/logowanie/listaUzytkownikow" class="pull-right">
                  <button type="button">
                     <span class="ui-icon ui-icon-cancel"></span>
                     Anuluj
                  </button>
               </a>
            </div>
         </form>
      {/if}
   {foreachelse}
      <span class=dtxt>(lista pusta)</span>
   {/foreach}
</div>