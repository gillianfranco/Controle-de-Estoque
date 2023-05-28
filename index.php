<?php 
	ob_start();
	require 'connection.php';
?>
<html lang="pt-br">
	<head>
		<meta charset="utf8">
		<title>Controle de Estoque</title>
		
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css">
	</head>
	
	<body>
		<div class="result"></div>
		<main>
			<ul class="menuLink">
				<li class="menuLinkStock">
					<a href="#home" class="btn_home"><i class="fa fa-home"></i> Home</a>
				</li>
				
				<li class="menuLinkStock">
					<a  href="#stockIn" class="btn_in"><i class="fa fa-sign-in-alt"></i> Entrada</a>
				</li>
				
				<li  class="menuLinkStock">
					<a  href="#stockOut" class="btn_out"><i class="fa fa-sign-out-alt"></i> Saída</a>
				</li>
				
				<li  class="menuLinkStock">
					<a  href="#stockBack" class="btn_back"><i class="fa fa-box-open"></i> Devolução</a>
				</li>
				
				<li  class="menuLinkStock">
					<a href="#stockSender" class="btn_sender"><i class="fa fa-boxes"></i> Expedição</a>
				</li>
			</ul>
			
			<article id="home">
				<h1><i class="fa fa-caret-right"></i> Home</h1>
				
				<section class="homeSearch">
					<p><i class="fa fa-search"></i> Pesquisar Nota Fiscal</p>
					
					<form method="post" id="formSearch">
						<input type="text" name="searchProduct" id="searchProduct">
						<button name="btnSearch" id="btnSearch"><i class="fa fa-search"></i> Pesquisar</button>
					</form>
					
					<h2><i class="fa fa-table"></i> Resultado da Busca:</h2>
					<table id="searchTable">
						<tr>
							<th>Nº OS</th>
							<th>Nota Fiscal</th>
							<th>Status</th>
							<th>Transportadora</th>
							<th>Recolhido</th>
							<th>Local</th>
						</tr>
						
						<tr>
							<td> <span id="tableOS"></span></td>
							<td> <span id="tableInvoice"></span></td>
							<td> <span id="tableStatus"></span></td>
							<td> <span id="tableOp"></span></td>
							<td> <span id="tableQuantity"></span></td>
							<td> <span id="tableLocal"></span></td>
						</tr>
					</table>
				</section>
			</article>
			
			<article id="stockIn">
				<?php
					$Read = $pdo->prepare("SELECT a.product_id, a.product_name, a.product_quantity, b.storage_id, b.product_id, b.storage_street, b.storage_local, b.storage_floor FROM products a INNER JOIN storage b ON (b.product_id = a.product_id)
					GROUP BY b.product_id");
					$Read->execute();
				?>
				<h1><i class="fa fa-caret-right"></i> Operação de Entrada</h1>
				
				<form method="post" id="formStockIn">
					
					<div class="divisor2">
						<label for="stockInProduct">Produto</label>
						<select name="stockInProduct" id="stockInProduct">
							<?php foreach($Read as $Show) :?>
							<option value="<?= strip_tags($Show['product_id'])?>"><?= strip_tags($Show['product_name'])?></option>
							<?php endforeach;?>
						</select>
					</div>
					
					<div class="divisor2">
						<label for="stockInInvoice">Nota Fiscal de Entrada</label>
						<input type="text" name="stockInInvoice" id="stockInInvoice" required>
					</div>
					
					<div class="divisor2">
						<label for="stockInQuantity">Quantidade</label>
						<input type="text" name="stockInQuantity" id="stockInQuantity" value="1">
					</div>
					
					<div class="divisor2">
						<label for="stockInStockToday">Estoque Atual</label>
						<input type="text" name="stockInStockToday" id="stockInStockToday" value="" placeholder="selecione um produto" readonly style="background-color: #ccc">
					</div>
					
					<div class="divisor2">
						<label for="stockInLocal">Localização</label>
						<input type="text" name="stockInLocal" id="stockInLocal" value="" placeholder="selecione um produto" readonly style="background-color: #ccc">
					</div>
					
					<div class="divisor2">
						<label for="stockInLocalZone">Prateleira</label>
						<input type="text" name="stockInLocalZone" id="stockInLocalZone" value="" placeholder="selecione um produto" readonly style="background-color: #ccc">
					</div>
					
					<div class="divisor2">
						<label for="stockInLocalZoneNumber">Andar/Nº</label>
						<input type="text" name="stockInLocalZoneNumber" id="stockInLocalZoneNumber" value="" placeholder="selecione um produto" readonly style="background-color: #ccc">
					</div>
					
					<div class="divisor2">
						<label for="stockInProvider">Fornecedor</label>
						<input type="hidden" name="stockInProvider" id="stockInProvider" value="" placeholder="selecione um produto" readonly style="background-color: #ccc">
						<input type="text" name="stockInProviderName" id="stockInProviderName" value="" placeholder="selecione um produto" readonly style="background-color: #ccc">
					</div>
					
					<div class="divisor2">
						<button name="btnStockIn" id="btnStockIn"><i class="fa fa-sync-alt"></i>  Atualizar Estoque</button>
						<a id='btnDelStockIn' title='Remover Este Registro' class='btn_delete' data-val="" data-id=""><i class='fa fa-trash-alt'></i></a>
					</div>
					<div class="clear"></div>
				</form>
			</article>
			
			<article id="stockOut">
				<?php
					$Read = $pdo->prepare("SELECT a.product_id, a.product_name, a.product_quantity, b.storage_id, b.product_id, b.storage_street, b.storage_local, b.storage_floor FROM products a INNER JOIN storage b ON (b.product_id = a.product_id)
					GROUP BY b.product_id");
					$Read->execute();
				?>

				<h1><i class="fa fa-caret-right"></i> Operação de Saída</h1>
				<form method="post" id="formStockOut">
					
					<div class="divisor2">
						<label for="stockOutProduct">Produto</label>
						<select name="stockOutProduct" id="stockOutProduct">
							<?php foreach($Read as $Show) :?>
							<option value="<?= strip_tags($Show['product_id'])?>"><?= strip_tags($Show['product_name'])?></option>
							<?php endforeach;?>
						</select>
					</div>
					
					<div class="divisor2">
						<label for="stockOutInvoice">Nota Fiscal de Saída</label>
						<input type="text" name="stockOutInvoice" id="stockOutInvoice" required>
					</div>
					
					<div class="divisor2">
						<label for="stockOutQuantity">Quantidade</label>
						<input type="text" name="stockOutQuantity" id="stockOutQuantity" value="1">
					</div>
					
					<div class="divisor2">
						<label for="stockOutStockToday">Estoque Atual</label>
						<input type="text" name="stockOutStockToday" id="stockOutStockToday" value="" placeholder="selecione um produto" readonly style="background-color: #ccc">
					</div>
					
					<div class="divisor2">
						<label for="stockOutLocal">Localização</label>
						<input type="text" name="stockOutLocal" id="stockOutLocal" value="" placeholder="selecione um produto" readonly style="background-color: #ccc">
					</div>
					
					<div class="divisor2">
						<label for="stockOutLocalZone">Prateleira</label>
						<input type="text" name="stockOutLocalZone" id="stockOutLocalZone" value="" placeholder="selecione um produto" readonly style="background-color: #ccc">
					</div>
					
					<div class="divisor2">
						<label for="stockOutLocalZoneNumber">Andar/Nº</label>
						<input type="text" name="stockOutLocalZoneNumber" id="stockOutLocalZoneNumber" value="" placeholder="selecione um produto" readonly style="background-color: #ccc">
					</div>
					
					<div class="divisor2">
						<label for="stockOutClient">Tipo de Operação</label>
						<select name="stockOutClient" id="stockOutClient">
							<option value="1">Ao Cliente</option>
							<option value="2">Devolver Fornecedor</option>
							<option value="3">Vencida/Avaria</option>
						</select>
					</div>
					
					<div class="divisor2">
						<button name="btnStockOut" id="btnStockOut"><i class="fa fa-sync-alt"></i>  Atualizar Estoque</button>
						<a id='btnDelStockOut' title='Remover Este Registro' class='btn_delete' data-val="" data-id=""><i class='fa fa-trash-alt'></i></a>
					</div>
					<div class="clear"></div>
				</form>
			</article>
			
			<article id="stockBack">
				<?php
					$Read = $pdo->prepare("SELECT a.product_id, a.product_name, a.product_quantity, b.storage_id, b.product_id, b.storage_street, b.storage_local, b.storage_floor FROM products a INNER JOIN storage b ON (b.product_id = a.product_id)
					GROUP BY b.product_id");
					$Read->execute();
				?>

				<h1><i class="fa fa-caret-right"></i> Operação de Devolução</h1>
				<form method="post" id="formStockBack">
					
					<div class="divisor2">
						<!-- Nota Fiscal de entrada: Quando o produto é devolvido e retorna para o almox.-->
						<!-- Nota Fiscal de saída: Quando produto é devolvido e retornará ao cliente-->
						<label for="stockBackInvoice">Nota Fiscal</label>
						<input type="text" name="stockBackInvoice" id="stockBackInvoice">
					</div>
					
					<div class="divisor2">
						<label for="stockBackProduct">Produto</label>
						<select name="stockBackProduct" id="stockBackProduct">
							<?php foreach($Read as $Show) :?>
							<option value="<?= strip_tags($Show['product_id'])?>"><?= strip_tags($Show['product_name'])?></option>
							<?php endforeach;?>
						</select>
					</div>
					
					<div class="divisor2">
						<label for="stockBackQuantity">Quantidade</label>
						<input type="text" name="stockBackQuantity" id="stockBackQuantity" value="1">
					</div>
					
					<div class="divisor2">
						<label for="stockBackStockToday">Estoque Atual</label>
						<input type="text" name="stockBackStockToday" id="stockBackStockToday" value=""  readonly style="background-color: #ccc">
					</div>
					
					<div class="divisor2">
					<?php
						$Read = $pdo->prepare("SELECT devolutiontype_id, devolutiontype_name FROM devolution_type");
						$Read->execute();
					?>

						<label for="stockBackLocal">Tipo de Devolução</label>
						<select name="stockBackLocal" id="stockBackLocal">
							<?php foreach($Read as $Show) :?>
							<option value="<?= strip_tags($Show['devolutiontype_id'])?>"><?= strip_tags($Show['devolutiontype_name'])?></option>
							<?php endforeach;?>
						</select>
					</div>
					
					<div class="divisor2">
						<?php
							$Read = $pdo->prepare("SELECT condition_id, condition_name FROM conditions");
							$Read->execute();
						?>

						<label for="stockBackProd">Estado do Produto</label>
						<select name="stockBackProd" id="stockBackProd">
							<?php foreach($Read as $Show) :?>
							<option value="<?= strip_tags($Show['condition_id'])?>"><?= strip_tags($Show['condition_name'])?></option>
							<?php endforeach;?>
						</select>
					</div>
					
					<div class="divisor2">
					<?php
						$Read = $pdo->prepare("SELECT client_id, client_name FROM client");
						$Read->execute();
					?>

						<label for="stockBackClient">Cliente</label>
						<select name="stockBackClient" id="stockBackClient">
							<?php foreach($Read as $Show) :?>
							<option value="<?= strip_tags($Show['client_id'])?>"><?= strip_tags($Show['client_name'])?></option>
							<?php endforeach;?>
						</select>
					</div>
					
					<div class="divisor2">
						<label for="stockBackRegister">Data de Devolução</label>
						<input type="date" name="stockBackRegister" id="stockBackRegister" required>
					</div>
					
					<div class="divisor2">
						<button name="btnStockBack" id="btnStockBack"><i class="fa fa-sync-alt"></i>  Registrar Devolução</button>
						<a id='btnDelBack' title='Remover Este Registro' class='btn_delete' data-val="" data-id=""><i class='fa fa-trash-alt'></i></a>
					</div>
					<div class="clear"></div>
				</form>
			</article>
			
			<article id="stockSender">
				<h1><i class="fa fa-caret-right"></i> Operação de Expedição</h1>
				<form method="post" id="formStockSender">
					
					<div class="divisor2">
						<label for="stockSenderInvoice">Nota Fiscal de Saída</label>
						<input type="text" name="stockSenderInvoice" id="stockSenderInvoice">
					</div>
					
					<div class="divisor2">
						<label for="stockSenderOS">Ordem de Serviço</label>
						<input type="text" name="stockSenderOS" id="stockSenderOS">
					</div>
					
					<div class="divisor2">
					<?php
						$Read = $pdo->prepare("SELECT Id, Name, Acronym FROM state ORDER BY Acronym ASC");
						$Read->execute();
					?>

						<label for="stockSenderState">UF</label>
						<select name="stockSenderState" id="stockSenderState">
							<?php foreach($Read as $Show) :?>
							<option value="<?= strip_tags($Show['Id'])?>"><?= strip_tags($Show['Acronym'])?></option>
							<?php endforeach;?>
						</select>
					</div>
					
					<div class="divisor2">
						
						<label for="stockSenderCity">Cidade</label>
						<!-- Pega o id durante a atualização de dados-->
						<input type="text" name="stockSenderCityId" id="stockSenderCityId" value="" style="display: none">
						
						<select name="stockSenderCity" id="stockSenderCity" readonly style="background-color: #ccc;">
							<option value="0">Selecione o UF</option>
						</select>
					</div>
					
					<div class="divisor2">
						<?php
							$Read = $pdo->prepare("SELECT shipping_id, shipping_name FROM shipping ORDER BY shipping_name ASC");
							$Read->execute();
						?>

						<label for="stockSenderTransp">Pedido Via</label>
						<select name="stockSenderTransp" id="stockSenderTransp">
							<?php foreach($Read as $Show) :?>
							<option value="<?= strip_tags($Show['shipping_id'])?>"><?= strip_tags($Show['shipping_name'])?></option>
							<?php endforeach;?>
						</select>
					</div>
					
					<div class="divisor2">
						<?php
							$Read = $pdo->prepare("SELECT status_id, status_name FROM status ORDER BY status_name ASC");
							$Read->execute();
						?>

						<label for="stockSenderStatus">Status da OS</label>
						<select name="stockSenderStatus" id="stockSenderStatus">
							<?php foreach($Read as $Show) :?>
							<option value="<?= strip_tags($Show['status_id'])?>"><?= strip_tags($Show['status_name'])?></option>
							<?php endforeach;?>
						</select>
					</div>
					
					<div class="divisor2">
						<?php
							$Read = $pdo->prepare("SELECT condition_id, condition_name FROM conditions");
							$Read->execute();
						?>

						<label for="stockSenderProd">Estado do Produto</label>
						<select name="stockSenderProd" id="stockSenderProd">
							<?php foreach($Read as $Show) :?>
							<option value="<?= strip_tags($Show['condition_id'])?>"><?= strip_tags($Show['condition_name'])?></option>
							<?php endforeach;?>
						</select>
					</div>
					
					<div class="divisor2">
						<label for="stockSenderRegister">Data do Recolhimento</label>
						<input type="date" name="stockSenderRegister" id="stockSenderRegister">
					</div>
					
					<div class="divisor2">
						<button name="btnStockSender" id="btnStockSender"><i class="fa fa-sync-alt"></i>  Registrar Expedição</button>
						<a id='btnDelSender' title='Remover Este Registro' class='btn_delete' data-val="" data-id=""><i class='fa fa-trash-alt'></i></a>
					</div>
					<div class="clear"></div>
				</form>
			</article>
		</main>
		
		<script src="js/jquery.js"></script>
		<script src="js/scripts.js"></script>
		<script src="Ajax/ajax.js"></script>
	</body>
</html>
<?php 
	ob_end_flush();
?>