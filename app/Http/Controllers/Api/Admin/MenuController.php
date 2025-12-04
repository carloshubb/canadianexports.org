<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\MenuResource;
use App\Models\Menu;
use App\Models\MenuDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    use StatusResponser;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $menus = Menu::query();

        $menus = $this->whereClause($menus);
        $menus = $this->loadRelations($menus);
        $menus = $this->sortingAndLimit($menus);

        return $this->apiSuccessResponse(MenuResource::collection($menus), 'Data Get Successfully!');
    }


    public function show(Menu $menu)
    {
        if (isset($_GET['withMenuDetail']) && $_GET['withMenuDetail'] == '1') {
            $menu = $menu->loadMissing('menuDetail');
        }

        return $this->apiSuccessResponse(new MenuResource($menu), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => ["required", "string", "max:255"],
            "is_main_menu" => ["required", "boolean"],
            "is_footer_menu" => ["required", "boolean"],
        ]);
        $menu = Menu::create([
            'name' => $request->name,
            'is_main_menu' => $request->is_main_menu,
            'is_footer_menu' => $request->is_footer_menu,
        ]);

        if ($menu) {
            if ($request->is_main_menu == 1) {
                $this->removeDefaultMainMenu($menu);
            }
            if ($request->is_footer_menu == 1) {
                $this->removeDefaultFooterMenu($menu);
            }
            return $this->apiSuccessResponse(new MenuResource($menu), 'Menu has been added successfully.');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, Menu $menu)
    {
        $rules = [
            'id' => ['required', 'exists:App\Models\Menu,id'],
            "name" => ["required", "string", "max:255"],
            "is_main_menu" => ["required", "boolean"],
            "is_footer_menu" => ["required", "boolean"],
        ];
        $this->validate($request, $rules);
        $result = Menu::whereId($request->id)->update([
            'name' => $request->name,
            'is_main_menu' => $request->is_main_menu,
            'is_footer_menu' => $request->is_footer_menu,
        ]);

        if ($result) {
            if ($request->is_main_menu == 1) {
                $this->removeDefaultMainMenu($menu);
            }
            if ($request->is_footer_menu == 1) {
                $this->removeDefaultFooterMenu($menu);
            }
            return $this->apiSuccessResponse(new MenuResource($menu), 'Menu has been updated successfully.');
        }
        return $this->errorResponse();
    }


    // public function destroy(Request $request, Menu $menu)
    // {
    //     if ($menu->menuDetail()->delete() && $menu->delete()) {
    //         return $this->apiSuccessResponse(new MenuResource($menu), 'Menu has been deleted successfully.');
    //     }
    //     return $this->errorResponse();
    // }

    public function destroy(Request $request, Menu $menu)
    {
        try {
            // Delete menu details first
            $menuDetailsDeleted = $menu->menuDetail()->delete();

            // Delete the menu itself
            $menuDeleted = $menu->delete();

            if ($menuDetailsDeleted && $menuDeleted) {
                return $this->apiSuccessResponse(new MenuResource($menu), 'Menu has been deleted successfully.');
            }

            // Ensure a consistent error message if deletion fails
            return $this->errorResponse('Menu deleted successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong, please try again.');
        }
    }

    protected function removeDefaultMainMenu($menu)
    {
        Menu::where('id', '!=', $menu->id)->update([
            'is_main_menu' => 0
        ]);
    }

    protected function removeDefaultFooterMenu($menu)
    {
        Menu::where('id', '!=', $menu->id)->update([
            'is_footer_menu' => 0
        ]);
    }

    protected function loadRelations($menus)
    {
        $defaultLang = getDefaultLanguage();
        $menus = $menus->with(['menuDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withMenuDetail']) && $_GET['withMenuDetail'] == '1') {
            $menus = $menus->with('menuDetail');
        }
        return $menus;
    }

    protected function sortingAndLimit($menus)
    {

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'is_main_menu', 'is_footer_menu'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $menus = $menus->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $menus->get();
        }

        return $menus->paginate($limit);
    }

    protected function whereClause($menus)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $menus = $menus->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
        }
        return $menus;
    }

    public function updateMenuBuilder(Request $request, $menuId)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if($language->is_default == '1'){
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['menu_' . $language->id => [$requiredVal, 'array']]);
            $errorMessages = array_merge($errorMessages, ['menu_' . $language->id . '.required' => 'Menu in ' . $language->name . ' is required.']);
            $errorMessages = array_merge($errorMessages, ['menu_' . $language->id . '.array' => 'Menu in ' . $language->name . ' must be an array.']);
            $errorMessages = array_merge($errorMessages, ['menu_' . $language->id . '.min' => 'Menu in ' . $language->name . ' must have atleast one item.']);
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        foreach ($languages as $language) {
            $menuDetail = MenuDetail::whereMenuId($menuId)->whereLanguageId($language->id)->exists();
            if ($menuDetail) {
                MenuDetail::whereMenuId($menuId)->whereLanguageId($language->id)->update([
                    'menu_items' => $request['menu_' . $language->id],
                ]);
            } else {
                MenuDetail::create([
                    'menu_id' => $menuId,
                    'language_id' => $language->id,
                    'menu_items' => json_encode($request['menu_' . $language->id]),
                ]);
            }
        }
        return $this->successResponse([], 'Menu has been updated successfully.');
    }
}
