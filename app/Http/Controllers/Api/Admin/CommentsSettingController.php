<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CommentsSettingResource;
use App\Models\CommentsSetting;
use App\Traits\StatusResponser;

class CommentsSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $commentsSetting = CommentsSetting::query();

        if (isset($_GET['withCommentsSettingDetail']) && $_GET['withCommentsSettingDetail'] == '1') {
            $commentsSetting = $commentsSetting->with('commentsSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $commentsSetting = $commentsSetting->wherePageId($_GET['findByPageId']);
        }

        $commentsSetting = $commentsSetting->firstOrFail();

        return $this->successResponse(new CommentsSettingResource($commentsSetting), 'Data get successfully.');
    }
}
