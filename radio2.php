<!DOCTYPE html>
<html>
<head>
	<title>Rádio Brasileira</title>
	<link rel="icon" href="https://radio.exbrhbofc.net/assets/img/rbr_icon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="theme-color" content="#453D79">
	<meta name="keywords" content="exército brasileiro, fa-site, habbo, fansite, radio brasileira">
	<meta property="og:site_name" content="Rádio Brasileira">
	<meta property="og:locale" content="pt_BR"/>
	<meta property="og:type" content="website"/>
	<meta property="og:title" content="Rádio Brasileira"/>
	<meta property="og:description" content="Rádio Brasileira - Sintoniza aí!"/>
	<meta property="og:url" content="https://exbrhbofc.net/radio.php"/>
	<meta property="og:image" content="https://exbrhbofc.net/arquivos/2021/05/ogimage.png"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="https://exbrhbofc.net/css/rbr.css">
	<script src="https://kit.fontawesome.com/5db384e8a3.js" crossorigin="anonymous"></script>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
	<main>
		<img src="https://i.imgur.com/ITZcSUM.png" class="img_center">
		<div class="card-panel infos_radio" id="infos_radio" style="background:url(https://www.habbo.com.br/habbo-imaging/avatarimage?img_format=png&user=RadioBR&direction=2&head_direction=3&size=l&gesture=sml&action=std) left no-repeat, linear-gradient(152deg, rgb(57,73,171) 0%, rgb(26,35,126)), #1A237E;">
			<span id="locutor">RadioBR</span> na voz com o programa "<span id="locutor_programa">AutoDJ</span>".<br>
			<span id="num_ouvintes">0</span> ouvintes.
		</div>
		<div class="div_radio">
			<div class="wrapper_radio z-depth-3" id="radio">
				<div class="controles">
					<div class="marquee_wrapper">
						<marquee class="marquee" scrolldelay="200" truespeed="" id="marquee_radio"><span>Rádio Brasileira</span></marquee>
					</div>
					<div class="wrapper_btn_controles">
						<button class="button_controle waves-effect" id="btn_control" onclick="player()"><i id="icon_control" class="fas fa-play"></i></button>
						<button class="button_controle waves-effect"><i class="fas fa-volume-up"></i> <i class="fas fa-minus" onclick="abaixar()"></i> <i class="fas fa-plus" onclick="aumentar()"></i></button>
						<button class="button_controle waves-effect" id="btn_control" onclick="refresh_radio()"><i class="fas fa-sync"></i></button>
						<audio id="player_audio" data-radio="rbr" data-status="pausada" src="LINK_DA_TRANSMISSÃO"></audio>
					</div>
				</div>
			</div>
		</div>
	</main>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<script src="https://login.exbrhbofc.net/js/radio.js"></script>
	<script>
		M.AutoInit();
	</script>
	<script src="https://exbrhbofc.net/js/EasyAJAX.js"></script>
	<script>
		var success = function(response) {
			let data = JSON.parse(response);
			var status = data.status; // Mostra o status da rádio
			var porta = data.porta; // Mostra a porta da rádio
			var porta_dj = data.porta_dj; // Mostra a porta DJ da rádio
			var ip = data.ip; // Mostra o endereço do servidor da rádio
			var ouvintes_conectados = data.ouvintes_conectados; // Mostra total de ouvintes conectados
			var titulo = data.titulo; // Mostra o nome da rádio
			var plano_ouvintes = data.plano_ouvintes; // Mostra o limite de ouvintes do plano
			var plano_ftp = data.plano_ftp; // Mostra o limite de espaço do AutoDJ do plano
			var plano_bitrate = data.plano_bitrate; // Mostra o bitrate do plano
			var musica_atual = data.musica_atual; // Mostra a música atual
			var proxima_musica = data.proxima_musica; // Mostra a próxima música do AutoDJ(não é valido para transmissão ao vivo)
			var genero = data.genero; // Mostra o genero da rádio
			var shoutcast = data.shoutcast; // Mostra a URL do shoutcast
			var rtmp = data.rtmp; // Mostra a URl do RTMP para uso em players próprios(se tiver RTMP)
			var rtsp = data.rtsp; // Mostra a URl do RTSP para uso em players próprios(se tiver RTMP)
			var capa_musica = data.capa_musica; // Mostra a URL da imagem JPG da capa do album da música
			var locutor = data.locutor;
			var programa = data.programa;

			let marquee = document.querySelector("#marquee_radio");
			let locutor_html = document.querySelector("#locutor");
			let programa_html = document.querySelector("#locutor_programa");
			let ouvintes_html = document.querySelector("#num_ouvintes");
			let box_locutor = document.querySelector("#infos_radio");

			if (typeof musica_atual == 'object') {
				marquee.innerHTML = `Rádio Brasileira`;
			} else {
				marquee.innerHTML = `${titulo} - ${musica_atual}`;
			}

			locutor_html.innerHTML = locutor;
			programa_html.innerHTML = programa;
			ouvintes_html.innerHTML= ouvintes_conectados;
			box_locutor.style.background = `url(https://www.habbo.com.br/habbo-imaging/avatarimage?img_format=png&user=${locutor}&direction=2&head_direction=3&size=l&gesture=sml&action=std) left no-repeat, linear-gradient(152deg, rgb(57,73,171) 0%, rgb(26,35,126) 100%), #1A237E`;
		}
		var error = function() {

		}
		var funcao_radio = function () {
			let data = easyAJAX.GET('INSIRA_AQUI_API_COM_DADOS', success, error);
		}
		setInterval(funcao_radio, 2000);
		funcao_radio();
	</script>
</body>
</html>
