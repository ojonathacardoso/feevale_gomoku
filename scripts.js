//
// Scripts em JavaScript
// scritps.js
//

// Array contendo as linhas e colunas do jogo
var linhas = new Array();

// Função que exibe na tela a tabela com a grade de jogadas
function ExibirTabela()
{
	document.getElementById('Grade').style.display = 'block';
}

// Função que oculta da tela a tabela com a grade de jogadas
function OcultarTabela()
{
	document.getElementById('Grade').style.display = 'none';	
}

// Função que retira um bloqueio visual de cima da tabela, habilitando as jogadas
function HabilitarTabela()
{
	document.getElementById('TabelaBloqueada').style.display = 'none';
}

// Função que coloca um bloqueio visual de cima da tabela, bloqueando as jogadas
function DesabilitarTabela()
{
	document.getElementById('TabelaBloqueada').style.display = 'block';	
}

// Função que desabilita um botão de ação
function DesabilitarBotao(id)
{
	document.getElementById(id).className = 'PainelAcoesBotoesDesabilitado';
	document.getElementById(id).disabled = true;
}

// Função que habilita um botão de ação
function HabilitarBotao(id)
{
	document.getElementById(id).className = 'PainelAcoesBotoes';
	document.getElementById(id).disabled = false;
}

// Função que prepara página para conexão 
function Conectar()
{
	// Obtém desejo do usuário.
	// OK para conectar-se ao adversário, Cancelar para aguardar conexão do adversário
	conectar = confirm("Clique em OK para se conectar ao adversário ou em Cancelar para aguardar a conexão. \n\nATENÇÃO: Se ambos clicarem no OK ou no Cancelar, a conexão não poderá ser realizada!");

	// Obtém do usuário a porta serial, que deve ter obrigatoriamente 4 dígitos (COMX)
	do {
		porta = prompt("Informe a porta serial", "");
	} while(porta.length != 4);
	
	if(conectar)
	{
		// Caso ele escolheu OK, ele avisa ao usuário sobre a conexão e redireciona para a página correspondente
		alert("Após recarregar a página, em 10 segundos faremos tentativa de comunicação com o outro computador, aguardando retorno do mesmo. \n\nSe a comunicação for bem sucedida, o jogo poderá ser iniciado");
		url='index.php?c=110000&p='+porta;
	}
	else
	{
		// Caso ele escolheu Cancelar, ele avisa ao usuário sobre a conexão e redireciona para a página correspondente
		alert("Após recarregar a página, aguardaremos tentativa de comunicação do outro computador, respondendo em seguida ao mesmo. \n\nSe a comunicação for bem sucedida, o jogo poderá ser iniciado");
		url='index.php?c=120000&p='+porta;
	}

	location.href=url;
}

// Função que avisa que a porta informada não existe
function PortaErrada(codigo)
{
	alert("A porta serial não existe!");
	
	// Obtém do usuário a porta serial, que deve ter obrigatoriamente 4 dígitos (COMX)
	do {
		porta = prompt("Informe uma porta serial válida!", "");
	} while(porta.length != 4);
	
	url='index.php?c='+codigo+'&p='+porta;
	
	location.href=url;
}

// Função que avisa que a porta informada está desconectada
function PortaDesconectada(codigo)
{
	alert("A porta serial está desconectada!");
	
	// Obtém do usuário a porta serial, que deve ter obrigatoriamente 4 dígitos (COMX)
	do {
		porta = prompt("Informe uma porta serial válida e conectada!", "");
	} while(porta.length != 4);
	
	url='index.php?c='+codigo+'&p='+porta;
	
	location.href=url;
}

// Função que informa a cor do jogador e redireciona para o jogo
function NovoJogo(jogador)
{
	if(jogador==1)
		alert('Você jogará com a cor preta! Bom jogo!');
	else
		alert('Você jogará com a cor branca! Bom jogo!');

	location.href='index.php?c=200000';
}

// Função que destaca, com uma borda vermelha, qual o jogador atual
function SelecionarJogador(jogador)
{	
	if (jogador == 1)
	{
		document.getElementById('PainelPlacarNumeroPreto').style.border = '1px solid red';
		document.getElementById('PainelPlacarNumeroBranco').style.border = '1px solid #616261';
	}
	else
	{
		document.getElementById('PainelPlacarNumeroPreto').style.border = '1px solid #616261';
		document.getElementById('PainelPlacarNumeroBranco').style.border = '1px solid red';
	}
}

