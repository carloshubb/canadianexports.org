<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\WidgetResource;
use App\Models\Widget;
use App\Models\WidgetDetail;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $widgets = Widget::query();

        $widgets = $this->whereClause($widgets);
        $widgets = $this->loadRelations($widgets);
        $widgets = $this->sortingAndLimit($widgets);

        return $this->apiSuccessResponse(WidgetResource::collection($widgets), 'Data Get Successfully!');
    }


    public function show(Widget $widget)
    {
        if (isset($_GET['withMedia']) && $_GET['withMedia'] == '1') {
            $widget = $widget->loadMissing('media');
        }
        if (isset($_GET['withMedia2']) && $_GET['withMedia2'] == '1') {
            $widget = $widget->loadMissing('media2');
        }
        if (isset($_GET['withWidgetDetail']) && $_GET['withWidgetDetail'] == '1') {
            $widget = $widget->loadMissing('widgetDetail');
        }

        return $this->apiSuccessResponse(new WidgetResource($widget), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $validationRule = [
            'name' => ['required'],
            'image_path' => ['required'],
            'image_path_2' => ['nullable'],
            'layout' => ['required', 'in:layout_1,layout_2,layout_3'],
        ];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if($language->is_default == '1'){
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['text_detail.text_detail_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['text_detail.text_detail_' . $language->id . '.required' => 'Description in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'Button text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['button_link.button_link_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_link.button_link_' . $language->id . '.required' => 'Button link in ' . $language->name . ' is required.']);
            $validationRule = array_merge($validationRule, ['action.action_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['action.action_' . $language->id . '.required' => 'Action in ' . $language->name . ' is required.']);
        }

        $this->validate($request, $validationRule, $errorMessages);

        if (isset($request->image_path)) {
            $media = json_decode($request->image_path, 1);
            $files = $this->moveFile($media, 'media/widgets', 'widgets');
        }
        if (isset($request->image_path_2)) {
            $media = json_decode($request->image_path_2, 1);
            $files2 = $this->moveFile($media, 'media/widgets', 'widgets');
        }
        $widget = Widget::create([
            'name' => $request->name,
            'short_code' => '[short_code=widget-' . rand(1, 1000000) . ']',
            'layout' => $request->layout,
            'image_path' => isset($files, $files[0]) ? $files[0]->id : null,
            'image_path_2' => isset($files2, $files2[0]) ? $files2[0]->id : null,
        ]);

        if ($widget) {
            foreach ($languages as $language) {
                WidgetDetail::create([
                    'widget_id' => $widget->id,
                    'language_id' => $language->id,
                    'text_detail' => $request['text_detail']['text_detail_' . $language->id],
                    'button_text' => $request['button_text']['button_text_' . $language->id],
                    'button_link' => $request['button_link']['button_link_' . $language->id],
                    'action' => $request['action']['action_' . $language->id],
                ]);
            }
            return $this->apiSuccessResponse(new WidgetResource($widget), 'Widget has been added successfully.');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, Widget $widget)
    {
        $validationRule = [
            'id' => ['required', 'exists:widgets,id'],
            'name' => ['required'],
            'layout' => ['required', 'in:layout_1,layout_2,layout_3'],
            'image_path' => ['required'],
            'image_path_2' => ['nullable'],
        ];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if($language->is_default == '1'){
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['text_detail.text_detail_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['text_detail.text_detail_' . $language->id . '.required' => 'Description in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'Button text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['button_link.button_link_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_link.button_link_' . $language->id . '.required' => 'Button link in ' . $language->name . ' is required.']);
            $validationRule = array_merge($validationRule, ['action.action_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['action.action_' . $language->id . '.required' => 'Action in ' . $language->name . ' is required.']);
        }

        $this->validate($request, $validationRule, $errorMessages);

        if (isset($request->image_path)) {
            $media = json_decode($request->image_path, 1);
            $files = $this->moveFile($media, 'media/widgets', 'widgets');
        }
        if (isset($request->image_path_2)) {
            $media = json_decode($request->image_path_2, 1);
            $files2 = $this->moveFile($media, 'media/widgets', 'widgets');
        }
        
        Widget::whereId($request->id)->update([
            'name' => $request->name,
            'image_path' => isset($files, $files[0]) ? $files[0]->id : $widget->image_path,
            'image_path_2' => isset($files2, $files2[0]) ? $files2[0]->id : $widget->image_path_2,
            'layout' => $request->layout,
        ]);

        if ($widget) {
            foreach ($languages as $language) {
                $widgetDetail = WidgetDetail::whereWidgetId($widget->id)->whereLanguageId($language->id)->exists();
                if ($widgetDetail) {
                    WidgetDetail::whereWidgetId($widget->id)->whereLanguageId($language->id)->update([
                        'text_detail' => $request['text_detail']['text_detail_' . $language->id],
                        'button_text' => $request['button_text']['button_text_' . $language->id],
                        'button_link' => $request['button_link']['button_link_' . $language->id],
                        'action' => $request['action']['action_' . $language->id],
                    ]);
                } else {
                    WidgetDetail::create([
                        'Widget_id' => $widget->id,
                        'language_id' => $language->id,
                        'text_detail' => $request['text_detail']['text_detail_' . $language->id],
                        'button_text' => $request['button_text']['button_text_' . $language->id],
                        'button_link' => $request['button_link']['button_link_' . $language->id],
                        'action' => $request['action']['action_' . $language->id],
                    ]);
                }
            }
            return $this->apiSuccessResponse(new WidgetResource($widget), 'Widget has been updated successfully.');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, Widget $widget)
    {
        if ($widget->delete()) {
            return $this->apiSuccessResponse(new WidgetResource($widget), 'Widget has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($widgets)
    {
        $defaultLang = getDefaultLanguage();
        $widgets = $widgets->with(['widgetDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withWidgetDetail']) && $_GET['withWidgetDetail'] == '1') {
            $widgets = $widgets->with('widgetDetail');
        }

        if (isset($_GET['withMedia']) && $_GET['withMedia'] == '1') {
            $widgets = $widgets->with('media');
        }

        if (isset($_GET['withMedia2']) && $_GET['withMedia2'] == '1') {
            $widgets = $widgets->with('media2');
        }
        return $widgets;
    }

    protected function sortingAndLimit($widgets)
    {
        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $widgets->orderBy('name', 'asc')->get();
        }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'native_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $widgets = $widgets->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $widgets->paginate($limit);
    }

    protected function whereClause($widgets)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $widgets = $widgets->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('short_code', 'LIKE', '%' . $_GET['searchParam'] . '%');
        }
        return $widgets;
    }
}
