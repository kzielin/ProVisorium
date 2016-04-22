<div class="ui-corner-all show center">
   <span class="fr icon-active ui-corner-all ui-icon ui-icon-arrowreturnthick-1-w"
         onClick="window.location='/'"
         title="Powrót do listy pokazów"
   ></span>
   <span class="fr icon-active ui-corner-all ui-icon ui-icon-help"
         onMouseOver="$('#helpArea').fadeIn()"
         onMouseOut="$('#helpArea').fadeOut()"
   ></span>
    <div class="showTitle">{$pokaz.name} - {$nazwaEkranu}</div>

    <div style="position: relative; display: inline-block;">
        <div id="helpArea" class="hide">
            {foreach from=$areas item="link"}
                <div class="helpRegion"
                     style="left:{$link.x1}px; top:{$link.y1}px; width:{$link.x2-$link.x1}px; height:{$link.y2-$link.y1}px; "
                ></div>
            {/foreach}
        </div>

        <div class="screenHolder" style="width:{$theme.width}px; height:{$theme.height}px">
            {$html}
        </div>


    </div>
    <div class="clr"></div>
</div>

