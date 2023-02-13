showLoadingImage();
$(document).ready(function(){  
  /**  Configuracion de menu  **/
  // console.log("id_man = "+id_man);
  if($("#id_man").val() == 0){
    $('#idcontent').load('view/view_facturas.php',function(){
      cargarFacturas();
      hideLoadingImage();
    });
  }else{
    $('#idcontent').load('view/search.php',function(){
      busquedaFactura();
      $("#id_man2").val(id_man);
    });
  }


  // $('#idcontent').load('view/add_factura.php','',function(e){ add_factura();});
  $('.opciones').each(function(index, element) {
    $(this).click(function(e) {
      showLoadingImage();
      e.stopPropagation();
      $('#idcontent').empty();         
      if($(this).is(':not(.salir)')){
        $('.menu_option').removeClass('active');
        $('.main-sidebar').removeClass('open');
        var url = $(this).children('a.menu_option').attr('href');
        $(this).children('a.menu_option').addClass('active');  
        $('#idcontent').load(url,'',function(e){
          if (url=='view/view_facturas.php') {
            cargarFacturas();
          }
          if (url=='view/asignarPersona.php'){
            seleccionar_documentos_no_asignadas('Controller/buscarFacturaNoAsociadas.php');
          }
          if (url=='view/view_boletas.php') {
            seleccionar_documentos_no_asignadas('Controller/buscarBoletasNoAsociadas.php');
          }
          if (url=='view/view_transferencias.php'){
            seleccionar_documentos_no_asignadas('Controller/buscarTransferenciasNoAsociadas.php');
          }
          if (url=='view/view_arriendos.php') {
            seleccionar_documentos_no_asignadas('Controller/buscarArriendosNoAsociadas.php');
          }
          if (url=='view/view_basicos.php'){
            seleccionar_documentos_no_asignadas('Controller/buscarSBasicosNoAsociadas.php');
          }
          if (url=='view/view_comunes.php') {
            seleccionar_documentos_no_asignadas('Controller/buscarGComunesNoAsociadas.php');
          }
          if (url=='view/view_dev.php'){
            seleccionar_documentos_no_asignadas('Controller/buscarDevolucionesNoAsociadas.php');
          }
          if (url=='view/view_fondo_dev.php'){
            seleccionar_documentos_no_asignadas('Controller/buscardevolucionesfondofijo.php');
          }
          if (url=='view/ReasignarPersona.php'){
            documentos_para_reasignar();
          }
          if (url=='view/graficas.php'){
            newGrafico();
          } 
          if (url=='view/add_factura.php'){
            add_factura();
          }
          if (url=='view/search.php'){
            busquedaFactura();
          }
          if (url=='view/uploadExcel.php'){
            subirExcel();
          }
          if (url=='view/view_anticipos.php'){
            anticipos();
          }
          if (url=='view/factoring.php'){
            factoring();
          }
          if (url=='view/view_all.php'){
            misFacturas_all();
          }   
        });
        e.preventDefault();
      }else{
        window.close();        
      }      
    });    
  });

  /**  view menu grafico (Home)  **/
  function newGrafico(){
    $.post('controller/GraficosController.php',function(response){ 
      $('#enPLZ_m').text('$ '+response['enPlazo_m']);
      $('#porV_m').text('$ '+response['porVencer_m']);
      $('#ven_m').text('$ '+response['vencidas_m']);
      $('#enPLZ_c').text(response['enPlazo']);
      $('#porV_c').text(response['porVencer']);
      $('#ven_c').text(response['vencidas']);
      // Data Graficos
      var ubdData = {
        datasets: [{
          hoverBorderColor: '#ffffff',
          data: [response['enPlazo_cant'], response['porVencer_cant'], response['vencidas_cant']],
          backgroundColor: [
          'rgba(31,188,64,0.9)',
          'rgba(255,180,0,0.9)',
          'rgba(196,24,60,0.9)'
          ]
        }],
        labels: [" En Plazo", " Por Vencer", " Vencidas"]
      };

      var ubdData1 = {
        datasets: [{
          hoverBorderColor: '#ffffff',
          data: [response['enPlazo_monto'], response['porVencer_monto'], response['vencidas_monto']],
          backgroundColor: [
          // 'rgba(31,188,64,0.9)',
          'rgba(0,123,255,0.3)',
          'rgba(0,123,255,0.5)',
          'rgba(0,123,255,0.9)',
          // 'rgba(255,180,0,0.9)',
          // 'rgba(196,24,60,0.9)'
          ],
        }],
        labels: [" En Plazo", " Por Vencer", " Vencidas"]
      };

      // Options
      var ubdOptions = {
        legend: {
          position: 'bottom',
          labels: {
            padding: 25,
            boxWidth: 20
          },
        },
        title: {
          display: true,
          text: 'Total: '+response['total_F_cant']+' Facturas',
          fontSize: 18
        },
        cutoutPercentage: 50,
        // Uncomment the following line in order to disable the animations.
        // animation: false,
        tooltips: {
          custom: false,
          mode: 'index',
          position: 'nearest'
        }
      };

      var ubdOptions1 = {
        legend: {
          position: 'bottom',
          labels: {
            padding: 25,
            boxWidth: 20
          },
        },
        title: {
          display: true,
          fontSize: 18,
          text: 'Total: $ '+response['total_F_monto']
        },
        cutoutPercentage: 50,
        // Uncomment the following line in order to disable the animations.
        // animation: false,
        tooltips: {
          custom: false,
          mode: 'index',
          position: 'nearest'
        }
      };

      var ubdCtx = document.getElementsByClassName('blog-users-by-device')[0];
      var ubdCtx1 = document.getElementsByClassName('blog-users-by-device1')[0];

      // Generate the users by device chart.
      window.ubdChart = new Chart(ubdCtx, {
        type: 'doughnut',
        data: ubdData,
        options: ubdOptions
      });

      // Generate the users by device chart.
      window.ubdChart1 = new Chart(ubdCtx1, {
        type: 'doughnut',
        data: ubdData1,
        options: ubdOptions1
      });

      hideLoadingImage();

      var data1 = JSON.stringify(response['facturas']);    
      var params = {
        datos : data1
      };
      $('#divTableFactura').load('view/viewTableFacturas.php',params,function(e){
        var table = $('#TablaEnPLazo').DataTable({
          "pageLength": 50,
          "language": {
            "url": "assets/DataTables/lenguajeDatatable.js"
          }
        });

        $.fn.dataTable.ext.search.push(
          function( settings, data, dataIndex ) {
            var min = parseInt( $('#min').val(), 10 );
            var max = parseInt( $('#max').val(), 10 );
          var age = parseFloat( data[5] ) || 0; // use data for the age column
          if (( isNaN( min ) && isNaN( max )) || ( isNaN( min ) && age <= max ) || ( min <= age   && isNaN( max )) || ( min <= age   && age <= max )) {
            return true;
          }
          return false;
        }
        );
        $('.enPLZ').click(function(e){
          $('#min').val('');
          $('#max').val(19);
          table.draw();
        });

        $('.porV').click(function(e){
          $('#min').val(20);
          $('#max').val(29);
          table.draw();       
        });

        $('.ven_m').click(function(e){
          $('#min').val(30);
          $('#max').val('');
          table.draw();
        });
      });
    },'json');
  }

  /**  view menu add_factura  **/
  function add_factura(){

    $('#selectR').hide();
    $('#searchOC').click(function(e){
      if ($('#nOCP').val() != '') {
        $('#nRECP').val('');
        $('#yRECP').val('');
        SerachRC($('#nOCP').val(),1);
      }else{
        Swal.fire(
          'Error!',
          'Debe Ingresar un numero valido!',
          'warning'
          );
      }      
    });

    $('#searchR').click(function(e){
      if ($('#nRECP').val() != '' && $('#yRECP').val()) {
        $('#nOCP').val('');
        SerachRC($('#nRECP').val(),$('#yRECP').val());
      }else{
        Swal.fire(
          'Error!',
          'Debe llenar ambos Campos!',
          'warning'
          );
      }      
    });

    function SerachRC(data,anio){
      $('#selectR').empty();
      var numOCP = $('#nOCP').val();
      $.post("controller/BuscarRecepcionController.php",{id:data,year:anio},function(responseText){                              
        $('#selectR').load("view/tblRecepcion.php",{data : responseText},function(response){
          $('#selectR').show();  
          $('.btnaddRecp').each(function(){
            $(this).click(function(e){
              $('#id_recepcion').val($(this).siblings('.idRecepcion').val());
              $('#num_recepcion').val(data);
              $('#year_recepcion').val(anio);
              $('#num_fold').val($(this).siblings('.numFacturaOLD').val());
              $('#mdlAddFactura').modal('show');
            });
          });            
        });              
      },'json');
    }

    $('#saveFactura').click(function(event){
      event.preventDefault();
      var opt = {
        error: function() {
          Swal.fire(
            'Error!',
            'No se agrego la factura',
            'error'
            );
        },
        success: function(response){
          SerachRC($('#num_recepcion').val(),$('#year_recepcion').val());
          if (response) {
            Swal.fire(
              'Excelente!',
              'Modificación realizada exitosamente',
              'success'
              );
          }else{
            Swal.fire(
              'Error!',
              'No se agrego la factura',
              'error'
              );
          }

          $('#mdlAddFactura').modal('hide');
          $('#frmFact').trigger("reset");
        }
      }
      // console.log($('#proveedor').val()+' - '+$('#valor').val()+' - '+$('#fecfac').val()+' - '+$('#numfac').val());
      if ($('#proveedor').val() != '' && $('#valor').val() != '' && $('#fecfac').val() != '' && $('#numfac').val() != '') {

        $("#frmFact").ajaxSubmit(opt);

      }else{
        Swal.fire(
          'Error!',
          'Debe llenar Todos los Campos',
          'error'
          );
      }
    });

    hideLoadingImage();
  }

  function misFacturas_all(){
    var table = $('#TablaMisFacturas').DataTable({
      "pageLength": 50,
      "language": {
        "url": "assets/DataTables/lenguajeDatatable.js"
      }
    });
    hideLoadingImage();
  }

  /** funciones para el menu de mis facturas (view_factura)   **/
  function cargarFacturas(){

    var table = $('#TablaFacturas').DataTable({
      "pageLength": 25,
      "language": {
        "url": "assets/DataTables/lenguajeDatatable.js"
      }
    });  

    var table2 = $('#TablaFacturas_r').DataTable({
      "pageLength": 25,
      "language": {
        "url": "assets/DataTables/lenguajeDatatable.js"
      }
    }); 

    var table3 = $('#TablaFacturas_extra').DataTable({
      "pageLength": 25,
      "language": {
        "url": "assets/DataTables/lenguajeDatatable.js"
      }
    });

    var table4 = $('#TablaFacturas_factoring').DataTable({
      "pageLength": 25,
      "language": {
        "url": "assets/DataTables/lenguajeDatatable.js"
      }
    });

    $('#mdlFactura').on('hidden.bs.modal', function () {
      if ($('#dtestadofac').val() != 5) {
        $('#idcontent').empty();
        $('#idcontent').load('view/view_facturas.php','',function(e){
          cargarFacturas();
        });
      }
    });

    $('.chkTGR').click(function(e){
      var estado = 0;
      var doc = $(this).siblings('.idDocumento').val();
      if (this.checked) {
        estado = 1
      }
      $.post('controller/updateEstadoTGRFacturaController.php',{id:doc,est:estado},function(e){});
    });

    $('.chkR2').click(function(e){
      var estado = 'NULL';
      var doc = $(this).siblings('.idDocumento').val();
      var resp = $('#sessionRut').val();  
      var src = 'assets/img/chk0.png';
          // console.log(resp);
          // console.log(doc);  
            // jQuery.ajaxSetup({async:false});    
            if ($(this).attr('src') == 'assets/img/chk0.png') {
              if (resp == '18313287-3') {
                estado = 2;    
                src = 'assets/img/chkD.png'; 
              }else{
                estado = 1;    
                src = 'assets/img/chkA.png'; 
              }
            }
            // jQuery.ajaxSetup({async:true});
            console.log(estado);   
            $(this).attr('src', src);
            console.log(src);
            $.post('controller/updateChkR2FacturaController.php',{id:doc,est:estado},function(e){});
          });
    hideLoadingImage();
    metodosCargarFacturas();
  }

  /**  view menu search  **/
  function busquedaFactura(){ 
    $(".btnMasFact").click(function(e){
      var post = $(this).siblings('.idtipolistado').val();
      if( post == 2 ){
        var cols = [
          {"title": "N°"},
          {"title": "id"},
          {"title": "NUMERO"},
          {"title": "VALOR"},
          {"title": "RUT PROVEEDOR"},
          {"title": "PROVEEDOR"},
          {"title": "FECHA FACTURA"},
          {"title": "FECHA PAGO"},
          {"title": "ESTADO"},
        ]
      }else{
        var cols = [
          {"title": "N°"},
          {"title": "id"},
          {"title": "NUMERO"},
          {"title": "PROVEEDOR"},
          {"title": "OC PORTAL"},      
          {"title": "FECHA FACTURA"},
          {"title": "VALOR"},
          {"title": "ESTADO"},
          {"title": "ENCARGADO"}
        ];
      }

      if (post == 1) {
        cols.push({"title": "TIPO DOCUMENTO"});
      }

      if ( $.fn.DataTable.isDataTable('#tableSearch2') ) {
        $('#tableSearch2').DataTable().destroy();
      }
      $('#tableSearch2 thead').empty();
      $('#tableSearch2 tbody').empty();

      var t = $('#tableSearch2').DataTable({      
        "ajax": {
          "url": "Controller/buscarTodasFacturas.php",
          'data' : { 'data' : post },
          'type' : 'post'
        },
        "pageLength": 100,
        "columns": cols,
        createdRow: function(row, data, dataIndex, cells) {
          $(row).attr('id', data[1]);
        },
        "columnDefs":[
        {
          "targets": [ 1 ],
          "visible": false
        }
        ],
        "language": {
          "url": "assets/DataTables/lenguajeDatatable.js"
        }
      });
      $('#tableSearch2 tbody').on( 'click', 'tr', function () {
        modalDetalleFactura($(this).attr('id'),0);
        $(this).toggleClass('selected');
      });
    });
    hideLoadingImage();
  }

  /** Funciones para el menu subir excel de acepta Local**/
  function subirExcel(){
    // Agregue el siguiente código si desea que el nombre del archivo aparezca en seleccionar
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    $('#btnUpExcel').click(function(e){
      e.preventDefault();
      var opt = {
        error: function() {
          Swal.fire(
            'Error!',
            'No se agrego la factura',
            'error'
            );
        },
        success: function(response){
          hideLoadingImage();          
          if (response != 'false') {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'El archivo cargo exitosamente!',
              showConfirmButton: false,
              timer: 1500
            });
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'No se agregaron Documentos!',
            });
          }

          $('#loading-image').remove();
          $('#idcontent').empty();
          $('#idcontent').load('view/asignarPersona.php',function(e){
            seleccionar_documentos_no_asignadas('Controller/buscarFacturaNoAsociadas.php');
          });
        }
      }
      if ($('#customFile').val() != '') {
        showLoadingImage();
        $("#formUpExcel").ajaxSubmit(opt);    
      }else{
        Swal.fire(
          'Error!',
          'Debe seleccionar un archivo, para ser procesado.',
          'warning'
          );
      }
    });
    hideLoadingImage();
  }

  function anticipos(){

    var tabla1 = iniciarDataTable('tblAprovedores');
    var tabla2 = iniciarDataTable('tblFondoFijo');

    $('.nav-tabs a').on('shown.bs.tab', function(event){
      var referencia = $(event.target).attr("href"); 
      if(referencia == "#Aproveedores")
        tabla1.columns.adjust();
      if(referencia == "#fondoFijo")
        tabla2.columns.adjust();
    });

    function iniciarDataTable(id){
      var table = $('#'+id).DataTable({
        scrollX: true,
        "language": {
          "url": "assets/DataTables/lenguajeDatatable.js"
        }
      });
      return table;
    }

    $('.btnPagarAnticipo').click(function(e){
      $('#docto_id').val($(this).siblings('.idAnticipo').val());
      $('#docto_tipo').val($(this).siblings('.idTipoAnticipo').val());
      $('#docto_responsable').val($("#rutQuePaga").val());
      $('#ModalPagoAnticipo').modal('show');
       
    });
    $("#devolver_fondo").click(function(e){
      var id=$(".idAnticipo").val();

      Swal.fire({
        title: 'Motivo de Reversa',
        input: 'textarea',
        inputAttributes: {
          autocapitalize: 'off'
      },
      showCancelButton: true,
      confirmButtonText: 'Enviar',
      showLoaderOnConfirm: true,
      preConfirm: (login) => {
        var f=new FormData();
        f.append('id',id);
        f.append('motivo',login);
        f.append('estado',2);
        return $.ajax({   
          processData: false,
          contentType: false,
          cache: false,
          enctype: 'multipart/form-data',
          data:  f, //datos que se envian a traves de ajax
          url:   'controller/reversarfondofijo.php', //archivo que recibe la peticion
          method:  'post', //método de envio
          beforeSend: function () {
            $("#resultado").html("Procesando, espere por favor...");
          },
          success:  function (response) { 
            //location.reload();
          }
        });
      },
      allowOutsideClick: () => !Swal.isLoading()
      }).then((result) => {
        if (result.isConfirmed) {
          swal({
            title:'Exito',
            text:'Se Rechazo la solicitud ',
            icon:'success',
            button:'Ok!'
          }) 
        }
      })

    });

    $('#btnSendPagoAnticipo').click(function(e){
      e.preventDefault();
      var opt = {
        error: function() {
          Swal.fire(
            'Error!',
            'No se realizó el Pago',
            'error'
            );
        },
        success: function(response){
          hideLoadingImage();          
          if (response != 'false') {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'El pago se realizó exitosamente!',
              showConfirmButton: false,
              timer: 1500
            });
             location.reload();
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'No se agregaron Documentos!',
            });
          }
        }
      }

      if ($('#nsifgep').val() != '' && $('#input-b9').val() != '' && $('#fpagoAnt').val() != '' && $('#docto_id').val() != '') {
        $("#frmPagarAnticipo").ajaxSubmit(opt);
        $('#ModalPagoAnticipo').modal('hide');
      }else{
        Swal.fire(
          'Error!',
          'Debe llenar Todos los Campos',
          'error'
          );
      }
    });

    function recargarAnticipos(e){
      $('#idcontent').empty();
      $('#idcontent').load('view/view_anticipos.php','',function(e){
        anticipos();
      });
    }
    hideLoadingImage();
  }

  function factoring(){
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    $("#sendFactoring").click(function(e){
      e.preventDefault();
      var opt = {
        error: function() {
          hideLoadingImage();
          Swal.fire(
            'Error!',
            'No se realizó el ingreso',
            'error'
            );
        },
        success: function(response){
          hideLoadingImage();
          if (response = true) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'El factoring se agregó exitosamente!',
              showConfirmButton: false,
              timer: 2000
            });
            $("#factoring-form")[0].reset();
            $(".custom-file-label").addClass("selected").html('');
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'No se agregó el factoring!',
            });
          }
        }
      }
      if ($('#inputNumFAct').val() != '' && $('#frecep_fact').val() != '' && $('#inputMomFAct').val() != '' && $('#inputProvFAct').val() != '' && $('#fcedido').val() != '' && $('#cesionario').val() != '' && $('#customFile3').val() != '' && $('#nombreCesionario').val() != '') {
        showLoadingImage();        
        $("#factoring-form").ajaxSubmit(opt);        
      }else{
        Swal.fire(
          'Advertencia!',
          'Debe rellenar todos los campos, para ser procesado.',
          'warning'
          );
      }
    });
    hideLoadingImage();
  }

