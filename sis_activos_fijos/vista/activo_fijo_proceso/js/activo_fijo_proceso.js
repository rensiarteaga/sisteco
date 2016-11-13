/**
* Nombre:		  	    pagina_cotizacion_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
*/
function pag_af_proceso(idContenedor,direccion,paramConfig,idContenedorPadre){
	var Atributos=new Array;
	var maestro;

	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/activo_fijo_proceso/ActionListarActivoFijoProceso.php'}),

		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_activo_fijo_proceso',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiqutas (campos)
		{name: 'desc_proceso', type: 'string'},
		'id_activo_fijo_proceso',
		'id_grupo_proceso',
		'estado',
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
		{name: 'fecha_ini_dep',type:'date',dateFormat:'Y-m-d'}
		]),
		remoteSort: true});


		
	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden id_persona//////
	//en la posición 0 siempre tiene que estar la llave primaria

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
		filtro_0:false,
		save_as:'hidden_id_activo_fijo_proceso'
	};
	
	Atributos[1] = {
		validacion:{
			fieldLabel: 'Proceso',
			name: 'desc_proceso',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false

		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'pro.codigo#pro.descripcion'
	};
	
	Atributos[2] = {
		validacion:{
			fieldLabel: 'Estado',
			name: 'estado',
			width_grid:80,
			grid_visible:true, // se muestra en el grid
			grid_editable:false

		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'grup.estado'
	};
	
	
	Atributos[3] = {
		validacion:{
			fieldLabel: 'Vida Util',
			name: 'vida_util_actual',
			width_grid:90,
			grid_visible:true, // se muestra en el grid
			grid_editable:false

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.vida_util_actual'
	};
	
	Atributos[4] = {
		validacion:{
			fieldLabel: 'Vida Util Ant.',
			name:'vida_util_anterior',
			width_grid:90,
			grid_visible:true, // se muestra en el grid
			grid_editable:false

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.vida_util_anterior'
	};
	
	Atributos[5] = {
		validacion:{
			fieldLabel: 'Monto Anterior',
			name: 'monto_vigente_anterior',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.monto_vigente_anterior'
	};
	
	Atributos[6] = {
		validacion:{
			fieldLabel: 'Dep. Acum. Ant.',
			name: 'depreciacion_acumulada_anterior',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.depreciacion_acumulada_anterior'
	};
	
	Atributos[7] = {
		validacion:{
			fieldLabel: 'Dep. Acum. Act.',
			name: 'depreciacion_acumulada_actualiz',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.depreciacion_acumulada_actualiz'
	};
	
	Atributos[8] = {
		validacion:{
			fieldLabel: 'Depreciación',
			name: 'depreciacion',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.depreciacion'
	};
	
	Atributos[9] = {
		validacion:{
			fieldLabel: 'Depreciación Acum.',
			name: 'depreciacion_acumulada',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.depreciacion_acumulada'
	};
	
	Atributos[10] = {
		validacion:{
			fieldLabel: 'Monto Actualizado Ant.',
			name: 'monto_actualiz_ant',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.monto_actualiz_ant'
	};
	
	Atributos[11] = {
		validacion:{
			fieldLabel: 'Monto Actualizado',
			name: 'monto_actualiz',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.monto_actualiz'
	};
	
		
	Atributos[12] = {
		validacion:{
			fieldLabel: 'Monto Vigente',
			name: 'monto_vigente_actual',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.monto_vigente_actual'
	};
	
	Atributos[13] = {
		validacion:{
			fieldLabel: 'Monto Revalorización',
			name: 'monto_revalorizacion',
			width_grid:110,
			grid_visible:true, // se muestra en el grid
			grid_editable:false

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.monto_revalorizacion'
	};
	
	Atributos[14] = {
		validacion:{
			fieldLabel: 'Vida Util Reval.',
			name: 'vida_util_revalorizacion',
			width_grid:90,
			grid_visible:true, // se muestra en el grid
			grid_editable:false

		},
		tipo: 'NumbreField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.vida_util_revalorizacion'
	};	
	
	
	
	
	Atributos[15] = {
		validacion:{
			name: 'fecha_ini_dep',
			fieldLabel: 'Fecha Inicio Dep.',
			grid_visible:true, // se muestra en el grid
			renderer: formatDate,
			width_grid:80
		},
		tipo: 'DateField',
		form:false,
		filtro_0:true,
		filterColValue:'afp.fecha_ini_dep'
	};
	Atributos[16] = {
		validacion:{
			fieldLabel: 'Identificador',
			//labelSeparator:'',
			name: 'id_grupo_proceso',
			inputType:'hidden',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			grid_indice:1

		},
		tipo: 'Field',
		filtro_0:false
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
		var layout_af_proceso = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
		layout_af_proceso.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_af_proceso,idContenedor);

	
	var getDialog=this.getDialog;
		var getGrid=this.getGrid;
		var enableSelect=this.EnableSelect;
		var EstehtmlMaestro=this.htmlMaestro;
	//////////////////////////////////////////////////////////////
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	//////////////////////////////////////////////////////////////

	var paramMenu = {
		

		actualizar:{
			crear :true,
			separador:false
		}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/activo_fijo_proceso/ActionEliminaActivoFijoProceso.php'},
			Save:{url:direccion+'../../../control/activo_fijo_proceso/ActionSaveActivoFijoProceso.php'},
			ConfirmSave:{url:direccion+'../../../control/activo_fijo_proceso/ActionSaveActivoFijoProceso.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:560,minHeight:222,	closable:true,titulo:'Procesos'}};


	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	this.reload=function(m){
			    maestro=m;
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						maestro_id_activo_fijo:maestro.id_activo_fijo
						
						
						
					}
				};
				this.btnActualizar();
				//iniciarEventosFormularios();



				
				this.InitFunciones(paramFunciones)
			};
			
			
	//añadido 02/05/2014
	function btn_hist_depre()
	{
		var sm=getSelectionModel();				
		var NumSelect=sm.getCount(); 
		if(NumSelect==1)
		{
			var SelectionsRecord=sm.getSelected();	
			var data='m_id_grupo_proceso='+SelectionsRecord.data.id_grupo_proceso;
			data=data+'&txt_id_activo_fijo='+maestro.id_activo_fijo;
			data=data+'&txt_desc_proceso='+SelectionsRecord.data.desc_proceso;
			data=data+'&txt_estado='+SelectionsRecord.data.estado;
							
			window.open(direccion+'../../../../sis_activos_fijos/control/activo_fijo_proceso/ActionPDFActivoFijoHistorialDepreciaciones.php?'+data);					
		}
			else if(NumSelect>1)
			{
				Ext.MessageBox.alert('Estado', 'Tiene mas de un registro seleccionado.');
			}	
		else
		{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar un registro')
		}
	}		
			
	//fin 02/05/2014
			
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
			
	
	this.getLayout=function(){return layout_af_proceso.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//añadido 02/05/2014
	this.AdicionarBoton('../../../lib/imagenes/report.png','Historial Depreciacion',btn_hist_depre,true,'deprec','Historial Depreciacion');
//fin 02/05/2014
	this.iniciaFormulario();
	
	layout_af_proceso.getLayout().addListener('layout',this.onResize);
	
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}
