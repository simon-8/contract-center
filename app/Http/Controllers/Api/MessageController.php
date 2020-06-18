<?php
/**
 * Note:
 * User: Liu
 * Date: 2019/7/9
 */
namespace App\Http\Controllers\Api;


use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageController extends BaseController
{
    /**
     * 信息列表
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $lists = Message::select(['id', 'from_userid', 'to_userid', 'title', 'is_read', 'created_at', 'updated_at'])
            ->ofFieldNumeric('to_userid', $this->user->id)
            ->ofFieldNumeric('is_read', $request->is_read)
            ->orderByDesc('id')
            ->paginate();
        return JsonResource::collection($lists);
    }

    /**
     * 详情
     * @param Message $message
     * @return JsonResource
     */
    public function show(Message $message)
    {
        return new JsonResource($message);
    }

    /**
     * 未读数量
     * @return \Illuminate\Http\JsonResponse
     */
    public function unreadCount()
    {
        $count = Message::where('to_userid', $this->user->id)
            ->where('is_read', Message::IS_READ_NO)
            ->count();
        return responseMessage('', $count);
    }

    /**
     * 更新已读状态
     * @param Message $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRead(Message $message)
    {
        $message->is_read = Message::IS_READ_YES;
        $message->save();
        return responseMessage(__('api.success'));
    }
}
