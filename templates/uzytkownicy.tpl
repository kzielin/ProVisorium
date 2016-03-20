{include file="_menu.tpl"}

<div class="ui-corner-all content">
   <h2>Lista użytkowników:</h2>

   <table>
      {foreach from=$listaUzytkownikow item="item"}
      <form method=post onSubmit="return confirm('Czy jesteś pewien?');">
      
      <input type=hidden name=login value="{$item.login}">
      <tr class="appear hover">
         <td>
            {assign var="itemRola" value=$item.rola}
            {$item.login} <span class="dtxt">({$listaRol.$itemRola})</span>
         </td>
         <td class="appear">
            <button name="act" value="del" type="submit" title="usuń">
               <span class="ui-icon ui-icon-trash"></span>
            </button>
            <a href="logowanie/zmianaHasla/{$item.login}">
               <button type="button">
                  <span class="ui-icon ui-icon-key"></span>
                  zmień hasło
               </button>
            </a>
            {if $item.rola == $R_USER}
            <a href="logowanie/uprawnienia/{$item.login}" title="wybierz pokazy dostępne dla tego loginu">
               <button type="button">
                  <span class="ui-icon ui-icon-unlocked"></span>
                  uprawnienia
               </button>
            </a>
            {/if}
            
         </td>
      </tr>
      </form>
      {/foreach}
      <tr class="hover appear">
         <form method=post onSubmit="return $('#newName').val().length > 0"> 
         <input type=hidden name=act value=add>
         <td class="appear">
            <input type=text     name=newName   id=newName   size=15 placeholder="login">
            <input type=password name=newPasswd id=newPasswd size=15 placeholder="hasło">
            <select name=newRole>
               {foreach from=$listaRol item="item" key="key"}
                  {if $key != $R_ALL}
                  <option value={$key}>{$item}</option>
                  {/if}
               {/foreach}
            </select>
         </td>
         <td class="appear"><button><span class="ui-icon ui-icon-plus"></span>dodaj nowego</button></td>
         </form>
      </tr>
   </table>
 
   
</div>