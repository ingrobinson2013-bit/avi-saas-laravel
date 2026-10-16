{{-- Central Search Bar matching Superadmin Mockup --}}
<div class="hidden md:flex items-center justify-center w-full max-w-md mx-auto">
    <div class="relative w-full">
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <form action="/super-admin/tenants" method="GET" class="w-full">
            <input type="text" 
                   name="tableSearch" 
                   placeholder="Buscar clínicas, usuarios, planes..." 
                   class="w-full pl-9 pr-4 py-1.5 text-xs rounded-lg border border-slate-200/90 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-800 text-slate-800 dark:text-slate-200 focus:outline-hidden focus:ring-2 focus:ring-teal-500 focus:border-transparent transition placeholder:text-slate-400 shadow-2xs" />
        </form>
    </div>
</div>
