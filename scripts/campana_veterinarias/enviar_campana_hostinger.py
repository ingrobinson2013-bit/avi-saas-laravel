"""
DISPARADOR OFICIAL DE CAMPAÑA - AVI-PLAN VETERINARIAS
Envío automatizado vía Hostinger SMTP (contacto@avipetapp.com)
"""

import argparse
import csv
import email.message
import os
import smtplib
import ssl
import sys
import time
import urllib.parse

SCRIPT_DIR = os.path.dirname(os.path.abspath(__file__))
INPUT_CSV = os.path.join(SCRIPT_DIR, "contactos_veterinarias.csv")
TEMPLATE_HTML = os.path.join(SCRIPT_DIR, "plantilla_avi_plan.html")
LOG_CSV = os.path.join(SCRIPT_DIR, "envios_hostinger_log.csv")

# Credenciales oficiales Hostinger
SMTP_HOST = os.environ.get("SMTP_HOST", "smtp.hostinger.com")
SMTP_PORT = int(os.environ.get("SMTP_PORT", 465))
SMTP_USER = os.environ.get("SMTP_USER", "contacto@avipetapp.com")
SMTP_PASS = os.environ.get("SMTP_PASS", "Ashley2023##")

TU_NUMERO_WHATSAPP = "573235813942"
PAUSA_SEGUNDOS = 4.0  # Pausa entre correos para reputación y evitar antispam

def cargar_plantilla():
    with open(TEMPLATE_HTML, 'r', encoding='utf-8') as f:
        return f.read()

def enviar_correo(server, destinatario, razon_social, municipio, plantilla):
    rs_encoded = urllib.parse.quote(razon_social)
    html = plantilla.replace('{{razon_social}}', razon_social)
    html = html.replace('{{municipio}}', municipio)
    html = html.replace('{{correo_comercial}}', destinatario)
    html = html.replace('{{whatsapp_link_number}}', TU_NUMERO_WHATSAPP)
    html = html.replace('{{razon_social_encoded}}', rs_encoded)

    asunto = f"¿Cómo generar ingresos fijos en {razon_social} sin depender solo de urgencias?"

    msg = email.message.EmailMessage()
    msg['Subject'] = asunto
    msg['From'] = f"AVI-Plan <{SMTP_USER}>"
    msg['To'] = destinatario
    msg['Reply-To'] = SMTP_USER

    texto_plano = (
        f"Hola, equipo de {razon_social}:\n\n"
        f"¿Cómo generar ingresos recurrentes mensuales en tu clínica en {municipio}?\n"
        f"Conoce AVI-Plan: nuestro modelo de membresías preventivas para mascotas.\n"
        f"Visita: https://avipetapp.com o escríbenos por WhatsApp: https://wa.me/{TU_NUMERO_WHATSAPP}\n\n"
        f"Saludos cordiales,\nEquipo AVI-Plan"
    )
    msg.set_content(texto_plano)
    msg.add_alternative(html, subtype='html')

    server.send_message(msg)

