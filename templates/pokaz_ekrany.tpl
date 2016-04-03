{include file="_menu.tpl"}

<div class="ui-corner-all content">
   <h2>Ekrany w ramach pokazu: {$pokaz.name}</h2>

   <table>
      {foreach from=$listaEkranow item="item"}
      <form method="post" id="f{$item.id}" onSubmit="return confirm('Czy jesteś pewien?');">
      <input type="hidden" name="screenId" value="{$item.id}">
      <tr class="appear hover">
         <td style="width:20px;">
            {if $item.isMain}
               <span class="ui-icon ui-icon-bullet" style="margin-left:1px;" title="To jest ekran startowy"></span>
            {else}
               <span class="ui-icon ui-icon-radio-on href" title="Ustaw ten ekran jako startowy"
                  onclick="$('#f{$item.id}').submit();" />
            {/if}
         </td>
         <td ondblclick="$(this).find('[role=show]').hide();$(this).find('[role=edit]').show();">
            <div role="show" class="inline">
               {$item.name}
            </div>
            <div role="edit" style="display:none">
               <input type="text" name="newName" value="{$item.name}" style="width: 80%;" class="fl">
               <button type="submit" name="act" value="ren" class="fr">
                  <span class="ui-icon ui-icon-disk"></span>
               </button>
            </div>
         </td>
         <td class="appear">
            <a href="/pokaz/ekran/{$item.id}"><button type="button">
                  <span class="ui-icon ui-icon-pencil"></span>
                  edytuj
               </button></a>
            <button name="act" value="del" type="submit" title="usuń">
               <span class="ui-icon ui-icon-trash"></span>
               &nbsp;
            </button>
         </td>
      </tr>
      </form>
      {/foreach}
      <tr class="hover appear">
         <form method=post onSubmit="return $('#screenName').val().length > 0"> 
         <input type=hidden name=act value=add>
         <td style="width:20px;">&nbsp;</td>
         <td class="appear"><input type=text name=screenName id=screenName size=40></td>
         <td class="appear"><button><span class="ui-icon ui-icon-plus"></span>dodaj nowy</button></td>
         </form>
      </tr>
   </table>
 
   
</div>