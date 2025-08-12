// Configuración global de la aplicación
window.SegurosPro = {
    // Configuración de la API
    api: {
        baseUrl: '/api',
        timeout: 10000,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        }
    },

    // Configuración de la UI
    ui: {
        animations: {
            duration: 300,
            easing: 'ease-in-out'
        },
        testimonialRotationInterval: 5000,
        scrollOffset: 100
    },

    // Mensajes de la aplicación
    messages: {
        loading: 'Cargando...',
        error: 'Ha ocurrido un error. Por favor, intenta de nuevo.',
        success: 'Operación completada exitosamente.',
        loginRequired: 'Por favor, completa todos los campos',
        invalidEmail: 'Por favor, introduce un email válido',
        loginInProgress: 'Iniciando sesión...'
    },

    // Configuración de validación
    validation: {
        email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        password: {
            minLength: 6,
            requireUppercase: false,
            requireNumbers: false,
            requireSpecialChars: false
        }
    }
};

// Utilidades globales
window.SegurosPro.utils = {
    // Formatear fechas
    formatDate: (date, locale = 'es-ES') => {
        return new Intl.DateTimeFormat(locale).format(new Date(date));
    },

    // Debounce para búsquedas
    debounce: (func, wait) => {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    // Mostrar notificaciones (puedes integrar con Toastr u otra librería)
    notify: (message, type = 'info') => {
        // Por ahora usamos alert, pero se puede cambiar por una librería de notificaciones
        console.log(`${type.toUpperCase()}: ${message}`);
        if (type === 'error') {
            alert(`Error: ${message}`);
        }
    }
};
