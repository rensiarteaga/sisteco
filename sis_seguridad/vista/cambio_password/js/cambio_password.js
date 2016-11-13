/* 
 * Nombre:		  	    cambio_password.js
 * Propósito: 			Vista que permite cambiar contraseña, estilo y filtro avanzado
 * Autor:				Marcos A. Flores Valda
 * Fecha creación:		21/01/2010
 */

function pagina_cambio_password(idContenedor,direccion,paramConfig)
{	
	var vectorAtributos = new Array;	
	var componentes = new Array();
	var cmp_contrasenia_nueva;
	var cmp_contrasenia_ant;
			
	vectorAtributos[0]=
	{
			validacion:{
				name: 'id_usuario',
				labelSeparator:'',
				inputType:'hidden'
			},
			tipo: 'Field',	
			id_grupo:0
		};
	
	vectorAtributos[1]=
	{
			validacion:{
				name: 'autentificacion',
				fieldLabel:'Autentificación',
				allowBlank:true,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['ldap','Contraseña Windows'],['local','Contraseña ENDESIS']]}),				
				valueField:'id',
				displayField:'valor',
				lazyRender:true,								
				forceSelection:true,
				emptyText:'Seleccione una opción...',
				width:200		
			},
			tipo: 'ComboBox',
			filtro_0:true,			
			id_grupo:0,
			defecto:'no',
			save_as:'txt_autentificacion'
		};
	
	vectorAtributos[2]=   
	{
			validacion:{
				name: 'contrasenia_ant',
				fieldLabel:'Contraseña anterior',
				allowBlank:false,
				inputType:'password',
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				width: 200,
				inputType:'password',	
				grid_visible:true,
				grid_editable:false,
				width_grid:100		
			},
			tipo: 'TextField',
			form: true,
			filtro_0: true,
			id_grupo:2,
			save_as:'txt_contrasenia_ant'
		};	
				
	vectorAtributos[3]={
			validacion:{
				name: 'contrasenia_nueva',
				fieldLabel:'Nueva contraseña',
				allowBlank:true,
				width: 200,	
				maxLength:100,
				minLength:8,
				showCapsWarning: false,
				showStrengthMeter: true,
				//pwStrengthTest: validatePass,
				//pwStrengthTest: seguridad_clave,	
								
				inputType:'password',
				selectOnFocus:true,
				validateValue:
				
					function(pw){
					
						var x = '';
						var seguridad = 0;
											
						if(tiene_numeros(pw)==1)
							seguridad += 18;
						else
							x += 'No contiene números<br>';
									
						
						if(tiene_minusculas(pw)==1)
							seguridad += 18;
						else
							x += 'No contiene minúsculas<br>';
									
						
						if(tiene_mayusculas(pw)==1)
							seguridad += 18;
						else
							x += 'No contiene mayúsculas<br>';
									
						
						if(tiene_especial(pw)==1)
							seguridad += 18;
						else
							x += 'No contiene especiales<br>';
											
						if(pw.length > 8)
							seguridad += 18;
						else
							x += '8 caracteres mínimamente<br>';
						
						cmp_contrasenia_nueva.markInvalid(x);
						
						if(pw.length == 0)
							seguridad = 0;
							
						if(x=='')
							return true
						else
						    return false
					}
			},
			
			tipo: 'PasswordField',
			form: true,
			filtro_0: true,
			id_grupo:2,
			save_as:'txt_contrasenia_nueva'
		};

	vectorAtributos[4]=
	{
			validacion:{
				name: 'confirmacion',
				fieldLabel:'Confirmación',
				allowBlank:false,
				width: 200,	
				maxLength:100,
				minLength:8,
				inputType:'password',				
				selectOnFocus:true,				
				width: 200								
			},
			tipo: 'TextField',
			form: true,
			id_grupo:2,
			save_as:'txt_confirmacion'
		};

	vectorAtributos[5]=
	{	validacion:{
				name: 'mod_contrasenia',
				fieldLabel:'Cambiar contraseña',
				allowBlank:true,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['SI','SI'],['NO','NO']]}),				
				valueField:'id',
				displayField:'valor',
				lazyRender:true,								
				forceSelection:true,
				emptyText:'Seleccione una opción...',
				width:200			
			},
			tipo: 'ComboBox',
			form: true,
			filtro_0:true,	
			defecto:'SI',
			id_grupo:1,
			save_as:'txt_mod_contrasenia'
		};
		
	vectorAtributos[6]=   
	{
			validacion:{
				name: 'contrasenia_windows',
				fieldLabel:'Contraseña actual WINDOWS',
				allowBlank:false,
				inputType:'password',
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				width: 200,
				//vtype:'texto',
				inputType:'password',	
				grid_visible:true,
				grid_editable:false,
				width_grid:100		
			},
			tipo: 'TextField',
			form: true,
			filtro_0: true,
			id_grupo:0,
			save_as:'txt_contrasenia_win'
		};	
	
	vectorAtributos[7]=
	{
			validacion:{
				name: 'estilo',
				fieldLabel:'Estilo de vista',
				allowBlank:true,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['xtheme-aero.css','xtheme-aero.css'],
				                        									['xtheme-gray.css','xtheme-gray.css'],
				                        									['xtheme-vista.css','xtheme-vista.css'],
				                        									['xtheme-galdaka.css','xtheme-galdaka.css'],
				                        									['xtheme-halo.css','xtheme-halo.css']]}),				
				valueField:'id',
				displayField:'valor',
				lazyRender:true,												
				forceSelection:true,
				emptyText:'Seleccione un Estilo...',
				width:200	
			},
			tipo: 'ComboBox',
			filtro_0:true,		
			id_grupo:0,
			save_as:'txt_estilo'
		};

	vectorAtributos[8]=
	{
			validacion:{
				name: 'filtro_avanzado',
				fieldLabel:'Filtro avanzado',
				allowBlank:true,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['si','si'],['no','no']]}),				
				valueField:'id',
				displayField:'valor',
				lazyRender:true,								
				forceSelection:true,
				emptyText:'Seleccione una opción...',
				width:200		
			},
			tipo: 'ComboBox',
			filtro_0:true,			
			id_grupo:0,
			defecto:'no',
			save_as:'txt_filtro_avanzado'
		};		
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){ return value ? value.dateFormat('d/m/Y') : '';	};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout

	var config={titulo_maestro:'Cambiar contraseña'};	
	layout_cambio_password = new DocsLayoutProceso(idContenedor);
	layout_cambio_password.init(config);
	
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_cambio_password,idContenedor);
	
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var CM_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
		
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_procesoSuccess=this.procesoSuccess;
	var CM_enableSelect=this.EnableSelect;
	
	var CM_ocultarComp=this.ocultarComponente;
	var CM_mostrarComp=this.mostrarComponente;
	var CM_submit=this.submit;
	var CM_getForm=this.getForm;
		
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////	
	
    //////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////			
	function obtenerTitulo(){	var titulo = "Cambiar contraseña";		return titulo;	}
	
	//datos necesarios para el filtro
	var paramFunciones = {		
		
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../control/cambio_password/ActionCambiarPassword.php',
	    abrir_pestana:false, //abrir pestana
		//titulo_pestana:obtenerTitulo,			    
		fileUpload:false,
		width:'60%',
		columnas:[350,350],		
		minWidth:150, minHeight:200, closable:true, titulo:'',		
		submit:guardarDatos,
		success:miSuccess,
		failure:miFailure,
		ValidarCampos:function(){return true},
		grupos:[
			{
				tituloGrupo:'Preferencias',
				columna:0,
				id_grupo:0
			},			
			{
				tituloGrupo:'Cambio de contraseña ENDESIS',
				columna:1,
				id_grupo:1
			},
			{
				tituloGrupo:'Datos contraseña ENDESIS',
				columna:1,
				id_grupo:2
			}]
		}	
	};			
	
	function tiene_numeros(pw){
		var expreg=/^.*[0-9]+.*$/;
		if(expreg.test(pw))
	    	return 1;
	  	return 0;
	}
		
	function tiene_letras(pw){
	   var expreg=/^.*[a-zA-ZáéíóúñÁÉÍÓÚÑ]+.*$/;
	  
		if(expreg.test(pw))
	    	return 1;
	  	return 0;
	} 
		
	function tiene_minusculas(pw){
	   var expreg=/^.*[a-záéíóúñ]+.*$/;
		if(expreg.test(pw))
	    	return 1;
	  	return 0;
	} 
	
	function tiene_mayusculas(pw){
	   var expreg=/^.*[A-ZÁÉÍÓÚÑ]+.*$/;
		if(expreg.test(pw))
	    	return 1;
	  	return 0;
	} 
	
	function tiene_especial(pw){
	   var expreg=/^.*\W+.*$/;	   /*[^a-zA-Z0-9áéíóúñÁÉÍÓÚÑ]*/
		if(expreg.test(pw))
	    	return 1;
	  	return 0;
	} 			 
		
	//OTRA FUNCION PARA EVALUAR CLAVES
	/*function valida(pw) 
	{	
		var l = 0;
		var v1 = '0123456789';
		var v2 = 'abcdefghyjklmnñopqrstuvwxyz';
		var v3 = 'vxyzBCDFGHJKLMNPQRST';
		var v4 = 'VXYZ$@#';
		for (var i = 0; i < pw.length; i++)
		{
			if (v1.indexOf(pw[i]) != -1) l += 1;
			else if (v2.indexOf(pw[i]) != -1) l += 2;
			else if (v3.indexOf(pw[i]) != -1) l += 3;
			else if (v4.indexOf(pw[i]) != -1) l += 4;
			else l += 5;
		}
		l *= 3;
		if(l > 100)
		{	
			l = 100;
		}		
		if(l < 30)
		{
			cmp_contrasenia_nueva.markInvalid('SEGURIDAD NINGUNA');
		}
		else if (l < 60) 
		{
			cmp_contrasenia_nueva.markInvalid('SEGURIDAD BAJA');
		}
		else if (l < 90)
		{
			cmp_contrasenia_nueva.markInvalid('SEGURIDAD MEDIA');
		}
		else if (l <= 100)
		{
			cmp_contrasenia_nueva.markInvalid('SEGURIDAD ALTA');
		}
		return l;
		return (pw.length * 10);
	}*/	
	
	//sobrecarga de funciones
	
	function guardarDatos()
	{	
		if(CM_getForm().isValid())
		{				
			if(cmp_contrasenia_nueva.getValue() == cmp_confirmacion.getValue())
			{
				cmp_contrasenia_nueva.setValue(MD5(cmp_contrasenia_nueva.getValue()));
				cmp_confirmacion.setValue(MD5(cmp_confirmacion.getValue()));
				cmp_contrasenia_ant.setValue(MD5(cmp_contrasenia_ant.getValue()));
				cmp_windows.setValue(Base64.encode(cmp_windows.getValue()));				
				CM_submit();				
			}
			else
			{	
				alert('CONFIRMACIÓN NO COINCIDE CON LA CONTRASEÑA NUEVA');	
//				cmp_contrasenia_nueva.setValue("");
//				cmp_confirmacion.setValue("");
//				cmp_contrasenia_ant.setValue("");
			}
		}				
	}
	
	function miSuccess(resp,x)
	{	
		cmp_contrasenia_nueva.setValue("");
		cmp_confirmacion.setValue("");
		cmp_contrasenia_ant.setValue("");
		CM_procesoSuccess(resp,x);
	}
	
	function miFailure(resp1,resp2,resp3,resp4)
	{
		cmp_contrasenia_nueva.setValue("");
		cmp_confirmacion.setValue("");
		cmp_contrasenia_ant.setValue("");
		CM_conexionFailure(resp1,resp2,resp3,resp4);		
	}
	
	//md5 en javascript
		
	var MD5 = function (string) 
	{
		   function RotateLeft(lValue, iShiftBits) 
		   {
		   		return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
		   }

		   function AddUnsigned(lX,lY) 
		   {
		           var lX4,lY4,lX8,lY8,lResult;
		           lX8 = (lX & 0x80000000);
		           lY8 = (lY & 0x80000000);
		           lX4 = (lX & 0x40000000);
		           lY4 = (lY & 0x40000000);
		           lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
		           if (lX4 & lY4) {
		                   return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
		           }
		           if (lX4 | lY4) {
		                   if (lResult & 0x40000000) {
		                           return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
		                   } else {
		                           return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
		                   }
		           } else {
		                   return (lResult ^ lX8 ^ lY8);
		           }
		   }

		   function F(x,y,z) { return (x & y) | ((~x) & z); }
		   function G(x,y,z) { return (x & z) | (y & (~z)); }
		   function H(x,y,z) { return (x ^ y ^ z); }
		   function I(x,y,z) { return (y ^ (x | (~z))); }

		   function FF(a,b,c,d,x,s,ac) {
		           a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
		           return AddUnsigned(RotateLeft(a, s), b);
		   };

		   function GG(a,b,c,d,x,s,ac) {
		           a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
		           return AddUnsigned(RotateLeft(a, s), b);
		   };

		   function HH(a,b,c,d,x,s,ac) {
		           a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
		           return AddUnsigned(RotateLeft(a, s), b);
		   };

		   function II(a,b,c,d,x,s,ac) {
		           a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
		           return AddUnsigned(RotateLeft(a, s), b);
		   };

		   function ConvertToWordArray(string) {
		           var lWordCount;
		           var lMessageLength = string.length;
		           var lNumberOfWords_temp1=lMessageLength + 8;
		           var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
		           var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
		           var lWordArray=Array(lNumberOfWords-1);
		           var lBytePosition = 0;
		           var lByteCount = 0;
		           while ( lByteCount < lMessageLength ) {
		                   lWordCount = (lByteCount-(lByteCount % 4))/4;
		                   lBytePosition = (lByteCount % 4)*8;
		                   lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
		                   lByteCount++;
		           }
		           lWordCount = (lByteCount-(lByteCount % 4))/4;
		           lBytePosition = (lByteCount % 4)*8;
		           lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
		           lWordArray[lNumberOfWords-2] = lMessageLength<<3;
		           lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
		           return lWordArray;
		   };

		   function WordToHex(lValue) {
		           var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
		           for (lCount = 0;lCount<=3;lCount++) {
		                   lByte = (lValue>>>(lCount*8)) & 255;
		                   WordToHexValue_temp = "0" + lByte.toString(16);
		                   WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
		           }
		           return WordToHexValue;
		   };

		   function Utf8Encode(string) {
		           string = string.replace(/\r\n/g,"\n");
		           var utftext = "";

		           for (var n = 0; n < string.length; n++) {

		                   var c = string.charCodeAt(n);

		                   if (c < 128) {
		                           utftext += String.fromCharCode(c);
		                   }
		                   else if((c > 127) && (c < 2048)) {
		                           utftext += String.fromCharCode((c >> 6) | 192);
		                           utftext += String.fromCharCode((c & 63) | 128);
		                   }
		                   else {
		                           utftext += String.fromCharCode((c >> 12) | 224);
		                           utftext += String.fromCharCode(((c >> 6) & 63) | 128);
		                           utftext += String.fromCharCode((c & 63) | 128);
		                   }

		           }

		           return utftext;
		   };

		   var x=Array();
		   var k,AA,BB,CC,DD,a,b,c,d;
		   var S11=7, S12=12, S13=17, S14=22;
		   var S21=5, S22=9 , S23=14, S24=20;
		   var S31=4, S32=11, S33=16, S34=23;
		   var S41=6, S42=10, S43=15, S44=21;

		   string = Utf8Encode(string);

		   x = ConvertToWordArray(string);

		   a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;

		   for (k=0;k<x.length;k+=16) {
		           AA=a; BB=b; CC=c; DD=d;
		           a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
		           d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
		           c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
		           b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
		           a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
		           d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
		           c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
		           b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
		           a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
		           d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
		           c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
		           b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
		           a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
		           d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
		           c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
		           b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
		           a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
		           d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
		           c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
		           b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
		           a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
		           d=GG(d,a,b,c,x[k+10],S22,0x2441453);
		           c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
		           b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
		           a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
		           d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
		           c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
		           b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
		           a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
		           d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
		           c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
		           b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
		           a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
		           d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
		           c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
		           b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
		           a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
		           d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
		           c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
		           b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
		           a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
		           d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
		           c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
		           b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
		           a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
		           d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
		           c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
		           b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
		           a=II(a,b,c,d,x[k+0], S41,0xF4292244);
		           d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
		           c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
		           b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
		           a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
		           d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
		           c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
		           b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
		           a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
		           d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
		           c=II(c,d,a,b,x[k+6], S43,0xA3014314);
		           b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
		           a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
		           d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
		           c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
		           b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
		           a=AddUnsigned(a,AA);
		           b=AddUnsigned(b,BB);
		           c=AddUnsigned(c,CC);
		           d=AddUnsigned(d,DD);
		        }

		        var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);

		        return temp.toLowerCase();
		}
	
	// fin md5 javascript
		
	var cmp_cambio_pass_sel = '';
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{		
		cmp_contrasenia_nueva = ClaseMadre_getComponente('contrasenia_nueva');
		cmp_confirmacion = ClaseMadre_getComponente('confirmacion');
		cmp_contrasenia_ant = ClaseMadre_getComponente('contrasenia_ant');
		cmp_cambio_pass_sel = ClaseMadre_getComponente('mod_contrasenia');		
		cmp_estilo = ClaseMadre_getComponente('estilo');
		cmp_autentificacion = ClaseMadre_getComponente('autentificacion');
		cmp_windows = ClaseMadre_getComponente('contrasenia_windows');
								
		cmp_autentificacion.on('select',onCambioAutentificacion);				
		cmp_cambio_pass_sel.on('select',onCambioPassSelect);
		cmp_estilo.on('select',onCambioEstilo);		
		
		CM_ocultarGrupo('Cambio de contraseña ENDESIS');
		CM_ocultarGrupo('Datos contraseña ENDESIS');	
		CM_ocultarComp(cmp_windows);
		
		cmp_contrasenia_nueva.disable();
		cmp_confirmacion.disable();
		cmp_contrasenia_ant.disable();
		cmp_windows.disable();
		
		ClaseMadre_getComponente('autentificacion').setValue(_CP.getConfig().ss_autentificacion);
		
		if(_CP.getConfig().ss_autentificacion == 'local')
			CM_mostrarGrupo('Cambio de contraseña ENDESIS');	
		
		else
			CM_ocultarGrupo('Cambio de contraseña ENDESIS');
		
		ClaseMadre_getComponente('mod_contrasenia').setValue("NO");	//setea el valor del combo
		ClaseMadre_getComponente('estilo').setValue(_CP.getConfig().ss_estilo_vista); //setea el valor del combo con el estilo actual establecido
		  
		if(_CP.getConfig().ss_filtro_avanzado=='true')
			ClaseMadre_getComponente('filtro_avanzado').setValue("si"); 	//setea el valor del combo
		
		else
			ClaseMadre_getComponente('filtro_avanzado').setValue("no");		//setea el valor del combo				
	}
		
	function onCambioAutentificacion(com,rec,ind)
	{		
		var identificador = cmp_autentificacion.getValue();		
		
		cmp_confirmacion.disable();
	    cmp_contrasenia_ant.disable();
	    cmp_contrasenia_nueva.disable();
		
		if(identificador == "local")		//validar el combo para poder ocultarlo o mostrarlo
		{
			cmp_windows.disable();
			CM_ocultarComp(cmp_windows);
			cmp_windows.setValue("");
			CM_mostrarGrupo('Cambio de contraseña ENDESIS');
			CM_ocultarGrupo('Datos contraseña ENDESIS');
		}
		
		else
		{
			cmp_windows.enable();
			CM_mostrarComp(cmp_windows);
			CM_ocultarGrupo('Cambio de contraseña ENDESIS');
			CM_ocultarGrupo('Datos contraseña ENDESIS');
		    ClaseMadre_getComponente('mod_contrasenia').setValue("NO");
		}
	}	
	
	function onCambioPassSelect(com,rec,ind){
		
		var identificador = cmp_cambio_pass_sel.getValue();
		
		if(identificador =="SI")		//validar el combo para poder ocultarlo o mostrarlo
		{			
			CM_mostrarGrupo('Datos contraseña ENDESIS');
			CM_mostrarComp(cmp_confirmacion);
			CM_mostrarComp(cmp_contrasenia_ant);
			CM_mostrarComp(cmp_contrasenia_nueva);
			
			cmp_confirmacion.enable();
		    cmp_contrasenia_ant.enable();
		    cmp_contrasenia_nueva.enable();		    
		}
		else
		{
			CM_ocultarGrupo('Datos contraseña ENDESIS');
			CM_ocultarComp(cmp_confirmacion);
			CM_ocultarComp(cmp_contrasenia_ant);
			CM_ocultarComp(cmp_contrasenia_nueva);
			
			cmp_confirmacion.disable();
		    cmp_contrasenia_ant.disable();
		    cmp_contrasenia_nueva.disable();
		}	
	}	
		
	function onCambioEstilo(com,rec,ind){
	   _CP.setEstiloVista(cmp_estilo.getValue()); //actualiza el estilo de vista dinamicamente	
	}
	
   //para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_cambio_password.getLayout();};			
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};		
	
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	this.Init(); //iniciamos la clase madre		
	this.InitFunciones(paramFunciones);	
	this.iniciaFormulario();	
		
	iniciarEventosFormularios();	
	_CP.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
