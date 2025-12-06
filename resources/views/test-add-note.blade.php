<!DOCTYPE html>
<html>
<head>
    <title>Add Note</title>
</head>
<body>

    <h1>Add Note to Group</h1>

    <form method="POST" action="/groups/1/add-note">
        @csrf
        
        <label for="note">Note:</label><br>
        <textarea name="note" id="note" rows="4" style="width:400px;"></textarea>
        <br><br>

        <button type="submit">Add Note</button>
    </form>

</body>
</html>