<?php
/**
*@package pXP
*@file PeidoDetEnv.php
*@author  rcm
*@date 22/11/2013
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.PedidoDetEnv = {
	require:'../../../sis_ventas/vista/pedido_det/PedidoDetAbs.php',
	requireclase:'Phx.vista.PedidoDetAbs',
	title:'Detalle Envio',
	nombreVista: 'pedidoDetEnv',
	
	AtributosExtra: [
		{
			config : {
				name : 'id_pedido_det',
				fieldLabel : 'Producto Solicitado',
				allowBlank : false,
				emptyText : 'Elija un Producto...',
				store : new Ext.data.JsonStore({
					url : '../../sis_ventas/control/PedidoDet/listarProducto',
					id : 'id_pedido_det',
					root : 'datos',
					sortInfo : {
						field : 'desc_item',
						direction : 'ASC'
					},
					totalProperty : 'total',
					fields : ['id_pedido_det', 'desc_item', 'descripcion', 'nro_serie', 'marca','procedencia','peiddo_codigo','desc_cliente','fecha','desc_sucursal'],
					remoteSort : true,
					baseParams : {
						par_filtro : 'item.nombre#item.codigo#prov.descripcion#prov.nro_serie#prov.marca#prov.procedencia#ped.codigo#ped.desc_cliente#ped.desc_sucursal'
					}
				}),
				valueField : 'id_pedido_det',
				displayField : 'desc_item',
				gdisplayField : 'desc_item',
				tpl : '<tpl for="."><div class="x-combo-list-item"><p>Producto: {desc_item}</p><p>Nro.Serie: {nro_serie}</p><p>Marca: {marca}</p><p>Procedencia: {procedencia}</p><p>Pedido: {codigo}</p><p>Cliente: {desc_cliente}</p><p>Sucursal: {desc_sucursal}</p></div></tpl>',
				hiddenName : 'id_pedido_det',
				forceSelection : false,
				typeAhead : false,
				triggerAction : 'all',
				lazyRender : true,
				mode : 'remote',
				pageSize : 10,
				queryDelay : 1000,
				anchor : '100%',
				gwidth : 250,
				minChars : 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['desc_item']);
				},
				resizable: true
			},
			type : 'ComboBox',
			id_grupo : 0,
			filters : {
				pfiltro : 'item.nombre#item.codigo',
				type : 'string'
			},
			grid: true,
			form: true
		}
	],
	
	constructor: function(config) {
		this.maestro=config.maestro;
		Phx.vista.PedidoDetEnv.superclass.constructor.call(this,config);
		this.grid.getTopToolbar().disable();
		this.grid.getBottomToolbar().disable();
		this.init();
	},
	loadValoresIniciales:function(){
		Phx.vista.PedidoDetEnv.superclass.loadValoresIniciales.call(this);
		this.getComponente('id_envio').setValue(this.maestro.id_envio);		
	},
	onReloadPage:function(m){
		this.maestro=m;						
		this.store.baseParams={id_envio:this.maestro.id_envio};
		this.load({params:{start:0, limit:this.tam_pag}});
	
	},
	ActSave:'../../sis_ventas/control/PedidoDet/insertarEnvioDet',
	ActDel:'../../sis_ventas/control/PedidoDet/eliminarEnvioDet',
	
	deshabilitarComponentes: function(){
		this.desHabCmp(this.Cmp.id_item);
		this.desHabCmp(this.Cmp.id_proveedor);
		this.desHabCmp(this.Cmp.codigo);
		this.desHabCmp(this.Cmp.cantidad_sol);
		this.desHabCmp(this.Cmp.descripcion);
		this.desHabCmp(this.Cmp.observaciones);
		this.desHabCmp(this.Cmp.precio_unit);
		this.desHabCmp(this.Cmp.nro_serie);
		this.desHabCmp(this.Cmp.marca);
		this.desHabCmp(this.Cmp.procedencia);
		this.desHabCmp(this.Cmp.peso);
		this.desHabCmp(this.Cmp.altura);
		this.desHabCmp(this.Cmp.ancho);
		this.desHabCmp(this.Cmp.largo);
		this.desHabCmp(this.Cmp.precio_total);
		this.desHabCmp(this.Cmp.id_unidad_medida_peso);
		this.desHabCmp(this.Cmp.id_unidad_medida_long);
	},
	desHabCmp: function(cmp){
		cmp.hide();
		this.setAllowBlank(cmp,true);
	},
	onButtonNew: function(){
		Phx.vista.PedidoDetEnv.superclass.onButtonNew.call(this);
		//Deshabilita componentes
		this.deshabilitarComponentes();
		//Oculta el grupo del detalle de producto
		this.adminGrupo({ocultar:[1]})
	},
	bedit: false,
	bsave: false
	
};
</script>
