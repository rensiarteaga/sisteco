<?php 
/**
 * Nombre:		  	    planilla_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-08-23 11:07:47
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
    echo "var vista='$tipo';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:2,FiltroEstructura:false,FiltroAvanzado:fa};

var elemento={pagina:new pagina_planilla(idContenedor,direccion,paramConfig,vista),idContenedor:idContenedor};

_CP.setPagina(elemento);
}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_planilla.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciï¿½n:		2010-08-23 11:07:47
 */
function pagina_planilla(idContenedor,direccion,paramConfig, vista){
	var Atributos=new Array,sw=0;
	var marcas_html,div_dlgFrm,dlgFrm,FechaDesde,FechaHasta;
	var txt_fecha_desde,txt_fecha_hasta,txt_id_planilla, t_gestion,t_dia, t_periodo,txt_fecha_planilla;
	var tipo='';
	var trimestral_html, div_trim, dlg_trim, num_accidente, inc_temporal, permanente_p,permanente_t,muerte, enfermedad, turnos, ingresos, retiros, rep_legal, ci_rep, fecha_rep, lugar_rep;
	 
	
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/planilla/ActionListarPlanilla.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_planilla',totalRecords:'TotalCount'
		},[		
		'id_planilla',
		'id_tipo_planilla',
		'desc_tipo_planilla',
		'id_periodo',
		'desc_periodo',
		'id_usuario',
		'usuario',
		'id_moneda',
		'desc_moneda',
		'numero',
		'estado',
		'observaciones',
		'fecha_reg',
		'codigo_depto',
		{name: 'fecha_planilla',type:'date',dateFormat:'Y-m-d'},
		'gestion',
		'id_gestion',
		'periodo_lite', 'fk_id_planilla', 'estado_anticipo','recalcular','estado_obligacion'
		]),remoteSort:true});

	
	//DATA STORE COMBOS

	
	
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','gestion'])
	});
	
    var ds_tipo_planilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_planilla/ActionListarTipoPlanilla.php?basica=si&vista='+vista}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_planilla',totalRecords: 'TotalCount'},['id_tipo_planilla','nombre','descripcion','estado_reg','fecha_reg','id_usuario','id_depto','codigo_depto','tipo'])
	});

    var ds_periodo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/periodo/ActionListarPeriodo.php'}),
    		baseParams:{id_gestion:0},
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_periodo',totalRecords: 'TotalCount'},['id_periodo','id_gestion','periodo','fecha_inicio','fecha_final','estado_peri_gral','periodo_lite'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

	//FUNCIONES RENDER

    function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','{gestion}','</div>');
	
	function render_id_tipo_planilla(value, p, record){return String.format('{0}', record.data['desc_tipo_planilla']);}
	var tpl_id_tipo_planilla=new Ext.Template('<div class="search-item">','<b>{codigo_depto}</b><br>','{nombre}<br>','<FONT COLOR="#2F4F4F"><i>{descripcion}</i></FONT>','</div>'); 
	
	function render_id_periodo(value, p, record){return String.format('{0}', record.data['periodo_lite']);}
	var tpl_id_periodo=new Ext.Template('<div class="search-item">','{periodo} - {periodo_lite}','</div>');

	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','{simbolo} - {nombre}','</div>');
		
	function render_id_usuario(value, p, record){return String.format('{0}', record.data['usuario']);}

	
	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////
	
	// hidden id_planilla
	//en la posiciï¿½n 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_planilla',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};
	// txt id_tipo_planilla
	Atributos[1]={
			validacion:{
			name:'id_tipo_planilla',
			fieldLabel:'Tipo Planilla',
			allowBlank:false,			
			emptyText:'tipo planilla...',
			desc: 'desc_tipo_planilla', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_planilla,
			valueField: 'id_tipo_planilla',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'TIPPLA.nombre#DEPTO.codigo_depto#TIPPLA.descripcion',
			typeAhead:false,
			tpl:tpl_id_tipo_planilla,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_planilla,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			grid_indice:5		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPPLA.nombre'
		
	};
	
	// txt id_moneda
	Atributos[2]={
			validacion:{
			name:'id_gestion',
			fieldLabel:'Gestión',
			allowBlank:false,			
			emptyText:'gestión...',
			desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'gestion',
			typeAhead:false,
			tpl:tpl_id_gestion,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			width:150,
			grid_indice:1	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERIOD.gestion'
		
	};
// txt id_periodo
	Atributos[3]={
			validacion:{
			name:'id_periodo',
			fieldLabel:'Periodo',
			allowBlank:false,			
			emptyText:'periodo...',
			desc: 'periodo_lite', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_periodo,
			valueField: 'id_periodo',
			displayField: 'periodo_lite',
			queryParam: 'filterValue_0',
			filterCol:'PERIOD.periodo',
			typeAhead:false,
			tpl:tpl_id_periodo,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_periodo,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			grid_indice:3	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERIOD.periodo_lite'
		
	};
	// txt id_usuario
	Atributos[4]={
			validacion:{
			name:'id_usuario',
			fieldLabel:'Usuario Reg.',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			renderer:render_id_usuario,
			grid_indice:9
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'USUARI.login'
		
	};
	// txt id_moneda
	Atributos[5]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre#MONEDA.simbolo',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:50,
			width:'100%',
			grid_indice:7		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'MONEDA.simbolo'
		
	};
	// txt numero
	Atributos[6]={
		validacion:{
			name:'numero',
			fieldLabel:'Planilla',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:4
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PLANIL.numero'
		
	};
	// txt estado
	Atributos[7]={
			validacion: {
			name:'estado',
			fieldLabel:'Estado',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:6		
		},
		tipo:'Field',
		form:false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PLANIL.estado'
	};
	// txt observaciones
	Atributos[8]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:700,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:'100%',
			grid_indice:8	
		},
		tipo:'TextArea',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PLANIL.observaciones'
		
	};
// txt fecha_reg
	Atributos[9]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Reg.',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:10	
		},
		tipo:'Field',
		filtro_0:false,
		filtro_1:false,
		form:false,		
		filterColValue:'PLANIL.fecha_reg',
	};
	
	Atributos[10]= {
			validacion:{
				name:'fecha_planilla',
				fieldLabel:'Fecha',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:78,
				allowBlank:false,
				grid_indice:2
			},
			tipo:'DateField',
			form:true,
			filtro_0:false,
			filtro_1:false,
			filterColValue:'PLANIL.fecha_planilla',
			dateFormat:'m-d-Y'
		};
	
	Atributos[11]={
		validacion:{
			name:'codigo_depto',
			fieldLabel:'Depto.',
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			grid_indice:4
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'DEPTO.codigo_depto'
		
	};
	
	
	if(vista=='consultores'){
		Atributos[12]={
				validacion:{
					name:'tipo_a',
					fieldLabel:'Clonar',
					allowBlank:false,
					typeAhead:true,
					loadMask:true,
					triggerAction:'all',
					store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					forceSelection:true,
					grid_visible:false,
					grid_editable:true,
					width_grid:70,
					align:'center',
					pageSize:100,
					minListWidth:'100%',
					disabled:false,
					grid_indice:15
				},
				tipo:'ComboBox',
				form:true,
				filtro_0:false,
				//filterColValue:'PLANIL.retirado',
				defecto:'si',
				save_as:'tipo_a'
			};
	}else{
		Atributos[12]={
				validacion:{
					name:'tipo_a',
					
					labelSeparator:'',
					inputType:'hidden',
					grid_visible:false, 
					grid_editable:false
				},
				tipo: 'Field',
				//form: true,
				filtro_0:false,
					
			};
	}
	
	

	Atributos[13]={
			validacion: {
			name:'estado_anticipo',
			fieldLabel:'Estado Anticipo',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:7	
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PLANIL.estado_anticipo'
	};
	
	
	Atributos[14]={
		validacion:{
			labelSeparator:'',
			name:'reporte_planilla',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'reporte_planilla'
	};
	
	
	Atributos[15]={
			validacion:{
				name:'retirado',
				fieldLabel:'Personal Retirado',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:false,
				grid_editable:true,
				width_grid:70,
				align:'center',
				pageSize:100,
				minListWidth:'100%',
				disabled:false,
				grid_indice:15
			},
			tipo:'ComboBox',
			form:true,
			filtro_0:false,
			filterColValue:'PLANIL.retirado',
			defecto:'no',
			save_as:'retirado'
		};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	//var config={titulo_maestro:'planilla',grid_maestro:'grid-'+idContenedor};
	var config={titulo_maestro:'Planilla',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_kardex_personal/vista/empleado_planilla/empleado_planilla.php'};
	var layout_planilla=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_planilla.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_planilla,idContenedor, tipo);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnEdit=this.btnEdit;
	var CM_btnNew=this.btnNew;
	var cm_EnableSelect=this.EnableSelect;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;

	///////////////////////////////////
	// DEFINICIï¿½N DE LA BARRA DE MENï¿½//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIï¿½N DE FUNCIONES ------------------------- //
	//  aquï¿½ se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/planilla/ActionEliminarPlanilla.php'},
		Save:{url:direccion+'../../../control/planilla/ActionGuardarPlanilla.php'},
		ConfirmSave:{url:direccion+'../../../control/planilla/ActionGuardarPlanilla.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'planilla'}};
	
	//-------------- DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
		if(vista=='consultores'){
		  CM_getBoton('obligacion_afp-'+idContenedor).hide();
		  CM_getBoton('obligacion_afp_excel-'+idContenedor).hide();
		  CM_getBoton('cal_planilla-'+idContenedor).hide();
		  
		  
		  
		}else{
			 CM_getBoton('obligacion_afp-'+idContenedor).show();
			 CM_getBoton('obligacion_afp_excel-'+idContenedor).show();
			 CM_getBoton('cal_planilla-'+idContenedor).show();
		}
			
		//para iniciar eventos en el formulario
		
		CM_ocultarComponente(getComponente('retirado'));
		
		
		cmbGestion=getComponente('id_gestion');
		cmbPeriodo=getComponente('id_periodo');
		txt_fecha=getComponente('fecha_planilla');
		txt_fecha_desde=getComponente('fecha_planilla');
		txt_fecha_planilla=getComponente('fecha_planilla');
		reporte_planilla=getComponente('reporte_planilla');
		
		cmbTipoPlanilla=getComponente('id_tipo_planilla');
		
		
		var filtrar_periodo = function( combo, record, index )
		{		
			//Filtramos los presupuestos segun la gestion seleccionada
			cmbPeriodo.store.baseParams={id_gestion:record.data.id_gestion};
			t_gestion=record.data.gestion;
			cmbPeriodo.modificado=true;			
			cmbPeriodo.setValue('');			
		}
		
		cmbGestion.on('select',filtrar_periodo);
		cmbGestion.on('change',filtrar_periodo);
		var calendario=function(combo, record, index){
			
			if(record.data.periodo ==1  || record.data.periodo ==3||record.data.periodo ==5||record.data.periodo ==7||record.data.periodo ==8||record.data.periodo ==10||record.data.periodo ==12){
				t_dia=31;
				
				
			}else{
				if(record.data.periodo==2){
					if(t_gestion%4==0){
						t_dia=29;
					}else{
						t_dia=28;
					}
				}else{
					t_dia=30;
				}
			}
			
			if(record.data.periodo<10){
				t_periodo='0'+record.data.periodo;
			}
			else{ 
			    t_periodo=record.data.periodo;
			}
			
			//alert (t_dia+'/'+record.data.periodo+'/'+(parseFloat(t_gestion)));
			txt_fecha_planilla.setValue('01/'+t_periodo+'/'+(parseFloat(t_gestion)));
			txt_fecha_desde.setValue(txt_fecha_planilla.getValue().dateFormat('d/m/Y'));
			txt_fecha.minValue=txt_fecha_desde.getValue();
			
			txt_fecha_planilla.setValue(t_dia+'/'+t_periodo+'/'+(parseFloat(t_gestion)));
			txt_fecha_desde.setValue(txt_fecha_planilla.getValue().dateFormat('d/m/Y'));
			txt_fecha.maxValue=txt_fecha_desde.getValue();
			
			txt_fecha.setValue(txt_fecha.getValue());
			
		}
		
		
		
		cmbPeriodo.on('select', calendario); 
		
		//planilla segundo aguinaldo personal retirado
		var onTipoPlanilla=function(combo, record,index){
			
			if(record.data.tipo=='aguinaldo2'){
				CM_mostrarComponente(getComponente('retirado'));
				
			}else{
				if(record.data.tipo=='aguinaldo_cons2'){
					getComponente('tipo_a').disable();
				}else{
					getComponente('tipo_a').enable();
				}

				
				CM_ocultarComponente(getComponente('retirado'));
			}
			
			
		}
		cmbTipoPlanilla.on('select', onTipoPlanilla);
		
		
	}
	
	this.btnEdit = function(){
		var sm=getSelectionModel();
		
		if(sm.getCount()!=0){
				ds_periodo.baseParams={id_gestion:sm.getSelected().data.id_gestion}
				CM_btnEdit();
			}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro')
		}
	}
	
	this.EnableSelect=function(sm,row,rec){
		//cm_EnableSelect(sm,row,rec);
		_CP.getPagina(layout_planilla.getIdContentHijo()).pagina.reload(rec.data);
		if(rec.data.desc_tipo_planilla=='sueldo'||rec.data.desc_tipo_planilla=='aguinaldo' ||rec.data.desc_tipo_planilla=='general' ||rec.data.desc_tipo_planilla=='aguinaldo2' ||rec.data.desc_tipo_planilla=='reposicion' ||rec.data.desc_tipo_planilla=='aguinaldo_cons2'){
			_CP.getPagina(layout_planilla.getIdContentHijo()).pagina.desbloquearMenu();
		}else{
			_CP.getPagina(layout_planilla.getIdContentHijo()).pagina.bloquearMenu();
		}
		enable(sm, row, rec);
	}
	
	function btn_empleado_planilla(){
	
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_planilla='+SelectionsRecord.data.id_planilla;
			data=data+"&vista_doble=si"; 
			data=data+"&estado="+SelectionsRecord.data.estado;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_planilla.loadWindows(direccion+'../../../../sis_kardex_personal/vista/empleado_planilla/empleado_planilla.php?'+data,'Funcionario - Planilla',ParamVentana);
			layout_planilla.getVentana().on('resize',function(){
			layout_planilla.getLayout().layout();
			
			});

		}else{var enableSelect=this.EnableSelect;
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	
	
		function btn_empleado_planilla3(){ 
		
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
				var SelectionsRecord=sm.getSelected();
				var data="id_planilla="+SelectionsRecord.data.id_planilla;
				data=data+"&vista_doble=si";
				data=data+"&id_tipo_planilla="+SelectionsRecord.data.id_tipo_planilla;
				data=data+"&estado="+SelectionsRecord.data.estado;
				data=data+"&desc_periodo="+SelectionsRecord.data.desc_periodo;
				data=data+"&gestion="+SelectionsRecord.data.gestion;
				var ParamVentana={Ventana:{width:'90%',height:'70%'}}
				layout_planilla.loadWindows(direccion+'../../../../sis_kardex_personal/vista/empleado_planilla3/empleado_planilla.php?'+data,'Funcionario - Planilla',ParamVentana,'DinaMainPla','false');
				layout_planilla.getVentana().on('resize',function(){
				layout_planilla.getLayout().layout();
			});

		}else{var enableSelect=this.EnableSelect;
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	
	
     function btn_planilla_presupuesto(){
	
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			
			if(SelectionsRecord.data.estado_anticipo!='' && SelectionsRecord.data.estado_anticipo!=null && SelectionsRecord.data.estado_anticipo!=undefined && SelectionsRecord.data.estado_anticipo!='pagado'){
				alert('Existen funcionarios con pago de anticipo pendiente. Antes de proceder con el Presupuesto, es necesario el pago correspondiente a la Quincena');
				
			}else{// esta pagado el anticipo o no existe ningun funcionario con anticipo
				
				if(SelectionsRecord.data.estado!='borrador'){
						
					
					var data='id_planilla='+SelectionsRecord.data.id_planilla+'&id_gestion='+SelectionsRecord.data.id_gestion;
					data=data+"&vista_doble=si";
					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					layout_planilla.loadWindows(direccion+'../../../../sis_kardex_personal/vista/planilla_presupuesto/planilla_presupuesto.php?'+data,'Funcionario - Planilla',ParamVentana);
					layout_planilla.getVentana().on('resize',function(){
					layout_planilla.getLayout().layout();
					
					});
				}else{
					alert('Es necesario proceder con la validacion de la planilla previamente');
				}
			}
		}else{var enableSelect=this.EnableSelect;
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}

	}
     
     
     function btn_obligacion(){
 		var sm=getSelectionModel();
 		var NumSelect=sm.getCount();
 		if(NumSelect!=0){
 			var SelectionsRecord=sm.getSelected();
 			var data='id_planilla='+SelectionsRecord.data.id_planilla+'&id_gestion='+SelectionsRecord.data.id_gestion+'&desc_periodo='+SelectionsRecord.data.desc_periodo+'&gestion='+SelectionsRecord.data.gestion;
 			data=data+"&vista_doble=si";
 			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
 			
 			layout_planilla.loadWindows(direccion+'../../../../sis_kardex_personal/vista/obligacion/obligacion.php?'+data,'Obligaciones por planilla',ParamVentana);
 			
 			
 			layout_planilla.getVentana().on('resize',function(){
 			layout_planilla.getLayout().layout();
 			
 			});

 		}else{var enableSelect=this.EnableSelect;
 			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
 		}

 	}
      
     
	
	

	
		
	function btn_calcular_planilla(){
		
		tipo='';
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			
				var SelectionsRecord=sm.getSelected();
				
			
			     var data='id_planilla='+SelectionsRecord.data.id_planilla;
				
			     Ext.MessageBox.show({
						title: 'Procesando Planilla...',
						msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Procesando Planilla...</div>",
						width:150,
						height:200,
						closable:false
					});
			
				Ext.Ajax.request({
				url:direccion+"../../../../sis_kardex_personal/control/planilla/ActionCalcularPlanilla.php?"+data,
				method:'POST',
				success:caluloSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});
			
		

		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}

	}
	
	
	function caluloSuccess(){
		Ext.MessageBox.hide();
		if(tipo=='' || tipo=='anticipo'){
		  alert("Se calculó la planilla con exito")	
		}else{
			if(tipo=='validar'){
				alert('Validación de planilla exitosa');
			}else{
				if(tipo=='revertir'){
					alert('Reversión de calculo de planilla exitosa');
				}else{
					if(tipo=='pago_anticipo'){
						alert('Solicitud de Pago de Anticipo exitosa');
						
					}else{
						alert('Generación de planilla exitosa');
					}
				}
			}
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					vista:vista
				}
			});
		}
	   
		
	}
	function resumen_horarioSuccess(){
			alert('Generación de resumen de marcas exitosa');
			ocultarFrm();
			Ext.MessageBox.hide();						
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					vista:vista
				}
			});
	}
	function btn_reporte_planilla(){ 
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla='+SelectionsRecord.data.id_planilla;
					data= data+'&reporte_planilla='+reporte_planilla.getValue();
					data= data+'&tipo_planilla='+SelectionsRecord.data.desc_tipo_planilla;
					
				if(reporte_planilla.getValue()=='AUX'){
					window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaSueldoNeto.php?'+data)

				}else {//17
					         if (reporte_planilla.getValue()=='PI') 	window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaImpositivaAreas.php?'+data)
				    else{//16  
				    	if(reporte_planilla.getValue()=='PS')	window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleado.php?'+data)
					  else{//15	

						  if(reporte_planilla.getValue()=='PSCPS')	window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoCaja.php?'+data+'&codigo_cps=CPS')
							else{
								if(reporte_planilla.getValue()=='PSCORDES')	window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoCaja.php?'+data+'&codigo_cps=CPS_CORDES')
								else{
							
						  if(reporte_planilla.getValue()=='quincena')	window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoBonos.php?'+data+'&tipo_reporte=ANTICIPO');
						  else{ //14
							     if(reporte_planilla.getValue()=='TE'){	
							       
									          if(vista=='consultores'){
									        	  data=data+'&tipo=REFRIGERIO&reporte=global';
									              window.open(direccion+'../../../control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?'+data);
									          }else{
									        	  window.open(direccion+'../../../control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?'+data+'&tipo=BONO_TE');
									          }
							  			}else{//13
							  					if(reporte_planilla.getValue()=='TRA')	window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoBonos.php?'+data+'&tipo_reporte=BONO_TRA');
							  					else{//12  
							  						if(reporte_planilla.getValue()=='RESUM') window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFSumPlanillaEmpleado.php?'+data+'&tipo_reporte=RESUM');
							  						else{//11 
							  							if(reporte_planilla.getValue()=='CACSELFIJO')   window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoBonos.php?'+data+'&tipo_reporte=AFCOOP');
							  							else{ //10
							  								if(reporte_planilla.getValue()=='CACSELPORCEN')  window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoBonos.php?'+data+'&tipo_reporte=APCOOP');
							  								else{//9 
							  									if(sw_reporte_planilla.getValue()=='PAGOAGUIN')  	window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoBonos.php?'+data+'&tipo_reporte=PAGOAGUIN');
							  									else {//8 
							  										  if(sw_reporte_planilla.getValue()=='PAGOAGUINTODOS' && vista=='consultores' ){
								  										   window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoBonos.php?'+data+'&tipo_reporte=PAGOAGUINTODOSCONS&reporte=ordenado_aguin');
							  										  } else{ //8.1
								  											 if(sw_reporte_planilla.getValue()=='PAGOAGUINTODOS' && vista!='consultores' ){
										  										   window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoBonos.php?'+data+'&tipo_reporte=PAGOAGUINTODOS&reporte=ordenado_aguin');

								  											 }
							  											      else{//7
							  													//ENDE-001:20121219 MZM: Rep de aguinaldo con formato para jef. de trabajo
							  													if(sw_reporte_planilla.getValue()=='REP_AGUIN') window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaAguinaldo.php?'+data+'&tipo_reporte=REP_AGUIN&reporte=ordenado_aguin'); 
							  														else{//13.03.2014: modificacion a reportes de bonos porque a partir de ahora se abonaran en cuenta
							  																if(sw_reporte_planilla.getValue()=='TE_SF'){
							 			         			    	
															 			         			    	 if(vista=='consultores'){
															 			         			    		  //data=data+'&tipo=REFRIGERIO&reporte=global';
															 			         			    		  	 window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?m_id_planilla='+SelectionsRecord.data.id_planilla+'&desc='+SelectionsRecord.data.observaciones+'&tipo=REFRIGERIO');
															 			         			    	 }else{
															 			         			    	         window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?m_id_planilla='+SelectionsRecord.data.id_planilla+'&tipo=BONO_TE');
															 			         			    	 }
							  																	} else{//6
							  																			if(sw_reporte_planilla.getValue()=='TE_CF'){
																	 			         			    		if(vista=='consultores'){
																		 			         			    		  //data=data+'&tipo=REFRIGERIO&reporte=global';
																		 			         			    		  	 window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?m_id_planilla='+SelectionsRecord.data.id_planilla+'&desc='+SelectionsRecord.data.observaciones+'&tipo=REFRIGERIO&reporte=firma');
																		 			         			    	 }else{
																		 			         			    		 	 window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?m_id_planilla='+SelectionsRecord.data.id_planilla+'&tipo=BONO_TE&reporte=firma');
																		 			         			    	 }
							  																			} else{//5
							  																				  if(sw_reporte_planilla.getValue()=='TE_GLOBAL'){
																		 			         			    			if(vista=='consultores'){
																				 			         			    		  //data=data+'&tipo=REFRIGERIO&reporte=global';
																				 			         			    		  	 window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?m_id_planilla='+SelectionsRecord.data.id_planilla+'&desc='+SelectionsRecord.data.observaciones+'&tipo=REFRIGERIO&reporte=global');
																				 			         			    	 }else{
																				 			         			    		 	 window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?m_id_planilla='+SelectionsRecord.data.id_planilla+'&tipo=BONMES&reporte=global');
																				 			         			    	 }
							 			         			    		     
							  																				  }	 else{//4
																	 			         			    			  if(sw_reporte_planilla.getValue()=='PRIMA_GLOBAL'){
																		 			         			    			
																				 			         			    	    window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?m_id_planilla='+SelectionsRecord.data.id_planilla+'&tipo=PRIMA&reporte=global');
																				 			         			    	 
																		 			         			    		   }else{//3
																			 			         			    			 if(sw_reporte_planilla.getValue()=='TXT_PRIMA'){
																					 			         			    			
																			 			         			    				 data=data+'&id_planilla='+SelectionsRecord.data.id_planilla+'&id_subsistema=5&id_cuenta_bancaria=0&codigo=PRIMA&nombre=pago_'+SelectionsRecord.data.id_planilla+'_PRIMA_'+SelectionsRecord.data.desc_periodo+'_'+SelectionsRecord.data.gestion+'.txt';
																		 			         			    					    Ext.Ajax.request({
																			 			         			  						url:direccion+"../../../../sis_kardex_personal/control/planilla/ActionGenerarRPrincipal.php?"+data,
																			 			         			  						success:function(resp){
																			 			         			  						    window.open(direccion+'../../../../sis_kardex_personal/control/planilla/archivos/planta/pago_'+SelectionsRecord.data.id_planilla+'_PRIMA_'+SelectionsRecord.data.desc_periodo+'_'+SelectionsRecord.data.gestion+'.txt');
																			 			         			  						},
																			 			         			  						failure:ClaseMadre_conexionFailure,
																			 			         			  						timeout:paramConfig.TiempoEspera
																		 			         			  					    });
																							 			         			    	 
																			 			         			    			 }else{//2
																			 			         			    				 	if(sw_reporte_planilla.getValue()=='TRA_SF'){
																			 			         			    				 		window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?m_id_planilla='+SelectionsRecord.data.id_planilla+'&tipo=BONO_TRA');
																			 			         			    				 	}else{//1
																						 			         			    				if(sw_reporte_planilla.getValue()=='TRA_CF'){
																						 			         			    					window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?m_id_planilla='+SelectionsRecord.data.id_planilla+'&tipo=BONO_TRA&reporte=firma');
																						 			         			    				}else{//archivo TXT de bonos de te y transporte, vigente desde marzo/2014

																																					if (sw_reporte_planilla.getValue()=='TXT_GLOBAL'){
																																						if(vista=='consultores'){
																																							
																																							data=data+'&id_planilla='+SelectionsRecord.data.id_planilla+'&id_subsistema=5&id_cuenta_bancaria=0&codigo=REFRIGERIO_DIC&reporte=global&nombre=pago_'+SelectionsRecord.data.id_planilla+'_BONMES_'+SelectionsRecord.data.desc_periodo+'_'+SelectionsRecord.data.gestion+'.txt';
																																							 Ext.Ajax.request({
																											 			         			  						url:direccion+"../../../../sis_kardex_personal/control/planilla/ActionGenerarRPrincipal.php?"+data,
																											 			         			  						success:function(resp){
																											 			         			  						    window.open(direccion+'../../../../sis_kardex_personal/control/planilla/archivos/planta/pago_'+SelectionsRecord.data.id_planilla+'_BONMES_'+SelectionsRecord.data.desc_periodo+'_'+SelectionsRecord.data.gestion+'.txt');
																											 			         			  						},
																											 			         			  						failure:ClaseMadre_conexionFailure,
																											 			         			  						timeout:paramConfig.TiempoEspera
																										 			         			  					    });
																																							
																																					    }else{ data=data+'&id_planilla='+SelectionsRecord.data.id_planilla+'&id_subsistema=5&id_cuenta_bancaria=0&codigo=BONMES&reporte=global&nombre=pago_'+SelectionsRecord.data.id_planilla+'_BONMES_'+SelectionsRecord.data.desc_periodo+'_'+SelectionsRecord.data.gestion+'.txt';
																																						       Ext.Ajax.request({
																										 			         			  						url:direccion+"../../../../sis_kardex_personal/control/planilla/ActionGenerarRPrincipal.php?"+data,
																										 			         			  						success:function(resp){
																										 			         			  						    window.open(direccion+'../../../../sis_kardex_personal/control/planilla/archivos/planta/pago_'+SelectionsRecord.data.id_planilla+'_BONMES_'+SelectionsRecord.data.desc_periodo+'_'+SelectionsRecord.data.gestion+'.txt');
																										 			         			  						},
																										 			         			  						failure:ClaseMadre_conexionFailure,
																										 			         			  						timeout:paramConfig.TiempoEspera
																									 			         			  					    });
																																					    }
									 			         			    					
																																					}
																						 			         			    				}// fin else //ARCGIVO TXT
																			 			         			    				 	}//fin else //1
																			 			         			    			 }// fin else //2
								 			         			    			   
								 			         			    			            			    		   }//fin else //3
							 			         			    			 
							  																				  }// fin else //4
							 			         			    	 
							  																			}// fin else //5
							 			         			    
							  																	}//fin else //6   
							 			         				   	
							  														}// fin else //13.03.2014: modificacion a reportes
							  											      
							  												}// fin else //7
							  									}//fin else //8
							  									}//fin 8.1
						 			 			}// fin else //9
						        		  	}//fin else //10
					         			}// fin else 11	
				         			}// fin else 12
				     			}// fin else 13
						 	 }// agosto2016 -------->
						   }//agosto2016
				 		}// fin else 14
		    		}// fin else 15
				}	// fin else 16		
			}// fin else //17
		}// if(NumSelect!=0){
		
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
					
				
			}
			
			function btn_obligacion_afp(){ //alert("----");
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla='+SelectionsRecord.data.id_planilla;
					data= data+'&reporte_planilla='+reporte_planilla.getValue();
					
					window.open(direccion+'../../../../sis_kardex_personal/control/empleado/ActionPDFEmpleadosAFPs.php?'+data)

				}
			}
			

			function btn_obligacion_afp_excel(){ //alert("----");
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla='+SelectionsRecord.data.id_planilla;
					data= data+'&reporte_planilla='+reporte_planilla.getValue();
					data=data+'&reporte_excel=si'
					//alert(data);
					
				
					window.open(direccion+'../../../../sis_kardex_personal/control/empleado/ActionPDFEmpleadosAFPs.php?'+data)

				}
			}
			
			
			
			
			
	function generar_planilla(t)	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='id_planilla='+SelectionsRecord.data.id_planilla;
			data=data+'&tipo='+t;
			
			if(SelectionsRecord.data.recalcular=='si'&&t!='revertir'){
				
				 alert("Es necesario recalcular la planilla, debido a que se modificó el resumen de marcas asociados a uno o mas funcionarios");
			}else{
					if(t=='validar' || t=='revertir'||t=='gen_obligacion' || t=='reg_presupuesto'){  ////////13feb12
						var texto_msj='';
						if(t=='validar'){
							texto_msj='Está seguro de Validar los Calculos de la Planilla?';
						}else{
							if(t=='revertir')
							    texto_msj='Está seguro de Revertir los Calculos de la Planilla?';
							else{
								if(t=='gen_obligacion')
								    texto_msj='Está seguro de generar las Obligaciones de la Planilla?';
								else{
									/********************************/
								     //13feb12: validacion para generar los presupuestos de la planilla
								     /********************************/
								     if(SelectionsRecord.data.estado_anticipo!='' && SelectionsRecord.data.estado_anticipo!=null && SelectionsRecord.data.estado_anticipo!=undefined && SelectionsRecord.data.estado_anticipo!='pagado'){
											alert('Existen funcionarios con pago de anticipo pendiente. Antes de proceder con el Presupuesto, es necesario el pago correspondiente a la Quincena');
				
									}else{// esta pagado el anticipo o no existe ningun funcionario con anticipo
							
											if(SelectionsRecord.data.estado!='borrador'){
													
														texto_msj='Está seguro de registrar el/los Presupuestos para pago de Planilla?'; //13feb12
													
											}else{
												    if(t=='pago_anticipado' ){
												    	 if(SelectionsRecord.data.estado_anticipo=='pagado'){
												    	
															 texto_msj='Está seguro de generar el Pago correspondiente a retroactivo Ene-Sep/2013';
												    	 }else{
												    	 	alert('Es necesario tener pagada la quincena previamente');
												    	 }
													}else{
												
														alert('Es necesario proceder con la validacion de la planilla previamente');
													}
												}
										}
								}
							}
							
						}
							
						
					if(texto_msj!='' && texto_msj!=undefined && texto_msj!= null){  // 13feb12: validacion de mensaje
						Ext.MessageBox.confirm("Atención",texto_msj,function(btn){
								 if(btn=='yes'){
									Ext.MessageBox.show({
										title: 'Procesando Planilla...',
										msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Procesando Planilla...</div>",
										width:150,
										height:200,
										closable:false
									});
									
									Ext.Ajax.request({
										url:direccion+"../../../../sis_kardex_personal/control/planilla/ActionCalcularPlanilla.php?"+data,
										success:caluloSuccess,
										failure:ClaseMadre_conexionFailure,
										timeout:paramConfig.TiempoEspera
									});
		
								}
							});
					}
				}else{
						if(t=='cbte_costo' && SelectionsRecord.data.estado_obligacion=='calculado'){
						    alert('Es necesario calcular el total de obligaciones para generar el Comprobante de Costos');	
						}else{
							Ext.MessageBox.show({
										title: 'Procesando Planilla...',
										msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Procesando Planilla...</div>",
										width:150,
										height:200,
										closable:false
									});
							
							Ext.Ajax.request({
								url:direccion+"../../../../sis_kardex_personal/control/planilla/ActionCalcularPlanilla.php?"+data,
								success:caluloSuccess,
								failure:ClaseMadre_conexionFailure,
								timeout:paramConfig.TiempoEspera
							})
						}
					}
			}
			
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	function btn_resumen_horario(){					   
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			txt_id_planilla=SelectionsRecord.data.id_planilla;
		   dlgFrm.show()
		   }
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}													   									 
	}
	function ProcesarResumenHorario(){
		
			var txt_fecha_desde=FechaDesde.getValue();
		    var txt_fecha_hasta=FechaHasta.getValue();
			var data='id_planilla='+txt_id_planilla;
			data=data+'&txt_fecha_desde='+txt_fecha_desde.dateFormat('m/d/Y');
			data=data+'&txt_fecha_hasta='+txt_fecha_hasta.dateFormat('m/d/Y');
			
			Ext.Ajax.request({
						url:direccion+"../../../../sis_kardex_personal/control/resumen_horario_mes/ActionCargaResumenMarcas.php?"+data,
						success:resumen_horarioSuccess,
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
					Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Ejecutando...</div>",
					width:150,
					height:200,
					closable:false
				});
		
	}
	function crearDialogFechas(){
		marcas_html="<div class='x-dlg-hd'>"+'Rango de Fechas'+"</div><div class='x-dlg-bd'><div id='form-ct2_"+idContenedor+"'></div></div>";
		div_dlgFrm=Ext.DomHelper.append(document.body,{tag:'div',id:'dlgFrm'+idContenedor,html:marcas_html});
		var Formulario=new Ext.form.Form({
			id:'frm_'+idContenedor,
			name:'frm_'+idContenedor,
			labelWidth:70 // label settings here cascade unless overridden
		});
		dlgFrm=new Ext.BasicDialog(div_dlgFrm,{
			modal:true,
			labelWidth:70,
			width:250,
			height:170,
			closable:paramFunciones.Formulario.closable
		});
		dlgFrm.addKeyListener(27,paramFunciones.Formulario.cancelar);//tecla escape
		dlgFrm.addButton('Procesar',ProcesarResumenHorario);
		dlgFrm.addButton('Cancelar',ocultarFrm);
		//creación de componentes
		FechaDesde=new Ext.form.DateField({
			name:'fecha_desde',
			fieldLabel:'Fecha Desde',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			renderer:formatDate,
			width_grid:100
		});
		FechaHasta=new Ext.form.DateField({
			name:'fecha_hasta',
			fieldLabel:'Fecha Hasta',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			renderer:formatDate,
			width_grid:100
		});
		
		Formulario.fieldset({legend:'Procesar Resúmen'},FechaDesde,FechaHasta);
		Formulario.render("form-ct2_"+idContenedor)
	}
	function ocultarFrm(){dlgFrm.hide()}
	function btn_resumen_marcas(){
	
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_planilla='+SelectionsRecord.data.id_planilla+'&m_nombre_completo='+SelectionsRecord.data.nombre_completo;
			data=data+"&vista_doble=si";
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_planilla.loadWindows(direccion+'../../../../sis_kardex_personal/vista/resumen_horario_mes/resumen_horario_mes.php?'+data,'Resumen Horarios',ParamVentana);
			layout_planilla.getVentana().on('resize',function(){
			layout_planilla.getLayout().layout();
			
			});

		}else{var enableSelect=this.EnableSelect;
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un funcionario');
		}

	}
	function btn_planilla_neto(){
		tipo='neto';
		generar_planilla(tipo);
	}
		
	function btn_planilla_impositiva(){
			tipo='impositiva';
			generar_planilla(tipo);
	}

	function btn_clon_planilla(){
		//tipo='clon';
		var id_padre;
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			id_padre=SelectionsRecord.data.id_planilla;
		}else{
			alert('Es necesario seleccionar una planilla base');
		}
		CM_btnNew();
		getComponente('tipo_a').setValue('clon');
		getComponente('id_planilla').setValue(id_padre);
		CM_ocultarComponente(getComponente('retirado'));
	}
	
		function btn_boleta_pago(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='id_planilla='+SelectionsRecord.data.id_planilla;
					var data=data+'&tipo_planilla='+SelectionsRecord.data.desc_tipo_planilla;
					if (SelectionsRecord.data.desc_tipo_planilla=='aguinaldo' || SelectionsRecord.data.desc_tipo_planilla=='aguinaldo2' )
					{
					    window.open(direccion+'../../../control/planilla/ActionPDFBoletaAguinaldo.php?'+data)
					}else{
					    window.open(direccion+'../../../control/planilla/ActionPDFBoletaPago.php?'+data)
					}
					    
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
		function btn_boleta_prima(){
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			if(NumSelect!=0){

				var SelectionsRecord=sm.getSelected();
				var data='id_planilla='+SelectionsRecord.data.id_planilla;
				//if (SelectionsRecord.data.desc_tipo_planilla=='aguinaldo')
				//{
				  //  window.open(direccion+'../../../control/planilla/ActionPDFBoletaAguinaldo.php?'+data)
				//}else{
				    window.open(direccion+'../../../control/planilla/ActionPDFBoletaPrima.php?'+data)
				//}
				    
			}
			else{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
			}
		}
			  
		//21.07.14
		function btn_boleta_primaSF(){
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			if(NumSelect!=0){

				var SelectionsRecord=sm.getSelected();
				var data='id_planilla='+SelectionsRecord.data.id_planilla;
				data=data+'&sin_firma=1';
				//if (SelectionsRecord.data.desc_tipo_planilla=='aguinaldo')
				//{
				  //  window.open(direccion+'../../../control/planilla/ActionPDFBoletaAguinaldo.php?'+data)
				//}else{
				    
				    window.open(direccion+'../../../control/planilla/ActionPDFBoletaPrima.php?'+data)
				//}
				    
			}
			else{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
			}
		}
		
		
		
		
		
			function btn_boleta_pagoSF(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='id_planilla='+SelectionsRecord.data.id_planilla;
					var data=data+'&tipo_planilla='+SelectionsRecord.data.desc_tipo_planilla;
					if (SelectionsRecord.data.desc_tipo_planilla=='aguinaldo'|| SelectionsRecord.data.desc_tipo_planilla=='aguinaldo2')
					{
					    window.open(direccion+'../../../control/planilla/ActionPDFBoletaAguinaldoSF.php?'+data)
					}else{
					   window.open(direccion+'../../../control/planilla/ActionPDFBoletaPagoSF.php?'+data)
					}
					
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
			
			function btn_reporte_planilla_uo(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla='+SelectionsRecord.data.id_planilla;
				if(SelectionsRecord.data.desc_tipo_planilla=='sueldo'){
					
					window.open(direccion+'../../../control/planilla/ActionPDFSumPlanillaEmpleado.php?'+data)

				   }
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
	
		function btn_cbte_costo_planilla(){
				tipo='cbte_costo';
				generar_planilla(tipo);
		}
			
			
		function btn_validar_cal(){
				tipo='validar';
				generar_planilla(tipo);
		}
	
		function btn_revertir_cal(){
				tipo='revertir';
				generar_planilla(tipo);
		}
		
		function btn_anticipo(){
			tipo='anticipo';
			generar_planilla(tipo);
		}
		
		
		function btn_pago_anticipo(){
			tipo='pago_anticipo';
			generar_planilla(tipo);
		}
		
		
		function btn_rev_anticipo(){
			tipo='rev_anticipo';
			generar_planilla(tipo);
		}
		
		/**/
		function btn_pago_anticipado(){
			tipo='pago_anticipado';
			generar_planilla(tipo);
		}
		

		function btn_gen_obligacion(){
			tipo='gen_obligacion';
			generar_planilla(tipo);
		}
		
		function btn_reporte_anticipo(){
			reporte_planilla.setValue('quincena');
			btn_reporte_planilla();
		}
		
		
		function btn_reporte_abono_anticipo(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
   
					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla='+SelectionsRecord.data.id_planilla+'&tipo_reporte=DESQUIN';
					
				/*if(SelectionsRecord.data.desc_tipo_planilla=='sueldo'){
					

				   }*/
				//window.open(direccion+'../../../control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?'+data)
				window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoBonos.php?'+data);
				//window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoBonos.php?'+data+'&reporte=ordenado');
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			function btn_reporte_abono_anticipo_global(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
   
					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla='+SelectionsRecord.data.id_planilla+'&tipo_reporte=DESQUIN';
					
				/*if(SelectionsRecord.data.desc_tipo_planilla=='sueldo'){
					

				   }*/
				//window.open(direccion+'../../../control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?'+data)
				//window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoBonos.php?'+data);
				window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoBonos.php?'+data+'&reporte=ordenado');
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
		
			
			/**///16/10/2013
			
			function btn_reporte_reintegro(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
   
					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla='+SelectionsRecord.data.id_planilla+'&tipo_reporte=ANTICIPADO';
					
				/*if(SelectionsRecord.data.desc_tipo_planilla=='sueldo'){
					

				   }*/
				//window.open(direccion+'../../../control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?'+data)
				//window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoBonos.php?'+data);
				window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoBonos.php?'+data);
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
			
			
			function btn_abono_reintegro(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
   
					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla='+SelectionsRecord.data.id_planilla+'&tipo_reporte=REINT_SAL';
					
				/*if(SelectionsRecord.data.desc_tipo_planilla=='sueldo'){
					

				   }*/
				//window.open(direccion+'../../../control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?'+data)
				//window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoBonos.php?'+data);
				window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoBonos.php?'+data);
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			function btn_abono_reintegro_global(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
   
					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla='+SelectionsRecord.data.id_planilla+'&tipo_reporte=REINT_SAL';
					
				/*if(SelectionsRecord.data.desc_tipo_planilla=='sueldo'){
					

				   }*/
				//window.open(direccion+'../../../control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?'+data)
				window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoBonos.php?'+data+'&reporte=ordenado');
				//window.open(direccion+'../../../../sis_kardex_personal/control/planilla/ActionPDFPlanillaEmpleadoBonos.php?'+data+'&reporte=ordenado');
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
		
		function btn_rep_abonos(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla='+SelectionsRecord.data.id_planilla+'&tipo=LIQPAG';
				/*if(SelectionsRecord.data.desc_tipo_planilla=='sueldo'){
					

				   }*/
				window.open(direccion+'../../../control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?'+data)
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
		function btn_rep_abonos_fir(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla='+SelectionsRecord.data.id_planilla+'&tipo=LIQPAG&reporte=firma';
				/*if(SelectionsRecord.data.desc_tipo_planilla=='sueldo'){
					

				   }*/
				window.open(direccion+'../../../control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?'+data)
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
		 function btn_rep_abonos_global(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla='+SelectionsRecord.data.id_planilla+'&tipo=LIQPAG&reporte=global';
				/*if(SelectionsRecord.data.desc_tipo_planilla=='sueldo'){
					

				   }*/
				window.open(direccion+'../../../control/planilla/ActionPDFPlanillaEmpleadoCuentaB.php?'+data)
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
		function btn_resumen_costos(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla='+SelectionsRecord.data.id_planilla;
					data=data+'&gestion='+SelectionsRecord.data.gestion;
					data=data+'&mes='+SelectionsRecord.data.periodo_lite;
					data=data+'&planilla='+SelectionsRecord.data.numero;
				/*if(SelectionsRecord.data.desc_tipo_planilla=='sueldo'){
					

				   }*/
				window.open(direccion+'../../../control/planilla/ActionPDFResumenCostos.php?'+data)
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			function btn_resumen_costos_dis(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla='+SelectionsRecord.data.id_planilla;
					data=data+'&gestion='+SelectionsRecord.data.gestion;
					data=data+'&mes='+SelectionsRecord.data.periodo_lite;
					data=data+'&planilla='+SelectionsRecord.data.numero;
					data=data+'&fecha_planilla='+SelectionsRecord.data.fecha_planilla.dateFormat('m/d/Y');
					
				/*if(SelectionsRecord.data.desc_tipo_planilla=='sueldo'){
					

				   }*/
				window.open(direccion+'../../../control/planilla/ActionPDFResumenCostosDis.php?'+data)
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
	//para que los hijos puedan ajustarse al tamaï¿½o
var nombre='';
			function btn_archivo_pago(){
				
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='id_planilla='+SelectionsRecord.data.id_planilla;
					var data=data+'&codigo=SUELDO';
					//var data=data+'&codigo=TOTGANADO';
					
					var data=data+'&monto=7000';
					nombre='davinci_'+SelectionsRecord.data.desc_periodo+'-'+SelectionsRecord.data.gestion+'.txt';
					var data=data+'&nombre='+nombre;
					Ext.Ajax.request({
						url:direccion+"../../../../sis_kardex_personal/control/planilla/ActionGenerarDavinci.php?"+data,
						success:successGenerar,
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
					/*Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Ejecutando...</div>",
					width:150,
					height:200,
					closable:false
				});*/
			}
			}

	function ocultarTrim(){dlg_trim.hide()}
			
	function success_planilla_trim(){
			alert('Registro para planilla trimestral exitosa');
			ocultarTrim();
			Ext.MessageBox.hide();						
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					vista:vista
				}
			});
	}	
			
function ProcesarPlanillaTrim(){
		
			var txt_fecha_rep=fecha_rep.getValue();
		    
		    
			var data='id_planilla='+txt_id_planilla;
			data=data+'&num_accidente='+num_accidente.getValue();
			data=data+'&inc_temp='+inc_temporal.getValue();
			data=data+'&permanente_p='+permanente_p.getValue();
			data=data+'&permanente_t='+permanente_t.getValue();
			data=data+'&muerte='+muerte.getValue();
			data=data+'&enfermedad='+enfermedad.getValue();
			data=data+'&turnos='+turnos.getValue();
			data=data+'&ingresos='+ingresos.getValue();
			data=data+'&retiros='+retiros.getValue();
			data=data+'&rep_legal='+rep_legal.getValue();
			data=data+'&ci_rep='+ci_rep.getValue();
			data=data+'&fecha_rep='+txt_fecha_rep.dateFormat('m/d/Y');
			data=data+'&lugar_rep='+lugar_rep.getValue();
			
			Ext.Ajax.request({
						url:direccion+"../../../../sis_kardex_personal/control/planilla_trimestral/ActionGuardarPlanillaTrimestral.php?"+data,
						success:success_planilla_trim,
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
					Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Ejecutando...</div>",
					width:150,
					height:200,
					closable:false
				});
		
	}	
	
	
	function registrar_trimestral(){
		trimestral_html="<div class='x-dlg-hd'>"+'Informacion Planilla Trimestral'+"</div><div class='x-dlg-bd'><div id='form-ct3_"+idContenedor+"'></div></div>";
		div_trim=Ext.DomHelper.append(document.body,{tag:'div',id:'dlg_trim'+idContenedor,html:trimestral_html});
		var Formulario=new Ext.form.Form({
			id:'trim_'+idContenedor,
			name:'trim_'+idContenedor,
			labelWidth:180,
			columnas:['47%','47%'],
			grupos:[{
				tituloGrupo:'Oculto',
				columna:0,
				id_grupo:0
			},{
				tituloGrupo:'Detalle Solicitud',
				columna:0,
				id_grupo:1}]
			// label settings here cascade unless overridden
		});
		dlg_trim=new Ext.BasicDialog(div_trim,{
			modal:true,
			labelWidth:70,
			width:380,
			height:500,
			closable:paramFunciones.Formulario.closable
		});
		
		dlg_trim.addKeyListener(27,paramFunciones.Formulario.cancelar);//tecla escape
		dlg_trim.addButton('Guardar',ProcesarPlanillaTrim);
		dlg_trim.addButton('Cancelar',ocultarTrim);
		//creación de componentes
		num_accidente=new Ext.form.NumberField({
			name:'num_accidente',
			fieldLabel:'Nº Accidentes Trimestre',
			allowBlank:false,
			allowNegative:false,
			width_grid:50,
			allowDecimals:false
			
		});
		inc_temporal=new Ext.form.NumberField({
			name:'inc_temporal',
			fieldLabel:'Inc. Temporal',
			allowBlank:false,
			allowNegative:false,
			width_grid:50,
			allowDecimals:false
		});
		
		permanente_p=new Ext.form.NumberField({
			name:'permanente_p',
			fieldLabel:'Inc. Permanente Parcial',
			allowBlank:false,
			allowNegative:false,
			width_grid:50,
			allowDecimals:false
		});
		
		permanente_t=new Ext.form.NumberField({
			name:'permanente_t',
			fieldLabel:'Inc. Permanente Total',
			allowBlank:false,
			allowNegative:false,
			width_grid:50,
			allowDecimals:false
		});
		
		
		muerte=new Ext.form.NumberField({
			name:'muerte',
			fieldLabel:'Muerte',
			allowBlank:false,
			allowNegative:false,
			width_grid:50,
			allowDecimals:false
		});
		
		
		enfermedad=new Ext.form.NumberField({
			name:'enfermedad',
			fieldLabel:'Nº Enfermedades Trabajo',
			allowBlank:false,
			allowNegative:false,
			width_grid:50,
			allowDecimals:false
		});
		
		
		turnos=new Ext.form.NumberField({
			name:'turnos',
			fieldLabel:'NºTurnos Trabajo',
			allowBlank:false,
			allowNegative:false,
			width_grid:50,
			allowDecimals:false
		});
		
		
		ingresos=new Ext.form.NumberField({
			name:'ingresos',
			fieldLabel:'Nº Per. Contratadas',
			allowBlank:false,
			allowNegative:false,
			width_grid:50,
			allowDecimals:false
		});
		
		retiros=new Ext.form.NumberField({
			name:'retiros',
			fieldLabel:'Nº Per. Retiradas',
			allowBlank:false,
			allowNegative:false,
			width_grid:50,
			allowDecimals:false
		});
		
		
		rep_legal=new Ext.form.TextField({
			name:'rep_legal',
			fieldLabel:'Rep. Legal',
			allowBlank:false,
			allowNegative:false,
			width_grid:120
		});
		
		ci_rep=new Ext.form.TextField({
			name:'ci_rep',
			fieldLabel:'CI',
			allowBlank:false,
			allowNegative:false,
			width_grid:100
			
		});
		lugar_rep=new Ext.form.TextField({
			name:'lugar_rep',
			fieldLabel:'Lugar',
			allowBlank:false,
			allowNegative:false,
			width_grid:100
			
		});
		fecha_rep=new Ext.form.DateField({
			name:'fecha_rep',
			fieldLabel:'Fecha',
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			renderer:formatDate,
			width_grid:100
			
		});
		
		
		Formulario.fieldset({legend:'Accidentes y enfermedades'},num_accidente,inc_temporal,permanente_p,permanente_t,muerte, enfermedad,turnos);
		
		Formulario.fieldset({legend:'Personal Contratado y Retirado'},  ingresos,retiros);

		Formulario.fieldset({legend:'Representante Legal'},rep_legal, ci_rep, lugar_rep, fecha_rep);
		Formulario.render("form-ct3_"+idContenedor)
	}
	
	function btn_planilla_trimestral(){/* trimestral_html, div_trim, dlg_trim*/
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			txt_id_planilla=SelectionsRecord.data.id_planilla;
		    dlg_trim.show()
		    
		   }
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
			
	function successGenerar(resp){ 
			
		  window.open(direccion+'../../../../sis_kardex_personal/control/planilla/archivos/davinci/'+nombre);
	}
	
	
	
	
	function btn_archivo_trimestral(){
				
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='id_planilla='+SelectionsRecord.data.id_planilla;
					nombre='planilla_trimestral_'+SelectionsRecord.data.desc_periodo+'-'+SelectionsRecord.data.gestion+'.txt';
					var data=data+'&nombre='+nombre;
					Ext.Ajax.request({
						url:direccion+"../../../../sis_kardex_personal/control/planilla/ActionGenerarTrimestral.php?"+data,
						success:successGenerarTrim,
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
					/*Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Ejecutando...</div>",
					width:150,
					height:200,
					closable:false
				});*/
			}
		}
	function successGenerarTrim(resp){ 
			
		  window.open(direccion+'../../../../sis_kardex_personal/control/planilla/archivos/trimestral/'+nombre);
	}
	
	
	/***************13FEB12*********************/
	function btn_reg_presupuesto(){
			tipo='reg_presupuesto';
			generar_planilla(tipo);
		}
		
	
	this.getLayout=function(){return layout_planilla.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			vista:vista
		}
	});
	
	//para agregar botones
	
	
	this.AdicionarMenuBotonSimple({text:'Empleado', 
		                           nombre:'cálculos',
		                           icon:'../../../lib/imagenes/user_otro.png',
		                           cls: 'x-btn-text-icon bmenu', // icon and text class
		                           items:[{ text:'Registro Lista',
		                        	       nombre:'empleado_planilla',
		                        	       handler:btn_empleado_planilla,
		                        	       icon:'../../../lib/imagenes/copy.png',
		                        	      // cls:'x-btn-text-icon'
		                        	       cls: 'x-btn-icon',
		                        	       },
		                        	       {text:'Registro Matriz',
			                        	       nombre:'empleado_planilla',
			                        	       handler:btn_empleado_planilla3,
			                        	       icon:'../../../lib/imagenes/copy.png',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    }
		                        	   ] 
		                             });
		                             
	
	
	if(vista!='consultores'){
	  this.AdicionarMenuBotonSimple({text:'Anticipo', 
		                           nombre:'Anticipos',
		                           icon:'../../../lib/imagenes/copy.png',
		                           cls: 'x-btn-text-icon bmenu', // icon and text class
		                           items:[{ text:'Calcular Anticipo',
		                        	       nombre:'anticipo',
		                        	       handler:btn_anticipo,
		                        	       icon:'../../../lib/imagenes/script_gear.png',
		                        	      // cls:'x-btn-text-icon'
		                        	       cls: 'x-btn-icon',
		                        	      },
		                        	       {text:'Habilitar Anticipo',
			                        	       nombre:'pago_anticipo',
			                        	       handler:btn_pago_anticipo,
			                        	       icon:'../../../lib/imagenes/ok.png',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },
			                        	    {text:'Revertir Anticipo',
			                        	       nombre:'rev_anticipo',
			                        	       handler:btn_rev_anticipo,
			                        	       icon:'../../../lib/imagenes/cross.gif',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },
			                        	     {text:'Reporte Anticipo',
			                        	       nombre:'rep_anticipo',
			                        	       handler:btn_reporte_anticipo,
			                        	       icon:'../../../lib/imagenes/print.gif',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },
			                        	    {text:'Reporte Abono Anticipo',
			                        	       nombre:'rep_abono_anticipo',
			                        	       handler:btn_reporte_abono_anticipo,
			                        	       icon:'../../../lib/imagenes/print.gif',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },
											
			                        	    {text:'Reporte Abono Anticipo Global',
			                        	       nombre:'rep_abono_anticipo',
			                        	       handler:btn_reporte_abono_anticipo_global,
			                        	       icon:'../../../lib/imagenes/print.gif',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    }/* ,
			                        	    
			                        	    {text:'Generar Retroactivo Ene-Sep/2013',
			                        	       nombre:'pago_anticipo',
			                        	       handler:btn_pago_anticipado,
			                        	       icon:'../../../lib/imagenes/ok.png',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },
			                        	    {text:'Rep Reintegro Ene-Sep/2013',
			                        	       nombre:'rep_reintegro',
			                        	       handler:btn_reporte_reintegro,
			                        	       icon:'../../../lib/imagenes/print.gif',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },{text:'Abono Reintegro Ene-Sep/2013',
			                        	       nombre:'rep_abono_reintegro',
			                        	       handler:btn_abono_reintegro,
			                        	       icon:'../../../lib/imagenes/print.gif',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },
			                        	    {text:'Abono Reintegro Ene-Sep/2013 Global',
			                        	       nombre:'rep_reintegro_global',
			                        	       handler:btn_abono_reintegro_global,
			                        	       icon:'../../../lib/imagenes/print.gif',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    }
			                        	    */
		                        	   ] 
		                             });
	}
	
   
	this.AdicionarMenuBotonSimple({text:'Operaciones', 
		                           nombre:'Cálculo Planilla',
		                           icon:'../../../lib/imagenes/script_gear.png',
		                           cls: 'x-btn-text-icon bmenu', // icon and text class
		                           items:[{ text:'Calcular Planilla',
		                        	       nombre:'cal_planilla',
		                        	       handler:btn_calcular_planilla,
		                        	       icon:'../../../lib/imagenes/det.ico',
		                        	      // cls:'x-btn-text-icon'
		                        	       cls: 'x-btn-icon',
		                        	      },
		                        	       {text:'Validar Cálculo',
			                        	       nombre:'validar_cal',
			                        	       handler:btn_validar_cal,
			                        	       icon:'../../../lib/imagenes/book_next.png',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },
			                        	    {text:'Revertir Calculo',
			                        	       nombre:'revertir_cal',
			                        	       handler:btn_revertir_cal,
			                        	       icon:'../../../lib/imagenes/book_previous.png',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    }
		                        	   ] 
		                             });
    
	
	
	this.AdicionarMenuBotonSimple({text:'Presupuesto', 
		                           nombre:'Presupuesto',
		                           icon:'../../../lib/imagenes/procsim.png',
		                           cls: 'x-btn-text-icon bmenu', // icon and text class
		                           items:[{ text:'Registrar Presupuesto de Pago',
		                        	       nombre:'reg_presupuesto',
		                        	       handler:btn_reg_presupuesto,
		                        	       icon:'../../../lib/imagenes/copy.png',
		                        	      // cls:'x-btn-text-icon'
		                        	       cls: 'x-btn-icon',
		                        	      },
		                        	       {text:'Detalle de Presupuesto',
			                        	       nombre:'planilla_presupuesto',
			                        	       handler:btn_planilla_presupuesto,
			                        	       icon:'../../../lib/imagenes/report.png',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    }
		                        	   ] 
		                             });
	
	

	
	    this.AdicionarMenuBotonSimple({text:'Obligaciones', 
		                           nombre:'Obligaciones',
		                           icon:'../../../lib/imagenes/report.png',
		                           cls: 'x-btn-text-icon bmenu', // icon and text class
		                           items:[{ text:'Generar Obligaciones',
		                        	       nombre:'gen_obligacion',
		                        	       handler:btn_gen_obligacion,
		                        	       icon:'../../../lib/imagenes/copy.png',
		                        	      // cls:'x-btn-text-icon'
		                        	       cls: 'x-btn-icon',
		                        	      },
		                        	       {text:'Detalle de Obligaciones',
			                        	       nombre:'obligacion',
			                        	       handler:btn_obligacion,
			                        	       icon:'../../../lib/imagenes/report.png',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },
			                        	    {text:'Detalle AFP',
			                        	       nombre:'obligacion_afp',
			                        	       handler:btn_obligacion_afp,
			                        	       icon:'../../../lib/imagenes/print.gif',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },
			                        	    {text:'Detalle AFP EXCEL',
			                        	       nombre:'obligacion_afp_excel',
			                        	       handler:btn_obligacion_afp_excel,
			                        	       icon:'../../../lib/imagenes/excel_16x16.gif',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    }
		                        	   ] 
		                             });
	
	
	if (vista!='consultores') {
	        this.AdicionarMenuBotonSimple({text:'Resumen Horario', 
		                           nombre:'Resumen Horas',
		                           icon:'../../../lib/imagenes/copy.png',
		                           cls: 'x-btn-text-icon bmenu', // icon and text class
		                           items:[{ text:'Generar Resumen de Marcas',
		                        	       nombre:'resumen_horario',
		                        	       handler:btn_resumen_horario,
		                        	       icon:'../../../lib/imagenes/copy.png',
		                        	      // cls:'x-btn-text-icon'
		                        	       cls: 'x-btn-icon',
		                        	      },
		                        	       {text:'Resumen de Marcas',
			                        	       nombre:'resumen_marcas',
			                        	       handler:btn_resumen_marcas,
			                        	       icon:'../../../lib/imagenes/copy.png',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },
			                        	    {text:'Generar Cbte. Costo/Planilla',
			                        	       nombre:'costo_planilla',
			                        	       handler:btn_cbte_costo_planilla,
			                        	       icon:'../../../lib/imagenes/ok.png',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    }
		                        	   ] 
		                             });
		                             
	}                            
		 
	
    if(vista=='consultores') {
    	var sw_reporte_planilla = new Ext.form.ComboBox({store: new Ext.data.SimpleStore({name:'reporte_planilla',fields:['ID','valor','filtro'],
            data:[['TE_SF','Rep. Refrigerio - Abono Cta(S/F)'],['TE_CF','Rep. Refrigerio - Abono Cta(C/F)'],
                  ['TE_GLOBAL','BONOS - Abono Cta(Global)'],['PAGOAGUINTODOS','AGUINALDO -Abono Cta.(Global)'],
                  ['TXT_GLOBAL','BONOS - Archivo TXT(Global)']]}),
            typeAhead: false,
            mode: 'local',
            triggerAction: 'all',
            emptyText:'Reporte...',
            selectOnFocus:true,
            width:180,
            valueField:'ID',
            displayField:'valor',
            mode:'local'});	
    
    		sw_reporte_planilla.on('select',function (combo, record, index){
    		
    								reporte_planilla.setValue(sw_reporte_planilla.getValue());
    								btn_reporte_planilla();
    		});
    }else{
    	var sw_reporte_planilla = new Ext.form.ComboBox({store: new Ext.data.SimpleStore({name:'reporte_planilla',fields:['ID','valor','filtro'],
                                              data:[['PS','PLANILLA - Rep. Sueldos'],['PI','PLANILLA - Rep. Impositiva'],['AUX','PLANILLA - Rep.Sueldo Neto'],
                                              ['RESUM','PLANILLA - Resumen'],

                                              ['PSCPS','PLANILLA CPS - Rep. Sueldos'],
                                              ['PSCORDES','PLANILLA CORDES - Rep. Sueldos'],
                                              //bonos
                                              //['TE','Asig. Te'],['ROPA','Asig. Ropa'],['TRA','Asig. Transporte'], //comentado 13.03.2014, pues entran en vigencia los nuevos reportes
                                              ['TE_SF','BONO TE - Abono Cta(S/F)'],['TE_CF','BONO TE - Abono Cta(C/F)'],
                                              ['TRA_SF','BONO TRA - Abono Cta(S/F)'],['TRA_CF','BONO TRA -Abono Cta(C/F)'],
                                              ['TE_GLOBAL','BONOS - Abono Cta(Global)'],['TXT_GLOBAL','BONOS - Archivo TXT(Global)'],
                                              //abono en cuentas
                                              ['ABONO','Abono en Cuenta(S/F)'],['ABONO_FIR','Abono en Cuenta(C/F)'],['ABONO_GLOBAL','Abono en Cuenta(Global)'],
                                              //boletas de pago
                                              ['PAGO','Boleta de Pago(C/F)'],['PAGOSF','Boleta de Pago(S/F)'],
                                              //costos
                                              ['RESU','Costos x Centros'],['RESUDIS','Costos x Distritos'],
                                              //cacsel
                                              ['CACSELFIJO','CACSEL -Aporte Fijo'],['CACSELPORCEN','CACSEL -Aporte %'],
                                              //aguinados (abono en cuentas  y reporte)
                                              //ENDE-001:20121219 MZM: Rep de aguinaldo con formato para jef. de trabajo
                                              ['PAGOAGUIN','AGUINALDO -Abono Cta'],['PAGOAGUINTODOS','AGUINALDO -Abono Cta.(Global)'],
                                              ['REP_AGUIN','AGUINALDO -Rep. Planilla'],
                                              
                                              ['REP_PRIMA','PRIMA - Boleta de Pago'],
                                              ['REP_PRIMASF','PRIMA - Boleta de Pago (S/F)'],
                                              ['PRIMA_GLOBAL','PRIMA - Abono Cta(Global)'],
                                              ['TXT_PRIMA','PRIMA - Archivo TXT(Global)']
                                              
                                              
                                              ]}),
                                              typeAhead: false,
                                              mode: 'local',
                                              triggerAction: 'all',
                                              emptyText:'Reporte...',
                                              selectOnFocus:true,
                                              width:190,
                                              valueField:'ID',
                                              displayField:'valor',
                                              mode:'local'});	
    		
    	sw_reporte_planilla.on('select',function (combo, record, index)
                                     {  
                                     	//alert (sw_reporte_planilla.getValue());
                                     	if(sw_reporte_planilla.getValue()=='ABONO'){
                                     		btn_rep_abonos();
                                     	}else{if(sw_reporte_planilla.getValue()=='ABONO_FIR'){
                                     		btn_rep_abonos_fir();
                                     	   }else{if(sw_reporte_planilla.getValue()=='ABONO_GLOBAL'){
                                     		btn_rep_abonos_global();
                                     	   }else{
                                     		if(sw_reporte_planilla.getValue()=='PAGO')
                                     		   btn_boleta_pago();
                                     		 else{
                                     		 if(sw_reporte_planilla.getValue()=='REP_PRIMA')
                                          		 btn_boleta_prima();
                                          	 else{
                                          		 	if(sw_reporte_planilla.getValue()=='REP_PRIMASF')
                                          		 	 btn_boleta_primaSF();
                                          		 	else{
                                          		 		
                                          		 		
			                                     		 	if(sw_reporte_planilla.getValue()=='PAGOSF')
			                                     		 	 btn_boleta_pagoSF(); 
			                                     		 	 else{
			                                     		        if(sw_reporte_planilla.getValue()=='RESU')
			                                     		           btn_resumen_costos();
			                                     		     	else{
			                                     		     		if(sw_reporte_planilla.getValue()=='RESUDIS')
			                                     		     		  btn_resumen_costos_dis();
			                                     		     		else{   
			                                     		     			
			                                     		     			
			                                     			         reporte_planilla.setValue(sw_reporte_planilla.getValue());
			                                     	        		 btn_reporte_planilla();
			                                     		     		}
			                                     		     	}
			                                     		 	 }
                                          		 	}
                                     		 }
                                     		}
                                     	}
                                     	//alert (reporte_planilla.getValue());
                                     }
								 }
							 }	 
                          );
                         
                          
                          
    }               
                          
    
    
    this.AdicionarBotonCombo(sw_reporte_planilla,'Reporte Planilla');
    //this.AdicionarBoton('../../../lib/imagenes/copy.png','Clonar Planilla',btn_clon_planilla,true,'clon_planilla','Clonar');
    if (vista!='consultores'){
    
         this.AdicionarBoton('../../../lib/imagenes/copy.png','Clonar Planilla',btn_clon_planilla,true,'clon_planilla','Clonar');
         this.AdicionarBoton('../../../lib/imagenes/davinci.jpg','Archivo Davinci',btn_archivo_pago,true,'archivo_pago','');
    
         this.AdicionarMenuBotonSimple({text:'Trimestral', 
		                           nombre:'Inf. Trimestral',
		                           icon:'../../../lib/imagenes/det.ico',
		                           cls: 'x-btn-text-icon bmenu', // icon and text class
		                           items:[{ text:'Reg. Inf. trimestral',
		                        	       nombre:'planilla_trimestral',
		                        	       handler:btn_planilla_trimestral,
		                        	       icon:'../../../lib/imagenes/copy.png',
		                        	      // cls:'x-btn-text-icon'
		                        	       cls: 'x-btn-icon',
		                        	      },
		                        	       {text:'Archivo Planilla Trimestral',
			                        	       nombre:'archivo_trimestral',
			                        	       handler:btn_archivo_trimestral,
			                        	       icon:'../../../lib/imagenes/copy.png',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    }
		                        	   ] 
		                             });
    }
   
    
   var CM_getBoton=this.getBoton;
   
   
   
	function  enable(sel,row,selected){
				var record=selected.data;
				
				var NumSelect = sel.getCount(); //recupera la cantidad de filas selecionadas
				var filas=ds.getModifiedRecords();

				if(selected&&record!=-1){
					
					if(record.desc_tipo_planilla!='reposicion' && record.desc_tipo_planilla!='aguinaldo_cons2'){
					
							   CM_getBoton('clon_planilla-'+idContenedor).disable();
							   CM_getBoton('resumen_horario-'+idContenedor).disable();
							   CM_getBoton('resumen_marcas-'+idContenedor).disable();
				
								if(record.estado=='borrador'){
								   	   CM_getBoton('validar_cal-'+idContenedor).enable();
								   	   CM_getBoton('revertir_cal-'+idContenedor).disable();
								   	   CM_getBoton('cal_planilla-'+idContenedor).enable();
								   	 
								   	   
								   	   if(record.estado_anticipo==null || record.estado_anticipo==undefined || record.estado_anticipo=='' || record.estado_anticipo=='pagado'){
								   	   	   CM_getBoton('anticipo-'+idContenedor).disable();
								   	   	   CM_getBoton('pago_anticipo-'+idContenedor).disable();
								   	   }else{
								   	   	   
								   	   		if(record.estado_anticipo=='calculado'){
								   	   			CM_getBoton('pago_anticipo-'+idContenedor).enable();
								   	   			CM_getBoton('anticipo-'+idContenedor).enable();
								   	   			 CM_getBoton('rev_anticipo-'+idContenedor).disable();
								   	   		}else{
								   	   			CM_getBoton('pago_anticipo-'+idContenedor).disable();
								   	   			CM_getBoton('anticipo-'+idContenedor).disable();
								   	   			CM_getBoton('rev_anticipo-'+idContenedor).enable();
								   	   		}
								   	    }
								   	   
								}else{
									if(record.estado=='calculado'){
										CM_getBoton('revertir_cal-'+idContenedor).enable();
									}else{
										CM_getBoton('revertir_cal-'+idContenedor).disable();
									}
									  
									  CM_getBoton('validar_cal-'+idContenedor).disable();
								   	  CM_getBoton('cal_planilla-'+idContenedor).disable();
								   	  CM_getBoton('anticipo-'+idContenedor).disable();
								   	  CM_getBoton('pago_anticipo-'+idContenedor).disable();
								   	  CM_getBoton('rev_anticipo-'+idContenedor).disable();
								}
				   
				   
								if(record.desc_tipo_planilla=='sueldo'||record.desc_tipo_planilla=='general'){
									
									 CM_getBoton('empleado_planilla-'+idContenedor).enable();
									
									 CM_getBoton('clon_planilla-'+idContenedor).disable();
									 CM_getBoton('obligacion-'+idContenedor).enable();
									 CM_getBoton('resumen_horario-'+idContenedor).enable();
									 CM_getBoton('resumen_marcas-'+idContenedor).enable();
								}
				
								if(record.desc_tipo_planilla=='auxiliar'){ // es del sueldo neto, para generar la impositiva
									
									 CM_getBoton('obligacion-'+idContenedor).disable();
									 CM_getBoton('rev_anticipo-'+idContenedor).disable();
									 CM_getBoton('resumen_horario-'+idContenedor).disable();
									 CM_getBoton('resumen_marcas-'+idContenedor).disable();
								
								}
												 
								if(record.desc_tipo_planilla=='impositiva'|| record.desc_tipo_planilla=='sueldo' || record.desc_tipo_planilla=='general'){ // es del sueldo neto, para generar la impositiva
									
									 if(record.estado!='borrador' && record.estado!='pendiente' && record.estado!='anulado'){
									 	CM_getBoton('clon_planilla-'+idContenedor).enable();
									 }else{
									 	CM_getBoton('clon_planilla-'+idContenedor).disable();
									 }
								}
								
				
								if(record.desc_tipo_planilla=='aguinaldo'){ 
									 CM_getBoton('resumen_marcas-'+idContenedor).disable();
									 CM_getBoton('resumen_horario-'+idContenedor).disable();
									 CM_getBoton('rev_anticipo-'+idContenedor).disable();
									 CM_getBoton('costo_planilla-'+idContenedor).disable();
									
								}
					}else{
						
						
						
						if(record.estado=='borrador'){
						   	   CM_getBoton('validar_cal-'+idContenedor).enable();
						   	   CM_getBoton('revertir_cal-'+idContenedor).disable();
						   	  // CM_getBoton('cal_planilla-'+idContenedor).enable();
						}else{
							if(record.estado=='calculado'){
								CM_getBoton('revertir_cal-'+idContenedor).enable();
							}else{
								CM_getBoton('revertir_cal-'+idContenedor).disable();
							}
							
							
							
							
						}
					}
				  
		}
	}

	this.iniciaFormulario();
	crearDialogFechas();
	registrar_trimestral();
	iniciarEventosFormularios();
	layout_planilla.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	_CP.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}