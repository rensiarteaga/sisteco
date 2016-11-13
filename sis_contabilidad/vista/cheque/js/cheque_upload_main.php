<?php
/**
 * Nombre:		  	    dato_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-08-19 10:28:40
 *
 */
session_start();
?>
//<script>
function main(){
	<?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion='$dir';";
	echo "var idContenedor='$idContenedor';";
	 echo "var idSub='$idSub';";
	?>
	var fa=false;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
	var pagina;
	var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:2,FiltroEstructura:false,FiltroAvanzado:fa,	idSub:decodeURI(idSub)};

	var maestro={
			id_transaccion:'<?php echo utf8_decode($m_id_transaccion);?>',
			desc_comprobante:'<?php echo utf8_decode($m_desc_comprobante);?>',
			concepto_tran:'<?php echo utf8_decode($m_concepto_tran);?>',
			desc_cuenta:'<?php echo utf8_decode($m_desc_cuenta);?>',
			desc_auxiliar:'<?php echo utf8_decode($m_desc_auxiliar);?>',
			desc_partida:'<?php echo utf8_decode($m_desc_partida);?>',
			id_moneda:'<?php echo utf8_decode($m_id_moneda);?>',
			id_cuenta:'<?php echo utf8_decode($m_id_cuenta);?>',
			id_auxiliar:'<?php echo utf8_decode($m_id_auxiliar);?>',
			desc_moneda:'<?php echo utf8_decode($m_desc_moneda);?>',
			tipo_plantilla:'<?php echo utf8_decode($m_tipo_plantilla);?>',
			desc_plantilla:'<?php echo utf8_decode($m_desc_plantilla);?>',
			importe_debe:'<?php echo utf8_decode($m_importe_debe);?>',
			importe_haber:'<?php echo utf8_decode($m_importe_haber);?>',
			fecha_trans:'<?php echo utf8_decode($m_fecha_trans);?>'

		};
	
	idContenedorPadre='<?php echo $idContenedorPadre;?>';
	var elemento={idContenedor:idContenedor,pagina:new pagina_cheque_upload(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
	_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:         
 * Propósito:    
 * Autor:    MZAMBRANA
 * Fecha creación:  25/08/2016
 */
function pagina_cheque_upload(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){ 
	var vectorAtributos=new Array;
	var Atributos=new Array;
	var componentes= new Array();


	 var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},
			['id_cuenta_bancaria','id_institucion','desc_institucion'
			,'id_cuenta','desc_cuenta','id_auxiliar'
			,'desc_auxiliar','nro_cheque','estado_cuenta'
			,'nro_cuenta_banco','id_moneda','nombre_moneda','gestion'
			]),baseParams:{m_vista_cheque:'registro_cheque_conta',m_id_cuenta:maestro.id_cuenta,m_id_auxiliar:maestro.id_auxiliar}});

		 function render_id_cuenta_bancaria(value, p, record){return String.format('{0}', record.data['nro_cuenta_banco']);}
		var tpl_id_cuenta_bancaria=new Ext.Template('<div class="search-item">'
			,'<b>Cuenta: </b><FONT COLOR="#B5A642">{nro_cuenta_banco}</FONT><br>',
			'<b>Banco: </b><FONT COLOR="#B5A642">{desc_institucion}</FONT><br>',
			'<b>Auxiliar: </b><FONT COLOR="#B5A642">{desc_auxiliar}</FONT><br>',
			'<b>Gestión: </b><FONT COLOR="#B5A642">{gestion}</FONT>','</div>');
		
	
	vectorAtributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_transaccion',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			defecto:maestro.id_transaccion,
			form: true,
			filtro_0:false,
			save_as:'id_transaccion'
		};

	vectorAtributos[1]={
			validacion:{
			name:'id_cuenta_bancaria',
			fieldLabel:'Cuenta Bancaria',
			allowBlank:false,			
			emptyText:'Cuenta Bancaria...',
			desc: 'nro_cuenta_banco', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cuenta_bancaria,
			valueField: 'id_cuenta_bancaria',
			displayField: 'nro_cuenta_banco',
			queryParam: 'filterValue_0',
			filterCol:'CUENTA.nro_cuenta#CUENTA.descripcion#CUEBAN.nro_cuenta_banco#INSTIT.nombre',
			typeAhead:false,
			tpl:tpl_id_cuenta_bancaria,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cuenta_bancaria,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CUENTA_8.nro_cuenta#CUENTA_8.descripcion##CUEBAN_8.nro_cuenta_banco',
		save_as:'id_cuenta_bancaria'
	};	
	
	vectorAtributos[2]={
		validacion:{
			name:'csv',
			fieldLabel:'Archivo CSV a subir',
			invalidText: 'Por favor seleccione un archivo',
			allowBlank:true,
			inputType:'file',   
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		save_as:'txt_csv',
		form:true
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){ return value ? value.dateFormat('d/m/Y') : ''; };

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config={ titulo_maestro:'Listar Documentos' };
	var layout_cheque_upload = new DocsLayoutProceso(idContenedor);
	layout_cheque_upload.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;

	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_cheque_upload,idContenedor);
	
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_getComponente = this.getComponente;
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	function obtenerTitulo(){
		var titulo = "Listar Documento"; return titulo; 
	}

	function retorno(resp,resp2,resp3,resp4){ console.log(resp);
		Ext.MessageBox.hide();
		var ventana = _CP.getVentana(idContenedor);
		ventana.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
			var root = resp.responseXML.documentElement;
			var mensaje =root.getElementsByTagName('mensaje')[0].firstChild.nodeValue;
			if (mensaje == "Se guardaron exitosamente todos los valores") {
				alert("Se guardaron exitosamente todos los valores");
			}else {
				Ext.Msg.alert('Status', mensaje);
			}
		}
	}

	function fallo(resp1,resp2,resp3,resp4){
		alert('Ocurrio un error'); 
	}
	console.log("ParamFunciones");
	//datos necesarios para el filtro
	var paramFunciones = {
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			height:70,
			url:direccion+'../../../control/cheque/ActionSubirCsvCheque.php?id_transaccion='+maestro.id_transaccion,
			abrir_pestana:false, //abrir pestana
			fileUpload:true,
			width:150,
			columnas:['90%'],
			minWidth:150,
			minHeight:100,
			closable:true,
			upload:true,
			success: retorno,
			failure: fallo,
			titulo:'Listar Documento',
			grupos:[{
				tituloGrupo:'Subir Archivo',
				columna:0,
				id_grupo:0
			}
		]}
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
		maestro.id_transaccion=datos.id_transaccion;
		maestro.id_cuenta=datos.id_cuenta;
		maestro.id_auxiliar=datos.id_auxiliar;
		
		ClaseMadre_getComponente('csv').reset();
		ClaseMadre_getComponente('id_cuenta_bancaria').reset();

		ClaseMadre_getComponente('id_cuenta_bancaria').baseParams={m_vista_cheque:'registro_cheque_conta',m_id_cuenta:maestro.id_cuenta,m_id_auxiliar:maestro.id_auxiliar}

		ds_cuenta_bancaria.modificado=true;
		console.log('reload: '+maestro.id_cuenta+' <--> '+maestro.id_auxiliar);
		ClaseMadre_getComponente('id_transaccion').setValue(maestro.id_transaccion);
		paramFunciones.Formulario.url=direccion+'../../../control/cheque/ActionSubirCsvCheque.php';
		this.InitFunciones(paramFunciones);
	};

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		for (var i=0;i<vectorAtributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
		}
		
		console.log("Iniciar: "+maestro.id_cuenta+' <-:-> '+maestro.id_auxiliar);
		ClaseMadre_getComponente('id_transaccion').setValue(maestro.id_transaccion);
	
	}

	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	this.Init(); //iniciamos la clase madre
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}