// END Document.ready
});

//metodos para detalle de factura
function metodosCargarFacturas(){
  // script for tab steps
  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e){
    var href = $(e.target).attr('href');
    var $curr = $(".process-model  a[href='" + href + "']").parent();
    $('.process-model li').removeClass();
    $curr.addClass("active");
    $curr.prevAll().addClass("visited");
  });

  //subir archivo
  $('#dtBtnAdjunto').click(function(event){
    event.preventDefault();
    var idFactura = $('#dtFacturaID').val();
    var files = $('#fileAdjuntoDoc').val();
    $('#adjuntosfactura').empty();
    var opt = {
      error: function() {
        Swal.fire(
          'Error!',
          'No se agrego ',
          'error'
          );
      },
      success: function(){
        $('#frm_adjunto_doc').trigger("reset");
         toastr.success('Archivo Adjunto subido.', 'Excelente!');
        $.post('controller/buscarAdjuntos.php',{id : idFactura},function(responseText){
          $('#adjuntosfactura').load("view/detalleAdjuntos.php",{data : responseText},function(response){          
          });
        },'JSON');
      }
    }
    if (idFactura != '' && files != '') {
        $("#frm_adjunto_doc").ajaxSubmit(opt);
    }
  });
  
  /** btnsEstados **/
  //Boton Rechazar
  $('#buttonRechazarEstado').click(function(e){
    var idf = $('#dtFacturaID').val();
    cambio_estado(idf, 6);
  });
  
  //boton Aceptar en Revision 1
  $('#buttonR1Estado').click(function(e){
    var idf = $('#dtFacturaID').val();
    cambio_estado(idf, 3);
  });

  //boton enviar a compra
  $('#buttonAcompraEstado').click(function(e){
    var idf = $('#dtFacturaID').val();
    if ($('#dtsigfeCpp').val() != '' && $('#dtOcp').val() != '') {
      if ($('#countRecepcionesAsoc').val() > 0) {
        cambio_estado(idf, 9);
      }else{
       Swal.fire({
        position: 'top-end',
        icon: 'warning',
        title: 'Debe Asociar una Recepción',
        showConfirmButton: false,
        timer: 1800
      });
     }
   }else{
     Swal.fire({
      position: 'top-end',
      icon: 'warning',
      title: 'Debe ingresar CPP sigfe! y N° Orden de Compra del Portal',
      showConfirmButton: false,
      timer: 1800
    });
   }
 });

  //boton Enviar a devengo
  $('#buttonR2Estado').click(function(e){
    var idf = $('#dtFacturaID').val();
    if ($('#dtsigfeCpp').val() != '') {
      if ($('#countRecepcionesAsoc').val() > 0) {
        cambio_estado(idf, 4);
      }else{
        Swal.fire({
          title: "No existe Recepción asociada!",
          text: "¿Está seguro de que desea devolver?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: "Sí, Devolver",
          cancelButtonText: "Cancelar",
        })
        .then(resultado => {
          if (resultado.value) {
            cambio_estado(idf, 2);
          } else {
            // Dijeron que no
            console.log("NO se Devuelve");
          }
        });
      }
    }else{
      Swal.fire({
        position: 'top-end',
        icon: 'warning',
        title: 'Debe ingresar CPP sigfe!',
        showConfirmButton: false,
        timer: 1800
      });
      $('#dtsigfeCpp').focus();
    }
  });

  //Boton Enviar a Pago
  $('#buttonDVEstado').click(function(e){
    var idf = $('#dtFacturaID').val();
    if ($('#dtsigfePago').val() !='' && $('#dtfechpago').val() != '') {
      if ($('#dtsigfeCpp').val() != '' && $('#dtsigfeDev').val() != '' && $('#dtsigfeComp').val() != ''){
        addLog_estado(idf, 5);
        cambio_estado(idf, 7);
      }else{
        Swal.fire({
          position: 'top-end',
          icon: 'warning',
          title: 'Debe ingresar todos los folios sigfe!',
          showConfirmButton: false,
          timer: 1800
        });
      }
    }else if ($('#dtsigfeDev').val() != '') {
      cambio_estado(idf, 5);
    }else{
      $('#dtsigfeDev').focus();
      Swal.fire({
        position: 'top-end',
        icon: 'warning',
        title: 'Debe ingresar folio sigfe!',
        showConfirmButton: false,
        timer: 1800
      });
    }
  });

  //Boton Pagar
  $('#buttonPagadoEstado').click(function(e){
    var idf = $('#dtFacturaID').val();
    if ($('#dtsigfePago').val() != '' && $('#dtfechpago').val() != '') {
      cambio_estado(idf, 7);
    }else{
      $('#dtsigfePago').focus();
      Swal.fire({
        position: 'top-end',
        icon: 'warning',
        title: 'Debe ingresar Fecha y N° Pago sigfe!',
        showConfirmButton: false,
        timer: 1800
      });
    }
  });
  //Boton Quitar de la bandeja
  $('#buttonQuitarEstado').click(function(e){  //este
    var idf = $('#dtFacturaID').val();
    if ($('#cant_nota_credito').val() > 0) {
      if ($('#countRecepcionesAsoc').val() > 0) {
        cambio_estado(idf, 8);
      }else{
        Swal.fire({
          title: "No existe Recepción asociada!",
          text: "¿Está seguro de que desea Anular?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: "Sí, Anular",
          cancelButtonText: "Cancelar",
        })
        .then(resultado => {
          if (resultado.value) {
            cambio_estado(idf, 8);
          } else {
            // Dijeron que no
            console.log("NO se Anula");
          }
        });
      }
    }else{
      Swal.fire({
        position: 'top-end',
        icon: 'warning',
        title: 'Debe asociar una Nota de Credito!',
        showConfirmButton: false,
        timer: 2000
      });
    }
  });

  //Boton Reversar
  $('#buttonReversarEstado').click(function(e){
    var idf = $('#dtFacturaID').val();
    var est = $('#dtFacturaEST').val()-1;

    Swal.fire({
      title: "Reversar Documento!",
      text: "¿Está seguro de que desea reversar?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: "Sí, Reversar",
      cancelButtonText: "Cancelar",
    })
    .then(resultado => {
      if (resultado.value) {
        cambio_estado(idf, est, 1);
      } else {
        // Dijeron que no
        console.log("NO se Reversa");
      }
    });  //este
  });
  /** </>btnsEstados **/

  // Actualiza la factura
  $('#btnUpdateDTFactura').click(function(e){
    e.preventDefault();
    var ep = null;
    if($('#extraPresup').prop('checked')) {
      ep = 1;
    }
    var params = {
      id : $('#dtFacturaID').val(),
      num : $('#dtnumfac').val(),
      monto: $('#dtvalor').val(),
      ffac: $('#dtfecfac').val(),
      fpago: $('#dtfechpago').val(),
      sigfecpp : $('#dtsigfeCpp').val(),
      sigfeDev : $('#dtsigfeDev').val(),
      sigfePago : $('#dtsigfePago').val(),
      sigfeComp : $('#dtsigfecomp').val(),
      FRfac: $('#dtfecRec').val(),
      ocp : $('#dtOcp').val(),        
      link : $('#dtLink').val(),
      extra: ep              
    }
    console.log(params);
    $.post('controller/updateFacturaController.php',params,function(response){
      toastr.success('Factura Actualizada.', 'Excelente!');
    });
  });

  /** Cambio de estados Facturas**/
  function cambio_estado(idf, est, rev){
    showLoadingImage();
    jQuery.ajaxSetup({async:false});
    $('#btnUpdateDTFactura').click();
    jQuery.ajaxSetup({async:true});
    $.post('controller/updateEstadoFacturaController.php',{id : idf, estado:est, reversar:rev},function(responseText){
      hideLoadingImage();
      $('#mdlFactura').modal('hide');
    });
  }

  function addLog_estado(id, estado){
    $.post('controller/addLogDocumento.php',{idf : id, est:estado},function(responseText){
    });
  }

}

