<?php

namespace App\Models;

use App\Services\FileService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Storage;

class FilesRegistre extends Model
{
    use HasUuids;

    protected $table = 'files_registre';

    protected $primaryKey = 'uid';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'uid',
        'filename',
        'path',
        'extension',
        'size',
        'disk',
        'uploaded_at',
        'json_data',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'json_data' => 'array',
    ];

    public function url(){
        return "/files/" . $this->disk . "/" . $this->path;
    }
}