<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Page;

class PageModel extends Model
{
    protected $table            = 'pages';
    protected $primaryKey       = 'id';
    protected $returnType       = Page::class;
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'title', 'slug', 'content', 
        'meta_title', 'meta_description', 'active'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
