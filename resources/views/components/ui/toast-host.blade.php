{{--
    Drop-in Toastr replacement. Place once in layouts/app.blade.php before </body>.
    Listens for: $dispatch('toast', ['type' => 'success|error|warning|info', 'message' => '...'])
    Also reads Livewire flash session keys: session('success'), session('error'), session('warning'), session('info').
--}}

@php
    $sessionToasts = [];
    foreach (['success', 'error', 'warning', 'info'] as $type) {
        if (session($type)) {
            $sessionToasts[] = ['type' => $type, 'message' => session($type)];
        }
    }
@endphp

<div
    x-data="{
        toasts: @js($sessionToasts),
        add(type, message) {
            const id = Date.now();
            this.toasts.push({ id, type, message });
            setTimeout(() => this.remove(id), 4500);
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        },
    }"
    @toast.window="add($event.detail.type ?? 'info', $event.detail.message)"
    class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 w-80 max-w-[calc(100vw-2rem)] pointer-events-none"
    aria-live="polite"
    aria-atomic="false"
>
    <template x-for="toast in toasts" :key="toast.id ?? toast.type + toast.message">
        <div
            x-show="true"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="pointer-events-auto flex items-start gap-3 rounded-lg px-4 py-3 shadow-lg border text-sm font-medium"
            :class="{
                'bg-white dark:bg-slate-800 border-emerald-200 dark:border-emerald-700 text-emerald-800 dark:text-emerald-300': toast.type === 'success',
                'bg-white dark:bg-slate-800 border-rose-200 dark:border-rose-700 text-rose-800 dark:text-rose-300':           toast.type === 'error',
                'bg-white dark:bg-slate-800 border-amber-200 dark:border-amber-700 text-amber-800 dark:text-amber-300':       toast.type === 'warning',
                'bg-white dark:bg-slate-800 border-sky-200 dark:border-sky-700 text-sky-800 dark:text-sky-300':               toast.type === 'info',
            }"
        >
            <svg class="w-5 h-5 shrink-0 mt-px" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <template x-if="toast.type === 'success'">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </template>
                <template x-if="toast.type === 'error'">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </template>
                <template x-if="toast.type === 'warning'">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </template>
                <template x-if="toast.type === 'info'">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </template>
            </svg>

            <span class="flex-1 leading-snug" x-text="toast.message"></span>

            <button @click="remove(toast.id)" class="shrink-0 opacity-50 hover:opacity-100 transition-opacity -mr-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
                <span class="sr-only">Cerrar</span>
            </button>
        </div>
    </template>
</div>
