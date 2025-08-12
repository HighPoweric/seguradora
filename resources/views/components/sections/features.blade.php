<!-- Features Section -->
<section id="features" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 fade-in">
            <h2 class="text-3xl font-bold text-blue-900 mb-4">Solución completa para gestión de siniestros</h2>
            <p class="text-gray-600">Optimiza cada etapa del proceso con nuestras herramientas especializadas</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @include('components.sections.features.feature-card', [
                'icon' => 'fas fa-file-upload',
                'title' => 'Carga de Documentos',
                'description' => 'Sube toda la documentación necesaria de forma segura y organizada. Formatos compatibles: PDF, JPG, PNG.',
                'features' => [
                    'Reconocimiento automático de documentos',
                    'Almacenamiento seguro en la nube',
                    'Historial de versiones'
                ]
            ])
            
            @include('components.sections.features.feature-card', [
                'icon' => 'fas fa-video',
                'title' => 'Gestión Multimedia',
                'description' => 'Sube grabaciones de cámaras vehiculares y gestiona todo el material multimedia relacionado con el siniestro.',
                'features' => [
                    'Visualizador integrado de videos',
                    'Marcación de momentos clave',
                    'Compartir fragmentos específicos'
                ]
            ])
            
            @include('components.sections.features.feature-card', [
                'icon' => 'fas fa-file-invoice',
                'title' => 'Informes Automatizados',
                'description' => 'Genera informes completos para tu aseguradora con un solo clic, ahorrando tiempo y reduciendo errores.',
                'features' => [
                    'Plantillas personalizables',
                    'Datos extraídos automáticamente',
                    'Exportación en múltiples formatos'
                ]
            ])
        </div>
    </div>
</section>
