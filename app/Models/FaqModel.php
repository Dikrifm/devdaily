<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Faq;

class FaqModel extends Model
{
    protected $table            = 'faqs';
    protected $primaryKey       = 'id';
    protected $returnType       = Faq::class;
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['question', 'answer', 'sort_order', 'active'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
