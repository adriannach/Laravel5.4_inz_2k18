@forelse ($tutorials as $tutorial)

  <div class="col-xs-12 col-md-6 col-lg-3 mb-3">
    <div class="card t">
      <a href="{{URL::to('/')}}/tutorial/{{ $tutorial->id }}">

        <img class="card-img-top " src="{{ asset('uploads/banners/'. $tutorial->bannerM) }}" alt="Tutorial Image">

      </a>
      <div class="card-body pt-3 pb-0">
        <h5 class="card-title text-center"><p>{{ str_limit($tutorial->title, $limit=40) }}</p></h5>
      </div>
    </div>
  </div>

@empty
<div class="col-md-12 px-0">
  <h1 class="font-weight-bold display-4 text-center">Brak poradników</h1>
</div>
@endforelse
{{ $tutorials->appends(Request::only('search'))->links() }}
