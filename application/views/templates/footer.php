</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
  /*Click al seleccionar pestaña*/
  $('#myTab a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
  });
  /*Function para pasar de una pestaña otra  */
  var siguiente=function(pasoSiguiente){    
    var tab='#myTab a[href="#'+pasoSiguiente+'"]';
    $(tab).trigger('click');
  };
  /*Change al seleccionar departamento*/
  $('#province').change(function(){    
    var dpto=$(this).val();    
    $.ajax({
      url : '<?php echo base_url() ?>application/libraries/ciudades.php',
      data : { dpto : dpto },
      type : 'GET',
      success : function(response) {
          $('#city').html(response);
      },   
    });
  });

</script>
</html>     