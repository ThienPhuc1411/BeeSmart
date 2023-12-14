<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Import Excel</title>
</head>
<body>
    <form action="{{route('import-Excel')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" id="">
        <input type="submit" value="Upload" name="submit">
        <input type="hidden" name="idCh" value="19">
    </form>
</body>
</html>