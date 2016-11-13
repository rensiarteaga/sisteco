/**
* Nombre:		  	    pagina_solicitud_proceso_compra.js
* Propósito: 			pagina objeto principal
* Autor:				Rensi Arteaga Copari
* Fecha creación:		2008-05-19 15:28:41
*/
function pag_relfam(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0,cpm_solicitud;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/relacion_familiar/ActionListarRelacionFamiliar.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_relacion_familiar',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_relacion_familiar',
		
		'id_empleado',
		'id_persona',
		'id_institucion',
		'relacion','desc_persona','desc_institucion'
		]),remoteSort:true});




		ds_institucion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/institucion/ActionListarInstitucion.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_institucion',
		totalRecords: 'TotalCount'
	}, ['id_institucion','tdoc_id','doc_id','nombre','casilla','telefono1','telefono2','celular1','celular2','fax','email1','email2','pag_web','observaciones','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_institucion','id_persona'])
	});
	//FUNCIONES RENDER
	
	function render_id_institucion(value, p, record){return String.format('{0}', record.data['desc_institucion']);}

	
	var ds_persona=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/persona/ActionListarPersona.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_persona',
			totalRecords: 'TotalCount'
		}, ['id_persona','apellido_paterno','apellido_materno','nombre','fecha_nacimiento','doc_id','genero','casilla','telefono1','telefono2','celular1','celular2','pag_web','email1','email2','email3','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','observaciones','id_tipo_doc_identificacion','desc_tipo_doc_identificacion','desc_per'])
	});
	
	function render_id_persona(value,p,record){return String.format('{0}',record.data['desc_persona'])}	
		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_solicitud_proceso_compra
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_relacion_familiar',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_relacion_familiar'
		};
		
		Atributos[1]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_empleado',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			defecto:maestro.id_empleado,
			save_as:'id_empleado'
		};

		Atributos[2]={
					validacion: {
					name:'id_persona',
					fieldLabel:'Persona',
					allowBlank:false,			
					//emptyText:'Funcionario...',
					desc:'desc_persona', //indica la columna del store principal ds del que proviane la descripcion
					store:ds_persona,
					valueField:'id_persona',
					displayField:'desc_per',
					filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
					typeAhead:false,
					forceSelection:true,
					mode:'remote',
					queryDelay:250,
					pageSize:15,
					minListWidth:350,
					grow:true,
					width:'100%',
					resizable:true,
					confTrigguer:{
						url:direccion+'../../../../sis_seguridad/vista/persona/persona.php',
					    paramTri:'prueba:XXX',		
					    title:'Personas',
					    param:{width:800,height:800},
					    idContenedor:idContenedor,
					   // clase_vista:'pagina_persona'
				},
					queryParam:'filterValue_0',
					minChars:2, ///caracteres mínimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					renderer:render_id_persona,
					grid_visible:true,
					grid_editable:false,
					
					
					width_grid:230 // ancho de columna en el gris
				},
				tipo:'ComboTrigger',
				filtro_0:true,
				
				//filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
				filterColValue:'FUNCIO.desc_persona',
				defecto: '',
				save_as:'id_persona'
			};
		
		Atributos[3]= {
				validacion: {
				name:'id_institucion',
				fieldLabel:'Institución',
				allowBlank:true,
				emptyText:'Institución...',
				name: 'id_institucion',     //indica la columna del store principal ds del que proviane el id
				desc: 'desc_institucion', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_institucion,
				valueField: 'id_institucion',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'INSTIT.nombre#INSTIT.casilla',
				typeAhead:true,
				//forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:150,
				minListWidth:450,
				grow:true,
				width:200,confTrigguer:{
						url:direccion+'../../../../sis_parametros/vista/institucion/institucion.php',
					    paramTri:'prueba:XXX',		
					    title:'Instituciones',
					    param:{width:800,height:800},
					    idContenedor:idContenedor
					   // baseParams={tipo:'si'}
					   // clase_vista:'pagina_persona'
				},
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_institucion,
				grid_visible:true,
				grid_editable:false,
				width_grid:150 // ancho de columna en el gris
	
			},
			tipo:'ComboTrigger',
			filtro_0:true,
			filtro_1:false,
			filterColValue:'INSTIT.nombre',
			defecto: '',
			form:true,
			
			save_as:'id_institucion'
			
		};
		
		Atributos[4]= {
		 validacion: {
			name:'relacion',
			emptyText:'Relacion',
			fieldLabel:'Relacion',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[
			['Cónyuge','Cónyuge - 1º Consanguinidad'],
			['Hijo','Hijo/Hija - 1º Consanguinidad'],
			['Padres','Padre/Madre - 1º Consanguinidad'],
			['Hermanos','Hermano(a) - 2º Consanguinidad'],
			['Abuelos','Abuelo(a) - 2º Consanguinidad'],
			['Nietos','Nieto(a) - 2º Consanguinidad'],
			['Tíos','Tío(a) - 3º Consanguinidad'],
			['Sobrinos','Sobrino(a) - 3º Consanguinidad'],
			['Bisabuelos','Bisabuelo(a) - 3º Consanguinidad'],
			['Biznietos','Biznieto(a) - 3º Consanguinidad'],
			['Primos','Primo(a) - 4º Consanguinidad'],
			['Suegros','Suegro(a) - 1º Afinidad'],
			['Cuñados','Cuñado(a) - 2º Afinidad'],
			['Nuera/Yerno','Nuera/Yerno - 3º Afinidad'],
			
			]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:false,
		filterColValue:'RELFAM.relacion',
		save_as:'relacion'
		
		};
		







		//----------- FUNCIONES RENDER

		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE

		var config={
		titulo_maestro:'Registro Empleados (Maestro)',
		titulo_detalle:'Empleados afp (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};

		lay_relfam=new DocsLayoutMaestro(idContenedor);
	    lay_relfam.init(config);
		





		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,lay_relfam,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var EstehtmlMaestro=this.htmlMaestro;
		var CM_btnNew=this.btnNew;
		var cm_EnableSelect=this.EnableSelect;
		//DEFINICIÓN DE LA BARRA DE MENÚ
		var paramMenu={guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};




		//DEFINICIÓN DE FUNCIONES

		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/relacion_familiar/ActionEliminarRelacionFamiliar.php',parametros:'&id_empleado='+maestro.id_empleado},
			Save:{url:direccion+'../../../control/relacion_familiar/ActionGuardarRelacionFamiliar.php',parametros:'&id_empleado='+maestro.id_empleado},
			ConfirmSave:{url:direccion+'../../../control/relacion_familiar/ActionGuardarRelacionFamiliar.php',parametros:'&id_empleado='+maestro.id_empleado},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'55%',width:'45%',minWidth:350,minHeight:300,	closable:true,titulo:'Relacion Familiar'
		
			
		}};
			//-------------- Sobrecarga de funciones --------------------//
			this.reload=function(params){
				var datos=Ext.urlDecode(decodeURIComponent(params));
				maestro.id_empleado=datos.id_empleado;
				Atributos[1].defecto=maestro.id_empleado;
				

			

				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						id_empleado:maestro.id_empleado
					}
				};
				
				
				
				
				this.btnActualizar();
				paramFunciones.btnEliminar.parametros='&id_empleado='+maestro.id_empleado;
				paramFunciones.Save.parametros='&id_empleado='+maestro.id_empleado;
				paramFunciones.ConfirmSave.parametros='&id_empleado='+maestro.id_empleado;
				this.InitFunciones(paramFunciones);
			};

			/*this.btnNew=function(){
				//getComponente('id_solicitud_compra').modificado=true;
				CM_btnNew()

			};*/

		/*	this.EnableSelect=function(sm,row,rec){
				cm_EnableSelect(sm,row,rec);
				_CP.getPagina(lay_sol_proc_bien.getIdContentHijo()).pagina.reload(rec.data);
				_CP.getPagina(lay_sol_proc_bien.getIdContentHijo()).pagina.desbloquearMenu();
			}*/

