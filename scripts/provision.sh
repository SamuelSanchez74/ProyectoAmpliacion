#!/bin/bash
# =============================================================
# provision.sh – Aprovisionamiento automático de la VM
# WebFusion Digital S.L.
# =============================================================
set -euo pipefail

echo "========================================="
echo " Iniciando aprovisionamiento WebFusion..."
echo "========================================="

# ----- 1. Actualizar sistema -----
apt-get update -qq

# ----- 2. Instalar dependencias base -----
apt-get install -y -qq \
  ca-certificates \
  curl \
  gnupg \
  lsb-release \
  git \
  unzip

# ----- 3. Instalar Docker (si no está instalado) -----
if ! command -v docker &>/dev/null; then
  echo "[INFO] Instalando Docker..."
  install -m 0755 -d /etc/apt/keyrings
  curl -fsSL https://download.docker.com/linux/ubuntu/gpg \
    | gpg --dearmor -o /etc/apt/keyrings/docker.gpg
  chmod a+r /etc/apt/keyrings/docker.gpg

  echo \
    "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] \
    https://download.docker.com/linux/ubuntu \
    $(lsb_release -cs) stable" \
    > /etc/apt/sources.list.d/docker.list

  apt-get update -qq
  apt-get install -y -qq docker-ce docker-ce-cli containerd.io docker-compose-plugin
  systemctl enable docker
  systemctl start docker
  usermod -aG docker vagrant
  echo "[INFO] Docker instalado correctamente."
else
  echo "[INFO] Docker ya está instalado. Omitiendo."
fi

# ----- 4. Instalar Docker Compose standalone (CLI clásica) -----
if ! command -v docker-compose &>/dev/null; then
  echo "[INFO] Instalando Docker Compose standalone..."
  COMPOSE_VERSION="2.27.0"
  curl -fsSL \
    "https://github.com/docker/compose/releases/download/v${COMPOSE_VERSION}/docker-compose-linux-x86_64" \
    -o /usr/local/bin/docker-compose
  chmod +x /usr/local/bin/docker-compose
  echo "[INFO] Docker Compose instalado correctamente."
else
  echo "[INFO] Docker Compose ya está instalado. Omitiendo."
fi

# ----- 5. Preparar directorio de trabajo -----
WORKDIR="/opt/webfusion"
mkdir -p "$WORKDIR"
cp /vagrant/docker-compose.yml "$WORKDIR/docker-compose.yml"

# ----- 6. Clonar / actualizar repositorio de contenido -----
REPO_URL="${REPO_URL:-https://github.com/SamuelSanchez74/ProyectoAmpliacion.git}"
REPO_DIR="$WORKDIR/repo"

if [ -d "$REPO_DIR/.git" ]; then
  echo "[INFO] Repositorio ya existe. Actualizando..."
  git -C "$REPO_DIR" pull --rebase
else
  echo "[INFO] Clonando repositorio..."
  git clone "$REPO_URL" "$REPO_DIR"
fi

# ----- 7. Copiar archivos PHP al volumen de WordPress -----
# El volumen wp-content se monta en /opt/webfusion/wp-content
# Los archivos del repo se copian al theme activo de WordPress
THEME_DEST="$WORKDIR/wp-content/themes/webfusion"
mkdir -p "$THEME_DEST"

if [ -d "$REPO_DIR/wp-content" ]; then
  echo "[INFO] Copiando archivos PHP del repositorio al theme..."
  cp -r "$REPO_DIR/wp-content/." "$THEME_DEST/"
else
  echo "[WARN] No se encontró el directorio wp-content en el repositorio."
fi

# ----- 8. Levantar servicios con Docker Compose -----
echo "[INFO] Levantando contenedores..."
cd "$WORKDIR"
docker-compose down --remove-orphans 2>/dev/null || true
docker-compose up -d

echo ""
echo "========================================="
echo " ¡Aprovisionamiento completado!"
echo " WordPress disponible en: http://localhost:8080"
echo "========================================="
