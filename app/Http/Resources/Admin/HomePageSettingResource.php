<?php

namespace App\Http\Resources\Admin;

use App\Models\CustomerProfile;
use App\Models\HomePageFeaturedExporter;
use App\Models\Widget;
use Illuminate\Http\Resources\Json\JsonResource;

class HomePageSettingResource extends JsonResource
{
    public function toArray($request)
    {
        $business_categories = HomePageFeaturedExporter::wherePageId($this->page_id)->pluck('business_category_id');
        if($business_categories){
            $business_profiles = CustomerProfile::whereIn('id', $business_categories)->select('id', 'company_name', 'slug')->get();
        }
        return [
            'id' => $this->id,
            'page_id' => $this->page_id,
            'number_of_featured_exporters' => $this->number_of_featured_exporters,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'home_page_setting_detail' => HomePageSettingDetailResource::collection($this->whenLoaded('homePageSettingDetail')),
            'business_profiles' => $business_profiles ?? null,
            'header_widget_id' => $this->header_widget_id,
            'header_widget' => Widget::select('id', 'name')->whereId($this->header_widget_id)->first() ?? null,
            'business_category_widget_id' => $this->business_category_widget_id,
            'business_category_widget' => Widget::select('id', 'name')->whereId($this->business_category_widget_id)->first() ?? null,
            'i2b_widget_id' => $this->i2b_widget_id,
            'i2b_widget' => Widget::select('id', 'name')->whereId($this->i2b_widget_id)->first() ?? null,
            'sponsor_widget_id' => $this->sponsor_widget_id,
            'sponsor_widget' => Widget::select('id', 'name')->whereId($this->sponsor_widget_id)->first() ?? null,
            'business_widget_id' => $this->business_widget_id,
            'business_widget' => Widget::select('id', 'name')->whereId($this->business_widget_id)->first() ?? null,
            'events_widget_id' => $this->events_widget_id,
            'events_widget' => Widget::select('id', 'name')->whereId($this->events_widget_id)->first() ?? null,
            'magazine_widget_id' => $this->magazine_widget_id,
            'magazine_widget' => Widget::select('id', 'name')->whereId($this->magazine_widget_id)->first() ?? null,
            'page' => new PageResource($this->whenLoaded('page')),
        ];
    }
}
