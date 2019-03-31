@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <transactions-recent ref="transactionsRecentIn" widget-type="in">
                <h4>Recent Revenue</h4>
            </transactions-recent>
        </div>

        <div class="col-lg-6">
            <transactions-recent ref="transactionsRecentOut" widget-type="out">
                <h4>Recent Expenses</h4>
            </transactions-recent>
        </div>
    </div>
@endsection
