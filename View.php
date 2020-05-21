<?php

//
// Classe visual
// View.php
//

//
// Carrega a classe de controle e tarefas
//
include_once("Control.php");

class View
{
	public $Control;
	
	// Função que inicia a Control e a sessão do navegador
	public function IniciarView()
	{
		$this->Control = new Control();
		$this->Control->IniciarSessao();
		$this->Control->TempoExecucao();
	}

	// Função que exibe os cabeçalhos de HTML
	public function CarregarHeaders()
	{
		// Carrega a folha de estilos CSS, o ícone da página e define a codificação
		echo
		"
			<LINK REL='stylesheet' TYPE='text/css' HREF='style.css'/>
			<LINK REL='shortcut icon' HREF='images/favicon.ico' TYPE='image/x-icon'/>
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
		";
	}
	
	// Função que carrega o arquivo de scripts em JavaScript
	public function CarregarScripts()
	{
		$this->Control->CarregarScripts();
	}

	// Função que exibe o título da página
	public function CarregarTitulo()
	{
		$Titulo = "The Web Serial Gomoku";
	
		echo
		"
			<TITLE>$Titulo</TITLE>
		";
	}

	// Função que carrega a tabela e a grade de jogadas
	public function CarregarTabela()
	{
		// Div que aparece ou desaparece bloqueando a tabela, conforme a necessidade 
		echo
		"
			<DIV CLASS='TabelaBloqueada' ID='TabelaBloqueada'>
			&nbsp;
			</DIV>
		";
		
		echo
		"
			
			<DIV CLASS='Tabela'>

				<TABLE CLASS='Grade' ID='Grade'>
		";

				// Laço que cria a grade de 19 x 19 pontos para o jogo
				for($x=0;$x<19;$x++)
				{
					echo "<TR>";
				
					for($y=0;$y<19;$y++)
					{
						// Como a função JavaScript para fazer o teste da jogada precisa saber qual é o jogador, a gente pega o jogador aqui
						$Jogador = $this->Control->getJogadorAtual();
					
						// O id do ponto corresponde à combinação da linha e da coluna
						$ID = $x.",".$y;
						
						echo
						"
							<TD>
								<INPUT TYPE='button' CLASS='GradeJogada' ID='$ID' onClick='TestarJogada(this.id, $Jogador);'></INPUT>
							</TD>
						";
					} 
					
					echo "</TR>";
					
				}
		
		echo
		"
				</TABLE>
			</DIV>
		";
		
		// Após desenhar a tabela, chamamos a função que pinta os pontos conforme as jogadas
		$this->PintarGrade();
		
	}
	
	// Função que pinta a grade de jogadas com as cores neutra, preta e branca
	public function PintarGrade()
	{
		for ($x = 0; $x < 19; $x++)
		{
			$Linha = "";
			// Define a cor conforme a jogada
			for ($y = 0; $y < 19; $y++)
			{ 
				if($_SESSION['Grade'][$x][$y] == 1)
					$Cor = 'black';
				else if($_SESSION['Grade'][$x][$y] == 2)
					$Cor = 'white';
				else
					$Cor = '#CDC9C9';
					
				$Celula = $x.",".$y;
					
				echo
				"
					<SCRIPT>PintarCelula('$Celula', '$Cor');</SCRIPT>
				";
				
				// Obtém todas as jogadas a partir do array				
				if($y < 18)
					$Linha .= $_SESSION['Grade'][$x][$y].",";
				else
					$Linha .= $_SESSION['Grade'][$x][$y];
			}
			 
			echo
			"
				<SCRIPT>CelulasGrade($x, '$Linha');</SCRIPT>
			";
			
		}

	}
	
	// Função que exibe na tela a tabela com a grade de jogadas
	public function ExibirTabela()
	{
		echo
		"
			<SCRIPT>ExibirTabela();</SCRIPT>
		";
	}
	
	// Função que oculta da tela a tabela com a grade de jogadas
	public function OcultarTabela()
	{
		
		echo
		"
			<SCRIPT>OcultarTabela();</SCRIPT>
		";
	}
	
