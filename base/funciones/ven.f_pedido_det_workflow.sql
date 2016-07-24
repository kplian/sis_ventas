CREATE OR REPLACE FUNCTION ven.f_pedido_det_workflow (
  p_id_usuario integer,
  p_parametros public.hstore
)
RETURNS varchar AS
$body$
/*
Autor: RCM
Fecha: 20/11/2013
Descripción: Función que se encarga de direccionar el worflow del sistema de ventas
*/

DECLARE
	
	v_nombre_funcion				varchar;
	v_resp		            		varchar;
	v_rec_ped						record;
    v_respuesta						varchar;
    v_id_depto						integer;
    v_id_funcionario				integer;
    v_cod_documento					varchar;
    v_id_proceso_wf					integer;
    v_id_estado_wf					integer;
    v_estado          				varchar;
    va_id_tipo_estado 				integer [];
    va_codigo_estado 				varchar [];
    va_disparador 					varchar [];
    va_regla 						varchar [];
    va_prioridad 					integer []; 
    v_id_tipo_proceso				integer;
    v_id_tipo_estado				integer;
    v_rec_wf						record;
    v_tipo_nodo						varchar;
    v_num_funcionarios				integer;
    v_cont							integer;
    g_registros						record;
    v_id_funcionario_estado			integer;
    v_id_estado_actual				integer;
    v_codigo_estado					varchar;
    v_id_usuario_reg				integer;
    v_id_estado_wf_ant				integer;    

