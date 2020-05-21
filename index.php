<?php

//
// The Web Serial Gomoku
// index.php
//

//
// Carrega a classe visual
//
include_once("View.php");

$View = new View();
$View->IniciarView();

	echo
	"
		<HTML>
			<HEAD>
			
			
	";
				// Carrega os headers HTML
				$View->CarregarHeaders();
				// Carrega o título da página
				$View->CarregarTitulo();
				// Carrega os scripts JavaScript
				$View->CarregarScripts();
	
	// O objetivo do "return false" nos oncontextmenu e onkeydown são para bloquear o clique direito e a digitação, respectivamente
	echo
	"	
			</HEAD>
	
			<BODY oncontextmenu='return false;' onkeydown='return false;'> 
	
				<DIV CLASS='Corpo' ALIGN='CENTER'>
			
	";
					// Se não houver código passado via URL, ele vai passar código 000000. Do contrário, passa o código que está na URL
					if (isset($_GET["c"]))
					{
						$View->TratarCodigo($_GET["c"]);
					}
					else
					{
						$View->TratarCodigo(000000);
					}
	
	echo
	"
				</DIV>
			</BODY>	
		</HTML>
	";
	
?>