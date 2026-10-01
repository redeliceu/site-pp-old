<?
require("cabecalho.php");
require("subcabecalho.php");
?>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td height="7"></td>
</tr>
<tr>
	<td background="../images/fundo-conteudo-cima.jpg" style="background-repeat:no-repeat;" height="23">
		
	</td>
</tr>
<tr>
	<td background="../images/fundo-conteudo-meio.jpg" style="background-repeat:repeat-y;">
		<table width="930" border="0" cellpadding="0" cellspacing="0" style="margin-left:auto;margin-right:auto;">
		<tr>
			<td>
				<img src="../images/barra-visita-virtual.jpg" border="0"></td>
		</tr>
		<tr>
			<td height="4"></td>
		</tr>
		<tr>
			<td style="padding: 32px 10px 0px 10px;">

				<!-- Jssor Slider Begin -->
			    <!-- To move inline styles to css file/block, please specify a class name for each element. --> 
			    <div id="slider1_container" style="margin:0 auto;position: relative; top: 0px; left: 0px; width: 800px;
			        height: 700px; background: #ffffff; overflow: hidden;">

			        <!-- Loading Screen -->
			        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
			            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
			                background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
			            </div>
			            <div style="position: absolute; display: block; background: url(../img/loading.gif) no-repeat center center;
			                top: 0px; left: 0px;width: 100%;height:100%;">
			            </div>
			        </div>

			        <!-- Slides Container -->
			        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 800px; height: 600px; overflow: hidden;">
			            <?
			            $files = array();
			            if ($handle = opendir('img/')) {
						    /* Esta é a forma correta de varrer o diretório */
						    while (false !== ($file = readdir($handle))) {
						    	if (($file != '.') && ($file != '..') && ($file != "thumb")) {
							        $files[] = $file;
							    }
						    }
						    closedir($handle);
						}
						sort($files, SORT_LOCALE_STRING);
						foreach ($files as $file) {
							$nome = "";
							$aux1 = array(".JPG", ".JPEG", ".jpg", ".jpeg", "_1", "_2", "_3", "_4", "_5", "_6", "_7", "_8");
							$aux2 = array("", "", "", "", "", "", "", "", "", "", "", "");
							$nome = str_replace($aux1, $aux2, $file);
							?><div><div u=caption t="CLIP|LR" class="captionOrange"  style="position:absolute; left:20px; top: 30px; width:300px; height:30px;z-index:999;"><?=$nome;?></div><img u="image" src="timthumb.php?src=img/<?=$file;?>&w=800&h=600" /><img u="thumb" src="timthumb.php?src=img/<?=$file;?>&w=60&h=45" /></div><?
						}
			            ?>
			        </div>
			        
			        <!--#region Arrow Navigator Skin Begin -->
			        <style>
			            /* jssor slider arrow navigator skin 05 css */
			            /*
			            .jssora05l                  (normal)
			            .jssora05r                  (normal)
			            .jssora05l:hover            (normal mouseover)
			            .jssora05r:hover            (normal mouseover)
			            .jssora05l.jssora05ldn      (mousedown)
			            .jssora05r.jssora05rdn      (mousedown)
			            */
			            .jssora05l, .jssora05r {
			                display: block;
			                position: absolute;
			                /* size of arrow element */
			                width: 40px;
			                height: 40px;
			                cursor: pointer;
			                background: url(../jssor-slider/img/a17.png) no-repeat;
			                overflow: hidden;
			            }
			            .jssora05l { background-position: -10px -40px; }
			            .jssora05r { background-position: -70px -40px; }
			            .jssora05l:hover { background-position: -130px -40px; }
			            .jssora05r:hover { background-position: -190px -40px; }
			            .jssora05l.jssora05ldn { background-position: -250px -40px; }
			            .jssora05r.jssora05rdn { background-position: -310px -40px; }
			        </style>
			        <!-- Arrow Left -->
			        <span u="arrowleft" class="jssora05l" style="top: 280px; left: 8px;">
			        </span>
			        <!-- Arrow Right -->
			        <span u="arrowright" class="jssora05r" style="top: 280px; right: 8px">
			        </span>
			        <!--#endregion Arrow Navigator Skin End -->
			        <!--#region Thumbnail Navigator Skin Begin -->
			        <!-- Help: http://www.jssor.com/development/slider-with-thumbnail-navigator-jquery.html -->
			        <style>
			            /* jssor slider thumbnail navigator skin 01 css */
			            /*
			            .jssort01 .p            (normal)
			            .jssort01 .p:hover      (normal mouseover)
			            .jssort01 .p.pav        (active)
			            .jssort01 .p.pdn        (mousedown)
			            */

			            .jssort01 {
			                position: absolute;
			                /* size of thumbnail navigator container */
			                width: 800px;
			                height: 100px;
			            }

			                .jssort01 .p {
			                    position: absolute;
			                    top: 0;
			                    left: 0;
			                    width: 72px;
			                    height: 72px;
			                }

			                .jssort01 .t {
			                    position: absolute;
			                    top: 0;
			                    left: 0;
			                    width: 100%;
			                    height: 100%;
			                    border: none;
			                }

			                .jssort01 .w {
			                    position: absolute;
			                    top: 0px;
			                    left: 0px;
			                    width: 100%;
			                    height: 100%;
			                }

			                .jssort01 .c {
			                    position: absolute;
			                    top: 0px;
			                    left: 0px;
			                    width: 68px;
			                    height: 68px;
			                    border: #000 2px solid;
			                    box-sizing: content-box;
			                    background: url(../jssor-slider/img/t01.png) -800px -800px no-repeat;
			                    _background: none;
			                }

			                .jssort01 .pav .c {
			                    top: 2px;
			                    _top: 0px;
			                    left: 2px;
			                    _left: 0px;
			                    width: 68px;
			                    height: 68px;
			                    border: #000 0px solid;
			                    _border: #fff 2px solid;
			                    background-position: 50% 50%;
			                }

			                .jssort01 .p:hover .c {
			                    top: 0px;
			                    left: 0px;
			                    width: 70px;
			                    height: 70px;
			                    border: #fff 1px solid;
			                    background-position: 50% 50%;
			                }

			                .jssort01 .p.pdn .c {
			                    background-position: 50% 50%;
			                    width: 68px;
			                    height: 68px;
			                    border: #000 2px solid;
			                }

			                * html .jssort01 .c, * html .jssort01 .pdn .c, * html .jssort01 .pav .c {
			                    /* ie quirks mode adjust */
			                    width /**/: 72px;
			                    height /**/: 72px;
			                }
			        </style>

			        <!-- thumbnail navigator container -->
			        <div u="thumbnavigator" class="jssort01" style="left: 0px; bottom: 0px;">
			            <!-- Thumbnail Item Skin Begin -->
			            <div u="slides" style="cursor: default;">
			                <div u="prototype" class="p">
			                    <div class=w><div u="thumbnailtemplate" class="t"></div></div>
			                    <div class=c></div>
			                </div>
			            </div>
			            <!-- Thumbnail Item Skin End -->
			        </div>
			        <!--#endregion Thumbnail Navigator Skin End -->
			        <a style="display: none" href="http://www.jssor.com">Bootstrap Slider</a>
			    </div>
			    <!-- Jssor Slider End -->

			</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td background="../images/fundo-conteudo-baixo.jpg" style="background-repeat:no-repeat;" height="20">
		
	</td>
</tr>
<tr>
	<td height="5"></td>
</tr>
</table>
<?
require("rodape.php");
?>