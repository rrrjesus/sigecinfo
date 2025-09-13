
<?= $this->layout("_beta"); ?>

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
	{font-family:"Cambria Math"; panose-1:2 4 5 3 5 4 6 3 2 4;}
@font-face
	{font-family:Verdana;	panose-1:2 11 6 4 3 5 4 4 2 4;}
@font-face
	{font-family:Tahoma; panose-1:2 11 6 4 3 5 4 4 2 4;}
@font-face
	{font-family:Georgia; panose-1:2 4 5 2 5 4 5 2 3 3;}
@font-face
	{font-family:"Arial Narrow"; panose-1:2 11 6 6 2 2 2 3 2 4;}

 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin-top:0cm; margin-right:0cm; margin-bottom:0cm; margin-left:-.05pt; text-indent:-.05pt; font-size:10.0pt; font-family:"Times New Roman",serif; position:relative; top:.5pt;}
.MsoChpDefault {font-size:10.0pt;}
 
/* Page Definitions */
 @page WordSection1 {size:21.0cm 842.0pt;	margin:28.95pt 2.0cm 31.2pt 70.9pt;}
div.WordSection1 {page:WordSection1;}

 /* List Definitions */
 ol {margin-bottom:0cm;}
ul {margin-bottom:0cm;}

 /* Print Definitions */
@media print {
  nav {visibility: hidden;} 
  footer {visibility: hidden;} 
  div.WordSection1{visibility: visible;}div.WordSection1 {position: fixed;left: 0;top: 0;}}

</style>

<body lang=PT-BR link=blue onload="ClosePrint()" vlink=purple style='word-wrap:break-word'>

