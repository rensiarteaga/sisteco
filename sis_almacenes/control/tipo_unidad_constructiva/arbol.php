<?php 


[
    {
    	"text":
    	"Usuarios",
    	"id":"1",
    	"leaf":false,
    	"cls":"folder",
    	"children":  [  
    	               {
    	               	 "text":"Visualizar",
    	                 "id":"2",
    	                 "leaf":true,
    	                 "cls":"file"
    	               }]
    },


   {
   	  "text":"Perfis",
   	  "id":"3",
   	  "leaf":false,
   	  "cls":"folder",
   	  "children": [{
   	  	              "text":"Visualizar",
   	  	              "id":"4",
   	  	              "leaf":true,
   	  	              "cls":"file"
   	                 }]
    },


   {
   	"text":"Produtos",
   	"id":"5",
   	"leaf":false,
   	"cls":"folder",
   	"children": [{
   		               "text":"Visualizar",
   		               "id":"6",
   		               "leaf":true,
   		               "cls":"file"
   	              }]
   },


]


/*****************************************************///////
//DIUNAMICO


[

  {"text":"util","id":"source\/util","cls":"folder"},
  {"text":"yui","id":"source\/yui","cls":"folder"},
  {"text":"data","id":"source\/data","cls":"folder"},
  {"text":"locale","id":"source\/locale","cls":"folder"},
  {"text":"ext.jsb","id":"source\/ext.jsb","leaf":true,"cls":"file"},
  {"text":"debug.js","id":"source\/debug.js","leaf":true,"cls":"file"},
  {"text":"license.txt","id":"source\/license.txt","leaf":true,"cls":"file"},
  {"text":"state","id":"source\/state","cls":"folder"},
  {"text":"dd","id":"source\/dd","cls":"folder"},
  {"text":"widgets","id":"source\/widgets","cls":"folder"},
  {"text":"core","id":"source\/core","cls":"folder"},
  {"text":"adapter","id":"source\/adapter","cls":"folder"}
  
  ]





[
    {
    	 "text":"'Hardware','hardware'",
    	 "id":"ynode-597",
    	 "leaf":false,
    	 "children": [
    	                {
    	                	"text":"'e'",
    	                	"id":"ynode-615",
    	                	"leaf":false,
    	                	"children":[]
    	                },
    	                {
    	                	"text":"rensi",
    	                	"id":"ynode-965",
    	                	"leaf":true,
    	                	"imagem":"no_galho.jpg",
    	                	"icon":"Layout/images/default/tree/user_comment.png"
    	                }
    	                ]
    }]




    [
    
    
    {
    	"text":"Torre",
    	"id":"1",
    	"options":[]
    },
    {
    	"text":"A",
    	"id":"8",
    	"options":[
    				{
    					"text":"B1",
    					"id":"9",
    					"leaf":false,
    					"icon":"../../../lib/imagenes/tuc.png",
    					"tipo":"tuc",
    					"loader":{
    							"baseParams":{},
    							"requestMethod":"POST",
    							"dataUrl":"../../../sis_almacenes/control/tipo_unidad_constructiva/ActionListaTucArb.php",
    							"events":{
    									"beforeload":true,
    									"load":true,
    									"loadexception":true
    							   		},
    							"transId":false
    							},
    					"children":[]
    				},
    				{
    					"text":"B2",
    					"id":"10",
    					"leaf":false,
    					"icon":"../../../lib/imagenes/tuc.png",
    					"tipo":"tuc",
    					"loader":{
    						"baseParams":{},
    						"requestMethod":"POST",
    						"dataUrl":"../../../sis_almacenes/control/tipo_unidad_constructiva/ActionListaTucArb.php",
    						"events":{
    							"beforeload":true,
    							"load":true,
    							"loadexception":true
    							},
    						"transId":false
    					},
    					"children":[]
    				},
    				{
    					"text":"A02B12000",
    					"id":"8",
    					"leaf":true,
    					"icon":"../../../lib/imagenes/item.png",
    					"tipo":"item",
    					"allowDelete":true,
    					"id_item":"1",
    					"loader":{
    						"baseParams":{},
    						"requestMethod":"POST",
    						"dataUrl":"../../../sis_almacenes/control/tipo_unidad_constructiva/ActionListaTucArb.php",
    						"events":{
    							"beforeload":true,
    							"load":true,
    							"loadexception":true
    							},
    						"transId":false
    					},
    					"children":[]
    				}
    				]
    }
    ]
    
    
    /************************************************/
    [
    	{
    		"text":"Torre",
    		"id":"1",
    		"options":[]
    	},
    	{
    		"text":"A",
    		"id":"8",
    		"options":
    				[
    					{
    						"text":"B1",
    						"id":"9",
    						"leaf":false,
    						"icon":"../../../lib/imagenes/tuc.png",
    						"tipo":"tuc",
    						"loader":
    								{
    									"baseParams":{},
    									"requestMethod":"POST",
    									"dataUrl":"../../../sis_almacenes/control/tipo_unidad_constructiva/ActionListaTucArb.php",
    									"events":
    											{
    												"beforeload":true,
    												"load":true,
    												"loadexception":true
    											},
    									"transId":false
    								},
    								"children":[]
    					},
    					{
    						"text":"B2",
    						"id":"10",
    						"leaf":false,
    						"icon":"../../../lib/imagenes/tuc.png",
    						"tipo":"tuc",
    						"loader":
    								{
    									"baseParams":{},
    									"requestMethod":"POST",
    									"dataUrl":"../../../sis_almacenes/control/tipo_unidad_constructiva/ActionListaTucArb.php",
    									"events":{"beforeload":true,"load":true,"loadexception":true},
    									"transId":false
    								},
    						"children":
    									[
    										{
    											"text":"C1",
    											"id":"11",
    											"leaf":false,
    											"icon":"../../../lib/imagenes/tuc.png",
    											"tipo":"tuc",
    											"loader":{"baseParams":{},"requestMethod":"POST","dataUrl":"../../../sis_almacenes/control/tipo_unidad_constructiva/ActionListaTucArb.php","events":{"beforeload":true,"load":true,"loadexception":true},"transId":false}
    										},
    										{
    											"text":"C2",
    											"id":"12",
    											"leaf":false,
    											"icon":"../../../lib/imagenes/tuc.png",
    											"tipo":"tuc",
    											"loader":{"baseParams":{},"requestMethod":"POST","dataUrl":"../../../sis_almacenes/control/tipo_unidad_constructiva/ActionListaTucArb.php","events":{"beforeload":true,"load":true,"loadexception":true},"transId":false}
    										},
    										{
    											"text":"C3",
    											"id":"13",
    											"leaf":false,
    											"icon":"../../../lib/imagenes/tuc.png",
    											"tipo":"tuc",
    											"loader":{"baseParams":{},"requestMethod":"POST","dataUrl":"../../../sis_almacenes/control/tipo_unidad_constructiva/ActionListaTucArb.php","events":{"beforeload":true,"load":true,"loadexception":true},"transId":false}
    										}
    									]
    					},
    					{
    						"text":"A02B12000",
    						"id":"8",
    						"leaf":true,
    						"icon":"../../../lib/imagenes/item.png",
    						"tipo":"item",
    						"allowDelete":true,
    						"id_item":"1",
    						"loader":{"baseParams":{},"requestMethod":"POST","dataUrl":"../../../sis_almacenes/control/tipo_unidad_constructiva

/ActionListaTucArb.php","events":{"beforeload":true,"load":true,"loadexception":true},"transId":false

},"children":[]}]}]
    
    

?>