@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'px-4 py-3 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm']) }}>
        {{ $status }}
    </div>
@endif
