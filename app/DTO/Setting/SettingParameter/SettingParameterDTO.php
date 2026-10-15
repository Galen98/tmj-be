<?php

namespace App\DTO\Setting\SettingParameter;

class SettingParameterDTO extends \App\DTO\BaseDTO
{
    public function __construct(
        public ?int $id = null,
        public ?string $key = null,
        public ?string $value = null,
        public ?string $description = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'value' => $this->value,
            'description' => $this->description,
        ];
    }
}
