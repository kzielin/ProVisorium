function screenHolderClick(e, ob) {
    var of = $(ob).offset();
    var x = mouseX(e) - of.left;
    var y = mouseY(e) - of.top;

    if ($('.iconHolderSelected:first').length) {
        if (isNaN(window.nrE)) window.nrE = 0;
        window.nrE = window.nrE + 1;
        var nrE = window.nrE;
        var compo = $('.iconHolderSelected:first').removeClass('iconHolderSelected');
        var newOb = $('<div><span class="pv-movable-handle ui-icon ui-icon-arrow-4"></span>' +
            '<div class="elementContent">' + atob(compo.data('html')) + '</div></div>');
        $(ob).append(newOb);
        $('.elementHolder').removeClass('hot');
        newOb
            .addClass('elementHolder hot component_' + compo.attr('title'))
            .css({
                left: Math.floor(x / gridRaster) * gridRaster,
                top: Math.floor(y / gridRaster) * gridRaster
            })
            .attr('id', 'el' + nrE)
            .attr('data-nr', nrE)
            .attr('data-type', compo.data('id'))
            .resizable({
                grid: [gridRaster, gridRaster],
                stop: function(){ $(this).addClass('hot'); updateDimensionProps(this); },
                resize: function(){ $(this).addClass('hot'); updateDimensionProps(this); }
            })
            .draggable({
                handle: '.pv-movable-handle',
                grid: [gridRaster, gridRaster],
                stop: function(){ $(this).addClass('hot'); updatePositionProps(this); },
                drag: function(){ $(this).addClass('hot'); updatePositionProps(this); }
            })
            .hover(
                function () {
                    $(this).find('.pv-movable-handle').show()
                },
                function () {
                    $(this).find('.pv-movable-handle').hide()
                }
            )
            .click(
                function (e) {
                    hideProps();
                    $(this).addClass('hot');
                    componentClick();
                    e.stopPropagation();
                }
            );
        updateDimensionProps(newOb);
        updatePositionProps(newOb);
        newOb.click();
        window.setTimeout(function(){ $('#el' + nrE).addClass('hot'); componentClick(); }, 100);
    } else {
        hideProps();
    }
}

function hideProps() {
    $('.props-wrapper').hide();
    $('.elementHolder').removeClass('hot');
}

function showProps(){
    $('.props-wrapper').show();
    $('.props-wrapper .props-title').addClass('active');
    $('.props-wrapper .props-area').html('');
}

function mkPropRow(label, field) {
    return '<tr class="border">' +
        '<td class="p50 text-right">' + label + '</td>' +
        '<td class="p50">'+ field +'</td>' +
        '</tr>';
}

function mkProp(type, name, label, val, def){
    label = label || name;
    val = val || def;
    switch (type) {
        case 't':
            return mkPropRow(label, '<input type="text" name="'+ name +'" value="'+val+'" onKeyUp="updatePropField(this)">');
            break;
        case 'l':
            return mkPropRow(label, '<input type="number" min="0" name="'+ name +'" value="'+val+'" onchange="updatePropField(this)" onkeyup="updatePropField(this)">');
            break;
        case 's':
            var $lista = JSON.parse(atob($('#listaEkranow').val()));
            var ekrany = '<option value="0">...</option>';
            if ($lista) {
                $.each($lista, function(k,item){
                    ekrany = ekrany + '<option value="'+item.id+'" '+(val == item.id ? 'selected':'')+'>'+item.name+'</option>';
                });
            }
            return mkPropRow(label, '<select name="'+ name +'" onchange="updatePropField(this)" onclick="updatePropField(this)">'+ekrany+'</select>');
            break;
        case 'p':
            return mkPropRow(label, '<input type="number" min="0" max="100" name="'+ name +'" value="'+val+'" onchange="updatePropField(this)" onkeyup="updatePropField(this)">');
            break;
        case 'c':
            return mkPropRow(label, '<input type="color" name="'+ name +'" value="'+val+'" onchange="updatePropField(this)">');
            break;
        case 'e':
            var $lista = def.split(';'), opcje = '<option value="">...</option>';
            if ($lista) {
                $.each($lista, function(k,item){
                    opcje = opcje + '<option value="'+item+'" '+(val == item? 'selected':'')+'>'+item+'</option>';
                });
            }
            return mkPropRow(label, '<select name="'+ name +'" onchange="updatePropField(this)" onclick="updatePropField(this)">'+opcje+'</select>');
            break;
    }
}

function getHot() {
    return $('.elementHolder.hot:first');
}

function removeHot() {
    var $ob = getHot();
    $ob.remove();
    hideProps();
}
function renderProps(data){
    var $ob = getHot();
    if ($ob.length && $ob.data('type') == data.komponent.id) {
        var props = getProps($ob);

        showProps();
        $('.props-wrapper .props-title.active').removeClass('active');

        var $area = $('.props-wrapper .props-area');
        var $tab = $area
            .append("<table></table>")
            .find('table');

        $.each(data.komponent.props, function(key,item) {
            $tab.append(mkProp(item.type,key,key,props[key],item.default));
        });

        $tab
            .append(mkProp('s','link','Link',props.link))
            .append(mkProp('l','w','Szerokość',props.w))
            .append(mkProp('l','h','Wysokość',props.h))
            .append(mkProp('l','x','Pozycja X',props.x))
            .append(mkProp('l','y','Pozycja Y',props.y))
            //.append(mkProp('l','z','Kolejność',props.z))
        ;
        $area.append('<button><span class="ui-icon ui-icon-trash" onclick="if (confirm(\'Czy chcesz usunąć element?\')) removeHot()"></span></button>')
    }
}

var props = []; // cache

function componentClick() {
    var $ob = getHot();
    if ($ob.length) {
        var componentTypeId = $ob.data('type');
        if (props[componentTypeId] != undefined) {
            renderProps(props[componentTypeId]);
            rerenderHotComponent();
        } else {
            showProps();
            $.ajax({
                url: '/ajax/props/' + componentTypeId,
                success: function (data) {
                    props[componentTypeId] = data;
                    renderProps(data);
                }
            });
        }
    } else {
        hideProps();
    }
}

function getProps(ob) {
    var $ob = $(ob);
    var props = {};
    try {
        props = JSON.parse(atob($ob.data('props')));
    } catch (e) {}
    return props;
}

function setProps(ob, props) {
    var newVal = btoa(JSON.stringify(props));
    $(ob).data('props', newVal);
}

function updatePositionProps(ob) {
    var props = getProps(ob);
    props.x = $(ob).position().left;
    props.y = $(ob).position().top;
    setProps(ob, props);
    componentClick();
}

function updateDimensionProps(ob) {
    var props = getProps(ob);
    props.w = $(ob).width();
    props.h = $(ob).height();
    setProps(ob, props);
    componentClick();
}

function setProp(name,value) {
    var $ob = getHot();
    var props = getProps($ob);
    props[name] = value;
    setProps($ob, props);
}

function updatePropField(field) {
    setProp($(field).attr('name'), $(field).val());
    var newHTML = rerenderHotComponent();
}

function rerenderHotComponent() {
    var $ob = getHot();
    var obId = $ob.data('type');
    var compo = $('.iconHolder[data-id='+ obId +']:first');
    var newHTML = atob(compo.data('html'));
    $('.props-area:visible').find('input,select').each(function() {
        var key = $(this).attr('name');
        var val = $(this).val();
        newHTML = newHTML.replace(new RegExp('#' + key , "g"), val);
    });
    $ob.find('.elementContent').html(newHTML);
}
