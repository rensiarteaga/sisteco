/**
* Nombre:		  	    pagina_af_grupo_proceso.js
* Propï¿½sito: 			pagina objeto principal
* Autor:				Generado Automaticamente
*/
function pag_af_grupo_proceso(idContenedor,direccion,paramConfig,idContenedorPadre,estado_pagina){
	var Atributos=new Array;
	var componentes=new Array;
	var maestro;
	var proceso;
	var cm,vista_grid,grid;
	

	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/activo_fijo_proceso/ActionListarActivoFijoProceso.php'}),

		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_activo_fijo_proceso',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiqutas (campos)
		'id_activo_fijo_proceso',
		'id_activo_fijo',
		'id_sub_tipo_activo',
		'id_tipo_activo',
		'id_transaccion',
		'id_grupo_proceso',
		'id_presupuesto',
		'vida_util_anterior',
		'vida_util_actual',
		'depreciacion',
		'depreciacion_acumulada',
		'depreciacion_acumulada_anterior',
		'depreciacion_acumulada_actualiz',
 		'monto_actualiz_ant',
		'monto_actualiz',
		'desc_tipo_activo',
		'desc_sub_tipo_activo',
		'desc_activo',
		'desc_presupuesto',
		'monto_vigente_anterior',
		'monto_vigente_actual',
		'monto_revalorizacion',
		'vida_util_revalorizacion',
		'observaciones',		
		{name: 'fecha_ini_dep',type:'date',dateFormat:'Y-m-d'},
		'estado_detalle',
		'asignar'
		
		]),
		remoteSort: true});

		var ds_activo_fijo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_activos_fijos/control/activo_fijo/ActionListaActivoFijo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_activo_fijo',totalRecords: 'TotalCount'},['id_activo_fijo','descripcion','codigo','monto_actual','simbolo_moneda','vida_util_restante','id_cta_soldet','id_aux_soldet','cta_soldet',
		'aux_soldet','id_gestion','id_ppto','desc_tipo_activo','desc_sub_tipo_activo','cta_proceso',
		'aux_proceso','id_cta_proceso','id_aux_proceso','monto_proceso','vida_proceso','id_sub_tipo_activo',
		'id_ppto','desc_presupuesto','desc_ep','desc_unidad_organizacional','id_tipo_activo'])
		});
		
			
		
		function renderActivoFijo(value, p, record){
		   return String.format('{0}', record.data['desc_activo']);				
		}
	
		var tpl_id_activo_fijo=new Ext.Template('<div class="search-item">','<b>{descripcion}</b><br>','<FONT COLOR="#B5A642">{codigo}</FONT>',
		'<br><FONT  SIZE="1" >Tipo:   {desc_tipo_activo}</FONT>',
		'<br><FONT  SIZE="1" >Subtipo:{desc_sub_tipo_activo}</FONT>',
		'<br><FONT  SIZE="1" >Id Activo Fijo: {id_activo_fijo}</FONT>',
		'</div>');
		
	
	//en la posiciï¿½n 0 siempre tiene que estar la llave primaria

	Atributos[0] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_activo_fijo_proceso',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid

		},
		tipo: 'Field',
		filtro_0:false
	};
	
	
	
	Atributos[1] = {
		validacion:{
			fieldLabel: 'Activo Fijo',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Activo Fijo...',
			name: 'id_activo_fijo',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_activo',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_activo_fijo,
			valueField: 'id_activo_fijo',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'AF.id_activo_fijo#AF.codigo#AF.descripcion',
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: renderActivoFijo,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:200, // ancho de columna en el gris
			width:200,
			tpl: tpl_id_activo_fijo,
			grid_indice:2
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'af.id_activo_fijo#af.codigo#af.descripcion',
		id_grupo:0
	};
	
	Atributos[2] = {
		validacion:{
			fieldLabel: 'Tipo Activo',
			name: 'desc_tipo_activo',
			width_grid:130,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			grid_indice:2

		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'ta.descripcion'
	};
	Atributos[3] = {
		validacion:{
			fieldLabel: 'Sub Tipo Activo',
			name: 'desc_sub_tipo_activo',
			width_grid:130,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			grid_indice:3

		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'sta.descripcion'
	};
	Atributos[4] = {
		validacion:{
			fieldLabel: 'Presupuesto',
			name: 'desc_presupuesto',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			grid_indice:4

		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'pre.desc_presupuesto'
	};
	Atributos[5] = {
		validacion:{
			fieldLabel: 'Vida Util',
			name: 'vida_util_actual',
			width_grid:90,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			grid_indice:5

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.vida_util_actual'
	};
	
	Atributos[6] = {
		validacion:{
			fieldLabel: 'Vida Util Ant.',
			name: 'vida_util_anterior',
			width_grid:90,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			grid_indice:6

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.vida_util_anterior'
	};
	
	Atributos[7] = {
		validacion:{
			fieldLabel: 'Monto Anterior',
			name: 'monto_vigente_anterior',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			grid_indice:12

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.monto_vigente_anterior'
	};
	
	Atributos[8] = {
		validacion:{
			fieldLabel: 'Dep. Acum. Ant.',
			name: 'depreciacion_acumulada_anterior',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			grid_indice:7

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.depreciacion_acumulada_anterior'
	};
	
	Atributos[9] = {
		validacion:{
			fieldLabel: 'Dep. Acum. Act.',
			name: 'depreciacion_acumulada_actualiz',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			grid_indice:8

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.depreciacion_acumulada_actualiz'
	};
	
	Atributos[10] = {
		validacion:{
			fieldLabel: 'Depreciaciï¿½n',
			name: 'depreciacion',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			grid_indice:9

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.depreciacion'
	};
	
	Atributos[11] = {
		validacion:{
			fieldLabel: 'Depreciaciï¿½n Acum.',
			name: 'depreciacion_acumulada',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			grid_indice:10

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.depreciacion_acumulada'
	};
	
	Atributos[12] = {
		validacion:{
			fieldLabel: 'Monto Actualizado Ant.',
			name: 'monto_actualiz_ant',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			grid_indice:11

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.monto_actualiz_ant'
	};
	
	Atributos[13] = {
		validacion:{
			fieldLabel: 'Monto Actualizado',
			name: 'monto_actualiz',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			grid_indice:12

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.monto_actualiz'
	};
	
		
	Atributos[14] = {
		validacion:{
			fieldLabel: 'Monto Vigente',
			name: 'monto_vigente_actual',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			grid_indice:12

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.monto_vigente_actual'
	};
	
	Atributos[15]= {
		validacion:{
			name: 'id_grupo_proceso',
			fieldLabel:'Identificador',
			inputType:"text",
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			grid_indice:1
		},
		tipo: 'Field'
	};
	
	Atributos[16] = {
		validacion:{
			name: 'monto_revalorizacion',
			fieldLabel: 'Importe Revalorizaciï¿½n',
			allowBlank: false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: true,
			allowNegative: false,
			minValue: 0,
			decimalPrecision : 2,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:110 // ancho de columna en el gris
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'afp.monto_revalorizacion',
		id_grupo:1
	};
	
	Atributos[17]= {
		validacion:{
			name: 'vida_util_revalorizacion',
			fieldLabel: 'Vida Util Reval.',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: 0,
			decimalPrecision : 0,
			//vtype:"alphaLatino",
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:90 // ancho de columna en el gris
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'afp.vida_util_revalorizacion',
		id_grupo:1
	};
	
	Atributos[18] = {
		validacion:{
			name: 'fecha_ini_dep',
			fieldLabel: 'Fecha Inicio Dep.',
			allowBlank: false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			//disabledDays: [0, 7],
			disabledDaysText: 'Dï¿½a no vï¿½lido',
			grid_visible:true, // se muestra en el grid
			renderer: formatDate,
			width_grid:80
		},
		tipo: 'DateField',
		filtro_0:true,
		filterColValue:'afp.fecha_ini_dep',
		dateFormat:'m-d-Y',
		id_grupo:1
	};
	Atributos[19] = {
		validacion:{
			name: 'observaciones',
			fieldLabel: 'Observaciones',
			allowBlank: true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, // se muestra en el grid
			vtype:"texto",
			width:'80%',
			width_grid:110,
			grid_indice:3
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'afp.observaciones',
		id_grupo:0
	};
	Atributos[20]={
			validacion: {
				name:'asignar',	
				fieldLabel:'Asignar',
				allowBlank:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				grid_editable:true,
				width_grid:70,
				disabled:false,
				grid_indice:-1			
			},
			tipo:'ComboBox',
			form: true,
			filterColValue:'afp.asignar',
			filtro_0:true,
			id_grupo:0
		};
	

	
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value?value.dateFormat('d/m/Y') : '';
	};


	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////


		var config={titulo_maestro:'Proceso de AF(Maestro) ',grid_maestro:'grid-'+idContenedor};
		var layout_af_grupo_proceso = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
		layout_af_grupo_proceso.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_af_grupo_proceso,idContenedor);

	
	var getDialog=this.getDialog;
		var getGrid=this.getGrid;
		var CM_enableSelect=this.EnableSelect;
		var EstehtmlMaestro=this.htmlMaestro;
		var CM_btnEdit=this.btnEdit;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_btnNew=this.btnNew;
		var CM_btnEdit=this.btnEdit;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var ClaseMadre_conexionFailure=this.conexionFailure;
		var ClaseMadre_btnActualizar=this.btnActualizar;
		var CM_getColumnModel=this.getColumnModel;
		var CM_getColumnNum=this.getColumnNum;
		var CM_getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_success=this.success;
		
		
	//////////////////////////////////////////////////////////////
	// -----------   DEFINICIï¿½N DE LA BARRA DE MENï¿½ ----------- //
	//////////////////////////////////////////////////////////////
	if(estado_pagina=='borrador')
		var paramMenu = {
			guardar: {
				crear : true, //para ver si se creara el boton
				separador:false
			},
			nuevo: {
				crear : true, //para ver si se creara el boton
				separador:true
			},
			editar:{
				crear : true, //para ver si se creara el boton
				separador:false
			},
			eliminar:{
				crear : true, //para ver si se creara el boton
				separador:false
			},
	
			actualizar:{
				crear :true,
				separador:false
			}
		};
	else{
		var paramMenu = {
			actualizar:{
				crear :true,
				separador:false
			}
		};
		
	}


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIï¿½N DE FUNCIONES ------------------------- //
	//  aquï¿½ se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/activo_fijo_proceso/ActionEliminarActivoFijoGrupoProceso.php'},
			Save:{url:direccion+'../../../control/activo_fijo_proceso/ActionGuardarActivoFijoGrupoProceso.php'},
			ConfirmSave:{url:direccion+'../../../control/activo_fijo_proceso/ActionGuardarActivoFijoGrupoProceso.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:'45%',minWidth:250,minHeight:200,closable:true,titulo:'Procesos',
			grupos:[
				{	tituloGrupo:'Activo Fijo',	columna:0,	id_grupo:0	},
				{	tituloGrupo:'Datos Revalorizacion',columna:0,	id_grupo:1	}
		
				]}
	};


	//-------------- FIN DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//
		
	
	
		this.reload=function(m){
			    maestro=m;
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						id_grupo_proceso:maestro.id_grupo_proceso
					}
				};
				this.btnActualizar();
				iniciarEventosFormularios();
				
				Atributos[15].defecto=maestro.id_grupo_proceso;
				
				paramFunciones.btnEliminar.parametros='&id_grupo_proceso='+maestro.id_grupo_proceso;
				paramFunciones.Save.parametros='&id_grupo_proceso='+maestro.id_grupo_proceso;
				paramFunciones.ConfirmSave.parametros='&id_grupo_proceso='+maestro.id_grupo_proceso;
				
				if(maestro.sw_bien_responsabilidad=='no'){
					ds_activo_fijo.baseParams.tipo_af_bien='activo';
				}
				else{
					ds_activo_fijo.baseParams.tipo_af_bien='';
				}
				this.InitFunciones(paramFunciones);
				proceso=new String(maestro.codigo_proceso);
				proceso=proceso.substring(0,(proceso.indexOf('-'))-1);
				manejarBotones(proceso,maestro.estado,maestro.sw_prestamo);
				if(proceso=='ALTA'){
					ds_activo_fijo.baseParams.estado_activo='ALTA';
					ds_activo_fijo.baseParams.id_ppto='';
					ds_activo_fijo.baseParams.id_depto='';
					ds_activo_fijo.baseParams.asignado='';
				}
				else if(proceso=='REVA' || proceso=='MEJACT' || proceso.substring(0,4)=='BAJA'){
					ds_activo_fijo.baseParams.estado_activo='PROCESO';
					ds_activo_fijo.baseParams.id_ppto='';
					ds_activo_fijo.baseParams.id_depto='';
					ds_activo_fijo.baseParams.asignado='';
				}
				else if(proceso=='TRAN'){
					ds_activo_fijo.baseParams.estado_activo='PROCESO';
					ds_activo_fijo.baseParams.id_ppto=maestro.id_presupuesto_org;
					ds_activo_fijo.baseParams.id_depto='';
					ds_activo_fijo.baseParams.asignado='';
				}
				else if (proceso=='ASIG'){
					ds_activo_fijo.baseParams.estado_activo='';
					ds_activo_fijo.baseParams.id_ppto='';
					ds_activo_fijo.baseParams.id_depto=maestro.id_depto_org;
					ds_activo_fijo.baseParams.asignado='no';
				}
				else if (proceso=='REACT' || proceso=='REAEMP'){
					ds_activo_fijo.baseParams.estado_activo='';
					ds_activo_fijo.baseParams.id_ppto='';
					ds_activo_fijo.baseParams.id_depto='';
					ds_activo_fijo.baseParams.asignado='si';
					
				}
				//añadido 28/04/2013
				else if (proceso =='BAJPROY')
				{
					ds_activo_fijo.baseParams.proyecto='si';
					ds_activo_fijo.baseParams.estado_activo='PROYECTO';
					ds_activo_fijo.baseParams.id_ppto='';
					ds_activo_fijo.baseParams.id_depto='';
					ds_activo_fijo.baseParams.asignado='';
				}
				//fin añadido 28/04/2013
				else{
					ds_activo_fijo.baseParams.estado_activo='';
					ds_activo_fijo.baseParams.id_ppto='';
					ds_activo_fijo.baseParams.id_depto='';
					ds_activo_fijo.baseParams.asignado='';
				}
				hideColumns([[CM_getColumnNum('vida_util_anterior'),false],
							[CM_getColumnNum('monto_vigente_anterior'),false],
							[CM_getColumnNum('depreciacion_acumulada_anterior'),false],
							[CM_getColumnNum('depreciacion_acumulada_actualiz'),false],
							[CM_getColumnNum('depreciacion'),false],
							[CM_getColumnNum('monto_actualiz_ant'),false],
							[CM_getColumnNum('monto_actualiz'),false],
							[CM_getColumnNum('monto_revalorizacion'),true],
							[CM_getColumnNum('vida_util_revalorizacion'),true],
							[CM_getColumnNum('fecha_ini_dep'),true]							
							]);
				
				if(proceso=='DEPRE'){
					hideColumns([[CM_getColumnNum('vida_util_anterior'),false],
							[CM_getColumnNum('monto_vigente_anterior'),false],
							[CM_getColumnNum('depreciacion_acumulada_anterior'),false],
							[CM_getColumnNum('depreciacion_acumulada_actualiz'),false],
							[CM_getColumnNum('depreciacion'),false],
							[CM_getColumnNum('monto_actualiz_ant'),false],
							[CM_getColumnNum('monto_actualiz'),false],
							[CM_getColumnNum('monto_revalorizacion'),true],
							[CM_getColumnNum('vida_util_revalorizacion'),true],
							[CM_getColumnNum('fecha_ini_dep'),true]							
							]);
				}
				else if(proceso=='REVA' || proceso=='MEJACT'){
					hideColumns([[CM_getColumnNum('vida_util_anterior'),true],
							[CM_getColumnNum('monto_vigente_anterior'),true],
							[CM_getColumnNum('depreciacion_acumulada_anterior'),true],
							[CM_getColumnNum('depreciacion_acumulada_actualiz'),true],
							[CM_getColumnNum('depreciacion'),true],
							[CM_getColumnNum('monto_actualiz_ant'),true],
							[CM_getColumnNum('monto_actualiz'),true],
							[CM_getColumnNum('monto_revalorizacion'),false],
							[CM_getColumnNum('vida_util_revalorizacion'),false],
							[CM_getColumnNum('fecha_ini_dep'),false]							
							]);
										
				}
				else{
					hideColumns([[CM_getColumnNum('vida_util_anterior'),true],
							[CM_getColumnNum('monto_vigente_anterior'),true],
							[CM_getColumnNum('depreciacion_acumulada_anterior'),true],
							[CM_getColumnNum('depreciacion_acumulada_actualiz'),true],
							[CM_getColumnNum('depreciacion'),true],
							[CM_getColumnNum('monto_actualiz_ant'),true],
							[CM_getColumnNum('monto_actualiz'),true],
							[CM_getColumnNum('monto_revalorizacion'),true],
							[CM_getColumnNum('vida_util_revalorizacion'),true],
							[CM_getColumnNum('fecha_ini_dep'),true]							
							]);
					
					
				}
				
				
			};
			
		function iniciarEventosFormularios(){
			cm=CM_getColumnModel();
			grid=getGrid();
			vista_grid=grid.getView();
			for (var i=0;i<Atributos.length;i++){
				componentes[i]=CM_getComponente(Atributos[i].validacion.name);
			}
			grid.on('beforeedit',validarEdicion);
			
		}
		this.EnableSelect=function(sm,row,rec){
			
			enable(sm,row,rec);
			
		}
	function validarEdicion(o){
		
		if(maestro.estado=='borrador'){
				return true;
		}
		else{
				alert('Solo se pueden realizar modificaciones en estado borrador');
				return false;
		}
		
	}
	
	function hideColumns(colIndexes){
		cm.totalWidth = null;
		for(var i=0;i<colIndexes.length;i++){
			cm.config[colIndexes[i][0]].hidden = colIndexes[i][1];
	        var cid = vista_grid.getColumnId(colIndexes[i][0]);
	        
	        if(colIndexes[i][1]){
	        	vista_grid.css.updateRule(vista_grid.tdSelector+cid, "display", "none");
	        	vista_grid.css.updateRule(vista_grid.splitSelector+cid, "display", "none");
	        }
	        else{
	        	vista_grid.css.updateRule(vista_grid.tdSelector+cid, "display", "");
	        	vista_grid.css.updateRule(vista_grid.splitSelector+cid, "display", "");
	        }
	        
		}
        if(Ext.isSafari){
            vista_grid.updateHeaders();
        }
        vista_grid.updateSplitters();
        vista_grid.layout();
    }
				
	this.btnNew=function(){ 
		if(proceso=='REVA' || proceso=='MEJACT'){
			CM_mostrarGrupo('Datos Revalorizacion');
			NoBlancosGrupo(1);
		}
		else{
			CM_ocultarGrupo('Datos Revalorizacion');
			SiBlancosGrupo(1);
		}
		CM_btnNew();
		
	}
		
	this.btnEdit=function(){ 
		if(proceso=='REVA' || proceso=='MEJACT'){
			CM_mostrarGrupo('Datos Revalorizacion');
			NoBlancosGrupo(1);
		}
		else{
			CM_ocultarGrupo('Datos Revalorizacion');
			SiBlancosGrupo(1);
		}
		CM_btnEdit();
	}

	function SiBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			
			if(Atributos[i].id_grupo==grupo)
			componentes[i].allowBlank=true;
		}
	}
	function NoBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(Atributos[i].id_grupo==grupo)
				componentes[i].allowBlank=Atributos[i].validacion.allowBlank;
		}
	}
	function btnDevol(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1){
			if(confirm('ï¿½Estï¿½ seguro de Registrar la devoluciï¿½n del activo?')){
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando devoluciï¿½n...</div>",
					width:300,
					height:200,
					closable:false
				});
				//Impresiï¿½n oficial del reporte de solicitud de pago
				reporte=2;
				Ext.Ajax.request({
					url:direccion+"../../../control/activo_fijo_proceso/ActionDevolucionProcesos.php",
					method:'POST',
					params:{cantidad_ids:'1',id_activo_fijo_proceso_1:SelectionsRecord.data.id_activo_fijo_proceso},
					success:esteSuccess,
					failure:ClaseMadre_conexionFailure,
					timeout:100000000
				});
			}
			
		} else{
			Ext.MessageBox.alert('Atenciï¿½n', 'Antes debe seleccionar un registro.');
		} 
	}
	
	this.btnActualizar=function()
	{
		if(estado_pagina=='borrador')
		{
			proceso=new String(maestro.codigo_proceso);
			proceso=proceso.substring(0,(proceso.indexOf('-'))-1);

			if(proceso=='ALTA' || proceso=='BAJA')
			{
				controlActivosTension(maestro.id_grupo_proceso);
			}
		}
		ClaseMadre_btnActualizar();
	}
	
	function btnListar()
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();

		if(NumSelect==1)
		{
			var SelectionsRecord=sm.getSelected();
			//listar asociacion V 1.1
			var data = "maestro_id_grupo_proceso=" + SelectionsRecord.data.id_grupo_proceso;
			data= data + "&maestro_proceso=" + SelectionsRecord.data.desc_proceso;
			var ParamVentana={Ventana:{width:'70%',height:'60%'}};
			//layout_af_grupo_proceso.loadWindows(direccion+'../../../../sis_activos_fijos/vista/activo_fijo_generacion_cbtes/activo_fijo_generacion_cbtes.php?'+data,'Comprobantes ',ParamVentana);
			layout_af_grupo_proceso.loadWindows(direccion+'../../../../sis_activos_fijos/vista/activo_fijo_comprobantes/activo_fijo_comprobantes.php?'+data,'Comprobantes ',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('Atencion', 'Antes debe seleccionar un registro.');
		}
	}

	function btnAsociacion(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		if(NumSelect==1)
		{
				if(confirm('¿Esta Seguro de Asociar el Grupo Proceso Seleccionado?'))
				{
					Ext.MessageBox.show({
					title: 'Asociando...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando registros...</div>",
					width:300,
					height:200,
					closable:false
					});
					//Ajax modificado V 1.1
					Ext.Ajax.request({
					url:direccion+"../../../control/activo_fijo_comprobantes/ActionGuardarActivoFijoComprobante.php",
					method:'POST',
					params:{cantidad_ids:'1',id_grupo_proceso_1:SelectionsRecord.data.id_grupo_proceso},
					success:esteSuccess,
					failure:ClaseMadre_conexionFailure,
					timeout:100000000
					});
				}
		}
		else{Ext.MessageBox.alert('Error', 'Antes debe seleccionar un registro.');}
	}
	function btnAFDist()
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();

		if(NumSelect==1)
		{

			var SelectionsRecord=sm.getSelected();

			//listar af con programa dist dado un id grupo proceso
			var data = "maestro_id_grupo_proceso=" + SelectionsRecord.data.id_grupo_proceso;
			data = data+"&maestro_desc_proceso=" + SelectionsRecord.data.desc_proceso;
			var ParamVentana={Ventana:{width:'70%',height:'60%'}};
			layout_af_grupo_proceso.loadWindows(direccion+'../../../../sis_activos_fijos/vista/activo_fijo_comprobantes/activos_fijos_distribucion.php?'+data,'af_prog_dist ',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('Atencion', 'Antes debe seleccionar un registro.');
		}
	}
	function controlActivosTension(id_grupo_proceso)
	{
			Ext.MessageBox.hide();
			Ext.Ajax.request({
				url:direccion+"../../../control/activo_fijo_comprobantes/activos_fijos_distribucion/ActionListarActivoFijoDistGrupoProceso.php",
				method:'POST',
				params:{control_tension:'si',cantidad_ids:'1',id_grupo_proceso:id_grupo_proceso},
				success:  cantidad_activos_distribucion,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
			});
	}
	function cantidad_activos_distribucion(resp)
	{
		Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
		{
			var root = resp.responseXML.documentElement;
			if(root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue > 0)
			{
				CM_getBoton('ctasAsociadas-'+idContenedor).disable();
			}
			else
			{
				CM_getBoton('ctasAsociadas-'+idContenedor).enable();
			}
		}
	}

	function esteSuccess(resp){
		Ext.MessageBox.hide();
				if(resp.responseXML&&resp.responseXML.documentElement){
										
					ClaseMadre_btnActualizar();
				}
				else{
					ClaseMadre_conexionFailure();
				}
	}
	this.getLayout=function(){return layout_af_grupo_proceso.getLayout()};
	this.Init(); //iniciamos la clase madre
	
	this.InitBarraMenu(paramMenu);
	var CM_getBoton=this.getBoton;		
	this.InitFunciones(paramFunciones);
	
	
	/*botones*/
	if(estado_pagina=='prestamo')
		this.AdicionarBoton('../../../lib/imagenes/book_next.png','Registrar Devolucion',btnDevol,true,'devol','Devolver Activo');
	
	if(estado_pagina=='borrador')
	{
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Activos Distribucion',btnAFDist,true,'afDist','Activos Distribucion');
		/*botones integracion ACTIF-CONIN*/
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Asociar Proceso',btnAsociacion,true,'ctasAsociadas','Asociar Proceso');
	}
	if (estado_pagina=='no_borrador')
	{
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Cuentas Asociadas',btnListar,true,'ctasList','Cuentas Asociadas');
		CM_getBoton('ctasList-'+idContenedor).hide();
	}

	function enable(sm,row,rec){
		CM_enableSelect(sm,row,rec);
		if(estado_pagina=='prestamo'){
			CM_getBoton('devol-'+idContenedor).disable();
			if(rec.data['estado_detalle']=='pendiente'){
				CM_getBoton('devol-'+idContenedor).enable();
			}
			
		}
	}
	function manejarBotones(proc,estado,sw_prestamo){
		if(estado=='borrador'){
			if(proc=='REAEMP'||proc=='DEVOL' ){
				CM_getBoton('editar-'+idContenedor).disable();
				CM_getBoton('nuevo-'+idContenedor).disable();
			}
			else if(proc=='DEPRE' || proc=='REACT'){
				CM_getBoton('editar-'+idContenedor).disable();
				CM_getBoton('nuevo-'+idContenedor).disable();
				CM_getBoton('eliminar-'+idContenedor).disable();
			}
			if(proc=='REAEMP'||proc=='DEVOL' ){
				CM_getBoton('editar-'+idContenedor).disable();
				CM_getBoton('nuevo-'+idContenedor).disable();
			}
			else if(proc=='DEPRE' || proc=='REACT'){
				CM_getBoton('editar-'+idContenedor).disable();
				CM_getBoton('nuevo-'+idContenedor).disable();
				CM_getBoton('eliminar-'+idContenedor).disable();
			}
		}
		//alert(estado);
		if(estado=='en_prestamo'){
			CM_getBoton('devol-'+idContenedor).disable();
		}
		if(estado == 'finalizado')
		{
			if(proc=='ALTA' || proc=='BAJA' )
			{
				CM_getBoton('ctasList-'+idContenedor).setVisible(true);
				//CM_getBoton('ctasList-'+idContenedor).enable();

			}
			else
			{
				CM_getBoton('ctasList-'+idContenedor).hide();
				//CM_getBoton('ctasList-'+idContenedor).setVisible(true);
				//CM_getBoton('ctasList-'+idContenedor).disable();
			}
		}
		if(estado == 'borrador')
		{
			if(proc=='ALTA' || proc=='BAJA' ){
				CM_getBoton('ctasAsociadas-'+idContenedor).setVisible(true);
				CM_getBoton('afDist-'+idContenedor).setVisible(true);
			}
			else
			{
				CM_getBoton('ctasAsociadas-'+idContenedor).hide();
				CM_getBoton('afDist-'+idContenedor).hide();
			}
		}
	}
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_af_grupo_proceso.getLayout().addListener('layout',this.onResize);
	
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}