<div class="container-fluid">
  <div class="row justify-content-end mt-1 mb-1">
    <div class="col-2">
      <?=buttonLink("/beta/patrimonios", "left", "Clique para retornar a listar os patrimônios", "danger", "list", "Sair", "1", "s")?>  
    </div>
  </div>

  <div class=WordSection1>

    <img class="rounded mx-auto d-block" src="<?=url('themes/'.CONF_VIEW_APP.'/assets/images/logo_termo.png');?>">

    <p class=MsoNormal align=center style='margin-left:-1.25text-align:center;
    text-indent:-.1pt'><span style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

    <p class=MsoNormal align=center style='margin-left:.05pt;text-align:center;
    text-indent:-.15pt;line-height:normal;page-break-after:avoid;border:none'><b><u><span
    style='font-size:14.0pt;font-family:"Arial",sans-serif;color:black'>TERMO DE
    RESPONSABILIDADE</span></u></b></p>

    <p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;text-indent:-.1pt'><span
    style='font-size:8.0pt'>&nbsp;</span></p>

    <p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;text-align:justify;text-indent:-.1pt'><span
    style='font-size:8.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

    <p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;text-align:justify;text-indent:-.1pt'><span
    style='font-family:"Arial",sans-serif'>Declaro que RECEBI os equipamentos
    abaixo discriminados, e que li e entendi os termos deste Termo de
    Responsabilidade, estando <b><span style='font-variant:small-caps'>CIENTE </span>e<span
    style='font-variant:small-caps'> DE ACORDO</span></b> que:</span></p>

    <p class=MsoNormal style='margin-top:14.0pt;margin-right:0cm;margin-bottom:
    0cm;margin-left:1.25cm;margin-right:1.25cm;margin-bottom:.0001pt;text-align:justify;text-indent:-.1pt'><span
    style='font-family:"Arial",sans-serif'>1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </span></span><span style='font-family:"Arial",sans-serif'>A partir da data do
    recebimento, sou responsável pela guarda e conservação deste aparelho (e
    acessérios), e que o mesmo é para meu <b>uso exclusivo</b>;</span></p>

    <p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;text-align:justify;text-indent:-.1pt'><span
    style='font-family:"Arial",sans-serif'>2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </span></span><span style='font-family:"Arial",sans-serif'>É terminantemente vedado o empréstimo, cessão e/ou transferência do aparelho recebido a terceiros, sendo de utilização <b>exclusiva para o curso de fiscais de posturas municipais</b></span></p>

    <p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;text-align:justify;text-indent:-.1pt;
    line-height:normal;border:none'><span style='font-family:"Arial",sans-serif;
    color:black'>3.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </span></span><span style='font-family:"Arial",sans-serif;color:black'>Na
    eventualidade de problemas de ordem técnica ou operacional, o aparelho dever 
    ser enviado à COTI de imediato, por intermédio de memorando, onde deverá ser
    registrado o problema apresentado, constando o Nº de Série do aparelho. Em caso
    de problemas no equipamento, deverei comunicar à COTI imediatamente;</span></p>

    <p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;text-align:justify;text-indent:-.1pt'><span
    style='font-family:"Arial",sans-serif'>4.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </span></span><span style='font-family:"Arial",sans-serif'>No caso de roubo /
    furto / perda do equipamento, deverei comunicar <b><u>de imediato</u></b> à
    COTI por intermédio de Memorando, anexando o <b>B.O.</b> - Boletim de
    Ocorrência Policial;</span></p>

    <p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;text-align:justify;text-indent:-.1pt'><span
    style='font-family:"Arial",sans-serif'>5.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </span></span><span style='font-family:"Arial",sans-serif'>Conforme a Portaria
    137/05 SMG. Art. 1º Inciso IV deverei ressarcir os prejuízos decorrentes de
    perda ou furto, ou danos ao equipamento devido à má utilização ou conservação,
    repondo o equipamento com a mesma especificação técnica á marca / modelo, ou similar,
    <b>Às minhas expensas</b>;</span></p>

    <p class=MsoNormal style='margin-top:14.0pt;margin-right:0cm;margin-bottom: 0cm;margin-left:1.25cm;margin-right:1.25cm;margin-bottom:.0001pt;text-align:justify;text-indent:-.1pt'>
      <span style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

    <div align=center>

      <table class=a border=1 cellspacing=0 cellpadding=0 width=624 style='border-collapse: collapse;border:none'>
        <tr style='height:44.0pt'>
          <td width=624 valign=top style='width:467.7pt;border:solid black 1.0pt; padding:0cm 5.4pt 0cm 5.4pt;height:44.0pt'>
            <p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;text-indent:-.1pt'><b>
              <span style='font-size:9.0pt;font-family:"Verdana",sans-serif'>Equipamento:</span></b>
              <span style='font-size:9.0pt;font-family:"Verdana",sans-serif'> 01 <?=$term->productBrand($term->product()->brand_id)->brand_name?> 
              <?=$term->product()->product_name?> - <?=$term->product()->type_part_number?> : <?=$term->part_number?></span>
            </p>
            <p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;text-indent:-.1pt'>
              <span style='font-size:9.0pt;font-family:"Verdana",sans-serif'><strong>Descrição</strong> : <?=$term->product()->acessories?></span>
            </p>
          </td>
        </tr>
      </table>

      <p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;text-align:justify;text-indent:-.1pt'>
        <span style='font-family:"Arial",sans-serif'>&nbsp;</span>
      </p>

      <table class=a0 border=1 cellspacing=0 cellpadding=0 width=624 style='margin-left:-.15pt;border-collapse:collapse;border:none'>
        <tr style='height:39.7pt'>
          <td width=314 valign=top style='width:235.85pt;border:solid black 1.0pt; padding:0cm 5.4pt 0cm 5.4pt;height:39.7pt'>
            <p class=MsoNormal style='margin-left:0cm;text-indent:-.1pt'><b>
              <span style='font-size:9.0pt;font-family:"Verdana",sans-serif'>AUTORIZADO EM</span></b>
              <span style='font-size:8.0pt;font-family:"Verdana",sans-serif'>:</span>
            </p>
            <p class=MsoNormal style='margin-left:0cm;text-indent:-.1pt'>
              <span style='font-size:8.0pt;font-family:"Verdana",sans-serif'>&nbsp;</span>
            </p>
            <p class=MsoNormal align=center style='margin-left:.05pt;text-align:center; text-indent:-.15pt'><b><span style='font-size:14.0pt;font-family:"Verdana",sans-serif'><?=date_now()?></span></b></p>
            <p class=MsoNormal style='margin-left:.05pt;text-indent:-.15pt'>
              <span style='font-size:14.0pt;font-family:"Verdana",sans-serif'>&nbsp;</span>
            </p>
            <p class=MsoNormal><span style='font-size:6.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
          </td>
          <td width=309 valign=top style='width:231.95pt;border:solid black 1.0pt; border-left:none;padding:0cm 5.4pt 0cm 5.4pt;height:39.7pt'>
            <p class=MsoNormal style='margin-left:0cm;text-indent:-.1pt'><b>
            <span style='font-size:9.0pt;font-family:"Verdana",sans-serif'>OBSERVAÇÃO:</span></b>
            </p>
            <p class=MsoNormal style='margin-left:0cm;text-indent:-.1pt'>
              <span style='font-size:9.0pt;font-family:"Verdana",sans-serif'><?=$term->observations?> ID:<?=$term->id?></span>
            </p>
            <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent: -.1pt'>
              <span style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span>
            </p>
          </td>
        </tr>
      </table>

    <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:-.1pt'><span
    style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

    <table class=a1 border=1 cellspacing=0 cellpadding=0 width=624
    style='margin-left:-.15pt;border-collapse:collapse;border:none'>
    <tr>
    <?php if($term->user_id){?>
      <td width=312 valign=top style='width:233.9pt;border:solid black 1.0pt;
      padding:0.25cm 5.4pt 0cm 5.4pt'>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:120%'><b><span style='font-family:"Arial",sans-serif'>RECEBIDO</span></b><span
      style='font-family:"Arial",sans-serif'> em _____/ _____/ ________</span></p>
      <p class=MsoNormal style='margin-left:0cm;text-indent:-.1pt'><b><span
      style='font-family:"Arial",sans-serif'>NOME</span></b><span style='font-family:
      "Arial",sans-serif' class=text-uppercase>: <?=$term->userPatrimony()->user_name?></span></p>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:120%'><b><span style='font-family:"Arial",sans-serif'>R.F</span></b><span
      style='font-family:"Arial",sans-serif'> : <?=$term->userPatrimony()->rf?></span></p>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:120%'><b><span style='font-family:"Arial",sans-serif'>FUNÇÃO</span></b><span
      style='font-family:"Arial",sans-serif'>: <?=$term->userPosition($term->userPatrimony()->position_id)->position_name?></span></p>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:120%'><b><span style='font-family:"Arial",sans-serif'>UNIDADE</span></b><span
      style='font-family:"Arial",sans-serif'>: <?=$term->userUnit($term->userPatrimony()->unit_id)->unit_name?></span></p>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:120%'><b><span style='font-family:"Arial",sans-serif'>TEL</span></b><span
      style='font-family:"Arial",sans-serif'>.<b>PESSOAL</b>: <?=$term->userPatrimony()->cell_phone?></span></p>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:120%;padding:0cm 0pt 0.25cm 0pt'><b><span style='font-family:"Arial",sans-serif'>E-MAIL</span></b><span
      style='font-family:"Arial",sans-serif'>: <?=$term->userPatrimony()->email?></span></p>
      </td>
      <?php }else{;?>
        <td width=312 valign=top style='width:233.9pt;border:solid black 1.0pt;
      padding:0.25cm 5.4pt 0cm 5.4pt'>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:120%'><b><span style='font-family:"Arial",sans-serif'>RECEBIDO</span></b><span
      style='font-family:"Arial",sans-serif'> em _____/ _____/ ________</span></p>
      <p class=MsoNormal style='margin-left:0cm;text-indent:-.1pt'><b><span
      style='font-family:"Arial",sans-serif'>NOME</span></b><span style='font-family:
      "Arial",sans-serif' class=text-uppercase>: ________________________________</span></p>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:120%'><b><span style='font-family:"Arial",sans-serif'>R.F</span></b><span
      style='font-family:"Arial",sans-serif'> : ________________</span></p>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:120%'><b><span style='font-family:"Arial",sans-serif'>FUNÇÃO</span></b><span
      style='font-family:"Arial",sans-serif'>: _______________________________</span></p>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:120%'><b><span style='font-family:"Arial",sans-serif'>UNIDADE</span></b><span
      style='font-family:"Arial",sans-serif'>: ______________________________</span></p>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:120%'><b><span style='font-family:"Arial",sans-serif'>TEL</span></b><span
      style='font-family:"Arial",sans-serif'>.<b>PESSOAL</b>: _________________________</span></p>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:120%;padding:0cm 0pt 0.25cm 0pt'><b><span style='font-family:"Arial",sans-serif'>E-MAIL</span></b><span
      style='font-family:"Arial",sans-serif'>: _______________________________</span></p>
      </td>
      <?php };?>
      <td width=312 valign=top style='width:233.9pt;border:solid black 1.0pt;
      border-left:none;padding:0cm 5.4pt 0cm 5.4pt'>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:150%'><span style='font-size:9.0pt;line-height:150%;
      font-family:"Arial",sans-serif'>Assinatura:</span></p>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:150%'><span style='font-size:9.0pt;line-height:150%;
      font-family:"Arial",sans-serif'>&nbsp;</span></p>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:150%'><span style='font-size:9.0pt;line-height:150%;
      font-family:"Arial",sans-serif'>&nbsp;</span></p>
      <p class=MsoNormal align=center style='margin-left:0cm;text-align:center;
      text-indent:-.1pt;line-height:120%'><span style='font-size:10.0pt;line-height:
      120%;font-family:"Arial",sans-serif'>__________________________________</span></p>
      <p class=MsoNormal align=center style='margin-left:0cm;text-align:center;
      text-indent:-.1pt;line-height:120%'><span style='font-size:10.0pt;line-height:
      120%;font-family:"Arial",sans-serif'>De acordo</span></p>
      </td>
    </tr>
    <tr style='height:39.0pt'>
      <td width=312 valign=top style='width:233.9pt;border:solid black 1.0pt;
      border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:39.0pt'>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:120%'><span style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:120%'><b><span style='font-family:"Arial",sans-serif'>Devolvido
      em ___/____/_______</span></b></p>
      </td>
      <td width=312 valign=top style='width:233.9pt;border-top:none;border-left:
      none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
      padding:0cm 5.4pt 0cm 5.4pt;height:39.0pt'>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:150%'><span style='font-size:9.0pt;line-height:150%;
      font-family:"Arial",sans-serif'>&nbsp;</span></p>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:150%'><span style='font-size:9.0pt;line-height:150%;
      font-family:"Arial",sans-serif'>Recebi o equipamento:
      _________________________</span></p>
      <p class=MsoNormal style='margin-left:0cm;text-align:justify;text-indent:
      -.1pt;line-height:150%'><span style='font-size:9.0pt;line-height:150%;
      font-family:"Arial",sans-serif'>
      Fiscal/Supervisor</span></p>
      </td>
    </tr>
    </table>

    <p class=MsoNormal style='text-align:justify'><span style='font-size:4.0pt;
    font-family:"Arial",sans-serif'>&nbsp;</span></p>

    <p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;text-align:justify;text-indent:-.1pt'><b><span
    style='font-family:"Arial",sans-serif'>Obs:</span></b><span style='font-family:
    "Arial",sans-serif'> Após o término do curso, os tablets deverão ser entregues
    a Coti.</span></p>

    <p class=MsoNormal style='margin-left:1.25cm;margin-right:1.25cm;text-align:justify;text-indent:-.1pt'><span
    style='font-family:"Arial",sans-serif'>Em momento oportuno convocaremos
    para entrega de novos equipamentos </span></p>

    <p class=MsoNormal style='text-align:justify'><span style='font-size:4.0pt;
    font-family:"Arial",sans-serif'>&nbsp;</span></p>

  </div>
</div>

</body>
