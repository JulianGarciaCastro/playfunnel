<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Models\ProjectLibrary;
use App\Models\Project;

class Library extends Model
{
    use HasFactory;
    
    protected $table = 'library';

    protected $appends = [
        'public_url',
        'thumbnail_public_url',
    ];

    protected $fillable = [
            'url'
        ];

    public function getPublicUrlAttribute()
    {
        return self::publicMediaUrl($this->url);
    }

    public function getThumbnailPublicUrlAttribute()
    {
        return self::publicMediaUrl($this->thumbnail ?: $this->url);
    }

    public static function publicMediaUrl($path)
    {
        if (empty($path)) {
            return '';
        }

        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        if (Str::startsWith($path, ['media/'])) {
            $encodedPath = collect(explode('/', $path))
                ->map(fn ($segment) => rawurlencode($segment))
                ->implode('/');

            return url('/media-file/' . $encodedPath);
        }

        return asset($path);
    }
    
    public function projectLibrary(){
        Log::debug('projectLibrary() mirando ProjectLibs');
        
        return $this->hasMany(ProjectLibrary::class, 'libraryid', 'id');
    }
    
    
    public function project(){
        Log::debug('project() mirando Project');
        
        return $this->belongsToMany(Project::class, 'projectlibrary', 'libraryid', 'projectid');
    }
    
    public function projectPublish(){
        Log::debug('project() mirando projectPublish');
        
        return $this->hasMany(Project::class,  'publish_library_img', 'id');
    } 
    
    public function projectLanding(){
        Log::debug('project() mirando projectLanding');
        
        return $this->hasMany(Project::class,  'landing_library_img', 'id');
    }
    
    public function projectOption(){
        Log::debug('project() mirando projectOption');
        
        return $this->belongsToMany(Project::class,  'type_option_data', 'library_img','projectid');
    } 
}
