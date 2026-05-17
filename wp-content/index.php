<?php
/**
 * Template Name: Página Principal – WebFusion Digital S.L.
 * Description:   Plantilla principal del sitio corporativo.
 *
 * @package WebFusion
 */

get_header(); ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo('name'); ?> – Desarrollo Web Profesional</title>
  <?php wp_head(); ?>
  <style>
    /* ── Reset básico ───────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body   { font-family: 'Segoe UI', Arial, sans-serif; color: #222; background: #f9f9f9; }
    a      { color: #0073aa; text-decoration: none; }
    a:hover{ text-decoration: underline; }

    /* ── Header ─────────────────────────────── */
    .site-header {
      background: #0073aa;
      color: #fff;
      padding: 1.5rem 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .site-header h1 { font-size: 1.8rem; letter-spacing: 1px; }
    .site-header nav a { color: #fff; margin-left: 1.5rem; font-size: 0.95rem; }

    /* ── Hero ────────────────────────────────── */
    .hero {
      background: linear-gradient(135deg, #0073aa 0%, #005177 100%);
      color: #fff;
      text-align: center;
      padding: 5rem 2rem;
    }
    .hero h2   { font-size: 2.8rem; margin-bottom: 1rem; }
    .hero p    { font-size: 1.2rem; max-width: 600px; margin: 0 auto 2rem; opacity: .9; }
    .hero .btn {
      display: inline-block;
      background: #fff;
      color: #0073aa;
      padding: .8rem 2rem;
      border-radius: 30px;
      font-weight: bold;
      font-size: 1rem;
      transition: transform .2s;
    }
    .hero .btn:hover { transform: scale(1.05); text-decoration: none; }

    /* ── Servicios ───────────────────────────── */
    .services {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1.5rem;
      max-width: 1100px;
      margin: 3rem auto;
      padding: 0 2rem;
    }
    .service-card {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,.08);
      padding: 2rem 1.5rem;
      text-align: center;
      transition: box-shadow .2s;
    }
    .service-card:hover { box-shadow: 0 4px 16px rgba(0,115,170,.18); }
    .service-card .icon { font-size: 2.5rem; margin-bottom: 1rem; }
    .service-card h3    { color: #0073aa; margin-bottom: .5rem; }
    .service-card p     { font-size: .9rem; color: #555; line-height: 1.5; }

    /* ── Sobre nosotros ──────────────────────── */
    .about {
      background: #fff;
      padding: 3rem 2rem;
      text-align: center;
      max-width: 800px;
      margin: 0 auto 3rem;
    }
    .about h2   { color: #0073aa; margin-bottom: 1rem; font-size: 2rem; }
    .about p    { line-height: 1.7; color: #444; }

    /* ── Contacto ────────────────────────────── */
    .contact {
      background: #f0f7fb;
      padding: 3rem 2rem;
      text-align: center;
    }
    .contact h2       { color: #0073aa; margin-bottom: 1rem; font-size: 2rem; }
    .contact .details { font-size: 1rem; color: #444; line-height: 2; }

    /* ── Footer ──────────────────────────────── */
    .site-footer {
      background: #222;
      color: #aaa;
      text-align: center;
      padding: 1.2rem;
      font-size: .85rem;
    }
  </style>
</head>

<body <?php body_class(); ?>>

<!-- ══ HEADER ══════════════════════════════════════════════ -->
<header class="site-header">
  <h1><?php bloginfo('name'); ?></h1>
  <nav>
    <a href="#servicios">Servicios</a>
    <a href="#nosotros">Nosotros</a>
    <a href="#contacto">Contacto</a>
  </nav>
</header>

<!-- ══ HERO ════════════════════════════════════════════════ -->
<section class="hero">
  <h2>Ejemplo de actualización, <br>para el proyecto</h2>
  <p>Diseñamos y desplegamos páginas web corporativas profesionales para pequeños negocios que quieren crecer en internet.</p>
  <a href="#contacto" class="btn">Solicita presupuesto gratis</a>
</section>

<!-- ══ SERVICIOS ═══════════════════════════════════════════ -->
<section id="servicios">
  <div class="services">

    <div class="service-card">
      <div class="icon">🎨</div>
      <h3>Diseño Web</h3>
      <p>Páginas modernas, responsivas y adaptadas a tu imagen de marca.</p>
    </div>

    <div class="service-card">
      <div class="icon">⚡</div>
      <h3>Despliegue Rápido</h3>
      <p>Entornos automatizados con Docker y WordPress listos en minutos.</p>
    </div>

    <div class="service-card">
      <div class="icon">🔄</div>
      <h3>Actualizaciones Ágiles</h3>
      <p>Control de versiones con GitHub para mantener tu web siempre al día.</p>
    </div>

    <div class="service-card">
      <div class="icon">🛡️</div>
      <h3>Mantenimiento</h3>
      <p>Copias de seguridad, actualizaciones de seguridad y soporte continuo.</p>
    </div>

  </div>
</section>

<!-- ══ SOBRE NOSOTROS ══════════════════════════════════════ -->
<section id="nosotros">
  <div class="about">
    <h2>Sobre WebFusion Digital</h2>
    <p>
      Somos una empresa especializada en el desarrollo de páginas web corporativas para
      pequeños negocios. Nuestro equipo combina diseño creativo con infraestructura moderna
      basada en contenedores, garantizando entornos reproducibles, rápidos de desplegar y
      fáciles de mantener.
    </p>
    <br>
    <p>
      Creemos que cada negocio, independientemente de su tamaño, merece una presencia
      digital profesional y accesible.
    </p>
  </div>
</section>

<!-- ══ CONTACTO ════════════════════════════════════════════ -->
<section id="contacto" class="contact">
  <h2>Contacta con nosotros</h2>
  <div class="details">
    <p>📧 <a href="mailto:hola@webfusiondigital.es">hola@webfusiondigital.es</a></p>
    <p>📞 +34 900 123 456</p>
    <p>📍 Madrid, España</p>
  </div>
</section>

<!-- ══ FOOTER ══════════════════════════════════════════════ -->
<footer class="site-footer">
  <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> – Todos los derechos reservados.</p>
</footer>

<?php wp_footer(); ?>
</body>
</html>

<?php get_footer(); ?>
