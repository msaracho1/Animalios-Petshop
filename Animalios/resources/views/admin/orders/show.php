<?php
/** @var object $order */
$title = 'Pedido #' . (int)$order->id_pedido . ' - Admin';

ob_start();
?>

<div style="display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;">
  <h1 class="page-title" style="margin-bottom:0;">Pedido #<?= (int)$order->id_pedido ?></h1>
  <a class="btn btn--sm" href="<?= htmlspecialchars(route('admin.orders.index'), ENT_QUOTES, 'UTF-8') ?>">← Volver</a>
</div>

<div class="panel" style="margin-top:14px;">
  <div class="panel__body">
    <div style="display:flex; gap:18px; flex-wrap:wrap; margin-bottom:10px;">
      <div><strong>Cliente:</strong> <?= htmlspecialchars((string)($order->user->nombre ?? '—'), ENT_QUOTES, 'UTF-8') ?></div>
      <div><strong>Fecha:</strong> <?= htmlspecialchars((string)$order->fecha_creacion, ENT_QUOTES, 'UTF-8') ?></div>
      <div><strong>Total:</strong> $ <?= number_format((float)$order->total, 2, ',', '.') ?></div>
    </div>

    <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:end; justify-content:space-between;">
      <div>
        <div class="muted" style="font-weight:900; margin-bottom:6px;">Estado actual</div>
        <div style="font-weight:900; font-size:14px;">
          <?= htmlspecialchars((string)(($order->history[0]->estado ?? '—')), ENT_QUOTES, 'UTF-8') ?>
        </div>
      </div>

      <form method="POST" action="<?= htmlspecialchars(route('admin.orders.status', ['id' => $order->id_pedido]), ENT_QUOTES, 'UTF-8') ?>" style="display:flex; gap:10px; align-items:end; flex-wrap:wrap;">
        <input type="hidden" name="_token" value="<?= htmlspecialchars(\App\Core\Session::csrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <div style="min-width:220px;">
          <label for="estado">Cambiar estado</label>
          <select id="estado" name="estado" required>
            <?php
              $states = ['pendiente','en_verificacion','preparando','enviado','recibido','cancelado'];
              $curr = (string)(($order->history[0]->estado ?? ''));
            ?>
            <?php foreach ($states as $s): ?>
              <option value="<?= htmlspecialchars($s, ENT_QUOTES, 'UTF-8') ?>" <?= ($curr === $s) ? 'selected' : '' ?>><?= htmlspecialchars(ucwords(str_replace('_',' ', $s)), ENT_QUOTES, 'UTF-8') ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <button class="btn btn--primary" type="submit">Actualizar</button>
      </form>
    </div>

    <h2 class="section-title" style="text-align:left; margin:18px 0 10px">Detalle del pedido</h2>
    <div class="tablewrap">
      <table class="ui" aria-label="detalle">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($order->items as $item): ?>
            <tr>
              <td><?= htmlspecialchars((string)($item->product->nombre ?? '—'), ENT_QUOTES, 'UTF-8') ?></td>
              <td>$ <?= number_format((float)$item->precio_unitario, 2, ',', '.') ?></td>
              <td><?= (int)$item->cantidad ?></td>
              <td>$ <?= number_format((float)$item->precio_unitario * (int)$item->cantidad, 2, ',', '.') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <h2 class="section-title" style="text-align:left; margin:18px 0 10px">Historial</h2>
    <ul style="margin:0; padding-left:18px;">
      <?php foreach ($order->history as $h): ?>
        <li><?= htmlspecialchars((string)$h->fecha_hora, ENT_QUOTES, 'UTF-8') ?> — <strong><?= htmlspecialchars((string)$h->nombre_estado, ENT_QUOTES, 'UTF-8') ?></strong></li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/app.php';
