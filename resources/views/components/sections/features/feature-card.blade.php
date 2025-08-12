<div class="feature-card bg-white rounded-xl shadow-md p-8 border border-gray-100">
    <div class="bg-blue-50 w-14 h-14 rounded-lg flex items-center justify-center mb-6">
        <i class="{{ $icon }} text-blue-900 text-2xl"></i>
    </div>
    <h3 class="text-xl font-semibold text-blue-900 mb-3">{{ $title }}</h3>
    <p class="text-gray-600 mb-4">{{ $description }}</p>
    <ul class="text-gray-600 text-sm space-y-2">
        @foreach($features as $feature)
            <li class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-2"></i> {{ $feature }}
            </li>
        @endforeach
    </ul>
</div>
