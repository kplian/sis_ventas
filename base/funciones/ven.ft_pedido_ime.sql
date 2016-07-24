CREATE OR REPLACE FUNCTION ven.ft_pedido_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Ventas
 FUNCION: 		ven.ft_pedido_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ven.tpedido'
 AUTOR: 		 (admin)
 FECHA:	        05-11-2013 06:34:26
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_pedido				integer;
	v_id_periodo			integer;
	v_id_subsistema			integer;
	v_codigo				varchar;
    
    v_codigo_proceso_macro  varchar;
    v_id_proceso_macro 		integer;
    v_codigo_tipo_proceso 	varchar;
    v_gestion 				integer;
    v_id_proceso_wf 		integer;
    v_id_estado_wf 			integer;
    v_codigo_estado 		varchar;
    v_id_gestion			integer;
    v_num_tramite  			varchar;
			    
BEGIN

    v_nombre_funcion = 'ven.ft_pedido_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'VEN_PEDIDO_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 06:34:26
	***********************************/

	if(p_transaccion='VEN_PEDIDO_INS')then
					
        begin
        
        	--Obtención del id_subsistema
        	select id_subsistema
        	into v_id_subsistema
        	from segu.tsubsistema
        	where codigo = 'VEN';
        
        	--Obtención del periodo
        	select po_id_periodo
        	into v_id_periodo
        	from param.f_get_periodo_gestion(v_parametros.fecha,v_id_subsistema);
        	
        	--Obtención código de sucursal
        	select codigo
        	into v_codigo
        	from ven.tsucursal
        	where id_sucursal = v_parametros.id_sucursal;
            
            ---------------
            --Inicio del WF
            ---------------
            --Proceso macro
            v_codigo_proceso_macro = 'VEN-PED';
            select 
            pm.id_proceso_macro
            into
            v_id_proceso_macro
            from wf.tproceso_macro pm
            where pm.codigo = v_codigo_proceso_macro;
        
            if v_id_proceso_macro is NULL THEN
               raise exception 'El proceso macro  de codigo %, no está habilitado en el sistema WF',v_codigo_proceso_macro;  
            end if;
        
        	--Código del tipo_proceso
            select tp.codigo 
            into v_codigo_tipo_proceso
            from wf.ttipo_proceso tp 
            where tp.id_proceso_macro = v_id_proceso_macro
            and tp.estado_reg = 'activo'
            and tp.inicio = 'si';
            
            if v_codigo_tipo_proceso is NULL THEN
               raise exception 'No existe un proceso inicial para el proceso macro indicado %. Revise su configuración.',v_codigo_proceso_macro;
            end if;
            
            --Obtención id_gestion
            v_gestion = (date_part('year', v_parametros.fecha))::integer;
            select ges.id_gestion
            into v_id_gestion
            from param.tgestion ges
            where ges.gestion = v_gestion
            limit 1 offset 0;
       
            --Obtención id_subsistema
            select s.id_subsistema
            into v_id_subsistema
            from segu.tsubsistema s
            where s.codigo = 'VEN';
    
        	--Inicio del trámite del WF
            SELECT 
            ps_num_tramite ,
            ps_id_proceso_wf ,
            ps_id_estado_wf ,
            ps_codigo_estado 
            into
            v_num_tramite,
            v_id_proceso_wf,
            v_id_estado_wf,
            v_codigo_estado   
            FROM wf.f_inicia_tramite(
            p_id_usuario, 
            v_id_gestion, 
            v_codigo_tipo_proceso, 
            NULL,
            NULL);
        	
        	--Sentencia de la insercion
        	insert into ven.tpedido(
			id_sucursal,
			id_cliente,
			id_moneda,
			forma_pago,
			estado,
			fecha,
			tipo_pago,
			monto_pagado,
			precio_total,
			estado_reg,
			destinatario,
			direccion,
			fecha_reg,
			id_usuario_reg,
			id_usuario_mod,
			fecha_mod,
			codigo,
			id_sucursal_dest,
			id_lugar,
			telef_destinatario,
			obs_destinatario,
            id_proceso_macro,
            id_proceso_wf,
            id_estado_wf 
          	) values(
			v_parametros.id_sucursal,
			v_parametros.id_cliente,
			v_parametros.id_moneda,
			v_parametros.forma_pago,
			v_codigo_estado,
			v_parametros.fecha,
			v_parametros.tipo_pago,
			v_parametros.monto_pagado,
			v_parametros.precio_total,
			'activo',
			v_parametros.destinatario,
			v_parametros.direccion,
			now(),
			p_id_usuario,
			null,
			null,
			param.f_obtener_correlativo ('VPED', v_id_periodo, NULL, NULL, p_id_usuario, 'VEN', null,2,3,'ven.tsucursal',v_parametros.id_sucursal,v_codigo),
			v_parametros.id_sucursal_dest,
			v_parametros.id_lugar,
			v_parametros.telef_destinatario,
			v_parametros.obs_destinatario,
            v_id_proceso_macro,
            v_id_proceso_wf,
            v_id_estado_wf
			)RETURNING id_pedido into v_id_pedido;
			
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Pedido almacenado(a) con exito (id_pedido'||v_id_pedido||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pedido',v_id_pedido::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'VEN_PEDIDO_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 06:34:26
	***********************************/

	elsif(p_transaccion='VEN_PEDIDO_MOD')then

		begin
			--Sentencia de la modificacion
			update ven.tpedido set
			id_sucursal = v_parametros.id_sucursal,
			id_cliente = v_parametros.id_cliente,
			id_moneda = v_parametros.id_moneda,
			forma_pago = v_parametros.forma_pago,
			fecha = v_parametros.fecha,
			tipo_pago = v_parametros.tipo_pago,
			monto_pagado = v_parametros.monto_pagado,
			precio_total = v_parametros.precio_total,
			destinatario = v_parametros.destinatario,
			direccion = v_parametros.direccion,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_sucursal_dest=v_parametros.id_sucursal_dest,
			id_lugar=v_parametros.id_lugar,
			telef_destinatario=v_parametros.telef_destinatario,
			obs_destinatario=v_parametros.obs_destinatario
			where id_pedido=v_parametros.id_pedido;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Pedido modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pedido',v_parametros.id_pedido::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'VEN_PEDIDO_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 06:34:26
	***********************************/

	elsif(p_transaccion='VEN_PEDIDO_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ven.tpedido
            where id_pedido=v_parametros.id_pedido;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Pedido eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pedido',v_parametros.id_pedido::varchar);
              
            --Devuelve la respuesta
            return v_resp;

		end;
        
    /*********************************    
 	#TRANSACCION:  'VEN_PEDIDO_WF'
 	#DESCRIPCION:	Workflow de Pedido
 	#AUTOR:			RCM
 	#FECHA:			19/11/2013
	***********************************/

	elsif(p_transaccion='VEN_PEDIDO_WF')then

		begin
        	--Funcion para gestion del workflow del pedido
			v_resp = ven.f_pedido_workflow(p_id_usuario,hstore(v_parametros));
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Pedido '); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pedido',v_parametros.id_pedido::varchar);
              
            --Devuelve la respuesta
            return v_resp;

		end;
         
	else
     
    	raise exception 'Transaccion inexistente: %',p_transaccion;

	end if;

EXCEPTION
				
	WHEN OTHERS THEN
		v_resp='';
		v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
		v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
		v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
		raise exception '%',v_resp;
				        
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;