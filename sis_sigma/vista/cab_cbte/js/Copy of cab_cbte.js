/**
* Nombre:		  	    pagina_cab_cbte.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		02/08/2010
*/
function pagina_cab_cbte(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var cmbProveedor;
	var componentes=new Array();
	var num_cotizaciones=0;
    var combo_depto,combo_cbte;
    var combo_depto_orig,combo_cbte_orig;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cab_cbte/ActionListarCabCbte.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cab_cbte',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_cab_cbte',
		'nro_cbte',
		'id_cbte',
		'compromiso',
	 	'devengado',
		'pagado',
		'operacion',
		'nro_cbte_orig',
		'id_cbte_orig',
		{name: 'fecha_validacion',type:'date',dateFormat:'Y-m-d'},
		'tipo_mov',
		'tipo_pago',
		'tipo',
		'id_declaracion',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'origen',
		'cbte_clase',
		'cbte_nro',
		'cbte_depto',
		'cbte1_clase',
		'cbte1_nro',
		'cbte1_depto',
		'modificado',
		'presentado'
		]),remoteSort:true});

		//DATA STORE COMBOS
        var ds_depto=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/depto/ActionListarDepartamentoEPUsuario.php?subsistema=sci"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','nombre_depto','codigo_depto'])});
        var ds_cbte=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_contabilidad/control/comprobante/ActionListarRegistroComprobante.php?m_sw_vista=libro_diario'}),reader: new Ext.data.XmlReader({record:'ROWS',id:'id_comprobante',totalRecords:'TotalCount'},['id_comprobante','nro_cbte','desc_clase','acreedor'])});
		var tpl_id_depto=new Ext.Template('<div class="search-item">','{nombre_depto}<br>','<b><FONT COLOR="#B5A642">{codigo_depto}</FONT></b>','</div>');
		var tpl_id_cbte=new Ext.Template('<div class="search-item">',
										'<b>Nº: </b><FONT COLOR="#0000ff">{nro_cbte}</FONT>',
										'<br><b>Tipo: </b><FONT COLOR="#0000ff">{desc_clase}</FONT>',
										'<br><b>Acreedor: </b><FONT COLOR="#0000ff">{acreedor}</FONT>','</div>');
	function render_cbte(value, p, record){return String.format('{0}', record.data['id_cbte']);}
        //FUNCIONES RENDER
		function render_presentado(value, p, record){
			if(value=='t'){
				return 'Si';
			} else{
				return '<span style="color:red;font-size:8pt"><b>NO</b> </span>';
			}
		}
		function render_tipo(value)
	{
		if(value=='gasto'){value='Gasto'	}
		else if(value=='recurso'){value='Recurso'	}
		return value
	}
	function render_depto(value,p,record){return String.format('{0}',record.data['cbte_depto'])}
		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_cotizacion
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_cab_cbte',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};
	
		Atributos[1]={
				validacion:{
					name:'tipo',
					fieldLabel:'Tipo',
					allowBlank:false,
			        typeAhead: true,
				    loadMask: true,
					triggerAction: 'all',			
					store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['gasto','Gasto'],['recurso','Recurso']]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					renderer:render_tipo,
					forceSelection:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:70,
					grid_indice:1
				},
				tipo:'ComboBox',
				filtro_0:true,
				filtro_1:true,
				filtro_2:true,
				filterColValue:'CABCBT.tipo'
			};
		
 	
		Atributos[3]= {
				validacion: {
					name:'compromiso',
					fieldLabel:'Compromiso',
					allowBlank:false,
					loadMask: true,
					triggerAction: 'all',
					store:new Ext.data.SimpleStore({
						fields:['ID','valor'],data:[['S','S'],['N','N']						           
					]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					forceSelection:true,
					grid_visible:true,
					grid_editable:true,
					width:120,
					width_grid:70,
					grid_indice:2
				},
				tipo:'ComboBox',
				filtro_0:true,
				filtro_1:true,
				filtro_2:true,
				filterColValue:'CABCBT.compromiso'
			};
		
		Atributos[4]= {
				validacion: {
					name:'devengado',
					fieldLabel:'Devengado',
					allowBlank:false,
					loadMask: true,
					triggerAction: 'all',
					store:new Ext.data.SimpleStore({
						fields:['ID','valor'],data:[['S','S'],['N','N']						           
					]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					forceSelection:true,
					grid_visible:true,
					grid_editable:true,
					width:120,
					width_grid:70,
					grid_indice:2
				},
				tipo:'ComboBox',
				filtro_0:true,
				filtro_1:true,
				filtro_2:true,
				filterColValue:'CABCBT.devengado'
			};
		
		Atributos[5]= {
				validacion: {
					name:'pagado',
					fieldLabel:'Pagado',
					allowBlank:false,
					loadMask: true,
					triggerAction: 'all',
					store:new Ext.data.SimpleStore({
						fields:['ID','valor'],data:[['S','S'],['N','N']						           
					]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					forceSelection:true,
					grid_visible:true,
					grid_editable:true,
					width:120,
					width_grid:70,
					grid_indice:2
				},
				tipo:'ComboBox',
				filtro_0:true,
				filtro_1:true,
				filtro_2:true,
				filterColValue:'CABCBT.pagado'
			};
		   	Atributos[6]={
				validacion:{
					fieldLabel:'Depto.',
					allowBlank:false,
		            vtype:'texto',
					emptyText:'Depto ...',
					name:'cbte_depto',
					desc:'cbte_depto',
					store:ds_depto,
					valueField:'id_depto',
					displayField:'nombre_depto',
					queryParam:'filterValue_0',
					filterCol:'nombre_depto',
					typeAhead:true,
					forceSelection:true,
					renderer:render_depto,
					mode:'remote',
					queryDelay:50,
					pageSize:10,
					minListWidth:300,
					width:200,
					tpl:tpl_id_depto,
					resizable:true,
					minChars:0,
					triggerAction:'all',
					editable:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:70,
					grid_indice:8
				},
				tipo:'ComboBox',
				filtro_0:true,
				filtro_1:true,
				filtro_2:true,
				filterColValue:'DEPTO.codigo_depto'
			};
			
	
		var filterCols_id_cbte=new Array();
	    var filterValues_id_cbte=new Array();
	    filterCols_id_cbte[0]='compro.id_depto';
	    filterValues_id_cbte[0]='%';
		Atributos[7]={
				validacion:{
				fieldLabel:'ID.Cbte.',
				allowBlank:false,
				vtype:'texto',
				emptyText:'ID.Cbte...',
				name:'id_cbte',
				desc:'id_cbte',
				store:ds_cbte,
				valueField:'id_comprobante',
				displayField:'nro_cbte',
				queryParam:'filterValue_0',
				tpl:tpl_id_cbte,
				filterCol:'COMPRO.nro_cbte',
				filterCols:filterCols_id_cbte,
			    filterValues:filterValues_id_cbte,
				typeAhead:true,
				forceSelection:true,
				renderer:render_cbte,		
				mode:'remote',
				queryDelay:50,
				pageSize:10,
				minListWidth:300,
				width:200,
				resizable:true,
				minChars:0,
				triggerAction:'all',
				editable:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:70,
				grid_indice:7
				},
				tipo:'ComboBox',
				filtro_0:true,
				filtro_1:true,
				filtro_2:true,
				filterColValue:'CABCBT.id_cbte'
			};
		Atributos[2]={
				validacion:{
					name:'nro_cbte_orig',
					fieldLabel:'Correl.Orig.',
					grid_visible:true,
					grid_editable:false,
					width_grid:70,
					grid_indice:14
				},
				tipo: 'Field',
				form:false,
				filtro_0:true,
				filtro_1:true,
				filtro_2:true,
				filterColValue:'CABCBT.nro_cbte_orig'
			};
			Atributos[8]={
				validacion:{
					name:'nro_cbte',
					fieldLabel:'Correl.',
					grid_visible:true,
					grid_editable:false,
					width_grid:70,
					grid_indice:5
				},
				tipo:'TextField',
				filtro_0:true,
				filtro_1:true,
				filtro_2:true,
				filterColValue:'CABCBT.nro_cbte'
			};
		
			Atributos[9]={
				validacion:{									
					name:'operacion',
					fieldLabel:'Operación',
					allowBlank:false,
					loadMask:true,
					triggerAction:'all',
					store:new Ext.data.SimpleStore({
						fields:['ID','valor'],data:[['O','O'],['R','R']
					]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					forceSelection:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:65,
					grid_indice:11
				},
				tipo:'ComboBox',
				filtro_0:true,
				filtro_1:true,
				filtro_2:true,
				filterColValue:'CABCBT.operacion'
			};
		Atributos[18]={
				validacion:{
					name:'fecha_validacion',
					fieldLabel:'Fecha validación',
					grid_visible:true,
					grid_editable:false,
					width_grid:80,
					grid_indice:10,
					renderer:formatDate
				},
				tipo: 'Field',
				form:false,
				filtro_0:false,
				dateFormat:'m-d-Y',
				filterColValue:'CABCBT.fecha_validacion'
			};
			
		Atributos[10]={
				validacion:{
					name:'origen',
					fieldLabel:'Origen',
					allowBlank:false,
					loadMask:true,
					triggerAction:'all',
					store:new Ext.data.SimpleStore({
						fields:['ID','valor'],data:[['O','Original'],['R','Reversión']
					]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					forceSelection:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:70,
					grid_indice:11
				},
				tipo:'ComboBox',
				filtro_0:true,
				filtro_1:true,
				filtro_2:true,
				filterColValue:'CABCBT.origen'
			};
		Atributos[11]={
				validacion:{
					name:'tipo_mov',
					fieldLabel:'Tipo Mov',
					allowBlank:false,
					loadMask:true,
					triggerAction:'all',
					store:new Ext.data.SimpleStore({
						fields:['ID','valor'],data:[['N','Normal'],['R','Regularización']
					]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					forceSelection:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:70,
					grid_indice:12
				},
				tipo:'ComboBox',
				filtro_0:true,
				filtro_1:true,
				filtro_2:true,
				filterColValue:'CABCBT.tipo_mov'
			};
		
		Atributos[15]={
				validacion:{
					name:'tipo_pago',
					fieldLabel:'Tipo Pago',
					allowBlank:false,
					loadMask:true,
					triggerAction:'all',
					store:new Ext.data.SimpleStore({
						fields:['ID','valor'],data:[['B','Beneficiarios'],['A','Acreedores']
					]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					forceSelection:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:70,
					grid_indice:13
				},
				tipo:'ComboBox',
				filtro_0:true,
				filtro_1:true,
				filtro_2:true,
				filterColValue:'CABCBT.tipo_pago'
			};
	
		Atributos[13]={
				validacion:{
					labelSeparator:'',
					name: 'id_declaracion',
					inputType:'hidden',
					grid_visible:false,
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false
			};
		
		Atributos[14]={
				validacion:{
					name:'fecha_reg',
					fieldLabel:'Fecha Reg.',
					grid_visible:true,
					grid_editable:false,
					width_grid:70,
					grid_indice:19,
					renderer:formatDate
				},
				tipo: 'Field',
				form:false,
				filtro_0:false,
				dateFormat:'m-d-Y',
				filterColValue:'CABCBT.fecha_reg'
			};
	
		
		Atributos[16]={
				validacion:{
					name:'cbte_clase',
					fieldLabel:'Tipo Cbte.',
					grid_visible:true,
					grid_editable:false,
					width_grid:120,
					grid_indice:9
				},
				tipo: 'Field',
				form:false,
				filtro_0:false,
				filterColValue:'CLACBT.titulo_cbte'
			};
		
		Atributos[17]={
				validacion:{
					name:'cbte_nro',
					fieldLabel:'Num.Cbte.',
					grid_visible:true,
					grid_editable:false,
					width_grid:70,
					grid_indice:6
				},
				tipo: 'Field',
				form:false,
				filtro_0:true,
				filtro_1:true,
				filtro_2:true,
				filterColValue:'CBTE.nro_cbte'
			};
		
	
		
		Atributos[19]={
				validacion:{
					name:'cbte1_clase',
					fieldLabel:'Tipo Cbte.Orig.',
					grid_visible:true,
					grid_editable:false,
					width_grid:100,
					grid_indice:17
				},
				tipo: 'Field',
				form:false,
				filtro_0:false,
				filterColValue:'CLACBT1.titulo_cbte'
			};
		
		Atributos[20]={
				validacion:{
					name:'cbte1_nro',
					fieldLabel:'Nro.Cbte.Orig.',
					grid_visible:true,
					grid_editable:false,
					width_grid:70,
					grid_indice:15
				},
				tipo:'Field',
				form:false,
				filtro_0:true,
				filtro_1:true,
				filtro_2:true,
				filterColValue:'CBTE1.nro_cbte'
			};
		
		Atributos[21]={
				validacion:{
					fieldLabel:'Depto.Orig.',
					allowBlank:true,
		            vtype:'texto',
					emptyText:'Depto.Orig...',
					name:'cbte1_depto',
					desc:'cbte1_depto',
					store:ds_depto,
					valueField:'id_depto',
					displayField:'nombre_depto',
					queryParam:'filterValue_0',
					filterCol:'nombre_depto',
					typeAhead:true,
					forceSelection:true,
					renderer:render_depto,
					mode:'remote',
					queryDelay:50,
					pageSize:10,
					minListWidth:300,
					width:200,
					tpl:tpl_id_depto,
					resizable:true,
					minChars:0,
					triggerAction:'all',
					editable:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:70,
					grid_indice:18
				},
				tipo:'ComboBox',
				filtro_0:true,
				filtro_1:true,
				filtro_2:true,
				filterColValue:'DEPTO1.codigo_depto'
			};
		var filterCols_id_cbte_orig=new Array();
	    var filterValues_id_cbte_orig=new Array();
	    filterCols_id_cbte_orig[0]='compro.id_depto';
	    filterValues_id_cbte_orig[0]='%';	
		Atributos[22]={
				validacion:{
				fieldLabel:'Id.Cbte.Orig.',
				allowBlank:true,
				vtype:'texto',
				emptyText:'ID.Cbte.Orig...',
				name:'id_cbte_orig',
				desc:'id_cbte_orig',
				store:ds_cbte,
				valueField:'id_comprobante',
				displayField:'nro_cbte',
				queryParam:'filterValue_0',
				tpl:tpl_id_cbte,
				filterCol:'COMPRO.nro_cbte',
				filterCols:filterCols_id_cbte_orig,
			    filterValues:filterValues_id_cbte_orig,
				typeAhead:true,
				forceSelection:true,
				renderer:render_cbte,		
				mode:'remote',
				queryDelay:50,
				pageSize:10,
				minListWidth:300,
				width:200,
				resizable:true,
				minChars:0,
				triggerAction:'all',
				editable:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:75,
				grid_indice:16					
				},
				tipo:'ComboBox',
				filtro_0:true,
				filtro_1:true,
				filtro_2:true,
				filterColValue:'CABCBT.id_cbte_orig'
			};
		Atributos[12]={
				validacion:{
					name:'modificado',
					fieldLabel:'Modificado',
					grid_visible:true,
					grid_editable:false,
					width_grid:60,
					grid_indice:-1
				},
				tipo:'Field',
				form:false,
				filtro_0:true,
				filtro_1:true,
				filtro_2:true,
				filterColValue:'CABCBT.modificado'
			};
		
		Atributos[23]={
				validacion:{
					name:'presentado',
					fieldLabel:'Presentado',
					grid_visible:true,
					grid_editable:false,
					width_grid:70,
					grid_indice:-2,
					renderer:render_presentado
				},
				tipo: 'Field',
				form:false,
				filtro_0:false,
				filtro_1:false,
				filtro_2:false,
				filterColValue:'CABCBT.nro_cbte'
			};
	
		//----------- FUNCIONES RENDER
		function formatDate(value){
		     return value?value.dateFormat('d/m/Y'):''
		}

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:' (Maestro)',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_sigma/vista/cbte_det/cbte_det.php'};

		var layout = new DocsLayoutMaestroDeatalle(idContenedor,idContenedorPadre);
		layout.init(config);



		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,layout,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_btnNew=this.btnNew;
		var CM_btnEdit=this.btnEdit;
		var CM_btnDelete=this.btnEliminar;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_conexionFailure=this.conexionFailure;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_saveSuccess=this.saveSuccess;
		var CM_mostrarComponente=this.mostrarComponente;
		var getDialog=this.getDialog;
		var getGrid=this.getGrid;
		var enableSelect=this.EnableSelect;
		var selModel=this.getSelectionModel;
		var EstehtmlMaestro=this.htmlMaestro;

		//DEFINICIÓN DE LA BARRA DE MENÚ
		var paramMenu={guardar:{crear:true,separador:true},nuevo:{crear:true,separador:true},actualizar:{crear:true,separador:false}};
		//DEFINICIÓN DE FUNCIONES

		var paramFunciones={
			Save:{url:direccion+'../../../control/cab_cbte/ActionGuardarCabCbte.php',parametros:'&m_id_declaracion='+maestro.id_declaracion},
			ConfirmSave:{url:direccion+'../../../control/cab_cbte/ActionGuardarCabCbte.php',parametros:'&m_id_declaracion='+maestro.id_declaracion},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:380,width:'38%',minWidth:550,minHeight:200,	closable:true,titulo:'Cabecera'}};

			//-------------- Sobrecarga de funciones --------------------//
			this.reload=function(params){
				var datos=Ext.urlDecode(decodeURIComponent(params));
				maestro.id_declaracion=datos.m_id_declaracion;
				maestro.gestion=datos.m_gestion;
				maestro.mes=datos.m_mes;
				maestro.estado=datos.m_estado;
				maestro.id_gestion=datos.m_id_gestion;
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_declaracion:maestro.id_declaracion
					}
				};
				
				_CP.getPagina(layout.getIdContentHijo()).pagina.limpiarStore();

				this.btnActualizar();
				iniciarEventosFormularios();

				//gridMaestro.getDataSource().removeAll();

				//gridMaestro.getDataSource().loadData([['Nº Proceso',maestro.num_proceso],['Codigo',maestro.codigo_proceso],['Observaciones',maestro.lugar_entrega]]);
				Atributos[13].defecto=maestro.id_declaracion;
				paramFunciones.Save.parametros='&m_id_declaracion='+maestro.id_declaracion;
				paramFunciones.ConfirmSave.parametros='&m_id_declaracion='+maestro.id_declaracion;
				this.iniciarEventosFormularios;
				this.InitFunciones(paramFunciones);
			};
			//Para manejo de eventos
			function iniciarEventosFormularios(){
				combo_depto=getComponente('cbte_depto');
		        combo_cbte=getComponente('id_cbte');
		        combo_depto_orig=getComponente('cbte1_depto');
		        combo_cbte_orig=getComponente('id_cbte_orig');
		      
		var onDeptoSelect=function(e){
			var id=combo_depto.getValue()
			combo_cbte.filterValues[0]=id;
			combo_cbte.modificado=true;
			combo_cbte.enable();
			combo_cbte.allowBlank=false;
			combo_cbte.setValue('')
		};
		var onDeptoOrigSelect=function(e){
			var id=combo_depto_orig.getValue()
			combo_cbte_orig.filterValues[0]=id;
			combo_cbte_orig.modificado=true;
			combo_cbte_orig.enable();
			combo_cbte_orig.allowBlank=false;
			combo_cbte_orig.setValue('')
		};
		combo_depto.on('select',onDeptoSelect);
		combo_depto.on('change',onDeptoSelect);
		combo_depto_orig.on('select',onDeptoOrigSelect);
		combo_depto_orig.on('change',onDeptoOrigSelect)
				}
			
			//evento de deselecion de una linea de grid
			getSelectionModel().on('rowdeselect',function(){
				if(_CP.getPagina(layout.getIdContentHijo()).pagina.limpiarStore()){
					_CP.getPagina(layout.getIdContentHijo()).pagina.bloquearMenu();
				}
			})

			this.EnableSelect=function(sm,row,rec){
				_CP.getPagina(layout.getIdContentHijo()).pagina.reload(rec.data,maestro.gestion);
				if(rec.data.modificado=='M'){
				   _CP.getPagina(layout.getIdContentHijo()).pagina.desbloquearMenu();	
				}
				
				enableSelect(sm,row,rec);
			}


			//para que los hijos puedan ajustarse al tamaño  
			this.getLayout=function(){return layout.getLayout()};
			//para el manejo de hijos

			this.Init(); //iniciamos la clase madre

			this.InitBarraMenu(paramMenu);

			this.InitFunciones(paramFunciones);
			//para agregar botones
			
			this.iniciaFormulario();
			iniciarEventosFormularios();
			//carga datos XML
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_declaracion:maestro.id_declaracion
				}
			});
			layout.getLayout().addListener('layout',this.onResize);
			//layout_proceso_compra.getVentana().addListener('beforehide',salta);
			ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}