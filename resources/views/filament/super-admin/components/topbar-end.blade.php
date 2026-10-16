@php
    $user = auth()->user();
    $name = $user?->name ?? 'Robinson Naranjo';
    $email = $user?->email ?? 'superadmin@avipetapp.com';
    $role = 'Superadmin';
    // Compute initials
    $words = explode(' ', trim($name));
    $initials = '';
    foreach (array_slice($words, 0, 2) as $w) {
        $initials .= mb_strtoupper(mb_substr($w, 0, 1));
    }
    if (empty($initials)) {
        $initials = 'RN';
    }
@endphp

<div class="flex items-center gap-3 shrink-0">
    <!-- Notification Bell with Blue Dot matching Mockup -->
    <div class="relative">
        <a href="/super-admin/prospecto-veterinarias" 
           title="Notificaciones de la plataforma"
           class="relative p-2 rounded-full text-slate-500 hover:text-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition block">
            <svg class="w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg>
            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 rounded-full bg-blue-500 ring-2 ring-white dark:ring-slate-900"></span>
        </a>
    </div>

    <!-- User Profile Badge matching Mockup -->
    <div class="flex items-center gap-2.5 pl-1">
        <div class="w-8 h-8 rounded-full bg-teal-800 text-teal-100 font-bold text-xs flex items-center justify-center shrink-0 shadow-2xs">
            {{ $initials }}
        </div>
        <div class="hidden sm:flex flex-col text-left leading-tight shrink-0">
            <span class="text-xs font-bold text-slate-800 dark:text-slate-100 truncate max-w-[150px]">
                {{ $name }}
            </span>
            <span class="text-[10.5px] font-medium text-slate-400 dark:text-slate-500 mt-0.5">
                {{ $role }}
            </span>
        </div>
    </div>
</div>
