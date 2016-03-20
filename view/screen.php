<? 
   $id = $args->get(1);
   $plik = Pliki::get($id);
   $projekt = $plik[projekt];
   switch ($_POST[action])
   {
      case 'addArea'     : 
         Area::dodaj($id, $_POST[x1],$_POST[y1],$_POST[x2],$_POST[y2], $_POST[nazwaObszaru], $_POST[screenId]); 
         break;
      case 'go2proj'     : 
         header("Location: $SN/edit/$projekt");
         exit();
         break;
      case 'del'     : 
         Area::usun($id, $_POST[areaId]); 
         break;
      case 'fresh'   :  
         $newId = Pliki::zamien($id,$_FILES[screen]); 
         if (is_numeric($newId)) 
         {
            header("Location: $SN/screen/$newId");
            exit();
         }
         break;
   }
?>

<?php include(B.'_header.php');?> 
<?php include(B.'_menu.php'); ?>

<div class="ui-corner-all content">
   <form method=post >
   <button class=fr name=action value=go2proj>
      <span class="ui-icon ui-icon-arrow-1-n"></span>
      Wróć do projektu
   </button>
   </form>
   <h2>Screen: <?php echo $plik[nazwa]; ?></h2>
   <img src="<?php echo Pliki::src($id); ?>" id=screen border=0>
   
   <br>
   
      <button name=action value=add onClick="startCropp()" id="startCroppBtn">
         <span class="ui-icon ui-icon-plus"></span>
         dodaj obszar
      </button>
      <form method=post>
         <input type=hidden name=action value=addArea>
         <div id="addCropArea" class="hide">
            <label>X1: <input type="text" size="4" id="x1" name="x1" /></label> 
            <label>Y1: <input type="text" size="4" id="y1" name="y1" /></label> 
            <label>X2: <input type="text" size="4" id="x2" name="x2" /></label> 
            <label>Y2: <input type="text" size="4" id="y2" name="y2" /></label> 
            <label>szerokość: <span id="w"></span></label> 
            <label>wysokość: <span id="h"><span></label> 
            <br>
            nazwa obszaru: <input type=text name=nazwaObszaru size=50 id=nazwaObszaru><br>
            Link do:       <select name="screenId">
         <?php foreach(Pliki::lista($projekt) as $plik) { ?>
            <option value="<?php echo $plik[id]; ?>"><?php echo $plik[nazwa]; ?></option>
         <?php } ?>
      </select>
            <br>
            <button type=button onClick="stopCropp();">
               <span class="ui-icon ui-icon-cancel"></span>
               anuluj
            </button>
            <button onClick="">
               <span class="ui-icon ui-icon-check"></span>
               zapisz obszar
            </button>
         
         </div>
      </form>
      
      
      <button onClick="$(this).hide();$('#loadNewFileArea').show('slow');">
         załaduj nowszą wersję tego pliku
      </button>
      <div class=hide id=loadNewFileArea>
         <hr>
         <form ENCTYPE="multipart/form-data" method=post>
         <h3>załaduj nowszą wersję tego pliku:</h3>
         <input type=file name=screen><br>
         <button name=action value=fresh>
            <span class="ui-icon ui-icon-check"></span>
            prześlij nowszą wersję
         </button>
         </form>
      </div>

   <hr>


   <h3>Lista obszarów:</h3>
   <form method=post>
      <select size=10 style="min-width: 500px" name="areaId" onChange="showSelection(this)">
      <?php foreach(Area::lista($id) as $obszar) { ?>
         <option value="<?php echo $obszar['links.id']; ?>"
               x1="<?php echo $obszar['links.x1']; ?>"
               y1="<?php echo $obszar['links.y1']; ?>"
               x2="<?php echo $obszar['links.x2']; ?>"
               y2="<?php echo $obszar['links.y2']; ?>"
         > &rarr; <?php echo $obszar[nazwaLinku]; ?> (<?php echo $obszar['links.nazwa']; ?>)</option>
      <?php } ?>
      </select>
      <br>
      <button name=action value=del>
         <span class="ui-icon ui-icon-trash"></span>
         usuń obszar
      </button>
   </form>


   <div class=clr></div>
   <hr>

   <form method=post >
   <button name=action value=go2proj>
      <span class="ui-icon ui-icon-check"></span>
      OK, gotowe, wróć do projektu
   </button>
   </form>

   
</div>
<script>
   var api;

   function initApi()
   {
      if (typeof api != "object")
         api = $.Jcrop('#screen', {
            onChange: showCoords,
            onSelect: selectCompleted
         });
   }
   
   function startCropp()
   {
      $('#startCroppBtn').hide();
      $('#addCropArea').show('slow');
      initApi();
      api.enable();
      api.release();
      clearCoords();
   }
   
   function stopCropp()
   {
      $('#addCropArea').hide('slow');
      $('#startCroppBtn').show();
      api.release();
      api.disable();
      clearCoords();
   }
   
   function showCoords(c)
   {
      $('#x1').val(c.x);
      $('#y1').val(c.y);
      $('#x2').val(c.x2);
      $('#y2').val(c.y2);
      $('#w').text(c.w);
      $('#h').text(c.h);
   };
   function clearCoords()
   {
      showCoords({x:'',y:'',x2:'',y2:'',w:'',h:''});
   }
   function selectCompleted(e)
   {
      showCoords(e);
      $('#nazwaObszaru').focus();
   }
   
   function showSelection(o)
   {
      initApi();
      s = $(o).find(':selected');
       api.animateTo([
         s.attr('x1'),
         s.attr('y1'),
         s.attr('x2'),
         s.attr('y2')
      ]);
   }
</script>
<?php include(B.'_footer.php'); ?>
