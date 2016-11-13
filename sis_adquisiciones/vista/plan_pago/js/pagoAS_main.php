//<script>
function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>
var paramConfig={TiempoEspera:10000};
var maestro={ id_cotizacion:'<?php echo $m_id_cotizacion;?>',
				precio_total_adjudicado:'<?php echo $m_precio_total_adjudicado;?>',
				total_aa:'<?php echo $m_total_aa;?>',
				total_as:'<?php echo $m_total_as;?>'
              
             };
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={pagina:new PagoAS(idContenedor,direccion,paramConfig,maestro,idContenedorPadre),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);



function PagoAS(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array;
	var ContPes=1;
	var layout_pago;
	
	
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_cotizacion',
			inputType:'hidden'
		},
		tipo:'Field',
		defecto:maestro.id_cotizacion,
		save_as:'id_cotizacion'
	};

	Atributos[1]={
		validacion:{
			name:'precio_total_adjudicado',
			fieldLabel:'Total Adjudicado',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			disabled:true,
			width:'80%'
		},
		tipo:'NumberField',
		defecto:maestro.precio_total_adjudicado,
		save_as:'precio_total_adjudicado'
	};
	
	Atributos[2]={
		validacion:{
			name:'total_aa',
			fieldLabel:'Total Año Actual',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'80%'
		},
		tipo:'NumberField',
		defecto:maestro.total_aa,
		save_as:'total_aa'
	};

	
	
	Atributos[3]={
		validacion:{
			name:'total_as',
			fieldLabel:'Total Año Siguiente',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'80%'
		},
		tipo:'NumberField',
		defecto:maestro.total_as,
		save_as:'total_as'
	};
	

	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:"Pagos"};
	layout_pago=new DocsLayoutProceso(idContenedor,idContenedorPadre);
	layout_pago.init(config);
	//---------         INICIAMOS HERENCIA           -----------//
	this.pagina=BaseParametrosReporte;
	this.pagina(paramConfig,Atributos,layout_pago,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var CM_conexionFailure=this.conexionFailure;
	var CM_getComponente=this.getComponente;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_btnActualizar=this.btnActualizar;
	var CM_conexionFailure=this.conexionFailure;
	
	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo(){
		var titulo="Documentos "+ContPes;
		ContPes ++;
		return titulo
	}
	function retorno(resp){
		Ext.MessageBox.hide();
		_CP.getVentana(idContenedor).hide();

		var root = resp.responseXML.documentElement;
		var mensaje = root.getElementsByTagName('mensaje')[0].firstChild.nodeValue;

		Ext.Msg.show({
			title:'Estado',
			msg:mensaje,
			minWidth:300,
			maxWidth :1000,
			buttons: Ext.Msg.OK
		});
		_CP.getPagina(idContenedorPadre).pagina.btnActualizar()
	}
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //

	//Define el Action para guardar los datos
	var paramFunciones;
		
	paramFunciones={
			Formulario:{labelWidth:75,
			url:direccion+'../../../../sis_adquisiciones/control/plan_pago/ActionGuardarPagoAS.php',
			abrir_pestana:false,
			titulo_pestana:obtenerTitulo,
			fileUpload:false,
			success:retorno,
			columnas:['95%'],
			grupos:[{tituloGrupo:'Datos Pago',columna:0,id_grupo:0}],parametros:''}
		};
	

	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_cotizacion=datos.m_id_cotizacion;
		maestro.precio_total_adjudicado=datos.m_precio_total_adjudicado;
		maestro.total_aa=datos.m_total_aa;
		maestro.total_as=datos.m_total_as;
		txt_total.setValue(datos.m_precio_total_adjudicado);
		txt_total_aa.setValue(datos.m_total_aa);
		txt_total_as.setValue(datos.m_total_as);
		getComponente('id_cotizacion').setValue(datos.m_id_cotizacion);
		
		paramFunciones={
				Formulario:{labelWidth:75,
				url:direccion+'../../../../sis_adquisiciones/control/plan_pago/ActionGuardarPagoAS.php',
				abrir_pestana:false,
				titulo_pestana:obtenerTitulo,
				fileUpload:false,
				success:retorno,
				columnas:['95%'],
				grupos:[{tituloGrupo:'Datos Pago',columna:0,id_grupo:0}],parametros:''}
		};
	
		this.InitFunciones(paramFunciones)
	};


	//Para manejo de eventos
	function iniciarEventosFormularios(){
		CM_getComponente('precio_total_adjudicado').setValue(maestro.precio_total_adjudicado);
		CM_getComponente('id_cotizacion').setValue(maestro.id_cotizacion);
		CM_getComponente('total_aa').setValue(maestro.total_aa);
		CM_getComponente('total_as').setValue(maestro.total_as);
		txt_total_aa=CM_getComponente('total_aa');
		txt_total_as=CM_getComponente('total_as');
		txt_total=CM_getComponente('precio_total_adjudicado');
		
		var onTotal=function(e){
			txt_total_as.setValue(txt_total.getValue()-txt_total_aa.getValue());
		}
		
		var onTotalA=function(e){
			txt_total_aa.setValue(txt_total.getValue()-txt_total_as.getValue());
		}
		
		
		txt_total_aa.on('change',onTotal);
		txt_total_as.on('change',onTotalA);
	}



	_CP.getVentana(idContenedor).on('resize',this.onResizePrimario);


	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	//ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}