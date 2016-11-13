/*
****************************************************************************************************
Nombre de la clase:	    LOV
Propósito:				Lista de valores parametrizable para la búsqueda de IDS para llaves foráneas
Métodos:
Fecha de Creación:		04 - 05 - 07
Versión:				2.2.1
Autor:					Rensi Arteaga Copari
****************************************************************************************************
*/


function LovItems(paramConfig){
	////////////////// DEFINICON   LOV  //////////////////
	var configuracion={
		nombre: '', //nombre del componente se utiliza para genera los sub nombres para los componentes
		store:'', //direccion para generar el STORE
		title:'',   //titulo que va en el GRID
		datos:[],
		pageSize:20
	};



	var contenedor;//para el componeten que va contener la descripcion del id

	var value=new Array();
	var v_temp=new Array();
	var valsel=new Array();
	var cmb_spGrup,cmb_grup,cmb_sbGrup,cmb_id1,cmb_id2,cmb_id3,gCar,dsCar;

	if(paramConfig.nombre!==null){configuracion.nombre=paramConfig.nombre}
	if(paramConfig.store!==null){configuracion.store=paramConfig.store}
	if(paramConfig.title!==null){configuracion.title= paramConfig.title}
	if(paramConfig.datos!==null){configuracion.datos= paramConfig.datos}
	if(paramConfig.filterCols!==null){configuracion.filterCols= paramConfig.filterCols}
	if(paramConfig.filterValues!==null){configuracion.filterValues= paramConfig.filterValues}
	if(paramConfig.pageSize!==null){configuracion.pageSize= paramConfig.pageSize}

	var paramLOV={
		modal:true,
		autoTabs:false,
		width:850,
		height:350,
		shadow:false,
		minWidth:400,
		minHeight:300,
		fixedCenter: true,
		constraIntoviewport: true,
		draggable:true,
		proxyDrag: true,
		closable:true,
		center_split: false,
		center_titlebar: false,
		center_autoscroll: true,
		south_split: false,
		south_titlebar: false
	};

	var smLOV;// para el selecion model
	var cmLOV;// para el colum model
	var dsLOV; //para el DATA STORE
	var dom_dlgLOV; // elemento en el DOM que contendra el dialogo del LOV
	var dom_gridLOV;// elemento en el DOM que contendra el grid del LOV
	var dlgLOV=false;//dialogo para el formulario
	var gridLOV;
	var layoutLOV;

	/////////////////////
	//FUNCION INIT LOV//
	///////////////////
	this.iniciaLOV=function(){
		var atiqueta_html="<div id='dlgLOV_" + configuracion.nombre + "'><div class='x-dlg-hd'>"+ configuracion.title + "</div><div id='gridLOV_"+configuracion.nombre+"'></div></div>";
		Ext.DomHelper.insertHtml('afterBegin',document.body,atiqueta_html);
		dom_dlgLOV=Ext.get('dlgLOV_'+configuracion.nombre);
		dom_gridLOV=Ext.get('gridLOV_'+configuracion.nombre);
		var showBtn;
		if(!dlgLOV){ // lazy initialize the dialog and only create it once
			dlgLOV=new Ext.LayoutDialog(dom_dlgLOV,{
				modal:paramLOV.modal,
				autoTabs:paramLOV.autoTabs,
				width:paramLOV.width,
				height:paramLOV.height,
				shadow:paramLOV.shadow,
				minWidth:paramLOV.minWidth,
				minHeight:paramLOV.minHeight,
				fixedCenter:paramLOV.fixedCenter,
				constraIntoviewport:paramLOV.constraIntoviewport,
				draggable:paramLOV.draggable,
				proxyDrag:paramLOV.proxyDrag,
				closable:paramLOV.closable,
				east:{split:true,
				initialSize:300,
				minSize:100,
				maxSize:400,
				titlebar:false,
				collapsible:true,
				collapsed:false,
				animate:false
				},
				center:{
					split:paramLOV.center_split,
					titlebar:paramLOV.center_titlebar,
					autoScroll:paramLOV.center_autoscroll
				}
			});
			dlgLOV.addKeyListener(27,ocultarLOV);//tecla escape
			dlgLOV.addButton('Seleccionar',Seleccionar);
			dlgLOV.addButton('Cancelar',ocultarLOV);
			dlgLOV.on('beforehide',function(tab,e){
				var ColFiltro=configuracion.datos[0].dataIndex;
				if(configuracion.datos[0].filterColValue!==undefined){
					ColFiltro=configuracion.datos[0].filterColValue
				}
				dsLOV.lastOptions={
					params:{
						start:0,
						limit:configuracion.pageSize,
						CantFiltros:7,
						//filterCol_0: ColFiltro,
						filterCol_0:'codigo',
						filterValue_0:'%'
					}
				};
				ActualizaVariablesFiltro();
				return true
			});

			var d_formFil=Ext.DomHelper.append(document.body,{tag:'div',html:"<div align='center' class='x-dlg-bd'><br><div id='formFil-"+configuracion.nombre+"'></div></div>"});
			var d_carac=Ext.DomHelper.append(document.body,{tag:'div',html:"<div align='center' class='x-dlg-bd'><br><div id='carac-"+configuracion.nombre+"'></div></div>"});
			layoutLOV=dlgLOV.getLayout();
			layoutLOV.beginUpdate();

			//iniciamos grilla de caracristicas


			dsCar = new Ext.data.Store({
				proxy: new Ext.data.HttpProxy({url:paramConfig.direccion+'../../../../sis_adquisiciones/control/caracteristica/ActionListarCaracteristicaItem.php'}),
				// aqui se define la estructura del XML
				reader: new Ext.data.JsonReader({root:'ROWS',totalProperty:'TotalCount'},['nombre','valor']),remoteSort:false});


				var cmCar = new Ext.grid.ColumnModel([{header:"Nombre",dataIndex:'nombre'},{header:"Valor",dataIndex:'valor'}]);
				var smCar =new Ext.grid.RowSelectionModel({singleSelect:false});
				gCar=new Ext.grid.Grid('carac-'+configuracion.nombre,{
					ds:dsCar,
					cm:cmCar,
					//selModel:smCar,
					enableColLock:false,
					enableColumnMove:false,
					stripeRows:false,
					trackMouseOver: false
				});




				//agregamos paneles

				layoutLOV.add('east',new Ext.ContentPanel(d_formFil,{title:'Filtro'}));
				layoutLOV.add('east',new Ext.GridPanel(gCar,{title:'Características',fitToFrame:true,closable:false}));
				layoutLOV.add('center',new Ext.ContentPanel(dom_gridLOV,{fitToFrame:true, closable: false, title:configuracion.title}));

				layoutLOV.endUpdate()
				gCar.render();


		}
		//  DATA STORE LOV
		//Se forma el array para el xml con los parámetros de entrada
		var xml=new Array();
		for(var i=0;i<configuracion.datos.length;i++){
			xml[i]=configuracion.datos[i].dataIndex
		}
		dsLOV=configuracion.store;
		//se definen los parametros iniciales de carga
		dsLOV.lastOptions={
			params:{
				start:0,
				limit:configuracion.pageSize,
				CantFiltros:7,
				filterCol_0:xml[0],
				filterValue_0:''}
		};
		ActualizaVariablesFiltro();
		dsLOV.addListener('loadexception',conexionFailure); //se recibe un error
		//COLUMN MODEL
		//Al cargar el COlumn model, no cargamos la columna del ID
		var datos_column=new Array;



		/*
		for(i=1;i<configuracion.datos.length;i++){

		datos_column[i-1]=configuracion.datos[i];
		}
		*/


		for(i=0;i<configuracion.datos.length;i++){
			datos_column[i]=configuracion.datos[i]
		}

		//cmLOV = new Ext.grid.DefaultColumnModel(configuracion.datos);
		cmLOV=new Ext.grid.DefaultColumnModel(datos_column);
		// se establece por defecto que las columnas sean ordenables
		cmLOV.defaultSortable=true;
		//SELECTION MODEL
		//El SelectionModel es para la selecion
		smLOV=new Ext.grid.RowSelectionModel({singleSelect:true});
		//Detecta el evento de una fila seleccionada
		smLOV.addListener('rowselect', EnableSelectLOV); //se marca un registro
		//Se crea un grid editable
		gridLOV=new Ext.grid.EditorGrid(dom_gridLOV,{
			ds: dsLOV,
			cm: cmLOV,
			selModel: smLOV,
			enableColLock:false
		});
		//Dibuja el grid
		gridLOV.render();
		/////manejo de eventos de layoput
		function onResize(){
			var gridView=gridLOV.getView();
			gridView.layout()
		}
		layoutLOV.addListener('layout',onResize);
		//Crea barra de paginación
		var gridFootLOV=gridLOV.getView().getFooterPanel(true);

		//Agrega la barra de paginación al pie
		var pagingLOV=new Ext.PagingToolbar(gridFootLOV, dsLOV,{
			pageSize: configuracion.pageSize,
			displayInfo: false,
			displayMsg: 'registros {0} - {1} de {2}',
			emptyMsg: "No hay registros para mostrar"
		});
		InitFiltro(pagingLOV);
		initForm()
	};var iniciaLOV=this.iniciaLOV;

	function  initForm(){
		ds_supergrupo=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:paramConfig.direccion+'../../../../sis_almacenes/control/supergrupo/ActionListarSuperGrupo.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_supergrupo',totalRecords:'TotalCount'},['id_supergrupo','nombre'])});
		ds_grupo=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:paramConfig.direccion+'../../../../sis_almacenes/control/grupo/ActionListarGrupo.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_grupo',totalRecords:'TotalCount'},['id_grupo','nombre'])});
		ds_subgrupo=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:paramConfig.direccion+'../../../../sis_almacenes/control/subgrupo/ActionListarSubGrupo.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_subgrupo',totalRecords:'TotalCount'},['id_subgrupo','nombre'])});
		ds_id1=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:paramConfig.direccion+'../../../../sis_almacenes/control/id1/ActionListarId1.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id: 'id_id1',totalRecords:'TotalCount'},['id_id1','nombre'])});
		ds_id2=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:paramConfig.direccion+'../../../../sis_almacenes/control/id2/ActionListarId2.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_id2',totalRecords:'TotalCount'},['id_id2','nombre'])});
		ds_id3=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:paramConfig.direccion+'../../../../sis_almacenes/control/id3/ActionListarId3.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_id3',totalRecords:'TotalCount'},['id_id3','nombre'])});
		fC_spg=new Array();
		fV_spg=new Array();
		fC_spg[0]='estado_registro';
		fV_spg[0]='activo';
		cmb_spGrup=new Ext.form.ComboBox({
			fieldLabel: 'Super Grupo',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Super Grupo...',
			name: 'id_supergrupo',     //indica la columna del store principal "ds" del que proviane el id
			//sortCol:'supgru.nombre',
			store:ds_supergrupo,
			valueField: 'id_supergrupo',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'nombre',
			typeAhead:false,
			forceSelection : false,
			mode: 'remote',
			filterCols:fC_spg,
			filterValues:fV_spg,
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all'
		});

		fC_g=new Array();
		fV_g=new Array();
		fC_g[0]='supgru.id_supergrupo';
		fV_g[0]='%';
		fC_g[1]='g.estado_registro';
		fV_g[1]='activo';
		cmb_grup=new Ext.form.ComboBox({
			fieldLabel:'Grupo',
			allowBlank:false,
			emptyText:'Grupo...',
			name:'id_grupo',     //indica la columna del store principal "ds" del que proviane el id
			store:ds_grupo,
			valueField:'id_grupo',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'g.nombre',
			filterCols:fC_g,
			filterValues:fV_g,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all'
		});

		fC_sbg=new Array();
		fV_sbg=new Array();
		fC_sbg[0]='supgru.id_supergrupo';
		fV_sbg[0]='%';
		fC_sbg[1]='g.id_grupo';
		fV_sbg[1]='%';
		fC_sbg[2]='sub.estado_registro';
		fV_sbg[2]='activo';
		cmb_sbGrup=new Ext.form.ComboBox({
			fieldLabel: 'Sub Grupo',
			allowBlank: false,
			emptyText:'Sub Grupo...',
			name:'id_subgrupo',
			desc:'nombre_subg',
			store:ds_subgrupo,
			valueField:'id_subgrupo',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'sub.nombre',
			filterCols:fC_sbg,
			filterValues:fV_sbg,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all'
		});

		fC_id1=new Array();
		fV_id1=new Array();
		fC_id1[0]='supgru.id_supergrupo';
		fV_id1[0]='%';
		fC_id1[1]='g.id_grupo';
		fV_id1[1]='%';
		fC_id1[2]='sub.id_subgrupo';
		fV_id1[2]='%';
		fC_id1[3]='id1.estado_registro';
		fV_id1[3]='activo';
		cmb_id1=new Ext.form.ComboBox({
			fieldLabel: 'Identificador 1',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Identificador 1...',
			name:'id_id1',
			desc:'nombre_id1',
			store:ds_id1,
			valueField:'id_id1',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'id1.nombre',
			filterCols:fC_id1,
			filterValues:fV_id1,
			typeAhead:false,
			forceSelection : false,
			mode: 'remote',
			queryDelay: 50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all'
		});
		fC_id2=new Array();
		fV_id2=new Array();
		fC_id2[0]='supgru.id_supergrupo';
		fV_id2[0]='%';
		fC_id2[1]='g.id_grupo';
		fV_id2[1]='%';
		fC_id2[2]='sub.id_subgrupo';
		fV_id2[2]='%';
		fC_id2[3]='id1.id_id1';
		fV_id2[3]='%';
		fC_id2[4]='id2.estado_registro';
		fV_id2[4]='activo';
		cmb_id2=new Ext.form.ComboBox({
			fieldLabel:'Identificador 2',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Identificador 2...',
			name:'id_id2',
			desc:'nombre_id2',
			store:ds_id2,
			valueField:'id_id2',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'id2.nombre',
			filterCols:fC_id2,
			filterValues:fV_id2,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all'
		});
		fC_id3=new Array();
		fV_id3=new Array();
		fC_id3[0]='supgru.id_supergrupo';
		fV_id3[0]='%';
		fC_id3[1]='g.id_grupo';
		fV_id3[1]='%';
		fC_id3[2]='sub.id_subgrupo';
		fV_id3[2]='%';
		fC_id3[3]='id1.id_id1';
		fV_id3[3]='%';
		fC_id3[4]='id2.id_id2';
		fV_id3[4]='%';
		fC_id3[5]='id3.estado_registro';
		fV_id3[5]='activo';
		cmb_id3=new Ext.form.ComboBox({
			fieldLabel: 'Identificador 3',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Identificador 3...',
			name:'id_id3',
			desc:'nombre_id3',
			store:ds_id3,
			valueField:'id_id3',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'id3.nombre',
			filterCols:fC_id3,
			filterValues:fV_id3,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all'
		});


		var formFil=new Ext.form.Form({labelWidth:90});
		formFil.add(cmb_spGrup,cmb_grup,cmb_sbGrup,cmb_id1,cmb_id2,cmb_id3);
		formFil.addButton('Filtrar',filtrarGrid);
		formFil.render('formFil-'+configuracion.nombre);



		var onSGSelect=function(e){
			cmb_grup.setValue('%');
			cmb_grup.resetFil();
			cmb_sbGrup.setValue('%');
			cmb_sbGrup.resetFil();
			cmb_id1.setValue('%');
			cmb_id1.resetFil();
			cmb_id2.setValue('%');
			cmb_id2.resetFil();
			cmb_id3.setValue('%');
			cmb_id3.resetFil();
			var id=cmb_spGrup.getValue();
			cmb_grup.filterValues[0]=id;
			cmb_grup.modificado=true;
			cmb_sbGrup.filterValues[0]=id;
			cmb_sbGrup.modificado=true;
			cmb_id1.filterValues[0]=id;
			cmb_id1.modificado=true;
			cmb_id2.filterValues[0]=id;
			cmb_id2.modificado=true;
			cmb_id3.filterValues[0]=id;
			cmb_id3.modificado=true
		};
		var onGSelect=function(e){
			cmb_sbGrup.setValue('%');
			cmb_sbGrup.resetFil();
			cmb_id1.setValue('%');
			cmb_id1.resetFil();
			cmb_id2.setValue('%');
			cmb_id2.resetFil();
			cmb_id3.setValue('%');
			cmb_id3.resetFil();
			var id=cmb_grup.getValue();
			cmb_sbGrup.filterValues[1]=id;
			cmb_sbGrup.modificado=true;
			cmb_id1.filterValues[1]=id;
			cmb_id1.modificado=true;
			cmb_id2.filterValues[1]=id;
			cmb_id2.modificado=true;
			cmb_id3.filterValues[1]=id;
			cmb_id3.modificado=true
		};
		var onSbGSelect = function(e){
			cmb_id1.setValue('%');
			cmb_id1.resetFil();
			cmb_id2.setValue('%');
			cmb_id2.resetFil();
			cmb_id3.setValue('%');
			cmb_id3.resetFil();
			var id=cmb_sbGrup.getValue();
			cmb_id1.filterValues[2]=id;
			cmb_id1.modificado=true;
			cmb_id2.filterValues[2]=id;
			cmb_id2.modificado=true;
			cmb_id3.filterValues[2]=id;
			cmb_id3.modificado=true
		};
		var onId1Select=function(e){
			cmb_id2.setValue('%');
			cmb_id2.resetFil();
			cmb_id3.setValue('%');
			cmb_id3.resetFil();
			var id = cmb_id1.getValue();
			cmb_id2.filterValues[3]=id;
			cmb_id2.modificado=true;
			cmb_id3.filterValues[3]=id;
			cmb_id3.modificado=true
		};
		var onId2Select = function(e){
			cmb_id3.setValue('%');
			cmb_id3.resetFil();
			var id = cmb_id2.getValue();
			cmb_id3.filterValues[4]= id;
			cmb_id3.modificado=true
		};

		cmb_spGrup.on('select',onSGSelect);
		cmb_spGrup.on('change',onSGSelect);
		cmb_grup.on('select',onGSelect);
		cmb_grup.on('change',onGSelect);
		cmb_sbGrup.on('select',onSbGSelect);
		cmb_sbGrup.on('change',onSbGSelect);
		cmb_id1.on('select',onId1Select);
		cmb_id1.on('change',onId1Select);
		cmb_id2.on('select',onId2Select);
		cmb_id2.on('change',onId2Select)
		//iniciamos tambien el grid de caracteristicas







	}
	function filtrarGrid(){
		dsLOV.lastOptions.params.start=0;
		dsLOV.lastOptions.params["filterCol_1"]='id_supergrupo';
		dsLOV.lastOptions.params["filterValue_1"]=cmb_spGrup.getValue();
		dsLOV.lastOptions.params["filterCol_2"]='id_grupo';
		dsLOV.lastOptions.params["filterValue_2"]=cmb_grup.getValue();
		dsLOV.lastOptions.params["filterCol_3"]='id_subgrupo';
		dsLOV.lastOptions.params["filterValue_3"]=cmb_sbGrup.getValue();
		dsLOV.lastOptions.params["filterCol_4"]='id_id1';
		dsLOV.lastOptions.params["filterValue_4"]=cmb_id1.getValue();
		dsLOV.lastOptions.params["filterCol_5"]='id_id2';
		dsLOV.lastOptions.params["filterValue_5"]=cmb_id2.getValue();
		dsLOV.lastOptions.params["filterCol_6"]='id_id3';
		dsLOV.lastOptions.params["filterValue_6"]=cmb_id3.getValue();
		dsLOV.load(dsLOV.lastOptions)
	}

	//this.InitFiltro = function (Barra)
	function InitFiltro(Barra){
		//var quickMenuItems=new Array('<b class="menu-title">Filtrar Por</b>');
		Barra.addSeparator();
		// llena los elementos en el combo
		var atributosLov = configuracion.datos.length;
		var quickMenuItems=new Array();
		quickMenuItems.push(new Ext.menu.CheckItem({hideOnClick:false,value:'filterAvanzado',text:'Filtro Avanzado', checked:false }));
		quickMenuItems.push('-');
		quickMenuItems.push('<b class="menu-title">Filtrar Por :</b>');


		for(var j=1;j<atributosLov;j++){
			//cambio para filtrar por un valor diferente al nombre de columna
			v=configuracion.datos[j].dataIndex;
			if(configuracion.datos[j].filterColValue){
				value=configuracion.datos[j].filterColValue
			}
			text=configuracion.datos[j].header;
			if(v!='usado'&&v!='nuevo'&&v!='total'){

					quickMenuItems.push(new Ext.menu.CheckItem({ hideOnClick:false,value:v,text:text,checked:j==1?true:false}))
				
			}
		}
		var quickMenuX = new Ext.menu.Menu({
			id: 'quickMenu_'+configuracion.nombre,
			items: quickMenuItems
		});
		Barra.add({
			text: 'Filtro',
			tooltip: 'Columnas por las que se filtra',
			icon: '../../../lib/images/m.png',
			cls: 'x-btn-text-icon btn-search-icon',
			menu: quickMenuX
		});
		var sftb=Barra.addDom({
			tag: 'input',
			id: 'quicksearch_'+configuracion.nombre,
			type: 'text',
			size: 30,
			value: '',
			style: 'background: #F0F0F9;'
		});

		var searchBox=new Ext.form.Field({
			emptyText:"Type to quicksearch"
		});
		searchBox.applyTo('quicksearch_'+configuracion.nombre);

		var onFilteringBeforeQuery=function(e){
			var sw=true; //primera vez que entra al for
			var filterCol="";
			var cuentaCol=0;
			var filterAvanzado=quickMenuItems[0].checked;
			for(var p=1,items=quickMenuItems,len=items.length;p<len;p++){
				if(items[p].checked){
					cuentaCol++;
					if(sw){
						filterCol=items[p].value;
						sw=false
					}
					else{
						filterCol=filterCol+"#"+items[p].value
					}

				}
			}
			if(cuentaCol===0){
				searchBox.setValue("");
				searchBox.disable()
			}
			else{
				searchBox.enable()
			}
			dsLOV.lastOptions.params["filterCol_0"]=filterCol;
			dsLOV.lastOptions.params["filterValue_0"]=searchBox.getValue();
			dsLOV.lastOptions.params["filterAvanzado_0"]=filterAvanzado;
			dsLOV.lastOptions.params.start=0;
			dsLOV.load(dsLOV.lastOptions)
		};
		//quickMenu.on('click', onFilteringBeforeQuery);
		//searchBox.on("specialkey", onFilteringBeforeQuery);
		//searchBox.el.on('keyup', onFilteringBeforeQuery,  searchBox);
		searchBox.el.addKeyListener(13, onFilteringBeforeQuery)
	}

	/////////////////// FUNCIONES /////////////////////////
	this.ocultarLOV=function(){
		dlgLOV.hide()
	};var ocultarLOV=this.ocultarLOV;
	//Función que muestra el LOV
	this.loadLOV=function(ds){
		ds.load(ds.lastOptions)
	};var loadLOV = this.loadLOV;
	//Funcion que se llama al seleccionar una fila
	this.EnableSelectLOV=function(selModel,row,selected){
		var SelectionsRecordLOV=selModel.getSelected(); //es el primer registro seleccionado
		if(selected && SelectionsRecordLOV!=-1){
			v_temp[0]=SelectionsRecordLOV.data[configuracion.datos[0].dataIndex];
			v_temp[1]=SelectionsRecordLOV.data[configuracion.datos[1].dataIndex];
			valsel=SelectionsRecordLOV.data;//retorna valores seleccionados
			//cargamos caracteristicas si es visible el grid de caracteristicas
			var reges=dlgLOV.getLayout().getRegion('east');

			if(reges.isVisible()){
				dsCar.load({params:{id_item:SelectionsRecordLOV.data['id_item']}});
			}





		}
	};var EnableSelectLOV=this.EnableSelectLOV;



	//Función que se ejecuta al oprimir seleccionar
	this.Seleccionar=function(){
		var NumSelect=smLOV.getCount(); //recupera la cantidad de filas selecionadas
		if(NumSelect!=0){
			value={id:v_temp[0],desc:v_temp[1]};
			contenedor.setValue(value);
			if(paramConfig.origen=='grid'){
				paramConfig.sm.getSelected().set(paramConfig.name,value.id)//= value_id;
			}
			contenedor.fireEvent("change");
			//contenedor.fireEvent("select");
			ocultarLOV()
		}
		else{
			Ext.MessageBox.alert('Status', 'Seleccione un item primero.')
		}
	};var Seleccionar=this.Seleccionar;
	//iniciamos el LOV
	iniciaLOV();
	this.smLOV=smLOV;// para el selecion model
	this.cmLOV=cmLOV;// para el colum model
	this.dsLOV=dsLOV; //para el DATA STORE
	this.gridLOV=gridLOV;//dialogo para el formulario



	this.mostrarLOV=function(cajaValue){
		contenedor=cajaValue; //contenedor del value
		ActualizaVariablesFiltro();
		this.dsLOV.load(this.dsLOV.lastOptions);
		this.smLOV.clearSelections();
		dlgLOV.show();
	};var mostrarLOV=this.mostrarLOV;



	function ActualizaVariablesFiltro(){
		for(var k=0;k<configuracion.filterValues.length;k++){
			var indice=k+dsLOV.lastOptions.params.CantFiltros;
			dsLOV.lastOptions.params["filterCol_"+indice]=configuracion.filterCols[k];
			dsLOV.lastOptions.params["filterValue_"+indice]=configuracion.filterValues[k];
			dsLOV.lastOptions.params["filterAvanzado_"+indice]=true
		}
		dsLOV.lastOptions.params.CantFiltros=configuracion.filterValues.length+dsLOV.lastOptions.params.CantFiltros
	}

	this.modifica_filterCols=function(indice,valor){
		configuracion.filterCols[indice]=valor
	};var modifica_filterCols=this.modifica_filterCols;

	this.modifica_filterValues=function(indice,valor){
		configuracion.filterValues[indice]=valor
	};var modifica_filterValues=this.modifica_filterValues;

	this.getSelect=function(){
		return valsel
	};getSelect=this.getSelect;

	this.setSelect=function(x){
		valsel=x
	};

	function conexionFailure(resp1,resp2,resp3){
		ContenedorPrincipal.conexionFailure(resp1,resp2,resp3)
	}this.conexionFailure=conexionFailure;



	function setValores(x){
		value=x!==undefined&&x!==''?x:new Array()
	}this.setValores=setValores;

	function getValores(){
		return value['id']
	}this.getValores=getValores;
}

