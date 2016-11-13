/* 
function main(){
	
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	//echo "var sw_vista='$sw_vista';";
	?>
	var paramConfig={TiempoEspera:10000};
	var elemento={pagina:new pagina_extracto_bancario(idContenedor,direccion,paramConfig,sw_vista),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}*/
<?php 
/**
 * Nombre:		  	    moneda_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:38
 *
 */
session_start();
?>
//<script>
//var paginaTipoActivo;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
	var fa;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_extracto_bancario(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_extracto_bancario(idContenedor, direccion, paramConfig, sw_vista) {
	var layout_extracto_bancario;
	var ContPes = 1;
	var vectorAtributos = new Array;
	var componentes=new Array();
	

	
	// ------------------ PARÁMETROS --------------------------//
	// ///DATA STORE////////////
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral','id_gestion'])
	});

	  var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},
			['id_cuenta_bancaria','id_institucion','desc_institucion'
			,'id_cuenta','desc_cuenta','id_auxiliar'
			,'desc_auxiliar','nro_cheque','estado_cuenta'
			,'nro_cuenta_banco','id_moneda','nombre_moneda','gestion'
			]),baseParams:{m_vista_cheque:'registro_cheque_conta'}});
	  function render_id_cuenta_bancaria(value, p, record){return String.format('{0}', record.data['nro_cuenta_banco']);}
		var tpl_id_cuenta_bancaria=new Ext.Template('<div class="search-item">'
			,'<b>Cuenta: </b><FONT COLOR="#B5A642">{nro_cuenta_banco}</FONT><br>',
			'<b>Banco: </b><FONT COLOR="#B5A642">{desc_institucion}</FONT><br>',
			'<b>Auxiliar: </b><FONT COLOR="#B5A642">{desc_auxiliar}</FONT><br>',
			'<b>Gestión: </b><FONT COLOR="#B5A642">{gestion}</FONT>','</div>');
		
		var ds_periodo_subsis = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/periodo/ActionListarPeriodo.php'}),
			reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_periodo',totalRecords: 'TotalCount'}, ['id_periodo','id_gestion','periodo','fecha_inicio','fecha_registro','fecha_final','periodo_lite'])
		});
		
	/*var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{sw_comboPresupuesto:'si'}
	});
	*/
	//ds_parametro.load();
	
	/*FUNCIONES RENDER*/
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro = new Ext.Template('<div class="search-item">','<b>{gestion_pres}</b><FONT COLOR="#B5A642"></FONT><br>','</div>');



	/*
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda']);}	
	var tpl_id_moneda = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
*/
	/////////////////////////'<FONT COLOR="#B5A642">CODIGO: {codigo_partida}</FONT><br>', '<FONT COLOR="#B5A642">NOMBRE: {nombre_partida}</FONT>',
	// Definición de datos //
	/////////////////////////  ['13','Comparativo'],   ,['12','Mensual - Inversión']
	vectorAtributos[0]={
			validacion:{
				name:'id_parametro',
				fieldLabel:'Gestión',
				allowBlank:false,			
				emptyText:'Gestión...',
				desc: 'gestion_pres', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_parametro,
				valueField: 'id_parametro',
				displayField: 'gestion_pres',
				queryParam: 'filterValue_0',
				filterCol:'GESTIO.gestion',
				typeAhead:true,
				tpl:tpl_id_parametro,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'50%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_parametro,
				width:200,
				disabled:false
			},
			tipo:'ComboBox',
			id_grupo:0,
			filterColValue:'PARAMP.gestion_pres',
			save_as:'id_parametro'
		};
	vectorAtributos[1]= {
			validacion: {
				name: 'id_periodo',
				fieldLabel:'Periodo',
				allowBlank:false,
				emptyText:'Periodo...',
				desc: 'periodo_lite',
				store:ds_periodo_subsis,
				valueField: 'id_periodo',
				displayField: 'periodo_lite',
				//filterCols:filterCols_periodo,
				//filterValues:filterValues_periodo,
				typeAhead:false,
				forceSelection:false,
				mode:'remote',
				queryDelay:200,
				pageSize:20,
				minListWidth:200,
				grow:true,
				width:200,
				minChars:1,
				triggerAction:'all',
				editable:true
			},
			tipo:'ComboBox',
			save_as:'id_periodo'
		};
			
	vectorAtributos[2]={
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
	/*var filterCols_periodo=new Array();
	var filterValues_periodo=new Array();
	filterCols_periodo[0]='PERIOD.id_gestion';
	filterValues_periodo[0]='x';*/
	
	vectorAtributos[3]= {
			validacion:{
				labelSeparator:'',
				name: 'nro_cuenta_banco',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'nro_cuenta_banco'
		};
	vectorAtributos[4]= {
			validacion:{
				labelSeparator:'',
				name: 'gestion',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'gestion'
		};
	vectorAtributos[5]= {
			validacion:{
				labelSeparator:'',
				name: 'periodo_lite',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'periodo_lite'
		};
	vectorAtributos[6] = {
			validacion:{
				name: 'txt_archivo',
				fieldLabel: 'Cargar Archivo',
				typeAhead: true,
				//vtype:"file",
				loadMask: true,
				inputType:'file',
				allowBlank: true,
				triggerAction: 'all',
				grid_visible:false, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:100 // ancho de columna en el grid
			},
			tipo:'Field',
			filtro_0:true
			
		
		};
		
	// ---------- FUNCIONES RENDER ---------------//
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : ''
	}
	// --------- INICIAMOS LAYOUT MAESTRO -----------//
	var config = {
		titulo_maestro :"Presupuesto"
	};
	layout_extracto_bancario = new DocsLayoutProceso(idContenedor);
	layout_extracto_bancario.init(config);
	
	// --------- INICIAMOS HERENCIA -----------//
	this.pagina = BaseParametrosReporte;
	this.pagina(paramConfig, vectorAtributos, layout_extracto_bancario, idContenedor);
	
	// --------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure = this.conexionFailure;
	var getComponente=this.getComponente;
	var CM_getDialog=this.getDialog;
	var CM_formulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente= this.mostrarComponente;
	
	// -------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios() {
		/*comp_sw_vista = ClaseMadre_getComponente('sw_vista');
		*/
		comp_id_parametro = ClaseMadre_getComponente('id_parametro');
		id_cuenta_bancaria = ClaseMadre_getComponente('id_cuenta_bancaria');
		id_parametro = ClaseMadre_getComponente('id_parametro');
		id_periodo = ClaseMadre_getComponente('id_periodo');
		nro_cuenta_banco = ClaseMadre_getComponente('nro_cuenta_banco');
		gestion = ClaseMadre_getComponente('gestion');
		periodo_lite = ClaseMadre_getComponente('periodo_lite');
		
		
		
		comp_id_parametro.on('select',f_evento_parametro);	
		id_cuenta_bancaria.on('select',f_evento_cuenta_bancaria);	
		id_periodo.on('select',f_evento_periodo);	
		id_parametro.on('select',f_evento_gestion);	
		
		componentes[0]=ClaseMadre_getComponente(vectorAtributos[0].validacion.name)
		componentes[1]=ClaseMadre_getComponente(vectorAtributos[1].validacion.name)
		componentes[2]=ClaseMadre_getComponente(vectorAtributos[2].validacion.name)
		componentes[3]=ClaseMadre_getComponente(vectorAtributos[3].validacion.name)
		componentes[4]=ClaseMadre_getComponente(vectorAtributos[4].validacion.name)
		componentes[5]=ClaseMadre_getComponente(vectorAtributos[5].validacion.name)
	
		//limpiar_componentes();
	}
	

	//}
/*	function f_evento_id_moneda(combo, record, index){comp_desc_moneda.setValue(record.data.nombre)}
	*/function f_evento_parametro(combo, record, index){
		//comp_desc_gestion.setValue(record.data.gestion_pres)
		var intGestion = record.data.gestion_pres;
		componentes[1].store.baseParams={id_gestion:record.data.id_gestion};
		componentes[1].modificado=true;
		componentes[1].setValue('');			
		componentes[1].setDisabled(false);	
		//actualiza periodo de acuerdo a la gestion
		
		componentes[2].store.baseParams={id_gestion:record.data.id_gestion,tipo_vista:'extracto_bancario'};
		componentes[2].modificado=true;
		componentes[2].setValue('');			
		componentes[2].setDisabled(false);	
		}
	function f_evento_cuenta_bancaria(combo, record, index){
		//comp_desc_gestion.setValue(record.data.gestion_pres)
		var nro_cuenta_banco1 = record.data.nro_cuenta_banco;
		//alert (nro_cuenta_banco1);
		
		nro_cuenta_banco.setValue(record.data.nro_cuenta_banco);

	}   
	function f_evento_periodo(combo, record, index){
			
		periodo_lite.setValue(record.data.periodo_lite);

	}
	function f_evento_gestion(combo, record, index){
		
		gestion.setValue(record.data.gestion_pres);

	}
	function obtenerTitulo() {
		var titulo = "EJECUCION PRESUPUESTARIA" + ContPes;
		ContPes++;
		return titulo
	}
	
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
			Formulario:{
				labelWidth: 75, //ancho del label
				abrir_pestana:true, //abrir pestana
				titulo_pestana:'Detalle de Extractos Bancarios',
				fileUpload:false,
				columnas:[305,305],
				grupos:[
				{	tituloGrupo:'Datos para ingresar Extractos Bancarios',
					columna:0,
					id_grupo:0
				}
				],
				parametros: '',
			submit:function (){	
				     
				        var data ='id_cuenta_bancaria='+id_cuenta_bancaria.getValue(); 	
				            data = data + ' &id_parametro='+id_parametro.getValue();
				            data= data + ' &id_periodo='+id_periodo.getValue();	
				            data= data + '&nro_cuenta_banco='+nro_cuenta_banco.getValue();
				            data= data + '&gestion='+gestion.getValue();
				            data= data + '&periodo_lite='+periodo_lite.getValue();
				          //  alert(data);
				            
						var mensaje="";
						if(id_cuenta_bancaria.getValue()==""){mensaje+=" Debe elegir una  cuenta bancaria";};
						if(mensaje=="")
						{
							
						      
		 		var ParamVentana={Ventana:{width:'100%',height:'70%'}}
					 layout_extracto_bancario.loadWindows(direccion+'../../../../sis_presupuesto/vista/extracto_bancario/extracto_bancario_det.php?'+data,'Detalle Extracto Bancario',ParamVentana);
				 }
			else{alert(mensaje);}
			}
				
			}
		}
	
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout', this.onResizePrimario)
}