<h2>Pago PSE - Place to Pay</h2>
<h2><?php echo (isset($responseReasonText)) ? $responseReasonText : ""; ?> </h2>
<a href="<?php echo (isset($bankURL)) ? $bankURL : ""; ?>">BankURL</a>

<div id="result" style="width: 100%;height: auto">
        <!-- Load pagina simuladora de Banco-->
</div>
<script type="text/javascript">
    document.getElementById("result").innerHTML='<object type="text/html" data="<?php echo $bankURL; ?>" ></object>';
    console.log("<?php echo $transactionID; ?>")
</script>

