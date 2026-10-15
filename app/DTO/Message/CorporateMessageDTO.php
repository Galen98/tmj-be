<?php

namespace App\DTO\Message;

use App\DTO\BaseDTO;

class CorporateMessageDTO extends BaseDTO
{
    public function __construct(
    public readonly string $corporate_contact,
    public readonly string $corporate_name,
    public readonly string $hari_acara,
    public readonly int $jumlah_peserta,
    public readonly bool $add_hotel,
    public readonly string $lokasi_start,
    ) {}

    public function toArray(): array
    {
        return [
            'corporate_contact' => $this->corporate_contact,
            'corporate_name' => $this->corporate_name,
            'hari_acara' => $this->hari_acara,
            'jumlah_peserta' => $this->jumlah_peserta,
            'add_hotel' => $this->add_hotel,
            'lokasi_start' => $this->lokasi_start,
        ];
    }
}
