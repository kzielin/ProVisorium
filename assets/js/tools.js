$(document).ready(function() {
   $("div.tabs").tabs({
       load: function( event, ui ) { console.log('load');}
   });
   $(".appear input,.appear select,.appear textarea,.appear button")
      .focus(function(){$(this).closest('.row.appear').addClass('appearFocus');})
      .blur(function(){$(this).closest('.row.appear').removeClass('appearFocus');})
   ;
   $("div.message").show().delay(7000).fadeOut('slow');
   $("textarea.autoheight")
      .css('height','auto')
      .css('overflow-y','hidden')
      .keyup(function(){
         while (this.scrollHeight > this.clientHeight && $(this).css('overflow-y') == 'hidden') {
            if (this.rows < $(this).data('maxrows') || 30) this.rows = this.rows + 1;
            else $(this).css('overflow-y','scroll');
         }
      })
      .trigger('keyup')
   ;

   $('input[type="file"]')
      .wrap('<div style="margin:0;padding:0;display:block;width:110px;height:25px;overflow:hidden;" class="ui-corner-all button" />')
      .css({opacity: 0,"margin-top":-1,"margin-left":-1})
      .before('<div style="position:absolute;margin: 2px 0 0 5px;"><span style="position:relative; top: -2px;" class="ui-icon ui-icon-inline ui-icon-folder-open" />Wybierz plik</div>')
      ;

   $('img.iconHolder').click(function(){
      $(this).parent().find('img.iconHolderSelected').removeClass('iconHolderSelected');
      $(this).addClass('iconHolderSelected');
   });
      
});

jQuery(function($){
	$.datepicker.regional['pl'] = {
		closeText: 'akceptuj',
		prevText: '&#x3c;Poprzedni',
		nextText: 'Następny&#x3e;',
		currentText: 'Dziś',
		monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec', 'Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'],
		monthNamesShort: ['Sty','Lut','Mar','Kwi','Maj','Cze', 'Lip','Sie','Wrz','Paz','Lis','Gru'],
		dayNames: ['Niedziela','Poniedzialek','Wtorek','Środa','Czwartek','Piątek','Sobota'],
		dayNamesShort: ['Nie','Pn','Wt','Śr','Czw','Pt','So'],
		dayNamesMin: ['N','Pn','Wt','Śr','Cz','Pt','So'],
		dateFormat: 'yy-mm-dd', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['pl']);
});

function mouseX(e)
{
   e = e || window.event;
   if (e.pageX) 
      return e.pageX;
   if (e.clientX) 
      return e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
   
   return 0;
}

// funkcja zwraca pozycja Y myszki
function mouseY(e)
{
   e = e || window.event;
   if (e.pageY) 
      return e.pageY;
   if (e.clientY) 
      return e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
   return 0;
}
function screenHolderClick(e, ob) {
   var of = $(ob).offset();
   var x = mouseX(e) - of.left;
   var y = mouseY(e) - of.top;
   
   if ($('.iconHolderSelected:first').length == 1) {
      if (isNaN(window.nrE)) window.nrE = 0;
      window.nrE = window.nrE + 1;
      var compo = $('.iconHolderSelected:first').removeClass('iconHolderSelected');
      var newOb = $('<div><span class="pv-movable-handle ui-icon ui-icon-arrow-4"></span>'
                     +window.atob(compo.data('html'))+'</div>');
      $(ob).append(newOb);
      var of = $('.screenHolder:first').offset();
      x = x - (x % 10) + 5 + of.left;
      y = y - (y % 10) + 5 + of.top;
      newOb
         .addClass('elementHolder component_'+compo.attr('title'))
         .attr('id', 'el'+window.nrE)
         .resizable()
         .draggable({ handle: '.pv-movable-handle' })
         .hover(
				function(){ $(this).find('.pv-movable-handle').show() },
				function(){ $(this).find('.pv-movable-handle').hide() }
			)
         ;
      var obOf = newOb.offset();
   } else {
      
   }
}