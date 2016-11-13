/**
 * Nombre:		  	    pagina_motivos_salida.js
 * Propósito: 			pagina objeto principal
 * Autor:				
 * Fecha creación:		2008-02-21 
 */
function pagina_motivos_salida(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;

	var datax;
   
	 ds_motivo_salida= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/motivo_salida/ActionListarMotivoSalida.php?origen=filtro'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_motivo_salida',
			totalRecords: 'TotalCount'
		}, ['id_motivo_salida','nombre','descripcion'])
	});
	
		
	function rendermotivo_salida(value, p, record){return String.format('{0}', record.data['nombre']);}
		
	// Definición de datos //
	/////////////////////////
	//en la posición 0 siempre esta la llave primaria
	
	var param_id_motivo_salida={
		validacion:{
			fieldLabel:'Motivo Salida',
			allowBlank:false,
			vtype:'texto',
			emptyText:'motivo_salida...',
			name:'id_motivo_salida',
			desc:'nombre',
			store:ds_motivo_salida,
			valueField:'id_motivo_salida',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'nombre',
			typeAhead:true,
			forceSelection:true,
			renderer:rendermotivo_salida,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:180
		},
		
		save_as:'txt_id_motivo_salida',
		tipo:'ComboBox',
		id_grupo:0
	};
	vectorAtributos[0] = param_id_motivo_salida;
	// txt bloqueado
	var param_seleccion= {
			validacion: {
			name:'seleccion',
			emptyText:'Tipo de reporte...',
			fieldLabel:'Tipo de Reporte',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.motivos_salida_combo.seleccion}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['1','Motivos de Salida'],
			                                                                ['2','Motivos de Salida Y Cuentas']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:80 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		//filtro_0:true,
		//filtro_1:true,
		//filterColValue:'ALMACE.bloqueado',
		defecto:'Motivos de salida',
		save_as:'txt_seleccion'
	};
	vectorAtributos[1] = param_seleccion;

	
		
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config={
		titulo_maestro:'Clasificación de motivo_salidas'
		
	};
	layout_motivos_salida=new DocsLayoutProceso(idContenedor);
	layout_motivos_salida.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_motivos_salida,idContenedor);
	
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
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
	var ClaseMadre_btnEliminar = this.btnEliminar;
	var ClaseMadre_btnActualizar = this.btnActualizar;
	var ClaseMadre_submit = this.submit;
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	
    //////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	
	function obtenerTitulo()
	{
		
		var titulo = "Clasificación de motivo_salidas";
		return titulo;
	}
	
	//datos necesarios para el filtro
	var paramFunciones = {
		
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../../control/_reportes/motivos_salida/ActionMotivoSalida.php?'+datax,
		abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		
		fileUpload:true,
		width:'60%',
		columnas:['50%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'Clasificacion motivo_salida',
		grupos:[{
			tituloGrupo:'Motivos de salida',
			columna: 0,
			id_grupo:0
		}
		]}};
		
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	//Para manejo de eventos

		function iniciarEventosFormularios(){	
		//para iniciar eventos en el formulario
		combo_motivo_salida= ClaseMadre_getComponente('id_motivo_salida');
		   				
		
		 function clasificacion(){
		    datax = "txt_id_motivo_salida=" + combo_motivo_salida.getValue();
				
		 }
		
		combo_motivo_salida.on('select',clasificacion);
		combo_motivo_salida.on('change',clasificacion);
		
	}
	
   //para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_motivos_salida.getLayout();};
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
				//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				//this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				
				
				this.InitFunciones(paramFunciones);
				//para agregar botones
				
				this.iniciaFormulario();
				iniciarEventosFormularios();
				//layout_almacen.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}