// Cargar facturas no asignadas
function seleccionar_documentos_no_asignadas(urlData){

  hideLoadingImage();
  var urlControlador = urlData;
  var t = $('#tblAsignfac').DataTable({
    "ajax": {
      "url": urlControlador,
    },
    createdRow: function(row, data, dataIndex, cells) {
      $(row).addClass('rowfacturaAsg');
      $(row).attr('id', data[1]);
    },
    "columnDefs":[
    {
      "targets": [ 1 ],
      "visible": false
    }
    ],
    "language": {
      "url": "assets/DataTables/lenguajeDatatable.js"
    },
    "fixedColumns": false,
    "paging": false
  });

  var sned = [];

  $('#tblAsignfac tbody').on( 'click', 'tr', function () {
    var indice = sned.indexOf($(this).attr('id')); // obtenemos el indice
    if (indice > -1) {
      sned.splice(indice, 1); // 1 es la cantidad de elemento a eliminar
    }else{
      sned.push($(this).attr('id'));
    }
    $(this).toggleClass('selected');
  });

  $('#arrFacturasASG').click( function () {
    if (sned.length > 0) {
      $("#mdlAsignar").modal('show');
    }
    // alert(t.rows('.selected').data().length +' row(s) selected');
  });

  $('#asg-btn').click(function(event){    
    showLoadingImage();
    var func = $("#func_select").val();
    $.post('controller/addAsignacionController.php',{data:sned,fun:func},function(responseText2){
      sned = [];
      $("#mdlAsignar").modal('hide');
      hideLoadingImage();
      $('#tblAsignfac').DataTable().ajax.url(urlControlador).load();
    });              
  });
}

