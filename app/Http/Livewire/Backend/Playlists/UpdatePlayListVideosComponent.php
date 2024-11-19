<?php

namespace App\Http\Livewire\Backend\Playlists;

use App\Models\Playlist;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class UpdatePlayListVideosComponent extends Component
{

    use LivewireAlert;

    public $playlistId;

    public $videoLinks = [];

    public $formSubmitted = false;
    public $databaseDataValid = false;

    public $videoLinksValid = false;

    public function mount($playlistId)
    {
        $this->playlistId = $playlistId;
        $playlist = Playlist::where('id', $this->playlistId)->first();

        // Initialize videoLinks
        if ($playlist->videoLinks != null && $playlist->videoLinks->isNotEmpty()) {
            foreach ($playlist->videoLinks as $item) {
                $this->videoLinks[] = ['link' => $item->link];
            }
        } else {
            $this->videoLinks = [
                ['link' => ''],
            ];
        }
    }

    //add videoLink
    public function addVideoLink()
    {
        $this->videoLinks[] = ['link' => ''];
    }

    // remove videoLink
    public function removeVideoLink($index)
    {
        unset($this->videoLinks[$index]);
        $this->videoLinks = array_values($this->videoLinks);
    }

    public function render()
    {
        return view('livewire.backend.playlists.update-play-list-videos-component');
    }
}
