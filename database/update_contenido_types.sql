-- Script para actualizar la base de datos existente con nuevos tipos de contenido
-- Ejecuta este script si ya tienes la base de datos creada

USE marketplace;

-- Actualizar la columna tipo_contenido en la tabla lecciones para soportar más tipos
ALTER TABLE lecciones 
MODIFY COLUMN tipo_contenido ENUM(
    'video', 
    'video_archivo', 
    'pdf', 
    'word', 
    'presentacion', 
    'excel', 
    'codigo', 
    'texto', 
    'markdown', 
    'audio', 
    'imagen', 
    'quiz', 
    'recurso', 
    'enlace',
    'documento'  -- Mantenemos compatibilidad con valores antiguos
) DEFAULT 'video';

-- Actualizar la columna url_contenido para soportar URLs más largas
ALTER TABLE lecciones 
MODIFY COLUMN url_contenido VARCHAR(500);

-- Migrar valores antiguos a nuevos tipos
UPDATE lecciones SET tipo_contenido = 'pdf' WHERE tipo_contenido = 'documento';

SELECT 'Base de datos actualizada correctamente' as mensaje;
