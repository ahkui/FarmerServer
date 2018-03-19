@extends('layouts.app') @section('content')
<div id="map"></div>
<button class="rounded-circle" type="button" onclick="window.addCustomMarker()" style="transform: translateX(-50%);position: fixed;left: 40%;right: 1rem;bottom: 1rem;z-index: 9999;">
    <i class="fas fa-plus"></i>
</button>
<button class="rounded-circle" type="button" onclick="window.showFilterBox()" style="transform: translateX(-50%);position: fixed;left:60%;right: 1rem;bottom: 1rem;z-index: 9999;">
    <i class="fas fa-search"></i>
</button>
<div id="filter-box"><div class="rounded"></div></div>
@endsection