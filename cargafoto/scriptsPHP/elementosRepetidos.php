<?php
/*
 * creado por Khriz Enríquez (tw) @khrizenriquez (fb) /khrizenriquez
 */
class ElementosRepetidos
{
    private $anioActual = "";
    
    function __construct()
    {
        $this->anioActual = date('Y');//me sirve para colocar el año actual
    }
    
    function piePagina($colorTexto, $creditos)
    {
        print "<footer class='navbar navbar-fixed-bottom'>
                    <label id = 'lblPie' style='color: $colorTexto; text-align:center' title='¿Te fue de ayuda?, contáctame en Twitter si tienes dudas o sugerencias'>
                        <a href='https://twitter.com/khrizEnriquez'>
                        <img src='img/rSociales/twitter_32.png' alt='Twitter' /></a>
                        $creditos $this->anioActual
                    </label>
            </footer>";
    }
}
?>