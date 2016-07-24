/***********************************I-SCP-RCM-ALM-1-04/11/2013****************************************/
CREATE TABLE ven.tcliente (
	id_cliente  SERIAL NOT NULL, 
	id_persona int4, 
	id_institucion int4, 
	codigo varchar(20), 
	nit_factura varchar(20), 
	estado varchar(15), 
	codigo_hash varchar(100), 
	CONSTRAINT pk_tcliente__id_cliente PRIMARY KEY (id_cliente)
) INHERITS (pxp.tbase) WITHOUT OIDS;

CREATE TABLE ven.tsucursal (
	id_sucursal  SERIAL NOT NULL,
	codigo varchar(15), 
	descripcion varchar(500), 
	CONSTRAINT pk_tsucursal__id_sucursal PRIMARY KEY (id_sucursal)
) INHERITS (pxp.tbase) WITHOUT OIDS;

CREATE TABLE ven.tpedido (
	id_pedido  SERIAL NOT NULL, 
	id_sucursal int4 NOT NULL, 
	id_cliente int4 NOT NULL, 
	id_moneda int4 NOT NULL, 
	id_sucursal_dest int4 NOT NULL,
	id_lugar int4 NOT NULL,
	codigo varchar(20), 
	estado varchar(20), 
	fecha date, 
	destinatario varchar(100), 
	telef_destinatario varchar(50), 
	obs_destinatario varchar(1000), 
	direccion varchar(1000), 
	forma_pago varchar(20), 
	tipo_pago varchar(20), 
	precio_total numeric(18, 2), 
	monto_pagado numeric(18, 2), 
	id_proceso_macro INTEGER, 
	id_estado_wf INTEGER, 
	id_proceso_wf INTEGER,
	CONSTRAINT pk_tpedido__id_pedido PRIMARY KEY (id_pedido)
) INHERITS (pxp.tbase) WITHOUT OIDS;

CREATE TABLE ven.tpedido_det (
	id_pedido_det  SERIAL NOT NULL, 
	id_pedido int4 NOT NULL, 
	id_item int4 NOT NULL, 
	id_producto int4 NOT NULL, 
	id_proveedor int4, 
	id_envio int4, 
	codigo varchar(100),
	observaciones text, 
	cantidad_sol numeric(18, 2), 
	estado varchar(20), 
	id_proceso_macro INTEGER, 
	id_estado_wf INTEGER, 
	id_proceso_wf INTEGER,
	CONSTRAINT pk_tpedido_det__id_pedido_det PRIMARY KEY (id_pedido_det),
	CONSTRAINT uq_tpedido_det__codigo UNIQUE (codigo)
) INHERITS (pxp.tbase) WITHOUT OIDS;

CREATE TABLE ven.tenvio (
	id_envio  SERIAL NOT NULL,
	id_proveedor INTEGER,
	id_sucursal INTEGER,
	id_persona_rmte INTEGER,
	id_persona_dest INTEGER,
	fecha date,
	codigo varchar(20), 
	descripcion varchar(1000), 
	medio VARCHAR(15),
	observaciones varchar(2000),
	CONSTRAINT pk_tenvio__id_envio PRIMARY KEY (id_envio)
) INHERITS (pxp.tbase) WITHOUT OIDS;


CREATE TABLE ven.tventa (
	id_venta  SERIAL NOT NULL, 
	id_cliente int4 NOT NULL, 
	id_moneda int4 NOT NULL, 
	id_factura int4 NOT NULL, 
	fecha date, 
	nit_factura int4, 
	estado varchar(20), 
	fac_nro varchar(30), 
	fac_nit varchar(30), 
	fac_nro_autoriz varchar(30), 
	CONSTRAINT pk_tventa__id_venta PRIMARY KEY (id_venta)
) INHERITS (pxp.tbase) WITHOUT OIDS;

CREATE TABLE ven.tventa_det (
	id_venta_det  SERIAL NOT NULL, 
	id_venta int4 NOT NULL, 
	id_pedido_det int4 NOT NULL, 
	id_producto int4 NOT NULL, 
	precio_unit numeric(18, 2), 
	cantidad numeric(18, 2), 
	CONSTRAINT pk_tventa_det__id_venta_det PRIMARY KEY (id_venta_det)
) INHERITS (pxp.tbase) WITHOUT OIDS;

CREATE TABLE ven.tproducto (
	id_producto SERIAL NOT NULL, 
	id_item int4 NOT NULL,
	id_unidad_medida_peso integer,
	id_unidad_medida_long integer, 
	codigo varchar(50), 
	precio_unit numeric(18, 2), 
	descripcion text,
	nro_serie varchar(50),
	marca varchar(150),
	procedencia varchar(200),
	peso numeric(18,2),
	altura numeric(18,2),
	ancho numeric(18,2),
	largo numeric(18,2),
	CONSTRAINT pk_tproducto__id_producto PRIMARY KEY (id_producto)
) INHERITS (pxp.tbase) WITHOUT OIDS;

/***********************************F-SCP-RCM-ALM-1-04/11/2013****************************************/