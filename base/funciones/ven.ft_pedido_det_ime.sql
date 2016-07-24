CREATE OR REPLACE FUNCTION ven.ft_pedido_det_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Ventas
 FUNCION: 		ven.ft_pedido_det_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ven.tpedido_det'
 AUTOR: 		 (admin)
 FECHA:	        05-11-2013 06:34:29
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
	v_id_pedido_det			integer;
	v_id_producto			integer;
    v_id_subsistema			integer;
    v_codigo_proceso_macro	varchar;
    v_id_proceso_macro		integer;
    v_codigo_tipo_proceso	varchar;
    v_gestion				integer;
    v_id_gestion			integer;
    v_num_tramite			integer;
    v_id_proceso_wf			integer;
    v_id_estado_wf			integer;
    v_codigo_estado			varchar;
    v_fecha					date;
			    
BEGIN

    v_nombre_funcion = 'ven.ft_pedido_det_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'VEN_DETPED_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 06:34:29
	***********************************/

	if(p_transaccion='VEN_DETPED_INS')then
					
        begin

        	--Registro del Producto
        	v_id_producto = ven.f_registro_producto(p_id_usuario,hstore(v_parametros),p_transaccion);
            
            --WF
            --Obtención del id_subsistema
        	select id_subsistema
        	into v_id_subsistema
        	from segu.tsubsistema
        	where codigo = 'VEN';
            
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
            and tp.codigo = 'PRODU';
            
            if v_codigo_tipo_proceso is NULL THEN
               raise exception 'No existe el proceso para el proceso macro indicado %. Revise su configuración.',v_codigo_proceso_macro;
            end if;
            
            --Obtiene la fecha del pedido
            select fecha
            into v_fecha
            from ven.tpedido
            where id_pedido = v_parametros.id_pedido;
            
            --Obtención id_gestion
            v_gestion = (date_part('year', v_fecha))::integer;
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
        	insert into ven.tpedido_det(
			id_pedido,
			id_item,
			id_proveedor,
			estado,
			estado_reg,
			cantidad_sol,
			id_producto,
			id_usuario_reg,
			fecha_reg,
			id_usuario_mod,
			fecha_mod,
			observaciones,
            id_proceso_macro,
            id_proceso_wf,
            id_estado_wf 
          	) values(
			v_parametros.id_pedido,
			v_parametros.id_item,
			v_parametros.id_proveedor,
			v_codigo_estado,
			'activo',
			v_parametros.cantidad_sol,
			v_id_producto,
			p_id_usuario,
			now(),
			null,
			null,
			v_parametros.observaciones,
            v_id_proceso_macro,
            v_id_proceso_wf,
            v_id_estado_wf			
			)RETURNING id_pedido_det into v_id_pedido_det;
            
            --OBtiene y actualiza el codigo
            update ven.tpedido_det set
            codigo = pxp.f_llenar_ceros(((v_parametros.id_pedido::varchar || v_parametros.id_item::varchar || v_id_pedido_det::varchar)::numeric*random())::numeric,20)
            where id_pedido_det =v_id_pedido_det;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Detalle Pedido almacenado(a) con exito (id_pedido_det'||v_id_pedido_det||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pedido_det',v_id_pedido_det::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'VEN_DETPED_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 06:34:29
	***********************************/

	elsif(p_transaccion='VEN_DETPED_MOD')then

		begin
		
			--Registro del Producto
        	v_id_producto = ven.f_registro_producto(p_id_usuario,hstore(v_parametros),p_transaccion);

			--Sentencia de la modificacion
			update ven.tpedido_det set
			id_pedido = v_parametros.id_pedido,
			id_item = v_parametros.id_item,
			id_proveedor = v_parametros.id_proveedor,
			codigo = v_parametros.codigo,
			cantidad_sol = v_parametros.cantidad_sol,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now()
			where id_pedido_det=v_parametros.id_pedido_det;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Detalle Pedido modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pedido_det',v_parametros.id_pedido_det::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'VEN_DETPED_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 06:34:29
	***********************************/

	elsif(p_transaccion='VEN_DETPED_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ven.tpedido_det
            where id_pedido_det=v_parametros.id_pedido_det;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Detalle Pedido eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pedido_det',v_parametros.id_pedido_det::varchar);
              
            --Devuelve la respuesta
            return v_resp;

		end;
		
	/*********************************    
 	#TRANSACCION:  'VEN_DETENV_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:			rcm	
 	#FECHA:			21/11/2013
	***********************************/

	elsif(p_transaccion='VEN_DETENV_INS')then
					
        begin
        
        	if not exists(select 1 from ven.tpedido_det
							where id_pedido_det = v_parametros.id_pedido_det) then
				raise exception 'Registro inexistente';
			end if;
           
            --Actualiza el registro
            update ven.tpedido_det set
            id_envio = v_parametros.id_envio
            where id_pedido_det = v_parametros.id_pedido_det;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Detalle Envio almacenado(a) con exito (id_pedido_det'||v_parametros.id_pedido_det||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pedido_det',v_parametros.id_pedido_det::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;
		
	/*********************************    
 	#TRANSACCION:  'VEN_DETENV_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:			rcm	
 	#FECHA:			21/11/2013
	***********************************/

	elsif(p_transaccion='VEN_DETENV_ELI')then

		begin
			if not exists(select 1 from ven.tpedido_det
							where id_pedido_det = v_parametros.id_pedido_det) then
				raise exception 'Registro inexistente';
			end if;
		
			--Sentencia de la eliminacion
			update ven.tpedido_det set
			id_envio = null
            where id_pedido_det=v_parametros.id_pedido_det;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Detalle Envio eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pedido_det',v_parametros.id_pedido_det::varchar);
              
            --Devuelve la respuesta
            return v_resp;

		end;
        
    /*********************************    
 	#TRANSACCION:  'VEN_DETPED_WF'
 	#DESCRIPCION:	Workflow de Pedido Detalle
 	#AUTOR:			RCM
 	#FECHA:			25/11/2013
	***********************************/

	elsif(p_transaccion='VEN_DETPED_WF')then

		begin
        	--Funcion para gestion del workflow del pedido
			v_resp = ven.f_pedido_det_workflow(p_id_usuario,hstore(v_parametros));
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Pedido Detalle gestionado por workflow'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pedido_det',v_parametros.id_pedido_det::varchar);
              
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