	// Função que retira um bloqueio visual de cima da tabela, habilitando as jogadas
	public function HabilitarTabela()
	{
		echo
		"
			<SCRIPT>HabilitarTabela();</SCRIPT>
		";
	}
	
	// Função que coloca um bloqueio visual de cima da tabela, bloqueando as jogadas
	public function DesabilitarTabela()
	{
		
		echo
		"
			<SCRIPT>DesabilitarTabela();</SCRIPT>
		";
	}
	
	// Função que carrega o painel de controle
	public function CarregarPainel()
	{
		$Jogador = $this->Control->getMeuJogador(); 
		$PontosPreto = $this->Control->getPontosPreto();
		$PontosBranco = $this->Control->getPontosBranco();
		
		echo
		"
			<DIV CLASS='Painel'>
		
				<DIV CLASS='PainelAcoes'>
					<INPUT TYPE='button' CLASS='PainelAcoesBotoes' ID='PainelAcoesConectar' VALUE='Conectar via serial' onClick=Conectar()>
					<P>
					<INPUT TYPE='button' CLASS='PainelAcoesBotoes' ID='PainelAcoesIniciar' VALUE='Iniciar novo jogo' onClick=NovoJogo($Jogador)>
					<P>
					<INPUT TYPE='button' CLASS='PainelAcoesBotoes' ID='PainelAcoesDesistir' VALUE='Desistir' onClick=Desistir();>
				</DIV>
			
				<DIV CLASS='PainelInformacoes'>
					<INPUT TYPE='button' CLASS='PainelInformacoesBotoes' ID='PainelSobreAjuda' onClick=Ajuda();>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<INPUT TYPE='button' CLASS='PainelInformacoesBotoes' ID='PainelSobreCreditos' onClick=Creditos();>
				</DIV>
				
				<DIV CLASS='PainelPlacar'>
					<DIV CLASS='PainelPlacarJogador'>
						<INPUT TYPE='text' CLASS='PainelPlacarLabel' ID='PainelPlacarLabelPreto' VALUE='Preto' DISABLED></INPUT>
						<P>
						<INPUT TYPE='text' CLASS='PainelPlacarNumero' ID='PainelPlacarNumeroPreto' VALUE='$PontosPreto' DISABLED></INPUT>
					</DIV>
					<DIV CLASS='PainelPlacarJogador'>
						<INPUT TYPE='text' CLASS='PainelPlacarLabel' ID='PainelPlacarLabelBranco' VALUE='Branco' DISABLED></INPUT>
						<P>
						<INPUT TYPE='text' CLASS='PainelPlacarNumero' ID='PainelPlacarNumeroBranco' VALUE='$PontosBranco' DISABLED></INPUT>
					</DIV>
				</DIV>
				
			</DIV>
		";
	}
	
	// Função que desabilita um botão
	public function DesabilitarBotao($id)
	{
		echo
		"
			<SCRIPT>DesabilitarBotao('$id');</SCRIPT>
		";
	}
	
	// Função que habilita um botão
	public function HabilitarBotao($id)
	{
		echo
		"
			<SCRIPT>HabilitarBotao('$id');</SCRIPT>
		";
	}
	
	// Função que destaca, com uma borda vermelha, qual o jogador atual
	public function SelecionarJogador()
	{
		// Se temos um número par de jogadas (jogada 0, jogada 2, jogada 4, etc), significa que o jogador atual é o mesmo que iniciou a partida
		if(($this->Control->getTotalJogadas())%2 == 0)
		{
			$Jogador = $this->Control->getJogadorQueInicia();
		}
		// Se temos um número ímpar de jogadas (jogada 1, jogada 3, jogada 5, etc), ele pegará o jogador atual
		else
		{
			if ($this->Control->getJogadorAtual() == 1)
				$Jogador = 1;
			else
				$Jogador = 2;
		}

		// Chama o JavaScript pra fazer a arte
		echo
		"
			<SCRIPT>SelecionarJogador($Jogador);</SCRIPT>
		";
		
	}
	
