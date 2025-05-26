<div class="search-output mt-4">
    @if($menuItems->count() || $offers->count() || $categories->count())
        <h5 class="mb-3">Search results for: <strong>{{ $query }}</strong></h5>

        {{-- Categories --}}
        @if($categories->count())
            <h6 class="text-warning mt-4 mb-3">Categories</h6>
            <div class="row g-3">
                @foreach($categories as $cat)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-warning">
                            <div class="card-body">
                                <h5 class="card-title">{{ $cat->name }}</h5>
                                <p class="card-text text-muted">{{ $cat->name_ar }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Offers --}}
        @if($offers->count())
            <h6 class="text-success mt-4 mb-3">Offers</h6>
            <div class="row g-3">
                @foreach($offers as $offer)
                    <div class="col-md-4">
                        <div class="card h-100 product-card">
                            <img src="{{ asset('storage/' . $offer->image) }}" class="card-img-top" alt="{{ $offer->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $offer->name }}</h5>
                                <p class="card-text">{{ Str::limit($offer->description, 80) }}</p>
                                <p class="text-warning fw-bold">{{ $offer->price }} JOD</p>
                                <a href="#" class="btn btn-warning btn-sm">Order Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Menu Items --}}
        @if($menuItems->count())
            <h6 class="text-info mt-4 mb-3">Menu Items</h6>
            <ul class="list-group">
                @foreach($menuItems as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ url('/menu#item-' . $item->id) }}" class="text-decoration-none">
                            {{ $item->name }}
                        </a>
                        <span class="badge bg-warning text-dark">{{ $item->price }} JOD</span>
                    </li>
                @endforeach
            </ul>
        @endif
    @else
        <p class="text-muted">No matching results found.</p>
    @endif
</div>
