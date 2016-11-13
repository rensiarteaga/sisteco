<?php
/**
 * Nombre:		  	    traspaso_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:42
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
var maestro={
		  id_siet_declara:<?php echo $id_siet_declara;?>//,
		  //tipo_declara:'<?php echo $tipo_declara;?>',
		  //periodo:'<?php echo $periodo;?>'
	    };
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_traspaso(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
//ContenedorPrincipal.getPagina(idContenedorPadre).pagina.setPagina(elemento);
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_traspaso.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:43
 */
function pagina_traspaso(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/interfaz_siet/ActionListarSietTraspasos.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_siet_traspaso',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_siet_traspaso',
		'id_siet_declara',
		'id_siet_cbte_origen',
		'id_siet_cbte_destion',
		 'nro_siet_cbte_origen',
		 'nro_siet_cbte_destino',
		 'nro_cuenta_bancaria_origen',
		 'nro_cuenta_bancaria_destino',
		'importe'
	]),remoteSort:true});
	
	/*function render_tc(value,cell,record,row,colum,store){
	 	if(record.data['variacion_tc'] != 1){
		   return  '<span style="color:red;">' +record.data['oficial']+'</span>'}	
	 	else{
	 		return  record.data['oficial']
		 	}
		
 	}*/

	//carga datos XML
	/*ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_siet_declara:maestro.id_siet_declara
		}
	});*/
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Periodo','algo'],['Tipo','nose']]}),cm:cmMaestro});
	gridMaestro.render();
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_siet_traspaso',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_traspaso'
	};
	 
// txt fecha
/*	vectorAtributos[1]= {
		validacion:{
			name:'fecha',
			fieldLabel:'Fecha',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPOCA.fecha',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha',
		id_grupo:1
	};
	
// txt hora
	vectorAtributos[2]= {
		validacion:{
			name:'hora',
			fieldLabel:'Hora',
			allowBlank:false,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPOCA.hora',
		save_as:'txt_hora',
		id_grupo:1
	};
	
// txt oficial
	vectorAtributos[3]= {
		validacion:{
			name:'oficial',
			fieldLabel:'Oficial',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :6,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			renderer:render_tc,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPOCA.oficial',
		save_as:'txt_oficial',
		id_grupo:0
	};
	
// txt compra
	vectorAtributos[4]= {
		validacion:{
			name:'compra',
			fieldLabel:'Compra',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :6,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPOCA.compra',
		save_as:'txt_compra',
		id_grupo:0
	};
	
// txt venta
	vectorAtributos[5]= {
		validacion:{
			name:'venta',
			fieldLabel:'Venta',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :6,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPOCA.venta',
		save_as:'txt_venta',
		id_grupo:0
	};
	
	// txt estado
	vectorAtributos[6]= {
			validacion: {
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : [['activo','activo'],['inactivo','inactivo'],['eliminado','eliminado']]
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60,		 // ancho de columna en el gris
			width:'80%'
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPOCA.estado',
		defecto:'activo',
		save_as:'txt_estado',
		id_grupo:2
	};


// txt observaciones
	vectorAtributos[7]= {
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'TIPOCA.observaciones',
		save_as:'txt_observaciones',
		id_grupo:2
	};
	
// txt id_moneda
	vectorAtributos[8] = {
		validacion:{
			name:'id_moneda',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_moneda,
		save_as:'txt_id_moneda'
	};
	
*/
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Monedas (Maestro)',
		titulo_detalle:'Tipo de Cambio (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_traspaso = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_traspaso.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_traspaso,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;

	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//--------- DEFINICIÓN DE FUNCIONES
	//datos necesarios para el filtro
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/traspaso/ActionEliminarTipoCambio.php',parametros:'&m_id_moneda=1'},
	Save:{url:direccion+'../../../control/traspaso/ActionGuardarTipoCambio.php',parametros:'&m_id_moneda=1'},
	ConfirmSave:{url:direccion+'../../../control/traspaso/ActionGuardarTipoCambio.php'},
	Formulario:{
			titulo:'Tipo de Cambio',
			html_apply:"dlgInfo-"+idContenedor,
			width:'25%',
			height:'40%',
			minWidth:100,
			minHeight:150,
			columnas:['95%'],
			closable:true,
			grupos:[
			{
				tituloGrupo:'Tipo Cambio',
				columna:0,
				id_grupo:0
			}
			]
		}
	};

	/*this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_siet_declara=datos.m_id_siet_declara;
		//maestro.nombre=datos.m_nombre;
		
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_siet_declara:maestro.id_siet_declara
			}
		});
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Moneda',maestro.id_siet_declara]]);
		//vectorAtributos[8].defecto=maestro.id_moneda;
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/traspaso/ActionEliminarTipoCambio.php',parametros:'&m_id_moneda='+maestro.id_moneda},
			Save:{url:direccion+'../../../control/traspaso/ActionGuardarTipoCambio.php',parametros:'&m_id_moneda='+maestro.id_moneda},
			ConfirmSave:{url:direccion+'../../../control/traspaso/ActionGuardarTipoCambio.php'},
			Formulario:{
				titulo:'Tipo de Cambio',
				html_apply:"dlgInfo-"+idContenedor,
				width:400,
				height:900,
				minWidth:100,
				minHeight:150,
				columnas:['95%'],
				closable:true,
				grupos:[
				{
					tituloGrupo:'Tipo Cambio',
					columna:0,
					id_grupo:0
				}
				]
			}
		};
		this.InitFunciones(paramFunciones)
	};*/
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

		
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
	//para iniciar eventos en el formulario
	for(i=0;i<vectorAtributos.length;i++)
		{
			
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
			
		}
		sm=getSelectionModel();
	}


	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_traspaso.getLayout();
	};



	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_traspaso.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}