$.ajaxSetup({
    cache: true
});


/* CAMBIO DE PÁGINA */
$(".link").click(function(e) {
    e.preventDefault();
    cambiarPagina($(this).attr('href'));
});
$(window).on("popstate", cargarDir);

function cambiarPagina(dir) {
    ocultarCortina();
    history.pushState("", "", "/" + dir.replace(/^\//, ''));
    cargarDir();
}
function cargarDir() {
    $(window).trigger("cambioURL");
    cargarScriptsMain = null;
    var dir = location.pathname.substring(1).split("/");
    dir = "/contenido_dinamico/" + dir[0] + ".php?data=" + dir[1];
    $("main").fadeTo(200, 0, function(){
        $(this).html('<div id="cargando"><div class="bar1"></div><div class="bar2"></div><div class="bar3"></div><div class="bar4"></div><div class="bar5"></div><div class="bar6"></div></div>');
        $(this).css('opacity', 1);
        $.get(dir, function(data) {
            $('main').fadeTo(200, 0,function(){
                cargarMain(data);
                tamMain();
                $('main').fadeTo(600, 1);
            });
        });
    });
    cambioPestana();
}
function cambioPestana() {
    $('html, body').animate({scrollTop:0},200);
    var dir = location.pathname.substring(1).split("/"), $e;
    if(dir[0] == '')
        $e = $('nav .link:first');
    else
        $e = $('nav .link[href="/' + dir[0] + '"]');
    $('header h1').text($e.text() != '' ? $e.text() : 'AssafPB');
    $("nav .link.seleccionado").removeClass("seleccionado");
    $e.addClass("seleccionado");
}
function cargarMain(data) {
    $('main').html(data);
    if(typeof cargarScriptsMain != 'undefined' && $.isFunction(cargarScriptsMain))
        cargarScriptsMain();
    cargarFuncionesComunes();
    $("body").scrollTop(0);
}
