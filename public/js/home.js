// Datos de Alpine.js para el componente principal
document.addEventListener('alpine:init', () => {
    Alpine.data('homePageData', () => ({
        mobileMenuOpen: false,
        loginModalOpen: false,
        currentTestimonial: 0,
        testimonials: [
            {
                name: 'Carlos Martínez', 
                role: 'Director de Siniestros', 
                company: 'Aseguradora SegurTotal', 
                content: 'SegurosPro ha reducido nuestro tiempo de gestión de siniestros en un 40%. La automatización de informes es impresionante.'
            },
            {
                name: 'Ana López', 
                role: 'Gerente de Operaciones', 
                company: 'Correduría ProActiva', 
                content: 'La interfaz intuitiva y las herramientas de seguimiento nos permiten ofrecer un servicio más eficiente a nuestros clientes.'
            },
            {
                name: 'Javier Ruiz', 
                role: 'Perito de Siniestros', 
                company: 'Peritajes Profesionales SL', 
                content: 'La capacidad de gestionar toda la documentación y multimedia en una sola plataforma ha simplificado enormemente nuestro trabajo.'
            }
        ],

        // Métodos para manejar el carrusel de testimonios
        nextTestimonial() {
            this.currentTestimonial = (this.currentTestimonial + 1) % this.testimonials.length;
        },

        prevTestimonial() {
            this.currentTestimonial = this.currentTestimonial === 0 ? this.testimonials.length - 1 : this.currentTestimonial - 1;
        },

        // Auto-rotar testimonios cada 5 segundos
        startTestimonialRotation() {
            setInterval(() => {
                this.nextTestimonial();
            }, 5000);
        },

        // Inicializar cuando se monta el componente
        init() {
            this.startTestimonialRotation();
        }
    }));
});

// Animaciones desactivadas para evitar problemas de ocultamiento
// Los elementos siempre serán visibles por defecto
document.addEventListener('DOMContentLoaded', function() {
    // No aplicar intersection observer para evitar conflictos
    console.log('Animaciones de scroll desactivadas para prevenir ocultamiento de secciones');
});

// Smooth scrolling para enlaces internos
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Funciones auxiliares para el formulario de login
function handleLoginSubmit(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const email = formData.get('email');
    const password = formData.get('password');
    const remember = formData.get('remember');
    
    // Agregar estado de loading
    const submitButton = event.target.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    submitButton.textContent = 'Iniciando sesión...';
    submitButton.disabled = true;
    submitButton.classList.add('loading');
    
    // Ejemplo de validación básica
    if (!email || !password) {
        alert('Por favor, completa todos los campos');
        resetLoginButton(submitButton, originalText);
        return;
    }
    
    // Validación de email
    if (!isValidEmail(email)) {
        alert('Por favor, introduce un email válido');
        resetLoginButton(submitButton, originalText);
        return;
    }
    
    // Simular llamada a API
    setTimeout(() => {
        // Aquí iría la llamada a tu API de autenticación
        console.log('Login attempt:', { email, password, remember });
        
        // Por ahora, solo simularemos el proceso
        alert('Funcionalidad de login en desarrollo');
        resetLoginButton(submitButton, originalText);
    }, 2000);
}

function resetLoginButton(button, originalText) {
    button.textContent = originalText;
    button.disabled = false;
    button.classList.remove('loading');
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Funciones para mejorar la UX
function initializeParallaxEffect() {
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.hero-gradient');
        
        parallaxElements.forEach(element => {
            const speed = 0.5;
            element.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });
}

// Lazy loading para imágenes
function initializeLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                observer.unobserve(img);
            }
        });
    });

    images.forEach(img => imageObserver.observe(img));
}

// Inicializar todas las funcionalidades cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    initializeParallaxEffect();
    initializeLazyLoading();
});