// Grava no array as linhas da grade de jogadas
function CelulasGrade(id, celulas)
{
	linhas[id] = celulas;
}

// Pinta o ponto da grade de jogadas com uma cor determinada
function PintarCelula(id, cor)
{
	document.getElementById(id).style.background = cor;
}

// Testa a jogada
function TestarJogada(id, jogador)
{
	posicoes = id.split(',');
	x = posicoes[0];
	y = posicoes[1];
	
	celulas = linhas[x].split(',');
	
	// Caso o ponto já esteja marcado...
	if(celulas[y] != 0)
	{
		alert("Ponto já marcado! Escolha outro ponto!");
	}
	// ...e caso esteja livre
	else
	{
		// Adiciona esta jogada no array para poder testar a jogada
		AdicionarJogada(id, jogador);
	
		vitoria = LinhaCompleta();
		
		if(jogador == 1)
			PintarCelula(id, 'black');
		else
			PintarCelula(id, 'white');
		
		DesabilitarTabela();
		DesabilitarBotao('PainelAcoesConectar');
		DesabilitarBotao('PainelAcoesIniciar');
		DesabilitarBotao('PainelAcoesDesistir');
		
		// Caso o jogador tenha vencido...
		if(vitoria)
		{
			alert("Parabéns! Você venceu!");

			location.href='index.php?c=700000';
		}
		// ...ou não
		else
		{
			if (x < 10)
				pontox = "0"+x;
			else
				pontox = x;
				
			if (y < 10)
				pontoy = "0"+y;
			else
				pontoy = y;

			location.href='index.php?c=50'+pontox+''+pontoy;
		}
	}

}

// Função que percorre todo o array para verificar se já temos a famigerada linha de exatamente 5 cores iguais.
function LinhaCompleta()
{
	// Laço pra percorrer as linhas
	for(lin=0;lin<19;lin++)
	{
		mesmaCor = 0;
		corAtual = 0;
		
		// Dentro do primeiro laço porque testamos a linha.
		// Como o array é de linhas, a cada linha percorrida, basta "splitar" a linha para percorrê-la.
		celulas = linhas[lin].split(',');
		
		for(col=0;col<19;col++)
		{
			if(celulas[col] == 0)
			{
				if (mesmaCor == 5)
				{
					if(celulas[col] != corAtual)
					{
						return true;
					}                        
				}
				else
				{
					mesmaCor = 0;
					corAtual = 0;
				}
			}
			else
			{
				if (mesmaCor == 5)
				{
					if(celulas[col] != corAtual)
					{
						return true;
					}
					else
					{
						mesmaCor++;
					}
				}
				else
				{
					if(corAtual == celulas[col] && corAtual != 0)
					{
						mesmaCor++;
					}
					else
					{
						mesmaCor = 1;
						corAtual = celulas[col];
					}
				}
			}
			
		}
	}
	
	// Laço pra percorrer as colunas
	for(col=0;col<19;col++)
	{
		mesmaCor = 0;
		corAtual = 0;

		for(lin=0;lin<19;lin++)
		{
			// Dentro do segundo laço porque testamos a coluna.
			// Como o array é de linhas, a cada linha percorrida, basta "splitar" a linha e obter a coluna "col" respectiva.
			celulas = linhas[lin].split(',');

			if(celulas[col] == 0)
			{
				if (mesmaCor == 5)
				{
					if(celulas[col] != corAtual)
					{
						return true;
					}                        
				}
				else
				{
					mesmaCor = 0;
					corAtual = 0;
				}
			}
			else
			{
				if (mesmaCor == 5)
				{
					if(celulas[col] != corAtual)
					{
						return true;
					}
					else
					{
						mesmaCor++;
					}
				}
				else
				{
					if(corAtual == celulas[col] && corAtual != 0)
					{
						mesmaCor++;
					}
					else
					{
						mesmaCor = 1;
						corAtual = celulas[col];
					}
				}
			}
		}
	}
	
	// Laço pra percorrer as diagonais principais
	for(diagonal=(-18); diagonal<=18; diagonal++)
	{
		mesmaCor = 0;
		corAtual = 0;

		for(lin=0;lin<19;lin++)
		{
			for(col=0;col<19;col++)
			{
				if((col-lin) == diagonal)
				{
					// Dentro do if porque testamos a diagonal.
					// Como o array é de linhas, a cada linha percorrida, basta "splitar" a linha e obter a coluna da diagonal correspondente
					celulas = linhas[lin].split(',');

					if(celulas[col] == 0)
					{
						if (mesmaCor == 5)
						{
							if(celulas[col] != corAtual)
							{
								return true;
							}                        
						}
						else
						{
							mesmaCor = 0;
							corAtual = 0;
						}
					}
					else
					{
						if (mesmaCor == 5)
						{
							if(celulas[col] != corAtual)
							{
								return true;
							}
							else
							{
								mesmaCor++;
							}
						}
						else
						{
							if(corAtual == celulas[col] && corAtual != 0)
							{
								mesmaCor++;
							}
							else
							{
								mesmaCor = 1;
								corAtual = celulas[col];
							}
						}
					}
				}
			}
		}
	}
	
	// Laço pra percorrer as diagonais secundárias
	for(diagonal=0; diagonal<=36; diagonal++)
	{
		mesmaCor = 0;
		corAtual = 0;

		for(lin=0;lin<19;lin++)
		{
			for(col=0;col<19;col++)
			{
				if((col+lin) == diagonal)
				{
					// Dentro do if porque testamos a diagonal.
					// Como o array é de linhas, a cada linha percorrida, basta "splitar" a linha e obter a coluna da diagonal correspondente
					celulas = linhas[lin].split(',');

					if(celulas[col] == 0)
					{
						if (mesmaCor == 5)
						{
							if(celulas[col] != corAtual)
							{
								return true;
							}                        
						}
						else
						{
							mesmaCor = 0;
							corAtual = 0;
						}
					}
					else
					{
						if (mesmaCor == 5)
						{
							if(celulas[col] != corAtual)
							{
								return true;
							}
							else
							{
								mesmaCor++;
							}
						}
						else
						{
							if(corAtual == celulas[col] && corAtual != 0)
							{
								mesmaCor++;
							}
							else
							{
								mesmaCor = 1;
								corAtual = celulas[col];
							}
						}
					}
				}
			}
		}
	}
	
	return false;
}

