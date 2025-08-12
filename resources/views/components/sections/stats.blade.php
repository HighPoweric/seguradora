<!-- Stats Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @include('components.sections.stats.stat-item', ['number' => '40%', 'text' => 'Reducción en tiempo de gestión'])
            @include('components.sections.stats.stat-item', ['number' => '98%', 'text' => 'Satisfacción del cliente'])
            @include('components.sections.stats.stat-item', ['number' => '500+', 'text' => 'Siniestros gestionados'])
            @include('components.sections.stats.stat-item', ['number' => '24/7', 'text' => 'Soporte disponible'])
        </div>
    </div>
</section>