// Cargar Documentos para reasignar
function documentos_para_reasignar(){

  var urlControlador = 'controller/buscarFacturaParaReasignar.php';
  var t = $('#tblAsignfac').DataTable({
    "ajax": {
      "url": urlControlador
    },
    createdRow: function(row, data, dataIndex, cells) {
      $(row).addClass('rowfacturaAsg');
      $(row).attr('id', data[1]);
    },
    "columnDefs":[
    {
      "targets": [ 1 ],
      "visible": false
    }
    ],
    "language": {
      "url": "assets/DataTables/lenguajeDatatable.js"
    },
    "fixedColumns": false,
    "paging": false
  });

  var sned = [];

  $('#tblAsignfac tbody').on( 'click', 'tr', function () {
    var indice = sned.indexOf($(this).attr('id')); // obtenemos el indice
    if (indice > -1) {
      sned.splice(indice, 1); // 1 es la cantidad de elemento a eliminar
    }else{
      sned.push($(this).attr('id'));
    }
    $(this).toggleClass('selected');
  });

  $('#arrFacturasASG').click( function () {
    if (sned.length > 0) {
      $("#mdlAsignar").modal('show');
    }
    // alert(t.rows('.selected').data().length +' row(s) selected');
  });

  $('#asg-btn').click(function(event){    
    showLoadingImage();
    var func = $("#func_select").val();
    $.post('controller/ReasignarMasivoController.php',{data:sned,fun:func},function(responseText2){
      sned = [];
      $("#mdlAsignar").modal('hide');
      hideLoadingImage();
      $('#tblAsignfac').DataTable().ajax.url(urlControlador).load();
    });              
  });
  hideLoadingImage();
}

