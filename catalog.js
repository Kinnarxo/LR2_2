var basket_visibility = false;

$(document).ready( function() {
    $("#basket_button").click(open_basket);
    $(".add_prod").click(add_goods);
});

function open_basket()
{
    if (!basket_visibility) {
        $("#basket_body").css("visibility", "visible");
        move_catalog('left');
    }
    else {
        $("#basket_body").css("visibility", "hidden");
        move_catalog('right');
    }
    basket_visibility = !basket_visibility;
}

function move_catalog(direction)
{
    if (direction == 'left')
    {
        $("#main").stop().animate({left:"15%"}, 500);
        $("#main_bg").stop().animate({left:"15%"}, 500);
    }
    else if (direction == 'right')
    {
        $("#main").stop().animate({left:"25%"}, 500);
        $("#main_bg").stop().animate({left:"25%"}, 500);
    }
}

function add_goods(event)
{
    let tgt = event.currentTarget;
    let id = tgt.getAttribute('id');
    id = id.slice(6);
    $.post("index.php", "&id="+id+"&command=add_goods");
    alert(id);
}