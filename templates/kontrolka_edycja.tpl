{include file="_menu.tpl" addons="file2base64"}

<div class="ui-corner-all content">
   <h2>Edycja komponentu {$component.name}:</h2>
   <form method="post">
      <button type="submit">
         <span class="ui-icon ui-icon-check"></span>
         zapisz
      </button>
      
      <a href="komponenty/eksportuj/{$idKomponentu}" target="_blank" class="fr">
         <button type="button">
            <span class="ui-icon ui-icon-extlink"></span>
            eksportuj
         </button>
      </a>
      <table class="wide">
         <col style="width: 40%" />
         <col style="width: 60%" />
         <tbody>
            <tr>
               <td rowspan=2 class="top">
                  <div class="tabs">
                     <ul>
                        <li><a href="#tabs-css3">Styl CSS3 komponentu</a></li>
                     </ul>
                  <div id="tabs-css3">
                     <span class="mono">div.component_{$component.name|urlencode} { </span><br>
                     <textarea class="wide autoheight" rows="2" name="css" id="fcss"
                     >{$savedCss|default:$component.css|escape:"html"}</textarea><br>
                     <span class="mono">}</span>
                  </div>
               </td>
               <td class="top">
                  <div class="tabs">
                     <ul>
                        <li><a href="#tabs-prop">Właściwości</a></li>
                        <li><a href="#tabs-html">Kod HTML</a></li>
                        <li><a href="#tabs-js">Kod Javascript</a></li>
                        <li><a href="#tabs-icon">Miniatura</a></li>
                     </ul>
                     <div id="tabs-prop">
                        <table class="wide">
                           <col style="width:10px" />
                           <col style="width:120px" />
                           <col style="width:100px" />
                           <col />
                           <col style="width:40px" />
                           <thead>
                              <tr>  
                                 <th colspan="2">Identyfikator</th>
                                 <th>Typ</th>
                                 <th>Wartość domyślna</th>
                                 <th>&nbsp;</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr class="appear">
                                 <td class="appear">#</td>
                                 <td class="appear"><input type="text" class="wide" placeholder="wyróżnik" title="Zdefiniuj możliwe właściwości komponentu. Właściwości są ustawiane przez projektanta w momencie wykorzystania komponentu na formatce. Identyfikator właściwości może zostać użyty w definicji komponentu - w kodzie CSS, HTML oraz JavaScript. Przykładowe identyfikatory: tekst, tytul, kolorTla, rozmiar." name="propId[]" id="propId"></td>
                                 <td class="appear">
                                    <select name="propType[]" id="propType">
                                       <option value="t">tekst</option>
                                       <option value="l">liczba</option>
                                       <option value="p">procent</option>
                                       <option value="c">kolor</option>
                                       <option value="e">wyliczeniowy</option>
                                    </select>
                                 </td>
                                 <td class="appear">
                                    <input type="text" class="wide" placeholder="Wartość domyślna"
                                    title="Wartość domyślna bez jednostki miary (bez %, px itp). Dla typu 'kolor' należy podać domyślny kolor w formacie HTML. Dla typu wyliczeniowego należy podać elementy listy oddzielone średnikiem, domyślna będzie pierwsza wartość." name="propDefault[]" id="propDefault">
                                    </td>
                                 <td class="appear">
                                    <button type="button" onclick="addProp(this)" title="dodaj właściwość" id="addBtn">
                                       <span class="ui-icon ui-icon-plus"></span>
                                    </button>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                     <div id="tabs-html">
                        <span class="mono">&lt;div class="component_{$component.name|urlencode}"&gt;<br></span>
                        <textarea class="wide autoheight" rows="2" data-maxrows="5" name="html" id="fhtml"
                        >{$savedHtml|default:$component.html|escape:"html"}</textarea><br>
                        <span class="mono">&lt;/div&gt;</span>
                     </div>
                     <div id="tabs-js">
                        <span class="mono">$(".component_{$component.name|urlencode}").each(function(){ <br></span>
                        <textarea class="wide autoheight" rows="2" data-maxrows="20" name="js" id="fjs"
                        >{$savedJs|default:$component.js|escape:"html"}</textarea><br>
                        <span class="mono">};</span>
                     </div>
                     <div id="tabs-icon">
                        <div class="hide center" id="iconPreview">
                           Podgląd ikony: <br>
                           <img src="">
                           <hr>
                        </div>
                        
                        <span class="mono">&lt;img width="32" height="32" src="data:image/png;base64,</span><br>
                        <textarea class="wide autoheight" rows="2" data-maxrows="5" name="icon" id="ficon"
                        onChange="refreshIconPreview()"
                        >{$savedIcon|default:$component.icon|escape:"html"}</textarea><br>
                        <span class="mono">"&gt;</span>
                     </div>
                  </div>
               </td>
            </tr>
            <tr>
               <td class="top">
                  <div class="tabs">
                     <ul>
                        <li><a href="#tabs-preview">Podgląd komponentu</a></li>
                     </ul>
                     <div id="tabs-preview">
                        <iframe id="preview" name="preview" class="wide" height="150px" scrolling="no" border="0" frameborder="0"></iframe>
                        <button type="button" onClick="refreshPreview()">
                           <span class="ui-icon ui-icon-refresh"></span>
                           odśwież podgląd
                        </button>
                     </div>
                  </div>
               </td>
            </tr>
         </tbody>
      </table>
   </form>
   <form method="post" target="preview" id="previewForm" action="komponenty/preview">
      <input type="hidden" name="html"  id="previewHtml"    >
      <input type="hidden" name="css"   id="previewCss"     >
      <input type="hidden" name="js"    id="previewJs"      >
      <input type="hidden" name="props" id="previewProps"   >
      <input type="hidden" name="name" id="previewName" value="{$component.name}">
   </form>
<script type="text/javascript">
function refreshPreview() {
   $('#previewHtml').val($('#fhtml').val());
   $('#previewCss').val($('#fcss').val());
   $('#previewJs').val($('#fjs').val());
   var props = [];
   $('#tabs-prop tr').each(function(){
      var p = {
         id: $(this).find('input[name^=propId]:first').val(),
         typ: $(this).find('select[name^=propType]:first').val(),
         def: $(this).find('input[name^=propDefault]:first').val()
         };
      if (p.id != undefined && p.id.length > 0)
         props.push(p);
   });
   $('#previewProps').val(JSON.stringify(props));
   
   $('#previewForm').submit();
}
$(function() {
   $("#fhtml,#fcss,#fjs").change(function(){ refreshPreview(); });
   refreshPreview();
});

function addProp(ob) {
   var TR = $(ob).closest('tr');
   
   var isOk = true;

   var fId = TR.find('input.[type=text][name^=propId]:first');
   var typ = TR.find('input.[type=text][name^=propType]:first').val();
   var fDef = TR.find('input.[type=text][name^=propDefault]:first');
   
   
   if (fId.val().match(/^[a-zA-Z0-9_-]+$/) == undefined) {
      isOk = false;
   }
   
   if (isOk) {
      var newTR = TR.clone();
      newTR.find('input[type=text]').val('');
      newTR.find('input,select,textarea,button')
         .focus(function(){ $(this).closest('tr.appear').addClass('appearFocus');})
         .blur(function(){ $(this).closest('tr.appear').removeClass('appearFocus');})
      ;
      TR .find('input,select,textarea').attr('readonly',true).removeAttr('placeholder').removeAttr('id').removeAttr('title');
      TR .find('button').removeAttr('id');
      TR .removeClass('appear')
         .find('button').attr('title', 'Usuń').attr('onclick','').click(function(){ $(this).closest("tr").remove()})
         .find('span.ui-icon-plus').removeClass('ui-icon-plus').addClass('ui-icon-trash')
      ;
      newTR.insertAfter(TR);
   }
   refreshPreview();
}

function addNewProp(id,type,def) {
   $('#propId').val(id);
   $('#propType').val(type);
   $('#propDefault').val(def);
   addProp($('#addBtn'));
}
{if is_array($component.props)}
{foreach from=$component.props key="key" item="item"}
addNewProp('{$key}','{$item.type}','{$item.default}');
{/foreach}
{/if}

function refreshIconPreview() {
   if ($('#ficon').val().length > 0)
      $('#iconPreview').show().find('img').attr('src','data:image/png;base64,' + $('#ficon').val());
   else
      $('#iconPreview').hide();
}
refreshIconPreview();
</script>
</div>