/** Funcion para cargar las vista de facturas subidas por acepta**/
function cargarPlanillaAcepta(datos){
  $.post('controller/BuscarFacturaController.php',{data:datos},function(responseText){
    $('#idcontent').load('view/asignarPersona.php',{data:responseText});
  },'JSON');
}

/** Funcion para ejecutar el loader**/
function showLoadingImage() {
  $('#body').append('<div id="loading-image"></div>');
  $("#loading-image").animate({
    height: '100%', 
    opacity: '0.9',
    width: '100%'
  }, 800);
}

/** Funcion para quitar el loader**/
function hideLoadingImage() {
  $("#loading-image").animate({
    height: '0%', 
    opacity: '0.9',
    width: '0%'
  }, 1200);
}

//busqueda de Facturas por año
function cargarTablaBusqueda(anio){
  if ( $.fn.DataTable.isDataTable('#tableSearch') ) {
    $('#tableSearch').DataTable().destroy();
  }
  $('#tableSearch tbody').empty();
  var urlJSON = "facturas/"+anio+".txt";
  var tabla = $('#tableSearch').DataTable({
    'ajax':urlJSON,
    "pageLength": 100,
    "columns": [
    {"title": "FACTURA","data": "numero"},
    {"title": "PROVEEDOR","data": "prov"},
    {"title": "RECEPCIÓN","data": "recep"},
    {"title": "OT","data": "ot"},
    {"title": "CPP","data": "cpp"},
    {"title": "F. FACTURA","data": "ffac"},
    {"title": "F. PAGO","data": "fpago"},
    {"title": "MONTO","data": "monto"}
    ],
    'language': {
      'url': 'assets/DataTables/lenguajeDatatable.js'
    },
  });
}

