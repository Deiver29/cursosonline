<?php ob_start(); ?>

<div class="container" style="padding: 2rem 0;">
    <div class="mb-3">
        <a href="<?php echo BASE_URL; ?>capacitador/misCursos" class="btn btn-outline">← Volver a Mis Cursos</a>
    </div>
    
    <h1 class="mb-4">Editar Curso: <?php echo $curso['titulo']; ?></h1>
    
    <?php if (isset($mensaje)): ?>
        <div class="alert alert-success"><?php echo $mensaje; ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['warning'])): ?>
        <div class="alert alert-warning" style="background: #FEF3C7; color: #92400E; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <strong>⚠️ Aviso:</strong> <?php echo $_SESSION['warning']; unset($_SESSION['warning']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger" style="background: #FEE2E2; color: #991B1B; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <strong>⚠️ Error:</strong> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <div>
            <div class="card mb-3">
                <div class="card-body">
                    <h3 class="mb-3">Información del Curso</h3>
                    <form method="POST">
                        <div class="form-group">
                            <label class="form-label">Título</label>
                            <input type="text" name="titulo" class="form-control" value="<?php echo $curso['titulo']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="6" required><?php echo $curso['descripcion']; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Categoría</label>
                            <select name="categoria_id" class="form-control" required>
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php echo $curso['categoria_id'] == $cat['id'] ? 'selected' : ''; ?>>
                                        <?php echo $cat['nombre']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Idioma del Curso</label>
                            <select name="idioma" class="form-control" required>
                                <optgroup label="Más Populares">
                                    <option value="es" <?php echo $curso['idioma'] == 'es' ? 'selected' : ''; ?>>🇪🇸 Español</option>
                                    <option value="en" <?php echo $curso['idioma'] == 'en' ? 'selected' : ''; ?>>🇬🇧 English</option>
                                    <option value="zh" <?php echo $curso['idioma'] == 'zh' ? 'selected' : ''; ?>>🇨🇳 中文 (Chino)</option>
                                    <option value="hi" <?php echo $curso['idioma'] == 'hi' ? 'selected' : ''; ?>>🇮🇳 हिन्दी (Hindi)</option>
                                    <option value="ar" <?php echo $curso['idioma'] == 'ar' ? 'selected' : ''; ?>>🇸🇦 العربية (Árabe)</option>
                                    <option value="pt" <?php echo $curso['idioma'] == 'pt' ? 'selected' : ''; ?>>🇵🇹 Português</option>
                                    <option value="fr" <?php echo $curso['idioma'] == 'fr' ? 'selected' : ''; ?>>🇫🇷 Français</option>
                                    <option value="de" <?php echo $curso['idioma'] == 'de' ? 'selected' : ''; ?>>🇩🇪 Deutsch</option>
                                    <option value="ja" <?php echo $curso['idioma'] == 'ja' ? 'selected' : ''; ?>>🇯🇵 日本語 (Japonés)</option>
                                    <option value="ru" <?php echo $curso['idioma'] == 'ru' ? 'selected' : ''; ?>>🇷🇺 Русский (Ruso)</option>
                                </optgroup>
                                <optgroup label="Europa">
                                    <option value="it" <?php echo $curso['idioma'] == 'it' ? 'selected' : ''; ?>>🇮🇹 Italiano</option>
                                    <option value="pl" <?php echo $curso['idioma'] == 'pl' ? 'selected' : ''; ?>>🇵🇱 Polski (Polaco)</option>
                                    <option value="nl" <?php echo $curso['idioma'] == 'nl' ? 'selected' : ''; ?>>🇳🇱 Nederlands (Holandés)</option>
                                    <option value="uk" <?php echo $curso['idioma'] == 'uk' ? 'selected' : ''; ?>>🇺🇦 Українська (Ucraniano)</option>
                                    <option value="ro" <?php echo $curso['idioma'] == 'ro' ? 'selected' : ''; ?>>🇷🇴 Română (Rumano)</option>
                                    <option value="cs" <?php echo $curso['idioma'] == 'cs' ? 'selected' : ''; ?>>🇨🇿 Čeština (Checo)</option>
                                    <option value="sv" <?php echo $curso['idioma'] == 'sv' ? 'selected' : ''; ?>>🇸🇪 Svenska (Sueco)</option>
                                    <option value="el" <?php echo $curso['idioma'] == 'el' ? 'selected' : ''; ?>>🇬🇷 Ελληνικά (Griego)</option>
                                    <option value="hu" <?php echo $curso['idioma'] == 'hu' ? 'selected' : ''; ?>>🇭🇺 Magyar (Húngaro)</option>
                                    <option value="da" <?php echo $curso['idioma'] == 'da' ? 'selected' : ''; ?>>🇩🇰 Dansk (Danés)</option>
                                    <option value="no" <?php echo $curso['idioma'] == 'no' ? 'selected' : ''; ?>>🇳🇴 Norsk (Noruego)</option>
                                    <option value="fi" <?php echo $curso['idioma'] == 'fi' ? 'selected' : ''; ?>>🇫🇮 Suomi (Finlandés)</option>
                                </optgroup>
                                <optgroup label="Asia">
                                    <option value="ko" <?php echo $curso['idioma'] == 'ko' ? 'selected' : ''; ?>>🇰🇷 한국어 (Coreano)</option>
                                    <option value="th" <?php echo $curso['idioma'] == 'th' ? 'selected' : ''; ?>>🇹🇭 ไทย (Tailandés)</option>
                                    <option value="vi" <?php echo $curso['idioma'] == 'vi' ? 'selected' : ''; ?>>🇻🇳 Tiếng Việt (Vietnamita)</option>
                                    <option value="id" <?php echo $curso['idioma'] == 'id' ? 'selected' : ''; ?>>🇮🇩 Bahasa Indonesia</option>
                                    <option value="ms" <?php echo $curso['idioma'] == 'ms' ? 'selected' : ''; ?>>🇲🇾 Bahasa Melayu (Malayo)</option>
                                    <option value="fil" <?php echo $curso['idioma'] == 'fil' ? 'selected' : ''; ?>>🇵🇭 Filipino</option>
                                    <option value="tr" <?php echo $curso['idioma'] == 'tr' ? 'selected' : ''; ?>>🇹🇷 Türkçe (Turco)</option>
                                    <option value="he" <?php echo $curso['idioma'] == 'he' ? 'selected' : ''; ?>>🇮🇱 עברית (Hebreo)</option>
                                    <option value="fa" <?php echo $curso['idioma'] == 'fa' ? 'selected' : ''; ?>>🇮🇷 فارسی (Persa)</option>
                                </optgroup>
                                <optgroup label="América">
                                    <option value="pt-br" <?php echo $curso['idioma'] == 'pt-br' ? 'selected' : ''; ?>>🇧🇷 Português (Brasil)</option>
                                    <option value="en-us" <?php echo $curso['idioma'] == 'en-us' ? 'selected' : ''; ?>>🇺🇸 English (US)</option>
                                </optgroup>
                                <optgroup label="África">
                                    <option value="sw" <?php echo $curso['idioma'] == 'sw' ? 'selected' : ''; ?>>🇰🇪 Kiswahili (Suajili)</option>
                                    <option value="af" <?php echo $curso['idioma'] == 'af' ? 'selected' : ''; ?>>🇿🇦 Afrikaans</option>
                                </optgroup>
                                <optgroup label="Otros">
                                    <option value="bn" <?php echo $curso['idioma'] == 'bn' ? 'selected' : ''; ?>>🇧🇩 বাংলা (Bengalí)</option>
                                    <option value="ur" <?php echo $curso['idioma'] == 'ur' ? 'selected' : ''; ?>>🇵🇰 اردو (Urdu)</option>
                                    <option value="pa" <?php echo $curso['idioma'] == 'pa' ? 'selected' : ''; ?>>🇮🇳 ਪੰਜਾਬੀ (Panyabí)</option>
                                    <option value="ta" <?php echo $curso['idioma'] == 'ta' ? 'selected' : ''; ?>>🇮🇳 தமிழ் (Tamil)</option>
                                    <option value="te" <?php echo $curso['idioma'] == 'te' ? 'selected' : ''; ?>>🇮🇳 తెలుగు (Telugu)</option>
                                    <option value="mr" <?php echo $curso['idioma'] == 'mr' ? 'selected' : ''; ?>>🇮🇳 मराठी (Maratí)</option>
                                </optgroup>
                            </select>
                            <small style="color: #6B7280;">Selecciona el idioma principal del curso</small>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Nivel</label>
                            <select name="nivel" class="form-control" required>
                                <option value="basico" <?php echo $curso['nivel'] == 'basico' ? 'selected' : ''; ?>>Básico</option>
                                <option value="intermedio" <?php echo $curso['nivel'] == 'intermedio' ? 'selected' : ''; ?>>Intermedio</option>
                                <option value="avanzado" <?php echo $curso['nivel'] == 'avanzado' ? 'selected' : ''; ?>>Avanzado</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Precio</label>
                            <input type="number" name="precio" class="form-control" step="0.01" value="<?php echo $curso['precio']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Moneda</label>
                            <select name="moneda" class="form-control" required>
                                <option value="USD" <?php echo $curso['moneda'] == 'USD' ? 'selected' : ''; ?>>USD</option>
                                <option value="EUR" <?php echo $curso['moneda'] == 'EUR' ? 'selected' : ''; ?>>EUR</option>
                                <option value="GBP" <?php echo $curso['moneda'] == 'GBP' ? 'selected' : ''; ?>>GBP</option>
                                <option value="MXN" <?php echo $curso['moneda'] == 'MXN' ? 'selected' : ''; ?>>MXN</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">URL de Imagen</label>
                            <input type="text" name="imagen" class="form-control" value="<?php echo $curso['imagen_portada']; ?>">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div>
            <div class="card mb-3">
                <div class="card-body">
                    <h3 class="mb-3">Contenido del Curso</h3>
                    
                    <button onclick="toggleForm('moduloForm')" class="btn btn-secondary mb-3">➕ Agregar Módulo</button>
                    
                    <div id="moduloForm" style="display: none;" class="card mb-3" style="background: var(--light-color);">
                        <div class="card-body">
                            <form method="POST" action="<?php echo BASE_URL; ?>capacitador/agregarModulo" id="formModulo" onsubmit="return agregarTokenUnico(this);">
                                <input type="hidden" name="curso_id" value="<?php echo $curso['id']; ?>">
                                <input type="hidden" name="form_token" value="" id="token_modulo">
                                <div class="form-group">
                                    <label class="form-label">Título del Módulo</label>
                                    <input type="text" name="titulo" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Descripción</label>
                                    <textarea name="descripcion" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Orden</label>
                                    <input type="number" name="orden" class="form-control" value="<?php echo count($modulos) + 1; ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-small">Guardar Módulo</button>
                            </form>
                        </div>
                    </div>
                    
                    <?php if (empty($modulos)): ?>
                        <p>No has agregado módulos aún. Agrega módulos y lecciones para estructurar tu curso.</p>
                    <?php else: ?>
                        <?php foreach ($modulos as $index => $modulo): ?>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div style="display: flex; justify-content: space-between; align-items: start;">
                                        <div>
                                            <h4><?php echo $modulo['titulo']; ?></h4>
                                            <p style="color: #6b7280; font-size: 0.875rem;"><?php echo $modulo['descripcion']; ?></p>
                                        </div>
                                        <button onclick="if(confirm('¿Eliminar este módulo y todas sus lecciones?')) { window.location.href='<?php echo BASE_URL; ?>capacitador/eliminarModulo/<?php echo $modulo['id']; ?>/<?php echo $curso['id']; ?>'; }" 
                                                class="btn btn-danger btn-small" 
                                                style="background: #DC2626; padding: 0.4rem 0.8rem; font-size: 0.85rem;">
                                            🗑️ Eliminar Módulo
                                        </button>
                                    </div>
                                    
                                    <button onclick="toggleForm('leccionForm<?php echo $index; ?>')" class="btn btn-secondary btn-small">
                                        ➕ Agregar Lección
                                    </button>
                                    
                                    <!-- Listado de lecciones existentes -->
                                    <?php if (!empty($modulo['lecciones'])): ?>
                                        <div style="margin-top: 1rem; padding-left: 1rem;">
                                            <h5 style="color: #6D28D9; font-size: 0.9rem; margin-bottom: 0.5rem;">📚 Lecciones:</h5>
                                            <?php foreach ($modulo['lecciones'] as $leccion): ?>
                                                <div style="padding: 0.75rem; background: #F9FAFB; border-left: 3px solid #6D28D9; margin-bottom: 0.5rem; border-radius: 0.25rem;">
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <div style="flex: 1;">
                                                            <strong style="color: #1F2937;"><?php echo $leccion['orden']; ?>. <?php echo htmlspecialchars($leccion['titulo']); ?></strong>
                                                            <div style="color: #6B7280; font-size: 0.8rem; margin-top: 0.25rem;">
                                                                <?php
                                                                $iconos = [
                                                                    'video' => '🎥', 'video_archivo' => '📹', 'pdf' => '📄',
                                                                    'word' => '📝', 'presentacion' => '📊', 'excel' => '📈',
                                                                    'codigo' => '💻', 'texto' => '📃', 'markdown' => '📋',
                                                                    'audio' => '🎵', 'imagen' => '🖼️', 'quiz' => '❓',
                                                                    'recurso' => '📦', 'enlace' => '🔗'
                                                                ];
                                                                echo $iconos[$leccion['tipo_contenido']] ?? '📄';
                                                                echo ' ' . ucfirst($leccion['tipo_contenido']);
                                                                if ($leccion['duracion'] > 0) {
                                                                    echo ' • ⏱️ ' . $leccion['duracion'] . ' min';
                                                                }
                                                                ?>
                                                            </div>
                                                            <?php if (!empty($leccion['url_contenido'])): ?>
                                                                <div style="color: #059669; font-size: 0.75rem; margin-top: 0.25rem;">
                                                                    ✓ Contenido cargado
                                                                    <?php if (strpos($leccion['url_contenido'], BASE_URL . 'uploads/') === 0): ?>
                                                                        <span style="color: #2563EB;">• 📤 Archivo subido</span>
                                                                    <?php else: ?>
                                                                        <span style="color: #7C3AED;">• 🔗 URL externa</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <button onclick="if(confirm('¿Eliminar esta lección?')) { window.location.href='<?php echo BASE_URL; ?>capacitador/eliminarLeccion/<?php echo $leccion['id']; ?>/<?php echo $curso['id']; ?>'; }" 
                                                                class="btn btn-danger btn-small" 
                                                                style="background: #DC2626; padding: 0.3rem 0.6rem; font-size: 0.8rem; margin-left: 1rem;">
                                                            🗑️
                                                        </button>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div id="leccionForm<?php echo $index; ?>" style="display: none; margin-top: 1rem; padding: 1rem; background: var(--light-color); border-radius: 0.5rem;">
                                        <form method="POST" action="<?php echo BASE_URL; ?>capacitador/agregarLeccion" enctype="multipart/form-data" id="formLeccion<?php echo $index; ?>" onsubmit="return agregarTokenUnico(this);">
                                            <input type="hidden" name="modulo_id" value="<?php echo $modulo['id']; ?>">
                                            <input type="hidden" name="curso_id" value="<?php echo $curso['id']; ?>">
                                            <input type="hidden" name="form_token" value="" class="token_leccion">
                                            
                                            <div class="form-group">
                                                <label class="form-label">Título de la Lección</label>
                                                <input type="text" name="titulo" class="form-control" required>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="form-label">Tipo de Contenido</label>
                                                <select name="tipo_contenido" class="form-control" id="tipo_contenido_<?php echo $index; ?>" required onchange="updateContentOptions(this, <?php echo $index; ?>)">
                                                    <optgroup label="Video">
                                                        <option value="video">🎥 Video (YouTube, Vimeo, etc.)</option>
                                                        <option value="video_archivo">📹 Video Archivo (.mp4, .mov, .avi)</option>
                                                    </optgroup>
                                                    <optgroup label="Documentos">
                                                        <option value="pdf">📄 PDF</option>
                                                        <option value="word">📝 Word (.doc, .docx)</option>
                                                        <option value="presentacion">📊 Presentación (.ppt, .pptx)</option>
                                                        <option value="excel">📈 Excel (.xls, .xlsx)</option>
                                                    </optgroup>
                                                    <optgroup label="Código y Texto">
                                                        <option value="codigo">💻 Código Fuente (.zip, .rar)</option>
                                                        <option value="texto">📃 Texto Plano (.txt)</option>
                                                        <option value="markdown">📋 Markdown (.md)</option>
                                                    </optgroup>
                                                    <optgroup label="Audio e Imagen">
                                                        <option value="audio">🎵 Audio (.mp3, .wav)</option>
                                                        <option value="imagen">🖼️ Imagen (.jpg, .png, .svg)</option>
                                                    </optgroup>
                                                    <optgroup label="Interactivo">
                                                        <option value="quiz">❓ Quiz / Evaluación</option>
                                                        <option value="recurso">📦 Recurso Descargable</option>
                                                        <option value="enlace">🔗 Enlace Externo</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                            
                                            <!-- Opción para elegir entre URL o Subir Archivo -->
                                            <div class="form-group">
                                                <label class="form-label">¿Cómo quieres agregar el contenido?</label>
                                                <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                                                    <label style="display: flex; align-items: center; cursor: pointer;">
                                                        <input type="radio" name="metodo_contenido_<?php echo $index; ?>" value="url" checked onchange="toggleContentMethod(this, <?php echo $index; ?>)" style="margin-right: 0.5rem;">
                                                        🔗 Usar URL Externa
                                                    </label>
                                                    <label style="display: flex; align-items: center; cursor: pointer;">
                                                        <input type="radio" name="metodo_contenido_<?php echo $index; ?>" value="archivo" onchange="toggleContentMethod(this, <?php echo $index; ?>)" style="margin-right: 0.5rem;">
                                                        📤 Subir Archivo desde mi PC
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <!-- Campo URL (por defecto visible) -->
                                            <div class="form-group" id="campo_url_<?php echo $index; ?>">
                                                <label class="form-label">URL del Contenido</label>
                                                <input type="text" name="url_contenido" class="form-control" id="url_contenido_<?php echo $index; ?>" placeholder="https://...">
                                                <small id="content_help_<?php echo $index; ?>" style="color: #6B7280;">
                                                    📹 Ejemplo: https://www.youtube.com/watch?v=...<br>
                                                    📄 O enlace de Google Drive, Dropbox, etc.
                                                </small>
                                            </div>
                                            
                                            <!-- Campo Archivo (oculto por defecto) -->
                                            <div class="form-group" id="campo_archivo_<?php echo $index; ?>" style="display: none;">
                                                <label class="form-label">Selecciona el Archivo</label>
                                                <input type="file" name="archivo_contenido" class="form-control" id="archivo_contenido_<?php echo $index; ?>" accept="*/*">
                                                <small id="file_help_<?php echo $index; ?>" style="color: #6B7280; display: block; margin-top: 0.5rem;">
                                                    📦 <strong>Tamaño máximo: 500MB</strong> (límite actual de PHP: <?php echo ini_get('upload_max_filesize'); ?>)<br>
                                                    💡 Formatos aceptados: Videos (.mp4, .mov, .avi), Documentos (.pdf, .docx, .pptx), Audio (.mp3), Imágenes (.jpg, .png), Comprimidos (.zip, .rar)<br>
                                                    <?php 
                                                    $limit_mb = (int)ini_get('upload_max_filesize');
                                                    if ($limit_mb < 100): 
                                                    ?>
                                                        <span style="color: #DC2626;">⚠️ Límite bajo detectado. <a href="<?php echo BASE_URL; ?>ajustar_php.php" target="_blank" style="color: #2563EB; text-decoration: underline;">Clic aquí para aumentarlo</a></span>
                                                    <?php endif; ?>
                                                </small>
                                                <div id="preview_archivo_<?php echo $index; ?>" style="margin-top: 0.5rem; padding: 0.75rem; background: #F3F4F6; border-radius: 0.5rem; display: none;">
                                                    <strong>Archivo seleccionado:</strong>
                                                    <div id="nombre_archivo_<?php echo $index; ?>" style="margin-top: 0.5rem;"></div>
                                                    <div id="tamano_archivo_<?php echo $index; ?>" style="margin-top: 0.25rem; color: #6B7280; font-size: 0.875rem;"></div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="form-label">Contenido/Descripción</label>
                                                <textarea name="contenido" class="form-control"></textarea>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="form-label">Duración (minutos)</label>
                                                <input type="number" name="duracion" class="form-control" value="0">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="form-label">Orden</label>
                                                <input type="number" name="orden" class="form-control" value="1" required>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary btn-small" id="btn_leccion_<?php echo $index; ?>">Guardar Lección</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Función para generar token único justo antes de enviar
