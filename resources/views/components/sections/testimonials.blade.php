<!-- Testimonials -->
<section id="testimonials" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 fade-in">
            <h2 class="text-3xl font-bold text-blue-900 mb-4">Lo que dicen nuestros clientes</h2>
            <p class="text-gray-600">Profesionales del sector confían en SegurosPro para gestionar sus siniestros</p>
        </div>
        
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-md p-8">
                <div class="text-center mb-8">
                    <i class="fas fa-quote-left text-blue-200 text-4xl"></i>
                </div>
                
                <div class="text-center mb-8">
                    <p class="text-gray-700 text-xl italic" x-text="testimonials[currentTestimonial].content"></p>
                </div>
                
                <div class="text-center">
                    <div class="font-semibold text-blue-900 text-lg" x-text="testimonials[currentTestimonial].name"></div>
                    <div class="text-gray-600" x-text="testimonials[currentTestimonial].role + ', ' + testimonials[currentTestimonial].company"></div>
                </div>
                
                <div class="flex justify-center mt-8 space-x-2">
                    <template x-for="(testimonial, index) in testimonials">
                        <button @click="currentTestimonial = index" 
                            :class="{'bg-blue-900': currentTestimonial === index, 'bg-blue-200': currentTestimonial !== index}" 
                            class="w-3 h-3 rounded-full transition-colors"></button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</section>