//////////////////////////////////////////////////////////////////////////
//---------------      COMPONET LOV          -------------------------- //
//   inicia los elementos para la contruccion del LOV                   //
//////////////////////////////////////////////////////////////////////////

Ext.form.LovItemsAlm=function(config){
	Ext.form.LovItemsAlm.superclass.constructor.call(this, config);
	this.nombre=this.getId();

	//para aumentar disparadores

	this.triggerConfig = {
		tag:'span', cls:'x-form-twin-triggers', style:'padding-right:2px',  // padding needed to prevent IE from clipping 2nd trigger button
		cn:[{tag: "img", src: Ext.BLANK_IMAGE_URL, cls: "x-form-trigger", style:config.hideComboTrigger?"display:none":""},
		{tag: "img", src: Ext.BLANK_IMAGE_URL, cls: "x-form-trigger x-form-search-trigger", style: config.hideClearTrigger?"display:none":""}
		]};


		var data=[{dataIndex:"id_item",
		filterColValue: "id_item",
		header: "ID",
		width:50
		},{
			dataIndex:"codigo", /// modificar con el de activo_fijo
			filterColValue:"codigo",
			header: "Codigo",
			width:90
		},{
			dataIndex:"descripcion", /// modificar con el de activo_fijo
			filterColValue:"descripcion",
			header: "Descripción",
			width:150
		},{
			dataIndex:"nombre_unid_base", /// modificar con el de activo_fijo
			filterColValue:"nombre_unid_base",
			header: "Unidad de Medida",
			width:150
		},{
			dataIndex: "nombre_supg",
			filterColValue: "nombre_supg",
			header: "Super Grupo",
			width:120
		},{
			dataIndex: "nombre_grupo", /// modificar con el de activo_fijo
			filterColValue:"nombre_grupo",
			header: "Grupo",
			width:120
		},{
			dataIndex:"nombre_subg", /// modificar con el de activo_fijo
			filterColValue:"nombre_subg",
			header: "Sub Grupo",
			width:120
		},{
			dataIndex:"nombre_id1", /// modificar con el de activo_fijo
			filterColValue:"nombre_id1",
			header: "Identificador 1",
			width:120
		},{
			dataIndex:"nombre_id2", /// modificar con el de activo_fijo
			filterColValue:"nombre_id2",
			header: "Identificador 2",
			width:120
		},{
			dataIndex:"nombre_id3", /// modificar con el de activo_fijo
			filterColValue:"nombre_id3",
			header: "Identificador 3",
			width:120
		},{	dataIndex:"nombre", /// modificar con el de activo_fijo
		filterColValue:"nombre",
		header: "Item",
		width:120
		},{
			dataIndex:"costo_estimado", /// modificar con el de activo_fijo
			filterColValue:"costo_estimado",
			header: "costo_estimado",
			width:120
		},
		{
			dataIndex:"mat_bajo_responsabilidad", /// modificar con el de activo_fijo
			filterColValue:"mat_bajo_responsabilidad",
			header: "mat_bajo_responsabilidad",
			width:120
		}
		];



		var url=this.direccion+'../../../../sis_almacenes/control/item/ActionListarItemSal.php';
		var datos = ['id_item','codigo','descripcion','precio_venta_almacen','costo_estimado','stock_min','observaciones','nivel_convertido','estado_registro',{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'},'id_unidad_medida_base','id_id3','id_id2','id_id1','id_subgrupo','id_grupo','id_supergrupo','nombre','nombre_id3','nombre_id2','nombre_id1','nombre_subg','nombre_grupo','nombre_supg','nombre_unid_base','mat_bajo_responsabilidad'];
		if(this.tipo=='salida'){
			//***
			var url=this.direccion+'../../../../sis_almacenes/control/item/ActionListarItemKardex.php';
			//alert( url);
			data.push({dataIndex:"nuevo",filterColValue:"nuevo",header:"Nuevos",width:50},
			{dataIndex:"usado",filterColValue:"usado",header:"Usados",width:50},
			{dataIndex:"total",filterColValue:"total",header:"Total",width:50});
			datos.push('usado','total','nuevo')
		}

		var ds=new Ext.data.Store({
			proxy:new Ext.data.HttpProxy({url:url}),
			reader: new Ext.data.XmlReader({record:'ROWS',totalRecords:'TotalCount'},datos),
			origen:this.origen, //contenedor del value
			sm:this.sm, //contenedor del value
			name:this.name,
			remoteSort: true // metodo de ordenacion remoto
		});

		this.store=ds;
		configuracion={
			nombre:this.nombre, //nombre del componente se utiliza para genera los sub nombres para los componentes
			store:new Ext.data.Store({
				proxy:new Ext.data.HttpProxy({url:url}),
				reader: new Ext.data.XmlReader({record:'ROWS',totalRecords:'TotalCount'},datos),
				origen:this.origen, //contenedor del value
				sm:this.sm, //contenedor del value
				name:this.name,
				remoteSort: true // metodo de ordenacion remoto
			}),
			title:'Items',//titulo que va en el GRID
			datos:data,//definicion de datos      //definicion de datos
			filterCols:this.filterCols,        //columnas extras para el filtro
			filterValues:this.filterValues,        //valores extra para el filtro
			pageSize: this.pageSize,
			contenedor_id:this.contenedor_id, //contenedor del value
			origen:this.origen, //contenedor del value
			sm:this.sm, //contenedor del value
			name:this.name, //contenedor del value
			direccion:this.direccion //direccion para las url's
		};
		this.lov=new LovItems(configuracion);
		this.on('Select',onComboSelect);

		function onComboSelect(x,y,z){
			//this.onSelect(y,z);
			this.lov.setSelect(y.data)
			//this.fireEvent("change");
		}
};
Ext.extend(Ext.form.LovItemsAlm,Ext.form.ComboBox,{

	tipo:'ingreso',//por defecto se dice que es para ingresos salida
	title:'Items',//titulo que va en el GRID
	datos:[],//definicion de datos
	filterCols:[],//columnas extras para el filtro
	filterValues:[],//valores extra para el filtro
	pageSize:20,//tamaño de pagina
	paramLOV:{//paramatros para configurar el LOV
		modal:true,
		autoTabs:false,
		width:850,
		height:350,
		shadow:false,
		minWidth:400,
		minHeight:300,
		fixedCenter: true,
		constraIntoviewport: true,
		draggable:true,
		proxyDrag: true,
		closable:true,
		center_split: false,
		center_titlebar: false,
		center_autoscroll: true,
		south_split: false,
		south_titlebar: false
	},
	valueField: 'id_item',
	displayField: 'codigo',
	dlgLOV:false,//dialogo para el formulario
	setValue:function(x) {
		if(x&&x.id!==undefined)
		{v={id:x.id,desc:x.desc}}
		else
		{v={id:x,desc:x}}


		this.lov.setValores(v);


		Ext.form.LovItemsAlm.superclass.setValue.call(this,v.desc)
	},
	setText:function(t){
		Ext.form.LovItemsAlm.superclass.setValue.call(this,t)
	},
	getValue : function(){

		var rx=this.lov.getValores();
		return rx?rx:''
	},

	//para dos disparadores

	getTrigger : function(index){
		return this.triggers[index];
	},
	mode:'remote',
	triggerAction:'all',
	allowBlank:true,
	typeAhead:false,
	loadMask:true,
	queryParam:'filterValue_0',
	forceSelection:true,
	minChars:1,
	listWidth:300,
	resizable:true,
	lazyRender:true,
	filterCol:'codigo#nombre#descripcion#observaciones',
	tpl:new Ext.Template('<div class="search-item">','<b>{descripcion}</b>','<br><FONT COLOR="#B5A642"><b>Código:</b> {codigo}</FONT>','<br><FONT COLOR="#B5A642"><b>Nombre:</b> {nombre}</FONT>','</div>'),

	initTrigger:function(){
		var ts = this.trigger.select('.x-form-trigger', true);
		this.wrap.setStyle('overflow', 'hidden');
		var triggerField = this;
		ts.each(function(t, all, index){
			t.hide = function(){
				var w = triggerField.wrap.getWidth();
				this.dom.style.display = 'none';
				triggerField.el.setWidth(w-triggerField.trigger.getWidth());
			};
			t.show = function(){
				var w = triggerField.wrap.getWidth();
				this.dom.style.display = '';
				triggerField.el.setWidth(w-triggerField.trigger.getWidth());
			};
			var triggerIndex = 'Trigger'+(index+1);

			if(this['hide'+triggerIndex]){
				t.dom.style.display = 'none';
			}
			t.on("click", this['on'+triggerIndex+'Click'], this, {preventDefault:true});
			t.addClassOnOver('x-form-trigger-over');
			t.addClassOnClick('x-form-trigger-click');
		}, this);
		this.triggers = ts.elements;
	},

	onTrigger1Click:function(){this.onTriggerClick()},   // pass to original combobox trigger handler

	onTrigger2Click:function(){
		this.collapse();
		//this.reset();
		this.lov.mostrarLOV(this)
	}      // cllamada al lov






});