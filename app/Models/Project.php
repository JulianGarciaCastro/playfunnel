<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

use App\Models\ProjectLibrary;
use App\Models\User;


class Project extends Model
{
    use HasFactory;

    protected $table = 'project';
    protected $primaryKey = 'id';
    public $incrementing = true;

    public $timestamps = false; // ✅ IMPORTANTE: tu tabla no tiene created_at/updated_at

    protected $fillable = [
        'user_id',
        'name',
        'aspect',
        'project_status_id',
        'publish_library_img',
        'publish_div',
        'landing_page',
        'creation_date',
    ];

    protected $casts = [
        'creation_date' => 'datetime',
    ];

    public function user() // ✅ relación estándar para Filament
    {
        return $this->belongsTo(User::class, 'user_id');
    }



    public function projectLibrary()
    {
        return $this->hasMany(ProjectLibrary::class, 'projectid', 'id')
            ->orderBy('position', 'ASC');
    }

    public function cuePoints()
    {
        return $this->hasMany(CuePoint::class, 'projectid', 'id')
            ->orderBy('libraryid', 'ASC')
            ->orderBy('time', 'ASC');
    }

    protected static function booted()
    {
        static::deleting(function (Project $project) {
            // ✅ cascada controlada, sin sobreescribir delete()
            $project->projectLibrary()->each(fn ($pl) => $pl->delete());
            $project->cuePoints()->delete();
        });
    }



}