function agregarTokenUnico(form) {
    const tokenInput = form.querySelector('input[name="form_token"]');
    if (tokenInput && !tokenInput.value) {
        // Generar token único con timestamp y random
        tokenInput.value = 'token_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }
    
    // Deshabilitar el botón submit para evitar doble clic
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn && !submitBtn.disabled) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '⏳ Guardando...';
    }
    
    return true; // Permitir envío del formulario
}

function toggleForm(formId) {
    const form = document.getElementById(formId);
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function toggleContentMethod(radio, index) {
    const campoUrl = document.getElementById('campo_url_' + index);
    const campoArchivo = document.getElementById('campo_archivo_' + index);
    const urlInput = document.getElementById('url_contenido_' + index);
    const archivoInput = document.getElementById('archivo_contenido_' + index);
    
    if (radio.value === 'url') {
        campoUrl.style.display = 'block';
        campoArchivo.style.display = 'none';
        urlInput.required = true;
        archivoInput.required = false;
        archivoInput.value = '';
    } else {
        campoUrl.style.display = 'none';
        campoArchivo.style.display = 'block';
        urlInput.required = false;
        archivoInput.required = true;
        urlInput.value = '';
    }
}

function updateContentOptions(select, index) {
    const tipo = select.value;
    const helpText = document.getElementById('content_help_' + index);
    const fileHelp = document.getElementById('file_help_' + index);
    const archivoInput = document.getElementById('archivo_contenido_' + index);
    
    const helpMessages = {
        'video': '🎥 Ejemplo: https://www.youtube.com/watch?v=... o https://vimeo.com/...',
        'video_archivo': '📹 Enlace directo a archivo de video (.mp4, .mov, .avi)',
        'pdf': '📄 URL del archivo PDF',
        'word': '📝 URL del documento Word (.doc, .docx)',
        'presentacion': '📊 URL de la presentación PowerPoint (.ppt, .pptx)',
        'excel': '📈 URL del archivo Excel (.xls, .xlsx)',
        'codigo': '💻 URL del archivo comprimido con código fuente (.zip, .rar)',
        'texto': '📃 URL del archivo de texto plano (.txt)',
        'markdown': '📋 URL del archivo Markdown (.md)',
        'audio': '🎵 URL del archivo de audio (.mp3, .wav, .m4a)',
        'imagen': '🖼️ URL de la imagen (.jpg, .png, .gif, .svg)',
        'quiz': '❓ URL del quiz externo (opcional)',
        'recurso': '📦 URL del recurso descargable',
        'enlace': '🔗 URL completa del sitio web o recurso externo'
    };
    
    const acceptTypes = {
        'video': '.mp4,.mov,.avi,.wmv,.flv,.mkv,.webm',
        'video_archivo': '.mp4,.mov,.avi,.wmv,.flv,.mkv,.webm',
        'pdf': '.pdf',
        'word': '.doc,.docx',
        'presentacion': '.ppt,.pptx',
        'excel': '.xls,.xlsx',
        'codigo': '.zip,.rar,.7z,.tar,.gz',
        'texto': '.txt',
        'markdown': '.md',
        'audio': '.mp3,.wav,.m4a,.ogg,.flac',
        'imagen': '.jpg,.jpeg,.png,.gif,.svg,.webp',
        'recurso': '*'
    };
    
    if (helpMessages[tipo]) {
        helpText.innerHTML = helpMessages[tipo];
    }
    
    if (acceptTypes[tipo]) {
        archivoInput.setAttribute('accept', acceptTypes[tipo]);
    }
}

// Mostrar información del archivo seleccionado y validar tamaño
document.addEventListener('DOMContentLoaded', function() {
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    // Límite máximo en bytes (500MB por defecto, puedes ajustar según php.ini)
    const MAX_FILE_SIZE = 500 * 1024 * 1024; // 500MB
    
    fileInputs.forEach(function(input) {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Extraer el índice del ID del input
                const inputId = e.target.id;
                const index = inputId.replace('archivo_contenido_', '');
                
                const preview = document.getElementById('preview_archivo_' + index);
                const nombreDiv = document.getElementById('nombre_archivo_' + index);
                const tamanoDiv = document.getElementById('tamano_archivo_' + index);
                
                if (preview && nombreDiv && tamanoDiv) {
                    nombreDiv.textContent = '📄 ' + file.name;
                    
                    // Validar tamaño
                    if (file.size > MAX_FILE_SIZE) {
                        tamanoDiv.innerHTML = '❌ <span style="color: #DC2626;">Tamaño: ' + formatBytes(file.size) + ' - EXCEDE EL LÍMITE DE 500MB</span>';
                        e.target.value = ''; // Limpiar selección
                        alert('⚠️ El archivo es demasiado grande.\n\n' +
                              'Tamaño del archivo: ' + formatBytes(file.size) + '\n' +
                              'Límite máximo: 500MB\n\n' +
                              'Por favor, selecciona un archivo más pequeño o comprime el video.');
                        preview.style.display = 'none';
                    } else {
                        tamanoDiv.innerHTML = '💾 Tamaño: ' + formatBytes(file.size) + ' <span style="color: #059669;">✓</span>';
                        preview.style.display = 'block';
                    }
                }
            }
        });
    });
    
    // Validar formularios antes de enviar
    const forms = document.querySelectorAll('form[enctype="multipart/form-data"]');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const fileInput = form.querySelector('input[type="file"]');
            if (fileInput && fileInput.files.length > 0) {
                const file = fileInput.files[0];
                if (file.size > MAX_FILE_SIZE) {
                    e.preventDefault();
                    alert('⚠️ No se puede subir el archivo.\n\nEl archivo excede el límite de 500MB.\nTamaño actual: ' + formatBytes(file.size));
                    return false;
                }
                
                // Mostrar indicador de progreso
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '⏳ Subiendo archivo... Por favor espera';
                }
            }
        });
    });
});

function formatBytes(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
}
</script>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>

