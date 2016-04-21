{include file="_menu.tpl"}

<div class="ui-corner-all content">
   <h2>Lista komponentów:</h2>

   <table class="lista">
      <tr>
         <th></th>
         <th>nazwa</th>
         <th>motyw</th>
         <th>akcje</th>
      </tr>
      {foreach from=$lista item="item"}
      <form method=post onSubmit="return confirm('Czy jesteś pewien?');">

      <input type=hidden name=id value="{$item.id}">
      <tr class="hover">
         <td style="width:40px">
         {if !empty($item.icon)}
            <img width="32" height="32" src="data:image/png;base64,{$item.icon}" >
         {/if}
         </td>
         <td>
            {$item.name}
         </td>
         <td>
            {$themes[$item.theme].name}
         </td>
         <td>
            <button name="act" value="del" type="submit" title="usuń">
               <span class="ui-icon ui-icon-trash"></span>
            </button>
            <a href="/komponenty/edytuj/{$item.id}">
               <button type="button" title="edycja">
                  <span class="ui-icon ui-icon-pencil"></span>
               </button>
            </a>
         </td>
      </tr>
      </form>
      {/foreach}
      <tr class="hover">
         <form method=post onSubmit="return $('#newName').val().length > 0"> 
         <input type=hidden name=act value=add>
         <td>&nbsp;</td>
         <td>
            <input type=text     name=newName   id=newName   size=50 placeholder="nazwa nowego komponentu">
         </td>
         <td>
            <select name="theme">
               {foreach $themes|@sortby:"id" as $theme}
                  <option value="{$theme.id}">{$theme.name}</option>
               {/foreach}
            </select>
         </td>
         <td>
            <button>
               <span class="ui-icon ui-icon-plus"></span>
               dodaj
            </button>
         </td>
         </form>
      </tr>
   </table>
</div>
