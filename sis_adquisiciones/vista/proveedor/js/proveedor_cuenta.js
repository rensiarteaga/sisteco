/**
 * Nombre:		  	    pagina_proveedor_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-17 10:31:08
 */
function pagina_proveedor_cuenta(idContenedor,direccion,paramConfig,vista)
{	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proveedor/ActionListarProveedor.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proveedor',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_proveedor',
		'codigo',
		'observaciones',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_institucion',
		'desc_institucion',
		'desc_persona',
		'id_persona',
		'nombre_persona',
		'usuario',
		'contrasena',
		'confirmado',
		'nombre_pago','direccion_proveedor','telefono1_proveedor','telefono2_proveedor','mail_proveedor','fax_proveedor',
		
		'casilla_proveedor',
		'celular1_proveedor',
		'celular2_proveedor',
		'email2_proveedor',
		'pag_web_proveedor',
		'nombre_contacto',
		'direccion_contacto',
		'telefono_contacto',
		'email_contacto',
		'tipo_contacto',
		'id_contacto','con_contacto'
		
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	// hidden id_proveedor
	//en la posición 0 siempre esta la llave primaria
	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_proveedor',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
			
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0,
		save_as:'hidden_id_proveedor'
	};
	
	vectorAtributos[1]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'codigo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		form: false,
		filtro_0:false,
		id_grupo:0,
		save_as:'txt_codigo'
	};
	
    vectorAtributos[2]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'desc_institucion',
			fieldLabel:'Persona Juridica',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false,
			width_grid:300
			
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'INSTIT.nombre',
		id_grupo:0,
		save_as:'txt_desc_institucion'
	};

 	vectorAtributos[3]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'desc_persona',
			fieldLabel:'Persona Natural',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false,
			width_grid:300
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
		id_grupo:0,
		save_as:'txt_desc_persona'
	};

	vectorAtributos[4]= {
		validacion:{
			name:'nombre_pago',
			fieldLabel:'Nombre de Pago',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			width:'90%',
			grid_editable:false,
			width_grid:200
		},
		tipo: 'TextArea',
		filtro_0:true,
		form: false,
		filtro_1:true,
		filterColValue:'PROVEE.nombre_pago',
		save_as:'txt_nombre_pago',
		id_grupo:0
	};
	
	// txt nombre_pago
	vectorAtributos[5]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'direccion_proveedor',
			fieldLabel:'Direccion',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0,
		form: false,
		save_as:'txt_direccion_proveedor'
	};

	vectorAtributos[6]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'telefono1_proveedor',
			fieldLabel:'Telefono Principal',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0,
		save_as:'txt_telefono1_proveedor'
	};
	
	vectorAtributos[7]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'telefono2_proveedor',
			fieldLabel:'Telefono Alternativo',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		form: false,
		id_grupo:0,
		save_as:'txt_telefono2_proveedor'
	};
	
	vectorAtributos[8]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'fax_proveedor',
			fieldLabel:'Fax ',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		form: false,
		id_grupo:0,
		save_as:'txt_fax_proveedor'
	};
	
	vectorAtributos[9]= {
		validacion:{
			name:'mail_proveedor',
			fieldLabel:'Email Principal',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'email',
			width:'90%'
		},
		tipo: 'TextField',
		form: false,
		save_as:'txt_mail_proveedor',
		id_grupo:0
	};
	
	vectorAtributos[10]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'casilla_proveedor',
			fieldLabel:'Casilla ',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		form: false,
		id_grupo:0,
		save_as:'txt_casilla_proveedor'
	};

	vectorAtributos[11]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'celular1_proveedor',
			fieldLabel:'Nº Celular Principal ',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0,
		form: false,
		save_as:'txt_celular1_proveedor'
	};
	
	vectorAtributos[12]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'pag_web_proveedor',
			fieldLabel:'Pag. Web',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		form: false,
		id_grupo:0,
		save_as:'txt_pag_web_proveedor'
	};
	
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
	if(vista=='cuenta')
		var config = {
			titulo_maestro:'proveedor',
			grid_maestro:'grid-'+idContenedor,
			urlHijo:'../../../sis_adquisiciones/vista/proveedor/proveedor_cuenta_detalle.php'
		};
	else{
		var config = {
			titulo_maestro:'proveedor',
			grid_maestro:'grid-'+idContenedor,
			urlHijo:'../../../sis_adquisiciones/vista/proveedor/proveedor_banco_detalle.php'
		};
	}
	
	
	layout_proveedor_cuenta=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_proveedor_cuenta.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_proveedor_cuenta,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnActualizar = this.btnActualizar;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_getGrid=this.getGrid;
	var cm_EnableSelect=this.EnableSelect;
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={
		actualizar:{crear:true,separador:false}
	};
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	//datos necesarios para el filtro
	var paramFunciones = {
		
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'55%',
		  width:'65%',minWidth:350,minHeight:400,closable:true,titulo:'Proveedor'}};
		
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
		getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_proveedor_cuenta.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_proveedor_cuenta.getIdContentHijo()).pagina.bloquearMenu()
					}
				})
	}
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.EnableSelect=function(sm,row,rec){
				cm_EnableSelect(sm,row,rec);
				_CP.getPagina(layout_proveedor_cuenta.getIdContentHijo()).pagina.reload(rec.data);
				_CP.getPagina(layout_proveedor_cuenta.getIdContentHijo()).pagina.desbloquearMenu();
	}
	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_proveedor_cuenta.getLayout();
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
				
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	this.iniciaFormulario();
	iniciarEventosFormularios();

	layout_proveedor_cuenta.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}