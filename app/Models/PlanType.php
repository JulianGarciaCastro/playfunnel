<<<<<<< HEAD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanType extends Model
{
    use HasFactory;
    
    protected $table = 'plantype';
    
    protected $primaryKey = 'id';
    public $incrementing  = true;
    public $timestamps    = false;
    
    protected $casts = [
        'enterdate'  => 'datetime',
        'changedate' => 'datetime',
    ];
    
    
    public function getPlanSize(){
        return $this->size;
    }
    
    public function getPlanName(){
        return $this->name;
    }
    
    public function getPlanPrice(){
        return $this->price;
    }
    
    public function getPlanInterval(){
        return $this->interval;
    }
    
    public static function getDefaultPlan(){
        return (new static)::where('active', 1)->where('default', 1)->first();
    }
=======
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanType extends Model
{
    use HasFactory;
    
    protected $table = 'plantype';
    
    protected $primaryKey = 'id';
    public $incrementing  = true;
    public $timestamps    = false;
    
    protected $casts = [
        'enterdate'  => 'datetime',
        'changedate' => 'datetime',
    ];
    
    
    public function getPlanSize(){
        return $this->size;
    }
    
    public function getPlanName(){
        return $this->name;
    }
    
    public function getPlanPrice(){
        return $this->price;
    }
    
    public function getPlanInterval(){
        return $this->interval;
    }
    
    public static function getDefaultPlan(){
        return (new static)::where('active', 1)->where('default', 1)->first();
    }
>>>>>>> 0d6f5c2c18f02c9c7d0a3cb40a1c8218e42ba08f
}