//funciones para cargar datos en la modal con los detalles del documento (modalDetalleFactura)
function modalDetalleFactura(idf, est2){
  var id_man2=$("#id_man2").val();
  var idTabs;
  jQuery.ajaxSetup({async:false});
  $('.mtareas').each(function(e){
    if ($(this).hasClass('active')){
      idTabs = "#"+$(this).attr('id');
    }
  });
  jQuery.ajaxSetup({async:true});  
  // $('#dtsigfecomp').attr('readonly',true);
  $('.btnDelRecepAsoc').hide();
  $('#buttonRechazarEstado').hide();
  $('#buttonReversarEstado').hide();
  $('#buttonR1Estado').hide();
  $('#buttonAcompraEstado').hide();
  $('#buttonR2Estado').hide();
  $('#buttonDVEstado').hide();
  $('#buttonQuitarEstado').hide();
  $('#buttonPagadoEstado').hide();  

  if (est2 == 0) {
    $('#footerDetalleFactura').hide();
    $('#btnUpdateDTFactura').hide();
    $("#capaDCS").hide();

  }else{
    $('#footerDetalleFactura').show();
    $('#btnUpdateDTFactura').show();
    $("#capaDCS").show();
  }

  var idFactura = idf;  
  var provDetalle = "";
  var estadoFactura = "";

  jQuery.ajaxSetup({async:false});

  $('#buttonReasignar').click(function(e){
    $('#mdlAsignar2').modal('show');
  });

  $('#asg-btn2').click(function(e){
    showLoadingImage();
    var func2 = $("#func_select2").val();
    $.post('controller/ReasignarController.php',{data:idFactura,fun:func2},function(response){
      $("#mdlAsignar2").modal('hide');
      $('#mdlFactura').modal('hide');
      hideLoadingImage();
    });
  });

  $.post('controller/buscarFacturaController.php',{id : idFactura},function(responseText){
    // console.log(responseText);
    provDetalle = responseText.facturas[0].proveedor_rut;
    estadoFactura = responseText.facturas[0].docto_estado_id;

    if (responseText.facturas[0].docto_tipo_id == 1 || responseText.facturas[0].docto_tipo_id == 14 || responseText.facturas[0].docto_tipo_id == 5) {
      if(responseText.facturas[0].docto_estado_id == 2){
        $('#buttonRechazarEstado').show();
        $('#buttonR1Estado').show();          
      }
      if(responseText.facturas[0].docto_estado_id == 3){
        $('#buttonR2Estado').show();
        $('#buttonAcompraEstado').show();
        $('#buttonReversarEstado').show();        //este
      }
      if(responseText.facturas[0].docto_estado_id == 4){
        $('#buttonRechazarEstado').show();
        $('#buttonDVEstado').show();
        $('#buttonReversarEstado').show();

      }
    }else{
      if(responseText.facturas[0].docto_estado_id == 5){
        $('#buttonPagadoEstado').show();
        $('#buttonReversarEstado').show();        
      }else if(responseText.facturas[0].docto_estado_id == 6){
        $('#buttonQuitarEstado').show();
      } else{
        $('#buttonRechazarEstado').show();
        $('#buttonDVEstado').show();
        // $('#buttonReversarEstado').show();
      }
    }

    if(responseText.facturas[0].docto_estado_id == 5){
      $('#buttonPagadoEstado').show();
      $('#buttonReversarEstado').show();
    }
    if(responseText.facturas[0].docto_estado_id == 6){
      $('#buttonQuitarEstado').show();
      // $('#buttonReversarEstado').show();
    }

    $('#estadofctmodal').text(responseText.facturas[0].estado);
    console.log(responseText.facturas[0]);
    $('#dtFacturaID').val(idFactura);
    $('#dtFacturaEST').val(responseText.facturas[0].docto_estado_id);
    $('#datosFactura').load("view/detalleFactura.php",{data : responseText, estadoBtn : est2},function(response){

      $('#dtsigfePago').attr('disabled',true);
      $('#dtsigfeCpp').attr('disabled',true);
      $('#dtsigfecomp').attr('disabled', true);
      $('#capaDCS').hide();
    
      if (responseText.facturas[0].docto_tipo_id == 10) {        
        if (responseText.facturas[0].n_sigfe_pago != '') {
          $('#dtsigfePago').attr('disabled',false);
        }
        if (responseText.facturas[0].n_sigfe_compensatorio != '') {
          $('#dtsigfecomp').attr('disabled',false);
        }
      }

      if ($('#dtestadofac').val() == 3) {
        $('#dtnumfac').attr('disabled',true);
        $('#dtvalor').attr('disabled',true);
        $('#dtfecfac').attr('disabled',true);
        $('#dtfecRec').attr('disabled',true);
        $('#dtsigfeDev').attr('disabled',true);
        $('#dtsigfeCpp').attr('disabled',false);
      }
      if ($('#dtestadofac').val() == 5) {
        $('#dtnumfac').attr('disabled',true);
        $('#dtvalor').attr('disabled',true);
        $('#dtfecfac').attr('disabled',true);
        $('#dtfecRec').attr('disabled',true);
        $('#dtsigfeDev').attr('disabled',true);
        $('#dtsigfeCpp').attr('disabled',false);
        $('#dtsigfePago').attr('disabled',false);
      }

      $('#extraPresup').click(function(e){
        if($('#extraPresup').prop('checked')) {
          $('#dtsigfeDev').attr("disabled", true);
          $('#dtsigfeDev').val('NO APLICA');
          $('#dtsigfeDev').css("background-color", "#D7DBDD");
          $('#dtsigfeCpp').attr("disabled", true);
          $('#dtsigfeCpp').val('NO APLICA');
          $('#dtsigfeCpp').css("background-color", "#D7DBDD");
        }else{
          $('#dtsigfeDev').attr("disabled", false);
          $('#dtsigfeDev').val('');
          $('#dtsigfeDev').css("background-color", "white");
          $('#dtsigfeCpp').attr("disabled", false);
          $('#dtsigfeCpp').val('');
          $('#dtsigfeCpp').css("background-color", "white");
        }
      });
      
      $('#sinfoliosigfe').click(function(e){
        if($('#sinfoliosigfe').prop('checked')) {
          $('#dtsigfeDev').attr("disabled", true);
          $('#dtsigfeDev').val('NO APLICA');
          $('#dtsigfeDev').css("background-color", "#D7DBDD");
        }else{
          $('#dtsigfeDev').attr("disabled", false);
          $('#dtsigfeDev').val('');
          $('#dtsigfeDev').css("background-color", "white");
        }
      });
      $('#sinCppsigfe').click(function(e){
        if($('#sinCppsigfe').prop('checked')) {
          $('#dtsigfeCpp').attr("disabled", true);
          $('#dtsigfeCpp').val('NO APLICA');
          $('#dtsigfeCpp').css("background-color", "#D7DBDD");
        }else{
          $('#dtsigfeCpp').attr("disabled", false);
          $('#dtsigfeCpp').val('');
          $('#dtsigfeCpp').css("background-color", "white");
        }
      });
    });
  },'JSON');
  jQuery.ajaxSetup({async:true});
  cargarProductosEnModal(idFactura);    
  $.post('controller/buscarAdjuntos.php',{id : idFactura},function(responseText){
    $('#adjuntosfactura').load("view/detalleAdjuntos.php",{data : responseText},function(response){
       if(id_man2 == 1){
          $("#dtBtnAdjunto").hide();
       }
    });
  },'JSON');
  $.post('controller/buscarObservaciones.php',{id : idFactura},function(responseText){ 
    $('#observacionesFactura').load("view/detalleObservaciones.php",{data : responseText},function(response){
       if(id_man2 == 1){
        $("#btnAddObservacion").hide();
       }
    });
  },'JSON');
  var estadoTipo;
  $.post('controller/mostrarEstadosController.php',function(responseText2){
    estadoTipo = responseText2; 
  },'JSON');
  $.post('controller/buscarHistorialController.php',{id : idFactura},function(responseText){
    $('#historialF').load("view/detalleHistorial.php",{data : responseText, est : estadoTipo},function(response){          
    });
  },'JSON');
  $.post('controller/buscarAsociacionesController.php',{id : idFactura, proveedor: provDetalle},function(responseText){
    $('#asociarFacturas').load("view/detalleAsociar.php",{data : responseText},function(response){
       if(id_man2 == 1){
        $("#showRecepciones").hide();
        $("#showAnticipos").hide();
        $("#showDocumentos").hide();
       }
      if (est2 == 0) {
        $("#showRecepciones").hide();
        $("#showAnticipos").hide();
      }else{
        $("#showRecepciones").show();
        $("#showAnticipos").show();
      }
      if($("#id_man_modal").val() ==  1){     
       $(".btnAsocRecep").hide();
      }
      $('#tblrecepcion_asoc').DataTable({
        "pageLength": 10,
        "language": {
          "url": "assets/DataTables/lenguajeDatatable.js"
        }          
      });
      $('#tbldocumentos_asoc').DataTable({
        "pageLength": 10,
        "language": {
          "url": "assets/DataTables/lenguajeDatatable.js"
        }          
      });


      show_facturas_recepcion(idFactura,estadoFactura,id_man2);
      show_facturas_documentos(idFactura);
      show_anticipos_documentos(idFactura);

      $('#viewAllDocumentos').hide();
      $('#divAsociaciones').hide();
      $('#viewAllRecepciones').hide();
      $('#viewAllAnticipos').hide();
      $('#closedViewRecepciones').hide();

      $('#closedViewRecepciones').click(function(e){
        $('#divAsociaciones').hide();
      });

      $('#showRecepciones').click(function(e){
         if($("#id_man_modal").val() ==  1){    
          $(".btnAsocRecep").hide();
         }

        $('#viewAllDocumentos').hide();
        $('#divAsociaciones').show();
        $('#closedViewRecepciones').show();
        $('#viewAllRecepciones').show();
        $('#viewAllAnticipos').hide();
      });

      $('#showDocumentos').click(function(e){
        $('#viewAllRecepciones').hide();
        $('#viewAllAnticipos').hide();
        $('#divAsociaciones').show();
        $('#closedViewRecepciones').show();
        $('#viewAllDocumentos').show();
      });

      $('#showAnticipos').click(function(e){
        $('#viewAllRecepciones').hide();
        $('#viewAllAnticipos').show();
        $('#divAsociaciones').show();
        $('#closedViewRecepciones').show();
        $('#viewAllDocumentos').hide();
      });

      $('#btnAddObservacion').click(function(e){
        var obs = $('#dtTxtObservacion').val();
        var idFactura = $('#dtFacturaID').val();
        $('#observacionesFactura').empty();
        if (obs != '') {
          $.post('controller/insertarObservacionController.php',{observacion:obs,factura:idFactura},function(e){
            $.post('controller/buscarObservaciones.php',{id : idFactura},function(responseText){
             toastr.success('Observacion Creada.', 'Excelente!');
             $('#dtTxtObservacion').val('');
             $('#observacionesFactura').load("view/detalleObservaciones.php",{data : responseText},function(response){    
             });
           },'JSON');
          });
        }
      });

      $('.btnAsocRecep').each(function(e){
        $(this).click(function(event){
          var rc = $(this).siblings('.idRecepcionAsoc').val();
          var i = $('#idDetalleFacturaAsoc').val();          
          $.post('controller/addRecepcionAsoc.php',{idf:i,recp:rc},function(response){
            show_facturas_recepcion(i);
            cargarProductosEnModal(i);
            $('#adjuntosfactura').empty();
            $.post('controller/buscarAdjuntos.php',{id : idFactura},function(responseText){
              $('#adjuntosfactura').load("view/detalleAdjuntos.php",{data : responseText},function(response){          
              });
            },'JSON');
          });
          $(this).parents('tr:first').remove();
        });
      }); 

      $('.btnAsocDocumento').each(function(e){
        $(this).click(function(event){
          var dc = $(this).siblings('.idDOCTOAsoc').val();
          var i = $('#idDetalleFacturaAsoc').val();
          $.post('controller/addDocumentoAsoc.php',{idf:i,doc:dc},function(response){
            show_facturas_documentos(i);
          });
          $(this).parents('tr:first').remove();          
        });
      });

      $('.btnAsocAnticipo').each(function(e){
        $(this).click(function(event){
          var dc = $(this).siblings('.idAnticipoAsoc').val();
          var sgp = $(this).parent().siblings('.anticipoSPago').text();
          var fchp = $(this).parent().siblings('.anticipoFPago').text();          
          var i = $('#idDetalleFacturaAsoc').val();
          $.post('controller/addAnticipoAsoc.php',{idf:i,doc:dc},function(response){
            $('#dtsigfePago').val(sgp);
            $('#dtfechpago').val(fchp);
            $('#dtsigfecomp').attr("disabled", false);
            $('#dtsigfePago').attr('readonly',true);
            $('#dtfechpago').attr('readonly',true);
            $('#btnUpdateDTFactura').click();
            show_anticipos_documentos(i);
          });
          $(this).parents('tr:first').remove();          
        });
      });          
    });
  },'JSON');
  $('.process-model li').removeClass();
  $('.process-model a').removeClass();
  $('.tab-pane').removeClass("active");            
  $(".process-model  a[href='#discover']").parent('li').addClass("active"); 
  $(".process-model  a[href='#discover']").addClass("active"); 
  $('#discover').addClass("active");
  $(idTabs).addClass("active");
  $('#mdlFactura').modal('show');
}



