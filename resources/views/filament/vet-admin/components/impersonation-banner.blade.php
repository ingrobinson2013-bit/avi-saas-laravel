@if(session()->has('impersonator_superadmin_id'))
    <div style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 50%, #9a3412 100%); color: #ffffff !important; padding: 12px 24px; display: flex; align-items: center; justify-content: space-between; font-weight: 800; font-size: 13px; z-index: 99999; width: 100%; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.15);" class="sticky top-0">
        <div style="display: flex; align-items: center; gap: 10px; color: #ffffff;">
            <span style="font-size: 18px;">👑</span>
            <span style="color: #ffffff; letter-spacing: 0.025em;">
                MODO SOPORTE SUPERADMIN: Estás administrando la clínica <strong style="color: #fef08a; text-decoration: underline;">{{ \Filament\Facades\Filament::getTenant()?->name }}</strong>
            </span>
        </div>

        <a href="/impersonate-clinic-stop" 
           style="background-color: #ffffff !important; color: #9a3412 !important; padding: 6px 16px; border-radius: 10px; font-weight: 800; font-size: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.2); transition: all 0.2s ease;">
            <span>↩️</span>
            <span>Salir y Volver al SuperAdmin</span>
        </a>
    </div>
@endif
