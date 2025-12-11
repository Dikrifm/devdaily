<?php

namespace App\Services;

use Config\Database;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Log\Logger;

/**
 * Class BaseService
 * * Fondasi untuk semua Service di aplikasi.
 * Menerapkan prinsip:
 * - #1 Database Transactions (All or Nothing)
 * - #3 Dependency Injection
 * - #13 Logging & Debugging
 */
abstract class BaseService
{
    /**
     * Instance Database Connection
     * @var BaseConnection
     */
    protected $db;

    /**
     * Instance Logger
     * @var Logger
     */
    protected $logger;

    /**
     * Menyimpan pesan error validasi/logic bisnis
     * @var array
     */
    protected $errors = [];

    public function __construct()
    {
        // Poin #10: Multiple Database Connections (Default group)
        $this->db = Database::connect();
        
        // Poin #13: Logger service
        $this->logger = service('logger');
    }

    /**
     * Menambahkan pesan error
     */
    protected function setError(string $message): void
    {
        $this->errors[] = $message;
        // Log error secara otomatis untuk audit trail
        $this->logger->error('[Service Error] ' . $message);
    }

    /**
     * Mengambil semua error
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Mengambil error pertama (untuk flash message sederhana)
     */
    public function getFirstError(): ?string
    {
        return $this->errors[0] ?? null;
    }

    /**
     * Cek apakah ada error
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    // -------------------------------------------------------------------------
    // DATABASE TRANSACTION WRAPPERS (Prinsip #1)
    // -------------------------------------------------------------------------

    /**
     * Memulai Transaksi Database
     */
    protected function beginTransaction(): void
    {
        $this->db->transException(true)->transStart();
    }

    /**
     * Menyelesaikan Transaksi (Commit)
     * Jika gagal di tengah jalan, otomatis Rollback
     * * @return bool True jika sukses commit, False jika rollback
     */
    protected function commitTransaction(): bool
    {
        $this->db->transComplete();
        return $this->db->transStatus();
    }

    /**
     * Paksa Rollback (misal validasi bisnis gagal di tengah transaksi)
     */
    protected function rollbackTransaction(): void
    {
        $this->db->transRollback();
    }
}
