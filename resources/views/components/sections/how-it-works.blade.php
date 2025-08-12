<!-- How it Works -->
<section id="how-it-works" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 fade-in">
            <h2 class="text-3xl font-bold text-blue-900 mb-4">Cómo funciona SegurosPro</h2>
            <p class="text-gray-600">Un proceso simplificado en cuatro pasos sencillos</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @include('components.sections.how-it-works.step', [
                'number' => '1',
                'title' => 'Registra el siniestro',
                'description' => 'Completa los datos básicos del incidente vehicular para iniciar el proceso.'
            ])
            
            @include('components.sections.how-it-works.step', [
                'number' => '2',
                'title' => 'Sube documentación',
                'description' => 'Adjunta fotos, videos, informes policiales y cualquier documento relevante.'
            ])
            
            @include('components.sections.how-it-works.step', [
                'number' => '3',
                'title' => 'Seguimiento en tiempo real',
                'description' => 'Monitorea el estado de tu caso y recibe notificaciones de actualizaciones.'
            ])
            
            @include('components.sections.how-it-works.step', [
                'number' => '4',
                'title' => 'Genera informes',
                'description' => 'Crea reportes completos para tu aseguradora con un solo clic.'
            ])
        </div>
    </div>
</section>
