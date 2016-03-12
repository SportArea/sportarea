<html>
	<head>
		<style type="text/css" media="all">
			body {
				font-family: Arial;
			}

			table tr td {
				border-bottom: solid #F5F5F5 1px;
				margin: 0px;
			}
		</style>
	</head>
	<body>
<?php
require_once dirname(__FILE__) .'/config.app.php';
require_once dirname(__FILE__) .'/config.requirements.php';
$list =	$_requirements;
?>
		<center>
			<table style="border: solid #3C7FB1 1px;">
				<thead style="background-color: #F5F5F5; font-weight: bold;">
					<tr>
						<td style="border: solid #3C7FB1 1px;">
							Mandatory requirements
						</td>
						<td style="border: solid #3C7FB1 1px;">
							Request
						</td>
						<td colspan="2" style="border: solid #3C7FB1 1px; text-align: center;">
							Current
						</td>
					</tr>
				</thead>
		<?php
			foreach($list['mandatory'] as $itemKey => $item):
				$trClass = ($itemKey%2 == 0) ? 'widefatBlueLight' : 'widefatBlueDark';
				?>
					<tr class="<?php echo $trClass?>" onmouseover="this.className='widefatBlueHover'" onmouseout="this.className='<?php echo $trClass?>'" align="left">
						<td>
							<?php echo $item['name'];?>
						</td>
						<td align="center"><?php echo $item['request'];?></td>
						<td align="center"><?php echo $item['current'];?></td>
						<td align="center">
						<?php
							switch ($item['type']):
								case 'phpVersion':
								case 'maxUploadSize':
								case 'maxExecutionTime':
								case 'maxInputTime':
								case 'memoryLimit':
									($item['current'] >= intval($item['request'])) ? $icon = 'accept' : $icon = 'cross';
									break;

								default:
									($item['current'] == $item['request']) ? $icon = 'accept' : $icon = 'cross';
							endswitch;
						?>
							<div style="width: 15px; height: 15px; background: #<?php echo ($icon == 'accept') ? '7CC745' : 'BE0910'?>">&nbsp;</div>
						</td>
					</tr>
				<?php
            endforeach;;

			if(is_array($list['optional']) AND count($list['optional']) > 0):
		?>

				<thead style="background-color: #F5F5F5; font-weight: bold;">
					<tr>
						<td colspan="4" style="border: solid #3C7FB1 1px;">
							Optional requirements
						</td>
					</tr>
				</thead>
		<?php
				foreach($list['optional'] as $itemKey => $item):
					$trClass = ($itemKey%2 == 0) ? 'widefatBlueLight' : 'widefatBlueDark';
					?>
						<tr class="<?php echo $trClass?>" onmouseover="this.className='widefatBlueHover'" onmouseout="this.className='<?php echo $trClass?>'" align="left">
							<td>
								<?php echo $item['name'];?>
							</td>
							<td align="center"><?php echo $item['request'];?></td>
							<td align="center"><?php echo $item['current'];?></td>
							<td align="center">
							<?php
								($item['current'] == 'true') ? $icon = 'accept' : $icon = 'cross';
							?>
								<div style="width: 15px; height: 15px; background: #<?php echo ($icon == 'accept') ? '7CC745' : 'BE0910'?>">&nbsp;</div>
							</td>
						</tr>
					<?php
                endforeach;
			endif;
		?>

			</table>
		</center>
	</body>
</html>