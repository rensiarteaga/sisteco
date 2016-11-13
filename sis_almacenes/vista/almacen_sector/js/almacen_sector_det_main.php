<?php
/**
 * Nombre:		  	    almacen_sector_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 21:16:54
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
	var sup=0;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
	
	/*<?php if($m_superficie_m2!='' ){
	
		echo 'sup='.$m_superficie_m2.';';
	}
	?>*/
	var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
	var maestro={id_almacen:<?php echo $m_id_almacen;?>,codigo:'<?php echo $m_codigo;?>',nombre:'<?php echo $m_nombre;?>',descripcion:'<?php echo $m_descripcion;?>',via_fil_max:'<?php echo $m_via_fil_max;?>',via_col_max:'<?php echo $m_via_col_max;?>'};
	var elemento={idContenedor:idContenedor,pagina:new pagina_almacen_sector_det(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre: 	  	    pagina_almacen_sector_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-18 21:16:58
*/
function pagina_almacen_sector_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	var txt_superficie,txt_altura,txt_filas,txt_columnas,combo_techado,combo_aire_acond,txt_fecha_reg,txt_superficie_m2;
	//  DATA STORE //
	var ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/almacen_sector/ActionListarAlmacenSector_det.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_almacen_sector',totalRecords:'TotalCount'},
		['codigo',
		'id_almacen_sector',
		'superficie',
		'altura',
		'via_fil',
		'via_col',
		'techado',
		'aire_acond',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_tipo_sector',
		'desc_tipo_sector',
		'desc_almacen',
		'id_almacen'
		]),remoteSort:true
	});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_almacen:maestro.id_almacen
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Id Almacen',maestro.id_almacen],['Codigo',maestro.codigo],['Nombre',maestro.nombre],['Descripción',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS
	var ds_tipo_sector=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/tipo_sector/ActionListarTipoSector.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_sector',totalRecords:'TotalCount'}, ['id_tipo_sector','codigo','descripcion','observaciones','estado_registro','fecha_reg'])});
	//FUNCIONES RENDER
	function render_id_tipo_sector(value,p,record){return String.format('{0}', record.data['desc_tipo_sector'])}
	// Template combo
	var resultTplTipoSector=new Ext.Template('<div class="search-item">','<b><i>{descripcion}</i></b>',	'<br><FONT COLOR="#B5A642">{codigo}</FONT>','</div>');
	// Definición de datos //
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_almacen_sector',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_almacen_sector'
	};
	vectorAtributos[1]={
			validacion:{
				name:'codigo',
				fieldLabel:'Codigo',
				allowBlank:false,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:100
			},
			tipo: 'TextField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'ALMSEC.codigo',
			save_as:'txt_codigo'
		};
	vectorAtributos[2]={
		validacion: {
			name:'id_tipo_sector',
			fieldLabel:'Sector',
			allowBlank:false,
			emptyText:'Sector...',
			name: 'id_tipo_sector',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_tipo_sector', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_sector,
			valueField: 'id_tipo_sector',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'TIPSEC.codigo#TIPSEC.descripcion',
			typeAhead:true,
			forceSelection:true,
			tpl:resultTplTipoSector,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:250,
			grow:true,
			width:'100%',
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_sector,
			grid_visible:true,
			grid_editable:true,
			width_grid:200 // ancho de columna en el gris
			},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'TIPSEC.codigo#TIPSEC.descripcion',
		defecto: '',
		save_as:'txt_id_tipo_sector'
	};
	vectorAtributos[3]={
		validacion:{
			name:'superficie',
			fieldLabel:'Superficie [m2]',
			allowBlank:false,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,
			allowNegative: false,
			minValue:0,
			maxValue:maestro.superficie_m2,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'ALMSEC.superficie',
		save_as:'txt_superficie'
	};
	vectorAtributos[4]={
		validacion:{
			name:'techado',
			fieldLabel:'Techado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['ID','valor'],data:Ext.almacen_sector_combo.techado}),
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:60
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ALMSEC.techado',
		defecto:'si',
		save_as:'txt_techado'
	};
	vectorAtributos[5]={
		validacion:{
			name:'altura',
			fieldLabel:'Altura [m]',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'ALMSEC.altura',
		save_as:'txt_altura'
	};
	vectorAtributos[6]={
		validacion:{
			name:'via_fil',
			fieldLabel:'Via-Fila',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,
			allowNegative:false,
			maxValue:maestro.via_fil_max,
			minValue:1,
			disabled:false,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'ALMSEC.via_fil',
		save_as:'txt_via_fil'
	};
	vectorAtributos[7]={
		validacion:{
			name:'via_col',
			fieldLabel:'Via-Columna',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,
			allowNegative: false,
			maxValue:maestro.via_col_max,
			minValue:1,
			disabled:false,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'ALMSEC.via_col',
		save_as:'txt_via_col'
	};
	vectorAtributos[8]={
		validacion: {
			name:'aire_acond',
			fieldLabel:'Aire Acondicionado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.almacen_sector_combo.aire_acond}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:120
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ALMSEC.aire_acond',
		defecto:'no',
		save_as:'txt_aire_acond'
	};
	vectorAtributos[9]={
		validacion:{
			name:'id_almacen',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_almacen,
		save_as:'txt_id_almacen'
	};
	vectorAtributos[10]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			disabled:true,
			width_grid:110,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'ALMSEC.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	//----------- FUNCIONES RENDER
	function formatDate(value){
		return value?value.dateFormat('d/m/Y') : ''
	};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Almacenes Físicos (Maestro)',
		titulo_detalle:'Sectores del Almacén (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	var layout_almacen_sector=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_almacen_sector.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_almacen_sector,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/almacen_sector/ActionEliminarAlmacenSector.php',parametros:'&m_id_almacen='+maestro.id_almacen},
		Save:{url:direccion+'../../../control/almacen_sector/ActionGuardarAlmacenSector.php',parametros:'&m_id_almacen='+maestro.id_almacen},
		ConfirmSave:{url:direccion+'../../../control/almacen_sector/ActionGuardarAlmacenSector.php',parametros:'&m_id_almacen='+maestro.id_almacen},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'50%',width:'50%',minWidth:150,minHeight:200,closable:true,titulo:'Sectores del Almacen'}
	};
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_almacen=datos.m_id_almacen;
		maestro.codigo=datos.m_codigo;
		maestro.nombre=datos.m_nombre;
		maestro.descripcion=datos.m_descripcion;
		maestro.via_fil_max=datos.m_via_fil_max;
		maestro.via_col_max=datos.m_via_col_max;
		maestro.superficie_m2=datos.m_superficie_m2;		
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id Almacen',datos.m_id_almacen],['Codigo',datos.m_codigo],['Nombre',datos.m_nombre],['Descripción',datos.m_descripcion]]);
		vectorAtributos[9].defecto=datos.m_id_almacen;
		paramFunciones={
			btnEliminar:{url:direccion+'../../../control/almacen_sector/ActionEliminarAlmacenSector.php',parametros:'&m_id_almacen='+maestro.id_almacen},
			Save:{url:direccion+'../../../control/almacen_sector/ActionGuardarAlmacenSector.php',parametros:'&m_id_almacen='+maestro.id_almacen},
			ConfirmSave:{url:direccion+'../../../control/almacen_sector/ActionGuardarAlmacenSector.php',parametros:'&m_id_almacen='+maestro.id_almacen},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'50%',width:'30%',minWidth:150,minHeight:200,closable:true,titulo:'Sectores del Almacen'}
		};
		this.InitFunciones(paramFunciones);
		ds.lastOptions={params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_almacen:datos.m_id_almacen
			}
		};
		this.btnActualizar();
		txt_filas.maxValue=datos.m_via_fil_max;
		txt_columnas.maxValue=datos.m_via_col_max
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_estante(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_almacen_sector='+SelectionsRecord.data.id_almacen_sector;
			data+='&vfm='+maestro.via_fil_max;
			data+='&vcm='+maestro.via_col_max;
			data+='&m_superficie='+SelectionsRecord.data.superficie;
			data+='&m_altura='+SelectionsRecord.data.altura;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}};
			layout_almacen_sector.loadWindows(direccion+'../../estante/estante_det.php?'+data,'Estantería',ParamVentana);
			layout_almacen_sector.getVentana().on('resize',function(){layout_almacen_sector.getLayout().layout()})
		}
	}
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		txt_superficie=ClaseMadre_getComponente('superficie');
		txt_altura=ClaseMadre_getComponente('altura');
		txt_filas=ClaseMadre_getComponente('via_fil');
		txt_columnas=ClaseMadre_getComponente('via_col');
		combo_techado=ClaseMadre_getComponente('techado');
		combo_aire_acond=ClaseMadre_getComponente('aire_acond');
        txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
       	function onSuperficieSelect(){
			var superficie=txt_superficie.getValue();
						
			if(superficie<=0){
				Ext.MessageBox.alert('Superficie', 'La Superficie tiene que ser mayor a 0');
				txt_superficie.setValue('')}
							
			}
		
		txt_superficie.on('select',onSuperficieSelect);
		txt_superficie.on('change',onSuperficieSelect);

		function onAlturaSelect(){
			var altura=txt_altura.getValue();
			if(altura<=0){
				Ext.MessageBox.alert('Altura', 'La Altura tiene que ser mayor a 0');
				txt_altura.setValue('')
			}
		}
		txt_altura.on('select', onAlturaSelect);
		txt_altura.on('change', onAlturaSelect);
		function onTechadoSelect(){
			var altura=txt_altura.getValue();
			var techado=combo_techado.getValue();
			if(techado=='no'){
				txt_altura.setValue('0');
				txt_altura.disable();
				combo_aire_acond.disable()
			}
			
			else{if(altura<=0){
					Ext.MessageBox.alert('Altura', 'La Altura tiene que ser mayor a 0');
					txt_altura.setValue('')
					}
				txt_altura.enable();
				 combo_aire_acond.enable()
				}
		}
		combo_techado.on('select',onTechadoSelect);
		combo_techado.on('change',onTechadoSelect)
	}
	this.btnNew=function(){
		CM_ocultarComponente(txt_fecha_reg);
		txt_altura.enable();
		ClaseMadre_btnNew();
		 combo_aire_acond.enable()
	};
	this.btnEdit=function(){
		CM_ocultarComponente(txt_fecha_reg);
		ClaseMadre_btnEdit()
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_almacen_sector.getLayout()
	};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.AdicionarBoton('../../../lib/imagenes/images.png','Estantería',btn_estante,true,'estante','');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_almacen_sector.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}
