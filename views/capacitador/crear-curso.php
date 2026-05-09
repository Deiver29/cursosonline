<?php ob_start(); ?>

<div class="container dashboard">
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="<?php echo BASE_URL; ?>capacitador/dashboard">📊 Panel Principal</a></li>
            <li><a href="<?php echo BASE_URL; ?>capacitador/misCursos">📚 Mis Cursos</a></li>
            <li><a href="<?php echo BASE_URL; ?>capacitador/crearCurso" class="active">➕ Crear Curso</a></li>
            <li><a href="<?php echo BASE_URL; ?>">🏠 Inicio</a></li>
        </ul>
    </aside>
    
    <div class="dashboard-content">
        <h1 class="mb-4">Crear Nuevo Curso</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>capacitador/crearCurso">
                    <div class="form-group">
                        <label class="form-label">Título del Curso</label>
                        <input type="text" name="titulo" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="6" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Categoría</label>
                        <select name="categoria_id" class="form-control" required>
                            <option value="">Selecciona una categoría</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>"><?php echo $cat['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Idioma del Curso</label>
                        <select name="idioma" class="form-control" required>
                            <optgroup label="Más Populares">
                                <option value="es">🇪🇸 Español</option>
                                <option value="en">🇬🇧 English</option>
                                <option value="zh">🇨🇳 中文 (Chino)</option>
                                <option value="hi">🇮🇳 हिन्दी (Hindi)</option>
                                <option value="ar">🇸🇦 العربية (Árabe)</option>
                                <option value="pt">🇵🇹 Português</option>
                                <option value="fr">🇫🇷 Français</option>
                                <option value="de">🇩🇪 Deutsch</option>
                                <option value="ja">🇯🇵 日本語 (Japonés)</option>
                                <option value="ru">🇷🇺 Русский (Ruso)</option>
                            </optgroup>
                            <optgroup label="Europa">
                                <option value="it">🇮🇹 Italiano</option>
                                <option value="pl">🇵🇱 Polski (Polaco)</option>
                                <option value="nl">🇳🇱 Nederlands (Holandés)</option>
                                <option value="uk">🇺🇦 Українська (Ucraniano)</option>
                                <option value="ro">🇷🇴 Română (Rumano)</option>
                                <option value="cs">🇨🇿 Čeština (Checo)</option>
                                <option value="sv">🇸🇪 Svenska (Sueco)</option>
                                <option value="el">🇬🇷 Ελληνικά (Griego)</option>
                                <option value="hu">🇭🇺 Magyar (Húngaro)</option>
                                <option value="da">🇩🇰 Dansk (Danés)</option>
                                <option value="no">🇳🇴 Norsk (Noruego)</option>
                                <option value="fi">🇫🇮 Suomi (Finlandés)</option>
                            </optgroup>
                            <optgroup label="Asia">
                                <option value="ko">🇰🇷 한국어 (Coreano)</option>
                                <option value="th">🇹🇭 ไทย (Tailandés)</option>
                                <option value="vi">🇻🇳 Tiếng Việt (Vietnamita)</option>
                                <option value="id">🇮🇩 Bahasa Indonesia</option>
                                <option value="ms">🇲🇾 Bahasa Melayu (Malayo)</option>
                                <option value="fil">🇵🇭 Filipino</option>
                                <option value="tr">🇹🇷 Türkçe (Turco)</option>
                                <option value="he">🇮🇱 עברית (Hebreo)</option>
                                <option value="fa">🇮🇷 فارسی (Persa)</option>
                            </optgroup>
                            <optgroup label="América">
                                <option value="pt-br">🇧🇷 Português (Brasil)</option>
                                <option value="en-us">🇺🇸 English (US)</option>
                            </optgroup>
                            <optgroup label="África">
                                <option value="sw">🇰🇪 Kiswahili (Suajili)</option>
                                <option value="af">🇿🇦 Afrikaans</option>
                            </optgroup>
                            <optgroup label="Otros">
                                <option value="bn">🇧🇩 বাংলা (Bengalí)</option>
                                <option value="ur">🇵🇰 اردو (Urdu)</option>
                                <option value="pa">🇮🇳 ਪੰਜਾਬੀ (Panyabí)</option>
                                <option value="ta">🇮🇳 தமிழ் (Tamil)</option>
                                <option value="te">🇮🇳 తెలుగు (Telugu)</option>
                                <option value="mr">🇮🇳 मराठी (Maratí)</option>
                            </optgroup>
                        </select>
                        <small style="color: #6b7280;">Selecciona el idioma principal del curso</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Nivel</label>
                        <select name="nivel" class="form-control" required>
                            <option value="basico">Básico</option>
                            <option value="intermedio">Intermedio</option>
                            <option value="avanzado">Avanzado</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Precio</label>
                        <input type="number" name="precio" class="form-control" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Moneda</label>
                        <select name="moneda" class="form-control" required>
                            <option value="USD">USD - Dólar</option>
                            <option value="EUR">EUR - Euro</option>
                            <option value="GBP">GBP - Libra</option>
                            <option value="MXN">MXN - Peso Mexicano</option>
                            <option value="ARS">ARS - Peso Argentino</option>
                            <option value="COP">COP - Peso Colombiano</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">URL de Imagen de Portada</label>
                        <input type="text" name="imagen" class="form-control">
                        <small style="color: #6b7280;">URL de la imagen de portada del curso</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Crear Curso</button>
                    <a href="<?php echo BASE_URL; ?>capacitador/dashboard" class="btn btn-outline">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>

