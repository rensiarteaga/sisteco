function epForm(config){var dlgForm;var contenedor;var value=new Array();this.text;var cmb_financiador;var cmb_regional;var cmb_programa;var cmb_proyecto;var cmb_actividad;this.initForm=function(){var atiqueta_html="<div id='dlgForm_"+config.nombre+"'><div class='x-dlg-hd'>"+config.title+"</div><div id='gridLOV_"+config.nombre+"'></div></div>";Ext.DomHelper.insertHtml('afterBegin',document.body,atiqueta_html);dom_dlgForm=Ext.get('dlgForm_'+config.nombre);dom_gridForm=Ext.get('gridForm_'+config.nombre);var showBtn;if(!dlgForm){dlgForm=new Ext.LayoutDialog(dom_dlgForm,{modal:true,width:550,height:300,fixedCenter:true,closable:true,center:{split:true,initialSize:300,minSize:100,maxSize:400,titlebar:false,animate:false}});dlgForm.addKeyListener(27,hideForm);dlgForm.addButton('Seleccionar',select);dlgForm.addButton('Cancelar',hideForm);d_formFil=Ext.DomHelper.append(document.body,{tag:'div',html:"<div align='center' class='x-dlg-bd'><br><div id='formFil-"+config.nombre+"'></div></div>"});layout=dlgForm.getLayout();layout.beginUpdate();layout.add('center',new Ext.ContentPanel(d_formFil));layout.endUpdate()}};function initDatos(){ds_financiador=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:'../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_financiador',totalRecords:'TotalCount'},['id_financiador','nombre_financiador','codigo_financiador'])});ds_regional=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:'../../../sis_parametros/control/regional/ActionListaRegionalEP.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_regional',totalRecords:'TotalCount'},['id_regional','nombre_regional','codigo_regional'])});ds_programa=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:'../../../sis_parametros/control/programa/ActionListaProgramaEP.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_programa',totalRecords:'TotalCount'},['id_programa','nombre_programa','codigo_programa'])});ds_proyecto=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:'../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proyecto',totalRecords:'TotalCount'},['id_proyecto','nombre_proyecto','codigo_proyecto'])});ds_actividad=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:'../../../sis_parametros/control/actividad/ActionListaActividadEP.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_actividad',totalRecords:'TotalCount'},['id_actividad','nombre_actividad','codigo_actividad'])});cmb_financiador=new Ext.form.ComboBox({fieldLabel:'Financiador',allowBlank:false,vtype:"texto",emptyText:'Financiador...',name:'id_financiador',desc:'nombre_financiador',store:ds_financiador,valueField:'id_financiador',displayField:'nombre_financiador',queryParam:'filterValue_0',filterCol:'nombre_financiador#codigo_financiador',typeAhead:false,forceSelection:true,tpl:new Ext.Template('<div class="search-item">','<b><i>{codigo_financiador}</i></b>','<br><FONT COLOR="#B5A642">{nombre_financiador}</FONT>','</div>'),mode:'remote',queryDelay:50,pageSize:10,width:350,resizable:true,queryParam:'filterValue_0',minChars:1,triggerAction:'all',editable:true});fC_regional=new Array();fV_regional=new Array();fC_regional[0]='frppa.id_financiador';fV_regional[0]='%';cmb_regional=new Ext.form.ComboBox({fieldLabel:'Regional',allowBlank:false,vtype:"texto",emptyText:'Regional...',name:'id_regional',desc:'nombre_regional',store:ds_regional,valueField:'id_regional',displayField:'nombre_regional',queryParam:'filterValue_0',filterCol:'nombre_regional#codigo_regional',filterCols:fC_regional,filterValues:fV_regional,typeAhead:false,forceSelection:true,tpl:new Ext.Template('<div class="search-item">','<b><i>{codigo_regional}</i></b>','<br><FONT COLOR="#B5A642">{nombre_regional}</FONT>','</div>'),mode:'remote',queryDelay:50,pageSize:10,width:350,resizable:true,queryParam:'filterValue_0',minChars:1,triggerAction:'all',editable:true});fC_programa=new Array();fV_programa=new Array();fC_programa[0]='frppa.id_financiador';fV_programa[0]='%';fC_programa[1]='frppa.id_regional';fV_programa[1]='%';cmb_programa=new Ext.form.ComboBox({fieldLabel:'Programa',allowBlank:false,vtype:"texto",emptyText:'Programa...',name:'id_programa',desc:'nombre_programa',store:ds_programa,valueField:'id_programa',displayField:'nombre_programa',queryParam:'filterValue_0',filterCol:'nombre_programa#codigo_programa',filterCols:fC_programa,filterValues:fV_programa,typeAhead:false,forceSelection:true,tpl:new Ext.Template('<div class="search-item">','<b><i>{codigo_programa}</i></b>','<br><FONT COLOR="#B5A642">{nombre_programa}</FONT>','</div>'),mode:'remote',queryDelay:50,pageSize:10,width:350,resizable:true,queryParam:'filterValue_0',minChars:1,triggerAction:'all',editable:true});fC_proyecto=new Array();fV_proyecto=new Array();fC_proyecto[0]='frppa.id_financiador';fV_proyecto[0]='%';fC_proyecto[1]='frppa.id_regional';fV_proyecto[1]='%';fC_proyecto[2]='PGPYAC.id_programa';fV_proyecto[2]='%';cmb_proyecto=new Ext.form.ComboBox({fieldLabel:'Sub Programa',allowBlank:false,vtype:"texto",emptyText:'Sub Programa...',name:'id_proyecto',desc:'nombre_proyecto',store:ds_proyecto,valueField:'id_proyecto',displayField:'nombre_proyecto',queryParam:'filterValue_0',filterCol:'nombre_proyecto#codigo_proyecto',filterCols:fC_proyecto,filterValues:fV_proyecto,typeAhead:false,forceSelection:true,tpl:new Ext.Template('<div class="search-item">','<b><i>{codigo_proyecto}</i></b>','<br><FONT COLOR="#B5A642">{nombre_proyecto}</FONT>','</div>'),mode:'remote',queryDelay:50,pageSize:10,width:350,resizable:true,queryParam:'filterValue_0',minChars:1,triggerAction:'all',editable:true});fC_actividad=new Array();fV_actividad=new Array();fC_actividad[0]='frppa.id_financiador';fV_actividad[0]='%';fC_actividad[1]='frppa.id_regional';fV_actividad[1]='%';fC_actividad[2]='PGPYAC.id_programa';fV_actividad[2]='%';fC_actividad[3]='PGPYAC.id_proyecto';fV_actividad[3]='%';cmb_actividad=new Ext.form.ComboBox({fieldLabel:'Actividad',allowBlank:false,vtype:"texto",emptyText:'Actividad...',name:'id_actividad',desc:'nombre_actividad',store:ds_actividad,valueField:'id_actividad',displayField:'nombre_actividad',queryParam:'filterValue_0',filterCol:'nombre_actividad#codigo_actividad',filterCols:fC_actividad,filterValues:fV_actividad,typeAhead:false,forceSelection:true,tpl:new Ext.Template('<div class="search-item">','<b><i>{codigo_actividad}</i></b>','<br><FONT COLOR="#B5A642">{nombre_actividad}</FONT>','</div>'),mode:'remote',queryDelay:50,pageSize:10,width:350,resizable:true,queryParam:'filterValue_0',minChars:1,triggerAction:'all',editable:true});var onFinanciadorSelect=function(e){var id=cmb_financiador.getValue();cmb_regional.filterValues[0]=id;cmb_regional.modificado=true;cmb_programa.filterValues[0]=id;cmb_programa.modificado=true;cmb_proyecto.filterValues[0]=id;cmb_proyecto.modificado=true;cmb_actividad.filterValues[0]=id;cmb_actividad.modificado=true;cmb_regional.setValue('');cmb_programa.setValue('');cmb_proyecto.setValue('');cmb_actividad.setValue('')};var onRegionalSelect=function(e){var id=cmb_regional.getValue();cmb_programa.filterValues[1]=id;cmb_programa.modificado=true;cmb_proyecto.filterValues[1]=id;cmb_proyecto.modificado=true;cmb_actividad.filterValues[1]=id;cmb_actividad.modificado=true;cmb_programa.setValue('');cmb_proyecto.setValue('');cmb_actividad.setValue('')};var onProgramaSelect=function(e){var id=cmb_programa.getValue();cmb_proyecto.filterValues[2]=id;cmb_proyecto.modificado=true;cmb_actividad.filterValues[2]=id;cmb_actividad.modificado=true;cmb_proyecto.setValue('');cmb_actividad.setValue('')};var onProyectoSelect=function(e){var id=cmb_proyecto.getValue();cmb_actividad.filterValues[3]=id;cmb_actividad.modificado=true;cmb_actividad.setValue('')};var onActividadSelect=function(e){dlgForm.buttons[0].enable()};cmb_financiador.on('select',onFinanciadorSelect);cmb_financiador.on('change',onFinanciadorSelect);cmb_regional.on('select',onRegionalSelect);cmb_regional.on('change',onRegionalSelect);cmb_programa.on('select',onProgramaSelect);cmb_programa.on('change',onProgramaSelect);cmb_proyecto.on('select',onProyectoSelect);cmb_proyecto.on('change',onProyectoSelect);cmb_actividad.on('select',onActividadSelect);cmb_actividad.on('change',onActividadSelect);var formFil=new Ext.form.Form({labelWidth:90});formFil.add(cmb_financiador,cmb_regional,cmb_programa,cmb_proyecto,cmb_actividad);formFil.render('formFil-'+config.nombre)}this.initDatos=initDatos;function showForm(c){contenedor=c;dlgForm.buttons[0].disable();dlgForm.show()}this.showForm=showForm;function hideForm(){dlgForm.hide()}this.hideForm=hideForm;function select(){var aux;value['id_financiador']=cmb_financiador.getValue();aux=cmb_financiador.store.getById(value['id_financiador']).data;value['nombre_financiador']=aux['nombre_financiador'];value['codigo_financiador']=aux['codigo_financiador'];value['id_regional']=cmb_regional.getValue();aux=cmb_regional.store.getById(value['id_regional']).data;value['nombre_regional']=aux['nombre_regional'];value['codigo_regional']=aux['codigo_regional'];value['id_programa']=cmb_programa.getValue();aux=cmb_programa.store.getById(value['id_programa']).data;value['nombre_programa']=aux['nombre_programa'];value['codigo_programa']=aux['codigo_programa'];value['id_proyecto']=cmb_proyecto.getValue();aux=cmb_proyecto.store.getById(value['id_proyecto']).data;value['nombre_proyecto']=aux['nombre_proyecto'];value['codigo_proyecto']=aux['codigo_proyecto'];value['id_actividad']=cmb_actividad.getValue();aux=cmb_actividad.store.getById(value['id_actividad']).data;value['nombre_actividad']=aux['nombre_actividad'];value['codigo_actividad']=aux['codigo_actividad'];this.text=value['codigo_financiador']+'-'+value['codigo_regional']+'-'+value['codigo_programa']+'-'+value['codigo_proyecto']+'-'+value['codigo_actividad'];contenedor.setText(this.text);contenedor.fireEvent("change");dlgForm.hide()}function setValores(x){var p=new Array();p['id_financiador']=x['id_financiador'];p['nombre_financiador']=x['nombre_financiador'];cmb_financiador.store.add(new Ext.data.Record(p,'id_financiador'));cmb_financiador.setValue(x['id_financiador']);p=new Array();p['id_regional']=x['id_regional'];p['nombre_regional']=x['nombre_regional'];cmb_regional.store.add(new Ext.data.Record(p,'id_regional'));cmb_regional.setValue(x['id_regional']);p=new Array();p['id_programa']=x['id_programa'];p['nombre_programa']=x['nombre_programa'];cmb_programa.store.add(new Ext.data.Record(p,'id_programa'));cmb_programa.setValue(x['id_programa']);p=new Array();p['id_proyecto']=x['id_proyecto'];p['nombre_proyecto']=x['nombre_proyecto'];cmb_proyecto.store.add(new Ext.data.Record(p,'id_proyecto'));cmb_proyecto.setValue(x['id_proyecto']);p=new Array();p['id_actividad']=x['id_actividad'];p['nombre_actividad']=x['nombre_actividad'];cmb_actividad.store.add(new Ext.data.Record(p,'id_actividad'));cmb_actividad.setValue(x['id_actividad']);value=x!==undefined&&x!==''?x:new Array()}this.setValores=setValores;function getValores(){return value}this.getValores=getValores;this.initForm();initDatos()}Ext.form.epField=function(config){Ext.form.epField.superclass.constructor.call(this,config);this.nombre=this.getId();con={nombre:this.nombre,sm:this.sm,title:this.emptyText};this.ep=new epForm(con)};Ext.extend(Ext.form.epField,Ext.form.TriggerField,{defaultAutoCreate:{tag:"input",type:"text",size:"24",autocomplete:"off"},nombre:undefined,title:'Estructura Programatica',triggerClass:'x-form-search-trigger',editable:false,value:undefined,text:undefined,onTriggerClick:function(){this.ep.showForm(this)},initEvents:function(){Ext.form.ComboBox.superclass.initEvents.call(this);this.keyNav=new Ext.KeyNav(this.el,{"enter":function(e){this.ep.showForm(this)},"esc":function(e){this.ep.hideForm()}});this.el.dom.setAttribute('readOnly',true);this.el.addClass('x-combo-noedit')},setValue:function(v){text=v!==undefined&&v!==''?v['codigo_financiador']+'-'+v['codigo_regional']+'-'+v['codigo_programa']+'-'+v['codigo_proyecto']+'-'+v['codigo_actividad']:'';this.ep.setValores(v);Ext.form.epField.superclass.setValue.call(this,text);this.value=v},setText:function(t){Ext.form.epField.superclass.setValue.call(this,t)},getValue:function(){return this.ep.getValores()},});