<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-secondary border border-transparent font-semibold text-xs text-white uppercase hover:bg-secondary active:bg-secondary focus:outline-none focus:border-secondary focus:ring focus:ring-secondary disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
