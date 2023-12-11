@extends('layouts.app')

@section('content')
@include('admin.houses.partials.form', ["title" => "Add New House","essential" => "*", "route" =>
'admin.houses.store', 'idForm'=>'create-form', 'methodRoute' => 'POST', 'btnClass' => 'create-btn'])
@endsection


@section('scripts')
<script>

</script>
@endsection