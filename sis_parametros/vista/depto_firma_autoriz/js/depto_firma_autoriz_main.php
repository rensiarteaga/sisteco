<?php
/**
 * Nombre:		  	    depto_firma_autoriz_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				RCM
 * Fecha creación:		02/04/2009
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
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>	
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={id_depto:<?php echo $id_depto;?>,codigo_depto:decodeURIComponent('<?php echo $codigo_depto;?>'),nombre_depto:decodeURIComponent('<?php echo $nombre_depto;?>')};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_depto_firma_autoriz(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_departamentoUsuario.js
* Propï¿½sito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creaciï¿½n:		2009-01-23 11:04:02
*/
function pagina_depto_firma_autoriz(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depto_firma_autoriz/ActionListarDeptoFirmaAutoriz.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_depto_firma_autoriz',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_depto_firma_autoriz',
		'importe_min',
		'importe_max',
		'prioridad',
		'id_depto',
		'id_documento',
		'id_empleado',
		'id_moneda',
		'estado_reg',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'codigo_depto',
		'nombre_depto',
		'codigo_doc',
		'desc_doc',
		'nombre_completo',
		'moneda',
		'sw_obliga',
		'desc_firma'
		]),remoteSort:true
	});


	// DEFINICIï¿½N DATOS DEL MAESTRO


	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['ID Depto.',maestro.id_depto],['Codigo Depto.',maestro.codigo_depto],['Departamento',maestro.nombre_depto]];

	//DATA STORE COMBOS

	var ds_doc = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/documento/ActionListarDocumento.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_documento',totalRecords: 'TotalCount'},['id_documento','codigo','descripcion'])
	});

	var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','desc_persona'])
	});

	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','simbolo','nombre'])
	});

	//FUNCIONES RENDER

	function render_doc(value, p, record){return String.format('{0}', record.data['desc_doc']);}
	var tpl_doc=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo}</FONT><br>','<FONT COLOR="#0000ff">{descripcion}</FONT>','</div>');

	function render_empleado(value, p, record){return String.format('{0}', record.data['nombre_completo']);}
	var tpl_empleado=new Ext.Template('<div class="search-item">','{desc_persona}','</div>');
	
	function render_moneda(value, p, record){return String.format('{0}', record.data['moneda']);}
	var tpl_moneda=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{simbolo}</FONT><br>','<b>{nombre}</b>','</div>');


	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////

	// hidden id_depto_usuario
	//en la posiciï¿½n 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_depto_firma_autoriz',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};

	Atributos[1]={
		validacion:{
			name:'importe_min',
			fieldLabel:'Importe Minimo',
			allowBlank:false,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			validator:function val_num(value){if(value<=0){return false;}else{return true;}},
			invalidText:'El valor debe ser mayor a cero'
		},
		tipo: 'NumberField',
		form: true
	};

	Atributos[2]={
		validacion:{
			name:'importe_max',
			fieldLabel:'Importe Maximo',
			allowBlank:false,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			validator:function val_num(value){if(value<=0){return false;}else{return true;}},
			invalidText:'El valor debe ser mayor a cero'
		},
		tipo: 'NumberField',
		form: true
	};

	Atributos[3]={
		validacion:{
			name:'prioridad',
			fieldLabel:'Prioridad',
			allowBlank:false,
			align:'right',
			maxLength:3,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			width:'50%',
			validator:function val_num(value){if(value<=0){return false;}else{return true;}},
			invalidText:'El valor debe ser mayor a cero'
		},
		tipo: 'NumberField',
		form: true
	};

	Atributos[4]={
		validacion:{
			name:'id_depto',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_depto
	};

	Atributos[5]={
		validacion:{
			name:'id_documento',
			fieldLabel:'Documento',
			allowBlank:false,
			emptyText:'Documento...',
			desc: 'desc_doc', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_doc,
			valueField: 'id_documento',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'DOCUME.codigo#DOCUME.descripcion',
			tpl:tpl_doc,
			mode:'remote',
			queryDelay:250,
			pageSize:15,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_doc,
			grid_visible:true,
			grid_editable:false,
			width_grid:170,
			width:250
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.codigo#DOCUME.descripcion'
	};

	Atributos[6]={
		validacion:{
			name:'id_empleado',
			fieldLabel:'Funcionario',
			allowBlank:false,
			emptyText:'Funcionario...',
			desc: 'nombre_completo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			tpl:tpl_empleado,
			mode:'remote',
			queryDelay:250,
			pageSize:15,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_empleado,
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:250
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre'
	};

	Atributos[7]={
		validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,
			emptyText:'Moneda...',
			desc: 'moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.simbolo#MONEDA.nombre',
			tpl:tpl_moneda,
			mode:'remote',
			queryDelay:250,
			pageSize:15,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:250
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.simbolo#MONEDA.nombre'
	};

	// txt estado
	Atributos[8]={
		validacion:{
			name:'estado_reg',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			grid_editable:false,
			forceSelection:true,
			width_grid:50,
			width:100
		},
		tipo:'ComboBox',
		defecto:'activo',
		form: true,
		filtro_0:true,
		filterColValue:'DEPFIR.estado'

	};
	// txt estado '',
 
	Atributos[9]={
		validacion:{
			name:'sw_obliga',
			fieldLabel:'Obliga',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','SI'],['no','NO']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			grid_editable:false,
			forceSelection:true,
			align:'center',
			width_grid:50,
			width:100
		},
		tipo:'ComboBox',
		defecto:'no',
		form: true,
		filtro_0:true,
		filterColValue:'DEPFIR.sw_obliga',
		save_as:'sw_obliga'
	};
	
	Atributos[10]={
		validacion:{
			name:'desc_firma',
			fieldLabel:'Descripcion Firma',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DEPFIR.desc_firma',
		save_as:'desc_firma'
	};
	
	Atributos[11]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'A partir de Fecha',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '31/01/2001',
			align:'center',
			disabledDaysText: 'Dia no valido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:100,
			disabled:false
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'DEPFIR.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:new Date(),
		save_as:'fecha_reg'
	};		

	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	function renderEstado(value){
		if(value==1){value='Activo' }
		if(value==2){value='Inactivo' }
		return value
	}

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Departamentos (Maestro)',titulo_detalle:'Firmas Autorizadas (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_departamentoUsuario = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_departamentoUsuario.init(config);

	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_departamentoUsuario,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	//DEFINICIï¿½N DE LA BARRA DE MENï¿½
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//DEFINICIï¿½N DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/depto_firma_autoriz/ActionEliminarDeptoFirmaAutoriz.php',parametros:'&id_depto='+maestro.id_depto},
		Save:{url:direccion+'../../../control/depto_firma_autoriz/ActionGuardarDeptoFirmaAutoriz.php',parametros:'&id_depto='+maestro.id_depto},
		ConfirmSave:{url:direccion+'../../../control/depto_firma_autoriz/ActionGuardarDeptoFirmaAutoriz.php',parametros:'&id_depto='+maestro.id_depto},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'departamentoUsuario'}};

		//-------------- Sobrecarga de funciones --------------------//
		this.reload=function(params){
			Ext.apply(maestro,Ext.urlDecode(decodeURIComponent(params)));
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_depto:maestro.id_depto
				}
			};
			this.btnActualizar();
			data_maestro=[['ID Depto.',maestro.id_depto],['Codigo Depto.',maestro.codigo_depto],['Departamento',maestro.nombre_depto]];
			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
			Atributos[4].defecto=maestro.id_depto;

			paramFunciones.btnEliminar.parametros='&id_depto='+maestro.id_depto;
			paramFunciones.Save.parametros='&id_depto='+maestro.id_depto;
			paramFunciones.ConfirmSave.parametros='&id_depto='+maestro.id_depto;
			this.InitFunciones(paramFunciones)
		};

		//Para manejo de eventos
		function iniciarEventosFormularios(){
			//para iniciar eventos en el formulario
		}

		//para que los hijos puedan ajustarse al tamaï¿½o
		this.getLayout=function(){return layout_departamentoUsuario.getLayout()};
		//para el manejo de hijos

		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		this.InitFunciones(paramFunciones);
		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_depto:maestro.id_depto
			}
		});

		//para agregar botones

		this.iniciaFormulario();
		iniciarEventosFormularios();
		layout_departamentoUsuario.getLayout().addListener('layout',this.onResize);
		layout_departamentoUsuario.getVentana(idContenedor).on('resize',function(){layout_departamentoUsuario.getLayout().layout()})

}