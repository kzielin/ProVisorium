{include file="_menu.tpl"}

<div class="ui-corner-all content">
   <h2>Dostępne pokazy:</h2>
   <div class="container-fluid">
      {foreach from=$listaPokazow item="pokaz"}
         <form method=post onSubmit="return confirm('Czy na pewno wykonać operację?');">
         <input type=hidden name=showId value="{$pokaz.id}">
         <div class="row appear hover">
            <div class="col-sm-6" ondblclick="$(this).children('[role=show]').hide();$(this).children('[role=edit]').show();">
               <div role="show" class="inline">
                  {$pokaz.name}
               </div>
               <div role="edit" class="hide">
                  <input type="text" name="newName" value="{$pokaz.name}" style="width: 80%;" class="fl">
                  <button type="submit" name="act" value="ren" class="fr">
                     <span class="ui-icon ui-icon-disk"></span>
                  </button>
               </div>
            </div>
            <div class="appear col-sm-6">
               <a href="/pokaz/uruchom/{$pokaz.id}" class="btn btn-default">
                  <span class="glyphicon glyphicon-play"></span>
                  uruchom
               </a>
               {if $rola >= $R_MASTER}
               <a href="/pokaz/edytuj/{$pokaz.id}" class="btn btn-default">
                     <span class="glyphicon glyphicon-edit"></span>
                     edytuj
               </a>
               <button name="act" value="del" type="submit" class="btn btn-danger">
                  <span class="glyphicon glyphicon-remove"></span>
                  usuń
               </button>
               {/if}
            </div>
         </div>
         </form>
      {/foreach}
      {if $rola >= $R_MASTER}
      <div class="row hover appear">
         <form method=post onSubmit="return $('#showName').val().length > 0"> 
            <input type=hidden name=act value=add>
            <div class="col-sm-6 appear">
               <input type=text name=showName id=showName size=40>
            </div>
            <div class="col-sm-6 appear">
               <a onclick="$(this).closest('form').submit()" class="btn btn-default" type="submit">
                  <span class="glyphicon glyphicon-plus"></span>
                  dodaj nowy
               </a>
            </div>
         </form>
      </div>
      {/if}
   </div>
 
   
</div>