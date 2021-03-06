@extends('admin.index')

@section('title', __('Edit country') . ' - ' . __('Admin') . ' -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <form class="form-horizontal" method="POST" action="{{ route( 'admin.countries.update', [ 'country' => $country->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

						@component('admin.form.input')
							@slot('field', 'code')

							@slot('value', $country->code)

							@slot('label', 'Code')

							@slot('attributes')
								required autofocus
							@endslot
						@endcomponent

						@component('admin.form.input')
							@slot('field', 'name')

							@slot('value', $country->name)

							@slot('label', 'Name')

							@slot('attributes')
								required
							@endslot
						@endcomponent

						@component('admin.form.submit')
							@slot('cancel', route('admin.countries.index'))

							Edit country
						@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
