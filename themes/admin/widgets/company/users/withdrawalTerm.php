<?= $this->layout("_admin"); ?>

<script>

	function ClosePrint() {
		setTimeout(function () { window.print(); }, 500);
		window.onfocus = function () { setTimeout(function () { window.close(); }, 500); }
	}

</script>

<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:"Cambria Math";
	panose-1:2 4 5 3 5 4 6 3 2 4;}
@font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin-top:0cm;
	margin-right:0cm;
	margin-bottom:8.0pt;
	margin-left:0cm;
	line-height:106%;
	font-size:11.0pt;
	font-family:"Calibri",sans-serif;}
h1
	{mso-style-link:"Título 1 Char";
	margin:0cm;
	text-align:center;
	page-break-after:avoid;
	font-size:12.0pt;
	font-family:"Arial",sans-serif;
	font-style:italic;}
p.MsoBodyText, li.MsoBodyText, div.MsoBodyText
	{mso-style-link:"Corpo de texto Char";
	margin:0cm;
	font-size:12.0pt;
	font-family:"Times New Roman",serif;
	font-weight:bold;}
p.MsoNoSpacing, li.MsoNoSpacing, div.MsoNoSpacing
	{margin:0cm;
	font-size:11.0pt;
	font-family:"Calibri",sans-serif;}
span.Ttulo1Char
	{mso-style-name:"Título 1 Char";
	mso-style-link:"Título 1";
	font-family:"Arial",sans-serif;
	font-weight:bold;
	font-style:italic;}
span.CorpodetextoChar
	{mso-style-name:"Corpo de texto Char";
	mso-style-link:"Corpo de texto";
	font-family:"Times New Roman",serif;
	font-weight:bold;}
.MsoChpDefault
	{font-size:10.0pt;}
.MsoPapDefault
	{margin-bottom:8.0pt;
	line-height:106%;}
@page WordSection1
	{size:595.5pt 842.0pt;
	margin:3.0cm 2.0cm 2.0cm 2.0cm;}
div.WordSection1
	{page:WordSection1;}

/* Print Definitions */
@media print {
  nav {visibility: hidden;} 
  footer {visibility: hidden;} 
  div.WordSection1{visibility: visible;}div.WordSection1 {position: fixed;left: 0;top: 0;}}

</style>

<body lang=PT-BR link="#0563C1" onload="ClosePrint()" vlink="#954F72" style='word-wrap:break-word'>

