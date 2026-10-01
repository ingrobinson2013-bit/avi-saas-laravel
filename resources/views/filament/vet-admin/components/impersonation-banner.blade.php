@if(session()->has('impersonator_superadmin_id'))
    <div style="background: linear-gradient(135deg, #c2410c 0%, #9a3412 100%); color: #ffffff !important; padding: 7px 20px; display: flex; align-items: center; justify-content: space-between; font-weight: 700; font-size: 12px; z-index: 99999; width: 100%; box-shadow: 0 2px 4px rgba(0,0,0,0.12);" class="sticky top-0">
        <div style="display: flex; align-items: center; gap: 8px; color: #ffffff;">
            <span style="font-size: 14px;">👑</span>
            <span style="color: #ffffff; letter-spacing: 0.02em;">
                SOPORTE SUPERADMIN: Administrando la clínica <strong style="color: #fef08a; text-decoration: underline;">{{ \Filament\Facades\Filament::getTenant()?->name }}</strong>
            </span>
        </div>

        <a href="/impersonate-clinic-stop" 
           style="background-color: #ffffff !important; color: #9a3412 !important; padding: 4px 12px; border-radius: 8px; font-weight: 800; font-size: 11px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.15); transition: all 0.2s ease;">
            <span>↩️</span>
            <span>Salir de Modo Soporte</span>
        </a>
    </div>
@endif
