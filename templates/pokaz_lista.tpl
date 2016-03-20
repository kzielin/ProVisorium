{include file="_menu.tpl"}

<div class="ui-corner-all content">
   <h2>Dostępne pokazy:</h2>

   <table>
      {foreach from=$listaPokazow item="pokaz"}
      <form method=post onSubmit="return confirm('Czy na pewno wykonać operację?');">
      <input type=hidden name=showId value="{$pokaz.id}">
      <tr class="appear hover">
         <td ondblclick="$(this).children('[role=show]').hide();$(this).children('[role=edit]').show();">
            <div role="show" class="inline">
               {$pokaz.name}
            </div>
            <div role="edit" class="hide">
               <input type="text" name="newName" value="{$pokaz.name}" style="width: 80%;" class="fl">
               <button type="submit" name="act" value="ren" class="fr">
                  <span class="ui-icon ui-icon-disk"></span>
               </button>
            </div>
         </td>
         <td class="appear">
            <a href="pokaz/uruchom/{$pokaz.id}" title="uruchom">
               <button type="button">
                  <span class="ui-icon ui-icon-play"></span>
               </button>
            </a>
            {if $rola >= $R_MASTER}
            <a href="pokaz/edytuj/{$pokaz.id}">
               <button type="button">
                  <span class="ui-icon ui-icon-pencil"></span>
                  edytuj
               </button>
            </a>
            <button name="act" value="del" type="submit" title="usuń">
               <span class="ui-icon ui-icon-trash"></span>
            </button>
            {/if}
         </td>
      </tr>
      </form>
      {/foreach}
      {if $rola >= $R_MASTER}
      <tr class="hover appear">
         <form method=post onSubmit="return $('#showName').val().length > 0"> 
         <input type=hidden name=act value=add>
         <td class="appear"><input type=text name=showName id=showName size=40></td>
         <td class="appear"><button><span class="ui-icon ui-icon-plus"></span>dodaj nowy</button></td>
         </form>
      </tr>
      {/if}
   </table>
 
   
</div>