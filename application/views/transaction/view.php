<h2>Pago PSE - Place to Pay</h2>

<div class="tab-content">
	<div class="list-group">
	  <a href="#" class="list-group-item active">Transaccion: <?php echo $transactionID; ?></a>
	  <a href="#" class="list-group-item">Referencia: <?php echo $reference; ?></a>
	  <a href="#" class="list-group-item">Mensaje: <?php echo $responseReasonText; ?></a>	  
	  <?php if ($transactionState=="OK"){ ?>
		  <div class='alert alert-success fade in'>Estado: Aprobado</div>
	  <?php }else{ ?>
		 <div class='alert alert-danger fade in'>Estado: Fallido</div>
	  <?php } ?>	  
	</div>
</div>

