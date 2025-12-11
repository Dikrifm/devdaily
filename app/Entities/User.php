<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at', 'last_active'];
    protected $casts   = [
        'active' => 'boolean',
        'json'   => 'json', // Untuk biometric_data jika perlu
    ];

    /**
     * Mutator: Otomatis Hash Password saat di-set
     */
    public function setPassword(string $pass): self
    {
        $this->attributes['password'] = password_hash($pass, PASSWORD_BCRYPT);
        return $this;
    }

    /**
     * Mutator: Otomatis Hash PIN saat di-set
     */
    public function setPin(string $pin): self
    {
        $this->attributes['pin'] = password_hash($pin, PASSWORD_BCRYPT);
        return $this;
    }

    /**
     * Helper: Verifikasi Password
     */
    public function verifyPassword(string $pass): bool
    {
        return password_verify($pass, $this->attributes['password']);
    }

    /**
     * Helper: Cek Avatar (Return default jika kosong)
     */
    public function getAvatarUrl(): string
    {
        if (!empty($this->attributes['avatar'])) {
            return base_url($this->attributes['avatar']);
        }
        // Avatar default DiceBear jika null
        return 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $this->attributes['username'];
    }
}
