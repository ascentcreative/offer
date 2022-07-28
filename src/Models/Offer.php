<?php

namespace AscentCreative\Offer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


/**
 * Represents an offer in the system (which is processed by a Rule)
 */
class Offer extends Model 
{
    use HasFactory;

    public $table = 'offer_offers';

    public $fillable = ['rule_class', 'alias', 'description', 'config', 'start_date', 'end_date',
                         'in_conjunction', 'processing_order', 'is_enabled', 'code'];


    public $casts = [
        'config'=>'array',
    ];

    public function discountables() {
        return $this->hasMany(Discountable::class); //, 'offer_discountables');
    }

    public function applicableItems($basket) {

        $offer = $this;
        return $basket->items()
                    ->whereExists(function($q) use ($offer) {
                            
                        $q->select('*')
                            ->from('offer_discountables')
                            ->where( DB::Raw("concat(discountable_type, '_', discountable_id)"), DB::Raw("concat(sellable_type, '_', sellable_id)"))
                            ->where('offer_id', $offer->id);

                    })
                    ->whereNull('offer_id')
                    ->get();
                
    }


    public function scopeLive($query, $codes=null) {

        $query
        ->where('is_enabled', 1)
        ->where(function($q) {
            $q->where(function($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<', DB::Raw('now()'));
            })->where(function($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>', DB::Raw('now()'));
            });
        });


        if($codes) {
            $query->where(function($q) use ($codes) {
                $q->whereNull('code')
                    ->orWhereIn('code', $codes);
            });
        }

    }




}