	// Função que faz a conexão via serial com o outro computador
	public function Conectar($Serial)
	{
		$Codigo = 110000;
	
		// Tenta abrir a porta. Se não conseguir é porque a porta não existe
		$Porta = @fopen($Serial, 'x+') or die("<SCRIPT>PortaErrada($Codigo);</SCRIPT>");
		
		// Tenta enviar dados para a porta.
		$Envio = fputs($Porta, "1");
		
		// Se não conseguir é porque a porta existe, mas está desconectada
		if($Envio == 0)
		{
			echo "<SCRIPT>PortaDesconectada($Codigo);</SCRIPT>";
		}
		else
		{
			// Aguarda 10 segundos pra dar tempo ao outro de se conectar à porta serial
			sleep(10);
		
			// Envia um byte...
			$Envio = fputs($Porta, 1);
		
			// ...e aguarda um byte de retorno
			$Retorno = fread($Porta, '1');
			
			fclose($Porta);	

			// Se ele conseguiu enviar e receber, define o jogador da sessão do navegador, e guarda o nome da porta.
			if($Retorno == '2' && $Envio == 1)
			{
				$this->Control->setMeuJogador(1);
				$this->Alertar('Conexão realizada com sucesso!');
				$_SESSION['Porta'] = $Serial;	
			}
		}
	}
	
	// Função que recebe a conexão via serial com o outro computador
	public function AguardarConexao($Serial)
	{
		$Codigo = 120000;
		
		// Tenta abrir a porta. Se não conseguir é porque a porta não existe
		$Porta = @fopen($Serial, 'x+') or die("<SCRIPT>PortaErrada($Codigo);</SCRIPT>");
		
		// Tenta enviar dados para a porta.
		$Envio = fputs($Porta, "2");
		
		// Se não conseguir é porque a porta existe, mas está desconectada
		if($Envio == 0)
		{
			echo "<SCRIPT>PortaDesconectada($Codigo);</SCRIPT>";
		}
		else
		{
			// Aguarda um byte...			
			$Retorno = fread($Porta, 1);
			
			// ...aguarda 10 segundos pra dar tempo ao outro de se conectar à porta serial...
			sleep(10);
			
			// ... envia um byte de retorno
			$Envio = fputs($Porta, '2');
			
			fclose($Porta);

			// Se ele conseguiu enviar e receber, define o jogador da sessão do navegador, e guarda o nome da porta.
			if($Retorno == '1' && $Envio == 1)
			{
				$this->Control->setMeuJogador(2);
				$this->Alertar('Conexão realizada com sucesso!');
				$_SESSION['Porta'] = $Serial;
			}
		}
	}

	// Função que prepara o início de um novo jogo
	public function NovoJogo()
	{
		// Se o jogador que inicia está 0 siginifica que é o primeiro jogo e, consequentemente, quem inicia é o preto.
		if ($this->Control->getJogadorQueInicia() == 0)
		{
			$this->Control->setJogadorQueInicia(1);
			$this->Control->setJogadorAtual(1);
		}
		// Do contrário, se o jogador que iniciou o último jogo foi um, agora quem inicia é o outro.
		else
		{
			if ($this->Control->getJogadorQueInicia() == 1)
			{
				$this->Control->setJogadorQueInicia(2);
				$this->Control->setJogadorAtual(2);
			}
			else
			{
				$this->Control->setJogadorQueInicia(1);
				$this->Control->setJogadorAtual(1);
			}
		}
	}
	
	// Função que aguarda a jogada do adversário via serial
	public function AguardarJogada()
	{
		// Abre a porta...
		$Porta = fopen($_SESSION['Porta'], 'x+');
		// ...aguarda a informação da jogada do adversário...
		$Jogada = fread($Porta,6);
		// ...e fecha a porta
		fclose($Porta);
		
		// Recarrega a página pra processar a jogada recebida
		echo "<SCRIPT>location.href='index.php?c=$Jogada';</SCRIPT>";
	}
	
	// Função que envia a jogada pro adversário via serial
	public function EnviarJogada()
	{
		// Abre a porta...
		$Porta = fopen($_SESSION['Porta'], 'x+');
		// ...envia a informação da jogada pro adversário...
		fputs($Porta,$_GET['c']);
		// ...e fecha a porta
		fclose($Porta);
	}
	
