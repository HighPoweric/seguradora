<header class="sticky top-0 z-50 bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            @include('components.header.logo')
            
            <!-- Desktop Navigation -->
            @include('components.header.desktop-nav')
            
            <!-- Mobile menu button -->
            @include('components.header.mobile-menu-button')
        </div>
        
        <!-- Mobile Menu -->
        @include('components.header.mobile-menu')
    </div>
</header>
