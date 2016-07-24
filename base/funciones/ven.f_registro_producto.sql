CREATE OR REPLACE FUNCTION ven.f_registro_producto (
  p_id_usuario integer,
  p_parametros public.hstore,
  p_transaccion varchar
)
RETURNS integer AS
$body$
/*
Autor: RCM
Fecha: 17/11/2013
Descripcion: Registro del producto en la tabla ven.tproducto
*/
DECLARE

	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_producto			integer;

BEGIN

	if p_transaccion = 'VEN_DETPED_INS' then
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
        (p_parametros->'precio_unit')::numeric,
        (p_parametros->'altura')::numeric,
        (p_parametros->'ancho')::numeric,
        (p_parametros->'descripcion')::text,
        (p_parametros->'codigo')::varchar,
        (p_parametros->'largo')::numeric,
        (p_parametros->'procedencia')::varchar,
        (p_parametros->'nro_serie')::varchar,
        'activo',
        (p_parametros->'id_unidad_medida_peso')::integer,
        (p_parametros->'marca')::varchar,
        (p_parametros->'id_unidad_medida_long')::integer,
        (p_parametros->'id_item')::integer,
        (p_parametros->'peso')::numeric,
        now(),
        p_id_usuario,
        null,
        null
        )RETURNING id_producto into v_id_producto;
    			
        --Devuelve la respuesta
        return v_id_producto;
        
	elsif p_transaccion = 'VEN_DETPED_MOD' then
    
    	if not exists(select 1 from ven.tproducto
        			where id_producto = (p_parametros->'id_producto')::integer) then
        	raise exception 'Producto inexistente';
        end if;
    
    	--Sentencia de la modificacion
        update ven.tproducto set
        precio_unit = (p_parametros->'precio_unit')::numeric,
        altura = (p_parametros->'altura')::numeric,
        ancho = (p_parametros->'ancho')::numeric,
        descripcion = (p_parametros->'descripcion')::text,
        codigo = (p_parametros->'codigo')::varchar,
        largo = (p_parametros->'largo')::numeric,
        procedencia = (p_parametros->'procedencia')::varchar,
        nro_serie = (p_parametros->'nro_serie')::varchar,
        id_unidad_medida_peso = (p_parametros->'id_unidad_medida_peso')::integer,
        marca = (p_parametros->'marca')::varchar,
        id_unidad_medida_long = (p_parametros->'id_unidad_medida_long')::integer,
        id_item = (p_parametros->'id_item')::integer,
        peso = (p_parametros->'peso')::numeric,
        id_usuario_mod = p_id_usuario,
        fecha_mod = now()
        where id_producto=(p_parametros->'id_producto')::integer;
        
        return (p_parametros->'id_producto')::integer;
        
    else
    	raise exception 'Transaccion inexistente';
    end if;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;