# scripts/hostinger-helper.py
import os
import sys
import string
import random
import re
from playwright.sync_api import sync_playwright

def generate_password(length=18):
    # Generar contraseña segura con letras y números
    chars = string.ascii_letters + string.digits
    return "".join(random.choice(chars) for _ in range(length))

def update_env_file(db_name, db_user, db_pass, db_host):
    env_path = os.path.join(os.path.dirname(os.path.dirname(__file__)), ".env")
    if not os.path.exists(env_path):
        content = ""
    else:
        with open(env_path, "r", encoding="utf-8") as f:
            content = f.read()

    # Añadir o reemplazar variables de Hostinger
    vars_to_set = {
        "HOSTINGER_DB_NAME": db_name,
        "HOSTINGER_DB_USER": db_user,
        "HOSTINGER_DB_PASS": db_pass,
        "HOSTINGER_DB_HOST": db_host
    }

    for key, val in vars_to_set.items():
        pattern = re.compile(rf"^{key}=.*$", re.MULTILINE)
        if pattern.search(content):
            content = pattern.sub(f'{key}="{val}"', content)
        else:
            content += f'\n{key}="{val}"'

    with open(env_path, "w", encoding="utf-8") as f:
        f.write(content.strip() + "\n")
    print("==> Archivo .env actualizado con las credenciales de Hostinger.")

def main():
    db_pass = generate_password()
    print("==> Contraseña de base de datos generada para Hostinger:", db_pass)

    user_data_dir = os.path.join(os.path.dirname(os.path.dirname(__file__)), "staging", "chrome_profile")
    
    with sync_playwright() as p:
        print("==> Iniciando navegador Chromium (modo interactivo)...")
        context = p.chromium.launch_persistent_context(
            user_data_dir=user_data_dir,
            headless=False,
            viewport={"width": 1280, "height": 800}
        )
        
        page = context.new_page()
        page.goto("https://hpanel.hostinger.com/")
        
        print("\n" + "="*80)
        print("INSTRUCCIONES:")
        print("1. Inicia sesión en el navegador que se acaba de abrir en tu pantalla.")
        print("2. Una vez que estés en el panel principal (hPanel), presiona ENTER en esta consola para continuar.")
        print("="*80 + "\n")
        
        input("Presiona ENTER aquí una vez que hayas iniciado sesión...")
        
        # Ir a la página de sitios web
        print("==> Navegando a la lista de sitios web...")
        page.goto("https://hpanel.hostinger.com/websites")
        page.wait_for_load_state("networkidle")
        
        print("\n" + "="*80)
        print("INSTRUCCIONES:")
        print("1. Si aún no has añadido el dominio 'mitsachile.com', hazlo ahora en el panel de Hostinger.")
        print("2. Una vez que 'mitsachile.com' figure en tu lista de sitios web, presiona ENTER aquí para continuar.")
        print("="*80 + "\n")
        
        input("Presiona ENTER aquí una vez que 'mitsachile.com' esté agregado en Hostinger...")
        
        # Intentar navegar directamente a la sección de bases de datos
        db_url = "https://hpanel.hostinger.com/hosting/mitsachile.com/databases/mysql"
        print(f"==> Navegando a la sección de bases de datos MySQL para mitsachile.com...")
        page.goto(db_url)
        page.wait_for_load_state("networkidle")
        
        print("\nIntentando automatizar la creación de la base de datos...")
        print("Buscando el formulario de creación en la página actual...")
        
        db_created = False
        scraped_db_name = ""
        scraped_db_user = ""
        
        try:
            # Intentar encontrar selectores comunes en hPanel
            # Buscamos inputs de base de datos, usuario y password
            # Habitualmente tienen placeholders o ids relacionados con dbname, username, password
            dbname_input = page.locator("input[name='dbname'], input[placeholder*='database'], input[placeholder*='Base de datos']").first
            dbuser_input = page.locator("input[name='username'], input[placeholder*='user'], input[placeholder*='Usuario']").first
            dbpass_input = page.locator("input[name='password'], input[placeholder*='password'], input[placeholder*='Contraseña']").first
            
            if dbname_input.is_visible(timeout=5000):
                dbname_input.fill("mitsa")
                dbuser_input.fill("mitsa")
                dbpass_input.fill(db_pass)
                
                # Buscar el botón de enviar
                submit_btn = page.locator("button[type='submit'], button:has-text('Create'), button:has-text('Crear')").first
                submit_btn.click()
                
                print("==> Se rellenó y envió el formulario de creación de base de datos.")
                print("Esperando confirmación de creación...")
                page.wait_for_timeout(5000)
                
                # Intentar leer las credenciales finales de la tabla de bases de datos creadas
                # Generalmente Hostinger lista las BD creadas abajo con el prefijo incluido
                # Buscamos texto que coincida con u[0-9]+_mitsa
                page.wait_for_load_state("networkidle")
                body_text = page.content()
                
                matches = re.findall(r"u\d+_mitsa", body_text)
                if matches:
                    # Hostinger suele usar el mismo nombre para la BD y el usuario en creaciones simples
                    unique_matches = list(set(matches))
                    print(f"Bases de datos/usuarios detectados con prefijo: {unique_matches}")
                    if len(unique_matches) >= 1:
                        scraped_db_name = unique_matches[0]
                        scraped_db_user = unique_matches[0]
                        db_created = True
                        print("==> Base de datos detectada automáticamente.")
        except Exception as e:
            print(f"Nota: No se pudo completar la automatización del formulario (Detalle: {e})")
            
        if not db_created:
            print("\n" + "="*80)
            print("AUTOMATIZACIÓN FALLIDA (Diseño de Hostinger diferente o requiere intervención manual)")
            print("Por favor, crea la base de datos MANUALMENTE en el navegador que tienes abierto:")
            print(" - Nombre de base de datos sugerido: mitsa")
            print(" - Usuario sugerido: mitsa")
            print(f" - Contraseña sugerida: {db_pass}")
            print("\nUna vez creada, copia y pega aquí los datos finales que te entregue Hostinger:")
            print("="*80 + "\n")
            
            scraped_db_name = input("Nombre completo de la base de datos (ej: u549101671_mitsa): ").strip()
            scraped_db_user = input("Nombre completo del usuario de la base de datos (ej: u549101671_mitsa): ").strip()
            
        # El host en Hostinger siempre es localhost o 127.0.0.1
        update_env_file(scraped_db_name, scraped_db_user, db_pass, "127.0.0.1")
        
        print("\n==> Configuración de Hostinger obtenida y guardada.")
        print("Cerrando navegador...")
        context.close()

if __name__ == "__main__":
    main()
