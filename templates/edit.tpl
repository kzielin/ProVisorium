{include file="_menu.tpl"}

<div class="ui-corner-all content">
   <h2>{$projektTxt}</h2>
   <h3>Lista ekranów:</h3>
      <table>
      {foreach from=$pliki item="plik" name="ekrany"}
      <form method=post onSubmit="return confirm('Czy jesteś pewien?');">
      <input type=hidden name=screenId value="{$plik.id}">
      <tr class="hover">
         <td>{if $defaultScreen == $plik.id}*{/if}</td>
         <td ondblclick="$(this).children('[role=show]').hide();$(this).children('[role=edit]').show();">
            <div role="show" class="inline">
               {$plik.nazwa}
            </div>
            <div role="edit" class="hide">
               <input type="text" name="newName" value="{$plik.nazwa}" style="width: 80%;" class="fl">
               <button type="submit" name="act" value="ren" class="fr">
                  <span class="ui-icon ui-icon-disk"></span>
               </button>
            </div>
         </td>
         <td>
            <button name=act value=edit>
               <span class="ui-icon ui-icon-pencil"></span>
               edytuj
            </button>
            
            <button name=act value=up {if $smarty.foreach.ekrany.first}disabled="disabled"{/if} title="przesuń w górę">
               <span class="ui-icon ui-icon-arrowthick-1-n"></span>
            </button>
            
            <button name=act value=down {if $smarty.foreach.ekrany.last}disabled="disabled"{/if} title="przesuń w dół">
               <span class="ui-icon ui-icon-arrowthick-1-s"></span>
            </button>
            
            <button name=act value=default {if $defaultScreen == $plik.id}disabled="disabled"{/if}>
               <span class="ui-icon ui-icon-star"></span>
               ustaw jako domyślny
            </button>

            <button name=act value=del title="usuń">
               <span class="ui-icon ui-icon-trash"></span>
               &nbsp;
            </button>
         </td>
      </tr>
      </form>
      {/foreach}
      <form method=post>
      <tr class="hover">
         <td></td>
         <td><input type=text name=fileName size=40></td>
         <td>
            <button name="act" value="add">
               <span class="ui-icon ui-icon-plus"></span>dodaj nowy
            </button>
         </td>
      </tr>
      </form>
      </table>
   <hr>
</div>
