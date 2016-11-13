/**
* Nombre:		  	    pagina_empleado_planilla.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2010-08-27 14:34:08
*/
function pagina_columna_partida_ejecucion(idContenedor,direccion,paramConfig,idContenedorPadre,maestro)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/columna_partida_ejecucion/ActionListarColumnaPartidaEjecucion.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_columna_partida_ejecucion',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_columna_partida_ejecucion',
		'id_planilla_presupuesto',
		'id_columna',
		'id_partida_ejecucion',
		'id_columna_partida_ejecucion_padre',
		'id_usuario_reg',
		'id_obligacion',
		'monto',
		'momento',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'estado_reg',
		'desc_columna',
		'desc_tcolumna',
		'id_partida',
		'codigo_partida',
		'desc_partida'
		]),remoteSort:true});


		// DEFINICIÓN DATOS DEL MAESTRO

		//DATA STORE COMBOS

		/*	 function negrita(val,cell,record,row,colum,store){

		if(record.get('tiene_ppto')=='0'){
		return '<span style="color:red;font-size:8pt">' + val + '</span>';
		}
		else
		{
		return val;
		}
		}*/


		function render_estado_reg(value)
		{
			if(value=='activo'){value='Activo'	}
			else if(value=='inactivo'){value='Inactivo'	}
			return value
		}





		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_empleado_planilla
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_columna_partida_ejecucion',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			form:false

		};


		// txt id_empleado
		Atributos[1]={
			validacion:{
				name:'id_obligacion',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			defecto:maestro.id_obligacion,
			form:false
		};


		Atributos[2]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Codigo',
				name: 'desc_columna',
				grid_visible:true,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			form:false

		};



		Atributos[3]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Descripcion',

				name: 'desc_tcolumna',
				grid_visible:true,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:true,
			filterColValue:'tc.nombre',
			form:false

		};


		Atributos[4]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Monto',
				name: 'monto',
				inputType:'hidden',
				grid_visible:true,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			form:false

		};


		Atributos[5]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Momento',
				name: 'momento',
				inputType:'hidden',
				grid_visible:true,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			form:false

		};


		Atributos[6]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Partida',
				name: 'codigo_partida',
				inputType:'hidden',
				grid_visible:true,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			form:false
		};



		Atributos[7]= {
			validacion: {
				name:'estado_reg',
				fieldLabel:'Estado',displayField:'valor',
				lazyRender:true,
				renderer:render_estado_reg,
				forceSelection:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:90,

			},
			tipo:'TextFielBox',
			form: false,
			filtro_0:true,
			filterColValue:'TOB.estado_reg'
		};

		// txt fecha_reg
		Atributos[8]= {
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha Registro',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:100,
				disabled:true
			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'TOB.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:''

		};


		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'col_par_eje',grid_maestro:'grid-'+idContenedor};
		var layout_columna_partida_ejecucion=new DocsLayoutMaestro(idContenedor,idContenedorPadre);
		layout_columna_partida_ejecucion.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_columna_partida_ejecucion,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;

		///////////////////////////////////
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		///////////////////////////////////

		var paramMenu={
			//guardar:{crear:true,separador:false},
			//nuevo:{crear:true,separador:true},
			//editar:{crear:true,separador:false},
			//eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};


		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////

		//datos necesarios para el filtro
		var paramFunciones={
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'columna_partida_ejecucion'}};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//


			//funcion de reload


			this.reload=function(m){
				maestro=m; 
                this.InitFunciones(paramFunciones);
		
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						id_obligacion:maestro.id_obligacion
					}
				};

				this.btnActualizar()
			}

			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
			}

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_columna_partida_ejecucion.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//carga datos XML
			/*ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_obligacion:maestro.id_obligacion
				}
			});*/

			//para agregar botones

			this.iniciaFormulario();
			iniciarEventosFormularios();
			this.bloquearMenu();
			layout_columna_partida_ejecucion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			_CP.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

			
			
}