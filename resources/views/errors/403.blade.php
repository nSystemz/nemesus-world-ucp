@extends('errors::minimal')

@section('title', __('Unerlaubte Aktion'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Unerlaubte Aktion'))
