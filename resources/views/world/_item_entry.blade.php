<div class="row world-entry">
    @if($imageUrl)
        <div class="col-md-3 world-entry-image"><a href="{{ $imageUrl }}" data-lightbox="entry" data-title="{{ $name }}"><img src="{{ $imageUrl }}" class="world-entry-image" /></a></div>
    @endif
    <div class="{{ $imageUrl ? 'col-md-9' : 'col-12' }}">
        <h3>{!! $name !!} @if(isset($searchUrl) && $searchUrl) <a href="{{ $searchUrl }}" class="world-entry-search text-muted"><i class="fas fa-search"></i></a>  @endif</h3>
        <div class="row">
            @if(isset($item->category) && $item->category)
                <div class="col">
                    <p><strong>Category:</strong> {!! $item->category->name !!}</p>
                </div>
            @endif
            @if(isset($item->data['rarity']) && $item->data['rarity'])
                <div class="col">
                    <p><strong>Rarity:</strong> {!! $item->data['rarity'] !!}</p>
                </div>
            @endif
            @if(isset($item->artist) && $item->artist)
                <div class="col">
                    <p><strong>Artist:</strong> {!! $item->artist !!}</p>
                </div>
            @endif
            <div class="col-md-6 col-md">
                <p></p>
            </div>
        </div>
        <div class="world-entry-text">
            @if(isset($item->reference_url) && $item->reference_url)  <p><strong>Reference Link:</strong> <a href="{{ $item->reference_url }}">{{ $item->reference_url }}</a></p> @endif
            {!! $description !!}
            @if(isset($item->data['uses']) && $item->data['uses'] || isset($item->data['release']) && $item->data['release'] || isset($item->data['shops']) && $item->data['shops'] || isset($item->data['prompts']) && $item->data['prompts'])
            <div class="text-right"><a data-toggle="collapse" href="#item-{{ $item->id }}" class="text-primary"><strong>Show details...</strong></a></div>
            <div class="collapse" id="item-{{ $item->id }}">
                @if(isset($item->data['uses']) && $item->data['uses'])  <p><strong>Uses:</strong> {{ $item->data['uses'] }}</p> @endif
                @if(isset($item->data['release']) && $item->data['release'] || isset($item->data['shops']) && $item->data['shops'] || isset($item->data['prompts']) && $item->data['prompts'])
                <h5>Availability</h5>
                <div class="row">
                    @if(isset($item->data['release']) && $item->data['release'])
                        <div class="col">
                            <p><strong>Original Source:</strong></p> 
                            <p>{!! $item->data['release'] !!}</p>
                        </div>
                    @endif
                    @if(isset($item->data['shops']) && $item->data['shops'])
                        <div class="col">
                            <p><strong>Purchaseable At:</strong></p>
                                <div class="row">
                                    @foreach($item->shops as $shop) <div class="col"><a href="{{ $shop->url }}">{{ $shop->name }}</a></div> @endforeach
                                </div>
                        </div>
                    @endif
                    @if(isset($item->data['prompts']) && $item->data['prompts'])
                        <div class="col">
                            <p><strong>Drops From:</strong></p>
                                <div class="row">
                                    @foreach($item->prompts as $prompt) <div class="col"><a href="{{ $prompt->url }}">{{ $prompt->name }}</a></div> @endforeach
                                </div>
                        </div>
                    @endif
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>