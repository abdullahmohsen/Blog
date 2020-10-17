<?php

namespace App\Listeners;

use App\Events\VideoViewer;
use App\Models\Video;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncreaseCounter
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(VideoViewer $event)
    {
        //lw el session mafhosh el key ely esmo videoIsVisited e3ml update ll counter
        if (!session() -> has('videoIsVisited'))
        {
            $this->updateViewer($event->video);
        }
        else
        {
            return false;
        }
    }

    function updateViewer($video)
    {
        $video->viewers = $video->viewers + 1;
        $video->save();

        // bakhzn id el video bet3 el user fel session
        session()->put('videoIsVisited', $video -> id);
    }
}