	// Função que marca o ponto na matriz que guarda as marcações
	public function MarcarPonto($Codigo)
	{
		// Obtém do código obtido via URL, a linha e a coluna do ponto marcado
		$x = intval(substr($Codigo,2,2));
		$y = intval(substr($Codigo,4,2));
		
		// Se o jogador atual for um, ele marca o ponto para este e define o outro jogador como o atual
		if ($this->Control->getJogadorAtual() == 1)
		{
			$this->Control->addJogada($x,$y,1);
			$this->Control->setJogadorAtual(2);
		}
		else
		{
			$this->Control->addJogada($x,$y,2);
			$this->Control->setJogadorAtual(1);
		}
	}
	
	// Função que define a vitória de um jogador
	public function Vitoria()
	{
		// Se o jogador atual era um, significa que foi ele quem venceu. Logo, ele ganha o ponto
		if($this->Control->getJogadorAtual() == 1)
		{
			$this->Control->addVitoriaPreto();
		}
		else
		{
			$this->Control->addVitoriaBranco();
		}
	}

	// Função que define a desistênca de um jogador
	public function Desistencia()
	{
		// Se o jogador atual era um, significa que foi ele quem desistiu. Logo, o outro ganha o ponto
		if($this->Control->getJogadorAtual() == 1)
		{
			$this->Control->addVitoriaBranco();
		}
		else
		{
			$this->Control->addVitoriaPreto();
		}
	}

