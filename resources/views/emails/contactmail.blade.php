<h3>Kwik Insurances {{ $data['title'] }}</h3>
<h4>Name: {{ $data['name'] }}</h4>
@if(empty($data['age']))
    <h4>Company Name: {{ $data['company_name'] }}</h4>
@endif
<h4>Email: <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></h4>
<h4>Number: <a href="tel:{{ $data['phone'] }}">{{ $data['phone'] }}</a></h4>
@if(empty($data['age']))
    <h4>Comment: {{ $data['message'] }}</h4>
@else
    <h4>Age: {{ $data['age'] }}</h4>
@endif