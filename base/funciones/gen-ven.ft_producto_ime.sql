CREATE OR REPLACE FUNCTION "ven"."ft_producto_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Ventas
 FUNCION: 		ven.ft_producto_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ven.tproducto'
 AUTOR: 		 (admin)
 FECHA:	        15-11-2013 23:40:58
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
	v_id_producto	integer;
			    
BEGIN

    v_nombre_funcion = 'ven.ft_producto_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'VEN_PROD_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-11-2013 23:40:58
	***********************************/

	if(p_transaccion='VEN_PROD_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ven.tproducto(
			precio_unit,
			altura,
			ancho,
			descripcion,
			codigo,
			largo,
			procedencia,
			nro_serie,
			estado_reg,
			id_unidad_medida_peso,
			marca,
			id_unidad_medida_long,
			id_item,
			peso,
			fecha_reg,
			id_usuario_reg,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.precio_unit,
			v_parametros.altura,
			v_parametros.ancho,
			v_parametros.descripcion,
			v_parametros.codigo,
			v_parametros.largo,
			v_parametros.procedencia,
			v_parametros.nro_serie,
			'activo',
			v_parametros.id_unidad_medida_peso,
			v_parametros.marca,
			v_parametros.id_unidad_medida_long,
			v_parametros.id_item,
			v_parametros.peso,
			now(),
			p_id_usuario,
			null,
			null
							
			)RETURNING id_producto into v_id_producto;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Producto almacenado(a) con exito (id_producto'||v_id_producto||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_producto',v_id_producto::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'VEN_PROD_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-11-2013 23:40:58
	***********************************/

	elsif(p_transaccion='VEN_PROD_MOD')then

		begin
			--Sentencia de la modificacion
			update ven.tproducto set
			precio_unit = v_parametros.precio_unit,
			altura = v_parametros.altura,
			ancho = v_parametros.ancho,
			descripcion = v_parametros.descripcion,
			codigo = v_parametros.codigo,
			largo = v_parametros.largo,
			procedencia = v_parametros.procedencia,
			nro_serie = v_parametros.nro_serie,
			id_unidad_medida_peso = v_parametros.id_unidad_medida_peso,
			marca = v_parametros.marca,
			id_unidad_medida_long = v_parametros.id_unidad_medida_long,
			id_item = v_parametros.id_item,
			peso = v_parametros.peso,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now()
			where id_producto=v_parametros.id_producto;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Producto modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_producto',v_parametros.id_producto::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'VEN_PROD_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-11-2013 23:40:58
	***********************************/

	elsif(p_transaccion='VEN_PROD_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ven.tproducto
            where id_producto=v_parametros.id_producto;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Producto eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_producto',v_parametros.id_producto::varchar);
              
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
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "ven"."ft_producto_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
