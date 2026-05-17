# 📦 WebFusion Digital – Despliegue Automatizado con Vagrant + Docker + WordPress

> Solución de infraestructura reproducible para el despliegue automatizado de sitios WordPress corporativos.

---

## 📐 Arquitectura del sistema

```
Ordenador Local
      │
      ▼
  Vagrant ──────────────────────────────────────────────────────────┐
      │                                                              │
      ▼                                                              │
VM Ubuntu 22.04 (jammy64)                                           │
      │                                                              │
      ▼                                                              │
   Docker                                                            │
   ├── Contenedor: webfusion_db  (MySQL 8.0)                        │
   ├── Contenedor: webfusion_wp  (WordPress 6.5 + Apache)           │
   │       └── Volumen: /wp-content/themes/webfusion ◄──────────┐  │
   └── Contenedor: webfusion_gitsync (alpine/git)                │  │
               └── Clona / actualiza repo de GitHub ─────────────┘  │
                                                               GitHub│
                                                                      │
                             ◄────────────────────────────────────────┘
```

### Componentes

| Componente | Tecnología | Función |
|---|---|---|
| Máquina virtual | Vagrant + VirtualBox | Entorno aislado y reproducible |
| Sistema operativo | Ubuntu 22.04 LTS (jammy64) | Base del sistema |
| Orquestación | Docker Compose | Gestión de contenedores |
| Base de datos | MySQL 8.0 | Almacenamiento de WordPress |
| CMS | WordPress 6.5 + Apache | Servidor web y gestor de contenidos |
| Sincronización | alpine/git | Descarga y actualización del código PHP |
| Control de versiones | GitHub | Repositorio del código del tema |

---

## ⚙️ Funcionamiento del sistema

1. **El desarrollador** ejecuta `vagrant up` desde su ordenador local.
2. **Vagrant** crea una VM Ubuntu y ejecuta `scripts/provision.sh`.
3. **El script de aprovisionamiento**:
   - Instala Docker y Docker Compose en la VM.
   - Clona el repositorio GitHub con los archivos PHP del tema.
   - Copia los archivos al directorio del tema WordPress.
   - Levanta los tres contenedores con `docker-compose up -d`.
4. **WordPress** queda disponible en `http://localhost:8080`.
5. **Para actualizar**, el desarrollador sube cambios a GitHub y ejecuta `vagrant provision`, que repite los pasos 3-4 automáticamente.

---

## 🚀 Instrucciones de despliegue paso a paso

### Prerrequisitos

Instala en tu ordenador:

- [VirtualBox](https://www.virtualbox.org/wiki/Downloads) (versión 6.1 o superior)
- [Vagrant](https://developer.hashicorp.com/vagrant/downloads) (versión 2.3 o superior)
- [Git](https://git-scm.com/downloads)

### Paso 1 – Clonar este repositorio

```bash
git clone https://github.com/TU_USUARIO/TU_REPOSITORIO.git webfusion
cd webfusion
```

### Paso 2 – Configurar la URL del repositorio

Copia el archivo de ejemplo y edítalo con la URL de tu repositorio GitHub:

```bash
cp .env.example .env
# Edita .env y cambia REPO_URL por la URL real de tu repo
```

O edita directamente `scripts/provision.sh` y cambia la variable `REPO_URL`.

### Paso 3 – Levantar el entorno

```bash
vagrant up
```

Este comando:
- Descarga la box `ubuntu/jammy64` (solo la primera vez, ~500 MB)
- Crea y configura la VM
- Instala Docker y Docker Compose
- Clona el repositorio con el código PHP
- Levanta WordPress, MySQL y el servicio de sincronización

El proceso completo tarda entre **5 y 15 minutos** la primera vez.

### Paso 4 – Acceder a WordPress

Abre tu navegador y visita:

```
http://localhost:8080
```

Completa el asistente de instalación de WordPress (solo la primera vez):
- **Nombre del sitio**: WebFusion Digital S.L.
- **Usuario**: admin
- **Contraseña**: (elige una segura)
- **Email**: tu@email.com

### Paso 5 – Activar el tema WebFusion

En el panel de WordPress:
1. Ve a **Apariencia → Temas**
2. Busca el tema **WebFusion** y haz clic en **Activar**

---

## 🔄 Actualización del contenido

### Flujo de trabajo

1. Edita los archivos PHP en tu repositorio GitHub (en local o desde la web de GitHub).
2. Haz commit y push de los cambios:
   ```bash
   git add .
   git commit -m "Actualizar página principal"
   git push origin main
   ```
3. Desde tu ordenador local, ejecuta:
   ```bash
   vagrant provision
   ```
4. El sistema automáticamente:
   - Hace `git pull` del repositorio actualizado.
   - Copia los nuevos archivos PHP al directorio del tema.
   - Reinicia los contenedores si es necesario.
5. Recarga `http://localhost:8080` y verás los cambios aplicados.

---

## 📂 Estructura del repositorio

```
webfusion-project/
├── Vagrantfile                # Configuración de la VM
├── docker-compose.yml         # Definición de contenedores
├── .env.example               # Plantilla de variables de entorno
├── .gitignore
├── README.md                  # Esta documentación
├── scripts/
│   └── provision.sh           # Script de aprovisionamiento automático
└── wp-content/
    ├── index.php              # Plantilla principal de WordPress
    ├── style.css              # Cabecera del tema (requerida por WP)
    └── functions.php          # Funciones del tema WordPress
```

---

## 🛠️ Comandos útiles

| Comando | Descripción |
|---|---|
| `vagrant up` | Crear e iniciar la VM |
| `vagrant provision` | Re-ejecutar el aprovisionamiento (actualizar) |
| `vagrant halt` | Apagar la VM |
| `vagrant destroy` | Eliminar la VM completamente |
| `vagrant ssh` | Conectarse a la VM por SSH |
| `vagrant reload` | Reiniciar la VM |

### Comandos dentro de la VM (`vagrant ssh`)

```bash
# Ver estado de los contenedores
docker-compose -f /opt/webfusion/docker-compose.yml ps

# Ver logs de WordPress
docker logs webfusion_wp

# Ver logs de MySQL
docker logs webfusion_db

# Reiniciar contenedores
cd /opt/webfusion && docker-compose restart
```

---

## 🔧 Resolución de problemas

**El puerto 8080 ya está en uso**
Cambia el puerto en `Vagrantfile`: `host: 8081` (o cualquier puerto libre).

**WordPress no carga tras el primer `vagrant up`**
Espera 30 segundos y recarga. MySQL puede tardar en estar disponible.

**Los cambios de GitHub no se reflejan**
Asegúrate de haber hecho `git push` antes de `vagrant provision`.

**Error de permisos en Docker**
Ejecuta `vagrant ssh` y luego `sudo usermod -aG docker vagrant`, cierra sesión y vuelve a entrar.

---

## 👥 Uso para nuevos desarrolladores

1. Instala VirtualBox y Vagrant.
2. Clona el repositorio.
3. Configura el archivo `.env`.
4. Ejecuta `vagrant up`.
5. Abre `http://localhost:8080`.

No se necesitan conocimientos avanzados de sistemas. Todo el entorno se configura de forma automática.

---

*Documentación generada para WebFusion Digital S.L. – Proyecto de automatización de despliegue web con contenedores.*
