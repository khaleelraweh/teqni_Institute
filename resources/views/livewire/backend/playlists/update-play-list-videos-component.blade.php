<div>
    {{-- Intended Learnerss --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-start">
            <div>
                <h6>{{ __('panel.playlist_video_tip') }}</h6>

                <!-- Display validation errors -->
                @if ($errors->has('videoLinks'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->get('videoLinks') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div>
                @if ($videoLinksValid || ($formSubmitted && !$errors->any()))
                    <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                @endif
            </div>
        </div>

        <div class="card-body">

            <table class="table" id="products_table">
                <tbody>
                    @foreach ($videoLinks as $index => $intended)
                        <tr>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="videoLinks[{{ $index }}][link]"
                                        class="form-control" wire:model="videoLinks.{{ $index }}.link"
                                        placeholder="{{ __('panel.playlist_video_add_your_video_link_here') }}" />
                                    <span class="input-group-text">{{ 160 - strlen($videoLinks[$index]['link']) }}
                                    </span>
                                </div>


                                <!-- Display validation error for current intended -->
                                @error('videoLinks.' . $index . '.link')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </td>
                            <td>
                                <a href="#"
                                    wire:click.prevent="removeVideoLink({{ $index }})">{{ __('panel.delete') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-sm btn-secondary" wire:click.prevent="addVideoLink">
                        + {{ __('panel.playlist_video_add_new_video_link') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
