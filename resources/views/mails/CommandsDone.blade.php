@component('mail::message')
# Command 

Good Day Mr/Mrs {{$client}},<br>
you have passed a mocha coffe command.<br>

<br>
  <div>
    @foreach ($command as $item)
      {{$item['product']['name']}} X {{$item['command']['quantity']}}<br>
    @endforeach
  </div>
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent



