{include file="_menu.tpl"}

<div class="ui-corner-all content">
   <h2>Dostępne motywy:</h2>
   <div class="container-fluid">
      <div class="row btxt">
         <div class="col-sm-4">nazwa</div>
         <div class="col-sm-2">rozmiar płótna</div>
         <div class="col-sm-6">akcje</div>
      </div>
      {foreach from=$lista item="item"}
         <form method="post" onSubmit="return confirm('Czy jesteś pewien?');">
         <input type=hidden name="id" value="{$item.id}">
         <div class="row appear hover">
            <div class="col-sm-4" ondblclick="$(this).find('[role=show]').hide();$(this).find('[role=edit]').show();">
               <div role="show" class="inline">
                  {$item.name}
               </div>
               <div role="edit" style="display:none">
                  <input type="text" name="newName" value="{$item.name}" style="width: 80%;" class="fl">
                  <button type="submit" name="act" value="ren" class="pull-right" title="zapisz">
                     <span class="ui-icon ui-icon-disk"></span>
                  </button>
               </div>
            </div>
            <div class="appear col-sm-2">
               {$item.width} x {$item.height}
            </div>
            <div class="appear col-sm-6">
               {if $rola >= $R_MASTER}
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
      <div class="row hover appear">
         <form method="post" onSubmit="return $('#name').val().length > 0">
            <input type=hidden name=act value=add>
            <div class="col-sm-4 appear">
               <input type="text" name="name" id="name" size=40>
            </div>
            <div class="col-sm-2 appear">
               <input type="number" min="0" max="1000" name="width" value="800">
               x
               <input type="number" min="0" max="1000" name="height" value="600">
            </div>
            <div class="col-sm-6 appear">
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