{include file="_menu.tpl"}

<div class="ui-corner-all content">
   <h2>Dostępne pokazy:</h2>
   <div class="container-fluid">
      <div class="row btxt">
         <div class="col-sm-4">nazwa</div>
         <div class="col-sm-2">motyw</div>
         <div class="col-sm-6">akcje</div>
      </div>
      {foreach from=$listaPokazow item="pokaz"}
         <form method="post" onSubmit="return confirm('Czy jesteś pewien?');">
         <input type=hidden name=showId value="{$pokaz.id}">
         <div class="row hover">
            <div class="col-sm-4" ondblclick="$(this).find('[role=show]').hide();$(this).find('[role=edit]').show();">
               <div role="show" class="inline">
                  {$pokaz.name}
               </div>
               <div role="edit" style="display:none">
                  <input type="text" name="newName" value="{$pokaz.name}" style="width: 80%;" class="fl">
                  <button type="submit" name="act" value="ren" class="pull-right" title="zapisz">
                     <span class="ui-icon ui-icon-disk"></span>
                  </button>
               </div>
            </div>
            <div class="col-sm-2">
               {$themes[$pokaz.theme].name}
            </div>
            <div class="col-sm-6">
               <a href="/pokaz/uruchom/{$pokaz.id}"><button type="button">
                  <span class="ui-icon ui-icon-play"></span>
                  uruchom
                  </button></a>
               {if $rola >= $R_MASTER}
               <a href="/pokaz/edytuj/{$pokaz.id}"><button type="button">
                     <span class="ui-icon ui-icon-pencil"></span>
                     edytuj
                  </button></a>
               <button name="act" value="del" type="submit">
                  <span class="ui-icon ui-icon-trash"></span>
                  usuń
               </button>
               {/if}
            </div>
         </div>
         </form>
      {/foreach}
      {if $rola >= $R_MASTER}
      <div class="row hover">
         <form method=post onSubmit="return $('#showName').val().length > 0"> 
            <input type=hidden name=act value=add>
            <div class="col-sm-4">
               <input type=text name=showName id=showName size=40>
            </div>
            <div class="col-sm-2">
               <select name="theme">
                  {foreach $themes|@sortby:"id" as $theme}
                     <option value="{$theme.id}">{$theme.name}</option>
                  {/foreach}
               </select>
            </div>
            <div class="col-sm-6">
               <button type="submit">
                  <span class="ui-icon ui-icon-plus"></span>
                  dodaj nowy
               </button>
            </div>
         </form>
      </div>
      {/if}
   </div>
 
   
</div>