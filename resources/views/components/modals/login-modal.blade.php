<div x-show="loginModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
    <div class="login-modal bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden" 
        x-show="loginModalOpen" 
        @click.away="loginModalOpen = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95">
        
        <!-- Modal Header -->
        @include('components.modals.login-modal.header')
        
        <!-- Modal Body -->
        @include('components.modals.login-modal.form')
        
        <!-- Modal Footer -->
        @include('components.modals.login-modal.footer')
    </div>
</div>