<div class=WordSection1>

	<div align=center>

		<img class="rounded mx-auto d-block" src="<?=url('themes/'.CONF_VIEW_APP.'/assets/images/logo_termo.png');?>">

		<h1 class="mt-5"><u><span style='font-size:14.0pt;font-style:normal'><b>TERMO DE EMPRÉSTIMO</b></span></u></h1>

		<p class=MsoNormal><span style='font-size:10.0pt;line-height:106%;font-family:
		"Arial",sans-serif'>&nbsp;</span></p>

		<p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;text-align:justify;text-indent:-.1pt'><span style='font-size:10.0pt;line-height:150%;font-family:
		"Arial",sans-serif;font-weight:normal'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Eu <span class="text-uppercase"><b><?=$term->user()->user_name?></b></span>,
		portador do Registro Funcional (RF) <span><b><?=$term->user()->rf?></span></b>, lotado/a na <span><b><?=$term->user()->userUnit()->unit_name?></b></span>,
		&nbsp;declaro assumir responsabilidade pela guarda, conservação deste aparelho
		(e acessórios) e uso adequado do(s) equipamento(s) abaixo listado(s) , conforme
		segue:</span></p>
		
		<table class=a border=1 cellspacing=0 cellpadding=0 width=624 style='border-collapse: collapse;border:none'>
			<tr style='height:44.0pt'>
				<td width=624 valign=top style='width:467.7pt;border:solid black 1.0pt; padding:0.2cm 5.4pt 0cm 5.4pt;height:44.0pt'>
				<p class=MsoNormal style='text-align:justify;text-indent:-.1pt'>
					<span style='font-size:10.0pt;font-family:"Arial",sans-serif'> <b>01</b>  
					<?=$term->product()->product_name?> <?=$term->product()->brand()->brand_name?> - <span><b><?=$term->product()->type_part_number?> : 
					<?php 
						if($term->product()->type_part_number == 'CHIP'){
						echo '(11)'.$term->part_number;
					} else {
						echo $term->part_number;
					}
					?>
				</b></span>, <?=$term->product()->acessories?></span>
				</p>
				</td>
			</tr>
		</table>

		<p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;margin-top:0.25cm;text-align:justify;text-indent:-.1pt'><span
		style='font-size:10.0pt;line-height:150%;font-family:"Arial",sans-serif;
		font-weight:normal'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Declaro ainda, que <span><b>RECEBI</b></span> o equipamento 
		acima discriminado em perfeita condição de uso, e que li e entendi os termos deste Termo de Empréstimo, 
		estando <span><b>CIENTE</b></span> e <span><b>DE ACORDO</b></span> que:</span></p>

		<p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;text-align:justify;text-indent:-.1pt'><span
			style='font-family:"Arial",sans-serif'>1</span><span
		style='font-size:10.0pt;line-height:150%;font-family:"Arial",sans-serif;
		font-weight:normal'>.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; O
		equipamento é para meu uso exclusivo, e por isso, é terminantemente vedado o
		empréstimo, cessão e/ou transferência do aparelho recebido à terceiros, inclusive a outros servidores. Assumo também o compromisso de devolver para <b>COTI</b>
		<span style='font-size:10.0pt;line-height:150%;font-family:"Arial",sans-serif;font-weight:normal'> 
			o/s equipamento/s supracitado/s caso mude de setor ou de secretaria, ou seja alocado em outra função que não faz uso do equipamento.</span></p>

		<p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;text-align:justify;text-indent:-.1pt'><span
			style='font-family:"Arial",sans-serif'>2</span><span
		style='font-size:10.0pt;line-height:150%;font-family:"Arial",sans-serif;
		font-weight:normal'>.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Na
		eventualidade de problemas de ordem técnica ou operacional, o aparelho deverá
		ser devolvido à </span><span style='font-size:10.0pt;line-height:150%;font-family:
		"Arial",sans-serif'><b>COTI</b></span><span style='font-size:10.0pt;line-height:150%;
		font-family:"Arial",sans-serif;font-weight:normal'> de imediato, comunicando por e-mail : <b>cotisuporte@smsub.prefeitura.sp.gov.br</b> ou <b>memorando</b>, 
		onde deverá ser registrado o problema apresentado, constando o </span><span
		style='font-size:10.0pt;line-height:150%;font-family:"Arial",sans-serif'><b><?=$term->product()->type_part_number?></b></span><span
		style='font-size:10.0pt;line-height:150%;font-family:"Arial",sans-serif;
		font-weight:normal'> do aparelho;</span></p>

		<p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;text-align:justify;text-indent:-.1pt'><span
			style='font-family:"Arial",sans-serif'>3</span><span
		style='font-size:10.0pt;line-height:150%;font-family:"Arial",sans-serif;
		font-weight:normal'>.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; No caso
		de roubo / furto / perda do equipamento, deverei comunicar </span><span
		style='font-size:10.0pt;line-height:150%;font-family:"Arial",sans-serif'>de
		imediato</span><span style='font-size:10.0pt;line-height:150%;font-family:"Arial",sans-serif;
		font-weight:normal'> à </span><span style='font-size:10.0pt;line-height:150%;
		font-family:"Arial",sans-serif'><b>COTI</b></span><span style='font-size:10.0pt;
		line-height:150%;font-family:"Arial",sans-serif;font-weight:normal'> através de <b>Processo SEI</b> ou <b>Memorando</b>,
		anexando o B.O. - Boletim de Ocorrência Policial;</span></p>

		<p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;text-align:justify;text-indent:-.1pt'><span
			style='font-family:"Arial",sans-serif'>4</span></a><span style='font-size:10.0pt;
		line-height:150%;font-family:"Arial",sans-serif;font-weight:normal'>.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Conforme a </span><span style='font-size:10.0pt;line-height:150%;font-family:
		"Arial",sans-serif'><b>Portaria 137/05 SMG. Art. 1º Inciso IV</b></span><span
		style='font-size:10.0pt;line-height:150%;font-family:"Arial",sans-serif;
		font-weight:normal'> deverei ressarcir os prejuízos decorrentes de perda,
		furto, ou danos ao equipamento, devido à má utilização ou conservação, repondo
		o equipamento com a mesma especificação técnica à marca/modelo, ou similar, </span><span
		style='font-size:10.0pt;line-height:150%;font-family:"Arial",sans-serif'>às minhas
		expensas</span><span style='font-size:10.0pt;line-height:150%;font-family:"Arial",sans-serif;
		font-weight:normal'>;</span></p>

		<p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;text-align:justify;text-indent:-.1pt'><span
			style='font-family:"Arial",sans-serif'>5</span><span
		style='font-size:10.0pt;line-height:150%;font-family:"Arial",sans-serif;
		font-weight:normal'>.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Em caso
		de aposentadoria, exoneração ou licença o servidor deverá comunicar à </span><span style='font-size:10.0pt;line-height:
		150%;font-family:"Arial",sans-serif'><b>COTI</b></span><span style='font-size:10.0pt;
		line-height:150%;font-family:"Arial",sans-serif;font-weight:normal'> de
		imediato.</span></p>

		<table class=a border=1 cellspacing=0 cellpadding=0 width=624 style='border-collapse: collapse;border:none'>
			<tr style='height:44.0pt'>
				<td width=624 valign=top style='width:467.7pt;border:solid black 1.0pt; padding:0.2cm 5.4pt 0cm 5.4pt;height:44.0pt'>
					<p class=MsoNormal style='text-align:justify;text-indent:-.1pt'>
						<span style='font-size:10.0pt;font-family:"Arial",sans-serif'><b>OBSERVAÇÕES :</b> <?=$term->observations?><br> ID:<?=$term->id?></span></p>
				</td>
			</tr>
		</table>

		<p class=MsoBodyText style='margin-top:4.6pt'><span style='font-size:10.0pt;
		font-family:"Arial",sans-serif'>Nestes<span style='letter-spacing:.5pt'> </span>termos,</span></p>

		<p class=MsoBodyText style='margin-top:.55pt'><span style='font-size:10.0pt;
		font-family:"Arial",sans-serif'>&nbsp;</span></p>

	</div>

		<p class=MsoNormal style='text-indent:-.1pt;margin-left:1.25cm;margin-right:1.25cm;line-height:normal'><b><span style='font-size:10.0pt;
		font-family:"Arial",sans-serif'>Assinatura do responsável pela retirada</span></b><span
		style='font-size:10.0pt;font-family:"Arial",sans-serif'>:_________________________________________________</span></p>

		<p class=MsoNormal style='text-indent:-.1pt;margin-left:1.25cm;margin-right:1.25cm;line-height:normal'><b><span style='font-size:10.0pt;
		font-family:"Arial",sans-serif'>Data da retirada</span></b><span
		style='font-size:10.0pt;font-family:"Arial",sans-serif'>: _____/______/_________</span></p>

		<p class=MsoNormal style='text-indent:-.1pt;margin-left:1.25cm;margin-right:1.25cm;line-height:normal'><span style='font-size:10.0pt;
		font-family:"Arial",sans-serif'><b>E-mail: </b></span><span style='font-size:
		10.0pt;font-family:"Arial",sans-serif'><?=(!empty($term->user()->email) ? $term->user()->email : "_______________________________________________");?></span></p>

		<p class=MsoNormal style='text-indent:-.1pt;margin-left:1.25cm;margin-right:1.25cm;line-height:normal'><span style='font-size:10.0pt;
		font-family:"Arial",sans-serif'><b>Celular: </b></span><span style='font-size:
		10.0pt;font-family:"Arial",sans-serif'><?=(!empty($term->user()->cell_phone) ? '('.substr($term->user()->cell_phone, 0,2).')'.substr($term->user()->cell_phone, 2,9) : "_____________________________");?></span></p>


			<div class="d-flex flex-column text-center">
				<div class="fw-bold mb-2 mt-4" style='font-size:10.0pt'>Entregue por :</div>
				<div class="text-uppercase fw-bold" style='font-size:8.0pt'><?=user()->user_name?></div>
				<div class="fw-bold" style='font-size:8.0pt'><?=user()->userPosition()->position_name?></div>
				<div class="fw-bold" style='font-size:8.0pt'>RF: <?=user()->rf?></div>
			</div>

	
</div>

</body>

