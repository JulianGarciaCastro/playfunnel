<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Library;
use App\Models\PlanSubscription;
use App\Models\PlanType;
use Carbon\Carbon;
use Stripe;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'google_token',
        'google_refresh_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    public function library(){
        return $this->hasMany(Library::class, 'createdby', 'id')
                    ->orderBy('createdate', 'ASC');
    }
    
    public function getLibrarySize(){
        $size = $this->hasMany(Library::class, 'createdby', 'id')->get()->sum('mediasize')/(1048576*1014);
        return round($size,2);
    }
    
    public function getPlanSusbcription(){
        return $this->hasMany(PlanSubscription::class, 'userid', 'id')
        ->orderBy('active',    'DESC')
        ->orderBy('startdate', 'ASC');
    }
    
    public function getPlanSusbcriptionActive(){
        return $this->hasOne(PlanSubscription::class, 'userid', 'id')->where('active', 1);
    }
    
    public function isPlanSusbcriptionActive(){
        $activePlan = $this->getPlanSusbcriptionActive;
        
        if($activePlan){
            //TODO: revisar porque en test da error al intentar utilizar estas funciones.
            //$planEndDate = Carbon::createFromFormat('d-m-Y', $activePlan->getPlanSubscriptionEndDate());
            //$currentDate = Carbon::createFromFormat('d-m-Y', Carbon::now()->format('d-m-Y'));
            
            $planEndDate = $activePlan->getPlanSubscriptionEndDate();
            $currentDate = Carbon::now();

            Log::debug('Plan Actual: ' . $planEndDate . " - Fecha Actual: " . $currentDate );
            
            if($currentDate->gt($planEndDate)){
                return false;
            }
            else {
                return true;
            }
        }
        
        return false;
    }
    
    public function getPlanSize(){
        $planActive = $this->getPlanSusbcriptionActive;
        
        if($planActive)
            return $planActive->getPlanSize();
        
        return 0;
    }
    
    public function getPlanName(){
        $planActive = $this->getPlanSusbcriptionActive;
        
        if($planActive)
            return $planActive->getPlanName();
            
        return "Sin subscripción activa";
    } 
    
    public function getPlanSubscriptionStartDate(){
        $planActive = $this->getPlanSusbcriptionActive;
        
        if($planActive)
            return $planActive->getPlanSubscriptionStartDate();
            
            return "00-00-0000";
    }
    
    public function getPlanSubscriptionEndDate(){
        $planActive = $this->getPlanSusbcriptionActive;
        
        if($planActive)
            return $planActive->getPlanSubscriptionEndDate();
            
            return "00-00-0000";
    }
    
    public function subscribeDefaultPlan(){
        $previous = $this->getPlanSusbcriptionActive;
        
        if(!$previous){
            $defaultPlan = PlanType::getDefaultPlan();
            $planSubscription = new PlanSubscription();
            $planSubscription->plantypeid = $defaultPlan->id;
            $planSubscription->active     = 1;
            $planSubscription->userid     = $this->id;
            $planSubscription->startdate  = Carbon::now();
            $planSubscription->enddate    = Carbon::now()->addDays( $defaultPlan->duration );
            $planSubscription->description= "Subscripcion Usuario Registrado y Verificado";
            $planSubscription->save();
        }
    }
    
    
    public function subscribePlan(PlanType $plan, $invoicenum){
        $previous = $this->getPlanSusbcriptionActive;
        
        if($previous){
            $this->cancelSubscription($previous);
            $previous->active = 0;
            $previous->save();
        }
        
        $planSubscription = new PlanSubscription();
        $planSubscription->plantypeid = $plan->id;
        $planSubscription->active     = 1;
        $planSubscription->userid     = $this->id;
        $planSubscription->startdate  = Carbon::now();
        //$planSubscription->enddate    = Carbon::now()->addDays($plan->duration);
        $planSubscription->description= "Nueva subscripcion";
        $planSubscription->invoicenum = $invoicenum;
        $planSubscription->enterby    = "-1";
        $planSubscription->save();    
    }
    
    
    public function cancelSubscription(PlanSubscription $planSubscription){
        
        if(!is_null($planSubscription->invoicenum)){
            //Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            //$subscription = Stripe\Subscription::Retrieve($planSubscription->invoicenum, [],);
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $subscription = $stripe->subscriptions->retrieve($planSubscription->invoicenum, []);
            
            if(!is_null($subscription)){
                
                if($subscription->status == 'canceled')
                    return "Suscripcion actualmente Cancelada";
                
                    
                $endDate = Carbon::createFromTimestamp($subscription->current_period_end);
                $subscription->cancel();
            
                
                //$planSubscription->active     = 0;
                //$planSubscription->enddate    = Carbon::now();
                $planSubscription->canceldate = Carbon::now();
                $planSubscription->enddate    = $endDate;
                $planSubscription->description= "Subscripcion Cancelada ";
                $planSubscription->save();
                
                return "Suscripcion Cancelada Correctamente";
            }
        }
        
        return "No existe subscription indicada";
    }
    
    
    public function cancelCurrentSubscription(){
        
        $previous = $this->getPlanSusbcriptionActive;
        
        if($previous){
            return $this->cancelSubscription($previous);
        }
        
        return "No exite Subscricion Activa";
    }
    
    
    public function isCurrentSubscriptionCanceled(){
        $planSubscription = $this->getPlanSusbcriptionActive;
        
        return $planSubscription->isPlanSubscriptionCanceled();
        
    }
    
    public function getPlanSubscriptionCancelDate(){
        $planSubscription = $this->getPlanSusbcriptionActive;
        
        return $planSubscription->getPlanSubscriptionCancelDate();
        
    }
    
    
    public function getNextBillingDate(){
        if( $this->isCurrentSubscriptionCanceled() ){
            return "";
        }
        
        $planSubscription = $this->getPlanSusbcriptionActive;
        
        if($planSubscription->invoicenum == ""){
            Log::error('getNextBillingDate() $planSubscription->invoicenum: vacío');
            return "";
        } 

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $subscription = $stripe->subscriptions->retrieve($planSubscription->invoicenum, []);
        
        $next_billing_date = Carbon::createFromTimestamp($subscription->current_period_end);
        Log::debug('getNextBillingDate() Suscripcion: ' . $subscription);
        Log::debug('getNextBillingDate() next_billing_date: ' . $next_billing_date);
        
        return $next_billing_date->format('d-m-Y');
    }
    
    
    public function getLatestInvoce(){
        $planSubscription = $this->getPlanSusbcriptionActive;
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        
        if($planSubscription->invoicenum == ""){
            Log::error('getLatestInvoce() $planSubscription->invoicenum: vacío');
            return "";
        }else{
            $subscription = $stripe->subscriptions->retrieve($planSubscription->invoicenum, []);
        
            $invoice = $stripe->invoices->retrieve($subscription->latest_invoice, []);
            $next_invoice_date = Carbon::createFromTimestamp($invoice->effective_at);
            Log::debug('getLatestInvoce() Invoice: ' . $invoice);
            Log::debug('getLatestInvoce() effective_at: ' . $next_invoice_date);
            return $next_invoice_date->format('d-m-Y');
        }
    }
    
    
    public function getInvoicePDF(){
        
        $planSubscription = $this->getPlanSusbcriptionActive;
        
        if($planSubscription->invoicenum == ""){
            Log::error('getInvoicePDF() $planSubscription->invoicenum: vacío');
            return "";
        }

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $subscription = $stripe->subscriptions->retrieve($planSubscription->invoicenum, []);
        $invoice = $stripe->invoices->retrieve($subscription->latest_invoice, []);
        
        Log::debug('getInvoicePDF() URL Invoice: ' . $invoice);
        return $invoice->invoice_pdf;
    }
        
    public function viewInvoicePDF(){
        
        $planSubscription = $this->getPlanSusbcriptionActive;

        if($planSubscription->invoicenum == ""){
            Log::error('viewInvoicePDF() $planSubscription->invoicenum: vacío');
            return "";
        }        
        
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $subscription = $stripe->subscriptions->retrieve($planSubscription->invoicenum, []);
        $invoice = $stripe->invoices->retrieve($subscription->latest_invoice, []);
        
        Log::debug('viewInvoicePDF() URL Invoice: ' . $invoice);
        return $invoice->hosted_invoice_url;
    }
    
    
    public function getChargeReceipt(){
        
        $planSubscription = $this->getPlanSusbcriptionActive;

        if($planSubscription->invoicenum == ""){
            Log::error('getChargeReceipt() $planSubscription->invoicenum: vacío');
            return "";
        }

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $subscription = $stripe->subscriptions->retrieve($planSubscription->invoicenum, []);

        $invoice = $stripe->invoices->retrieve($subscription->latest_invoice, []);
        


        if($invoice->status != 'paid'){
            $stripe->invoices->pay($invoice->id, []);
        }
        
        $invoice = $stripe->invoices->retrieve($subscription->latest_invoice, []);
        $charge = $stripe->charges->retrieve($invoice->charge, []);
        Log::debug('getChargeReceipt() Charge: ' . $charge);
        return $charge->receipt_url;
        return "";
    }
    
}