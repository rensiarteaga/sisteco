function Pagina(paramConfig,parametrosDatos,ds,ContenedorLayout,idContenedor){var grid;var configuracion=new Array;var Grupos=new Array();configuracion={TamanoPagina:12,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:false,grid_html:'grid-'+idContenedor};if(paramConfig.TamanoPagina!=null){configuracion.TamanoPagina=paramConfig.TamanoPagina}if(paramConfig.TiempoEspera!=null){configuracion.TiempoEspera=paramConfig.TiempoEspera}if(paramConfig.CantFiltros!=null){configuracion.CantFiltros=paramConfig.CantFiltros}if(paramConfig.FiltroEstructura!=null){configuracion.FiltroEstructura=paramConfig.FiltroEstructura}if(paramConfig.FiltroAvanzado!=null){configuracion.FiltroAvanzado=paramConfig.FiltroAvanzado}if(paramConfig.grid_html!=null){configuracion.grid_html=paramConfig.grid_html}var parametros_barra_menu;var paging;var dlgInfo=false;var dlgLoading;var GuardarOtro=false;var Formulario;var GuardarOtro=false;var vectorDatos=new Array;var cantidadAtributosEntrada=parametrosDatos.length;var cantidadAtributos=parametrosDatos.length;var sm=new Ext.grid.RowSelectionModel({singleSelect:false});Ed=Ext.grid.GridEditor;var Componentes=new Array();var Componentes_grid=new Array();var parametrosCM=new Array();for(var i=0;i<cantidadAtributos;i++){var vA=parametrosDatos[i].validacion;if(parametrosDatos[i].tipo=='LovTriggerField'||parametrosDatos[i].tipo=='LovItemsAlm'){vA.origen='formulario';Componentes[i]=new Ext.form[parametrosDatos[i].tipo](vA);if(vA.grid_editable!=undefined&&vA.grid_editable!=null&&vA.grid_editable!=false){vA.sm=sm;vA.origen='grid';Componentes_grid[i]=new Ext.form[parametrosDatos[i].tipo](vA)}}else{Componentes[i]=new Ext.form[parametrosDatos[i].tipo](vA);if(vA.grid_editable===true&&vA.grid_visible===true){Componentes_grid[i]=new Ext.form[parametrosDatos[i].tipo](vA)}}if(parametrosDatos[i].tipo=='ComboBox'){vA.store.addListener('loadexception',ContenedorPrincipal.conexionFailure)}var elemento;if(vA.grid_visible==true){var header=vA.name;if(vA.fieldLabel!==undefined){header=vA.fieldLabel;}var align='left';if(vA.align!=undefined){align=vA.align;}if(parametrosDatos[i].tipo!=='epField'){if(vA.grid_editable===true){elemento={grid_indice:vA.grid_indice,ind2:i,header:header,width:vA.width_grid,dataIndex:vA.name,renderer:vA.renderer,align:align,desc:vA.desc,editor:new Ed(Componentes_grid[i])}}else{elemento={grid_indice:vA.grid_indice,ind2:i,header:header,width:vA.width_grid,dataIndex:vA.name,renderer:vA.renderer,align:align,desc:vA.desc}}parametrosCM.push(elemento)}else{elemento={grid_indice:vA.grid_indice,ind2:i,ind3:1,header:'Financiador',width:200,dataIndex:'nombre_financiador'};parametrosCM.push(elemento);elemento={grid_indice:vA.grid_indice,ind2:i,ind3:2,header:'Regional',width:100,dataIndex:'nombre_regional'};parametrosCM.push(elemento);elemento={grid_indice:vA.grid_indice,ind2:i,ind3:3,header:'Programa',width:100,dataIndex:'nombre_programa'};parametrosCM.push(elemento);elemento={grid_indice:vA.grid_indice,ind2:i,ind3:4,header:'Sub Programa',width:250,dataIndex:'nombre_proyecto'};parametrosCM.push(elemento);elemento={grid_indice:vA.grid_indice,ind2:i,ind3:5,header:'Actividad',width:100,dataIndex:'nombre_actividad'};parametrosCM.push(elemento)}}}function ordenacionAsc(x,y){if(x.grid_indice!=undefined&&y.grid_indice!=undefined){if(x.grid_indice<y.grid_indice){return-1}if(x.grid_indice>y.grid_indice){return 1}}if((x.grid_indice==undefined&&y.grid_indice==undefined)||x.grid_indice===y.grid_indice){if(x.ind2<y.ind2){return-1}if(x.ind2>y.ind2){return 1}if(x.ind2==y.ind2&&x.ind2!=undefined){if(x.ind3<y.ind3){return-1}if(x.ind3>y.ind3){return 1}return 0}return 0}if(x.grid_indice==undefined&&y.grid_indice!=undefined){return 1}if(x.grid_indice!=undefined&&y.grid_indice==undefined){return-1}return 0}parametrosCM.sort(ordenacionAsc);var cm=new Ext.grid.DefaultColumnModel(parametrosCM);cm.defaultSortable=true;this.Init=function(){Ext.QuickTips.init();Ext.form.Field.prototype.msgTarget='qtip';ds.addListener('loadexception',this.conexionFailure);sm.addListener('rowselect',this.EnableSelect);this.grid=new Ext.grid.EditorGrid(configuracion.grid_html,{ds:ds,cm:cm,selModel:sm,enableColLock:true});grid=this.grid;this.grid.render();var gridFoot=this.grid.getView().getFooterPanel(true);paging=new Ext.PagingToolbar(gridFoot,ds,{pageSize:configuracion.TamanoPagina,displayInfo:true,displayMsg:'Registros {0} - {1} de {2}',emptyMsg:"No hay registros para mostrar"});this.onResize=function(){var gridView=grid.getView();gridView.layout()};this.onResizePrimario=function(){ContenedorLayout.getLayout().layout()};InitFiltro(paging,configuracion.CantFiltros);if(configuracion.FiltroEstructura==true){this.filtro_ep=FiltroEstructuraProgramatica;this.filtro_ep("filtro-"+idContenedor);this.Init_FiltroEstructura(ds,conexionFailure,this.btnActualizar)}};this.mostrarFormulario=function(){dlgInfo.show();Ext.form.Field.prototype.msgTarget='under';limpiarInvalidos()};mostrarFormulario=this.mostrarFormulario;this.ocultarFormulario=function(){dlgInfo.hide();Ext.form.Field.prototype.msgTarget='qtip'};var ocultarFormulario=this.ocultarFormulario;this.iniciaFormulario=function(){if(!dlgInfo){marcas_html="<div class='x-dlg-hd'>"+Funcion_Formulario.titulo+"</div><div class='x-dlg-bd'><div id='form-ct2_"+Funcion_Formulario.html_apply+"'></div></div>";var div_dlgInfo=Ext.DomHelper.append(document.body,{tag:'div',id:Funcion_Formulario.html_apply,html:marcas_html});Formulario=new Ext.form.Form({id:'formulario_'+Funcion_Formulario.html_apply,name:'formulario_'+Funcion_Formulario.html_apply,labelWidth:Funcion_Formulario.labelWidth,method:Funcion_Formulario.method,url:Funcion_Save.url,fileUpload:Funcion_Formulario.upload,success:Funcion_Save.success,failure:Funcion_Save.failure});dlgInfo=new Ext.BasicDialog(div_dlgInfo,{modal:Funcion_Formulario.modal,autoTabs:Funcion_Formulario.autoTabs,width:Funcion_Formulario.width,height:Funcion_Formulario.height,shadow:Funcion_Formulario.shadow,minWidth:Funcion_Formulario.minWidth,minHeight:Funcion_Formulario.minHeight,fixedcenter:Funcion_Formulario.fixedcenter,constraintoviewport:Funcion_Formulario.constraintoviewport,draggable:Funcion_Formulario.draggable,proxyDrag:Funcion_Formulario.proxyDrag,closable:Funcion_Formulario.closable});dlgInfo.addKeyListener(27,Funcion_Formulario.cancelar);dlgInfo.addButton('Guardar',Funcion_Formulario.guardar);dlgInfo.addButton('Guardar + Nuevo',Funcion_Formulario.guardarOtro).disable();dlgInfo.addButton('Cancelar',Funcion_Formulario.cancelar);for(var i=0;i<Funcion_Formulario.columnas.length;i++){Formulario.column({width:Funcion_Formulario.columnas[i],style:'margin-left:10px',clear:true});for(var j=0;j<Funcion_Formulario.grupos.length;j++){if(Funcion_Formulario.grupos[j].columna==i){Grupos[j]=Formulario.fieldset({legend:Funcion_Formulario.grupos[j].tituloGrupo});for(var k=0;k<cantidadAtributosEntrada;k++){var id_grupo=0;if(parametrosDatos[k].id_grupo!=undefined&&parametrosDatos[k].id_grupo!=null){id_grupo=parametrosDatos[k].id_grupo}if(id_grupo==j){Formulario.add(Componentes[k]);vectorDatos[k]=Componentes[k];vectorDatos[k].on('valid',function(){dlgInfo.buttons[0].enable()})}}Formulario.end()}}Formulario.end()}Formulario.render("form-ct2_"+Funcion_Formulario.html_apply)}};var iniciaFormulario=this.iniciaFormulario;this.getFormulario=function(){return Formulario};var getFormulario=this.getFormulario;this.renderFormulario=function(){Formulario.render("form-ct2_"+Funcion_Formulario.html_apply)};var renderFormulario=this.renderFormulario;this.ValidarCampos=function(){return Formulario.isValid()};var ValidarCampos=this.ValidarCampos;this.limpiarInvalidos=function(){return Formulario.clearInvalid()};var limpiarInvalidos=this.limpiarInvalidos;this.EnableSelect=function(selModel,row,selected){var record=selModel.getSelected().data;if(selected&&record!=-1){for(var i=0;i<cantidadAtributos;i++){if(parametrosDatos[i].validacion.inputType!='file'&&parametrosDatos[i].tipo!='ComboBox'&&parametrosDatos[i].tipo!='epField'&&parametrosDatos[i].tipo!='LovItemsAlm'){if(record[parametrosDatos[i].validacion.name]===undefined){vectorDatos[i].setValue('')}else{vectorDatos[i].setValue(record[parametrosDatos[i].validacion.name])}}else{if(parametrosDatos[i].tipo=='ComboBox'){if(vectorDatos[i].mode=='remote'){if(vectorDatos[i].store.getById(record[parametrosDatos[i].validacion.name])===undefined){var params=new Array();params[vectorDatos[i].valueField]=record[parametrosDatos[i].validacion.name];params[vectorDatos[i].displayField]=record[parametrosDatos[i].validacion.desc];var aux=new Ext.data.Record(params,record[parametrosDatos[i].validacion.name]);vectorDatos[i].store.add(aux)}vectorDatos[i].setValue(record[parametrosDatos[i].validacion.name])}else{vectorDatos[i].setValue(record[parametrosDatos[i].validacion.name])}}if(parametrosDatos[i].tipo=='LovItemsAlm'){var p=new Array();p={id:record[parametrosDatos[i].validacion.name],desc:record[parametrosDatos[i].validacion.desc]};vectorDatos[i].setValue(p)}if(parametrosDatos[i].tipo=='epField'){var p=new Array();p={id_financiador:record['id_financiador'],codigo_financiador:record['codigo_financiador'],nombre_financiador:record['nombre_financiador'],id_regional:record['id_regional'],codigo_regional:record['codigo_regional'],nombre_regional:record['nombre_regional'],id_programa:record['id_programa'],codigo_programa:record['codigo_programa'],nombre_programa:record['nombre_programa'],id_proyecto:record['id_proyecto'],codigo_proyecto:record['codigo_proyecto'],nombre_proyecto:record['nombre_proyecto'],id_actividad:record['id_actividad'],codigo_actividad:record['codigo_actividad'],nombre_actividad:record['nombre_actividad']};vectorDatos[i].setValue(p)}}}}};var EnableSelect=this.EnableSelect;this.btnActualizar=function(){var filas=ds.getModifiedRecords();var cont=filas.length;if(cont>0){if(confirm("Tiene registros pendientes sin guardar que se perderan, desea continuar?")){ds.load(ds.lastOptions);ds.rejectChanges()}}else{ds.load(ds.lastOptions);ds.rejectChanges()}};var btnActualizar=this.btnActualizar;btnNew=function(){dlgInfo.buttons[1].enable();sm.clearSelections();for(var i=0;i<cantidadAtributos;i++){var value="";if(parametrosDatos[i].defecto!=undefined){value=parametrosDatos[i].defecto}vectorDatos[i].setValue(value)}var filas=ds.getModifiedRecords();var cont=filas.length;if(cont>0){if(confirm("Tiene registros pendientes sin guardar que se perderan, desea continuar?")){Funcion_Formulario.mostrar()}}else{Funcion_Formulario.mostrar()}};this.btnNew=btnNew;this.btnEdit=function(){dlgInfo.buttons[1].disable();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();sm.clearSelections();if(NumSelect!=0){if(cont>0){var confirmar=function(btn){if(btn=='yes'){Funcion_Formulario.mostrar()}};Ext.MessageBox.confirm('Confirmar','Tiene registros pendientes sin guardar que se perderan, desea continuar?',confirmar)}else{Funcion_Formulario.mostrar()}}else{Ext.MessageBox.alert('Estado','Seleccione un item primero.')}dlgInfo.buttons[0].disable();};var btnEdit=this.btnEdit;this.btnEliminar=function(){var NumSelect=sm.getCount();if(NumSelect!=0){var filas=ds.getModifiedRecords();var cont=filas.length;var sw=false;var confirmar;if(cont>0){if(confirm('Tiene registros pendientes sin guardar que se perderan, desea continuar?')){sw=true}}else{sw=true}if(sw){if(confirm(Funcion_btnEliminar.mensaje)){var SelectionsRecord=sm.getSelections();var postData="cantidad_ids="+NumSelect;parametrosFiltro="";for(var i=0;i<configuracion.CantFiltros;i++){parametrosFiltro=parametrosFiltro+"&filterCol_"+i+"="+ds.lastOptions.params["filterCol_"+i];parametrosFiltro=parametrosFiltro+"&filterValue_"+i+"="+ds.lastOptions.params["filterValue_"+i]}postData=postData+parametrosFiltro+Funcion_btnEliminar.parametros;for(j=0;j<Funcion_ConfirmSave.parametros_ds.length;j++){var aux=Funcion_ConfirmSave.parametros_ds[j];postData=postData+"&"+aux+"="+ds.lastOptions.params[aux];}for(var i=0;i<NumSelect;i++){idSelect=SelectionsRecord[i].data[parametrosDatos[0].validacion.name];var postData=postData+"&"+parametrosDatos[0].save_as+"_"+i+"="+idSelect}Ext.MessageBox.show({title:'Espere Por Favor...',msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",width:150,height:200,closable:false});Ext.Ajax.request({url:Funcion_btnEliminar.url,params:postData,method:'POST',success:Funcion_btnEliminar.success,failure:Funcion_btnEliminar.failure,timeout:configuracion.TiempoEspera});}}}else{Ext.MessageBox.alert('Estado','Seleccione un item primero.')}};var btnEliminar=this.btnEliminar;this.eliminarSucess=function(resp){Ext.MessageBox.hide();if(resp.responseXML!=undefined&&resp.responseXML.documentElement!=undefined){var root=resp.responseXML.documentElement;Ext.mensajes.msg('Eliminaci�n Exitosa','Se tienen "{0}" registros.',root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue);var total_registros=new Number(root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue);var total_paginas=Math.ceil(total_registros/configuracion.TamanoPagina);var paginaData=paging.getPageData();var pagina=paginaData.activePage;var puntero=0;if(pagina>total_paginas){pagina=pagina-1}if(pagina>1){puntero=(pagina-1)*configuracion.TamanoPagina}ds.lastOptions.params.start=puntero;ds.load(ds.lastOptions);ds.rejectChanges();origen=undefined;if(root.getElementsByTagName('origen')[0]!=undefined){origen=root.getElementsByTagName('origen')[0].firstChild.nodeValue}parametros_mensaje={origen:origen,mensaje:root.getElementsByTagName('mensaje')[0].firstChild.nodeValue,tiempo_resp:root.getElementsByTagName('tiempo_resp')[0].firstChild.nodeValue,TotalCount:root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue};ContenedorPrincipal.setEventoLog(parametros_mensaje)}else{conexionFailure(resp)}};var eliminarSucess=this.eliminarSucess;this.ConfirmSave=function(){var filas=ds.getModifiedRecords();var cont=filas.length;if(cont>0){if(confirm("�Est� seguro de guardar los cambios?")){var postData="cantidad_ids="+cont;var i=0;for(i=0;i<cont;i++){var record=filas[i].data;for(var j=0;j<cantidadAtributos;j++){if(parametrosDatos[j].tipo!='DateField'){if(parametrosDatos[j].tipo=='epField'){postData=postData+"&txt_id_financiador_"+i+"="+record['id_financiador']+"&txt_id_regional_"+i+"="+record['id_regional']+"&txt_id_programa_"+i+"="+record['id_programa']+"&txt_id_proyecto_"+i+"="+record['id_proyecto']+"&txt_id_actividad_"+i+"="+record['id_actividad']}else{postData=postData+"&"+parametrosDatos[j].save_as+"_"+i+"="+record[parametrosDatos[j].validacion.name]}}else{if(record[parametrosDatos[j].validacion.name]!=""){postData=postData+"&"+parametrosDatos[j].save_as+"_"+i+"="+record[parametrosDatos[j].validacion.name].dateFormat(parametrosDatos[j].dateFormat)}else{postData=postData+"&"+parametrosDatos[j].save_as+"_"+i+"="+record[parametrosDatos[j].validacion.name]}}}}parametrosFiltro="";for(var i=0;i<configuracion.CantFiltros;i++){parametrosFiltro=parametrosFiltro+"&filterCol_"+i+"="+ds.lastOptions.params["filterCol_"+i];parametrosFiltro=parametrosFiltro+"&filterValue_"+i+"="+ds.lastOptions.params["filterValue_"+i]}postData=postData+parametrosFiltro+Funcion_ConfirmSave.parametros;for(j=0;j<Funcion_ConfirmSave.parametros_ds.length;j++){var aux=Funcion_ConfirmSave.parametros_ds[j];postData=postData+"&"+aux+"="+ds.lastOptions.params[aux]}Ext.Ajax.request({url:Funcion_ConfirmSave.url,params:postData,method:'POST',success:Funcion_ConfirmSave.success,failure:Funcion_ConfirmSave.failure,argument:Funcion_ConfirmSave.argument,timeout:Funcion_ConfirmSave.timeout});}}};var ConfirmSave=this.ConfirmSave;this.Save=function(){if(Funcion_Save.validar()){var postData="cantidad_ids=1";parametrosFiltro="";for(var i=0;i<configuracion.CantFiltros;i++){parametrosFiltro=parametrosFiltro+"&filterCol_"+i+"="+ds.lastOptions.params["filterCol_"+i];parametrosFiltro=parametrosFiltro+"&filterValue_"+i+"="+ds.lastOptions.params["filterValue_"+i]}postData=postData+parametrosFiltro+Funcion_Save.parametros;var cantidadAtributos=parametrosDatos.length;var postCadena=Formulario.getValues;for(var i=0;i<cantidadAtributos;i++){if(parametrosDatos[i].save_as){if(parametrosDatos[i].tipo=='DateField'){hora=vectorDatos[i].getValue();if(hora!=""){postData=postData+"&"+parametrosDatos[i].save_as+"_0="+hora.dateFormat(parametrosDatos[i].dateFormat)}else{postData=postData+"&"+parametrosDatos[i].save_as+"_0="+hora}}else{if(parametrosDatos[i].tipo=='epField'){var p=vectorDatos[i].getValue();postData=postData+"&txt_id_financiador_0="+p['id_financiador']+"&txt_id_regional_0="+p['id_regional']+"&txt_id_programa_0="+p['id_programa']+"&txt_id_proyecto_0="+p['id_proyecto']+"&txt_id_actividad_0="+p['id_actividad']}else{postData=postData+"&"+parametrosDatos[i].save_as+"_0="+vectorDatos[i].getValue()}}}}for(j=0;j<Funcion_ConfirmSave.parametros_ds.length;j++){var aux=Funcion_ConfirmSave.parametros_ds[j];postData=postData+"&"+aux+"="+ds.lastOptions.params[aux]}Ext.MessageBox.show({title:'Espere Por Favor...',msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",width:150,height:200,closable:false});Ext.Ajax.request({url:Formulario.url,params:postData,isUpload:Formulario.fileUpload,method:Formulario.method,success:Formulario.success,argument:Funcion_Save.argument,failure:Formulario.failure,timeout:Funcion_Save.timeout});}};var Save=this.Save;this.SaveAndOther=function(){GuardarOtro=true;Funcion_Formulario.guardar()};var SaveAndOther=this.SaveAndOther;this.saveSuccess=function(resp){Ext.MessageBox.hide();if(resp.responseXML!=undefined&&resp.responseXML.documentElement!=undefined){var root=resp.responseXML.documentElement;if(!resp.argument.multi){Funcion_Formulario.ocultar();if(GuardarOtro){parametros_barra_menu.nuevo.sobrecarga();GuardarOtro=false}}Ext.mensajes.msg('Grabaci�n exitosa','Se tienen "{0}" registros.',root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue);var total_registros=new Number(root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue);var total_paginas=Math.ceil(total_registros/configuracion.TamanoPagina);var paginaData=paging.getPageData();var pagina=paginaData.activePage;var puntero=0;if(pagina>total_paginas){pagina=pagina-1}if(pagina!=1){puntero=(pagina-1)*configuracion.TamanoPagina}ds.lastOptions.params.start=puntero;ds.load(ds.lastOptions);ds.rejectChanges();sm.clearSelections();origen=undefined;if(root.getElementsByTagName('origen')[0]!=undefined){origen=root.getElementsByTagName('origen')[0].firstChild.nodeValue}parametros_mensaje={origen:origen,mensaje:root.getElementsByTagName('mensaje')[0].firstChild.nodeValue,tiempo_resp:root.getElementsByTagName('tiempo_resp')[0].firstChild.nodeValue,TotalCount:root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue};ContenedorPrincipal.setEventoLog(parametros_mensaje);}else{conexionFailure(resp)}};saveSuccess=this.saveSuccess;function conexionFailure(resp1,resp2,resp3,resp4){ContenedorPrincipal.conexionFailure(resp1,resp2,resp3,resp4)};this.conexionFailure=conexionFailure;this.InitBarraMenu=function(param){parametros_barra_menu=param;this.barra=Boton;this.barra(this.grid);if(param.guardar){if(!param.guardar.sobrecarga){param.guardar.sobrecarga=this.ConfirmSave}this.AdicionarBoton("../../../lib/imagenes/save.jpg",'<b>Guardar<b>',param.guardar.sobrecarga,param.guardar.separador,'guardar','')}if(param.nuevo){if(!param.nuevo.sobrecarga){param.nuevo.sobrecarga=this.btnNew}this.AdicionarBoton("../../../lib/imagenes/nuevo.png",'<b>Nuevo<b>',param.nuevo.sobrecarga,param.nuevo.separador,'nuevo','')}if(param.editar){if(!param.editar.sobrecarga){param.editar.sobrecarga=this.btnEdit}this.AdicionarBoton("../../../lib/imagenes/editar.png",'<b>Editar<b>',param.editar.sobrecarga,param.editar.separador,'editar','')}if(param.eliminar){if(!param.eliminar.sobrecarga){param.eliminar.sobrecarga=this.btnEliminar}this.AdicionarBoton("../../../lib/imagenes/eliminar.png",'<b>Eliminar<b>',param.eliminar.sobrecarga,param.eliminar.separador,'eliminar','')}if(param.actualizar){if(!param.actualizar.sobrecarga){param.actualizar.sobrecarga=this.btnActualizar}this.AdicionarBoton("../../../lib/imagenes/actualizar.jpg",'<b>Actualizar<b>',param.actualizar.sobrecarga,param.actualizar.separador,'actualizar','')}};this.InitFiltro=function(Barra,Cantidad){var Menus=new Array();var Combos=new Array();var MenusItems=new Array();for(var i=0;i<Cantidad;i++){Barra.addSeparator();if(configuracion.FiltroAvanzado==true){MenusItems["quickMenuItems_"+i]=new Array();MenusItems["quickMenuItems_"+i].push(new Ext.menu.CheckItem({value:'filterAvanzado',text:'Filtro Avanzado',checked:false}));MenusItems["quickMenuItems_"+i].push('-');MenusItems["quickMenuItems_"+i].push('<b class="menu-title">Filtrar Por :</b>')}else{MenusItems["quickMenuItems_"+i]=new Array('<b class="menu-title">Filtrar Por :</b>')}var filtroIni=0;for(var j=0;j<cantidadAtributos;j++){if(parametrosDatos[j]["filtro_"+i]!=null&&parametrosDatos[j]["filtro_"+i]==true){if(parametrosDatos[j].filterColValue){value=parametrosDatos[j].filterColValue}else{value=parametrosDatos[j].validacion.name}if(parametrosDatos[j].validacion.fieldLabel){text=parametrosDatos[j].validacion.fieldLabel}else{text=parametrosDatos[j].validacion.name}filtroIni++;if(filtroIni==1){MenusItems["quickMenuItems_"+i].push(new Ext.menu.CheckItem({value:value,text:text,checked:true}))}else{MenusItems["quickMenuItems_"+i].push(new Ext.menu.CheckItem({value:value,text:text,checked:false}))}}}Menus["quickMenu_"+i]=new Ext.menu.Menu({items:MenusItems["quickMenuItems_"+i]});Barra.add({text:'Filtro',tooltip:'Columnas por las que se filtra',icon:'../../../lib/images/m.png',cls:'x-btn-text-icon btn-search-icon',menu:Menus["quickMenu_"+i]});var sftb=Barra.addDom({tag:'input',id:'quicksearch_'+i+"-"+configuracion.grid_html,type:'text',size:30,value:'',style:'background: #F0F0F9;'});Combos["searchBox_"+i]=new Ext.form.TextField({emptyText:"Criterio de B�squeda",width:110});Combos["searchBox_"+i].applyTo('quicksearch_'+i+"-"+configuracion.grid_html);var onFilteringBeforeQuery=function(e){for(k=0;k<Cantidad;k++){var sw=true;var cuentaCol=0;var filterCol="";var filterAvanzado=false;for(var p=0,items=MenusItems["quickMenuItems_"+k],len=items.length;p<len;p++){if(items[p].value!='filterAvanzado'){if(items[p].checked){cuentaCol++;if(sw){filterCol=items[p].value;sw=false}else{filterCol=filterCol+"#"+items[p].value}}}else{filterAvanzado=items[p].checked}}if(cuentaCol==0){Combos["searchBox_"+k].setValue("")}if(cuentaCol==0){Combos["searchBox_"+k].setValue("");Combos["searchBox_"+k].disable()}else{Combos["searchBox_"+k].enable()}var value=Combos["searchBox_"+k].getValue();ds.lastOptions.params["filterCol_"+k]=filterCol;ds.lastOptions.params["filterValue_"+k]=value;ds.lastOptions.params["filterAvanzado_"+k]=filterAvanzado}ds.lastOptions.params.start=0;ds.load(ds.lastOptions)};Menus["quickMenu_"+i].on('click',onFilteringBeforeQuery);Combos["searchBox_"+i].el.on("keyup",onFilteringBeforeQuery)}};var InitFiltro=this.InitFiltro;parametrosFiltro="&CantFiltros="+paramConfig.CantFiltros;var Funcion_btnEliminar={success:this.eliminarSucess,failure:this.conexionFailure,timeout:configuracion.TiempoEspera,url:"../../control/",parametros:parametrosFiltro,parametros_ds:[],mensaje:"�Est� seguro de eliminar el registro?"};var Funcion_Save={success:this.saveSuccess,argument:{multi:false},failure:this.conexionFailure,timeout:configuracion.TiempoEspera,url:"../../control/",parametros:parametrosFiltro,parametros_ds:[],validar:ValidarCampos};var Funcion_ConfirmSave={success:this.saveSuccess,argument:{multi:true},failure:this.conexionFailure,timeout:configuracion.TiempoEspera,url:"../../control/",parametros_ds:[],parametros_ds:[]};var Funcion_Formulario={titulo:'Formulario ...',html_apply:"dlgInfo-"+idContenedor,guardar:this.Save,guardarOtro:this.SaveAndOther,cancelar:ocultarFormulario,ocultar:ocultarFormulario,mostrar:mostrarFormulario,modal:true,autoTabs:false,width:450,height:500,shadow:false,minWidth:150,minHeight:200,fixedcenter:true,constraintoviewport:true,draggable:true,proxyDrag:true,closable:true,upload:false,labelWidth:100,method:'post',columnas:[450],grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0}]};this.InitFunciones=function(param){if(param.btnEliminar){if(param.btnEliminar.url!=null){Funcion_btnEliminar.url=param.btnEliminar.url;}if(param.btnEliminar.mensaje!=null){Funcion_btnEliminar.mensaje=param.btnEliminar.mensaje}if(param.btnEliminar.parametros!=null){Funcion_btnEliminar.parametros=Funcion_btnEliminar.parametros+param.btnEliminar.parametros}if(param.btnEliminar.failure!=null){Funcion_btnEliminar.failure=param.btnEliminar.failure}if(param.btnEliminar.success!=null){Funcion_btnEliminar.success=param.btnEliminar.success}if(param.btnEliminar.argument!=null){Funcion_btnEliminar.argument=param.btnEliminar.argument}if(param.btnEliminar.parametros_ds!=null){Funcion_btnEliminar.parametros_ds=param.btnEliminar.parametros_ds}}if(param.Save){if(param.Save.url!=null){Funcion_Save.url=param.Save.url}if(param.Save.parametros!=null){Funcion_Save.parametros=Funcion_Save.parametros+param.Save.parametros}if(param.Save.argument!=null){Funcion_Save.argument=param.Save.argument}if(param.Save.timeout!=null){Funcion_Save.timeout=param.Save.timeout}if(param.Save.failure!=null){Funcion_Save.failure=param.Save.failure}if(param.Save.success!=null){Funcion_Save.success=param.Save.success}if(param.Save.validar!=null){Funcion_Save.validar=param.Save.validar}if(param.Save.parametros_ds!=null){Funcion_Save.parametros_ds=param.Save.parametros_ds}}if(param.ConfirmSave){if(param.ConfirmSave.url!=null){Funcion_ConfirmSave.url=param.ConfirmSave.url}if(param.ConfirmSave.parametros!=null){Funcion_ConfirmSave.parametros=Funcion_ConfirmSave.parametros+param.ConfirmSave.parametros}if(param.ConfirmSave.argument!=null){Funcion_ConfirmSave.argument=param.ConfirmSave.argument}if(param.ConfirmSave.timeout!=null){Funcion_ConfirmSave.timeout=param.ConfirmSave.timeout}if(param.ConfirmSave.failure!=null){Funcion_ConfirmSave.failure=param.ConfirmSave.failure}if(param.ConfirmSave.success!=null){Funcion_ConfirmSave.success=param.ConfirmSave.success}if(param.ConfirmSave.parametros_ds!=null){Funcion_ConfirmSave.parametros_ds=param.ConfirmSave.parametros_ds}}if(param.Formulario){if(param.Formulario.titulo!=null){Funcion_Formulario.titulo=param.Formulario.titulo}if(param.Formulario.guardar!=null){Funcion_Formulario.guardar=param.Formulario.guardar}if(param.Formulario.guardarOtro!=null){Funcion_Formulario.guardarOtro=param.Formulario.guardarOtro}if(param.Formulario.cancelar!=null){Funcion_Formulario.cancelar=param.Formulario.cancelar}if(param.Formulario.ocultar!=null){Funcion_Formulario.ocultar=param.Formulario.ocultar}if(param.Formulario.mostrar!=null){Funcion_Formulario.mostrar=param.Formulario.mostrar}if(param.Formulario.modal!=null){Funcion_Formulario.modal=param.Formulario.modal}if(param.Formulario.autoTabs!=null){Funcion_Formulario.autoTabs=param.Formulario.autoTabs}if(param.Formulario.width!=null){Funcion_Formulario.width=param.Formulario.width}if(param.Formulario.height!=null){Funcion_Formulario.height=param.Formulario.height}if(param.Formulario.shadow!=null){Funcion_Formulario.shadow=param.Formulario.shadow}if(param.Formulario.minWidth!=null){Funcion_Formulario.minWidth=param.Formulario.minWidth}if(param.Formulario.minHeight!=null){Funcion_Formulario.minHeight=param.Formulario.minHeight}if(param.Formulario.fixedcenter!=null){Funcion_Formulario.fixedcenter=param.Formulario.fixedcenter}if(param.Formulario.constraintoviewport!=null){Funcion_Formulario.constraintoviewport=param.Formulario.constraintoviewport}if(param.Formulario.draggable!=null){Funcion_Formulario.draggable=param.Formulario.draggable}if(param.Formulario.proxyDrag!=null){Funcion_Formulario.proxyDrag=param.Formulario.proxyDrag}if(param.Formulario.closable!=null){Funcion_Formulario.closable=param.Formulario.closable}if(param.Formulario.upload!=null){Funcion_Formulario.upload=param.Formulario.upload}if(param.Formulario.method!=null){Funcion_Formulario.method=param.Formulario.method}if(param.Formulario.labelWidth!=null){Funcion_Formulario.labelWidth=param.Formulario.labelWidth}if(param.Formulario.columnas!=null){Funcion_Formulario.columnas=param.Formulario.columnas}if(param.Formulario.grupos!=null){Funcion_Formulario.grupos=param.Formulario.grupos}if(param.Formulario.html_apply!=null){Funcion_Formulario.html_apply=param.Formulario.html_apply}}};this.getSelectionModel=function(){return sm};getSelectionModel=this.getSelectionModel;this.getVectorDatos=function(){return vectorDatos};getVectorDatos=this.getVectorDatos;this.getComponente=function(componente_name){parametrosDatos.length;var i=0;for(i=0;i<parametrosDatos.length;i++){if(parametrosDatos[i].validacion.name===componente_name){break}}return vectorDatos[i]};getComponente=this.getComponente;this.ocultarComponente=function(comp){comp.el.up('.x-form-item').down('label').update('');comp.hide()};ocultarComponente=this.ocultarComponente;this.mostrarComponente=function(comp){comp.el.up('.x-form-item').down('label').update(comp.fieldLabel);comp.show()};mostrarComponente=this.mostrarComponente;this.ocultarTodosComponente=function(){for(var i=1;i<parametrosDatos.length;i++){vectorDatos[i].el.up('.x-form-item').down('label').update('');vectorDatos[i].hide()}};ocultarTodosComponente=this.ocultarTodosComponente;this.motrarTodosComponente=function(){for(var i=1;i<parametrosDatos.length;i++){vectorDatos[i].el.up('.x-form-item').down('label').update(vectorDatos[i].fieldLabel);vectorDatos[i].show()}};mostrarTodosComponente=this.mostrarTodosComponente;this.mostrarGrupo=function(nom){j=0;tam=Funcion_Formulario.grupos.length;while(j<tam){if(Grupos[j].legend==nom){Grupos[j].show();j=tam}j++}};this.ocultarGrupo=function(nom){j=0;tam=Funcion_Formulario.grupos.length;while(j<tam){if(Grupos[j].legend==nom){Grupos[j].hide();j=tam}j++}};this.getDialog=function(){return dlgInfo};getDialog=this.getDialog;this.getGrid=function(){return grid};getGrid=this.getGrid;this.clearSelections=function(){sm.clearSelections()}}