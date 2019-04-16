<h1>Hi, {{ $name }}</h1>
@foreach($detail as $row)
	<p>Name: {{ $row->name }} </p>
	<p>Email: {{ $row->email }}</p>
	<p>Post Title: {{ $row->title }}</p><hr>
@endforeach