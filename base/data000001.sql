/***********************************I-DAT-RCM-ALM-0-15/01/2013*****************************************/
INSERT INTO segu.tsubsistema ("codigo", "nombre", "fecha_reg", "prefijo", "estado_reg", "nombre_carpeta", "id_subsis_orig")
VALUES (E'VEN', E'Sistema de Ventas', now(), E'VEN', E'activo', E'VENTAS', NULL);
  
select pxp.f_insert_tgui ('SISTEMA DE VENTAS', '', 'VEN', 'si',1 , '', 1, '../../../lib/imagenes/alma32x32.png', '', 'VEN');
select pxp.f_insert_tgui ('Catálogos', 'Catálogos', 'VENCAT', 'si', 1, '', 2, '', '', 'VEN');
select pxp.f_insert_tgui ('Pedidos', 'Pedidos', 'VENPED', 'si', 2, '', 2, '', '', 'VEN');
select pxp.f_insert_tgui ('Envíos', 'Envíos', 'VENENV', 'si', 3, '', 2, '', '', 'VEN');
select pxp.f_insert_tgui ('Ventas', 'Ventas', 'VENVEN', 'si', 4, '', 2, '', '', 'VEN');

select pxp.f_insert_tgui ('Sucursales', 'Sucursales', 'VENSUC', 'si', 1, 'sis_ventas/vista/sucursal/Sucursal.php', 3, '', 'Sucursal', 'VEN');
select pxp.f_insert_tgui ('Clientes', 'Clientes', 'VENCLI', 'si', 1, 'sis_ventas/vista/cliente/Cliente.php', 3, '', 'Cliente', 'VEN');
select pxp.f_insert_tgui ('Pedidos', 'Pedidos', 'VENPEDR', 'si', 1, 'sis_ventas/vista/pedido/PedidoReq.php', 3, '', 'PedidoReq', 'VEN');
select pxp.f_insert_tgui ('Identificación de Productos', 'Identificación de Productos', 'VENPRODI', 'si', 1, 'sis_ventas/vista/pedido_det/PedidoDetIdent.php', 3, '', 'PedidoDetIdent', 'VEN');
select pxp.f_insert_tgui ('Envíos No Recibidos', 'Envíos no Recibidos', 'VENENVNOREC', 'si', 1, 'sis_ventas/vista/envio/EnvioNoRec.php', 3, '', 'EnvioNoRec', 'VEN');
select pxp.f_insert_tgui ('Envíos Recibidos', 'Envíos Recibidos', 'VENENVREC', 'si', 1, 'sis_ventas/vista/envio/EnvioRec.php', 3, '', 'EnvioRec', 'VEN');
select pxp.f_insert_tgui ('Todos los Envíos', 'Todos los Envíos', 'VENENVR', 'si', 1, 'sis_ventas/vista/envio/Envio.php', 3, '', 'Envio', 'VEN');
select pxp.f_insert_tgui ('Ventas', 'Ventas', 'VENVENR', 'si', 1, 'sis_ventas/vista/venta/Venta.php', 3, '', 'Venta', 'VEN');

select pxp.f_insert_testructura_gui ('VEN', 'SISTEMA');
select pxp.f_insert_testructura_gui ('VENCAT', 'VEN');
select pxp.f_insert_testructura_gui ('VENPED', 'VEN');
select pxp.f_insert_testructura_gui ('VENENV', 'VEN');
select pxp.f_insert_testructura_gui ('VENVEN', 'VEN');
select pxp.f_insert_testructura_gui ('VENSUC', 'VENCAT');
select pxp.f_insert_testructura_gui ('VENCLI', 'VENCAT');
select pxp.f_insert_testructura_gui ('VENPEDR', 'VENPED');
select pxp.f_insert_testructura_gui ('VENPRODI', 'VENPED');
select pxp.f_insert_testructura_gui ('VENENVNOREC', 'VENENV');
select pxp.f_insert_testructura_gui ('VENENVREC', 'VENENV');
select pxp.f_insert_testructura_gui ('VENENVR', 'VENENV');
select pxp.f_insert_testructura_gui ('VENVENR', 'VENVEN');

select pxp.f_add_catalog('VEN','tpedido__forma_pago','efectivo');
select pxp.f_add_catalog('VEN','tpedido__forma_pago','tarjeta_credito');
select pxp.f_add_catalog('VEN','tpedido__tipo_pago','adelanto');
select pxp.f_add_catalog('VEN','tpedido__tipo_pago','inicio');
select pxp.f_add_catalog('VEN','tpedido__tipo_pago','entrega');

/***********************************F-DAT-RCM-ALM-0-17/10/2013****************************************/

/***********************************I-DAT-RCM-ALM-0-13/11/2013****************************************/
select param.f_registrar_documento( 'VEN','VPED','Formulario de Pedido para Ventas','periodo','tabla','codtabla-correlativo-periodo/gestion')
select pxp.f_insert_tgui ('Aprobacion Pedidos', 'Aprobacion de Pedidos', 'VENPEDAP', 'si', 1, 'sis_ventas/vista/pedido/PedidoVb.php', 3, '', 'PedidoVb', 'VEN');
select pxp.f_insert_testructura_gui ('VENPEDAP', 'VENPED');

select pxp.f_add_catalog('VEN','tenvio__medio','aereo');
select pxp.f_add_catalog('VEN','tenvio__medio','maritimo');
/***********************************F-DAT-RCM-ALM-0-13/11/2013****************************************/