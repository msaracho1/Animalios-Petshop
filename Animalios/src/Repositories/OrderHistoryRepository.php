<?php
declare(strict_types=1);

namespace App\Repositories;

final class OrderHistoryRepository extends BaseRepository
{
    public function create(int $orderId, string $estado, string $fecha): int
    {
        $this->exec(
            'INSERT INTO historial_pedido (id_pedido, estado, fecha) VALUES (:p,:e,:f)',
            ['p'=>$orderId,'e'=>$estado,'f'=>$fecha]
        );
        return $this->lastInsertId();
    }

    public function listForOrder(int $orderId): array
    {
        return $this->objs($this->fetchAll('SELECT * FROM historial_pedido WHERE id_pedido = :id ORDER BY fecha DESC, id_historial DESC', ['id'=>$orderId]));
    }
}
