<<<<<<< HEAD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PlanType;
use App\Models\User;

use Illuminate\Support\Facades\Log;

class PlanSubscription extends Model
{
    use HasFactory;
    
    
    protected $table = 'plansubscription';
    protected $dates = ['startdate','enddate','enterdate','canceldate'];
    
    protected $primaryKey = 'id';
    public $incrementing  = true;
    public $timestamps    = false;
    
    protected $casts = [
        'startdate'  => 'datetime',
        'enddate'    => 'datetime',
        'enterdate'  => 'datetime',
        'canceldate' => 'datetime',
    ];
    
    public function getPlan(){
        return $this->hasOne(PlanType::class, 'id', 'plantypeid');
    }
    
    public function getUser(){
        return $this->hasOne(User::class, 'id', 'userid');
    }
    
    public function getUserEmail(){
        $user = $this->getUser;
        
        if($user)
            return $user->email;
            
            return "No User";
    } 
    
    public function getPlanSize(){
        $plan = $this->getPlan;

        if($plan)
            return $plan->getPlanSize();
        
        return 0;
    }
    
    public function getPlanName(){
        $plan = $this->getPlan;
        
        if($plan)
            return $plan->getPlanName();
            
            return "No Plan";
    } 
    
    public function getPlanPrice(){
        $plan = $this->getPlan;
        
        if($plan)
            return $plan->getPlanPrice();
            
            return 0;
    }
    
    public function getPlanSubscriptionStartDate(){
        if($this->startdate)
            return $this->startdate->format('d-m-Y');
        return null;
    }
    
    public function getPlanSubscriptionEndDate(){
        if($this->enddate)
            return $this->enddate->format('d-m-Y');
        return null;
    }
    
    public function isPlanSubscriptionActive(){
        return $this->active;
    }
    
    public function isPlanSubscriptionCanceled(){
        
        if($this->canceldate)
            return true;
            
            return false;
    }
    
    public function getPlanSubscriptionCancelDate(){
        if($this->canceldate)
            return $this->canceldate->format('d-m-Y');
        return null;
    }
    
    public function getPlanSubscriptionDate(){
        if($this->enterdate)
            return $this->enterdate->format('d-m-Y');
        return null;
    }
    
    public function getPlanID(){
        return $this->id;
    }
    
=======
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PlanType;
use App\Models\User;

use Illuminate\Support\Facades\Log;

class PlanSubscription extends Model
{
    use HasFactory;
    
    
    protected $table = 'plansubscription';
    protected $dates = ['startdate','enddate','enterdate','canceldate'];
    
    protected $primaryKey = 'id';
    public $incrementing  = true;
    public $timestamps    = false;
    
    protected $casts = [
        'startdate'  => 'datetime',
        'enddate'    => 'datetime',
        'enterdate'  => 'datetime',
        'canceldate' => 'datetime',
    ];
    
    public function getPlan(){
        return $this->hasOne(PlanType::class, 'id', 'plantypeid');
    }
    
    public function getUser(){
        return $this->hasOne(User::class, 'id', 'userid');
    }
    
    public function getUserEmail(){
        $user = $this->getUser;
        
        if($user)
            return $user->email;
            
            return "No User";
    } 
    
    public function getPlanSize(){
        $plan = $this->getPlan;

        if($plan)
            return $plan->getPlanSize();
        
        return 0;
    }
    
    public function getPlanName(){
        $plan = $this->getPlan;
        
        if($plan)
            return $plan->getPlanName();
            
            return "No Plan";
    } 
    
    public function getPlanPrice(){
        $plan = $this->getPlan;
        
        if($plan)
            return $plan->getPlanPrice();
            
            return 0;
    }
    
    public function getPlanSubscriptionStartDate(){
        if($this->startdate)
            return $this->startdate->format('d-m-Y');
        return null;
    }
    
    public function getPlanSubscriptionEndDate(){
        if($this->enddate)
            return $this->enddate->format('d-m-Y');
        return null;
    }
    
    public function isPlanSubscriptionActive(){
        return $this->active;
    }
    
    public function isPlanSubscriptionCanceled(){
        
        if($this->canceldate)
            return true;
            
            return false;
    }
    
    public function getPlanSubscriptionCancelDate(){
        if($this->canceldate)
            return $this->canceldate->format('d-m-Y');
        return null;
    }
    
    public function getPlanSubscriptionDate(){
        if($this->enterdate)
            return $this->enterdate->format('d-m-Y');
        return null;
    }
    
    public function getPlanID(){
        return $this->id;
    }
    
>>>>>>> 0d6f5c2c18f02c9c7d0a3cb40a1c8218e42ba08f
}