BEGIN

	v_nombre_funcion = 'ven.f_pedido_det_workflow';
    
    if coalesce(p_parametros->'id_pedido_det',0)=0 is null then 
    	raise exception 'Eld Identificador del Registro no debe estar vacío';
    end if;

	------------------------------
    --1.OBTENCION DATOS MOVIMIENTO
    ------------------------------
    --Se obtienen los datos del pedido a finalizar
    select
	ped.codigo, ped.id_proceso_wf, ped.id_estado_wf, ped.estado
    into
    v_rec_ped
    from ven.tpedido_det ped
    where ped.id_pedido_det = (p_parametros->'id_pedido_det')::integer; 
        
    ----------------------------------
    --2.OBTENCIÓN DE DATOS WORK FLOW
    ----------------------------------
    select
    ped.id_proceso_wf, ped.id_estado_wf, ped.estado
    into            
    v_id_proceso_wf, v_id_estado_wf, v_estado
    from ven.tpedido_det ped
    where ped.id_pedido_det = (p_parametros->'id_pedido_det')::integer;
    
    --  Siguiente estado correspondiente al proceso del WF
    select 
    ps_id_tipo_estado, ps_codigo_estado, ps_disparador, ps_regla, ps_prioridad
    into
    va_id_tipo_estado, va_codigo_estado, va_disparador, va_regla, va_prioridad
    from wf.f_obtener_estado_wf(v_id_proceso_wf, v_id_estado_wf,NULL,'siguiente');
            
    --Obtención del Tipo de Proceso
    select pw.id_tipo_proceso
    into v_id_tipo_proceso
    from wf.tproceso_wf  pw
    where pw.id_proceso_wf = v_id_proceso_wf;
			
    --Obtención del tipo de estado   
    select ew.id_tipo_estado 
    into v_id_tipo_estado
    from wf.testado_wf ew
    where ew.id_estado_wf = v_id_estado_wf;

    --Datos del nodo
    select inicio, fin, tipo_asignacion
    into v_rec_wf
    from wf.ttipo_estado te
    where te.id_tipo_estado = va_id_tipo_estado[1];
            
    if v_rec_wf.inicio = 'si' then
        v_tipo_nodo = 'inicial';
    elsif v_rec_wf.fin = 'si' then
        v_tipo_nodo = 'final';
    else
        v_tipo_nodo = 'intermedio';
    end if;
    
    -------------------------
    --3. ACCIONES A REALIZAR
    -------------------------
            
    IF  (p_parametros->'operacion')::varchar = 'verificar' THEN
        -------------------------
        --3.1 VALIDACIÓN GENERAL
        -------------------------
        --Implementar

     
        ---------------------------------------------
        --3.2 VALIDACIÓN ESPECÍFICA POR TIPO DE NODO
        ---------------------------------------------
        v_respuesta =pxp.f_agrega_clave(v_respuesta,'mensaje','Verificación realizada');
        if v_tipo_nodo = 'inicial' then
            --Implementar
        elsif v_tipo_nodo = 'final' then
            --Implementar
        elsif v_tipo_nodo = 'intermedio' then
            --Implementar
        end if;
                
        ------------------------------
        --3.3 DEFINICION DE RESPUESTA
        ------------------------------
        --WF cantidad estados
        if array_length(va_id_tipo_estado,1)>0  THEN           
            v_respuesta=pxp.f_agrega_clave(v_respuesta,'wf_cant_estados',array_length(va_id_tipo_estado,1)::varchar);
                    
            if array_length(va_id_tipo_estado,1)= 1 then
                v_respuesta=pxp.f_agrega_clave(v_respuesta,'wf_id_tipo_estado',va_id_tipo_estado[1]::varchar);
            end if;
                    
            v_respuesta=pxp.f_agrega_clave(v_respuesta,'id_tipo_proceso',v_id_tipo_proceso::varchar);
            v_respuesta=pxp.f_agrega_clave(v_respuesta,'id_tipo_estado_padre',v_id_tipo_estado::varchar);
                    
        else
            --No hay estado siguiente
          	raise exception '%', 'Nada que hacer. No hay ningún estado siguiente';
        end if;
                
        --WF cantidad funcionarios
        v_num_funcionarios=0;
        --Verifica si el estado acepta funcionarios
        if v_rec_wf.tipo_asignacion != 'ninguno' then
            select *
            into v_num_funcionarios 
            from wf.f_funcionario_wf_sel(p_id_usuario, va_id_tipo_estado[1],v_rec_ped.fecha,v_id_estado_wf,true) as (total bigint);
                    
            v_cont=1;
            for g_registros in (SELECT id_funcionario, desc_funcionario, desc_funcionario_cargo
                                from wf.f_funcionario_wf_sel(
                                p_id_usuario, 
                                va_id_tipo_estado[1], 
                                v_rec_ped.fecha,
                                v_id_estado_wf,
                                false) 
                                AS (id_funcionario integer,
                                desc_funcionario text,
                                desc_funcionario_cargo text,
                                prioridad integer)) loop
                if v_cont = 1 then
                    v_id_funcionario_estado = g_registros.id_funcionario;
                end if;
                v_cont = v_cont + 1;
            end loop;
                  
            v_respuesta=pxp.f_agrega_clave(v_respuesta,'wf_cant_funcionarios',v_num_funcionarios::varchar);

            if v_num_funcionarios = 1 then
                v_respuesta=pxp.f_agrega_clave(v_respuesta,'wf_id_funcionario',v_id_funcionario_estado::varchar);
            end if;

        else
            --Respuesta de que no hay funcionarios
            v_respuesta=pxp.f_agrega_clave(v_respuesta,'wf_cant_funcionarios','0');
        end if;
                
        v_respuesta=pxp.f_agrega_clave(v_respuesta,'id_estado_wf',v_id_estado_wf::varchar);
        v_respuesta=pxp.f_agrega_clave(v_respuesta,'fecha',v_rec_ped.fecha::varchar);

     ELSIF (p_parametros->'operacion')::varchar = 'siguiente' THEN  
            
        ----------------------------------------
        --4.REGISTRO NUEVO ESTADO DEL WORK FLOW
        ----------------------------------------

       
        v_id_estado_actual =  wf.f_registra_estado_wf((p_parametros->'id_tipo_estado')::integer,--va_id_tipo_estado[1], 
                                                      (p_parametros->'id_funcionario_wf')::integer,--v_id_funcionario_estado, 
                                                      v_id_estado_wf, 
                                                      v_id_proceso_wf,
                                                      p_id_usuario,
                                                      NULL);
            	
        --Obtiene el código del estado obtenido                      
        select te.codigo
        into v_codigo_estado
        from wf.testado_wf ewf
        inner join wf.ttipo_estado te on te.id_tipo_estado = ewf.id_tipo_estado
        where ewf.id_estado_wf = v_id_estado_actual;

        -----------------------
        --5.ACCIONES GENERALES
        -----------------------
        --Actualiza estado de WF
        update ven.tpedido_det set
        id_estado_wf = v_id_estado_actual,           
        estado = v_codigo_estado,
        fecha_mod = now(),
        id_usuario_mod = p_id_usuario
        where id_pedido_det = (p_parametros->'id_pedido_det')::integer;
          
        --------------------------------
        --3.4 ACCIONES POR TIPO DE NODO
        --------------------------------
        if v_tipo_nodo = 'inicial' then
            --Implementar
        elsif v_tipo_nodo = 'intermedio' then
			--Implementar
        elsif v_tipo_nodo = 'final' then
			--Implementar
        end if;
                
    ELSIF (p_parametros->'operacion')::varchar = 'anterior' THEN
            
        --Recupera estado anterior segun Log del WF
        SELECT  
        ps_id_tipo_estado,ps_id_funcionario,ps_id_usuario_reg,
        ps_id_depto,ps_codigo_estado,ps_id_estado_wf_ant
        into
        v_id_tipo_estado,v_id_funcionario,v_id_usuario_reg,
        v_id_depto,v_codigo_estado,v_id_estado_wf_ant 
        FROM wf.f_obtener_estado_ant_log_wf(v_id_estado_wf);
                            
        --Encuentra el proceso
        select ew.id_proceso_wf 
        into v_id_proceso_wf
        from wf.testado_wf ew
        where ew.id_estado_wf= v_id_estado_wf_ant;
                          
        --Registra nuevo estado
        v_id_estado_actual = wf.f_registra_estado_wf(
                      v_id_tipo_estado, 
                      v_id_funcionario, 
                      v_id_estado_wf, 
                      v_id_proceso_wf, 
                      p_id_usuario,
                      v_id_depto,
                      (p_parametros->'obs')::varchar);
                          
        --Actualiza estado del movimiento
        update ven.tpedido_det  set 
        id_estado_wf = v_id_estado_actual,
        estado = v_codigo_estado,
        id_usuario_mod = p_id_usuario,
        fecha_mod = now()
        where id_pedido_det = (p_parametros->'id_pedido_det')::integer;
                             
        v_respuesta = pxp.f_agrega_clave(v_respuesta,'mensaje','Se retrocedió el Pedido Detalle al estado anterior)'); 
            
    ELSIF (p_parametros->'operacion')::varchar = 'inicio' THEN

        SELECT
        ped.id_estado_wf, pw.id_tipo_proceso, pw.id_proceso_wf
        into
        v_id_estado_wf, v_id_tipo_proceso, v_id_proceso_wf
        FROM ven.tpedido ped
        inner join wf.tproceso_wf pw on pw.id_proceso_wf = ped.id_proceso_wf
        WHERE ped.id_pedido = (p_parametros->'id_pedido')::integer;
      
        --Recuperamos el estado inicial segun tipo_proceso
        SELECT  
        ps_id_tipo_estado, ps_codigo_estado
        into
        v_id_tipo_estado,v_codigo_estado
        FROM wf.f_obtener_tipo_estado_inicial_del_tipo_proceso(v_id_tipo_proceso);
                 
        --Recupera el funcionario según log
        SELECT 
        ps_id_funcionario, ps_codigo_estado, ps_id_depto
        into
        v_id_funcionario, v_codigo_estado, v_id_depto
        FROM wf.f_obtener_estado_segun_log_wf(v_id_estado_wf, v_id_tipo_estado);
                
         --Registra estado borrador
         v_id_estado_actual = wf.f_registra_estado_wf(
                v_id_tipo_estado, 
                v_id_funcionario, 
                v_id_estado_wf, 
                v_id_proceso_wf, 
                p_id_usuario,
                v_id_depto,
                (p_parametros->'obs')::varchar);
                          
         --Actualiza estado en el movimiento
         update ven.tpedido_det set 
         id_estado_wf = v_id_estado_actual,
         estado = v_codigo_estado,
         id_usuario_mod = p_id_usuario,
         fecha_mod = now()
         where id_pedido_det = (p_parametros->'id_pedido_det')::integer;             
                
         --Respuesta
         v_respuesta = pxp.f_agrega_clave(v_respuesta,'mensaje','Se regreso al estado inicial'); 
           
    ELSE
                  
        raise exception 'Operación no identificada %',COALESCE( (p_parametros->'operacion')::varchar,'--');
                  
    END IF; 
    
    --Respuesta
    return v_respuesta;
    
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