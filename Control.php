<?php

//
// Classe de controle e tarefas
// View.php
//

class Control
{
	// Função que carrega o arquivo de scripts
	public function CarregarScripts()
	{
		echo
		"
			<SCRIPT TYPE='text/javascript' SRC='scripts.js'></SCRIPT>
		";
	}
	
	// Função que inicia a sessão do navegador, aonde serão guardadas algumas informações importantes
	public function IniciarSessao()
	{
		session_start();
	}
	
	// Função que zera toda a sessão, incluindo pontos e jogadores que começam
	public function ZerarSessao()
	{
		$_SESSION['MeuJogador'] = 0;
		
		$_SESSION['PontosPreto'] = 0;
		$_SESSION['PontosBranco'] = 0;
		
		$_SESSION['JogadorQueInicia'] = 0;
	}
	
	// Função que zera para a partida atual, incluindo total de jogadas e a grade de jogadas
	public function ZerarJogo()
	{
		$_SESSION['TotalJogadas'] = 0;
		$_SESSION['JogadorAtual'] = 0;
	
		for ($x = 0; $x < 19; $x++)
		{
			for ($y = 0; $y < 19; $y++)
			{ 
				$_SESSION['Grade'][$x][$y] = 0;
			}
		}
	}
	
	// Define o tempo máximo de execução em 5 minutos (300 segundos)
	public function TempoExecucao()
	{
		ini_set('max_execution_time', 300);
	}
	
	// Função que define qual é o jogador da janela aberta atualmente
	public function setMeuJogador($Codigo)
	{
		$_SESSION['MeuJogador'] = $Codigo;
	}
	
	// Função que obtém qual é o jogador da janela aberta atualmente
	public function getMeuJogador()
	{
		return $_SESSION['MeuJogador'];
	}
	
	// Função que define o jogador da jogada atual
	public function setJogadorAtual($Codigo)
	{
		$_SESSION['JogadorAtual'] = $Codigo;
	}
	
	// Função que obtém o jogador da jogada atual
	public function getJogadorAtual()
	{
		return $_SESSION['JogadorAtual'];
	}
	
	// Função que define o jogador que inicia a partida atual
	public function setJogadorQueInicia($Codigo)
	{
		$_SESSION['JogadorQueInicia'] = $Codigo;
	}
	
	// Função que obtém o jogador que inicia a partida atual
	public function getJogadorQueInicia()
	{
		return $_SESSION['JogadorQueInicia'];
	}
	
	// Função que adiciona uma jogada da partida atual
	public function addJogada($x, $y, $jogador)
	{
		$_SESSION['Grade'][$x][$y] = $jogador;
		$_SESSION['TotalJogadas']++;
	}
	
	// Função que obtém o número atual de jogadas da partida atual
	public function getTotalJogadas()
	{
		return $_SESSION['TotalJogadas'];
	}
	
	// Função que adiciona um ponto ao jogador preto
	public function addVitoriaPreto()
	{
		$_SESSION['PontosPreto']++;
	}

	// Função que adiciona um ponto ao jogador branco
	public function addVitoriaBranco()
	{
		$_SESSION['PontosBranco']++;
	}
	
	// Função que obtém a pontuação do jogador preto
	public function getPontosPreto()
	{
		return $_SESSION['PontosPreto'];
	}
	
	// Função que obtém a pontuação do jogador branco
	public function getPontosBranco()
	{
		return $_SESSION['PontosBranco'];
	}
	
}

?>