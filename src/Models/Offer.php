<?php

namespace AscentCreative\Offer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use AscentCreative\Offer\Models\Offer\Sellable;

use AscentCreative\CMS\Traits\Publishable;
use AscentCreative\Offer\Traits\HasSellables;

/**
 * Represents an offer in the system (which is processed by a Rule)
 */
class Offer extends Model 
{
    use HasFactory, Publishable, HasSellables;

    public $table = 'offer_offers';

    public $fillable = ['rule_class', 'alias', 'description', 'config', 'start_date', 'end_date',
                         'in_conjunction', 'processing_order', 'is_enabled', 'code'];


    public $casts = [
        'config'=>'array',
    ];

    public function sellables() {
        return $this->hasMany(Sellable::class)
                ->with('sellable'); //, 'offer_discountables');
    }


    public function applicableItems($basket) {

       $keys = [];

        foreach($this->sellables as $sellable) {

            $ref = new \ReflectionClass(get_class($sellable->sellable));
            if($ref->implementsInterface(\AscentCreative\Checkout\Contracts\SellableGroup::class)) {
                // if the sellable is a SellableGroup, we need to resolve the individual sellables within it
                $q = DB::query();
                $out = $sellable->sellable->resolveSellables($q)->get()->transform(function($item) {
                    return $item->sellable_type . '_' . $item->sellable_id;
                });
                $keys = array_merge($keys, $out->toArray());
            } else {
                // otherwise, just add this one to the list
                $keys[] = $sellable->sellable_type . '_' . $sellable->sellable_id;
            }
        }

        // dump($keys);

        // dump($basket->items());

        // dd($basket->items()->first());

        // dump($basket->items()->whereIn('morph_key', $keys)->filter(function($value, $key) {
        //     return count($value->offer) == 0;
        // }));

        // dd($basket->items()->where('offer', '!=', null)->whereIn('morph_key', $keys));

        return $basket->items()->whereIn('morph_key', $keys)
                    ->whereNull('offer_id');

        // dump($basket->items());

        // once we have a list of the keys, we can filter the basket items to find all the matches:
        // return $basket->items()->whereIn('morph_key', $keys);

        // return $keys;
     
    }




    public function oldApplicableItems($basket) {

        $offer = $this;

        // $table = $basket->items()->getRelated()->getTable();
        $table = 'checkout_order_items';

        return $basket->items()

                    ->where(function($q) use ($offer, $table) {
                            
                        $q->whereExists(function($q) use ($offer) {
                                
                            // where the item is listed in the offer items (sellables...)
                            $q->select('*')
                                ->from('offer_sellables')
                                ->where('offer_sellables.sellable_type', DB::Raw('checkout_order_items.sellable_type'))
                                ->where('offer_sellables.sellable_id', DB::Raw('checkout_order_items.sellable_id'))
                                ->where('offer_id', $offer->id);

                        });

                        // look for any discountables which are sellable_groups

                        $groups = [];
                        foreach($offer->sellables as $sellable) {
                            if(!is_null($sellable->sellable) && method_exists($sellable->sellable, 'resolveSellables')) {
                                $groups[] = $sellable;
                            }
                        }

                        if(count($groups) > 0 ) {

                            $q->orWhereExists(function($q) use ($groups, $table) {

                                $q->select('*')
                                    ->from(function($q) use ($groups, $table) {
        
                                        $group = array_shift($groups);
                                        
                                        if(method_exists($group->sellable, 'resolveSellables')) {
                                            // the first group is applied straight to the query
                                            $group->sellable->resolveSellables($q);
                                        }
                                       
                                        // the remaining ones (if any) are unioned
                                        foreach($groups as $group) {
                                            if(method_exists($group->sellable, 'resolveSellables')) {
                                                $q2 = DB::query();
                                                $q->union($group->sellable->resolveSellables($q2));
                                            }
                                        }
        
                                    }, 'tmp')
                                    ->where('tmp.sellable_type', DB::Raw($table . '.sellable_type'))
                                    ->where('tmp.sellable_id', DB::Raw($table . '.sellable_id')); 

        
                            });

                        }

                    

                })
                    ->whereDoesntHave('offers')
                    ->whereNull('offer_id')
                    ->get();
                
    }


        // dd("here");
                            
                    //     // this needs to do a deeper search, somehow...
                    //     // if the discountable is not a direct sellable, but a group or category, 
                    //     // this needs to resolve to a list or temporary table of the matching products...

                    //     // feels like the 'sellable_group' should implement a query function which this calls
                        
                    //     // so, example...
                    //     // all a3 lustre prints...
                    //     // the offer would be agsainst the print-spec. 

                    //     // so, the print spec would return a temp. table query
                        
                    //     // what if there are multiple of that type of class (i.e., all a3 lustre and all a4 lustre?)

                    //     // feels like we just union them all into a temp table.

                    //     // the question then, is how do we know whether the discountable is a single product?
                    //     // - does the sellable just return its own morph data from the same query scope thing? (or nothing as it's covered in the first Exists)
                        
                    //     // is it a query, or do we pre-process with a call to loop through and build the lookup list of all models?
                    //     // it could be a query using concat... 

                    //     // feels like the most flexible option is for the model to just be able to return an array for now? 

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
