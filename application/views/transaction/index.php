<h2>Pago PSE - Place to Pay</h2>
<?php echo (isset($responseReasonText)) ? $responseReasonText : ""; ?>
<?php echo (isset($returnCode) && $returnCode=="FAILED") ? "<div class='alert alert-danger fade in'>Transaccion Fallida!</div>" : ""; ?>
<?php echo (isset($transactionState) && $transactionState=="OK") ? "<div class='alert alert-success fade in'>Transaccion Exitosa!</div>" : ""; ?>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist" id="myTab">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#paso1" role="tab">1. Datos del Banco</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#paso2" role="tab">2. Datos del Cliente</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#paso3" role="tab">3. Datos del Pago</a>
  </li>
</ul>
<?php include("application\libraries\departamentos.php"); //Array de departamentos de Colombia para el select ?>
<?php echo validation_errors(); //Mostramos errores si es el caso ?>
<?php echo form_open('transaction/create');  ?>
<!-- Pestaña 1 - Datos del Banco -->
<div class="tab-content">
  <div class="tab-pane active" id="paso1" role="tabpanel">    
      <div class="form-group">
        <label for="bankInterface">Tipo de interfaz del banco.</label>
        <select class="form-control" id="bankInterface" name="bankInterface">
          <option value="0">Persona</option>
          <option value="1">Empresa</option>
        </select>
      </div>
      <div class="form-group">
        <label for="bankCode">Banco con que desea realizar el pago.</label>
        <select class="form-control" id="bankCode" name="bankCode" >
        <?php echo $bankOptions ?>
		</select>
      </div>
      <hr>
      <div class="text-right">
          <input type="button" class="btn btn-primary" value="Siguiente>>" onclick="siguiente('paso2');">
      </div>            
  </div>
    <!-- Pestaña 2 - Datos del Cliente -->
  <div class="tab-pane" id="paso2" role="tabpanel">
    <div class="col-xs-12 col-md-12 col-centered box-content">
        <div class="row">
            <div class="form-group col-xs-12 col-sm-6">
                <label>Tipo de identificación</label>
                <div class="wrapper_select2">
                    <select name="documentType" id="documentType" class="form-control" >
                      <option value="CC">Cedula de ciudadania</option>
                      <option value="CE">Cedula de extranjeria</option>
                      <option value="TI">Tarjeta de identidad</option>
                      <option value="PPN">Pasaporte</option>
                      <option value="NIT">Número de identificación tributaria</option>
                      <option value="SSN">Social Security Number</option>
                    </select>
                </div>
            </div>
            <div class="form-group col-xs-12 col-sm-6">
                <label for="document">Número de identificación</label>
                <input type="text" class="form-control" id="document" name="document" placeholder="Número de Identificación" >
            </div>
        </div>
        <div class="row">
            <div class="form-group col-xs-12 col-sm-6">
                <label for="firstName">Nombres</label>
                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Nombre completo" >
            </div>
            <div class="form-group col-xs-12 col-sm-6">
                <label for="lastName">Apellidos</label>
                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Apellidos" >
            </div>
        </div>
        <div class="row">
            <div class="form-group col-xs-12 col-sm-6">
                <label>Compañia</label>
                <input type="text" class="form-control" id="company" name="company" placeholder="Compañia donde labora o representa" >
            </div>
            <div class="form-group col-xs-12 col-sm-6">
                <label>E-mail</label>
                <input type="text" class="form-control" id="emailAddress" name="emailAddress" placeholder="Correo electrónico" >
            </div>
        </div>
        <div class="row">
            <div class="form-group col-xs-12 col-sm-6">
                <label for="province">Departamento/Provincia</label>
                <select class="form-control" id="province" name="province" > 
                <?php 
                foreach($departamentos as $dpto) {             
                    echo '<option value="'.$dpto.'">'.$dpto.'</option>';                 
                } 
                ?> 
                </select> 
            </div>
            <div class="form-group col-xs-12 col-sm-6">
                <label for="city">Ciudad</label>
                <select class="form-control" id="city" name="city" > </select>
          </div>
        </div>        
        <div class="row">
            <div class="form-group col-xs-12 col-sm-12">
                <label>Dirección</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Dirección postal completa" >
            </div>
        </div>        
        <div class="row">
            <div class="form-group col-xs-12 col-sm-6">
                <label for="phone">Telf. Fijo</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Número de telefonía fija" >
            </div>
            <div class="form-group col-xs-12 col-sm-6">
                <label for="mobile">Telf. Celular</label>
                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Número de telefonía móvil o celular" 
                >
          </div>
        </div>
        <hr>
        <div class="row">
            <div class="btns">
                <div class="col-lg-12 col-md-12">
                    <div class="text-center btns clearfix">
                        <div class="col-xs-12 col-sm-6 text-left">
                            <input type="button" id="btnRegresar" formnovalidate="" class="btn btn-primary pull-left" role="button" value="<<Atras" onclick="siguiente('paso1')">
                        </div>
                        <div class="col-xs-12 col-sm-6 text-right">
                            <input type="button" id="btnVolverAlPago" class="btn btn-primary pull-right" role="button" value="Siguiente>>" onclick="siguiente('paso3');">
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </div>
  </div>
<!-- Pestaña 3 - Datos del Pago -->
  <div class="tab-pane" id="paso3" role="tabpanel">
    <div class="col-xs-12 col-md-12 col-centered box-content">
        <div class="row">
            <div class="form-group col-xs-12 col-sm-6">
                <label for="reference">Referencia</label>
                <input type="text" class="form-control" id="reference" name="reference" placeholder="Referencia única de pago" >
            </div>
            <div class="form-group col-xs-12 col-sm-6">
                <label for="description">Descripcion</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Descripcion o concepto del pago" >
            </div>
        </div>
        <div class="row">
            <div class="form-group col-xs-12 col-sm-6">
                <label for="totalAmount">Total del Pago</label>
                <input type="text" class="form-control" id="totalAmount" name="totalAmount" placeholder="Valor total a recaudar" >
            </div>
            <div class="form-group col-xs-12 col-sm-6">
                <label for="taxAmount">Total Impuesto</label>
                <input type="text" class="form-control" id="taxAmount" name="taxAmount" placeholder="Discriminación del impuesto aplicado" >
            </div>
        </div>
        <div class="row">
            <div class="form-group col-xs-12 col-sm-6">
                <label for="devolutionBase">Base</label>
                <input type="text" class="form-control" id="devolutionBase" name="devolutionBase" placeholder="Base de devolución para el impuesto" >
            </div>
            <div class="form-group col-xs-12 col-sm-6">
                <label for="tipAmount">Otros Montos</label>
                <input type="text" class="form-control" id="tipAmount" name="tipAmount" placeholder="Otros valores exentos de impuesto" >
            </div>
        </div>
		<div class="row">
            <div class="btns">
                <div class="col-lg-12 col-md-12">
                    <div class="text-center btns clearfix">
                        <div class="col-xs-12 col-sm-6 text-left">
                            <input type="button" id="btnRegresar" formnovalidate="" class="btn btn-primary pull-left" role="button" value="<<Atras" onclick="siguiente('paso1')">
                        </div>
                        <div class="col-xs-12 col-sm-6 text-right">
                            <input type="submit" id="btnVolverAlPago" class="btn btn-primary pull-right" role="button" value="Procesar Pago"">
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
  </div>  
</div>
</form>