// Função que adiciona a última jogada ao nosso array de jogadas
function AdicionarJogada(id,jogador)
{
	/*
	Por que split, join, array?
	Porque o JavaScript não tem array multidimensional (matriz), mas apenas unidimensional (vetor)
	A solução? Usar strings separadas por vírgula em cada posição do vetor.
	O split divide esta string em um array - o que corresponderia a uma posição
	O join junta várias posições em uma string, jogando no array
	*/
	
	posicoes = id.split(',');
	x = posicoes[0];
	y = posicoes[1];
	
	celulas = linhas[x].split(',');
	celulas[y] = jogador;
	
	celulasAlteradas = celulas.join(',');
	linhas[x] = celulasAlteradas;
}

// Função que testa se o usuário quer desistir do seu jogo.
function Desistir()
{
	desistir = confirm("Deseja desistir do jogo? Seu adversário vencerá o jogo!");
	
	// Se desistir, avisa e redireciona a página
	if(desistir)
	{
		alert("Você desistiu. Vitória do seu adversário!");
	
		location.href=onClick=location.href='index.php?c=900000';
	}
}

function Ajuda()
{
	texto = "Gomoku (“cinco pontos” em Japonês) é um jogo de estratégia, jogado em um tabuleiro de 19 x 19 posições, com pedras brancas e pretas. "
			+ "O tabuleiro inicia vazio e o jogador que possuir as pedras pretas joga primeiro. Na sua vez de jogar, cada jogador coloca uma pedra "
			+ "de sua cor em qualquer quadrado vazio do tabuleiro. O primeiro jogador que formar uma linha contínua com exatamente cinco pedras"
			+ "nas direções vertical, horizontal ou diagonal é declarado vencedor."
			+ "\n\n";
			
	alert(texto);
}

function Creditos()
{
	texto = "The Web Serial Gomoku \u00A9 2015\n"
			+ "\n"
            + "Disciplina: Comunicação de Dados \n"
            + "Professor: Eduardo Leivas Bastos \n "
            + "\n"
            + "Desenvolvedores: Gabriel Moutinho, Jonatha Cardoso e Leandro Thomas"
			+ "\n\n";
	
	alert(texto);
}