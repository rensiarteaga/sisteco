function pagina_tuc_arb(idContenedor,direccion,paramConfig)
{
	var Atributos=[];


	//  En la posicion CERO va el ID del nodo
	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_tipo_unidad_constructiva',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field'

	};
	Atributos[1]={
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo: 'TextField'
	};


	Atributos[2]= {
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo: 'TextField'
	};

	// txt tipo
	Atributos[3]= {
		validacion: {
			name:'tipo',
			fieldLabel:'Tipo Unidad',
			allowBlank:false,
			align: 'center',
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.tipo_unidad_constructiva_combo.tipo}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [
			                                                        		['Hoja','Hoja'],
			                                                        		['Rama','Rama'],
			                                                        		['Raiz','Raiz']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true

		},
		tipo:'ComboBox',
		defecto:'Hoja'
	};

	// txt descripcion
	Atributos[4]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo: 'TextArea',
		save_as:'descripcion'
	};


	// txt observaciones
	Atributos[5]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'

		},
		tipo: 'TextArea'
	};

	var DatosNodo=new Array('id','id_p','tipo');

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT ARBOL     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo:'Tipo Unidad Constructiva'
	};
	layout_tuc=new DocsLayoutArb(idContenedor);
	layout_tuc.init(config);


	///////////////////////////////////////////////////
	//---------       Creacion del Arbol  -----------//
	///////////////////////////////////////////////////

	var raiz=new Ext.tree.AsyncTreeNode({
		allowDrag:false,
		allowDrop:true,
		id:'id',
		text:'Packages and Components',
		cls:'croot',
		loader:new Ext.tree.TreeLoader({
			//dataUrl:'../../../sis_almacenes/control/tipo_unidad_constructiva/dep-tree.json',
			dataUrl:'../../../sis_almacenes/control/tipo_unidad_constructiva/ActionListarTucArbPrueba.php'/*,
			createNode: readNode   //  se ejecuta al crear un nuevo nodo*/
		})
	});



	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = PaginaArb;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,raiz,layout_tuc,idContenedor,DatosNodo);

	/////////////////////////////
	// parametros las funciones//
	////////////////////////////

	var paramFunciones = {
		Basicas:{
			url:direccion+'../../../../sis_almacenes/control/tipo_unidad_constructiva/ActionGuardarTucArbPrueba.php'
		},
		Formulario:{
			height:430,
			width:480,
			minWidth:150,
			minHeight:200,
			closable:true,
			titulo:'Tipo Unidad Constructiva'
		}
	};

	/////////////////////////
	// parametros del menu //
	/////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();






}