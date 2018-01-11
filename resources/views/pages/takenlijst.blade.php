@extends('theme.layout',
    [
        'meta_title' => 'Takenlijst'
    ])

@section('content')

    <div class="takenlijst-container">

        <div class="takenlijst">

            <takentabel :databasetaken="databasetaken" :werknemers="werknemers"></takentabel>

        </div>

        <div class="ledenlijst">

            <ledentabel :werknemers="werknemers"></ledentabel>

        </div>

    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        var databasetaken = {!! json_encode($taken) !!};
        var werknemers = {!! json_encode($werknemers) !!};
    </script>
    <script src="{{ URL::asset('js/bundle.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.12.1/printThis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.ns-autogrow/1.1.6/jquery.ns-autogrow.min.js"></script>
@endsection