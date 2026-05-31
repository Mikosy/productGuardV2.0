@extends('errors.layout')

@section('code', '401')
@section('title', 'Unauthorized')
@section('message', 'We couldn\'t find the batch or page you were looking for. It might have been archived or moved.')
@section('icon')
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
@endsection