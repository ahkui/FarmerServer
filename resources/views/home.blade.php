@extends('layouts.app') @section('content')
<div id="map"></div>
<button type="button" onclick="window.clearMarker()" style="position: fixed;right: 0;bottom: 0;z-index: 9999;">remove all</button>
@endsection