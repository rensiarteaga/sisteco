/*
 * ***************************************************************************************************
 * Nombre de la clase: LOV Propósito: Lista de valores parametrizable para la
 * búqueda de IDS para llaves foráneas
 * Métodos: Fecha de Creación: 04 - 05 - 07
 * Versión: 2.0.0 Autor: Rensi Arteaga Copari
 * ***************************************************************************************************
 */
function epForm(config,epF){
	
	var dlgForm,contenedor,cmb_financiador,cmb_regional,cmb_programa,cmb_proyecto,cmb_actividad;
	var value=new Array();
	this.datosCarga={};
	this.text;
	var ds_financiador,ds_programa,ds_proyecto,ds_regional,ds_actividad;
	this.initForm=function(){
		var atiqueta_html="<div id='dlgForm_" + config.nombre + "'><div class='x-dlg-hd'>"+ config.title + "</div><div id='gridLOV_"+config.nombre+"'></div></div>";
		Ext.DomHelper.insertHtml('afterBegin',document.body,atiqueta_html);
		dom_dlgForm = Ext.get('dlgForm_'+config.nombre);
		dom_gridForm= Ext.get('gridForm_'+config.nombre);
		var showBtn;
		if(!dlgForm){ // lazy initialize the dialog and only create it once
			dlgForm=new Ext.LayoutDialog(dom_dlgForm,{
				modal:true,
				width:550,
				height:300,
				fixedCenter:true,
				closable:true,
				center:{split:true,
				initialSize:300,
				minSize:100,
				maxSize:400,
				titlebar:false,
				animate:false
				}
			});
			dlgForm.addKeyListener(27,hideForm);// tecla escape
			dlgForm.addButton('Seleccionar',select);
			dlgForm.addButton('Cancelar',hideForm);
			d_formFil=Ext.DomHelper.append(document.body,{tag:'div',html:"<div align='center' class='x-dlg-bd'><br><div id='formFil-"+config.nombre+"'></div></div>"});
			layout=dlgForm.getLayout();
			layout.beginUpdate();
			layout.add('center', new Ext.ContentPanel(d_formFil));
			layout.endUpdate()
		}
	};

	this.cargaEPprimaria=function(p,f){
		// Obtiene la lista de todas las eps del usuario, si tiene una sola la
		// carga e inhabilita combo
		// si tiene más de una, se carga la primera
		
			Ext.Ajax.request({
				url:config.precargaAct,
				method:'POST',
				params:p,
				success:cargar_ep,
				argument:{fun:f},
				failure:_CP.conexionFailure,
				timeout:100000// TIEMPO DE ESPERA PARA DAR FALLO
			})
		

	};

	function cargar_ep(resp){
		this.datosCarga=Ext.util.JSON.decode(resp.responseText);
		epF.setValue(this.datosCarga)
		if(resp.argument.fun){
			resp.argument.fun(this.datosCarga)			
		}
	}

	function initDatos(){
		ds_financiador=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:config.actFin}),reader: new Ext.data.XmlReader({record:'ROWS',id: 'id_financiador',totalRecords: 'TotalCount'}, ['id_financiador','nombre_financiador','codigo_financiador']),baseParams:config.bpFin});
		ds_regional=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:config.actReg}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_regional',totalRecords: 'TotalCount'}, ['id_regional','nombre_regional','codigo_regional']),baseParams:config.bpReg});
		ds_programa=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:config.actProg}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_programa',totalRecords: 'TotalCount'}, ['id_programa','nombre_programa','codigo_programa']),baseParams:config.bpProg});
		ds_proyecto=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:config.actProy}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_proyecto',totalRecords: 'TotalCount'}, ['id_proyecto','nombre_proyecto','codigo_proyecto']),baseParams:config.bpProy});
		ds_actividad=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:config.actAct}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_actividad',totalRecords: 'TotalCount'}, ['id_actividad','nombre_actividad','codigo_actividad']),baseParams:config.bpAct});
		ds_financiador.on('loadexception',_CP.conexionFailure);
		ds_regional.on('loadexception',_CP.conexionFailure);
		ds_programa.on('loadexception',_CP.conexionFailure);
		ds_proyecto.on('loadexception',_CP.conexionFailure);
		ds_actividad.on('loadexception',_CP.conexionFailure);
		
		// hidden_id_financiador
		cmb_financiador=new Ext.form.ComboBox({
			fieldLabel: 'Financiador',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Financiador...',
			name: 'id_financiador',
			desc: 'nombre_financiador',
			store:ds_financiador,
			valueField: 'id_financiador',
			displayField: 'nombre_financiador',
			queryParam: 'filterValue_0',
			filterCol:'nombre_financiador#codigo_financiador',
			typeAhead:false,
			forceSelection :true,
			tpl:new Ext.Template('<div class="search-item">','<b><i>{codigo_financiador}</i></b>','<br><FONT COLOR="#B5A642">{nombre_financiador}</FONT>','</div>'),
			mode:'remote',
			queryDelay:250,
			minChars:4,
			pageSize:15,
			width:350,
			resizable: true,
			queryParam: 'filterValue_0',
			// minChars : 1,
			triggerAction: 'all',
			editable:true
		});
		var fC_regional=new Array();
		var fV_regional=new Array();
		fC_regional[0]='frppa.id_financiador';
		fV_regional[0]='%';

		// hidden_id_regional
		cmb_regional=new Ext.form.ComboBox({
			fieldLabel: 'Regional',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Regional...',
			name: 'id_regional',
			desc: 'nombre_regional',
			store:ds_regional,
			valueField: 'id_regional',
			displayField: 'nombre_regional',
			queryParam: 'filterValue_0',
			filterCol:'nombre_regional#codigo_regional',
			filterCols:fC_regional,
			filterValues:fV_regional,
			typeAhead:false,
			forceSelection:true,
			tpl:new Ext.Template('<div class="search-item">','<b><i>{codigo_regional}</i></b>','<br><FONT COLOR="#B5A642">{nombre_regional}</FONT>','</div>'),
			mode:'remote',
			queryDelay:250,
			minChars:4,
			pageSize:15,
			width:350,
			resizable:true,
			queryParam:'filterValue_0',
			triggerAction:'all',
			editable:true
		});
		var fC_programa=new Array();
		var fV_programa=new Array();
		fC_programa[0]='frppa.id_financiador';
		fV_programa[0]='%';
		fC_programa[1]='frppa.id_regional';
		fV_programa[1]='%';
		// hideen_id_programa
		cmb_programa=new Ext.form.ComboBox({
			fieldLabel: 'Programa',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Programa...',
			name: 'id_programa',
			desc: 'nombre_programa',
			store:ds_programa,
			valueField: 'id_programa',
			displayField: 'nombre_programa',
			queryParam: 'filterValue_0',
			filterCol:'nombre_programa#codigo_programa',
			filterCols:fC_programa,
			filterValues:fV_programa,
			typeAhead:false,
			forceSelection :true,
			tpl:new Ext.Template('<div class="search-item">','<b><i>{codigo_programa}</i></b>','<br><FONT COLOR="#B5A642">{nombre_programa}</FONT>','</div>'),
			mode: 'remote',
			queryDelay:250,
			minChars:4,
			pageSize:15,
			width:350,
			resizable:true,
			queryParam:'filterValue_0',
			triggerAction:'all',
			editable:true
		});
		var fC_proyecto= new Array();
		var fV_proyecto= new Array();
		fC_proyecto[0]='frppa.id_financiador';
		fV_proyecto[0]='%';
		fC_proyecto[1]='frppa.id_regional';
		fV_proyecto[1]='%';
		fC_proyecto[2]='PGPYAC.id_programa';
		fV_proyecto[2]='%';
		// hidden_id_proyecto
		cmb_proyecto=new Ext.form.ComboBox({
			fieldLabel:'Sub Programa',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Sub Programa...',
			name:'id_proyecto',
			desc:'nombre_proyecto',
			store:ds_proyecto,
			valueField:'id_proyecto',
			displayField:'nombre_proyecto',
			queryParam:'filterValue_0',
			filterCol:'nombre_proyecto#codigo_proyecto',
			filterCols:fC_proyecto,
			filterValues:fV_proyecto,
			typeAhead:false,
			forceSelection :true,
			tpl:new Ext.Template('<div class="search-item">','<b><i>{codigo_proyecto}</i></b>','<br><FONT COLOR="#B5A642">{nombre_proyecto}</FONT>','</div>'),
			mode:'remote',
			queryDelay:250,
			minChars:4,
			pageSize:15,
			width:350,
			resizable: true,
			queryParam: 'filterValue_0',
			triggerAction: 'all',
			editable:true
		});
		var fC_actividad=new Array();
		var fV_actividad=new Array();
		fC_actividad[0]='frppa.id_financiador';
		fV_actividad[0]='%';
		fC_actividad[1]='frppa.id_regional';
		fV_actividad[1]='%';
		fC_actividad[2]='PGPYAC.id_programa';
		fV_actividad[2]='%';
		fC_actividad[3]='PGPYAC.id_proyecto';
		fV_actividad[3]='%';

		// hidden_id_actividad
		cmb_actividad=new Ext.form.ComboBox({
			fieldLabel:'Actividad',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Actividad...',
			name:'id_actividad',
			desc:'nombre_actividad',
			store:ds_actividad ,
			valueField:'id_actividad',
			displayField:'nombre_actividad',
			queryParam:'filterValue_0',
			filterCol:'nombre_actividad#codigo_actividad',
			filterCols:fC_actividad,
			filterValues:fV_actividad,
			typeAhead:false,
			forceSelection : true,
			tpl:new Ext.Template('<div class="search-item">','<b><i>{codigo_actividad}</i></b>','<br><FONT COLOR="#B5A642">{nombre_actividad}</FONT>','</div>'),
			mode: 'remote',
			queryDelay:250,
			minChars:4,
			pageSize:15,
			width:350,
			resizable: true,
			queryParam: 'filterValue_0',
			triggerAction: 'all',
			editable: true
		});
		var onFinanciadorSelect=function(e){
			var id=cmb_financiador.getValue();
			cmb_regional.filterValues[0]=id;
			cmb_regional.modificado=true;
			cmb_programa.filterValues[0]=id;
			cmb_programa.modificado=true;
			cmb_proyecto.filterValues[0]=id;
			cmb_proyecto.modificado=true;
			cmb_actividad.filterValues[0]=id;
			cmb_actividad.modificado=true;
			cmb_regional.setValue('');
			cmb_programa.setValue('');
			cmb_proyecto.setValue('');
			cmb_actividad.setValue('');
			cmb_regional.enable()
		};
		var onRegionalSelect=function(e){
			var id=cmb_regional.getValue();
			cmb_programa.filterValues[1]=id;
			cmb_programa.modificado=true;
			cmb_proyecto.filterValues[1]=id;
			cmb_proyecto.modificado=true;
			cmb_actividad.filterValues[1]=id;
			cmb_actividad.modificado=true;
			cmb_programa.setValue('');
			cmb_proyecto.setValue('');
			cmb_actividad.setValue('');
			cmb_programa.enable()
		};
		var onProgramaSelect=function(e){
			var id=cmb_programa.getValue();
			cmb_proyecto.filterValues[2]=id;
			cmb_proyecto.modificado=true;
			cmb_actividad.filterValues[2]=id;
			cmb_actividad.modificado=true;
			cmb_proyecto.setValue('');
			cmb_actividad.setValue('');
			cmb_proyecto.enable()
		};
		var onProyectoSelect=function(e){
			var id=cmb_proyecto.getValue();
			cmb_actividad.filterValues[3]= id;
			cmb_actividad.modificado=true;
			cmb_actividad.setValue('');
			cmb_actividad.enable()
		};
		var onActividadSelect=function(e){
			dlgForm.buttons[0].enable()
		};

		cmb_financiador.on('select',onFinanciadorSelect);
		cmb_financiador.on('change',onFinanciadorSelect);
		cmb_regional.on('select',onRegionalSelect);
		cmb_regional.on('change',onRegionalSelect);
		cmb_programa.on('select',onProgramaSelect);
		cmb_programa.on('change',onProgramaSelect);
		cmb_proyecto.on('select',onProyectoSelect);
		cmb_proyecto.on('change',onProyectoSelect);
		cmb_actividad.on('select',onActividadSelect);
		cmb_actividad.on('change',onActividadSelect);
		var formFil=new Ext.form.Form({labelWidth:90});
		formFil.add(cmb_financiador,cmb_regional,cmb_programa,cmb_proyecto,cmb_actividad);
		formFil.render('formFil-'+config.nombre)
	}this.initDatos=initDatos;

	function showForm(c){
		contenedor=c; // contenedor del value
		cmb_regional.disable();
		cmb_programa.disable();
		cmb_proyecto.disable();
		cmb_actividad.disable();
		dlgForm.buttons[0].disable();
		dlgForm.show()
	}this.showForm=showForm;

	function hideForm(){
		dlgForm.hide()
	}this.hideForm=hideForm;

	function select(){
		var aux;
		value['id_financiador']=cmb_financiador.getValue();
		aux=cmb_financiador.store.getById(value['id_financiador']).data;
		value['nombre_financiador']=aux['nombre_financiador'];
		value['codigo_financiador']=aux['codigo_financiador'];
		value['id_regional']=cmb_regional.getValue();
		aux=cmb_regional.store.getById(value['id_regional']).data;
		value['nombre_regional']=aux['nombre_regional'];
		value['codigo_regional']=aux['codigo_regional'];
		value['id_programa']=cmb_programa.getValue();
		aux=cmb_programa.store.getById(value['id_programa']).data;
		value['nombre_programa']=aux['nombre_programa'];
		value['codigo_programa']=aux['codigo_programa'];
		value['id_proyecto']=cmb_proyecto.getValue();
		aux=cmb_proyecto.store.getById(value['id_proyecto']).data;
		value['nombre_proyecto']=aux['nombre_proyecto'];
		value['codigo_proyecto']=aux['codigo_proyecto'];
		value['id_actividad']=cmb_actividad.getValue();
		aux=cmb_actividad.store.getById(value['id_actividad']).data;
		value['nombre_actividad']=aux['nombre_actividad'];
		value['codigo_actividad']=aux['codigo_actividad'];
		this.text=value['codigo_financiador']+'-'+value['codigo_regional']+'-'+value['codigo_programa']+'-'+value['codigo_proyecto']+'-'+value['codigo_actividad'];
		contenedor.setText(this.text);
		contenedor.fireEvent("change");
		dlgForm.hide()
	}this.select=select;

	function setValores(x){
		if(x!==undefined&&x!==''){
		var p=new Array();
		p['id_financiador']=x['id_financiador'];
		p['nombre_financiador']=x['nombre_financiador'];
		cmb_financiador.store.add(new Ext.data.Record(p,'id_financiador'));
		cmb_financiador.setValue(x['id_financiador']);
		p=new Array();
		p['id_regional']=x['id_regional'];
		p['nombre_regional']=x['nombre_regional'];
		cmb_regional.store.add(new Ext.data.Record(p,'id_regional'));
		cmb_regional.setValue(x['id_regional']);
		p=new Array();
		p['id_programa']=x['id_programa'];
		p['nombre_programa']=x['nombre_programa'];
		cmb_programa.store.add(new Ext.data.Record(p,'id_programa'));
		cmb_programa.setValue(x['id_programa']);
		p=new Array();
		p['id_proyecto']=x['id_proyecto'];
		p['nombre_proyecto']=x['nombre_proyecto'];
		cmb_proyecto.store.add(new Ext.data.Record(p,'id_proyecto'));
		cmb_proyecto.setValue(x['id_proyecto']);
		p=new Array();
		p['id_actividad']=x['id_actividad'];
		p['nombre_actividad']=x['nombre_actividad'];
		cmb_actividad.store.add(new Ext.data.Record(p,'id_actividad'));
		cmb_actividad.setValue(x['id_actividad']);
		value=x;
		x=new Array()
		}
	}this.setValores=setValores;

	function getValores(){
		return value
	}this.getValores=getValores;

	this.setBaseParams=function(params){

		Ext.apply(ds_financiador.baseParams,params);
		Ext.apply(ds_regional.baseParams,params);
		Ext.apply(ds_programa.baseParams,params);
		Ext.apply(ds_proyecto.baseParams,params);
		Ext.apply(ds_actividad.baseParams,params);

		cmb_financiador.modificado=true;
		cmb_regional.modificado=true;
		cmb_programa.modificado=true;
		cmb_proyecto.modificado=true;
		cmb_actividad.modificado=true;
	};


	this.initForm();
	initDatos();
	// this.cargaEPprimaria();
}

