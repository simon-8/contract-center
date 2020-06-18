<?php
/**
 * Note: 站内信管理
 * User: Liu
 * Date: 2019/11/21
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Message;
use App\Http\Requests\MessageRequest;
use App\Services\ModelService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * 列表页
     * @param Request $request
     * @param Message $message
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = $request->all();

        $lists = Message::ofFieldLike('title', $request->title)
            ->ofFieldNumeric('is_read', $request->is_read)
            ->ofFieldNumeric('to_userid', $request->to_userid)
            ->orderByDesc('id')
            ->paginate()
            ->appends($data);

        return view('admin.message.index', compact('lists','data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.message.create');
    }

    /**
     * 新增
     * @param MessageRequest $request
     * @param Message $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MessageRequest $request, Message $message)
    {
        $data = $request->all();
        $request->validateCreate($data);

        if (!$message->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('admin.message.index')->with('message' , __('web.success'));
    }

    /**
     * 编辑
     * @param Message $message
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Message $message)
    {
        return view('admin.message.create', compact('message'));
    }

    /**
     * 更新
     * @param MessageRequest $request
     * @param Message $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MessageRequest $request, Message $message)
    {
        $data = $request->all();
        $request->validateUpdate($data);

        if (!$message->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('admin.message.index')->with('message', __('web.success'));
    }

    /**
     * 删除
     * @param Message $message
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Message $message)
    {
        if (!$message->delete()) {
            return back()->withErrors(__('web.failed'));
        }
        return redirect()->route('admin.message.index')->with('message', __('web.success'));
    }
}
