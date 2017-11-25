<form method="post">
    {{ csrf_field() }}
    <input type="text" name="apikey">
    <input type="submit" value="Save">
</form>
<table style="text-align: center">
    <thead>
        <tr>
            <td>api key</td>
            <td>used count</td>
        </tr>
    </thead>
    <tbody>
@foreach ($records as $record)
<tr>
    <td>{{$record->apikey}}</td>
    <td>{{$record->used_count}}</td>
</tr>
@endforeach        
    </tbody>
</table>
