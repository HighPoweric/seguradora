<footer class="py-12 bg-gray-900 text-gray-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Company Info -->
            @include('components.footer.company-info')
            
            <!-- Quick Links -->
            @include('components.footer.quick-links')
            
            <!-- Resources -->
            @include('components.footer.resources')
            
            <!-- Contact -->
            @include('components.footer.contact-info')
        </div>
        
        <!-- Copyright -->
        @include('components.footer.copyright')
    </div>
</footer>
