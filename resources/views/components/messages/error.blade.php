<div>
  @if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissible">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
</div>
