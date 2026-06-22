<?php
// 1. Ruta de tu carpeta de fotos
$ruta_carpeta = 'img/'; 

// 2. Escanea la carpeta buscando imágenes válidas
$imagenes = glob($ruta_carpeta . "*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería con Lightbox</title>
    <style>
        /* --- ESTILOS DE LA GALERÍA --- */
        .galeria-automatica {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .foto-caja {
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            aspect-ratio: 1 / 1;
            cursor: pointer;
        }
        .foto-caja img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
            display: block;
        }
        .foto-caja img:hover {
            transform: scale(1.05);
        }

        /* --- ESTILOS DEL LIGHTBOX (PANTALLA COMPLETA) --- */
        .lightbox {
            display: none; /* Oculto por defecto */
            position: fixed;
            z-index: 999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            justify-content: center;
            align-items: center;
        }
        .lightbox img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            border-radius: 4px;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
            animation: aparecer 0.3s ease;
        }
        .lightbox-cerrar {
            position: absolute;
            top: 20px;
            right: 30px;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            user-select: none;
        }
        
        @keyframes aparecer {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>

    <h1 style="text-align: center; font-family: sans-serif; margin-top: 40px;">Mi Galería de Fotos</h1>

    <!-- Contenedor de la Galería -->
    <div class="galeria-automatica">
        <?php
        if (!empty($imagenes)) {
            foreach ($imagenes as $imagen) {
                $nombre_archivo = basename($imagen);
                echo '<div class="foto-caja" onclick="abrirLightbox(\'' . htmlspecialchars($imagen) . '\')">';
                echo '<img src="' . htmlspecialchars($imagen) . '" alt="' . htmlspecialchars($nombre_archivo) . '" loading="lazy">';
                echo '</div>';
            }
        } else {
            echo '<p style="grid-column: 1/-1; text-align: center;">No se encontraron imágenes en la carpeta "img/".</p>';
        }
        ?>
    </div>

    <!-- Estructura del Lightbox -->
    <div id="miLightbox" class="lightbox" onclick="cerrarLightbox()">
        <span class="lightbox-cerrar" onclick="cerrarLightbox()">&times;</span>
        <img id="imagenLightbox" src="" alt="Imagen ampliada">
    </div>

    <!-- Script del Lightbox -->
    <script>
        const lightbox = document.getElementById('miLightbox');
        const imagenLightbox = document.getElementById('imagenLightbox');

        function abrirLightbox(rutaImagen) {
            imagenLightbox.src = rutaImagen;
            lightbox.style.display = 'flex';
        }

        function cerrarLightbox() {
            lightbox.style.display = 'none';
            imagenLightbox.src = ''; // Limpia la ruta al cerrar
        }

        // Permite cerrar también pulsando la tecla Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') cerrarLightbox();
        });
    </script>

</body>
</html>