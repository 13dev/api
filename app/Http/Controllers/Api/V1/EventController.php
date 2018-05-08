<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Transformers\EventTransformer;
use App\Models\User;
use App\Models\Destiny;

class EventController extends BaseController
{
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function index()
    {
        $events = $this->event->paginate();

        // Foreach event
        $events->map(function ($event) {
            $user =  User::find($event->user_id);

            //Add user
            if ($user) {
              $event['user'] = $user;
            }
            return $event;
        });

        return $this->response->paginator($events, new EventTransformer());
    }

    public function show($id)
    {
        $event = $this->event->where('id', $id)->first();
        return $this->response->item($event, new EventTransformer());
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->input(), [
            'destiny_id' => 'required|exists:destiny,id',
            'title' => 'required|string',
            'desc' => 'required|string',
            'rating' => 'required|in:0,0.5,1,1.5,2,2.5,3,3.5,4,4.5,5',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $attributes = $request->only('title', 'desc', 'rating', 'destiny_id');
        $attributes['user_id'] = User::find($this->user()->id)->id;

        $event = $this->event->create($attributes);

        // Return 201 plus data
        return $this->response
            ->item($event, new EventTransformer())
            ->setStatusCode(201);
    }

    public function update($id,Request $request)
    {
        $event = $this->event->findOrFail($id);

        if ($this->user()->role == 'user' ) {
            if ($event->user_id != $this->user()->id) {
                return $this->response->error('403 forbidden. Only owner can modify this post.', 403);
            }
        }

        $validator = \Validator::make($request->input(), [
            'destiny_id' => 'required|exists:destiny,id',
            'title' => 'required|string',
            'desc' => 'required|string',
            'rating' => 'required|in:0,0.5,1,1.5,2,2.5,3,3.5,4,4.5,5',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $event->updated_at = \Carbon\Carbon::now();
        $event->title = $request->get('title');
        $event->desc = $request->get('desc');
        $event->destiny_id = $request->get('destiny_id');
        $event->rating = $request->get('rating');
        $event->save();

        return $this->response->item($event, new EventTransformer());
    }
}
