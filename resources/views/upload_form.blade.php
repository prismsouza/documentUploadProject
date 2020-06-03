<form action="/upload" enctype="multipart/form-data" method="post">
    {{ csrf_field() }}
    Product photos (can attach more than one): <br>
    <input multiple="multiple" name="photos[]" type="file">
    <br><br>
    <input type="submit" value="Upload">
</form>
