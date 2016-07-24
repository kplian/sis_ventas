/***********************************I-DEP-RCM-VEN-0-05/11/2013*****************************************/
ALTER TABLE ONLY ven.tcliente
    ADD CONSTRAINT fk_tcliente__id_persona
    FOREIGN KEY (id_persona) REFERENCES segu.tpersona(id_persona);
    
ALTER TABLE ONLY ven.tcliente
    ADD CONSTRAINT fk_tcliente__id_institucion
    FOREIGN KEY (id_institucion) REFERENCES param.tinstitucion(id_institucion);
    
ALTER TABLE ONLY ven.tpedido
    ADD CONSTRAINT fk_tpedido__id_sucursal
    FOREIGN KEY (id_sucursal) REFERENCES ven.tsucursal(id_sucursal);
    
ALTER TABLE ONLY ven.tpedido
    ADD CONSTRAINT fk_tpedido__id_cliente
    FOREIGN KEY (id_cliente) REFERENCES ven.tcliente(id_cliente);
    
ALTER TABLE ONLY ven.tpedido
    ADD CONSTRAINT fk_tpedido__id_moneda
    FOREIGN KEY (id_moneda) REFERENCES param.tmoneda(id_moneda);

ALTER TABLE ONLY ven.tpedido_det
    ADD CONSTRAINT fk_tpedido_det__id_pedido
    FOREIGN KEY (id_pedido) REFERENCES ven.tpedido(id_pedido);
    
ALTER TABLE ONLY ven.tpedido_det
    ADD CONSTRAINT fk_tpedido_det__id_item
    FOREIGN KEY (id_item) REFERENCES alm.titem(id_item);
    
ALTER TABLE ONLY ven.tpedido_det
    ADD CONSTRAINT fk_tpedido_det__id_proveedor
    FOREIGN KEY (id_proveedor) REFERENCES param.tproveedor(id_proveedor);
    
ALTER TABLE ONLY ven.tpedido_det
    ADD CONSTRAINT fk_tpedido_det__id_envio
    FOREIGN KEY (id_envio) REFERENCES ven.tenvio(id_envio);
    
ALTER TABLE ONLY ven.tventa
    ADD CONSTRAINT fk_tventa__id_cliente
    FOREIGN KEY (id_cliente) REFERENCES ven.tcliente(id_cliente);
    
ALTER TABLE ONLY ven.tventa
    ADD CONSTRAINT fk_tventa__id_moneda
    FOREIGN KEY (id_moneda) REFERENCES param.tmoneda(id_moneda);

CREATE VIEW ven.vcliente
AS
  SELECT client.id_cliente,
         client.id_persona,
         client.codigo_hash,
         client.nit_factura,
         client.estado,
         client.estado_reg,
         client.id_institucion,
         client.codigo,
         client.fecha_reg,
         client.id_usuario_reg,
         client.id_usuario_mod,
         client.fecha_mod,
         usu1.cuenta AS usr_reg,
         usu2.cuenta AS usr_mod,
         per.nombre_completo1,
         inst.nombre,
         CASE COALESCE(client.id_persona, 0)
           WHEN 0 THEN inst.nombre
           ELSE per.nombre_completo1::character varying
         END AS nombre_cliente,
         CASE COALESCE(client.id_persona, 0)
           WHEN 0 THEN 'institucion' ::character varying
           ELSE 'persona' ::character varying
         END AS persona_inst,
         CASE COALESCE(client.id_persona, 0)
           WHEN 0 THEN inst.doc_id
           ELSE per.ci
         END AS doc_id,
         CASE COALESCE(client.id_persona, 0)
           WHEN 0 THEN inst.email1
           ELSE per.correo
         END AS email,
         CASE COALESCE(client.id_persona, 0)
           WHEN 0 THEN inst.telefono1
           ELSE per.telefono1
         END AS telefono1,
         CASE COALESCE(client.id_persona, 0)
           WHEN 0 THEN inst.telefono2
           ELSE per.telefono2
         END AS telefono2,
         CASE COALESCE(client.id_persona, 0)
           WHEN 0 THEN inst.celular1
           ELSE per.celular1
         END AS celular1,
         CASE COALESCE(client.id_persona, 0)
           WHEN 0 THEN inst.celular2
           ELSE per.celular2
         END AS celular2
  FROM ven.tcliente client
       JOIN segu.tusuario usu1 ON usu1.id_usuario = client.id_usuario_reg
       LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = client.id_usuario_mod
       LEFT JOIN segu.vpersona per ON per.id_persona = client.id_persona
       LEFT JOIN param.tinstitucion inst ON inst.id_institucion =
        client.id_institucion;
        
        
CREATE VIEW ven.vpedido
AS 
select
pedido.id_pedido,
pedido.id_sucursal,
pedido.id_cliente,
pedido.id_moneda,
pedido.forma_pago,
pedido.estado,
pedido.fecha,
pedido.codigo,
pedido.tipo_pago,
pedido.monto_pagado,
pedido.precio_total,
pedido.estado_reg,
pedido.destinatario,
pedido.direccion,
pedido.fecha_reg,
pedido.id_usuario_reg,
pedido.id_usuario_mod,
pedido.fecha_mod,
usu1.cuenta as usr_reg,
usu2.cuenta as usr_mod,
suc.descripcion as desc_sucursal,
cli.nombre_cliente as desc_cliente,
mon.codigo as desc_moneda,
pedido.id_sucursal_dest,
pedido.id_lugar,
pedido.telef_destinatario,
pedido.obs_destinatario,
suc1.descripcion as desc_sucursal_dest,
param.f_get_nombre_lugar_rec(pedido.id_lugar,'padres') as desc_lugar
from ven.tpedido pedido
inner join segu.tusuario usu1 on usu1.id_usuario = pedido.id_usuario_reg
left join segu.tusuario usu2 on usu2.id_usuario = pedido.id_usuario_mod
inner join ven.vcliente cli on cli.id_cliente = pedido.id_cliente
inner join ven.tsucursal suc on suc.id_sucursal = pedido.id_sucursal
inner join param.tmoneda mon on mon.id_moneda = pedido.id_moneda
inner join ven.tsucursal suc1 on suc1.id_sucursal = pedido.id_sucursal_dest;
/***********************************F-DEP-RCM-VEN-0-05/11/2013*****************************************/