// Funcion para cargar las recepciones disponibles para asociar a un documento por proveedor
function show_facturas_recepcion(idFactura,est,man){
  $.post('controller/buscarRecepcionesAsoc.php',{id : idFactura},function(responseText){
    // console.log(responseText);
    if (responseText != null) {
      $('#capaDCS').show();
      $('#detalleRecepciones').empty();
      $('#detalleRecepciones').load("view/viewRecepcionFacturas.php",{data : responseText},function(e){
        if (est != 3 || man == 1) {
          $(".btnDelRecepAsoc").hide();
        }
      });
    }    
  },'JSON');
} 

// Funcion para cargar las docuemntos disponibles para asociar a un documento por proveedor
function show_facturas_documentos(idFactura){
  $.post('controller/buscarDocumentosAsoc.php',{id : idFactura},function(responseText){
    $('#tblFacturaDoc').empty();
    $('#tblFacturaDoc').load("view/viewDocumentosFacturas.php",{data : responseText});
  },'JSON');
}

// Funcion para cargar las docuemntos disponibles para asociar a un documento por proveedor
function show_anticipos_documentos(idFactura){
  $.post('controller/buscarAnticiposAsoc.php',{id : idFactura},function(responseText){
    $('#tblAnticiposDoc').empty();
    $('#tblAnticiposDoc').load("view/viewDocumentosAnticipo.php",{data : responseText},function(e){
      console.log("anticipo = "+$('#cnAnticipo').val());
      if ($('#cnAnticipo').val() > 0) {
        $('#dtsigfecomp').attr("disabled", false);
      }
    });
  },'JSON');
}

