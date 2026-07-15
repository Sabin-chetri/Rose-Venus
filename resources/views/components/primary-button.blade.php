<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full px-8 py-4 bg-gradient-to-r from-rose-800 to-rose-700 hover:from-rose-900 hover:to-rose-800 text-white text-sm font-medium tracking-wider uppercase rounded-xl transition-all duration-300 shadow-lg shadow-rose-900/25 hover:shadow-rose-900/40 hover:-translate-y-0.5']) }}>
    {{ $slot }}
</button>
