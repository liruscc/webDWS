<?php

function mensaje($cadena) {
    echo "<div id='errores' class='alert alert-success p-1 w-100'>";
    echo $cadena;
    echo "</div>";
}

function error($cadena) {
    echo "<div id='errores' class='alert alert-danger p-1 w-100'>";
    echo $cadena;
    echo "</div>";
}

function botonEditar($url,$string='') {
    echo "<a class='btn btn-warning mr-1 pt-0' href='".$url."'><img with='15px' src='img/edit.png'>".$string."</a>";
}

function botonDesactivar($url,$string='') {
    echo "<a class='btn btn-danger mr-1 pt-0' href='".$url."'><img with='15px' src='img/delete.png'>".$string."</a>";
}

function botonInfo($url,$string='') {
    echo "<a class='btn btn-info mr-1 pt-0' href='".$url."'><img with='15px' src='img/info.png'>".$string."</a>";
}

function botonActivar($url,$string='') {
    echo "<a class='btn btn-success mr-1 pt-0' href='".$url."'><img with='15px' src='img/anadir.png'>".$string."</a>";
}

function botonAñadir($url,$string='') {
    echo "<a class='btn btn-warning mr-1 pt-0' href='".$url."'><img with='15px' src='img/edit.png'>".$string."</a>";
}

?>