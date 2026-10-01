@if(session()->has('impersonator_superadmin_id'))
    <div style="background-color: #0f172a; color: #f8fafc !important; border-bottom: 2px solid #3b82f6; padding: 6px 20px; display: flex; align-items: center; justify-content: space-between; font-weight: 700; font-size: 11px; z-index: 99999; width: 100%; box-shadow: 0 1px 3px rgba(0,0,0,0.1);" class="sticky top-0">
        <div style="display: flex; align-items: center; gap: 8px;">
            <span style="background-color: #1e293b; color: #38bdf8; border: 1px solid #334155; padding: 2px 8px; border-radius: 9999px; font-weight: 800; font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em;">
                ● Modo Soporte
            </span>
            <span style="color: #94a3b8;">
                Administrando clínica: <strong style="color: #ffffff;">{{ \Filament\Facades\Filament::getTenant()?->name }}</strong>
            </span>
        </div>

        <a href="/impersonate-clinic-stop" 
           style="background-color: #1e293b; color: #f1f5f9; border: 1px solid #475569; padding: 3px 10px; border-radius: 6px; font-weight: 700; font-size: 11px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s ease;">
            <span>✕</span>
            <span>Salir de Soporte</span>
        </a>
    </div>
@endif
