<?php
	$categorias = categoria::getCategorias();	
?>

<div class = "col-lg-2 col-md-2 col-sm-2">
<aside>
	<nav class="navbar fixed-left text-align-left pl-0">
		<ul class="menu">
			<li class="nav-item"><a class="nav-link" href="index.php">Ver todo</a></li>
			<?php
				foreach ($categorias as $categoria => $value){
					echo '<li class="nav-item"><a class="nav-link" href="index.php?cat='.$value->getCodigo().'	">'.$value.'</a>';
					$subcategorias = subcategoria::getSubcategorias($value);
					if($subcategorias){
						echo '<ul class="submenu">';
						foreach ($subcategorias as $subcategoria => $value){
                                                    if($value->getActivo()=='1'){
                                                        echo '<li class="nav-item"><a class="nav-link" href="index.php?subcat='.$value->getCodigo().'	">'.$value.'</a></li>';
                                                    }
						}
						echo '</ul>';
					}
					echo '</li>';
				}
			?>
		</ul>
	</nav>
</aside>
</div>