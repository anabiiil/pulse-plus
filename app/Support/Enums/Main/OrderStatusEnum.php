<?php

namespace App\Support\Enums\Main;

enum OrderStatusEnum: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case InProgress = 'in_progress';
    case OnWay = 'on_way';
    case Completed = 'completed';
    case Canceled = 'canceled';
    case CanceledByClient = 'canceled_by_client';

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'bg-warning',
            self::Confirmed => 'bg-info',
            self::InProgress => 'bg-primary',
            self::OnWay => 'bg-purple',
            self::Completed => 'bg-success',
            self::Canceled => 'bg-danger',
            self::CanceledByClient => 'bg-danger',
        };
    }

    public function trans(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Confirmed => 'Confirmed',
            self::InProgress => 'In Progress',
            self::OnWay => 'On Way',
            self::Completed => 'Completed',
            self::Canceled => 'Canceled',
            self::CanceledByClient => 'Canceled by Client',
        };
    }
}
