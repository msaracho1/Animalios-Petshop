<?php
/** @var array $featured */
/** @var array $brands */
$title = 'Animalios';

$pawSvg = '<svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 30c-4 0-8-5-8-10s3-9 7-9 7 4 7 9-2 10-6 10Zm24 0c-4 0-8-5-8-10s3-9 7-9 7 4 7 9-2 10-6 10ZM14 40c-4 0-7-4-7-8s2-7 6-7 6 3 6 7-1 8-5 8Zm36 0c-4 0-7-4-7-8s2-7 6-7 6 3 6 7-1 8-5 8Zm-18 2c8 0 18 6 18 14 0 5-4 8-18 8S14 61 14 56c0-8 10-14 18-14Z" fill="currentColor" opacity=".45"/></svg>';

ob_start();
?>

<?php
$banners = [
  '/animalios/public/assets/images/banner.png',
  '/animalios/public/assets/images/marcas.png'
];

$bannerLinks = [
  route('store.index')
];
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<section aria-label="Promociones" style="max-width:1200px; margin: 18px auto 10px; padding: 0 16px;">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <div id="heroCarousel"
       class="carousel slide"
       data-bs-ride="carousel"
       data-bs-interval="4000">

    <div class="carousel-inner" style="border-radius:18px; overflow:hidden;">

      <?php foreach ($banners as $i => $img): ?>
        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
          <?php $href = $bannerLinks[$i] ?? null; ?>

          <?php if ($href): ?>
            <a href="<?= htmlspecialchars($href, ENT_QUOTES, 'UTF-8') ?>" style="display:block;">
          <?php endif; ?>

          <img src="<?= htmlspecialchars($img, ENT_QUOTES, 'UTF-8') ?>"
               class="d-block w-100"
               alt="Banner <?= $i + 1 ?>"
               style="height: 320px; object-fit: cover;"
               loading="lazy">

          <?php if ($href): ?>
            </a>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>

    </div>

    <?php if (count($banners) > 1): ?>
      <button class="carousel-control-prev"
              type="button"
              data-bs-target="#heroCarousel"
              data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>

      <button class="carousel-control-next"
              type="button"
              data-bs-target="#heroCarousel"
              data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    <?php endif; ?>

  </div>
</section>


<h2 class="section-title">Productos más vendidos</h2>

<?php if (empty($featured)): ?>
  <p class="muted" style="text-align:center">No hay productos para mostrar.</p>
<?php else: ?>
  <div class="grid grid--products">
    <?php foreach ($featured as $p): ?>
      <div class="product">
        <a href="<?= htmlspecialchars(route('store.show', ['id' => $p->id_producto]), ENT_QUOTES, 'UTF-8') ?>">
          <div class="product__img"><?= $pawSvg ?></div>
          <div class="product__name"><?= htmlspecialchars((string)($p->nombre ?? ''), ENT_QUOTES, 'UTF-8') ?></div>
        </a>
        <div class="product__price">$ <?= number_format((float)($p->precio ?? 0), 2, ',', '.') ?></div>
        <div class="product__actions">
          <form method="POST" action="<?= htmlspecialchars(route('cart.add'), ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="_token" value="<?= htmlspecialchars(\App\Core\Session::csrfToken(), ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="id_producto" value="<?= (int)($p->id_producto ?? 0) ?>">
            <input type="hidden" name="cantidad" value="1">
            <button class="btn btn--sm" type="submit">Comprar</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>


<h2 class="section-title">Trabajamos con las mejores marcas</h2>

<div style="max-width:1100px; margin:0 auto 24px; padding: 0 16px;">
  <img src="/animalios/public/assets/images/marcas.png"
       alt="Marcas"
       style="width:100%; border-radius:18px;"
       loading="lazy">
</div>


<section style="max-width:1200px; margin: 32px auto 0; padding: 0 16px;">
  <img src="/animalios/public/assets/images/abajo.png"
       alt="Banner adicional"
       style="width:100%; border-radius:18px;"
       loading="lazy">
</section>

<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/app.php';