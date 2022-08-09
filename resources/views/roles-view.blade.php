<!DOCTYPE html>
<html>
    <h1>Roles</h1>
    <ul>
        @foreach ($array as $role)
            <li>ID: {{$role['id']}}, Name: {{$role['name']}}</li>
        @endforeach
    </ul>
</html>
