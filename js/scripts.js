$(document).ready(function(){
	
	/*Disabled ENTER Submit Form*/
	$('input').keypress(function (e) {
        var code = null;
        code = (e.keyCode ? e.keyCode : e.which);                
        return (code == 13) ? false : true;
   });
   
   //Disabled input CITY
	//Só mostra quando apertar no option, e não select
   $('#stockSenderState option').click(function(){
	   $('#stockSenderCityId').hide();
	   $('#stockSenderCity').show();
   });
   
   //Disabled SELECT CITY
   $('#stockSenderInvoice').click(function(){
	   $('#stockSenderCity').hide();
	   $('#stockSenderCityId').show();
   });
   
	/*Modal Home*/
	$("#home").css('display', 'block');	

	/*Modal Open Stock Sender*/
	$(".btn_home").click(function(){
		$("#home").fadeIn(40);	
		$("#stockSender, #stockIn, #stockOut, #stockBack").fadeOut(30);	
	});
	
	/*Modal Open Stock In*/
	$(".btn_in").click(function(){
		$("#stockIn").fadeIn(40);	
		$("#home, #stockOut, #stockBack, #stockSender").fadeOut(30);	
	});
	
	/*Modal Open Stock Out*/
	$(".btn_out").click(function(){
		$("#stockOut").fadeIn(40);	
		$("#home, #stockIn, #stockBack, #stockSender").fadeOut(30);	
	});
	
	/*Modal Open Stock Back*/
	$(".btn_back").click(function(){
		$("#stockBack").fadeIn(40);	
		$("#home, #stockIn, #stockOut, #stockSender").fadeOut(30);	
	});
	
	/*Modal Open Stock Sender*/
	$(".btn_sender").click(function(){
		$("#stockSender").fadeIn(40);	
		$("#home, #stockIn, #stockOut, #stockBack").fadeOut(30);	
	});
	
	/* Select option - StockIn */
	$("#stockInProduct").click(function(e){
		e.preventDefault();
		var option = document.getElementById("stockInProduct").value;
		var url = 'ajax/stock/StockIn.php?val='+option;
		$.ajax({
			url : url,
			type: 'POST',
			data: option,
			dataType: 'JSON',
			
			success: function (data, textStatus, jqXHR){
				  $("#stockInStockToday, #stockInLocal, #stockInLocalZoneNumber, #stockInLocalZone, #stockInProvider").val();
				  $("#stockInStockToday").val(data['stock']);
				  $("#stockInLocal").val(data['street']);
				  $("#stockInLocalZone").val(data['floor']);
				  $("#stockInLocalZoneNumber").val(data['local']);
				  $("#stockInProvider").val(data['providerId']);
				  $("#stockInProviderName").val(data['providerName']);
			}
		});
		
	});
	
	/* Select option - StockOut */
	$("#stockOutProduct").click(function(e){
		e.preventDefault();
		var option = document.getElementById("stockOutProduct").value;
		var url = 'ajax/stock/StockOut.php?val='+option;
		$.ajax({
			url : url,
			type: 'POST',
			data: option,
			dataType: 'JSON',
			
			success: function (data, textStatus, jqXHR){
				  $("#stockOutStockToday, #stockOutLocal, #stockOutLocalZoneNumber, #stockOutLocalZone, #stockOutClient").val();
				  $("#stockOutStockToday").val(data['stock']);
				  $("#stockOutLocal").val(data['street']);
				  $("#stockOutLocalZone").val(data['floor']);
				  $("#stockOutLocalZoneNumber").val(data['local']);
				  $("#stockOutProvider").val(data['clientName']);
			}
		});
		
	});
	
	/* Select option - Devolution */
	$("#stockBackProduct").click(function(e){
		e.preventDefault();
		var option = document.getElementById("stockBackProduct").value;
		var url = 'ajax/stock/Devolution.php?val='+option;
		$.ajax({
			url : url,
			type: 'POST',
			data: option,
			dataType: 'JSON',
			
			success: function (data, textStatus, jqXHR){
				  $("#stockBackStockToday").val();
				  $("#stockBackStockToday").val(data['stock']);
			}
		});
		
	});
	
	/* Select option - Expedição */
	 $("#stockSenderState").click(function(e){
		e.preventDefault();
		
		var option = document.getElementById("stockSenderState").value;
		var url = 'ajax/stock/State.php?val='+option;
		
		var options = '';
		var data = '';
		
		$.ajax({
			url : url,
			type: 'POST',
			data: option,
			dataType: 'JSON',
			
			success: function (data, textStatus, jqXHR){
				var countData = data.length;
				
				//Limpa os dados anteriores
				$("#stockSenderCity").html("");
				
				for(a = 0; a < countData; a++){
					//Resgata dados do id da tabela city
					var idcity = data[a]['idcity'];
					
					//Resgata dados dos names da tabela city
					var names = data[a]['name'];
					
					//Criamos o options
					var options = ["<option value='"+idcity+"'>"+names+"</option>"];
					
					//Adicionamos o option pronto no select
					$('#stockSenderCity').append(options);
				}
				
			}
		});
	});
	
	
	/* Select option - NF StockIn  Atualizar Dados*/
	$("#stockInInvoice").change(function(e){
		e.preventDefault();
		var option = document.getElementById("stockInInvoice").value;
		var url = 'ajax/stock/StockInEdit.php?val='+option;
		$.ajax({
			url : url,
			type: 'POST',
			data: option,
			dataType: 'JSON',
			
			success: function (data, textStatus, jqXHR){
				if(data['status'] == 'error'){
					$(".result").text('');
                    $(".result").prepend('<div id="status-container" class="status-top-right text-center"><div class="status status-' + data['status'] + '"><div class="status-message"><span class="fa fa-times-circle"> ' + data['message'] + '</div></div></div>');
					
					setTimeout(function(){
						$("#status-container").hide();
						
					}, 3000);
				}else{
				  $("#stockInProduct, #stockInQuantity, #stockInStockToday, #stockInLocal, #stockInLocalZone").val();
				  $("#stockInProduct").val(data['stockInProduct']);
				  $("#stockInQuantity").val(data['stockInQuantity']);
				  $("#stockInStockToday").val(data['stockInStockToday']);
				  $("#stockInLocal").val(data['stockInLocal']);
				  $("#stockInLocalZone").val(data['stockInLocalZone']);
				  $("#stockInLocalZoneNumber").val(data['stockInLocalZoneNumber']);
				  $("#stockInProvider").val(data['stockInProvider']);
				  $("#stockInProviderName").val(data['stockInProviderName']);
				  $("#btnDelStockIn").attr("data-val",data['btnDelbtn_delete']);
				  $("#btnDelStockIn").attr("data-id",data['btnDelbtn_delete']);
				}
			}
		});
		
	});
	
	/* Select option - NF StockIOut  Atualizar Dados*/
	$("#stockOutInvoice").change(function(e){
		e.preventDefault();
		var option = document.getElementById("stockOutInvoice").value;
		var url = 'ajax/stock/StockOutEdit.php?val='+option;
		$.ajax({
			url : url,
			type: 'POST',
			data: option,
			dataType: 'JSON',
			
			success: function (data, textStatus, jqXHR){
				if(data['status'] == 'error'){
					$(".result").text('');
                    $(".result").prepend('<div id="status-container" class="status-top-right text-center"><div class="status status-' + data['status'] + '"><div class="status-message"><span class="fa fa-times-circle"> ' + data['message'] + '</div></div></div>');
					
					setTimeout(function(){
						$("#status-container").hide();
						
					}, 3000);
				}else{
				  $("#stockOutProduct, #stockOutQuantity, #stockOutStockToday, #stockOutLocal, #stockOutLocalZone").val();
				  $("#stockOutProduct").val(data['stockOutProduct']);
				  $("#stockOutQuantity").val(data['stockOutQuantity']);
				  $("#stockOutStockToday").val(data['stockOutStockToday']);
				  $("#stockOutLocal").val(data['stockOutLocal']);
				  $("#stockOutLocalZone").val(data['stockOutLocalZone']);
				  $("#stockOutLocalZoneNumber").val(data['stockOutLocalZoneNumber']);
				  $("#stockOutClient").val(data['stockOutClient']);
				  $("#btnDelStockOut").attr("data-val",data['btnDelbtn_delete']);
				  $("#btnDelStockOut").attr("data-id",data['btnDelbtn_delete']);
				}
			}
		});
		
	});
	
	/* Select option - NF Devolution Atualizar Dados*/
	$("#stockBackInvoice").change(function(e){
		e.preventDefault();
		var option = document.getElementById("stockBackInvoice").value;
		var url = 'ajax/stock/DevolutionEdit.php?val='+option;
		$.ajax({
			url : url,
			type: 'POST',
			data: option,
			dataType: 'JSON',
			
			success: function (data, textStatus, jqXHR){
				if(data['status'] == 'error'){
					$(".result").text('');
                    $(".result").prepend('<div id="status-container" class="status-top-right text-center"><div class="status status-' + data['status'] + '"><div class="status-message"><span class="fa fa-times-circle"> ' + data['message'] + '</div></div></div>');
					
					setTimeout(function(){
						$("#status-container").hide();
						
					}, 3000);
				}else{
				  $("#stockBackProduct, #stockBackQuantity, #stockBackRegister, #stockBackLocal, #stockBackProd").val();
				  $("#stockBackProduct").val(data['BackProduct']);
				  $("#stockBackQuantity").val(data['BackQuantity']);
				  $("#stockBackRegister").val(data['BackStockToday']);
				  $("#stockBackLocal").val(data['BackLocal']);
				  $("#stockBackProd").val(data['BackProd']);
				  $("#stockBackClient").val(data['BackClient']);
				  $("#stockBackStockToday").val(data['stock']);
				  $("#btnDelBack").attr("data-val",data['btnDelbtn_delete']);
				  $("#btnDelBack").attr("data-id",data['btnDelbtn_delete']);
				}
			}
		});
		
	});
	
	/* Select option - NF Expedition  Atualizar Dados*/
	$("#stockSenderInvoice").change(function(e){
		e.preventDefault();
		var option = document.getElementById("stockSenderInvoice").value;
		var url = 'ajax/stock/ExpeditionEdit.php?val='+option;
		$.ajax({
			url : url,
			type: 'POST',
			data: option,
			dataType: 'JSON',
			
			success: function (data, textStatus, jqXHR){
				if(data['status'] == 'error'){
					$(".result").text('');
                    $(".result").prepend('<div id="status-container" class="status-top-right text-center"><div class="status status-' + data['status'] + '"><div class="status-message"><span class="fa fa-times-circle"> ' + data['message'] + '</div></div></div>');
					
					setTimeout(function(){
						$("#status-container").hide();
						
					}, 3000);
				}else{
					
				  $("#stockSenderOS, #stockSenderState, #stockSenderCity, #stockSenderTransp, #stockSenderStatus").val();
				  $("#stockSenderOS").val(data['stockSenderOS']);
				  $("#stockSenderState").val(data['stockSenderState']);
				  $("#stockSenderCityId").val(data['stockSenderCity']);
				  $("#stockSenderTransp").val(data['stockSenderTransp']);
				  $("#stockSenderStatus").val(data['stockSenderStatus']);
				  $("#stockSenderProd").val(data['stockSenderProd']);
				  $("#stockSenderRegister").val(data['stockSenderRegister']);
				  $("#btnDelSender").attr("data-val",data['btnDelbtn_delete']);
				  $("#btnDelSender").attr("data-id",data['btnDelbtn_delete']);
				}
			}
		});
		
	});
	
	
});
