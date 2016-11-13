/**
* Nombre:		  	    pagin_vobo_detalle.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-16 09:53:33
*/
function pagina_vobo_detalle(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var tituloM,maestro;

	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/detalle_vobo/ActionListarDetalleVobo.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_vobo_detalle',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_vobo_detalle',
		'id_depto',
        'desc_depto',
		'id_usuario',
        'desc_empleado',
		'id_partida_vobo',
        'estado_reg'
		
		]),remoteSort:true});

		//	//DATA STORE COMBOS
		
//   var ds_depto= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?oc=si'}),
//		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto'])
//		});

		var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuario.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['id_usuario','id_persona','desc_persona','login'])
	});

		//FUNCIONES RENDER
		
//			function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto']);}
//		var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','{nombre_depto}','</div>');

		function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
		var tpl_id_empleado=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{login}</FONT><br>','{desc_persona}<br>','</div>');

		
		/////////////////////////
		// Definición de datos //
		/////////////////////////
		// hidden id_solicitud_compra_det
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_vobo_detalle',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_vobo_detalle'
			
		};

		// txt id_item_antiguo
//		Atributos[1]={
//			validacion:{
//				name:'id_depto',
//				fieldLabel:'Departamento de Adquisiciones',
//				allowBlank:false,
//				emptyText:'Depto Adquisiciones...',
//				desc: 'desc_depto', //indica la columna del store principal ds del que proviane la descripcion
//				store:ds_depto,
//				valueField: 'id_depto',
//				displayField: 'nombre_depto',
//				queryParam: 'filterValue_0',
//				filterCol:'DEPTO.codigo_depto#DEPTO.nombre_depto',
//				typeAhead:true,
//				tpl:tpl_id_depto,
//				forceSelection:true,
//				mode:'remote',
//				queryDelay:250,
//				pageSize:100,
//				minListWidth:'100%',
//				grow:true,
//				resizable:true,
//				queryParam:'filterValue_0',
//				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
//				triggerAction:'all',
//				editable:true,
//				renderer:render_id_depto,
//				grid_visible:true,
//				grid_editable:false,
//				width_grid:280,
//				width:180,
//				disabled:false
//
//			},
//			tipo:'ComboBox',
//			form: true,
//			filtro_0:true,
//			filterColValue:'DEPTO.nombre_depto#DEPTO.codigo_depto',
//			save_as:'id_depto'
//		};
		
		// txt id_item
		Atributos[1]={
			validacion:{
			name:'id_usuario',
			fieldLabel:'Funcionario',
			allowBlank:false,			
			emptyText:'Funcionario...',
			desc: 'desc_empleado', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_usuario',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_empleado,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'85%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'85%',
			disabled:false
			
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON_1.apellido_paterno#PERSON_1.apellido_materno#PERSON_1.nombre'
		
	};
	
	Atributos[2]={
			validacion: {
			name:'estado_reg',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['inactivo','inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			disabled:false
			
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'VBDET.estado_reg',
		defecto:'activo'
	};
	
Atributos[3]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_depto',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_depto'
			
			
		};
		
	
		//----------- FUNCIONES RENDER

		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
		
		tituloM='Solicitud Detalle';

		//---------- INICIAMOS LAYOUT DETALLE
	
//		var layout_vobo_detalle = new DocsLayoutMaestro(idContenedor);
//		layout_vobo_detalle.init({titulo_maestro:'Partidas - Verificación(Maestro)',titulo_detalle:'Empleado - Verificación',grid_maestro:'grid-'+idContenedor});

	//var config={titulo_maestro:'Partida-Verificacion',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/partida_vobo/partida_vobo.php'};
	
	//var config={titulo_maestro:'Solicitud de Compra',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/solicitud_compra_bien/sol_compra_bien_det.php'};
	var layout_vobo_detalle=new DocsLayoutMaestro(idContenedor);
	//layout_vobo_detalle.init(config);
	layout_vobo_detalle.init({titulo_maestro:'Partidas - Verificación(Maestro)',titulo_detalle:'Empleado - Verificación',grid_maestro:'grid-'+idContenedor});



		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,layout_vobo_detalle,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var CM_btnNew=this.btnNew;
		var CM_btnEdit=this.btnEdit;
		var getGrid=this.getGrid;
		var Cm_conexionFailure=this.conexionFailure;
		var dialog= this.getFormulario;
		var EstehtmlMaestro=this.htmlMaestro;
		var cm_EnableSelect=this.EnableSelect;
		//DEFINICIÓN DE LA BARRA DE MENÚ
		var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
		//DEFINICIÓN DE FUNCIONES

		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/detalle_vobo/ActionEliminarDetalleVobo.php'},
			Save:{url:direccion+'../../../control/detalle_vobo/ActionGuardarDetalleVobo.php'},
			ConfirmSave:{url:direccion+'../../../control/detalle_vobo/ActionGuardarDetalleVobo.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:'55%',minWidth:150,minHeight:200,closable:true,titulo:'Empleado-Verificación Técnica',

			}};



			//-------------- Sobrecarga de funciones --------------------//
			this.reload=function(m){
				maestro=m;

				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_depto:maestro.id_depto
					}
				};
				this.btnActualizar();
				
				Atributos[3].defecto=maestro.id_depto;
				paramFunciones.btnEliminar.parametros='&m_id_depto='+maestro.id_depto;
				paramFunciones.Save.parametros='&m_id_depto='+maestro.id_depto;
				paramFunciones.ConfirmSave.parametros='&m_id_depto='+maestro.id_depto;
				this.InitFunciones(paramFunciones)
			};


			
			function iniciarEventosFormularios(){
			
			}

				function btn_partida(){
					var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
					if(NumSelect!=0){
						var SelectionsRecord=sm.getSelected();
						var data='m_id_vobo_detalle='+SelectionsRecord.data.id_vobo_detalle;
						data=data+'&codigo_depto='+SelectionsRecord.data.codigo_depto;
						data=data+'&nombre_depto='+SelectionsRecord.data.nombre_depto;
			
						var ParamVentana={Ventana:{width:'90%',height:'70%'}}
						layout_vobo_detalle.loadWindows(direccion+'../../../../sis_adquisiciones/vista/partida_vobo/partida_vobo.php?'+data,'Partida-Verificación',ParamVentana);
					}
					else
					{
						Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
					}
				}




			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_vobo_detalle.getLayout()};
			//para el manejo de hijos

			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			this.InitFunciones(paramFunciones);
			//para agregar botones

			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Partidas - Verificacion',btn_partida,true,'partida_verif','');
			this.iniciaFormulario();
			iniciarEventosFormularios();

	
			this.bloquearMenu();
			layout_vobo_detalle.getLayout().addListener('layout',this.onResize);
			
			//ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
			ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}