	// Função que trata os códigos oriundos da URL
	public function TratarCodigo($Codigo)
	{
		switch($Codigo)
		{
			// Código inicial, primeiro acesso
			case '000000':
				// Zera os dados
				$this->Control->ZerarSessao();
				$this->Control->ZerarJogo();
				
				// Prepara, oculta e habilita a tabela
				$this->CarregarTabela();
				$this->OcultarTabela();	
				$this->HabilitarTabela();			

				// Carrega o painel e habilita apenas o botão pra se conectar
				$this->CarregarPainel();
				$this->HabilitarBotao("PainelAcoesConectar");
				$this->DesabilitarBotao("PainelAcoesIniciar");
				$this->DesabilitarBotao("PainelAcoesDesistir");

				break;
			// Conexão serial - Computador fará a conexão
			case '110000':
				// Solicita para se conectar à porta obtida via URL
				$this->Conectar($_GET["p"]);
			
				// Prepara, oculta e habilita a tabela
				$this->CarregarTabela();
				$this->OcultarTabela();	
				$this->HabilitarTabela();				
				
				// Carrega o painel e habilita apenas o botão pra iniciar o jogo
				$this->CarregarPainel();
				$this->DesabilitarBotao("PainelAcoesConectar");
				$this->HabilitarBotao("PainelAcoesIniciar");
				$this->DesabilitarBotao("PainelAcoesDesistir");

				break;
			// Conexão serial - Computador receberá a conexão
			case '120000':
				// Solicita para aguardar conexão na porta obtida via URL
				$this->AguardarConexao($_GET["p"]);
			
				// Prepara, oculta e habilita a tabela
				$this->CarregarTabela();
				$this->OcultarTabela();
				$this->HabilitarTabela();				
				
				// Carrega o painel e habilita apenas o botão pra iniciar o jogo
				$this->CarregarPainel();
				$this->DesabilitarBotao("PainelAcoesConectar");
				$this->HabilitarBotao("PainelAcoesIniciar");
				$this->DesabilitarBotao("PainelAcoesDesistir");
				
				break;
			// Prepara o novo jogo
			case '200000':
				// Inicia o jogo definindo o jogador que inicia
				$this->NovoJogo();
				
				// Carrega, desabilita e exibe a tabela
				$this->CarregarTabela();
				$this->DesabilitarTabela();
				$this->ExibirTabela();				
				//$this->CarregarPainel();
				
				// Se o jogador do computador não for o que inicia, ele aguardará a jogada, bloqueando o acesso à tabela
				if($this->Control->getMeuJogador() != $this->Control->getJogadorAtual())
				{
					$this->AguardarJogada();					
				}
				// Do contrário, ele apenas habilita o acesso à tabela
				else
				{
					$this->HabilitarTabela();
				}
				
				// Carrega o painel e habilita apenas o botão para desistir
				$this->CarregarPainel();
				$this->DesabilitarBotao("PainelAcoesConectar");
				$this->DesabilitarBotao("PainelAcoesIniciar");
				$this->HabilitarBotao("PainelAcoesDesistir");
				
				// Seleciona o jogador atual no placar
				$this->SelecionarJogador();

				break;
			// Vitória
			case '700000':
				// Define o vitorioso
				$this->Vitoria();
				
				// Carrega, desabilita e exibe a tabela
				$this->CarregarTabela();
				$this->DesabilitarTabela();
				$this->ExibirTabela();

				// Se o jogador do computador não for o que venceu, ele mostrará que o adversário ganhou
				if($this->Control->getMeuJogador() != $this->Control->getJogadorAtual())
				{
					$this->Alertar('Vitória do seu adversário!');
					
					// Aguarda 3 segundos para que ambos vejam como ficou o tabuleiro
					sleep(3);
				}
				// Do contrário, se ele for o que venceu, mandará para o adversário a notícia
				else
				{
					$this->EnviarJogada();
				}

				// Zera o jogo
				$this->Control->ZerarJogo();
				
				// Oculta e reabilita a tabela
				$this->OcultarTabela();
				$this->HabilitarTabela();

				// Carrega o painel e habilita apenas o botão de novo jogo
				$this->CarregarPainel();
				$this->DesabilitarBotao("PainelAcoesConectar");
				$this->HabilitarBotao("PainelAcoesIniciar");
				$this->DesabilitarBotao("PainelAcoesDesistir");
				
				break;
			// Desistência
			case '900000':
				$this->Desistencia();

				// Carrega, desabilita e exibe a tabela
				$this->CarregarTabela();
				$this->DesabilitarTabela();
				$this->ExibirTabela();
				
				// Se o jogador do computador não for o que desistiu, ele mostrará que o adversário desistiu e que ele ganhou
				if($this->Control->getMeuJogador() != $this->Control->getJogadorAtual())
				{
					$this->Alertar('Seu adversário desistiu. Você venceu!');
					
					// Aguarda 3 segundos para que ambos vejam como ficou o tabuleiro
					sleep(3);
				}
				// Do contrário, se ele for o que venceu, mandará para o adversário a notícia
				else
				{
					$this->EnviarJogada();
				}
				
				// Oculta e reabilita a tabela
				$this->OcultarTabela();
				$this->HabilitarTabela();			
				
				// Zera o jogo
				$this->Control->ZerarJogo();
				
				// Carrega o painel e habilita apenas o botão de novo jogo
				$this->CarregarPainel();
				$this->DesabilitarBotao("PainelAcoesConectar");
				$this->HabilitarBotao("PainelAcoesIniciar");
				$this->DesabilitarBotao("PainelAcoesDesistir");
				
				break;
			// Padrão, que é o ponto marcado sem vitória ou desistência
			default:
				$this->MarcarPonto($Codigo);
				
				
				// Carrega e exibe a tabela
				//$this->CarregarPainel();
				$this->CarregarTabela();
				$this->CarregarPainel();
				//$this->Alertar('1');
				
				$this->ExibirTabela();
				// Carrega o painel e habilita apenas o botão para desistir				
				$this->DesabilitarTabela();

				// Se o jogador do computador não for o jogador atual, ele enviará a sua última jogada pro adversário e aguardará a jogada do mesmo.
				if($this->Control->getMeuJogador() != $this->Control->getJogadorAtual())
				{
					$this->EnviarJogada();					
					$this->AguardarJogada();
				}
				// Do contrário, ele apenas habilita o acesso à tabela
				else
				{
					$this->HabilitarTabela();
				}
				
				
				$this->DesabilitarBotao("PainelAcoesConectar");
				$this->DesabilitarBotao("PainelAcoesIniciar");
				$this->HabilitarBotao("PainelAcoesDesistir");
				
				// Seleciona o jogador atual no placar
				$this->SelecionarJogador();

				break;
		}
	}
	
	// Função que exibe na tela uma mensagem
	public function Alertar($Mensagem)
	{
		echo
		"
			<SCRIPT>alert('$Mensagem');</SCRIPT>
		";
	}

}

?>