// ////////////////////////////////////////////////////////////////////////
// --------------- COMPONET LOV -------------------------- //
// inicia los elementos para la contruccion del LOV //
// ////////////////////////////////////////////////////////////////////////

Ext.form.epField=function(config){
	Ext.form.epField.superclass.constructor.call(this,config);
	this.nombre=this.getId();
	con={		
		nombre:this.nombre,
		sm:this.sm,
		title:this.emptyText,
		actFin:'../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php',
		bpFin:{'v':'1'},
		actReg:'../../../sis_parametros/control/regional/ActionListaRegionalEP.php',
		bpReg:{'v':'1'},
		actProg:'../../../sis_parametros/control/programa/ActionListaProgramaEP.php',
		bpProg:{'v':'1'},
		actProy:'../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php',
		bpProy:{'v':'1'},
		actAct:'../../../sis_parametros/control/actividad/ActionListaActividadEP.php'
		,bpAct:{'v':'1'}
	};
	Ext.apply(con,this)
	//Ext.apply(con,config)
	this.ep=new epForm(con,this)
};
Ext.extend(Ext.form.epField,Ext.form.TriggerField,{
	defaultAutoCreate:{tag:"input",type:"text",size:"24",autocomplete:"off"},
	//nombre:undefined,
	title:'Estructura Programática',
	triggerClass:'x-form-search-trigger',
	editable:false,
	pregarga:true,
	precargaAct:"../../../sis_seguridad/control/asignacion_estructura/ActionListarEPusuario.php",
	// value:undefined,
	// text:undefined,
	onTriggerClick:function(){if(!this.disabled){this.ep.showForm(this)}},
	initEvents:function(){
		Ext.form.ComboBox.superclass.initEvents.call(this);
		this.keyNav=new Ext.KeyNav(this.el,{
		"enter":function(e){this.ep.showForm(this)},
		"esc":function(e){this.ep.hideForm()}
		});
		this.el.dom.setAttribute('readOnly', true);
		this.el.addClass('x-combo-noedit')
	},
	setValue:function(v,e)  {
		
		//alert("v['codigo_financiador'] " + v['id_financiador'] + "  v['codigo_regional'] " + v['id_regional']+ "  v['codigo_programa'] " + v['id_programa']+ "  v['codigo_proyecto'] " + v['id_proyecto']+ "  v['codigo_actividad'] " + v['id_actividad']);
		text= v!==undefined && v!==''? v['codigo_financiador']+'-'+v['codigo_regional']+'-'+v['codigo_programa']+'-'+v['codigo_proyecto']+'-'+v['codigo_actividad']:'';
		this.ep.setValores(v);
		Ext.form.epField.superclass.setValue.call(this,text);
		this.value=v;
		if(e == undefined || e){
			this.fireEvent("change")
		}
		
	},
	setText:function(t){
		Ext.form.epField.superclass.setValue.call(this,t)
	},
	getValue:function(){
		return this.ep.getValores()
	}
});