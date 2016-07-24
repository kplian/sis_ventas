<?php
/**
*@package pXP
*@file gen-Cliente.php
*@author  RCM
*@date 05-11-2013 00:29:31
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Cliente=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Cliente.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
		
		//Eventos
		this.iniciarEventos();
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_cliente'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				name: 'persona_inst',
				fieldLabel: 'Persona/Instit.',
				anchor: '100%',
				gwidth: 100,
				maxLength:10,
				items: [
	                {boxLabel: 'Persona', name: 'rg-auto', inputValue: 'persona', checked:true},
	                {boxLabel: 'Institución', name: 'rg-auto', inputValue: 'institucion'} //, checked: true}
            	]/*,
            	listeners:[{
            		change: function(newVal,oldVal){
            			alert('awesome');
            		}
            	}
            	]*/
			},
			type:'RadioGroup',
			//filters:{pfiltro:'serv.nombre',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'codigo',
				fieldLabel: 'Código',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20,
				disabled:true
			},
			type:'TextField',
			filters:{pfiltro:'client.codigo',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
	   		config:{
	       		    name:'id_persona',
	   				origen:'PERSONA',
	   				tinit:true,
	   				fieldLabel: 'Persona',
	   			    gwidth: 120,
	   			    anchor: '100%',
		   			renderer: function (value, p, record){return String.format('{0}', record.data['desc_persona']);}
			},
   			type:'ComboRec',
   			id_grupo:0,
   			filters:{	
		        pfiltro:'per.nombre_completo1',
				type:'string'
			},
   			grid:false,
   			form:true
	   	},
	   	{
	   		config:{
	       		    name:'id_institucion',
	   				origen:'INSTITUCION',
	   				tinit:true,
	   				fieldLabel: 'Institución',
	   			    gwidth: 120,
	   			    anchor: '100%',
		   			renderer: function (value, p, record){return String.format('{0}', record.data['desc_institucion']);},
		   			disabled:true
       	     },
   			type:'ComboRec',
   			id_grupo:0,
   			filters:{	
		        pfiltro:'inst.nombre',
				type:'string'
			},
   			grid:false,
   			form:true
	   	},
	   	{
			config:{
				name: 'nombre_cliente',
				fieldLabel: 'Nombre/Razón Social',
				allowBlank: true,
				anchor: '100%',
				gwidth: 200,
				maxLength:200
			},
			type:'TextField',
			filters:{pfiltro:'client.nombre_cliente',type:'string'},
			id_grupo:1,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'codigo_hash',
				fieldLabel: 'Código Hash',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:100,
				disabled:true
			},
			type:'TextField',
			filters:{pfiltro:'client.codigo_hash',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'doc_id',
				fieldLabel: 'CI/NIT',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
			type:'NumberField',
			filters:{pfiltro:'client.doc_id',type:'string'},
			id_grupo:1,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'nit_factura',
				fieldLabel: 'NIT factura',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
			type:'NumberField',
			filters:{pfiltro:'client.nit_factura',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'email',
				fieldLabel: 'Email',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
			type:'NumberField',
			filters:{pfiltro:'client.email',type:'string'},
			id_grupo:1,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'telefono1',
				fieldLabel: 'Teléfono 1',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
			type:'NumberField',
			filters:{pfiltro:'client.telefono1',type:'string'},
			id_grupo:1,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'telefono2',
				fieldLabel: 'Teléfono 2',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
			type:'NumberField',
			filters:{pfiltro:'client.telefono2',type:'string'},
			id_grupo:1,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'celular1',
				fieldLabel: 'Celular 1',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
			type:'NumberField',
			filters:{pfiltro:'client.celular1',type:'string'},
			id_grupo:1,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'celular2',
				fieldLabel: 'Celular 2',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
			type:'NumberField',
			filters:{pfiltro:'client.celular2',type:'string'},
			id_grupo:1,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'estado',
				fieldLabel: 'Estado',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:15
			},
			type:'TextField',
			filters:{pfiltro:'client.estado',type:'string'},
			id_grupo:1,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'estado_reg',
				fieldLabel: 'Estado Reg.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
			type:'TextField',
			filters:{pfiltro:'client.estado_reg',type:'string'},
			id_grupo:1,
			grid:true,
			form:false
		},
		
		{
			config:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
			type:'DateField',
			filters:{pfiltro:'client.fecha_reg',type:'date'},
			id_grupo:1,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'usr_reg',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
			type:'NumberField',
			filters:{pfiltro:'usu1.usr_reg',type:'string'},
			id_grupo:1,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'usr_mod',
				fieldLabel: 'Modificado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
			type:'NumberField',
			filters:{pfiltro:'usu2.usr_mod',type:'string'},
			id_grupo:1,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
			type:'DateField',
			filters:{pfiltro:'client.fecha_mod',type:'date'},
			id_grupo:1,
			grid:true,
			form:false
		}
	],
	tam_pag:50,	
	title:'Cliente',
	ActSave:'../../sis_ventas/control/Cliente/insertarCliente',
	ActDel:'../../sis_ventas/control/Cliente/eliminarCliente',
	ActList:'../../sis_ventas/control/Cliente/listarCliente',
	id_store:'id_cliente',
	fields: [
		{name:'id_cliente', type: 'numeric'},
		{name:'id_persona', type: 'numeric'},
		{name:'id_persona', type: 'numeric'},
		{name:'codigo_hash', type: 'string'},
		{name:'nit_factura', type: 'string'},
		{name:'estado', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'id_institucion', type: 'numeric'},
		{name:'codigo', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'desc_persona', type: 'string'},
		{name:'desc_institucion', type: 'string'},
		{name:'persona_inst', type: 'string'},
		{name:'doc_id', type: 'string'},
		{name:'email', type: 'string'},
		{name:'telefono1', type: 'string'},
		{name:'telefono2', type: 'string'},
		{name:'celular1', type: 'string'},
		{name:'celular2', type: 'string'},
		{name:'nombre_cliente', type: 'string'}
		
	],
	sortInfo:{
		field: 'id_cliente',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	iniciarEventos: function(){
		//Radiobutton para elegir persona o institucion
		this.Cmp.persona_inst.on('change',function(groupRadio,radio){
			this.enableDisable(radio.inputValue);
		},this);
		
		//Persona: cargar carnet de persona
		this.Cmp.id_persona.on('blur',function(){
			if(this.Cmp.id_persona.getValue()){
	            Ext.Ajax.request({
	                    url:'../../sis_seguridad/control/Persona/listarPersona',
	                    params:{
	                    	id_persona:this.Cmp.id_persona.getValue(),
	                    	start:0,limit:1,sort:'id_persona',dir:'ASC'
	                    },
	                    success: function(resp){
	                    	var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
				            this.Cmp.nit_factura.setValue(reg.datos[0].ci);
	                    },
	                    failure: this.conexionFailure,
                    	timeout:this.timeout,
	                    scope:this
	             });
			}
		},this);
		
		//Institución: cargar nit de institución
		this.Cmp.id_institucion.on('blur',function(){
			if(this.Cmp.id_institucion.getValue()){
	            Ext.Ajax.request({
	                    url:'../../sis_parametros/control/Institucion/listarInstitucion',
	                    params:{
	                    	id_institucion:this.Cmp.id_institucion.getValue(),
	                    	start:0,limit:1,sort:'id_institucion',dir:'ASC'
	                    	},
	                    success: function(resp){
	                    	var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
				            this.Cmp.nit_factura.setValue(reg.datos[0].nit);
	                    },
	                    failure: this.conexionFailure,
                    	timeout:this.timeout,
	                    scope:this
	             });
			}
		},this);
	},
	enableDisable: function(val){
		console.log(val)
		if(val=='persona'){
			this.Cmp.id_persona.enable();
			this.Cmp.id_institucion.disable();
			//this.Cmp.id_institucion.setValue('');
		} else{
			this.Cmp.id_institucion.enable();
			this.Cmp.id_persona.disable();
			//this.Cmp.id_persona.setValue('');
		}
		
	},
	onButtonEdit:function(){
		var datos=this.sm.getSelected().data;
		/*var aux;
		if(datos.id_persona){
			aux='persona';
			this.Cmp.persona_inst.items[0].checked=true;
			this.Cmp.persona_inst.items[1].checked=false;
		} else{
			aux='institucion';
			this.Cmp.persona_inst.items[1].checked=true;
			this.Cmp.persona_inst.items[0].checked=false;
		}*/
		//this.Cmp.persona_inst.setValue(aux)
		Phx.vista.Cliente.superclass.onButtonEdit.call(this); 

		//Set the visible value of field radio button
		this.enableDisable(datos.persona_inst);
	}
	
	
})
</script>
		
		