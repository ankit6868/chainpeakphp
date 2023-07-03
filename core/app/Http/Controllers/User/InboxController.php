<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Inbox;
use App\Models\Message;
use App\Models\User;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function list()
    {
        $pageTitle = 'Inbox List';
        $inboxes   = Inbox::where('sender_id' , auth()->id())->orWhere('receiver_id', auth()->id())->latest()->with(['sender', 'receiver'])->paginate(getPaginate());
        return view($this->activeTemplate.'user.inbox.index', compact('pageTitle', 'inboxes'));
    }

    public function messages($uniqueId)
    {
        $inbox     = Inbox::where('unique_id', $uniqueId)->where(function ($q) {
                        $q->where('sender_id', auth()->id())->orWhere('receiver_id', auth()->id());
                    })->firstOrFail();
        $messages  = Message::where('inbox_id', $inbox->id)->with(['sender', 'receiver'])->get();
        $pageTitle = "Inbox id - $inbox->unique_id";
        return view($this->activeTemplate.'user.inbox.messages', compact('pageTitle', 'inbox', 'messages'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required',
            'subject'     => 'required|max:40',
            'message'     => 'required'
        ]);

        $receiver = User::where('id', decrypt($request->receiver_id))->firstOrFail();
        $senderId = auth()->id();

        if ($receiver->id == $senderId) {
            $notify[] = ['error', 'This is your own product or profile'];
            return back()->withNotify($notify);
        }

        $checkInbox = Inbox::where(function ($qOne) use ($senderId) {
                        $qOne->where('sender_id', $senderId)->orWhere('receiver_id', $senderId);
                    })->where(function ($qTwo) use ($receiver) {
                        $qTwo->where('sender_id', $receiver->id)->orWhere('receiver_id', $receiver->id);
                    })->first();

        if (Inbox::where('receiver_id',$receiver->id)->exists()) {
            $notify[] = ['info', 'You already have a conversation with this profile.'];
            return to_route('user.inbox.list')->withNotify($notify);
        }

        $inbox              = new Inbox();
        $inbox->unique_id   = getTrx();
        $inbox->subject     = $request->subject;
        $inbox->sender_id   = $senderId;
        $inbox->receiver_id = $receiver->id;
        $inbox->save();

        $message              = new Message();
        $message->inbox_id    = $inbox->id;
        $message->sender_id   = $senderId;
        $message->receiver_id = $receiver->id;
        $message->message     = $request->message;
        $message->save();

        $notify[] = ['success', 'Your response is taken successfully'];
        return back()->withNotify($notify);
    }

    public function store(Request $request)
    {
        $request->validate([
            'unique_id'   => 'required',
            'receiver_id' => 'required',
            'message'     => 'required_without:file',
            'file'        => ['nullable', new FileTypeValidate(['jpg', 'jpeg', 'png', 'pdf']), 'max:2000'],
        ],[
            'message.required_without' => "The message filed is required"
        ]);

        $receiver = User::where('id', decrypt($request->receiver_id))->firstOrFail();
        $senderId = auth()->id();
        $file     = null;

        if ($receiver->id == $senderId) {
            $notify[] = ['error', 'This is your own product or profile'];
            return back()->withNotify($notify);
        }

        $inbox = Inbox::where('unique_id', $request->unique_id)->where(function ($q) {
                    $q->where('sender_id', auth()->id())->orWhere('receiver_id', auth()->id());
                })->firstOrFail();

        if ($request->hasFile('file')) {
            $file = fileUploader($request->file, getFilePath('messageFile'));
        }

        $message              = new Message();
        $message->inbox_id    = $inbox->id;
        $message->sender_id   = $senderId;
        $message->receiver_id = $receiver->id;
        $message->message     = $request->message;
        $message->file        = $file;
        $message->save();

        $notify[] = ['success', 'Your response is taken successfully'];
        return back()->withNotify($notify);
    }
}
