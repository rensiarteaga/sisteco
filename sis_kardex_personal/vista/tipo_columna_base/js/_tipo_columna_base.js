/**
* Nombre:		  	    pagina_tipo_columna_base.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		15-11-2010
*/
function pagina_tipo_columna_base(idContenedor,direccion,paramConfig){
	/*var Atributos=new Array,sw=0;
	var componentes=new Array();

	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_columna_base/ActionListarTipoColumnaBase.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_tipo_columna_base',totalRecords:'TotalCount'
		},[
		'id_tipo_columna_base',
		'prioridad',
		'id_tipo_columna',
		'id_tipo_columna_fk',
		'desc_tipo_columna',
		'desc_tipo_columna_fk',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'}
		]),remoteSort:true});


		//DATA STORE COMBOS
		var ds_tipo_columna=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_kardex_personal/control/tipo_columna/ActionListarTipoColumna.php"}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_columna_tipo',totalRecords:'TotalCount'},['id_columna_tipo','desc_parametro_kardex','nombre','codigo','tipo_dato'])
		});


		//FUNCIONES RENDER

		function render_id_tipo_columna(value, p, record){return String.format('{0}', record.data['desc_tipo_columna']);}
		var tpl_id_tipo_columna=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>','</div>');

		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_columna_tipo
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_tipo_columna_base',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};

		// txt id_parametro
		Atributos[1]={
			validacion:{
				name:'id_tipo_columna',
				fieldLabel:'Tipo de Columna',
				allowBlank:true,
				//emptyText:'Gestión...',
				desc: 'desc_tipo_columna', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_tipo_columna,
				valueField: 'id_tipo_columna',
				displayField: 'codigo',
				queryParam: 'filterValue_0',
				filterCol:'TIPCOL.codigo',
				typeAhead:false,
				align:'center',
				tpl:tpl_id_tipo_columna,
				forceSelection:false,
				mode:'remote',
				queryDelay:200,
				pageSize:100,
				minListWidth:200,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_tipo_columna,
				grid_visible:true,
				grid_editable:false,
				width_grid:60,
				width:200,
				disabled:false,
				grid_indice:1
			},
			tipo:'ComboBox',
			form: true,
			id_grupo:0,
			filtro_0:true,
			filterColValue:'TIPCOL.codigo'
		};
*/

	/*	Atributos[2]={
			validacion:{
				name:'id_tipo_columna_fk',
				fieldLabel:'Tipo de Columna Padre',
				allowBlank:true,
				//emptyText:'Gestión...',
				desc: 'desc_tipo_columna_fk', //indica la columna del store principal ds del que proviane la descripcion
				//store:ds_tipo_columna_fk,
				valueField: 'id_tipo_columna_fk',
				displayField: 'codigo',
				queryParam: 'filterValue_0',
				filterCol:'TICOFK.codigo',
				typeAhead:false,
				align:'center',
				//tpl:tpl_id_tipo_columna_fk,
				forceSelection:false,
				mode:'remote',
				queryDelay:200,
				pageSize:100,
				minListWidth:200,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				//renderer:render_id_tipo_columna_fk,
				grid_visible:true,
				grid_editable:false,
				width_grid:60,
				width:200,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			id_grupo:,
			filtro_0:true,
			filterColValue:'TICOFK.codigo'
		};*/
		
		// txt nombre
		/*Atributos[2]={
			validacion:{
				name:'prioridad',
				fieldLabel:'Prioridad',
				allowBlank:false,
				maxLength:255,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:130,
				width:'100%',
				disabled:false,
				grid_indice:1
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			id_grupo:,
			filterColValue:'TICOBA.prioridad'

		};

		// txt fecha_reg
		Atributos[3]= {
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
				width_grid:85,
				disabled:true
			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'TICOBA.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:''
		};*/


		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Tipo de Columna Base',grid_maestro:'grid-'+idContenedor};
		var layout_tipo_columna_base=new DocsLayoutMaestro(idContenedor);
		layout_tipo_columna_base.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_tipo_columna_base,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var ClaseMadre_getComponente=this.getComponente;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_btnNew=this.btnNew;
		var CM_btnEdit=this.btnEdit;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var CM_Save = this.Save;

		///////////////////////////////////
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		///////////////////////////////////

		var paramMenu={
			guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};


		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////

		//datos necesarios para el filtro
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/tipo_columna_base/ActionEliminarTipoColumnaBase.php'},
			Save:{url:direccion+'../../../control/tipo_columna_base/ActionGuardarTipoColumnaBase.php'},
			ConfirmSave:{url:direccion+'../../../control/tipo_columna_base/ActionGuardarTipoColumnaBase.php'},
			Formulario:{
				guardar:sSave,
				html_apply:'dlgInfo-'+idContenedor,
				height:500,
				width:480,
				minWidth:150,
				minHeight:200,
				closable:true,
				titulo:'Tipo de Columna Base',
				grupos:[
				{
					tituloGrupo:'Oculto',
					columna:0,
					id_grupo:0
				}]
			}};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
				alert('llega');
			}

			function InitPaginaColumnaTipo()
			{
				for(var i=0; i<Atributos.length; i++)
				{
					componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
				}

			}


			this.btnNew=function(){
				//var SelectionsRecord=sm.getSelected();
				
				CM_btnNew();
			}

			this.btnEdit=function(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					
					CM_btnEdit();
				}else{
					alert('Antes debe seleccionar un item');
				}
			}




			function sSave(){
				//para codificar caracteres especiales como el simbolo de "+"
				//ClaseMadre_getComponente('formula').setValue(encodeURIComponent(ClaseMadre_getComponente('formula').getValue()));
				CM_Save()
			}



			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_tipo_columna_base.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//carga datos XML
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros
				}
			});

			//para agregar botones

			this.iniciaFormulario();
			iniciarEventosFormularios();
			InitPaginaColumnaTipo();
			layout_tipo_columna_base.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}