function cargarProductosEnModal(idf){
  $.post('controller/showProductos.php',{id : idf},function(responseText){
    $('#productosFactura').load("view/detalleProductos.php",{data : responseText},function(response){          
    });
  },'JSON'); 
}

//eliminar recepcion asoc factura
function delete_asoc_recepcion(idr){
  var idFactura = $('#idDetalleFacturaAsoc').val();
  $.post('controller/delRecepcionAsoc.php',{idf : idFactura, recp: idr},function(){
    show_facturas_recepcion(idFactura);
    cargarProductosEnModal(idFactura); 
  });
}

//eliminar dOCUEMNTO asoc factura
function delete_asoc_documento(idd){
  var idFactura = $('#idDetalleFacturaAsoc').val();
  $.post('controller/delDocumentoAsoc.php',{idf : idFactura, doc: idd},function(){
    show_facturas_documentos(idFactura);
  });
}

//eliminar anticipo asoc factura
function delete_asoc_anticipo(idd){
  var idFactura = $('#idDetalleFacturaAsoc').val();
  $.post('controller/delAnticipoAsoc.php',{idf: idd},function(){
    $('#dtsigfePago').val('');
    $('#dtfechpago').val('');
    $('#dtsigfePago').attr('readonly',false);
    $('#dtfechpago').attr('readonly',false);
    $('#btnUpdateDTFactura').click();
    show_anticipos_documentos(idFactura);
  });
}

/**  La cantidad "A" no puede ser menor q "B" **/
function validarCantidad(cant, newCant){
  if (newCant > cant) {
    alert('La cantidad ingresada no es valida');
    return false;
  }
}

// Validacion de envio a pago
function estadoFactura5(idF){
  var idfac = idF;

  return estado
}

/**  Calcula dias entre fechas  **/
function CountDias(){
  if ($('#fecfac').val() != '') {
    var ffactura = $('#fecfac').val();
    Date.prototype.mes = function() {
      var m = this.getMonth() + 1; // getMonth() is zero-based
      return (m>9 ? '' : '0') + m;
    };
    var d = new Date();
    var dateFormat = d.getFullYear() + "-" + d.mes() + "-" + d.getDate();
    var aFecha1 = dateFormat.split('-');
    var aFecha2 = ffactura.split('-');
    var fFecha1 = Date.UTC(aFecha1[0],aFecha1[1]-1,aFecha1[2]);
    var fFecha2 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha2[2]);
    var dif = fFecha1 - fFecha2;
    var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
    $('#dias').val(dias);
    if (dias >= 30) {
      $('#statusFactura').val('Vencida');
      $('#statusFactura').removeClass('is-valid',true);
      $('#statusFactura').addClass('is-invalid',true);      
    }else if(dias < 30 && dias > 25){
      $('#statusFactura').val('Proxima a vencer');
      $('#statusFactura').removeClass('is-valid',true);
      $('#statusFactura').removeClass('is-invalid',true);
    }else{
      $('#statusFactura').val('En plazo');
      $('#statusFactura').removeClass('is-invalid',true); 
      $('#statusFactura').addClass('is-valid',true);
    }
  }
}

function addCommas() { 
  var nStr = $('#dtvalor').val();
  nStr += '';
  x = nStr.split('.');
  x1 = x[0];
  x2 = x.length > 1 ? '.' + x[1] : '';
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1)) { 
    x1 = x1.replace(rgx, '$1' + ',' + '$2');
  } 
  return x1 + x2; 
}

function vercpp(id){

   $.post('controller/VerCppController.php',{id:id},function(response){
   var c= stripquotes(response);

    console.log(c);
    if(c!= 0){
     
      
      window.open('../CPP?dato='+c,'_blank');
      


    }else{
      alertdulce('No existe documento para este numero de anticipo ','error');
    }
      
      
    });

}
function stripquotes(a) {
    if (a.charAt(0) === '"' && a.charAt(a.length-1) === '"') {
        return a.substr(1, a.length-2);
    }
    return a;
}
function alertdulce(text,icono){

  Swal.fire({
    icon: icono,
    title: 'Oops...',
    text: text,

  })
}
function agregarcuenta(id,id3){
  $("#tituloan").text('Agregar Cuenta Contable N°'+id);
  $("#anti_cc").val(id3);
  $("#cc_n").hide();
  $("#cc_i").hide();
  $("#cc_b").hide();
  $.get('controller/vercuentacontableController.php',function(response){  
  console.log(jQuery.parseJSON(response));
  var response1=jQuery.parseJSON(response);
  
    var select = document.getElementById('selectorcuenta');
    for (var i = 0; i<response1.length; i++){
    
      $(".selectpicker").append('<option value="'+response1[i].id+'">'+response1[i].cuenta+'</option>');
     
      $(".selectpicker").selectpicker("refresh");
      
    }

  });

  $("#modal_agregar_cuenta").modal('show');
  $(".selectpicker").selectpicker();

}
function updatecuenta(id,id2){
  $.post('controller/updatecuentaController.php',{cuenta:id,anticipo:id2},function(response){  
         console.log('insertar',response);
          $("#modal_agregar_cuenta").modal('hide');
         location.reload();
         
    });

}
function insertcuenta(id,anticipo){
$.post('controller/agregarcuentaController.php',{cuenta:id},function(response){  
         console.log('insertar',response);
         updatecuenta(response,anticipo);
         $("#modal_agregar_cuenta").modal('hide');
           
                 location.reload();

    });
}
  function iniciarDataTable2(id){
      var table = $('#tblFondoFijo').DataTable({
        scrollX: true,
        "language": {
          "url": "assets/DataTables/lenguajeDatatable.js"
        }
      });
      return table;
    }

function guardarcuenta(){
  var anticipo=$("#anti_cc").val();
  var cuenta=$("#selectorcuenta").val();

  if(cuenta == 0){
     var inp=$("#cc_i").val();
    if($("#cc_i").val().length == 0){
      return alertdulce('Debe ingresar una cuenta','error')

    }else{
      insertcuenta(inp,anticipo);
    }

  }else{
    updatecuenta(cuenta,anticipo);
  }


}



