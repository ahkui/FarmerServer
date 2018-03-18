@extends('layouts.app') @section('content')
<div id="map"></div>
<button class="rounded-circle" type="button" onclick="window.addCustomMarker()" style="position: fixed;left:40%;right: 1rem;bottom: 1rem;z-index: 9999;">＋</button>
<button class="rounded-circle" type="button" onclick="window.addCustomMarker()" style="position: fixed;left:40%;right: 1rem;bottom: 1rem;z-index: 9999;"><i class="fas fa-search"></i></button>
@endsection