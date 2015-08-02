<?php
require_once('vendor/autoload.php');

use Instagram\Classe\Instagram as Instagram;

$config = array(
    'client_id' => 'be000232443747b699ffaabbb05b9ae0',
    'client_secret' => '4e6ef1e5c70f47619d56dad1db4f4a3f',
    'redirect_uri' => 'http://localhost:8000/easy-instagram/'
);
try {
	Instagram::init($config);
}
catch (Exception $e) {
    echo $e->getMessage();
}

if ( isset($_GET['code']) ) {
	Instagram::getAccessToken($_GET['code']);

	$data = Instagram::getData();
	$id = $data['user']['id'];
}
?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			Instagram - API	
		</title>
		<link rel="stylesheet" type="text/css" href="Public/Css/Bootstrap.min.css">
	</head>
	<body>
		<div class="jumbotron" style="background-color:#5AA5E6; color:#fff;">
			<div class="container">
				<h1>Easy-Instagram</h1>
				<?php
					if (!isset($_GET['code'])) {
				?>
				<a class="btn btn-success btn-lg" href="<?php echo Instagram::getOauthUri(); ?>">Login with Insgatram</a>
				<?php
					}
				?>
			</div>
		</div>
		<div class="container">
			<?php
				if (!empty($data)) {
					$result = Instagram::recentMedia((int) $id, (int) 6);

					if (is_array($result['data'])) {
						foreach ($result['data'] as $key=>$value) {
							$image = $value['images']['low_resolution'];
							$title = $value['caption']['text'];
							
						?>
						<div class="col-md-4">
							<div class="thumbnail">
								<img src="<?php echo $image['url'] ?>" title="<?php echo $title;?>">
								<div class="caption">
									<h3>
									<?php
										echo $title;
									?>
									</h3>
								</div>
							</div>
						</div>
						<?php
						}
					}
					else
						echo "<div class='well'><b>Ops!</b> Desculpe ocorreu um erro.Tente novamente mais tarde!</div>";
				}
				else{
					?>
					<div class="well"><b>Please</b> enter Instagram</div>
					<?php
				}
			?>
		</div>
	</body>
</html>