<!DOCTYPE html>
<html>
<head>
    <title>Input Data</title>
</head>
<body>
    <h1>Input Data</h1>

    <form method="POST" action="{{ route('store') }}">
        @csrf
        <label for="data">Masukkan Data Diri : </label><br>
        <input type="text" id="data" name="data"><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
