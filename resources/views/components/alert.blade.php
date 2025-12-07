@props([
    'type' => session()->has('success') ? 'success' : (session()->has('error') ? 'error' : 'info'),
    'message' => session('success') ?? session('error') ?? ''
])

@if ($message || $errors->any() )
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 3000)" 
        x-show="show"
        x-transition
        class="fixed top-4 right-4 z-50 w-full max-w-sm"
    >
        <div
            @class([
                'flex items-center p-4 text-sm border rounded-lg shadow-md',
                'bg-green-100 text-green-800' => $type === 'success',
                'bg-red-100 text-red-800' => $type === 'error',
                'bg-gray-100 text-gray-800' => !in_array($type, ['success', 'error']),
            ])
            role="alert">

            <svg class="shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
            </svg>
            @if ($message)
            <div>
                <span class="font-medium">Sukses!</span> {{ $message }}
            </div>
            @endif

            @if ($errors->any())
            <ul>
                @foreach ( $errors->all() as $errors )     
                <li>
                    <span class="font-medium">Error!</span> {{ $errors }}
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
@endif