def ejecutar_campana(archivo_csv=None, modo_test=None, limite=10, dry_run=False):
    print("============================================================")
    print("DISPARADOR OFICIAL AVI-PLAN (HOSTINGER SMTP)")
    print("============================================================")
    print(f"- Servidor SMTP: {SMTP_HOST}:{SMTP_PORT} (SSL)")
    print(f"- Remitente: {SMTP_USER}")
    print(f"- WhatsApp Asesor: +{TU_NUMERO_WHATSAPP}")
    print(f"- Modo: {'[SIMULACION]' if dry_run else ('[TEST: ' + modo_test + ']' if modo_test else '[ENVIO REAL]')}")
    print("============================================================\n")

    plantilla = cargar_plantilla()

    # Si es modo test, solo enviamos 1 correo al destinatario indicado
    if modo_test:
        contactos = [{
            'razon_social': 'Clínica Veterinaria Prueba Demo',
            'correo_comercial': modo_test,
            'municipio': 'Bogotá / Sabana'
        }]
    else:
        ruta_csv = archivo_csv if archivo_csv and os.path.exists(archivo_csv) else INPUT_CSV
        print(f"- Archivo fuente: {ruta_csv}")
        with open(ruta_csv, 'r', encoding='utf-8') as f:
            reader = csv.DictReader(f, delimiter=';')
            contactos = list(reader)

    print(f"Total contactos cargados: {len(contactos)}")
    if not modo_test:
        print(f"Procesando lote de hasta: {limite} contactos")

    # Iniciar conexión SMTP si no es dry-run
    server = None
    if not dry_run:
        try:
            print("Conectando con Hostinger SMTP...")
            context = ssl.create_default_context()
            server = smtplib.SMTP_SSL(SMTP_HOST, SMTP_PORT, context=context, timeout=15)
            server.login(SMTP_USER, SMTP_PASS)
            print(" Autenticacion SMTP exitosa con Hostinger.\n")
        except Exception as e:
            print(f"[ERROR] Conexion SMTP con Hostinger: {e}")
            return

    # Preparar log
    log_existe = os.path.exists(LOG_CSV)
    f_log = open(LOG_CSV, 'a', encoding='utf-8-sig', newline='')
    log_writer = csv.writer(f_log, delimiter=';')
    if not log_existe:
        log_writer.writerow(['fecha_envio', 'email', 'razon_social', 'municipio', 'estado', 'detalle'])

    enviados = 0
    fallidos = 0

    lista_a_procesar = contactos if modo_test else contactos[:limite]

    for idx, c in enumerate(lista_a_procesar, 1):
        email_dest = (c.get('correo_comercial') or '').strip().lower()
        rs = (c.get('razon_social') or '').strip()
        muni = (c.get('municipio') or 'Cundinamarca').strip()

        if not email_dest or '@' not in email_dest:
            continue

        timestamp = time.strftime('%Y-%m-%d %H:%M:%S')

        if dry_run:
            print(f"[{idx:02d}/{len(lista_a_procesar)}] [SIMULADO] -> {email_dest:<32} | {rs[:30]}")
            log_writer.writerow([timestamp, email_dest, rs, muni, 'SIMULADO', 'OK'])
            enviados += 1
            continue

        try:
            enviar_correo(server, email_dest, rs, muni, plantilla)
            enviados += 1
            print(f"[{idx:02d}/{len(lista_a_procesar)}] [ENVIADO]   -> {email_dest:<32} | {rs[:30]}")
            log_writer.writerow([timestamp, email_dest, rs, muni, 'ENVIADO', 'Entregado a Hostinger'])
            if idx < len(lista_a_procesar):
                time.sleep(PAUSA_SEGUNDOS)
        except Exception as e:
            fallidos += 1
            print(f"[{idx:02d}/{len(lista_a_procesar)}] [ERROR]     -> {email_dest} | {e}")
            log_writer.writerow([timestamp, email_dest, rs, muni, 'ERROR', str(e)])

    if server:
        server.quit()
    f_log.close()

    print("\n" + "=" * 60)
    print("RESUMEN DE EJECUCION:")
    print(f"- Total enviados: {enviados}")
    print(f"- Total fallidos: {fallidos}")
    print(f"- Archivo de auditoria: {LOG_CSV}")
    print("=" * 60)

if __name__ == '__main__':
    parser = argparse.ArgumentParser(description="Despachador de Campaña AVI-Plan Hostinger")
    parser.add_argument('--archivo', type=str, help="Ruta al archivo CSV con contactos")
    parser.add_argument('--test', type=str, help="Enviar un correo de prueba a este email")
    parser.add_argument('--lote', type=int, default=10, help="Cantidad de correos a enviar (default: 10)")
    parser.add_argument('--dry-run', action='store_true', help="Modo simulación sin envío real")

    args = parser.parse_args()
    ejecutar_campana(archivo_csv=args.archivo, modo_test=args.test, limite=args.lote, dry_run=args.dry_run)