/*			function btn_solicitud_compra_det(){
				var sm=getSelectionModel(),filas=ds.getModifiedRecords(),cont=filas.length,NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					var data='m_id_solicitud_proceso_compra='+SelectionsRecord.data.id_solicitud_proceso_compra;
					data=data+'&m_id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
					data=data+'&m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
					data=data+'&m_id_tipo_adq='+SelectionsRecord.data.id_tipo_adq;
					data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
					data=data+'&m_tipo_adq='+SelectionsRecord.data.tipo_adq;
					data=data+'&m_simbolo='+SelectionsRecord.data.simbolo_moneda;

					data=data+'&m_solicitante='+SelectionsRecord.data.solicitante;
					data=data+'&m_num_solicitud='+SelectionsRecord.data.num_solicitud;
					data=data+'&m_num_solicitud_sis='+SelectionsRecord.data.num_solicitud_sis;
					data=data+'&m_fecha_sol='+SelectionsRecord.data.fecha_sol;
					var url='';
					if(SelectionsRecord.data.tipo_adq=='Bien'){
						url='../../../../sis_adquisiciones/vista/solicitud_compra_det/solicitud_compra_mul_item_det.php?'+data
					}else{
						url='../../../../sis_adquisiciones/vista/solicitud_compra_det/solicitud_compra_mul_serv_det.php?'+data
					}
					var ParamVentana={ventana:{width:'90%',height:'90%'}};
					lay_sol_proc_bien.loadWindows(direccion+url,'Detalle de Solicitud de Compra',ParamVentana);
					lay_sol_proc_bien.getVentana().on('resize',function(){
						lay_sol_proc_bien.getLayout().layout()
					})
				}
				else{
					Ext.MessageBox.alert('Estado','Antes debes seleccionar un item.')
				}
			}*/

			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
				/*cpm_solicitud=getComponente('id_solicitud_compra');
				getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(lay_sol_proc_bien.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(lay_sol_proc_bien.getIdContentHijo()).pagina.bloquearMenu()
					}
				})*/
			}

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return lay_relfam.getLayout()};
			
			
			//_CP.getVentana(idContenedor).addListener('beforehide',function(){_CP.getPagina(idContenedorPadre).pagina.btnActualizar()})
			//para el manejo de hijos

			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			this.InitFunciones(paramFunciones);
			//para agregar botones
			this.iniciaFormulario();
			//carga datos XML
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_empleado:maestro.id_empleado
				}
			});
			iniciarEventosFormularios();
			lay_relfam.getLayout().addListener('layout',this.onResize);
			ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}