<style type="text/css">
    {foreach $kontrolki as $kontrolka}
    .component_{$kontrolka.name|urlencode} {
    {$kontrolka.css}
    }

    {/foreach}
</style>
<script type="text/javascript">
    {foreach $kontrolki as $kontrolka}
    $(".component_{$kontrolka.name|urlencode}").each(function () {
        {$kontrolka.js}
    });
    {/foreach}
</script>

<div class="ui-corner-all show center">
   <span class="pull-right glyphicon glyphicon-home href space"
         onClick="window.location='/'"
         title="Powrót do listy pokazów"
   >
   </span>
   <span class="pull-right glyphicon glyphicon-comment href space comments-button"
         title="Pokaż komentarze"
         onclick="$(this).closest('.show').toggleClass('comments')"
   ></span>
    <div class="showTitle">{$pokaz.name} - {$nazwaEkranu}</div>

    <div style="position: relative; display: inline-block;">
        <div class="screenHolder" style="width:{$theme.width}px; height:{$theme.height}px">
            {$html}
        </div>
    </div>
    <div class="clr"></div>
</div>

<script>

    $(window).ready(function () {
        $('.screenHolder > .component')
                .mouseover(function () {
                    $(this).addClass('over');
                })
                .mouseout(function () {
                    $(this).removeClass('over');
                })
        ;
        $('.comments-input > textarea')
                .focus(function () {
                    $(this).closest('.comments-wrapper').addClass('have-focus')
                })
                .blur(function () {
                    $(this).closest('.comments-wrapper').removeClass('have-focus')
                })
                .keydown(function (e) {
                    if (e.which == 13) {
                        var comment = $(this).val().trim();
                        var id = $(this).closest('.component').data('id');
                        $(this).html('').val('');
                        $.ajax({
                            method: 'POST',
                            url: '/ajax/saveComment/' + id,
                            data: {
                                'txt': comment
                            },
                            success: function (data) {
                                $('[data-id='+id+']')
                                        .find('.comments-wrapper')
                                        .addClass('have-comments')
                                ;
                                $('[data-id='+id+']')
                                        .find('.comments')
                                        .html(data)
                                        .scrollTop(99999)
                                ;
                            }
                        });
                        return false;
                    }
                });

    });

    function elementClicked(ob) {
        if ($('.show.comments').length == 0) {
            backdropLoader();
            return true;
        } else {
            var $ob = $(ob);

        }
        return false;
    }
</script>