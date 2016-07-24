Ext.namespace('Phx','Phx.comborec.sis_ventas');		

Phx.comborec.sis_ventas.configini = function (config){
	
	if (config.origen == 'SUCURSAL') {
		return {
			 origen: 'SUCURSAL',
			 tinit:false,
			 tasignacion:true,
			 resizable:true,
			 tname:'id_sucursal',
			 tdisplayField:'descripcion',
			 pid:this.idContenedor,
			 name:'id_sucursal',
 				fieldLabel:'Sucursal',
 				allowBlank:true,
 				emptyText:'Sucursal...',
 				store : new Ext.data.JsonStore({
					url : '../../sis_ventas/control/Sucursal/listarSucursal',
					id : 'id_sucursal',
					root : 'datos',
					sortInfo : {
						field : 'descripcion',
						direction : 'ASC'
					},
					totalProperty : 'total',
					fields : ['id_sucursal', 'codigo', 'descripcion'],
					remoteSort : true,
					baseParams : {
						par_filtro : 'venrsuc.descripcion#venrsuc.codigo'
					}
				}),
				valueField: 'id_sucursal',
 				displayField: 'descripcion',
 				hiddenName: 'id_sucursal',
				tpl:'<tpl for="."><div class="x-combo-list-item"><p>{codigo}</p><p>Nombre:{descripcion}</p> </div></tpl>',
				forceSelection:true,
 				typeAhead: false,
                triggerAction: 'all',
                lazyRender:true,
 				mode:'remote',
 				pageSize:10,
 				queryDelay:1000,
 				width:250,
				listWidth:'280',
				minChars:2
		}
		
	} else if(config.origen == 'CLIENTE') {
		return {
			 origen: 'SUCUCLIENTERSAL',
			 tinit:false,
			 tasignacion:true,
			 resizable:true,
			 tname:'id_cliente',
			 tdisplayField:'nombre_cliente',
			 pid:this.idContenedor,
			 name:'id_cliente',
 				fieldLabel:'CLiente',
 				allowBlank:true,
 				emptyText:'Cliente...',
 				store : new Ext.data.JsonStore({
					url : '../../sis_ventas/control/Cliente/listarCliente',
					id : 'id_id_Cliente',
					root : 'datos',
					sortInfo : {
						field : 'nombre_cliente',
						direction : 'ASC'
					},
					totalProperty : 'total',
					fields : ['id_cliente', 'codigo', 'nombre_cliente'],
					remoteSort : true,
					baseParams: Ext.apply({par_filtro:'client.nombre_cliente#client.codigo'},config.baseParams)
				}),
				valueField: 'id_cliente',
 				displayField: 'nombre_cliente',
 				gdisplayField : 'desc_cliente',
 				hiddenName: 'id_cliente',
				tpl : '<tpl for="."><div class="x-combo-list-item"><p>Código: {codigo}</p><p>Cliente: {nombre_cliente}</p></div></tpl>',
				forceSelection:true,
 				typeAhead: false,
                triggerAction: 'all',
                lazyRender:true,
 				mode:'remote',
 				pageSize:10,
 				queryDelay:1000,
 				width:250,
				listWidth:'280',
				minChars:2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['desc_cliente']);
				}
		}
		
	}

}
	    		

	    