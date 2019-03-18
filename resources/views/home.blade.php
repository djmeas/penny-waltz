@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <transactions-recent ref="transactionsRecentIn" widgetType="in">
                Recent Money-In
            </transactions-recent>
        </div>

        <div class="col-lg-6">
            <transactions-recent ref="transactionsRecentOut" widgetType="out">
                Recent Money-Out
            </transactions-recent>
        </div>
    </div>
@endsection
