/**
* Nombre:		  	    pagina_cbte_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-28 17:32:15
*/
function pagina_cbte_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var combo_presupuesto;
	var combo_partida;
	var combo_transaccion;
	var comp,ds_tipo,data_tipo;
	/////////////////
	//  DATA STORE //
	/////////////////
	
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cbte_det/ActionListarCbteDet.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id:'id_cbte_det',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		
		'id_cbte_det',
		'ent_trf',
		'libreta',
		'importe',
	 	'tipo_dato',
		'tipo',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_cab_cbte',
		'id_presupuesto',
		'id_partida',
		'id_oec',
		'id_cuenta_bancaria',
		'cuenta_sigma',
		'id_transaccion',
		'desc_presupuesto',
		'partida',
		'sigla_oec',
		'codigo_oec',
		'desc_oec',
		'banco',
		'reportar',
		'fuente_fin',
		'organismo_fin',
		'programa',
		'proyecto',
		'actividad'
		
		]),remoteSort:true});

		//FUNCIONES RENDER
		
		function render_partida(value, p, record){return record.data['partida'];};
		function render_id_cuenta_bancaria(value, p, record){return record.data['banco'];};
		function render_cuenta(value,p,record){return String.format('{0}',record.data['cuenta_sigma'])};
		function render_presupuesto(value, p, record){return record.data['desc_presupuesto'];};
		function render_transaccion(value, p, record){return record.data['id_transaccion'];};
		// DEFINICIÓN DATOS DEL MAESTRO

		/*var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");*/
	
		//DATA STORE COMBOS
        var ds_cuenta=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php?sw_sigma=si"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords:'TotalCount'},['id_cuenta','nombre_cuenta','desc_cuenta'])});
        var tpl_cuenta=new Ext.Template('<div class="search-item">','{nombre_cuenta}<br>','<b><FONT COLOR="#B5A642">{desc_cuenta}</FONT></b>','</div>');
		var ds_cuenta_bancaria=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords:'TotalCount'},['id_cuenta_bancaria','desc_institucion','desc_cuenta'])});
        var tpl_cuenta_bancaria=new Ext.Template('<div class="search-item">','{desc_institucion}<br>','<b><FONT COLOR="#B5A642">{desc_cuenta}</FONT></b>','</div>');
        var ds_presupuesto=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_presupuesto/control/presupuesto/ActionListarPresupuestoDepto.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords:'TotalCount'},['id_presupuesto','desc_presupuesto','tipo_pres'])});
        var tpl_presupuesto=new Ext.Template('<div class="search-item">','{desc_presupuesto}<br>','<b><FONT COLOR="#B5A642">{tipo_pres}</FONT></b>','</div>');
        var ds_partida=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_presupuesto/control/partida/ActionListarPartida.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords:'TotalCount'},['id_partida','nombre_partida','codigo_partida','desc_par'])});
        var tpl_partida=new Ext.Template('<div class="search-item">','{nombre_partida}<br>','<b><FONT COLOR="#B5A642">{codigo_partida}</FONT></b>','</div>');
        var ds_transaccion=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_contabilidad/control/transaccion/ActionListarRegistroTransacion.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_transaccion',totalRecords:'TotalCount'},['id_transaccion','desc_comprobante','desc_fuente_financiamiento'])});
        var tpl_transaccion=new Ext.Template('<div class="search-item">','{desc_fuente_financiamiento}<br>','<b><FONT COLOR="#B5A642">{desc_comprobante}</FONT></b>','</div>');
        /////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_cotizacion_det
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name:'id_cbte_det',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo:'Field',
			filtro_0:false
		};
	Atributos[1]= {
				validacion: {
					name:'reportar',
					fieldLabel:'Reportar',
					allowBlank:false,
					loadMask: true,
					triggerAction: 'all',
					store:new Ext.data.SimpleStore({
						fields:['ID','valor'],data:[['si','Si'],['no','No']						           
					]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					forceSelection:true,
					grid_visible:true,
					grid_editable:true,
					width:120,
					width_grid:60,
					grid_indice:-1
				},
				tipo:'ComboBox',
				filtro_0:true,
				filtro_1:false,
				filterColValue:'CBTEDE.reportar'
			};
		

			Atributos[2]= {
				validacion: {
					name:'tipo',
					fieldLabel:'Tipo',
					allowBlank:false,
					loadMask: true,
					triggerAction: 'all',
					store:new Ext.data.SimpleStore({
						fields:['ID','valor'],data:[['gasto','gasto'],['recurso','recurso'],['anexo_gasto','anexo_gasto'],['anexo_recurso','anexo_recurso']]}),
					//store: ds_tipo,
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					forceSelection:true,
					grid_visible:true,
					grid_editable:true,
					width:120,
					width_grid:60,
					grid_indice:1
				},
				tipo:'ComboBox',
				filtro_0:true,
				filtro_1:false,
				filterColValue:'CBTEDE.tipo'
			};
		

			Atributos[3]= {
				validacion: {
					name:'tipo_dato',
					fieldLabel:'Tipo Dato',
					allowBlank:false,
					loadMask: true,
					triggerAction: 'all',
					store:new Ext.data.SimpleStore({
						fields:['ID','valor'],data:[['C','C'],['F','F']						           
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
				filtro_1:false,
				filterColValue:'CBTEDE.tipo_dato'
			};
		Atributos[4]={
				validacion:{
					name:'importe',
					fieldLabel:'Importe',
					grid_visible:true,
					grid_editable:false,
					width_grid:70,
					grid_indice:3
				},
				tipo:'TextField',
				filtro_0:true,
				filterColValue:'CBTEDE.importe'
			};
			Atributos[5]={
				validacion:{
					fieldLabel:'Cuenta Sigma',
					allowBlank:true,
		            vtype:'texto',
					emptyText:'Cuenta Sigma ...',
					name:'cuenta_sigma',
					desc:'cuenta_sigma',
					store:ds_cuenta,
					valueField:'id_cuenta',
					displayField:'desc_cuenta',
					queryParam:'filterValue_0',
					filterCol:'CUENTA.nombre_cuenta',
					typeAhead:true,
					forceSelection:true,
					renderer:render_cuenta,
					mode:'remote',
					queryDelay:50,
					pageSize:10,
					minListWidth:300,
					width:200,
					tpl:tpl_cuenta,
					resizable:true,
					minChars:0,
					triggerAction:'all',
					editable:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:100,
					grid_indice:4
				},
				tipo:'ComboBox',
				filtro_0:true,
				form:false,
				filterColValue:'CBTEDE.cuenta_sigma'
			};
			Atributos[6]={
				validacion:{
					fieldLabel:'Cuenta Bancaria',
					allowBlank:false,
		            vtype:'texto',
					emptyText:'Cuenta Banc....',
					name:'id_cuenta_bancaria',
					desc:'banco',
					store:ds_cuenta_bancaria,
					valueField:'id_cuenta_bancaria',
					displayField:'desc_cuenta',
					queryParam:'filterValue_0',
					filterCol:'CUENTA.nro_cuenta',
					typeAhead:true,
					forceSelection:true,
					renderer:render_id_cuenta_bancaria,
					mode:'remote',
					queryDelay:50,
					pageSize:10,
					minListWidth:300,
					width:200,
					tpl:tpl_cuenta_bancaria,
					resizable:true,
					minChars:0,
					triggerAction:'all',
					editable:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:120,
					grid_indice:5
				},
				tipo:'ComboBox',
				filtro_0:true,
				filterColValue:'CBTEDE.id_cuenta_bancaria'
			};
			Atributos[7]={
				validacion:{
					name:'ent_trf',
					fieldLabel:'Ent.Transf.',
					grid_visible:true,
					grid_editable:false,
					width_grid:70,
					grid_indice:6
				},
				tipo:'TextField',
				filtro_0:true,
				form:false,
				filterColValue:'CBTEDE.ent_trf'
			};
					
		Atributos[11]={
				validacion:{
					name:'fecha_reg',
					fieldLabel:'Fecha Reg.',
					grid_visible:true,
					grid_editable:false,
					width_grid:70,
					grid_indice:14
				},
				tipo: 'Field',
				form:false,
				filtro_0:false,
				filterColValue:'CBTEDE.fecha_reg'
			};		
		Atributos[17]={
				validacion:{
					labelSeparator:'',
					name: 'id_cab_cbte',
					inputType:'hidden',
					grid_visible:false,
					grid_editable:false
				},
				tipo:'Field',
				filtro_0:false
			};
		
		Atributos[8]={
				validacion:{
					name:'libreta',
					fieldLabel:'Libreta',
					grid_visible:true,
					grid_editable:false,
					width_grid:70,
					grid_indice:7
				},
				tipo:'TextField',
				filtro_0:false,
				filterColValue:'CBTEDE.libreta'
			};	
			var filterCols_id_presupuesto=new Array();
	    var filterValues_id_presupuesto=new Array();
	    filterCols_id_presupuesto[0]='PARAMP.gestion_pres';
	    filterValues_id_presupuesto[0]='%';
		Atributos[9]={
				validacion:{
					fieldLabel:'Presupuesto',
					allowBlank:false,
		            vtype:'texto',
					emptyText:'Presupuesto ...',
					name:'id_presupuesto',
					desc:'desc_presupuesto',
					store:ds_presupuesto,
					valueField:'id_presupuesto',
					displayField:'desc_presupuesto',
					queryParam:'filterValue_0',
					filterCols:filterCols_id_presupuesto,
			        filterValues:filterValues_id_presupuesto,
					filterCol:'PRESUP.desc_presupuesto',
					typeAhead:true,
					forceSelection:true,
					renderer:render_presupuesto,
					mode:'remote',
					queryDelay:50,
					pageSize:10,
					minListWidth:300,
					width:200,
					tpl:tpl_presupuesto,
					resizable:true,
					minChars:0,
					triggerAction:'all',
					editable:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:140,
					grid_indice:8
				},
				tipo:'ComboBox',
				filtro_0:true,
				filterColValue:'PRESTO.desc_presupuesto'
			};

		var filterCols_id_partida=new Array();
	    var filterValues_id_partida=new Array();
	    filterCols_id_partida[0]='PARAMP.gestion_pres';
	    filterValues_id_partida[0]='%';
        filterCols_id_partida[1]='PARTID.sw_transaccional';
	    filterValues_id_partida[1]='1';
		Atributos[10]={
				validacion:{
					fieldLabel:'Partida',
					allowBlank:false,
		            vtype:'texto',
					emptyText:'Partida ...',
					name:'id_partida',
					desc:'partida',
					store:ds_partida,
					valueField:'id_partida',
					displayField:'desc_par',
					queryParam:'filterValue_0',
					filterCols:filterCols_id_partida,
			        filterValues:filterValues_id_partida,
					filterCol:'PARTID.codigo_partida',
					typeAhead:true,
					forceSelection:true,
					renderer:render_partida,
					mode:'remote',
					queryDelay:50,
					pageSize:10,
					minListWidth:300,
					width:200,
					tpl:tpl_partida,
					resizable:true,
					minChars:0,
					triggerAction:'all',
					editable:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:120,
					grid_indice:9
				},
				tipo:'ComboBox',
				filtro_0:true,
				filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida'
			};
       
			Atributos[12]={
				validacion:{
					labelSeparator:'',
					name:'id_transaccion',
					inputType:'hidden',
					grid_visible:false,
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false
			};		
		Atributos[13]={
				validacion:{
					labelSeparator:'',
					name: 'id_oec',
					inputType:'hidden',
					grid_visible:false,
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false
			};

		Atributos[14]={
				validacion:{
					name:'sigla_oec',
					fieldLabel:'Sigla OEC',
					grid_visible:true,
					grid_editable:false,
					width_grid:70,
					grid_indice:11
				},
				tipo: 'Field',
				form:false,
				filtro_0:false,
				filterColValue:'CABCBT.nro_cbte'
			};
		
		Atributos[15]={
				validacion:{
					name:'codigo_oec',
					fieldLabel:'Código OEC',
					grid_visible:true,
					grid_editable:false,
					width_grid:90,
					grid_indice:12
				},
				tipo: 'Field',
				filtro_0:false,
				form:false,
				filterColValue:'OOEECC.codigo_oec'
			};

		Atributos[16]={
				validacion:{
					name:'desc_oec',
					fieldLabel:'Descripción OEC',
					grid_visible:true,
					grid_editable:false,
					width_grid:150,
					grid_indice:13
				},
				tipo: 'Field',
				filtro_0:false,
				form:false,
				filterColValue:'OOEECC.desc_oec'
			};
			
			Atributos[18]={
				validacion:{
					name:'fuente_fin',
					fieldLabel:'Fuente Fin.',
					grid_visible:true,
					grid_editable:false,
					width_grid:90
				},
				tipo: 'Field',
				filtro_0:true,
				form:false,
				filterColValue:'FUEFIN.sigla'
			};
			
			Atributos[19]={
				validacion:{
					name:'organismo_fin',
					fieldLabel:'Organismo Fin.',
					grid_visible:true,
					grid_editable:false,
					width_grid:90
				},
				tipo: 'Field',
				filtro_0:true,
				form:false,
				filterColValue:'PRESTO1.cod_fin'
			};
			
			Atributos[20]={
				validacion:{
					name:'programa',
					fieldLabel:'Programa',
					grid_visible:true,
					grid_editable:false,
					width_grid:90
				},
				tipo: 'Field',
				filtro_0:true,
				form:false,
				filterColValue:'PRESTO1.cod_prg'
			};
			
			Atributos[21]={
				validacion:{
					name:'proyecto',
					fieldLabel:'Proyecto',
					grid_visible:true,
					grid_editable:false,
					width_grid:90
				},
				tipo: 'Field',
				filtro_0:true,
				form:false,
				filterColValue:'PRESTO1.cod_proy'
			};
			
			Atributos[22]={
				validacion:{
					name:'actividad',
					fieldLabel:'Actividad',
					grid_visible:true,
					grid_editable:false,
					width_grid:90
				},
				tipo: 'Field',
				filtro_0: true,
				form:false,
				filterColValue:'PRESTO1.cod_act'
			};
		
	
		
		
		//----------- FUNCIONES RENDER

		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Detalle Cbte. ',grid_maestro:'grid-'+idContenedor};
		var layout = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
		layout.init(config);

		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,layout,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_btnNew=this.btnNew;
		var CM_btnEdit=this.btnEdit;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var Cm_conexionFailure=this.conexionFailure;
		var getDialog=this.getDialog;
		var getGrid=this.getGrid;
		var enableSelect=this.EnableSelect;
		var EstehtmlMaestro=this.htmlMaestro;
		//DEFINICIÓN DE LA BARRA DE MENÚ
		var paramMenu={
			guardar:{crear:true,separador:true},
			nuevo:{crear:true,separador:true},
			actualizar:{crear:true,separador:false}
		};
		//DEFINICIÓN DE FUNCIONES

		var paramFunciones={
			Save:{url:direccion+'../../../control/cbte_det/ActionGuardarCbteDet.php',parametros:'&m_id_cab_cbte='+maestro.id_cab_cbte},
			ConfirmSave:{url:direccion+'../../../control/cbte_det/ActionGuardarCbteDet.php',parametros:'&m_id_cab_cbte='+maestro.id_cab_cbte},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:560,minHeight:222,	closable:true,titulo:'Detalle de Comprobante'}};

			
		
			//-------------- Sobrecarga de funciones --------------------//
			this.reload=function(m,gestion){
				maestro=m;
				//console.log(maestro);
				comp=maestro.id_cbte;
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_cab_cbte:maestro.id_cab_cbte
					}
				};
				this.btnActualizar();
				Atributos[17].defecto=maestro.id_cab_cbte;
                paramFunciones.Save.parametros='&m_id_cab_cbte='+maestro.id_cab_cbte;
				paramFunciones.ConfirmSave.parametros='&m_id_cab_cbte='+maestro.id_cab_cbte;
               	iniciarEventosFormularios();
				this.InitFunciones(paramFunciones)
				
				//console.log(cmbTipo);
				
				//Definición de Store de Tipo
				/*if(maestro.tipo=='gasto'){
					data_tipo = [['gasto','gasto'],['anexo_gasto','anexo_gasto']];
				} else if(maestro.tipo=='recurso'){
					data_tipo = [['recurso','recurso'],['anexo_recurso','anexo_recurso']];
				} else {
					data_tipo = [['no_definido','no_definido']];
				}*/
				
				/*ds_tipo = new Ext.data.SimpleStore({
						fields:['ID','valor'],data:data_tipo});
				cmbTipo.store.data = data_tipo;*/
				
				//console.log(cmbTipo);
				//Fin
				

				
				combo_presupuesto.filterValues[0]=gestion;
			    combo_presupuesto.modificado=true;
				combo_partida.filterValues[0]=gestion;
			    combo_partida.modificado=true;
				/*this.btnActualizar();
				var datos=Ext.urlDecode(decodeURIComponent(params));
				maestro.id_cab_cbte=datos.m_id_cab_cbte;*/
				//alert(maestro.id_cab_cbte)

				/*ds_maestro.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_cab_cbte:maestro.id_cab_cbte

				}
			});*/ 
				/*ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_cab_cbte:maestro.id_cab_cbte
					}
				};
				this.btnActualizar();
				iniciarEventosFormularios();
		
				
				Atributos[7].defecto=maestro.id_cab_cbte;
				
				paramFunciones.Save.parametros='&m_id_cab_cbte='+maestro.id_cab_cbte;
				paramFunciones.ConfirmSave.parametros='&m_id_cab_cbte='+maestro.id_cab_cbte;

				this.iniciarEventosFormularios;
				this.InitFunciones(paramFunciones)*/
			};
			
			//Para manejo de eventos
			function iniciarEventosFormularios(){
				combo_presupuesto=getComponente('id_presupuesto');
				combo_partida=getComponente('id_partida');
                combo_transaccion=getComponente('id_transaccion');
                cmbTipo=getComponente('tipo');
                cmbPartida=getComponente('id_partida');
                cmbCuentaBancaria=getComponente('id_cuenta_bancaria');
                cmbLibreta=getComponente('libreta');
                
                /*var desplegarCampos = function() {
                	if(cmbTipo.getValue()=='gasto'||cmbTipo.getValue()=='recurso'){
                		//Gasto, Recurso
                		cmbLibreta.enable=true;
                		cmbCuentaBancaria.enable=true;
                	} else{
                		//Anexos
                		cmbLibreta.enable=false;
                		cmbCuentaBancaria.enable=false;
                	}
                }
                
                cmbOperacion.on('blur',desplegarCampos);*/
			}

			
			this.EnableSelect=function(x,z,y){
		   		enableSelect(x,z,y);
			}
			
			function ActualizarPadre(resp){
				_CP.getPagina(idContenedorPadre).pagina.btnActualizar();
			}
			this.ActualizarPadre=ActualizarPadre;
			
			
			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout.getLayout()};
			//para el manejo de hijos

			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			this.InitFunciones(paramFunciones);
			//para agregar botones

			
			this.iniciaFormulario();
			iniciarEventosFormularios();
			this.bloquearMenu();
			layout.getLayout().addListener('layout',this.onResize);
			layout.getVentana().addListener('beforehide',ActualizarPadre);
			ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}
