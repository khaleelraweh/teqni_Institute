<?php

namespace App\Http\Livewire\Backend\Playlists;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CreatePlayListVideosComponent extends Component
{

    use LivewireAlert;
    public $videoLinks = [];

    public $formSubmitted = false;
    public $databaseDataValid = false;

    public $videoLinksValid = false;

    public function mount()
    {
        $this->videoLinks = [
            ['link' => ''],
        ];
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
        return view('livewire.backend.playlists.create-play-list-videos-component');
    }
}
